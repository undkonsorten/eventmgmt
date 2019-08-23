<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Undkonsorten.' . 'eventmgmt',
    'List',
    'Event Management'
);

$extensionKey = 'eventmgmt';
$pluginSignature = str_replace('_','',$extensionKey) . '_list';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$extensionKey.'/Configuration/FlexForms/flexform_list.xml');
