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
	public function listAction() {
		$events = $this->eventRepository->findAll();
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($events);
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
	public function searchAction() {
		$events = $this->eventRepository->findAll();
		$this->view->assign('events', $events);
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
	private function storagePidFallback() {
		$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
	
		//Check if stroage PID is set in plugin
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

}
?>