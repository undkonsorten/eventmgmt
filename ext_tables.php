<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'List',
	'Calendar'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_list';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Calendar');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_event_domain_model_calendar', 'EXT:event/Resources/Private/Language/locallang_csh_tx_event_domain_model_calendar.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_event_domain_model_calendar');
$TCA['tx_event_domain_model_calendar'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_calendar',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Calendar.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_event_domain_model_calendar.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_event_domain_model_event', 'EXT:event/Resources/Private/Language/locallang_csh_tx_event_domain_model_event.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_event_domain_model_event');
$TCA['tx_event_domain_model_event'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,subtitle,short_title,teaser,description,image,files,start,end,all_day,fee,primary_calendar,secundary_calendar,register,link,location,organizer,display,category,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Event.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_event_domain_model_event.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_event_domain_model_link', 'EXT:event/Resources/Private/Language/locallang_csh_tx_event_domain_model_link.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_event_domain_model_link');
$TCA['tx_event_domain_model_link'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_link',
		'label' => 'text',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'text,link,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Link.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_event_domain_model_link.gif'
	),
);

$tmp_event_columns = array(

);

t3lib_extMgm::addTCAcolumns('tx_people_domain_model_person',$tmp_event_columns);

$TCA['tx_people_domain_model_person']['columns'][$TCA['tx_people_domain_model_person']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_people_domain_model_person.tx_extbase_type.Tx_Event_Address','Tx_Event_Address');

$TCA['tx_people_domain_model_person']['types']['Tx_Event_Address']['showitem'] = $TCA['tx_people_domain_model_person']['types']['1']['showitem'];
$TCA['tx_people_domain_model_person']['types']['Tx_Event_Address']['showitem'] .= ',--div--;LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_address,';
$TCA['tx_people_domain_model_person']['types']['Tx_Event_Address']['showitem'] .= '';

?>