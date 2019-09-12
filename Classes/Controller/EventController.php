<?php
namespace Undkonsorten\Eventmgmt\Controller;

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
use TYPO3\CMS\Core\Resource\ExceptionInsufficientUserPermissionsException;
use Undkonsorten\Eventmgmt\Domain\Model\Year;
use TYPO3\CMS\Beuser\Domain\Model\Demand;
use Undkonsorten\Eventmgmt\Datastructures\LocationHeap;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class EventController extends \Undkonsorten\Eventmgmt\Controller\BaseController {


	/**
	 * configuration manager
	 *
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $configurationManager;

	/**
	 * eventRepository
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Repository\EventRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $eventRepository;

	/**
	 * addressRepository
	 *
	 * @var \Undkonsorten\Addressmgmt\Domain\Repository\AddressRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $addressRepository;

	/**
	 * categoryRepository
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $categoryRepository;

	/**
	 * categoryService
	 *
	 * @var \Undkonsorten\Eventmgmt\Utility\CategoryService
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $categoryService;

	/**
	 * userRepository
	 *
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $userRepository;

	/**
	 * location Repository
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Repository\LocationRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $locationRepository;

	/**
	 *
	 * @var \Undkonsorten\Eventmgmt\Utility\DemandUtility
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $demandUtility;

	/**
	 *
	 * @var \Undkonsorten\Eventmgmt\Utility\EventLocations
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $eventLocations;



	/**
	 * Constructor
	 */
	protected function initializeAction()
    {
        $this->overrideFlexformSettings();

        if (!$this->settings['showPaginator']) {
            $this->settings['limit'] = $this->settings['itemsPerPage'];
        }
        if ($this->settings['itemsPerPage'] == '') {
            $this->settings['itemsPerPage'] = PHP_INT_MAX;
        }
        $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
        $this->settings['feUserAsRelation'] = $extConf['feUserAsRelation'];

        if ($this->arguments->hasArgument('demand')) {
			$propertyMappingConfiguration = $this->arguments['demand']->getPropertyMappingConfiguration();
			$propertyMappingConfiguration->allowProperties('regions');
			$propertyMappingConfiguration->allowProperties('subject');
			$propertyMappingConfiguration->allowProperties('topics');
			$propertyMappingConfiguration->allowProperties('types');
			$propertyMappingConfiguration->allowProperties('location');
			$propertyMappingConfiguration->allowProperties('timeslot');
			$propertyMappingConfiguration->allowProperties('listMode');
			$propertyMappingConfiguration->allowProperties('archiveDate');
			$propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true);
            $propertyMappingConfiguration->forProperty('startDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
            $propertyMappingConfiguration->forProperty('endDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d');
        }

	}



	public function exportPreviewAction(){
	    $demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
	    $events = $this->eventRepository->findDemanded($demand);
	    $this->view->assign('events', $events);
	    $this->view->assign('demand', $demand);
	}


	/**
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 */
	public function exportAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL){
	    $demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
	    $events = $this->eventRepository->findDemanded($demand);
	    $this->view->assign('events', $events);
	    $this->response->setHeader('Cache-control', 'public', TRUE);
	    $this->response->setHeader('Content-Description', 'File transfer', TRUE);
	    $this->response->setHeader('Content-Disposition', 'attachment; filename=export.xls', TRUE);
	    $this->response->setHeader('Content-Type', 'application/vnd.ms-excel', TRUE);
	    $this->response->setHeader('Content-Transfer-Encoding', 'binary', TRUE);

	    // As the very last thing, I send the headers to the visitor, before Extbase comes to the part, where it renders a HTML template

	    $this->response->sendHeaders();
	    echo $this->view->render();
	    exit;
	}

	/**
	 * action list
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return void
	 */

	public function listAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {

		$demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$demand->setListMode("upcomming");


		$limit = $this->settings['limit'];

		$allEvents = $this->eventRepository->findDemanded($demand);

		$events = $this->eventRepository->findDemanded($demand, $limit);

		$this->generateSearchForm($events);

		//$this->debugQuery($events);
		$this->view->assign('events', $events);
		$this->view->assign('allEvents', $allEvents->count());
		$this->view->assign('demand', $demand);
	}


	public function listAllAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL){
		$demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$demand->setListMode("listAll");

		$limit = $this->settings['limit'];
		$allEvents = $this->eventRepository->findDemanded($demand);

		$events = $this->eventRepository->findDemanded($demand, $limit);

		if($this->settings['searchBox']){
		    $this->generateSearchForm($allEvents);
		}

		$this->view->assign('events', $events);
		$this->view->assign('allEvents', $allEvents->count());
		$this->view->assign('demand', $demand);
	}

	public function listByCalendarAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL){
		$this->listAction($demand);
	}

	public function listByTimeslotAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL, \Undkonsorten\Eventmgmt\Domain\Model\Timeslot $timeslot = null){
	    $demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);

	    $limit = $this->settings['limit'];
	    $allEvents = $this->eventRepository->findDemanded($demand);
	    $result = $this->eventLocations->getLocationsAndTimeslotsFromEvents($allEvents);
	    $timeslots = $result['timeslots'];

	    if(!is_null($timeslot)){
	        $demand->setTimeslot($timeslot);
	    }

	    if($this->settings['searchBox']){
	        $this->generateSearchForm($allEvents);
	    }

	    $events = $this->eventRepository->findDemanded($demand, $limit);

	    $this->view->assign('timeslots', $timeslots);
	    $this->view->assign('events', $events);
	    $this->view->assign('demand', $demand);
	}

	public function listBySpeakerAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL){
	    $feuser = $this->getLoggedInFrontendUser();
	    if(is_null($feuser)){
	        //@FIXME
	    }
	    if(is_null($demand)){
			$demand = $this->objectManager->get('Undkonsorten\Eventmgmt\Domain\Model\EventDemand');
		}

		$extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
		if($extConf['feUserAsRelation'] != 1){
		    $demand->setSpeaker($this->addressRepository->findByFeUser($feuser)->getFirst());
		}elseif($extConf['feUserAsRelation'] == 1){
		    $demand->setSpeaker($feuser);
		}


	    $this->listAction($demand);
	}

	/**
	 * action shortList
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return void
	 */
	public function shortListAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {
		$limit = $this->settings['itemsPerPage'];
		$demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$demand->setListMode("upcomming");
		$allEvents = $this->eventRepository->findDemanded($demand);

		$events = $this->eventRepository->findDemanded($demand, $limit);
		$this->view->assign('events', $events);
		$this->view->assign('allEvents', $allEvents->count());
	}

	/**
	 * action archiveList
	 *
	 * @return void
	 */
	public function archiveAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {
		$demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$demand->setListMode("archive");

		$limit = $this->settings['limit'];

		$allEvents = $this->eventRepository->findDemanded($demand);

		$years = $this->generateYears();

		$events = $this->eventRepository->findDemanded($demand, $limit);

        if($this->settings['searchBox']){
            $this->generateSearchForm($allEvents);
        }

		$this->view->assign('archiveDate', $years);
		$this->view->assign('events', $events);
		$this->view->assign('allEvents', $allEvents->count());
	}

	/**
	 * action search
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return void
	 */
	public function searchAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {
	    $demand=$this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$limit = $this->settings['limit'];
		$demanded = $this->eventRepository->findDemanded($demand, $limit);
		$this->generateSearchForm($demanded);
		$this->view->assign('demanded', $demanded);
		$this->view->assign('demand', $demand);
	}


	/**
	 * action archiveList
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return void
	 */
	public function archiveSearchAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {
		$demand=$this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$demand->setListMode("archive");
		$limit = $this->settings['limit'];

		$demanded = $this->eventRepository->findDemanded($demand, $limit);

		$allCategories = $this->categoryRepository->findAll();

        $this->generateSearchForm($demanded);

		$years = $this->generateYears();

		$this->view->assign('demanded', $demanded);
		$this->view->assign('archiveDate', $years);
		$this->view->assign('demand', $demand);
	}

	/**
	 * action show
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Event $event
	 * @return void
	 */
	public function showAction(\Undkonsorten\Eventmgmt\Domain\Model\Event $event) {
		$this->view->assign('event', $event);
	}


	/**
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Event $event
	 * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientUserPermissionsException
	 */
	public function editAction(\Undkonsorten\Eventmgmt\Domain\Model\Event $event){
	    $user = $this->getLoggedInFrontendUser();

	    /*
	     * $user is FrontendUser but speaker can be different types
	     * so we check on uid here
	     */
	    $check = false;
	    foreach($event->getSpeaker() as $speaker){
	        $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	        if($extConf['feUserAsRelation'] != 1){
	            if($speaker->getFeUser()->getUid() == $user->getUid()){
    	            $check = true;
    	        }
	        }elseif($extConf['feUserAsRelation'] == 1){
    	        if($speaker->getUid() == $user->getUid()){
    	            $check = true;
    	        }
	        }
	    }

	    if(!$check){
	        throw new \TYPO3\CMS\Core\Resource\Exception\InsufficientUserPermissionsException('You are not allowed to edit this event',1455541189);
	    }

	    $this->view->assign('event', $event);
	}

	/**
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Event $event
	 */
	public function updateAction(\Undkonsorten\Eventmgmt\Domain\Model\Event $event){
	    $this->eventRepository->update($event);
	    $this->redirect('show','Event','eventmgmt',array('event' => $event));
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
		$typoScriptSettings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'eventmgmt', 'event_list');
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

	protected function generateYears(){
		$now = (int)date("Y");
		$i = $this->settings['filter']['lastYear'];
		while($i<=$now){
			$year = new Year();
			$year->setYear($i);
			$years[] = $year;
			$i = $i+1;
		}
		return array_reverse($years);
	}

	/**
	 * Return logged in frontend user, if any, NULL otherwise
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected function getLoggedInFrontendUser() {
	    $frontendUser = NULL;
	    $user = $GLOBALS['TSFE']->fe_user->user;
	    if(isset($user['uid'])) {
	        $frontendUser = $this->userRepository->findByUid($user['uid']);
	    }
	    return $frontendUser;
	}

	protected function generateSearchForm(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult  $events = null){
	    if(is_null($events)){
	        $fakeDemand = $this->demandUtility->updateDemandObjectFromSettings(null, $this->settings);
	        $events = $this->eventRepository->findDemanded($fakeDemand, $limit);
	    }
	    if($this->settings['category']['regionUid']){
	        $regionsRoot = $this->categoryRepository->findByUid($this->settings['category']['regionUid']);
	        $regions = $this->categoryService->findAllDescendants($regionsRoot);
	        $this->view->assign('regions', $regions);
	    }

	    if($this->settings['category']['topicUid']){
	        $topicsRoot = $this->categoryRepository->findByUid($this->settings['category']['topicUid']);
	        $topics = $this->categoryService->findAllDescendants($topicsRoot);
	        $this->view->assign('topics', $topics);
	    }

	    if($this->settings['category']['typeUid']){
	        $typesRoot = $this->categoryRepository->findByUid($this->settings['category']['typeUid']);
	        $types = $this->categoryService->findAllDescendants($typesRoot);
	        $this->view->assign('types', $types);
	    }
       $result = $this->eventLocations->getLocationsAndTimeslotsFromEvents($events);
	   $locations = $result['locations'];
	   $timeslots = $result['timeslots'];
	   $this->view->assign('locations', $locations);
	   $this->view->assign('timeslots', $timeslots);

	}






}
?>
