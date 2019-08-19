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
