<?php
namespace Undkonsorten\Event\Domain\Model;

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
class Calendar extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Name of the calendar
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	
	protected $name;
	
	/**
	 * SinglePid of the calendar
	 *
	 * @var \string
	 * 
	 */
	protected $singlePid;
	
	/**
	 * Returns the singlePid
	 *
	 * @return \string $singlePid
	 */
	public function getSinglePid() {
		return $this->singlePid;
	}
	
	/**
	 * Sets the singlePid
	 *
	 * @param \string $singlePid
	 * @return void
	 */
	public function setSinglePid($singlePid) {
		$this->singlePid = $singlePid;
	}
	
	

	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

}
?>