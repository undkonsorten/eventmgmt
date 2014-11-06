<?php
namespace Undkonsorten\Eventmgmt\Domain\Model;

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
class Calendar extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Name of the calendar
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	
	protected $name;
	
	/**
	 * Subtitle of the calendar
	 *
	 * @var \string
	 */
	
	protected $subtitle;
	 * SinglePid of the calendar
	 *
	 * @var \string
	 * 
	 */
	protected $singlePid;
	
	/**
	 * 
	 * @var  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Event>
	 */
	 protected $events;
	
	/**
	 * __construct
	 *
	 * @return Event
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}
	
	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->events = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}
	
	/**
	 * Returns the singlePid
	 *
	 * @return \string $singlePid
	 */
	public function getSinglePid() {
		return $this->singlePid;
	}
	
	/**
	 * Sets the singlePid
	 *
	 * @param \string $singlePid
	 * @return void
	 */
	public function setSinglePid($singlePid) {
		$this->singlePid = $singlePid;
	}
	
	

	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Returns the subtitle
	 *
	 * @return \string $subtitle
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}
	
	/**
	 * Sets the subtitle
	 *
	 * @param \string $subtitle
	 * @return void
	 */
	public function setSubtitle($subtitle) {
		$this->subtitle = $subtitle;
	}
	
	/**
	 * Adds a Event
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Event $event
	 * @return void
	 */
	public function addEvent(\TYPO3\CMS\Extbase\Domain\Model\Event $event) {
		$this->events->attach($event);
	}
	
	/**
	 * Removes a Event
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Event $eventToRemove The Event to be removed
	 * @return void
	 */
	public function removeEvent(\TYPO3\CMS\Extbase\Domain\Model\Event $eventToRemove) {
		$this->events->detach($eventToRemove);
	}
	
	/**
	 * Returns the event
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Event> $events
	 */
	public function getEvents() {
		return $this->events;
	}
	
	/**
	 * Sets the events
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Event> $events
	 * @return void
	 */
	public function setEvents(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $events) {
		$this->events = $events;
	}

}
?>