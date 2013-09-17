<?php
namespace Undkonsorten\Event\Domain\Model;

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
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Title of the event
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * subtitle of the event
	 *
	 * @var \string
	 */
	protected $subtitle;

	/**
	 * Short title for breadcrumb and URL
	 *
	 * @var \string
	 */
	protected $shortTitle;

	/**
	 * Teaser of the event
	 *
	 * @var \string
	 */
	protected $teaser;

	/**
	 * Description of the Event
	 *
	 * @var \string
	 */
	protected $description;

	/**
	 * Images of the event
	 *
	 * @var \string
	 */
	protected $image;

	/**
	 * Files of the event
	 *
	 * @var \string
	 */
	protected $files;

	/**
	 * Beginning of the event
	 *
	 * @var \DateTime
	 */
	protected $start;

	/**
	 * Ending of the event
	 *
	 * @var \DateTime
	 */
	protected $end;

	/**
	 * Is the event all day?
	 *
	 * @var boolean
	 */
	protected $allDay = FALSE;

	/**
	 * Fee of the event
	 *
	 * @var \float
	 */
	protected $fee;

	/**
	 * The primary calendar of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar>
	 */
	protected $primaryCalendar;

	/**
	 * Other calender the event belongs to
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar>
	 */
	protected $secundaryCalendar;

	/**
	 * The link to where you can register for the event
	 *
	 * @var \Undkonsorten\Event\Domain\Model\Link
	 */
	protected $register;

	/**
	 * The link to the event page
	 *
	 * @var \Undkonsorten\Event\Domain\Model\Link
	 */
	protected $link;

	/**
	 * Location of the event
	 *
	 * @var \Undkonsorten\Event\Domain\Model\Address
	 */
	protected $location;

	/**
	 * Organizer of the event
	 *
	 * @var \Undkonsorten\Event\Domain\Model\Address
	 */
	protected $organizer;

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
		$this->primaryCalendar = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->secundaryCalendar = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
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
	 * Returns the shortTitle
	 *
	 * @return \string $shortTitle
	 */
	public function getShortTitle() {
		return $this->shortTitle;
	}

	/**
	 * Sets the shortTitle
	 *
	 * @param \string $shortTitle
	 * @return void
	 */
	public function setShortTitle($shortTitle) {
		$this->shortTitle = $shortTitle;
	}

	/**
	 * Returns the teaser
	 *
	 * @return \string $teaser
	 */
	public function getTeaser() {
		return $this->teaser;
	}

	/**
	 * Sets the teaser
	 *
	 * @param \string $teaser
	 * @return void
	 */
	public function setTeaser($teaser) {
		$this->teaser = $teaser;
	}

	/**
	 * Returns the description
	 *
	 * @return \string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the image
	 *
	 * @return \string $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \string $image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns the files
	 *
	 * @return \string $files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Sets the files
	 *
	 * @param \string $files
	 * @return void
	 */
	public function setFiles($files) {
		$this->files = $files;
	}

	/**
	 * Returns the start
	 *
	 * @return \DateTime $start
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Sets the start
	 *
	 * @param \DateTime $start
	 * @return void
	 */
	public function setStart($start) {
		$this->start = $start;
	}

	/**
	 * Returns the end
	 *
	 * @return \DateTime $end
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Sets the end
	 *
	 * @param \DateTime $end
	 * @return void
	 */
	public function setEnd($end) {
		$this->end = $end;
	}

	/**
	 * Returns the allDay
	 *
	 * @return boolean $allDay
	 */
	public function getAllDay() {
		return $this->allDay;
	}

	/**
	 * Sets the allDay
	 *
	 * @param boolean $allDay
	 * @return void
	 */
	public function setAllDay($allDay) {
		$this->allDay = $allDay;
	}

	/**
	 * Returns the boolean state of allDay
	 *
	 * @return boolean
	 */
	public function isAllDay() {
		return $this->getAllDay();
	}

	/**
	 * Returns the fee
	 *
	 * @return \float $fee
	 */
	public function getFee() {
		return $this->fee;
	}

	/**
	 * Sets the fee
	 *
	 * @param \float $fee
	 * @return void
	 */
	public function setFee($fee) {
		$this->fee = $fee;
	}

	/**
	 * Adds a Calendar
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Calendar $primaryCalendar
	 * @return void
	 */
	public function addPrimaryCalendar(\Undkonsorten\Event\Domain\Model\Calendar $primaryCalendar) {
		$this->primaryCalendar->attach($primaryCalendar);
	}

	/**
	 * Removes a Calendar
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Calendar $primaryCalendarToRemove The Calendar to be removed
	 * @return void
	 */
	public function removePrimaryCalendar(\Undkonsorten\Event\Domain\Model\Calendar $primaryCalendarToRemove) {
		$this->primaryCalendar->detach($primaryCalendarToRemove);
	}

	/**
	 * Returns the primaryCalendar
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar> $primaryCalendar
	 */
	public function getPrimaryCalendar() {
		return $this->primaryCalendar;
	}

	/**
	 * Sets the primaryCalendar
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar> $primaryCalendar
	 * @return void
	 */
	public function setPrimaryCalendar(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $primaryCalendar) {
		$this->primaryCalendar = $primaryCalendar;
	}

	/**
	 * Adds a Calendar
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Calendar $secundaryCalendar
	 * @return void
	 */
	public function addSecundaryCalendar(\Undkonsorten\Event\Domain\Model\Calendar $secundaryCalendar) {
		$this->secundaryCalendar->attach($secundaryCalendar);
	}

	/**
	 * Removes a Calendar
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Calendar $secundaryCalendarToRemove The Calendar to be removed
	 * @return void
	 */
	public function removeSecundaryCalendar(\Undkonsorten\Event\Domain\Model\Calendar $secundaryCalendarToRemove) {
		$this->secundaryCalendar->detach($secundaryCalendarToRemove);
	}

	/**
	 * Returns the secundaryCalendar
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar> $secundaryCalendar
	 */
	public function getSecundaryCalendar() {
		return $this->secundaryCalendar;
	}

	/**
	 * Sets the secundaryCalendar
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar> $secundaryCalendar
	 * @return void
	 */
	public function setSecundaryCalendar(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $secundaryCalendar) {
		$this->secundaryCalendar = $secundaryCalendar;
	}

	/**
	 * Returns the register
	 *
	 * @return \Undkonsorten\Event\Domain\Model\Link $register
	 */
	public function getRegister() {
		return $this->register;
	}

	/**
	 * Sets the register
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Link $register
	 * @return void
	 */
	public function setRegister(\Undkonsorten\Event\Domain\Model\Link $register) {
		$this->register = $register;
	}

	/**
	 * Returns the link
	 *
	 * @return \Undkonsorten\Event\Domain\Model\Link $link
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * Sets the link
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Link $link
	 * @return void
	 */
	public function setLink(\Undkonsorten\Event\Domain\Model\Link $link) {
		$this->link = $link;
	}

	/**
	 * Returns the location
	 *
	 * @return \Undkonsorten\Event\Domain\Model\Address $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Sets the location
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Address $location
	 * @return void
	 */
	public function setLocation(\Undkonsorten\Event\Domain\Model\Address $location) {
		$this->location = $location;
	}

	/**
	 * Returns the organizer
	 *
	 * @return \Undkonsorten\Event\Domain\Model\Address $organizer
	 */
	public function getOrganizer() {
		return $this->organizer;
	}

	/**
	 * Sets the organizer
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Address $organizer
	 * @return void
	 */
	public function setOrganizer(\Undkonsorten\Event\Domain\Model\Address $organizer) {
		$this->organizer = $organizer;
	}

}
?>