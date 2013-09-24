<?php
namespace Undkonsorten\Event\Domain\Repository;

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
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	/**
	 * Returns the objects of this repository matching the demand.
	 *
	 * @param \Undkonsorten\Event\Domain\Model\EventDemand $demand
	 * @param integer $limit
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findDemanded(\Undkonsorten\Event\Domain\Model\EventDemand $demand, $limit) {
		$query = $this->generateQuery($demand, $limit);
		return $query->execute();
	}
	
	/**
	 * Generates the query
	 *
	 * @param \Undkonsorten\Event\Domain\Model\EventDemand $demand
	 * @param integer $limit
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
	 */
	protected function generateQuery(\Undkonsorten\Event\Domain\Model\EventDemand $demand, $limit) {
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
	 * @param \Undkonsorten\Event\Domain\Model\EventDemand $demand
	 * @return array<Tx_Extbase_Persistence_QOM_Constraint>
	 */
	protected function createConstraintsFromDemand(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \Undkonsorten\Event\Domain\Model\EventDemand $demand) {
		$constraints = array();
	
		//@TODO Set proper filers here
	
		if($demand->getStartDate()) {
			$dateConstraints[] = $query->logicalOr(
					$query->greaterThanOrEqual('start', $demand->getStartDate()),
					$query->greaterThanOrEqual('parent.date', $demand->getStartDate())
			);
		}
		if($demand->getEndDate()) {
			$dateConstraints[] = $query->logicalOr(
					$query->lessThanOrEqual('end', $demand->getEndDate()),
					$query->lessThanOrEqual('parent.date', $demand->getEndDate())
			);
		}
		if($dateConstraints) $constraints[] = $query->logicalAnd($dateConstraints);
	
	
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
		if ($demand->getSubject() !== "" && $demand->getSubject() !== NULL) {
			$searchSubject = $demand->getSubject();
			foreach ($searchFields as $field) {
				if (!empty($searchSubject)) {
					$searchConstraints[] = $query->like($field, '%' . $searchSubject . '%');
				}
			}
			$constraints[] = $query->logicalOr($searchConstraints);
		}
	
		// Clean not used constraints
		foreach ($constraints as $key => $value) {
			if (is_null($value)) {
				unset($constraints[$key]);
			}
		}
		return $constraints;
	}
	
	/**
	 * Returns an array of orderings created from a given demand object.
	 *
	 * @param \Undkonsorten\Event\Domain\Model\EventDemand $demand
	 * @return array<Tx_Extbase_Persistence_QOM_Constraint>
	 */
	protected function createOrderingsFromDemand(\Undkonsorten\Event\Domain\Model\EventDemand $demand) {
		$orderings = array();
	
		if ($demand->getOrder()) {
			$orderList = t3lib_div::trimExplode(',', $demand->getOrder(), TRUE);
	
			if (!empty($orderList)) {
				// go through every order statement
				foreach ($orderList as $orderItem) {
					list($orderField, $ascDesc) = t3lib_div::trimExplode(' ', $orderItem, TRUE);
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
}
?>