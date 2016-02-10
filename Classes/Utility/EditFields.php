<?php
namespace Undkonsorten\Eventmgmt\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;


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

class EditFields
{
    public function getFields($config)
    {
      // DebuggerUtility::var_dump($config);
       
       $filterList = "sys_language_uid,l10n_parent,l10n_diffsource,t3ver_label, hidden,starttime,endtime,tx_extbase_type";

       $result = array();
       $i=0;
        $config['items'] = $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns'];
        foreach($GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns'] as $field => $value){
          if(!in_array($field, GeneralUtility::trimExplode(",",$filterList))){
              $result[$i] = array(
                  0 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($value['label'], 'eventmgmt'), 
                  1 => $field
              );
              $i++;
          }
        }
        $config['items'] = $result;

       
        return $config;
    }
}