<?php
namespace Undkonsorten\Eventmgmt\Utility;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Eike Starkmann <es@undkonsorten.com>, undkonsorten
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
 
 class DemandUtility{
     
     /**
      * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
      */
     protected $objectManager;
     
     /**
      * calendarRepository
      *
      * @var \Undkonsorten\Eventmgmt\Domain\Repository\CalendarRepository
      * @inject
      */
     protected $calendarRepository;
     
     /**
      * Injects the object manager
      *
      * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
      * @return void
      */
     public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
         $this->objectManager = $objectManager;
         $this->arguments = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Mvc\\Controller\\Arguments');
     }
     
     /**
      * Update demand with current settings, if not exists it creates one
      *
      * @param \Undkonsorte\Eventmgmt\Domain\Model\EventDemand
      * @param array
      * @return \Undkonsorten\Eventmgmt\Domain\Model\EventDemand
      */
     public function updateDemandObjectFromSettings(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand $demand = NULL, $settings) {
         if(is_null($demand)){
             $demand = $this->objectManager->get('Undkonsorten\Eventmgmt\Domain\Model\EventDemand');
         }
     
         $demand->setSearchFields(\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $settings['search']['fields'], TRUE));
     
         //Set primaryCalendar form backend settings
         if($settings['primaryCalendar']['displayCalendar']!='ignore'&&$settings['primaryCalendar']['calendar']){
             $demand->setDisplayPrimaryCalendar($settings['primaryCalendar']['displayCalendar']);
             foreach(explode(",", $settings['primaryCalendar']['calendar']) as $calendar){
                 $demand->addPrimaryCalendar($this->calendarRepository->findByUid($calendar));
             }
             	
             if($settings['primaryCalendar']['displayCategory']!='ignore'&&$settings['primaryCalendar']['category']){
                 $demand->setDisplayPrimaryCategory($settings['primaryCalendar']['displayCategory']);
                 foreach(explode(",", $settings['primaryCalendar']['category']) as $category){
                     //Add current category
                     $currentCategory = $this->categoryRepository->findByUid($category);
                     $demand->addPrimaryCategory($currentCategory);
                     //Add alls descendants of the current category
                     $descendants = $this->categoryService->findAllDescendants($currentCategory);
                     foreach($descendants as $descendant){
                         $demand->addPrimaryCategory($descendant);
                     }
                 }
             }
         }
     
         if($settings['secondaryCalendar']['displayCalendar']!='ignore'&&$settings['secondaryCalendar']['calendar']){
             $demand->setDisplaySecondaryCalendar($settings['secondaryCalendar']['displayCalendar']);
             foreach(explode(",", $settings['secondaryCalendar']['calendar']) as $calendar){
                 $demand->addSecondaryCalendar($this->calendarRepository->findByUid($calendar));
             }
     
             if($settings['secondaryCalendar']['displayCategory']!='ignore'&&$settings['secondaryCalendar']['category']){
                 $demand->setDisplaySecondaryCategory($settings['secondaryCalendar']['displayCategory']);
                 foreach(explode(",", $settings['secondaryCalendar']['category']) as $category){
                     //Add current category
                     $currentCategory = $this->categoryRepository->findByUid($category);
                     $demand->addSecondaryCategory($currentCategory);
                     //Add alls descendants of the current category
                     $descendants = $this->categoryService->findAllDescendants($currentCategory);
                     foreach($descendants as $descendant){
                         $demand->addSecondaryCategory($descendant);
                     }
                 }
             }
         }
     
     
         if ($settings['orderBy']) {
             $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
         }
         if ($settings['storageFolder']) {
             $demand->setStoragePage($settings['storageFolder']);
         }
         return $demand;
     }   
 }