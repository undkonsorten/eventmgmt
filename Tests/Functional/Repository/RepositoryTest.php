<?php
namespace Undkonsorten\Eventmgmt\Tests\Functional\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use Undkonsorten\Eventmgmt\Domain\Repository\CalendarRepository;
use Undkonsorten\Eventmgmt\Domain\Repository\EventRepository;

class RepositoryTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{

    protected $calendarRepository;
    protected $categoryRepository;
    protected $objectManager;
    protected $testExtensionsToLoad = ['typo3conf/ext/eventmgmt', 'typo3conf/ext/addressmgmt'];

    public function setUp()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        parent::setUp();
    }

    /**
     * @test
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    public function choosenCategoryFiltersResultSet()
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_category.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_eventmgmt_domain_model_event.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_eventmgmt_domain_model_calendar.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_eventmgmt_event_calendar_mm.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_eventmgmt_event_category_mm.xml');

        $this->categoryRepository = $this->objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository::class);
        $this->calendarRepository = $this->objectManager->get(CalendarRepository::class);
        $category = $this->categoryRepository->findByUid(1);
        $calendar = $this->calendarRepository->findByUid(2);
        $demand = $this->objectManager->get(\Undkonsorten\Eventmgmt\Domain\Model\EventDemand::class);
        $demand->setSearchFields(['title']);
        $demand->setDisplayPrimaryCategory('only');
        $demand->addPrimaryCategory($category);
        $demand->addPrimaryCalendar($calendar);

        /** @var \Undkonsorten\Eventmgmt\Domain\Repository\EventRepository $eventRepository */
        $eventRepository = $this->objectManager->get(EventRepository::class);

        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $eventRepository->setDefaultQuerySettings($querySettings);
        $events = $eventRepository->findDemanded($demand);
        $events = $events->toArray();
        $this->assertEquals(1,count($events));
        $this->assertEquals($events[0]->getUid(),456);
    }


}
