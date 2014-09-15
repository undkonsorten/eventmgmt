<?php
namespace Undkonsorten\Eventmgmt\Domain\Repository;

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

class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	
	/**
	 * Returns the objects of this repository matching the demand.
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @param integer $limit
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findDemanded(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand, $limit) {
		if($limit<=0){
			$limit = 100;
		}
		$query = $this->generateQuery($demand, $limit);
		return $query->execute();
	}
	
	/**
	 * Counts all available events without the limit
	 * 
	 * @param integer $count
	 */
	public function countDemanded($demand) {
		return $this->findDemanded($demand, NULL)->count();
		
	}
	
	/**
	 * Generates the query
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @param integer $limit
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
	 */
	protected function generateQuery(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand, $limit) {
		$query = $this->createQuery();
	
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$constraints = $this->createConstraintsFromDemand($query, $demand);
		if (!empty($constraints)) {
			$query->matching(
					$query->logicalAnd($constraints)
			);
		}
		
		if ($orderings = $this->createOrderingsFromDemand($demand)) {
			$query->setOrderings($orderings);
		}
	
		if ($demand->getLimit() != NULL) {
			$query->setLimit((int) $demand->getLimit());
		} else {
			$query->setLimit((int) $limit);
		}
		
		if ($demand->getOffset() != NULL) {
			$query->setOffset((int) $demand->getOffset());
		}
		return $query;
	}
	
	/**
	 * Returns an array of constraints created from a given demand object.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return array<Tx_Extbase_Persistence_QOM_Constraint>
	 */
	protected function createConstraintsFromDemand(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand) {
		$constraints = array();
		//@TODO Set proper filers here
		if($demand->getDisplayPrimaryCalendar()){
			$primaryCalendarConstraints[] = $this->createPrimaryAndSecondaryConstraints($query, $demand->getPrimaryCalendar(), $demand->getDisplayPrimaryCalendar(), 'calendar');
			
			//cal1 OR cal2 ...
			if($primaryCalendarConstraints && count($primaryCalendarConstraints)>1) {
				$primaryConstraints[] = $query->logicalOr($primaryCalendarConstraints);
			}else{
				$primaryConstraints = $primaryCalendarConstraints;
			}
				
		}
		
		
		if($demand->getDisplayPrimaryCategory()){
			$primaryCategoryConstraints[] = $this->createPrimaryAndSecondaryConstraints($query, $demand->getPrimaryCategory(), $demand->getDisplayPrimaryCategory(), 'display');
			$primaryCategoryConstraints[] = $this->createPrimaryAndSecondaryConstraints($query, $demand->getPrimaryCategory(), $demand->getDisplayPrimaryCategory(), 'category');
			$primaryCategoryConstraints = $this->cleanUnusedConstaints($primaryCategoryConstraints);
			
			// cat1 OR cat2 ..
			$primaryConstraints[] = $query->logicalOr($primaryCategoryConstraints);
		}
		
		//Calendar AND category
		if($primaryConstraints && count($primaryConstraints)>1) {
			$primaryConstraints = $query->logicalAnd($primaryConstraints);
		}
		
	
		
		if($demand->getDisplaySecondaryCalendar()){
			$secondayCategoryConstraints[] = $this->createPrimaryAndSecondaryConstraints($query, $demand->getSecondaryCalendar(), $demand->getDisplaySecondaryCalendar(), 'calendar');
			
			if(count($tmpConstraints)>1){
				$secondaryConstraints[] = $query->logicalAnd($secondayCategoryConstraints);
			}else{
				$secondaryConstraints = $secondayCategoryConstraints;
			}
		}
	
		if($demand->getDisplaySecondaryCategory()){
			$secondaryCategoryConstraints[] = $this->createPrimaryAndSecondaryConstraints($query, $demand->getSecondaryCategory(), $demand->getDisplaySecondaryCategory(), 'display');
			$secondaryCategoryConstraints[] = $this->createPrimaryAndSecondaryConstraints($query, $demand->getSecondaryCategory(), $demand->getDisplaySecondaryCategory(), 'category');
			$secondaryCategoryConstraints = $this->cleanUnusedConstaints($secondaryCategoryConstraints);

			$secondaryConstraints[] = $query->logicalOr($secondaryCategoryConstraints);
			
		}
		
		if($secondaryConstraints && count($secondaryConstraints)>1) {
			$secondaryConstraints = $query->logicalAnd($secondaryConstraints);
		}
		
		//primary OR secodary constraint
		if(count($primaryConstraints)==1 && count($secondaryConstraints)==1){
			$tmpConstraints[] = $secondaryConstraints;
			$tmpConstraints[] = $primaryConstraints;
			$constraints[] = $query->logicalOr($tmpConstraints);
		}else{
			if(count($primaryConstraints)==1){
				$constraints[] = $primaryConstraints;
			}
			if(count($secondaryConstraints)==1){
				$constraints[] = $secondaryConstraints;
			}
		}
		
		
		if($demand->getArchiveDate()){
			$endTimestamp = mktime(0,0,0,12,31,$demand->getArchiveDate());
			$startTimestamp = mktime(0,0,0,1,1,$demand->getArchiveDate());
			$constraints[] = $query->logicalAnd(
				$query->lessThanOrEqual('end', $endTimestamp),
				$query->greaterThanOrEqual('end', $startTimestamp)
			);
		}
		
		if($demand->getRegions()){
			$constraints[] = $query->contains('category',$demand->getRegions());
		}

		if($demand->getTopics()){
			$constraints[] = $query->contains('category',$demand->getTopics());
		}
		
		$archivConstraints = array();
		
		if($demand->getListMode()){
			$archivConstraints[] = $query->logicalAnd(array(
				$query->lessThanOrEqual('end', time()),
				$query->logicalNot($query->equals('end', 0))
			));
			$archivConstraints[] = $query->lessThanOrEqual('start', time());
			$constraints[] = $query->logicalAnd($archivConstraints);
			
		}else{
			$archivConstraints[] = $query->greaterThanOrEqual('end', time());
			$archivConstraints[] = $query->greaterThanOrEqual('start', time());
			$constraints[] = $query->logicalOr($archivConstraints);
		}
		
	
	
		// storage page
		if ($demand->getStoragePage() != 0) {
			$pidList = \TYPO3\CMS\Extbase\Utility\ArrayUtility::trimExplode(',', $demand->getStoragePage(), TRUE);
			$constraints[] = $query->in('pid', $pidList);
		}
	
		// search subject
		$searchFields = $demand->getSearchFields();
		$searchConstraints = array();
	
		if (count($searchFields) === 0) {
			throw new \UnexpectedValueException('No search fields defined', 1318497755);
		}
		$allowedCharactersInWords = '/[^\w@]/';
		$searchWords = preg_split($allowedCharactersInWords, $demand->getSubject(), -1, PREG_SPLIT_NO_EMPTY);
		
		
		if (is_array($searchWords) && count($searchWords)) {
			foreach($searchWords as $searchWord){
				$searchWordConstraint = array();
				foreach ($searchFields as $field) {
					//Search for each word seperatly
					$searchWordConstraint[] = $query->like($field, '%' . $searchWord . '%');
				}
				$searchConstraints[] = $query->logicalOr($searchWordConstraint);
			}
			$constraints[] = $query->logicalAnd($searchConstraints);
		}
		
		$constraints = $this->cleanUnusedConstaints($constraints);

		return $constraints;
	}
	
	/**
	 * Returns an array of orderings created from a given demand object.
	 *
	 * @param \Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand
	 * @return array<Tx_Extbase_Persistence_QOM_Constraint>
	 */
	protected function createOrderingsFromDemand(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand) {
		$orderings = array();
	
		if ($demand->getOrder()) {
			$orderList = \TYPO3\CMS\Extbase\Utility\ArrayUtility::trimExplode(',', $demand->getOrder(), TRUE);
	
			if (!empty($orderList)) {
				// go through every order statement
				foreach ($orderList as $orderItem) {
					list($orderField, $ascDesc) = \TYPO3\CMS\Extbase\Utility\ArrayUtility::trimExplode(' ', $orderItem, TRUE);
					// count == 1 means that no direction is given
					if ($ascDesc) {
						$orderings[$orderField] = ((strtolower($ascDesc) == 'desc') ?
								\TYPO3\CMS\EXTBASE\Persistence\QueryInterface::ORDER_DESCENDING :
								\TYPO3\CMS\EXTBASE\Persistence\QueryInterface::ORDER_ASCENDING);
					} else {
						$orderings[$orderField] = \TYPO3\CMS\EXTBASE\Persistence\QueryInterface::ORDER_ASCENDING;
					}
				}
			}
		} else {
			$orderings['start'] = \TYPO3\CMS\EXTBASE\Persistence\QueryInterface::ORDER_DESCENDING;
		}
		
		return $orderings;
		
		
	}
	/**
	 * Build the containts needed for the primary/secondary catlendar/category logic
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @param mixed $objects
	 * @param string $display
	 * @param string $field
	 */
	protected  function createPrimaryAndSecondaryConstraints(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, $objects, $display, $field){
		
		if ($objects && count($objects) != 0) {
			foreach ($objects as $object){
				$objectConstraints[] = $query->contains($field, $object);
			}
			$constraint = $query->logicalOr($objectConstraints);
				
			if($display == "except"){
				$constraint =$query->logicalNot($constraint);
			}
		}
		return $constraint;
	}
	
	/**
	 * 
	 * @param array $contrains
	 * @return array
	 */
	
	protected function cleanUnusedConstaints($constraints){
		// Clean not used constraints
		foreach ($constraints as $key => $value) {
			if (is_null($value)) {
				unset($constraints[$key]);
			}
		}
		return $constraints;
	}
}
?>