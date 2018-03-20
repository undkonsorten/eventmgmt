<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Undkonsorten.' . $_EXTKEY,
        'user',	 // Make module a submodule of 'tools'
        'export',	// Submodule key
        '',						// Position
        array(
            'Event' => 'exportPreview, export, ',
        ),
        array(
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_export.xlf',
        )
        );

}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Undkonsorten.' . $_EXTKEY,
	'List',
	'Event Management'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_list';


$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Eventmgmt');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/BasicCss', 'EventmgmtBasicCss');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/FrontendUser', 'FeUser');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_eventmgmt_domain_model_calendar', 'EXT:eventmgmt/Resources/Private/Language/locallang_csh_tx_eventmgmt_domain_model_calendar.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eventmgmt_domain_model_calendar');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_eventmgmt_domain_model_event', 'EXT:eventmgmt/Resources/Private/Language/locallang_csh_tx_eventmgmt_domain_model_event.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eventmgmt_domain_model_event');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_eventmgmt_domain_model_link', 'EXT:eventmgmt/Resources/Private/Language/locallang_csh_tx_eventmgmt_domain_model_link.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eventmgmt_domain_model_link');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_eventmgmt_domain_model_timeslot', 'EXT:eventmgmt/Resources/Private/Language/locallang_csh_tx_eventmgmt_domain_model_timeslot.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eventmgmt_domain_model_timeslot');

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
	\TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
	'tx-eventmgmt-uk',
	\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
	['source' => 'EXT:eventmgmt/Resources/Public/Icons/uk.svg']
);