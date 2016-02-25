<?php

namespace Undkonsorten\Eventmgmt\Domain\Model;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Eike Starkmann <eike.starkmann@undkonsorten.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Event Demand object which holds all information to get the correct
 * media records.
 *
 * @package event
 * @subpackage dto
 */
class EventDemand extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {
	
	/**
	 * @var string
	 * 
	 */
	protected $subject;
	
	/**
	 * Category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $category;
	
	/**
	 * Regions
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\Category
	 */
	protected $regions;
	
	/**
	 * Topics
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\Category
	 */
	protected $topics;
	
	/**
	 * types
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\Category
	 */
	protected $types;
	
	/**
	 * @var \DateTime
	 */
	protected $startDate;
	
	/**
	 * @var \DateTime
	 */
	protected $endDate;
	
	/**
	 * @var string
	 */
	protected $archiveDate;
	
	/**
	 * @var string
	 */
	protected $listMode;
	
	/**
	 * 
	 * @var \array
	 */
	protected $searchFields;
	
	/**
	 *
	 * @var string
	 */
	protected $order;
	
	/**
	 * 
	 * @var string
	 */
	protected $search;
	

	/**
	 * @var integer
	 */
	protected $limit;

	/**
	 * @var integer
	 */
	protected $offset;
	
	/**
	 * @var string
	 */
	protected $storagePage;
	
	/**
	 * The primary calendar of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Calendar>
	 */
	protected $primaryCalendar;
	
	/**
	 * The display of the primary calendar of the event
	 *
	 * @var string
	 */
	protected $displayPrimaryCalendar;
	
	/**
	 * The secondary calendar of the event
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Calendar>
	 */
	protected $secondaryCalendar;
	
	/**
	 * Display category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $primaryCategory;
	
	/**
	 * Category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $secondaryCategory;
	
	/**
	 * The display of the primary category of the event
	 *
	 * @var string
	 */
	protected $displayPrimaryCategory;
	
	/**
	 * The display of the secondary category of the event
	 *
	 * @var string
	 */
	protected $displaySecondaryCalendar;
	
	/**
	 * The display of the secondary category of the event
	 *
	 * @var string
	 */
	protected $displaySecondaryCategory;
	
	/**
	 * 
	 * @var \Undkonsorten\Addressmgmt\Domain\Model\Address\Person
	 */
	protected $speakerAddress;
	
	/**
	 * 
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $speakerFeUser;
	
	/**
	 * 
	 * @var \Undkonsorten\Addressmgmt\Domain\Model\Address\Location
	 */
	protected $location;
	
	
	/**
	 * 
	 * @var \Undkonsorten\Eventmgmt\Domain\Model\Timeslot 
	 */
	protected $timeslot;
	
	
	/**
	 * 
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 * @inject
	 */
	protected $objectManager;
	
	
	/**
	 * __construct
	 *
	 * @return Publication
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
		$this->primaryCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->secondaryCalendar = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->secondaryCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * List of allowed $startDate
	 *
	 * @param \DateTime $startDate
	 * @return void
	 */
	public function setStartDate($startDate) {
		
		$this->startDate = $startDate;
	}
	
	/**
	 * Get allowed $startDate
	 *
	 * @return string
	 */
	public function getStartDate() {
		return $this->startDate;
	}
	
	/**
	 * List of allowed $archiveDate
	 *
	 * @param string $archiveDate
	 * @return void
	 */
	public function setArchiveDate($archiveDate) {
	
		$this->archiveDate = $archiveDate;
	}
	
	/**
	 * Get allowed $archiveDate
	 *
	 * @return string
	 */
	public function getArchiveDate() {
		return $this->archiveDate;
	}
	
	/**
	 * List of allowed $listMode
	 *
	 * @param string $listMode
	 * @return void
	 */
	public function setListMode($listMode) {
	
		$this->listMode = $listMode;
	}
	
	/**
	 * Get allowed $listMode
	 *
	 * @return string
	 */
	public function getListMode() {
		return $this->listMode;
	}
	
	/**
	 * List of allowed $endDate
	 *
	 * @param \DateTime $endDate
	 * @return void
	 */
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
	}
	
	/**
	 * Get allowed $endDate
	 *
	 * @return string
	 */
	public function getEndDate() {
		return $this->endDate;
	}
	
	public function getDateRange() {
		if($this->getStartDate() || $this->getEndDate()) {
			$range = array(
				'startDate' => $this->getStartDate(),
				'endDate' => $this->getEndDate()	
			);
		}
		return $range;
	}
	
	/**
	 * List of allowed $subject
	 *
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = trim($subject);
	}
	
	/**
	 * Get allowed $subject
	 *
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Set order
	 *
	 * @param string $order order
	 * @return void
	 */
	public function setOrder($order) {
		$this->order = $order;
	}

	/**
	 * Get order
	 *
	 * @return string
	 */
	public function getOrder() {
		return $this->order;
	}

	/**
	 * Set search fields
	 *
	 * @param array $searchFields search fields
	 * @return void
	 */
	public function setSearchFields($searchFields) {
		$this->searchFields = $searchFields;
	}

	/**
	 * Get search fields
	 *
	 * @return array
	 */
	public function getSearchFields() {
		return $this->searchFields;
	}

	/**
	 * Set limit
	 *
	 * @param integer $limit limit
	 * @return void
	 */
	public function setLimit($limit) {
		$this->limit = (int)$limit;
	}

	/**
	 * Get limit
	 *
	 * @return integer
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Set offset
	 *
	 * @param integer $offset offset
	 * @return void
	 */
	public function setOffset($offset) {
		$this->offset = (int)$offset;
	}

	/**
	 * Get offset
	 *
	 * @return integer
	 */
	public function getOffset() {
		return $this->offset;
	}
	
	/**
	 * Set list of storage pages
	 *
	 * @param string $storagePage storage page list
	 * @return void
	 */
	public function setStoragePage($storagePage) {
		$this->storagePage = $storagePage;
	}
	
	/**
	 * Get list of storage pages
	 *
	 * @return string
	 */
	public function getStoragePage() {
		return $this->storagePage;
	}
	
	/**
	 * Adds a PrimaryCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $primaryCategory
	 * @return void
	 */
	public function addPrimaryCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $primaryCategory) {
		$this->primaryCategory->attach($primaryCategory);
	}

	/**
	 * Removes a PrimaryCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $primaryCategoryToRemove The PrimaryCategory to be removed
	 * @return void
	 */
	public function removePrimaryCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $primaryCategoryToRemove) {
		$this->primaryCategory->detach($primaryCategoryToRemove);
	}

	/**
	 * Returns the primaryCategory
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $primaryCategory
	 */
	public function getPrimaryCategory() {
		return $this->primaryCategory;
	}

	/**
	 * Sets the primaryCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $primaryCategory
	 * @return void
	 */
	public function setPrimaryCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $primaryCategory) {
		$this->primaryCategory = $primaryCategory;
	}
	
	/**
	 * Set displayPrimaryCategory
	 *
	 * @param string $displayPrimaryCategory displayPrimaryCategory
	 * @return void
	 */
	public function setDisplayPrimaryCategory($displayPrimaryCategory) {
		$this->displayPrimaryCategory = $displayPrimaryCategory;
	}
	
	/**
	 * Get displayPrimaryCategory
	 *
	 * @return string
	 */
	public function getDisplayPrimaryCategory() {
		return $this->displayPrimaryCategory;
	}
	
	/**
	 * Adds a SecondaryCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $secondaryCategory
	 * @return void
	 */
	public function addSecondaryCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $secondaryCategory) {
		$this->secondaryCategory->attach($secondaryCategory);
	}
	
	/**
	 * Removes a SecondaryCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $secondaryCategoryToRemove The SecondaryCategory to be removed
	 * @return void
	 */
	public function removeSecondaryCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $secondaryCategoryToRemove) {
		$this->secondaryCategory->detach($secondaryCategoryToRemove);
	}
	
	/**
	 * Returns the secondaryCategory
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $secondaryCategory
	 */
	public function getSecondaryCategory() {
		return $this->secondaryCategory;
	}
	
	/**
	 * Sets the secondaryCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $secondaryCategory
	 * @return void
	 */
	public function setSecondaryCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $secondaryCategory) {
		$this->secondaryCategory = $secondaryCategory;
	}
	
	/**
	 * Adds a PrimaryCalendar
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Calendar $primaryCalendar
	 * @return void
	 */
	public function addPrimaryCalendar(\Undkonsorten\Eventmgmt\Domain\Model\Calendar $primaryCalendar) {
		$this->primaryCalendar->attach($primaryCalendar);
	}
	
	/**
	 * Removes a PrimaryCalendar
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Calendar $primaryCalendarToRemove The PrimaryCalendar to be removed
	 * @return void
	 */
	public function removePrimaryCalendar(\Undkonsorten\Eventmgmt\Domain\Model\Calendar $primaryCalendarToRemove) {
		$this->primaryCalendar->detach($primaryCalendarToRemove);
	}
	
	/**
	 * Returns the primaryCalendar
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Calendar> $primaryCalendar
	 */
	public function getPrimaryCalendar() {
		return $this->primaryCalendar;
	}
	
	/**
	 * Sets the primaryCalendar
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Calendar> $primaryCalendar
	 * @return void
	 */
	public function setPrimaryCalendar(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $primaryCalendar) {
		$this->primaryCalendar = $primaryCalendar;
	}
	
	/**
	 * Set displayPrimaryCalendar
	 *
	 * @param string $displayPrimaryCalendar displayPrimaryCalendar
	 * @return void
	 */
	public function setDisplayPrimaryCalendar($displayPrimaryCalendar) {
		$this->displayPrimaryCalendar = $displayPrimaryCalendar;
	}
	
	/**
	 * Get displayPrimaryCalendar
	 *
	 * @return string
	 */
	public function getDisplayPrimaryCalendar() {
		return $this->displayPrimaryCalendar;
	}
	
	
	/**
	 * Set displaySecondaryCalendar
	 *
	 * @param string $displaySecondaryCalendar displaySecondaryCalendar
	 * @return void
	 */
	public function setDisplaySecondaryCalendar($displaySecondaryCalendar) {
		$this->displaySecondaryCalendar = $displaySecondaryCalendar;
	}
	
	/**
	 * Get displaySecondaryCalendar
	 *
	 * @return string
	 */
	public function getDisplaySecondaryCalendar() {
		return $this->displaySecondaryCalendar;
	}
	
	
	/**
	 * Set displaySecondaryCategory
	 *
	 * @param string $displaySecondaryCategory displaySecondaryCategory
	 * @return void
	 */
	public function setDisplaySecondaryCategory($displaySecondaryCategory) {
		$this->displaySecondaryCategory = $displaySecondaryCategory;
	}
	
	/**
	 * Get displaySecondaryCategory
	 *
	 * @return string
	 */
	public function getDisplaySecondaryCategory() {
		return $this->displaySecondaryCategory;
	}
	
	
	/**
	 * Adds a SecondaryCalendar
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Calendar $secondaryCalendar
	 * @return void
	 */
	public function addSecondaryCalendar(\Undkonsorten\Eventmgmt\Domain\Model\Calendar $secondaryCalendar) {
		$this->secondaryCalendar->attach($secondaryCalendar);
	}
	
	/**
	 * Removes a SecondaryCalendar
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\Calendar $secondaryCalendarToRemove The SecondaryCalendar to be removed
	 * @return void
	 */
	public function removeSecondaryCalendar(\Undkonsorten\Eventmgmt\Domain\Model\Calendar $secondaryCalendarToRemove) {
		$this->secondaryCalendar->detach($secondaryCalendarToRemove);
	}
	
	/**
	 * Returns the secondaryCalendar
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Calendar> $secondaryCalendar
	 */
	public function getSecondaryCalendar() {
		return $this->secondaryCalendar;
	}
	
	/**
	 * Sets the secondaryCalendar
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Undkonsorten\Eventmgmt\Domain\Model\Calendar> $secondaryCalendar
	 * @return void
	 */
	public function setSecondaryCalendar(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $secondaryCalendar) {
		$this->secondaryCalendar = $secondaryCalendar;
	}
	
	/**
	 * Returns the topics
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\Category $topics
	 */
	public function getTopics() {
		return $this->topics;
	}
	
	/**
	 * Sets the topics
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $topics
	 * @return void
	 */
	public function setTopics($topics) {
		$this->topics = $topics;
	}
	
	/**
	 * Returns the regions
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\Category $regions
	 */
	public function getRegions() {
		return $this->regions;
	}
	
	/**
	 * Sets the regions
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $regions
	 * @return void
	 */
	public function setRegions($regions) {
		$this->regions = $regions;
	}
	
	const ARRAY_PROPERTIES = 'regions,topics,location,types,timeslot,subject,archiveDate';
	
	/**
	 * 
	 */
	public function getParameter(){
		$returnArray = array();
		foreach (explode(',', self::ARRAY_PROPERTIES) as $property) {
			$method = 'get' . ucfirst($property);
			$propertyValue =  $this->$method();
			if(!is_null($propertyValue)) {
				if(is_a($propertyValue, '\TYPO3\CMS\Extbase\Persistence\ObjectStorage')) {
					$propertyValue = $propertyValue->toArray();
				}
				$returnArray [$property]= $propertyValue;
				
			}
		}
		return $returnArray;
	}

	/**
	 * 
	 */
    public function getSpeaker()
    {
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['eventmgmt']);
        if($extConf['feUserAsRelation'] != 1){
            return $this->speakerAddress;
        }elseif($extConf['feUserAsRelation'] == 1){
            return $this->speakerFeUser;
        }
    }

    /**
     * 
     * @param mixed $speaker
     */
    public function setSpeaker($speaker)
    {
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['eventmgmt']);
        if($extConf['feUserAsRelation'] != 1){
            $this->speakerAddress = $$speaker;
        }elseif($extConf['feUserAsRelation'] == 1){
            $this->speakerFeUser = $speaker;
        }
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function setTypes($types)
    {
        $this->types = $types;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getTimeslot()
    {
        return $this->timeslot;
    }

    public function setTimeslot($timeslot)
    {
        $this->timeslot = $timeslot;
    }
   
 
 
    
    
 
 

    
  
 
	
	
}

?>
