<?php
namespace Undkonsorten\Eventmgmt\Utility;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 "Eike Starkmann <starkmann@undkonsorten.com>"
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
class CategoryService extends \TYPO3\CMS\Core\Utility\GeneralUtility {
	
	
	
	
	
	/**
	 * categoryRepository
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $categoryRepository;
	
	
	
	
	
	
	
	/**
	 * Finds all descendants of an given category
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $parentCategory
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $resultStorage
	 */
	
	public function findAllDescendants (\TYPO3\CMS\Extbase\Domain\Model\Category $parentCategory){
		$this->categoryRepository->setDefaultOrderings(array('title'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		$allCategories = $this->categoryRepository->findAll();
		
		$storage = $regions = $this->buildStorageFormQuery($allCategories);
		$resultStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
		$stack = array();
		array_push($stack, $parentCategory);
		while(count($stack)>0){
			$currentRoot = array_pop($stack);
			foreach($storage as $category){
				if($category->getParent() === $currentRoot){
					$resultStorage->attach($category);
					array_push($stack, $category);
				}
			}
		}
		return $resultStorage;
	}
	
	/**
	 * Builds an object storage form query
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	protected function buildStorageFormQuery (\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $query){
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
		foreach($query as $category){
			if($category->getParent()!=NULL) $storage->attach($category);
		}
		return $storage;
	}
	
}


?>
