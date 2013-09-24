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
	 * @var \Undkonsorten\Event\Domain\Repository\CategoryRepository
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
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings);
		if(is_null($demand)) {
			$demand = $this->createDemandObjectFromSettings($this->settings);
		}
		$limit = $this->settings['limit'];
		$events = $this->eventRepository->findDemanded($demand, $limit);
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
		if (is_null($demand)){
			$demand=$this->objectManager->get('Undkonsorten\Event\Domain\Model\EventDemand');
		}
		$this->updateDemandWithSearchFields($demand);
		if ($this->settings['orderBy']) {
			$demand->setOrder($this->settings['orderBy'] . ' ' . $this->settings['orderDirection']);
		}
		$limit = $this->settings['limit'];
		$demanded = $this->eventRepository->findDemanded($demand, $limit);
		$this->view->assign('demanded', $demanded);#
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
	 * Update demand with current search fields from TS
	 *
	 * @param Undkonsorte\Event\Domain\Model\EventDemand
	 * @return void
	 */
	protected function updateDemandWithSearchFields($demand) {
		$demand->setSearchFields(\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['search']['fields'], TRUE));
	}
	
	/**
	 * Create the demand object which define which records will get shown
	 *
	 * @param array $settings
	 * @return Undkonsorten\Event\Domain\Model\EventDemand
	 */
	protected function createDemandObjectFromSettings($settings) {
		/* @var $demand \Undkonsorten\Event\Domain\Model\EventDemand */
		$demand = $this->objectManager->get('Undkonsorten\Event\Domain\Model\EventDemand');
	
		//@TODO Set filters here
		/*
		 * if($settings['category']) $demand->setCategory($settings['category']);
		*
		*/
		
		//Set primaryCalendar form backend settings
		if($settings['primaryCalendar']['diplayCalendar']!='ignore'&&$settings['primaryCalendar']['calendar']){
			$demand->addPrimaryCalendar($this->calendarRepository->findByUid($settings['primaryCalendar']['calendar']));
		}
		
		/*if($settings['primaryCalendar']['diplayCategory']!='ignore'&&$settings['primaryCalendar']['category']){
			$demand->addPrimaryCategory($this->categoryRepository->findByUid($settings['primaryCalendar']['category']));
		}*/
		
		$this->updateDemandWithSearchFields($demand);
		if ($settings['orderBy']) {
			$demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
		}
		return $demand;
	}

}
?>
