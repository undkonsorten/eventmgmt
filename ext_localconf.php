<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Undkonsorten.' . $_EXTKEY,
	'Calendar',
	array(
		'Event' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Event' => '',
		
	)
);

?>