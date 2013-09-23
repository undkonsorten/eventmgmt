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
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $image;

	/**
	 * Files of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
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
	protected $calendar;


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
	 * @var \Undkonsorten\Addressbook\Domain\Model\Address\Organisation
	 */
	protected $location;

	
	 /**
	 * Label of th location
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $locationLabel;
	
	/**
	 * Text of the location
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $locationText;
	
	/**
	 * Organizer of the event
	 *
	 * @var \Undkonsorten\Addressbook\Domain\Model\Address
	 *
	 */
	protected $organizer;

	/**
	 * Show category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $display;

	/**
	 * Category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $category;

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
		$this->calendar = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->display = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
	 */
	public function getImage() {
		return $this->image;
	}
	
	/**
	 * Returns the first image
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getFirstImage() {
		$images = $this->getImage()->toArray();
		return $images[0];
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns the files
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Sets the files
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
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
	 * @param \Undkonsorten\Event\Domain\Model\Calendar $calendar
	 * @return void
	 */
	public function addCalendar(\Undkonsorten\Event\Domain\Model\Calendar $calendar) {
		$this->calendar->attach($calendar);
	}

	/**
	 * Removes a Calendar
	 *
	 * @param \Undkonsorten\Event\Domain\Model\Calendar $calendarToRemove The Calendar to be removed
	 * @return void
	 */
	public function removeCalendar(\Undkonsorten\Event\Domain\Model\Calendar $calendarToRemove) {
		$this->calendar->detach($calendarToRemove);
	}

	/**
	 * Returns the calendar
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar> $calendar
	 */
	public function getCalendar() {
		return $this->calendar;
	}

	/**
	 * Sets the calendar
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Event\Domain\Model\Calendar> $calendar
	 * @return void
	 */
	public function setCalendar(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $calendar) {
		$this->calendar = $calendar;
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
	 * @return \Undkonsorten\Addressbook\Domain\Model\Address\Organisation $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Sets the location
	 *
	 * @param \Undkonsorten\Addressbook\Domain\Model\Address\Organisation $location
	 * @return void
	 */
	public function setLocation(\Undkonsorten\Event\Domain\Model\Address\Organisation $location) {
		$this->location = $location;
	}
	
	/**
	 * Returns the locationLabel
	 *
	 * @return \string $locationLabel
	 */
	public function getLocationLabel() {
		return $this->locationLabel;
	}
	
	/**
	 * Sets the locationLabel
	 *
	 * @param \string $locationLabel
	 * @return void
	 */
	public function setLocationLabel($locationLabel) {
		$this->locationLabel = $locationLabel;
	}
	
	/**
	 * Returns the locationText
	 *
	 * @return \string $locationText
	 */
	public function getLocationText() {
		return $this->locationText;
	}
	
	/**
	 * Sets the locationText
	 *
	 * @param \string $locationText
	 * @return void
	 */
	public function setLocationText($locationText) {
		$this->locationText = $locationText;
	}

	/**
	 * Returns the organizer
	 *
	 * @return\Undkonsorten\Addressbook\Domain\Model\Address $organizer
	 */
	public function getOrganizer() {
		return $this->organizer;
	}

	/**
	 * Sets the organizer
	 *
	 * @param \Undkonsorten\Addressbook\Domain\Model\Address $organizer
	 * @return void
	 */
	public function setOrganizer(\Undkonsorten\Event\Domain\Model\Address $organizer) {
		$this->organizer = $organizer;
	}

	/**
	 * Adds a Category
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $display
	 * @return void
	 */
	public function addDisplay(\TYPO3\CMS\Extbase\Domain\Model\Category $display) {
		$this->display->attach($display);
	}

	/**
	 * Removes a Category
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $displayToRemove The Category to be removed
	 * @return void
	 */
	public function removeDisplay(\TYPO3\CMS\Extbase\Domain\Model\Category $displayToRemove) {
		$this->display->detach($displayToRemove);
	}

	/**
	 * Returns the display
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $display
	 */
	public function getDisplay() {
		return $this->display;
	}

	/**
	 * Sets the display
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $display
	 * @return void
	 */
	public function setDisplay(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $display) {
		$this->display = $display;
	}

	/**
	 * Adds a Category
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
	 * @return void
	 */
	public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category) {
		$this->category->attach($category);
	}

	/**
	 * Removes a Category
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove) {
		$this->category->detach($categoryToRemove);
	}

	/**
	 * Returns the category
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $category
	 * @return void
	 */
	public function setCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $category) {
		$this->category = $category;
	}

}
?>