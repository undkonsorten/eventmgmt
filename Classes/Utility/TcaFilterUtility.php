<?php
namespace Undkonsorten\Eventmgmt\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Ingmar Schlecht <ingmar.schlecht@typo3.org>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class TcaFilterUtility {
	
	/**
	 * filter values by given type
	 * to configure set 'type'-key of parameter array
	 * 
	 * @param $parameters array containing values and additional parameters
	 * @return $array the filtered values
	 */
	public function filterByType($parameters) {
		$values = $parameters['values'];
		$cleanValues = array();
		if (is_array($values)) {
			foreach ($values as $value) {
				if (empty($value)) {
					continue;
				}
				list($tableName, $uid) = self::splitValueToTableAndUid($value);
				$record = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($tableName, $uid);
				if(isset($GLOBALS['TCA'][$tableName]['ctrl']['type'])) {
					$typeField = $GLOBALS['TCA'][$tableName]['ctrl']['type'];
				} else {
					$typeField = 'type';
				}
				if($record[$typeField] == $parameters['type']) {
					$cleanValues []= $value;
				}
			}
		}	
		return $cleanValues;
	}
	
	/**
	 * splits a single value of format tx_extenion_244 into tableName and uid
	 * returns as array with keys 'tableName' and 'uid'
	 * 
	 * @param $value the identifier to be split
	 * @return array
	 */
	static public function splitValueToTableAndUid($value) {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::revExplode('_', $value, 2);
		// return array('tableName' => $parts[0], 'uid' => $parts[1]);
	}
	
}
	   
?>
