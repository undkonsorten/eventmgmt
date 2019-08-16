<?php
namespace Undkonsorten\Eventmgmt\Domain\Model;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
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
	 * @var \string
	 */
	protected $fee;

	/**
	 * The primary calendar of the event
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Model\Calendar
	 */
	protected $calendar;


	/**
	 * The link to where you can register for the event
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Model\Link
	 */
	protected $register;

	/**
	 * The link to the event page
	 *
	 * @var \Undkonsorten\Eventmgmt\Domain\Model\Link
	 */
	protected $link;

	/**
	 * Location of the event
	 *
	 * @var \Undkonsorten\Addressmgmt\Domain\Model\Address\Location
	 */
	protected $location;
	
	/**
	 * Location_Room relation of the event
	 *
	 * @var \Undkonsorten\Addressmgmt\Domain\Model\Relation
	 */
	protected $locationRelation;

	
	/**
	 * Alternative/additional location
	 *
	 * @var \string
	 * 
	 */
	protected $locationAlternative;
	
	/**
	 * Closest city
	 *
	 * @var \string
	 * 
	 */
	protected $locationClosestCity;
	
	/**
	 * Organizer of the event
	 *
	 * @var \Undkonsorten\Addressmgmt\Domain\Model\Address
	 *
	 */
	protected $organizerAddress;
	
	/**
	 * Organizer of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $organizerFeUser;
	
	/**
	 * Organizer of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Addressmgmt\Domain\Model\Address>
	 *
	 */
	protected $speaker;
	
	/**
	 * Organizer of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
	 */
	protected $speakerFeUser;

	/**
	 * Alternative/additional location
	 *
	 * @var \string
	 * 
	 */
	protected $organizerAlternative;
	
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
	 * 
	 */
	protected $category;
	
	/**
	 * Contact of the event
	 *
	 * @var \Undkonsorten\Addressmgmt\Domain\Model\Address
	 *
	 */
	protected $contactAddress;
	
	/**
	 * Contact of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 *
	 */
	protected $contactFeUser;

	
	/**
	 * Alternative/additional contact
	 *
	 * @var \string
	 *
	 */
	protected $contactAlternative;
	
	/**
	 * 
	 * @var \string
	 */
	protected $program;
	
	/**
	 * 
	 * @var \string
	 */
	protected $technic;

    /**
     * @var \DateTime
     */
	protected $entrytime;

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


	public function addFile($file){
		$this->files->attach($file);
	}
	
	public function addImage($image){
        $this->image->attach($image);

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
	 * @return \string $fee
	 */
	public function getFee() {
		return $this->fee;
	}

	/**
	 * Sets the fee
	 *
	 * @param \string $fee
	 * @return void
	 */
	public function setFee($fee) {
		$this->fee = $fee;
	}


	/**
	 * Returns the calendar
	 *
	 * @return \Undkonsorten\Eventmgmt\Domain\Model\Calendar $calendar
	 */
	public function getCalendar() {
		return $this->calendar;
	}

	/**
	 * Sets the calendar
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Calendar $calendar
	 * @return void
	 */
	public function setCalendar(\Undkonsorten\Eventmgmt\Domain\Model\Calenda $calendar) {
		$this->calendar = $calendar;
	}

	/**
	 * Returns the register
	 *
	 * @return \Undkonsorten\Eventmgmt\Domain\Model\Link $register
	 */
	public function getRegister() {
		return $this->register;
	}

	/**
	 * Sets the register
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Link $register
	 * @return void
	 */
	public function setRegister(\Undkonsorten\Eventmgmt\Domain\Model\Link $register) {
		$this->register = $register;
	}

	/**
	 * Returns the link
	 *
	 * @return \Undkonsorten\Eventmgmt\Domain\Model\Link $link
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * Sets the link
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Link $link
	 * @return void
	 */
	public function setLink(\Undkonsorten\Eventmgmt\Domain\Model\Link $link) {
		$this->link = $link;
	}

	/**
	 * Returns the location
	 *
	 * @return \Undkonsorten\Addressmgmt\Domain\Model\Address\Location $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Sets the location
	 *
	 * @param \Undkonsorten\Addressmgmt\Domain\Model\Address\Location $location
	 * @return void
	 */
	public function setLocation(\Undkonsorten\Addressmgmt\Domain\Model\Address\Location $location) {
		$this->location = $location;
	}
	
	/**
	 * Returns the location
	 *
	 * @return \Undkonsorten\Addressmgmt\Domain\Model\Relation $location
	 */
	public function getLocationRelation() {
	    return $this->locationRelation;
	}
	
	/**
	 * Sets the location
	 *
	 * @param \Undkonsorten\Addressmgmt\Domain\Model\Relation $location
	 * @return void
	 */
	public function setLocationRelation(\Undkonsorten\Addressmgmt\Domain\Model\Address\Relation $location) {
	    $this->locationRelation = $location;
	}
	
	/**
	 * Returns the alternative location
	 *
	 * @return \string $locationAlternative
	 */
	public function getLocationAlternative() {
		return $this->locationAlternative;
	}
	
	/**
	 * Sets the locationAlternative
	 *
	 * @param \string $locationAlternative
	 * @return void
	 */
	public function setLocationAlternative($locationAlternative) {
		$this->locationAlternative = $locationAlternative;
	}

	/**
	 * Returns the location's closest city
	 *
	 * @return \string $locationClosestCity
	 */
	public function getLocationClosestCity() {
		return $this->locationClosestCity;
	}
	
	/**
	 * Sets the location's closest city
	 *
	 * @param \string $locationClosestCity
	 * @return void
	 */
	public function setLocationClosestCity($locationClosestCity) {
		$this->locationClosestCity = $locationClosestCity;
	}
	
	
	/**
	 * gets closest city, either from event or event.location
	 * 
	 * @return \string
	 */
	public function getClosestCity() {
		$closestCity = '';
		if($this->getLocationClosestCity()) {
			$closestCity = $this->getLocationClosestCity();
		} elseif ($this->getLocationRelation()) {
			$closestCity = $this->getLocationRelation()->getLocation()->getClosestCity();
		}
		return $closestCity;
	}

	/**
	 * Returns the organizer
	 *
	 * @return mixed $organizer
	 */
	public function getOrganizer() {
	    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	    if($extConf['feUserAsRelation'] != 1){
	        return $this->organizerAddress;
	    }elseif($extConf['feUserAsRelation'] == 1){
	       
	        $this->organizer = $this->organizerFeUser;
	        return $this->organizerFeUser;
	    }
		
	}

	/**
	 * Sets the organizer
	 *
	 * @param \Undkonsorten\Addressmgmt\Domain\Model\Address $organizer
	 * @return void
	 */
	public function setOrganizer(\Undkonsorten\Eventmgmt\Domain\Model\Address $organizer) {
		$this->organizer = $organizer;
	}
	
	/**
	 * Returns the speaker
	 *
	 * @return mixed $speaker
	 */
	public function getSpeaker() {
	    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	    if($extConf['feUserAsRelation'] != 1){
	        return $this->speaker;
	    }elseif($extConf['feUserAsRelation'] == 1){
	        return $this->speakerFeUser;
	    }
	
	}
	
	/**
	 * Sets the speaker
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<mixed>
	 * @return void
	 */
	public function setSpeaker(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $speakers) {
	    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	    if($extConf['feUserAsRelation'] != 1){
	        $this->speaker = $speakers;
	    }elseif($extConf['feUserAsRelation'] == 1){
	        $this->speakerFeUser = $speakers;
	    }
	}
	
	/**
	 * Adds a speaker
	 *
	 * @param mixed $person
	 * @return void
	 */
	public function addSpeaker($speaker) {
	    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	    if($extConf['feUserAsRelation'] != 1){
	        $this->speaker->attach($speaker);
	    }elseif($extConf['feUserAsRelation'] == 1){
	        $this->speakerFeUser->attach($speaker);
	    }
	}
	
	/**
	 * Removes a Category
	 *
	 * @param mixed $speaker The Category to be removed
	 * @return void
	 */
	public function removeSpeaker($speaker) {
	    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	    if($extConf['feUserAsRelation'] != 1){
	        $this->speaker->detach($speaker);
	    }elseif($extConf['feUserAsRelation'] == 1){
	        $this->speakerFeUser->detach($speaker);
	    }
	}
	
	/**
	 * Returns the contact
	 *
	 * @return mixed $contact
	 */
	public function getContact() {
	    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
	    if($extConf['feUserAsRelation'] != 1){
	        return $this->contactAddress;
	    }elseif($extConf['feUserAsRelation'] == 1){
	        return $this->contactFeUser;
	    }
	}
	
	/**
	 * Sets the contact
	 *
	 * @param \Undkonsorten\Addressmgmt\Domain\Model\Address $contact
	 * @return void
	 */
	public function setContact(\Undkonsorten\Eventmgmt\Domain\Model\Address $contact) {
		$this->contact = $contact;
	}

	/**
	 * Returns the alternative organizer
	 *
	 * @return \string
	 */
	public function getOrganizerAlternative() {
		return $this->organizerAlternative;
	}

	/**
	 * Sets the alternative organizer
	 *
	 * @param \string $organizerAlternative
	 * @return void
	 */
	public function setOrganizerAlternative($organizerAlternative) {
		$this->organizerAlternative = $organizerAlternative;
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
	
	/**
	 * 
	 * @return string
	 */
	public function getContactAlternative() {
		return $this->contactAlternative;
	}
	
	/**
	 * 
	 * @param string $contactAlternative
	 */
	public function setContactAlternative($contactAlternative) {
		$this->contactAlternative = $contactAlternative;
	}

    public function getProgram()
    {
        return $this->program;
    }

    public function setProgram($program)
    {
        $this->program = $program;
        return $this;
    }

    public function getTechnic()
    {
        return $this->technic;
    }

    public function setTechnic($technic)
    {
        $this->technic = $technic;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEntrytime()
    {
        return $this->entrytime;
    }

    /**
     * @param \DateTime $entrytime
     */
    public function setEntrytime($entrytime)
    {
        $this->entrytime = $entrytime;
    }



	
}
?>
