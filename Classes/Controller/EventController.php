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

class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	
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
	 * @var \Undkonsorten\Eventmgmt\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository;
	
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
	 * @var \Undkonsorten\Eventmgmt\Utility\CategoryService
	 * @inject
	 */
	protected $categoryService;
	
	/**
	 * userRepository
	 * 
	 * 
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $userRepository;
	
	/**
	 * location Repository
	 * 
	 * @var \Undkonsorten\Eventmgmt\Domain\Repository\LocationRepository
	 * @inject
	 */
	protected $locationRepository;
	
	/**
	 * 
	 * @var \Undkonsorten\Eventmgmt\Utility\DemandUtility
	 * @inject
	 */
	protected $demandUtility;
	
	/**
	 * 
	 * @var \Undkonsorten\Eventmgmt\Utility\EventLocations
	 * @inject
	 */
	protected $eventLocations;
	


	/**
	 * Constructor
	 */
	protected function initializeAction(){
		$this->overrideFlexformSettings();
		$this->storagePidFallback();
		
		if(!$this->settings['showPaginator']){
			$this->settings['limit'] = $this->settings['itemsPerPage'];		
		}
		if($this->settings['itemsPerPage']==''){
			$this->settings['itemsPerPage']=PHP_INT_MAX;
		}
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['eventmgmt']);
		$this->settings['feUserAsRelation'] = $extConf['feUserAsRelation'];
	}
	
	
	protected function initializeSearchAction(){
		$propertyMappingConfiguration = $this->arguments['demand']->getPropertyMappingConfiguration();
		$propertyMappingConfiguration->allowProperties('regions');
		$propertyMappingConfiguration->allowProperties('subject');
		$propertyMappingConfiguration->allowProperties('topics');
		$propertyMappingConfiguration->allowProperties('types');
		$propertyMappingConfiguration->allowProperties('location');
		$propertyMappingConfiguration->allowProperties('timeslot');
		$propertyMappingConfiguration->allowProperties('archiveDate');
		$propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
	}
	
	
	protected function initializeArchiveSearchAction(){
		$propertyMappingConfiguration = $this->arguments['demand']->getPropertyMappingConfiguration();
		$propertyMappingConfiguration->allowProperties('regions');
		$propertyMappingConfiguration->allowProperties('subject');
		$propertyMappingConfiguration->allowProperties('topics');
		$propertyMappingConfiguration->allowProperties('types');
		$propertyMappingConfiguration->allowProperties('location');
		$propertyMappingConfiguration->allowProperties('timeslot');
		$propertyMappingConfiguration->allowProperties('archiveDate');
		$propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
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
		
		$this->generateSearchForm($allEvents);
		
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
    
	    $allEvents = $this->eventRepository->findDemanded($demand);
	    $result = $this->eventLocations->getLocationsAndTimeslotsFromEvents($allEvents);
	    $timeslots = $result['timeslots'];
	    
	    if(!is_null($timeslot)){
	        $demand->setTimeslot($timeslot);
	    }
	    
	    $events = $this->eventRepository->findDemanded($demand, $limit);

	    $this->view->assign('timeslots', $timeslots);
	    $this->view->assign('events', $events);
	    $this->view->assign('demand', $demand);
	}
	
	public function listBySpeakerAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL){
	    $speaker = $this->getLoggedInFrontendUser();
	    if(is_null($speaker)){
	        //@FIXME
	    }
	    if(is_null($demand)){
			$demand = $this->objectManager->get('Undkonsorten\Eventmgmt\Domain\Model\EventDemand');
		}

		$demand->setSpeaker($speaker);
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
		
		$regionsRoot = $this->categoryRepository->findByUid($this->settings['category']['regionUid']);
		if($regionsRoot){
			$regions = $this->categoryService->findAllDescendants($regionsRoot);
		}
		$limit = $this->settings['limit'];
		
		if($limit>0) $allEvents = $this->eventRepository->countDemanded($demand);
		$topicsRoot = $this->categoryRepository->findByUid($this->settings['category']['topicUid']);
		if($topicsRoot){
			$topics = $this->categoryService->findAllDescendants($topicsRoot);
		}
		$years = $this->generateYears();
		
		$events = $this->eventRepository->findDemanded($demand, $limit);
		
		$this->view->assign('regions', $regions);
		$this->view->assign('topics', $topics);
		$this->view->assign('archiveDate', $years);
		$this->view->assign('events', $events);
		$this->view->assign('allEvents', $allEvents);
		$this->view->assign('locations', $this->locationRepository->findAll());
	}
	
	/**
	 * action search
	 *
	 * @dontverifyrequesthash
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return void
	 */
	public function searchAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {
		$demand=$this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$limit = $this->settings['limit'];
		$demanded = $this->eventRepository->findDemanded($demand, $limit);
		
		$this->generateSearchForm();
		
		$this->view->assign('demanded', $demanded);
		$this->view->assign('demand', $demand);
	}
	
	
	/**
	 * action archiveList
	 * @dontverifyrequesthash
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return void
	 */
	public function archiveSearchAction(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL) {
		$demand=$this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
		$demand->setListMode("archive");
		$limit = $this->settings['limit'];
		
		$demanded = $this->eventRepository->findDemanded($demand, $limit);
	
		$allCategories = $this->categoryRepository->findAll();
	
		$regionsRoot = $this->categoryRepository->findByUid($this->settings['category']['regionUid']);
		$regions = $this->categoryService->findAllDescendants($regionsRoot);
	
		$topicsRoot = $this->categoryRepository->findByUid($this->settings['category']['topicUid']);
		$topics = $this->categoryService->findAllDescendants($topicsRoot);
	
		$years = $this->generateYears();
	
		$this->view->assign('regions', $regions);
		$this->view->assign('topics', $topics);
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
	        if($speaker->getUid() == $user->getUid()){
	            $check = true;
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
	
	public function getErrorFlashMessage() {
		DebuggerUtility::var_dump($this->controllerContext->getArguments()->getValidationResults()->getFlattenedErrors());
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
