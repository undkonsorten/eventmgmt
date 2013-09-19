<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_event_domain_model_event'] = array(
	'ctrl' => $TCA['tx_event_domain_model_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, short_title, teaser, description, image, files, start, end, all_day, fee, primary_calendar, secundary_calendar, register, link, location, organizer',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, subtitle, short_title, teaser, description, image, files, start, end, all_day, fee, primary_calendar, secundary_calendar, register, link, location, organizer,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_event_domain_model_event',
				'foreign_table_where' => 'AND tx_event_domain_model_event.pid=###CURRENT_PID### AND tx_event_domain_model_event.sys_language_uid IN (-1,0)',
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
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'subtitle' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.subtitle',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'short_title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.short_title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'teaser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.teaser',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
		),
		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.image',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_event',
				'show_thumbs' => 1,
				'size' => 5,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'disallowed' => '',
			),
		),
		'files' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.files',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_event',
				'allowed' => '*',
				'disallowed' => 'php',
				'size' => 5,
			),
		),
		'start' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.start',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'end' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.end',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'all_day' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.all_day',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'fee' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.fee',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'primary_calendar' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.primary_calendar',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_event_domain_model_calendar',
				'foreign_field' => 'event',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'secundary_calendar' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.secundary_calendar',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_event_domain_model_calendar',
				'MM' => 'tx_event_event_secundarycalendar_calendar_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_event_domain_model_calendar',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'register' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.register',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_event_domain_model_link',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'link' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.link',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_event_domain_model_link',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'location' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.location',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_people_domain_model_person',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'organizer' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:event/Resources/Private/Language/locallang_db.xlf:tx_event_domain_model_event.organizer',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_people_domain_model_person',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
);

?>