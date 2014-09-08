<?php
namespace Undkonsorten\Event\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Eike Starkmann <starkmann@undkonsorten.com>, undkonsorten
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package event
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use Undkonsorten\Event\Domain\Model\Year;

class CalendarController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	
	/**
	 * configuration manager
	 * 
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;
	
	/**
	 * eventRepository
	 *
	 * @var \Undkonsorten\Event\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository;
	
	/**
	 * calendarRepository
	 *
	 * @var \Undkonsorten\Event\Domain\Repository\CalendarRepository
	 * @inject
	 */
	protected $calendarRepository;
	
	/**
	 * categoryRepository
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;
	
	/**
	 * categoryService
	 *
	 * @var \Undkonsorten\Event\Utility\CategoryService
	 * @inject
	 */
	protected $categoryService;

	/**
	 * Constructor
	 */
	protected function initializeAction(){
		$this->overrideFlexformSettings();
		$this->storagePidFallback();
		
		if(!$this->settings['showPaginator']){
			$this->settings['limit'] = $this->settings['itemsPerPage'];		
		}
	}
	
	/**
	 * action list
	 * @param \Undkonsorten\Event\Domain\Model\EventDemand $demand
	 * @return void
	 */
		
	public function listAction(\Undkonsorten\Event\Domain\Model\EventDemand $demand = NULL) {
		$demand = $this->updateDemandObjectFromSettings($demand, $this->settings);
		
		if($this->settings['primaryCalendar']){
			$calendars = $this->categoryRepository->findByUid($this->settings['primaryCalendar']);
		}else{
			$calendars = $this->calendarRepository->findAll();
		}
		
		$this->view->assign('calendars', $calendars);
	}
	
	/**
	 * StoragePid fallback: Plugin->TS->CurrentPid
	 */
	protected function storagePidFallback() {
		$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
	
		//Check if storage PID is set in plugin
		if($configuration['settings']['storageFolder']){
			$pid['persistence']['storagePid'] = $configuration['settings']['storageFolder'];
			$this->configurationManager->setConfiguration(array_merge($configuration, $pid));
			//Check if storage PID is set in TS
		}elseif($configuration['persistence']['storagePid']){
			$pid['persistence']['storagePid'] = $configuration['persistence']['storagePid'];
			$this->configurationManager->setConfiguration(array_merge($configuration, $pid));
		}else{
			// Use current PID as storage PID
			$pid['persistence']['storagePid'] = $GLOBALS["TSFE"]->id;
			$this->configurationManager->setConfiguration(array_merge($configuration, $pid));
		}
	}
	
	/**
	 * overrides flexform settings with original typoscript values when 
	 * flexform value is empty and settings key is defined in 
	 * 'settings.overrideFlexformSettingsIfEmpty'
	 * 
	 * @return void
	 */
	public function overrideFlexformSettings() {
		$originalSettings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$typoScriptSettings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'event', 'event_list');
		if(isset($typoScriptSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
			$overrideIfEmpty = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $typoScriptSettings['settings']['overrideFlexformSettingsIfEmpty'], TRUE);
			foreach ($overrideIfEmpty as $settingToOverride) {
				// if flexform setting is empty and value is available in TS
				if ((!isset($originalSettings[$settingToOverride]) || empty($originalSettings[$settingToOverride]))
						&& isset($typoScriptSettings['settings'][$settingToOverride])) {
					$originalSettings[$settingToOverride] = $typoScriptSettings['settings'][$settingToOverride];
				}				
			}
			$this->settings = $originalSettings; 
		}
	}
	
	/**
	 * Update demand with current settings, if not exists it creates one
	 *
	 * @param Undkonsorte\Event\Domain\Model\EventDemand
	 * @param array
	 * @return void
	 */
	protected function updateDemandObjectFromSettings($demand , $settings) {
		if(is_null($demand)){
			$demand = $this->objectManager->get('Undkonsorten\Event\Domain\Model\EventDemand');
		}
		
		$demand->setSearchFields(\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $settings['search']['fields'], TRUE));
		
		//Set primaryCalendar form backend settings
		if($settings['primaryCalendar']['displayCalendar']!='ignore'&&$settings['primaryCalendar']['calendar']){
			$demand->setDisplayPrimaryCalendar($settings['primaryCalendar']['displayCalendar']);
			foreach(explode(",", $settings['primaryCalendar']['calendar']) as $calendar){
				$demand->addPrimaryCalendar($this->calendarRepository->findByUid($calendar));
			}
			
			if($settings['primaryCalendar']['displayCategory']!='ignore'&&$settings['primaryCalendar']['category']){
				$demand->setDisplayPrimaryCategory($settings['primaryCalendar']['displayCategory']);
				foreach(explode(",", $settings['primaryCalendar']['category']) as $category){
					//Add current category
					$currentCategory = $this->categoryRepository->findByUid($category);
					$demand->addPrimaryCategory($currentCategory);
					//Add alls descendants of the current category
					$descendants = $this->categoryService->findAllDescendants($currentCategory);
					foreach($descendants as $descendant){
						$demand->addPrimaryCategory($descendant);
					}
				}
			}
		}
		
		if($settings['secondaryCalendar']['displayCalendar']!='ignore'&&$settings['secondaryCalendar']['calendar']){
			$demand->setDisplaySecondaryCalendar($settings['secondaryCalendar']['displayCalendar']);
			foreach(explode(",", $settings['secondaryCalendar']['calendar']) as $calendar){
				$demand->addSecondaryCalendar($this->calendarRepository->findByUid($calendar));
			}
				
			if($settings['secondaryCalendar']['displayCategory']!='ignore'&&$settings['secondaryCalendar']['category']){
				$demand->setDisplaySecondaryCategory($settings['secondaryCalendar']['displayCategory']);
				foreach(explode(",", $settings['secondaryCalendar']['category']) as $category){
					//Add current category
					$currentCategory = $this->categoryRepository->findByUid($category);
					$demand->addSecondaryCategory($currentCategory);
					//Add alls descendants of the current category
					$descendants = $this->categoryService->findAllDescendants($currentCategory);
					foreach($descendants as $descendant){
						$demand->addSecondaryCategory($descendant);
					}
				}
			}
		}
		
		if ($settings['orderBy']) {
			$demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
		}
		if ($settings['storageFolder']) {
			$demand->setStoragePage($settings['storageFolder']);
		}
		return $demand;
	}
	
	/**
	 * Debugs a SQL query from a QueryResult
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult
	 * @param boolean $explainOutput
	 * @return void
	 */
	public function debugQuery(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult, $explainOutput = FALSE){
		$GLOBALS['TYPO3_DB']->debugOuput = 2;
		if($explainOutput){
			$GLOBALS['TYPO3_DB']->explainOutput = true;
		}
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;
		$queryResult->toArray();
		DebuggerUtility::var_dump($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);
	
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = false;
		$GLOBALS['TYPO3_DB']->explainOutput = false;
		$GLOBALS['TYPO3_DB']->debugOuput = false;
	}
	
	
	

}
?>
