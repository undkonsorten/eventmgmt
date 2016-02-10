<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_eventmgmt_domain_model_calendar'] = array(
	'ctrl' => $TCA['tx_eventmgmt_domain_model_calendar']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, subtitle, events, single_pid',
	),
	'types' => array(
		'1' => array('showitem' => 'name, subtitle, events, single_pid,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_eventmgmt_domain_model_calendar',
				'foreign_table_where' => 'AND tx_eventmgmt_domain_model_calendar.pid=###CURRENT_PID### AND tx_eventmgmt_domain_model_calendar.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_calendar.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'subtitle' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_calendar.subtitle',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'eval' => 'trim'
				),
		),
		'events' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.events',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_eventmgmt_domain_model_event',
				'MM' => 'tx_eventmgmt_event_calendar_mm',
				'MM_opposite_field' => 'calendar',
				'appearance' => array(
						'collapseAll' => 0,
						'levelLinksPosition' => 'top',
						'collapseAll' => TRUE,
						//~ 'showSynchronizationLink' => 1,
						'showPossibleLocalizationRecords' => 1,
						//~ 'showAllLocalizationLink' => 1
				),
				'behaviour' => array(
					'localizationMode' => 'select',
					'localizeChildrenAtParentLocalization' => TRUE,
				),
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 1,
			),
		),
		'single_pid' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:flexform.single_pid',
				'config' => array(
						'type' => 'group',
						'internal_type' => 'db',
						'allowed' => 'pages',
						'size' => '1',
						'maxitems' => '1',
						'minitems' => '0',
						'show_thumbs' => '1',
						'wizards' => array(
								'suggest' => array(
										'type' => 'suggest'
								)
						)
				)
		),
	),
);

?>