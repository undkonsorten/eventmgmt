<?php

namespace Undkonsorten\Event\Tests;
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
 * Test case for class \Undkonsorten\Event\Domain\Model\Event.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Calendar
 *
 * @author Eike Starkmann <starkmann@undkonsorten.com>
 */
class EventTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Undkonsorten\Event\Domain\Model\Event
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Undkonsorten\Event\Domain\Model\Event();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getSubtitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSubtitleForStringSetsSubtitle() { 
		$this->fixture->setSubtitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSubtitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getShortTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setShortTitleForStringSetsShortTitle() { 
		$this->fixture->setShortTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getShortTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getTeaserReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTeaserForStringSetsTeaser() { 
		$this->fixture->setTeaser('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTeaser()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImageForStringSetsImage() { 
		$this->fixture->setImage('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage()
		);
	}
	
	/**
	 * @test
	 */
	public function getFilesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFilesForStringSetsFiles() { 
		$this->fixture->setFiles('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFiles()
		);
	}
	
	/**
	 * @test
	 */
	public function getStartReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setStartForDateTimeSetsStart() { }
	
	/**
	 * @test
	 */
	public function getEndReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEndForDateTimeSetsEnd() { }
	
	/**
	 * @test
	 */
	public function getAllDayReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setAllDayForOoleanSetsAllDay() { }
	
	/**
	 * @test
	 */
	public function getFeeReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getFee()
		);
	}

	/**
	 * @test
	 */
	public function setFeeForFloatSetsFee() { 
		$this->fixture->setFee(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getFee()
		);
	}
	
	/**
	 * @test
	 */
	public function getPrimaryCalendarReturnsInitialValueForCalendar() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPrimaryCalendar()
		);
	}

	/**
	 * @test
	 */
	public function setPrimaryCalendarForObjectStorageContainingCalendarSetsPrimaryCalendar() { 
		$primaryCalendar = new \Undkonsorten\Event\Domain\Model\Calendar();
		$objectStorageHoldingExactlyOnePrimaryCalendar = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOnePrimaryCalendar->attach($primaryCalendar);
		$this->fixture->setPrimaryCalendar($objectStorageHoldingExactlyOnePrimaryCalendar);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePrimaryCalendar,
			$this->fixture->getPrimaryCalendar()
		);
	}
	
	/**
	 * @test
	 */
	public function addPrimaryCalendarToObjectStorageHoldingPrimaryCalendar() {
		$primaryCalendar = new \Undkonsorten\Event\Domain\Model\Calendar();
		$objectStorageHoldingExactlyOnePrimaryCalendar = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOnePrimaryCalendar->attach($primaryCalendar);
		$this->fixture->addPrimaryCalendar($primaryCalendar);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePrimaryCalendar,
			$this->fixture->getPrimaryCalendar()
		);
	}

	/**
	 * @test
	 */
	public function removePrimaryCalendarFromObjectStorageHoldingPrimaryCalendar() {
		$primaryCalendar = new \Undkonsorten\Event\Domain\Model\Calendar();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($primaryCalendar);
		$localObjectStorage->detach($primaryCalendar);
		$this->fixture->addPrimaryCalendar($primaryCalendar);
		$this->fixture->removePrimaryCalendar($primaryCalendar);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPrimaryCalendar()
		);
	}
	
	/**
	 * @test
	 */
	public function getSecundaryCalendarReturnsInitialValueForCalendar() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getSecundaryCalendar()
		);
	}

	/**
	 * @test
	 */
	public function setSecundaryCalendarForObjectStorageContainingCalendarSetsSecundaryCalendar() { 
		$secundaryCalendar = new \Undkonsorten\Event\Domain\Model\Calendar();
		$objectStorageHoldingExactlyOneSecundaryCalendar = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneSecundaryCalendar->attach($secundaryCalendar);
		$this->fixture->setSecundaryCalendar($objectStorageHoldingExactlyOneSecundaryCalendar);

		$this->assertSame(
			$objectStorageHoldingExactlyOneSecundaryCalendar,
			$this->fixture->getSecundaryCalendar()
		);
	}
	
	/**
	 * @test
	 */
	public function addSecundaryCalendarToObjectStorageHoldingSecundaryCalendar() {
		$secundaryCalendar = new \Undkonsorten\Event\Domain\Model\Calendar();
		$objectStorageHoldingExactlyOneSecundaryCalendar = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneSecundaryCalendar->attach($secundaryCalendar);
		$this->fixture->addSecundaryCalendar($secundaryCalendar);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneSecundaryCalendar,
			$this->fixture->getSecundaryCalendar()
		);
	}

	/**
	 * @test
	 */
	public function removeSecundaryCalendarFromObjectStorageHoldingSecundaryCalendar() {
		$secundaryCalendar = new \Undkonsorten\Event\Domain\Model\Calendar();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($secundaryCalendar);
		$localObjectStorage->detach($secundaryCalendar);
		$this->fixture->addSecundaryCalendar($secundaryCalendar);
		$this->fixture->removeSecundaryCalendar($secundaryCalendar);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getSecundaryCalendar()
		);
	}
	
	/**
	 * @test
	 */
	public function getRegisterReturnsInitialValueForLink() { }

	/**
	 * @test
	 */
	public function setRegisterForLinkSetsRegister() { }
	
	/**
	 * @test
	 */
	public function getLinkReturnsInitialValueForLink() { }

	/**
	 * @test
	 */
	public function setLinkForLinkSetsLink() { }
	
	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForAddress() { }

	/**
	 * @test
	 */
	public function setLocationForAddressSetsLocation() { }
	
	/**
	 * @test
	 */
	public function getOrganizerReturnsInitialValueForAddress() { }

	/**
	 * @test
	 */
	public function setOrganizerForAddressSetsOrganizer() { }
	
	/**
	 * @test
	 */
	public function getDisplayReturnsInitialValueForCategory() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getDisplay()
		);
	}

	/**
	 * @test
	 */
	public function setDisplayForObjectStorageContainingCategorySetsDisplay() { 
		$display = new \TYPO3\CMS\Extbase\Domain\Model\Category();
		$objectStorageHoldingExactlyOneDisplay = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneDisplay->attach($display);
		$this->fixture->setDisplay($objectStorageHoldingExactlyOneDisplay);

		$this->assertSame(
			$objectStorageHoldingExactlyOneDisplay,
			$this->fixture->getDisplay()
		);
	}
	
	/**
	 * @test
	 */
	public function addDisplayToObjectStorageHoldingDisplay() {
		$display = new \TYPO3\CMS\Extbase\Domain\Model\Category();
		$objectStorageHoldingExactlyOneDisplay = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneDisplay->attach($display);
		$this->fixture->addDisplay($display);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneDisplay,
			$this->fixture->getDisplay()
		);
	}

	/**
	 * @test
	 */
	public function removeDisplayFromObjectStorageHoldingDisplay() {
		$display = new \TYPO3\CMS\Extbase\Domain\Model\Category();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($display);
		$localObjectStorage->detach($display);
		$this->fixture->addDisplay($display);
		$this->fixture->removeDisplay($display);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getDisplay()
		);
	}
	
	/**
	 * @test
	 */
	public function getCategoryReturnsInitialValueForCategory() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategory()
		);
	}

	/**
	 * @test
	 */
	public function setCategoryForObjectStorageContainingCategorySetsCategory() { 
		$category = new \TYPO3\CMS\Extbase\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->setCategory($objectStorageHoldingExactlyOneCategory);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategory()
		);
	}
	
	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategory() {
		$category = new \TYPO3\CMS\Extbase\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->addCategory($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategory()
		);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategory() {
		$category = new \TYPO3\CMS\Extbase\Domain\Model\Category();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($category);
		$localObjectStorage->detach($category);
		$this->fixture->addCategory($category);
		$this->fixture->removeCategory($category);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCategory()
		);
	}
	
}
?>