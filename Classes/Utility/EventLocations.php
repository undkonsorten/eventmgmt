<?php
namespace Undkonsorten\Eventmgmt\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Felix Althaus <felix.althaus@undkonsorten.com>, undkonsorten
 *  Eike Starkmann <eike.starkmann@undkonsorten.com>, undkonsorten
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

class EventLocations
{
    public function getLocations($config)
    {
        $itemNames = array_map(function($item) {
            return $item[0];
        }, $config['items']);
        array_multisort($itemNames, $config['items']);
       
        return $config;
    }
    
    public function getLocationsFromEvents(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $events){
        $locations = array();
        $timeslots = array();
         
        // O(n)
        foreach($events as $event){
            $locations[$event->getLocation()->getLocation()->getUid()] = $event->getLocation()->getLocation();
            
            // O(n*m) m<<n
            if($event->getCalendar()->getTimeslots()){
                foreach($event->getCalendar()->getTimeslots() as $timeslot){
                    $timeslots[$timeslot->getUid()] = $timeslot;
                }
            }
        }
        //Average O(n*log(n))
        usort($locations, function($a,$b){
            return strnatcmp($a->getName(),$b->getName());
        }
        );
        
        usort($timeslots, function($a,$b){
            return ($a->getStart() < $b->getStart());
        }
        );
            //O(n) + O(n*log(n))
        return array('locations' => $locations, 'timeslots' => $timeslots);
    }
}