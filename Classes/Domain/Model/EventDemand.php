<?php

namespace Undkonsorten\Event\Domain\Model;
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
	 */
	protected $subject;
	
	/**
	 * Category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $category;
	
	/**
	 * @var \DateTime
	 */
	protected $startDate;
	
	/**
	 * @var \DateTime
	 */
	protected $endDate;
	
	/**
	 * 
	 * @var \array
	 */
	protected $searchFields;
	
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
	 * @var integer
	 */
	protected $storagePage;

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
		$this->subject = $subject;
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
	}/**
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