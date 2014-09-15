<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Undkonsorten.' . $_EXTKEY,
	'List',
	array(
		'Event' => 'list, shortList, archive, listByCalendar, show, listAll',
	
		
	),
	// non-cacheable actions
	array(
		'Event' => 'search, archiveSearch',
		
	)
);

?>