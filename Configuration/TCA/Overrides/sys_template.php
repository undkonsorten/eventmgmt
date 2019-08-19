<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('eventmgmt', 'Configuration/TypoScript', 'Eventmgmt');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('eventmgmt', 'Configuration/TypoScript/BasicCss', 'EventmgmtBasicCss');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('eventmgmt', 'Configuration/TypoScript/FrontendUser', 'FeUser');
