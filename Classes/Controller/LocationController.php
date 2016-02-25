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
use Undkonsorten\Eventmgmt\Domain\Model\Year;

class LocationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * calendarRepository
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Repository\LocationRepository
	 * @inject
	 */
	protected $locationRepository;
	
	/**
	 *
	 * @var \Undkonsorten\Eventmgmt\Utility\EventLocations
	 * @inject
	 */
	protected $eventLocations;
	
	/**
	 * 
	 * @var \Undkonsorten\Eventmgmt\Utility\DemandUtility
	 * @inject
	 */
	protected $demandUtility;
	
	/**
	 * eventRepository
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository;

	
	/**
	 * action list
	 * @return void
	 */
	public function listAction() {
	    if($this->settings['onlyUsedLocations']){
	        $demand = $this->demandUtility->updateDemandObjectFromSettings($demand, $this->settings);
	        $events = $this->eventRepository->findDemanded($demand);
	        $locations = $this->eventLocations->getLocationsFromEvents($events);
	    }else{
	        
	    }
        
		$this->view->assign('locations', $locations);
	}
	
	/**
	 * action show
	 *
	 * @param \Undkonsorten\Addressmgmt\Domain\Model\Address\Location $location
	 * @return void
	 */
	public function showAction(\Undkonsorten\Addressmgmt\Domain\Model\Address\Location $location) {
	    $this->view->assign('location', $location);
	}
	
	
	
	

}
?>
