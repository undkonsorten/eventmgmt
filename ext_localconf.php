<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Undkonsorten.' . $_EXTKEY,
	'List',
	array(
		'Event' => 'list, shortList, archive, listByCalendar, show, listAll',
		'Calendar' => 'list',
	    'Location' => 'list',


	),
	// non-cacheable actions
	array(
		'Event' => 'search, archiveSearch',

	)
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:eventmgmt/Configuration/TSconfig/ContentElementWizard.txt">');

// Register upgrade wizard for slugs
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['eventmgmtSlugs']
    = \Undkonsorten\Eventmgmt\Updates\PopulateSlugs::class;
