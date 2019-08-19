<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Undkonsorten.' . 'eventmgmt',
    'List',
    'Event Management'
);


$pluginSignature = str_replace('_','','eventmgmt') . '_list';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:eventmgt/Configuration/FlexForms/flexform_list.xml');
