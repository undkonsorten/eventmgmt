<?php
declare(strict_types=1);
namespace Undkonsorten\Eventmgmt\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\PopulatePageSlugs;

/**
 * This file is part of the TYPO3 CMS extension "eventmgmt".
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class PopulateSlugs
 *
 * @author Elias Häußler <elias.haeussler@undkonsorten.com>
 * @license GPL-2.0+
 */
class PopulateSlugs extends PopulatePageSlugs
{
    /**
     * @var array URL parameters identifying the data sets
     */
    protected $urlParameter = [
        'tx_eventmgmt_domain_model_event' => 'tx_eventmgmt_list[event]',
    ];

    /**
     * @var string Field name
     */
    protected $fieldName = 'slug';

    /**
     * @var array Database tables which need migration
     */
    protected $tablesRequiredForUpgrade = [];


    /**
     * {@inheritDoc}
     */
    public function getIdentifier(): string
    {
        return 'eventmgmtSlugs';
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle(): string
    {
        return 'Introduce URL parts ("slugs") to all EXT:eventmgmt data sets';
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return 'Since TYPO3 supports native URL handling, existing path segments need to ' .
            'be migrated to make use of the new URL handling. The following tables ' .
            'deliver a new field called "slug" which contains the new path segments:' . PHP_EOL . '- ' .
            implode(PHP_EOL . '- ', array_keys($this->urlParameter));
    }

    /**
     * {@inheritDoc}
     */
    public function updateNecessary(): bool
    {
        $updateNeeded = $this->checkIfWizardIsRequired();
        return $updateNeeded;
    }

    /**
     * {@inheritDoc}
     *
     * @throws SiteNotFoundException
     */
    public function executeUpdate(): bool
    {
        $this->checkIfWizardIsRequired();
        foreach ($this->tablesRequiredForUpgrade as $tableName) {
            $this->populateSlugsForTable($tableName);
        }
        return true;
    }

    /**
     * Build slugs for data sets in given table.
     *
     * @param string $tableName Table name where slugs should be populated
     * @throws SiteNotFoundException
     */
    protected function populateSlugsForTable(string $tableName): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $statement = $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->fieldName, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->fieldName)
                )
            )
            ->execute();

        // Get suggested slugs from realurl table
        $suggestedSlugs = [];
        if ($this->checkIfTableExists('tx_realurl_urldata')) {
            $suggestedSlugs = $this->getSuggestedSlugsForTable('tx_realurl_urldata', $this->urlParameter[$tableName]);
        }

        // Get table field configuration
        $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$this->fieldName]['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $tableName, $this->fieldName, $fieldConfig);

        // Update slug for all fields of current table
        while ($record = $statement->fetch()) {
            $recordId = (int)$record['uid'];
            $pid = (int)$record['pid'];
            $languageId = (int)$record['sys_language_uid'];
            $pageIdInDefaultLanguage = $languageId > 0 ? (int)$record['l10n_parent'] : $recordId;
            $slug = $suggestedSlugs[$pageIdInDefaultLanguage][$languageId] ?? '';

            if (empty($slug)) {
                $slug = $slugHelper->generate($record, $pid);
            }

            $state = RecordStateFactory::forName($tableName)->fromArray($record, $pid, $recordId);
            if ($hasToBeUniqueInSite && !$slugHelper->isUniqueInSite($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
            }
            if ($hasToBeUniqueInPid && !$slugHelper->isUniqueInPid($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
            }

            $connection->update($tableName, [$this->fieldName => $slug], ['uid' => $recordId]);
        }
    }

    /**
     * Get suggested slugs from given migration table.
     *
     * @param string $tableName Name of the migration table
     * @param string $urlParameter URL parameter to be used for searching in migration table
     * @return array Suggested slugs in migration table for given URL parameter
     */
    protected function getSuggestedSlugsForTable(string $tableName, string $urlParameter): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
        $statement = $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->like(
                    'request_variables',
                    $queryBuilder->createNamedParameter('%"' . $urlParameter . '"%')
                )
            )
            ->execute();

        $suggestedSlugs = [];
        while ($row = $statement->fetch()) {
            // rawurldecode ensures that non-ASCII arguments are also migrated
            $pathSegment = rawurldecode($row['speaking_url']);
            $requestVariables = json_decode($row['request_variables'], true);
            $dataSetUid = (int)$requestVariables[$urlParameter];
            $languageId = (int)$requestVariables['L'];
            preg_match('/\/?[^\/]*$/', trim($pathSegment, '/'), $matches);
            $suggestedSlugs[$dataSetUid][$languageId] = trim($matches[0], '/');
        }
        return $suggestedSlugs;
    }

    /**
     * {@inheritDoc}
     */
    protected function checkIfWizardIsRequired(): bool
    {
        $updateNeeded = false;
        foreach (array_keys($this->urlParameter) as $tableName) {
            if ($this->checkIfWizardIsRequiredForTable($tableName)) {
                $this->tablesRequiredForUpgrade[] = $tableName;
                $updateNeeded = true;
            }
        }
        return $updateNeeded;
    }

    /**
     * Check if upgrade wizard is required for a given table.
     *
     * @param string $tableName Table name to check
     * @return bool `true` if an upgrade is required, `false` otherwise
     */
    protected function checkIfWizardIsRequiredForTable(string $tableName): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $numberOfEntries = $queryBuilder
            ->count('uid')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->fieldName, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->fieldName)
                )
            )
            ->execute()
            ->fetchColumn();
        return $numberOfEntries > 0;
    }
}
