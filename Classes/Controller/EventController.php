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
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
	 * Constructor
	 */
	protected function initializeAction(){
		$this->storagePidFallback();
	}
	/**
	 * action list
	 *
	 * @return void
	 */
		
	public function listAction(\Undkonsorten\Event\Domain\Model\EventDemand $demand = NULL) {
		$demand = $this->updateDemandObjectFromSettings($demand, $this->settings);
		$limit = $this->settings['limit'];
		
		$allCategories = $this->categoryRepository->findAll();
		
		$regionsRoot = $this->categoryRepository->findByUid($this->settings['category']['displayUid']);
		$regions = $this->findAllDescendants($regionsRoot, $allCategories);
		$regions = array_merge(array(0=>\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_event_domain_model_demand.region.none','event')),$regions->toArray());
		$topicsRoot = $this->categoryRepository->findByUid($this->settings['category']['normalUid']);
		$topics = $this->findAllDescendants($topicsRoot, $allCategories);
		$topics = array_merge(array(0=>\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_event_domain_model_demand.topic.none','event')),$topics->toArray());
		
		
		$events = $this->eventRepository->findDemanded($demand, $limit);
		$this->view->assign('regions', $regions);
		$this->view->assign('topics', $topics);
		$this->view->assign('events', $events);
	}
	
	/**
	 * action shortList
	 *
	 * @return void
	 */
	public function shortListAction() {
		$events = $this->eventRepository->findAll();
		$this->view->assign('events', $events);
	}
	
	/**
	 * action archiveList
	 *
	 * @return void
	 */
	public function archiveAction() {
		$events = $this->eventRepository->findAll();
		$this->view->assign('events', $events);
	}
	
	/**
	 * action archiveList
	 *
	 * @return void
	 */
	public function searchAction(\Undkonsorten\Event\Domain\Model\EventDemand $demand = NULL) {
		$demand=$this->updateDemandObjectFromSettings($demand, $this->settings);
		$limit = $this->settings['limit'];
		$demanded = $this->eventRepository->findDemanded($demand, $limit);
		
		$allCategories = $this->categoryRepository->findAll();
		
		$regionsRoot = $this->categoryRepository->findByUid($this->settings['category']['displayUid']);
		$regions = $this->findAllDescendants($regionsRoot, $allCategories);
		
		$topicsRoot = $this->categoryRepository->findByUid($this->settings['category']['normalUid']);
		$topics = $this->findAllDescendants($topicsRoot, $allCategories);
		$topics = array_merge(array(0=>'-Alle-'),$topics->toArray());
		
		
		$this->view->assign('regions', $regions);
		$this->view->assign('topics', $topics);
		$this->view->assign('demanded', $demanded);
		$this->view->assign('demand', $demand);
	}

	/**
	 * action show
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Event $event
	 * @return void
	 */
	public function showAction(\Undkonsorten\Event\Domain\Model\Event $event) {
		$this->view->assign('event', $event);
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
					$demand->addPrimaryCategory($this->categoryRepository->findByUid($category));
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
					$demand->addSecondaryCategory($this->categoryRepository->findByUid($category));
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
	 * Finds all descendants of an given category
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $parentCategory
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $resultStorage
	 */
	
	protected function findAllDescendants (\TYPO3\CMS\Extbase\Domain\Model\Category $parentCategory, \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query){
		$storage = $this->buildStorageFormQuery($query);
		$resultStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
		$stack = array();	
		array_push($stack, $parentCategory);
		while(count($stack)>0){
			$currentRoot = array_pop($stack);
			foreach($storage as $category){
				if($category->getParent() === $currentRoot){
					$resultStorage->attach($category);
					array_push($stack, $category);
				}
			}
		}
		return $resultStorage;
	}
	
	/**
	 * Builds an object storage form query
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	protected function buildStorageFormQuery (\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query){
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
		foreach($query as $category){
			if($category->getParent()!=NULL) $storage->attach($category);
		}
		return $storage;
	}
	
	
	

}
?>
