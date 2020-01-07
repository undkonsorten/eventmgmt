<?php

$ll = 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:';
$extensionConfiguration = \Undkonsorten\Addressmgmt\Service\ExtensionConfigurationService::getInstance('eventmgmt');

return [
	'ctrl' => array(
		'title'	=> 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY start DESC',
		'type' => 'tx_extbase_type',
		'versioningWS' => TRUE,
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
		'searchFields' => 'title,subtitle,short_title,teaser,description,image,files,start,end,all_day,fee,calendar,register,link,location,organizer,display,category,',
//		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Event.php',
		'iconfile' => 'EXT:eventmgmt/Resources/Public/Icons/tx_eventmgmt_domain_model_event.png',
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, short_title, teaser, description, image, files, start, end, entrytime, all_day, fee, calendar, register, technic, content_elements, program, link, location, location_relation, location_label, location_text, location_additional, organizer, speaker display, category, contact ,tx_extbase_type',
	),
	'types' => array(
		'tx_eventmgmt_event' => array('showitem' => '
				calendar, title, slug, --palette--;;title,
				--palette--;' . $ll .'palettes.dates;dates, image, teaser, description, program, link, files,location_additional,
				--palette--;' . $ll .'palettes.registration;registration, technic, content_elements,
			--div--;' . $ll .'tabs.location,--palette--;;location,
			--div--;' . $ll .'tabs.persons,--palette--;;organizer,--palette--;;contact, speaker,
			--div--;' . $ll .'tabs.categories, category, display,
			--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,hidden,sys_language_uid, l10n_parent, l10n_diffsource, starttime, endtime'
		),
	),
	'palettes' => array(
		'registration' => array('showitem' => 'register, --linebreak--, fee', 'canNotCollapse' => 1),
		'title' => array('showitem' => 'short_title,subtitle', 'canNotCollapse' => 1),
		'dates' => array('showitem' => 'start,end,entrytime,all_day', 'canNotCollapse' => 1),
		'organizer' => array('showitem' => 'organizer, --linebreak--, organizer_alternative, --linebreak--', 'canNotCollapse' => 1),
		'location' => array('showitem' => 'location_relation,--linebreak--,location, --linebreak--,location_alternative, --linebreak--, location_closest_city', 'canNotCollapse' => 1),
		'contact' => array('showitem' => 'contact,--linebreak--,contact_alternative, --linebreak--', 'canNotCollapse' => 1),
	),
	'columns' => array(
		'pid' => array(
			'config' => array(
				'type' => 'passthrough',
			)
		),
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0)
				),
                'default' => 0
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_eventmgmt_domain_model_event',
				'foreign_table_where' => 'AND tx_eventmgmt_domain_model_event.pid=###CURRENT_PID### AND tx_eventmgmt_domain_model_event.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'allowLanguageSynchronization' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'allowLanguageSynchronization' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.title',
			'config' => array(
				'type' => 'input',
				'size' => 45,
				'eval' => 'trim,required'
			),
		),
		'subtitle' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.subtitle',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 2,
				'eval' => 'trim'
			),
		),
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.slug',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => true,
                    'replacements' => [
                        '/' => '',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite'
            ],
        ],
		'short_title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.short_title',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			),
		),
		'teaser' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.teaser',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 8,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 10,
				'eval' => 'trim',
                'enableRichtext' => true,
			),
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
						'collapseAll' => TRUE,
					),
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                        ],
                    ],
				),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'files' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.files',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'files',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:media.addFileReference',
						'headerThumbnail' => array(
							'width' => 32,
							'height' => 32,
						),
						'collapseAll' => TRUE,
						'expandSingle' => TRUE,
					),
				)
			),
		),
		'start' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.start',
			'config' => array(
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 10,
				'eval' => 'datetime, required',
				'checkbox' => 1,
				'default' => time(),
			),
		),
		'end' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.end',
			'config' => array(
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 10,
				'eval' => 'datetime, required',
				'checkbox' => 1,
			),
		),
		'entrytime' => array(
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.entrytime',
			'config' => array(
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 10,
				'eval' => 'time',
				'checkbox' => 1,
			),
		),
		'all_day' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.all_day',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'fee' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.fee',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 3,
				'eval' => 'trim'
			),
		),
		'calendar' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.calendar',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array (
					array('',0),
				),
				'foreign_table' => 'tx_eventmgmt_domain_model_calendar',
				'foreign_table_where' => 'AND tx_eventmgmt_domain_model_calendar.hidden=0 ORDER BY tx_eventmgmt_domain_model_calendar.name',
				'MM' => 'tx_eventmgmt_event_calendar_mm',
				'maxitems'      => 1,
			),
		),
        'content_elements' => [
            'exclude' => true,
            'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.content_elements',
            'config' => [
                'type' => 'inline',
                'allowed' => 'tt_content',
                'foreign_table' => 'tt_content',
                'foreign_sortby' => 'sorting',
                'foreign_field' => 'tx_eventmgmt_related_event',
                'minitems' => 0,
                'maxitems' => 99,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'levelLinksPosition' => 'bottom',
                    'useSortable' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                    'enabledControls' => [
                        'info' => false,
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
		'register' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.register',
			'config' =>  $extensionConfiguration->getProperty('inlineForRegister') ?

				array(
					'type' => 'inline',
					'foreign_table' => 'tx_eventmgmt_domain_model_link',
					'minitems' => 0,
					'maxitems' => 1,
					'appearance' => array(
						'collapseAll' => 0,
						'levelLinksPosition' => 'top',
						'collapseAll' => TRUE,
						'showSynchronizationLink' => 1,
						'showPossibleLocalizationRecords' => 1,
						'showAllLocalizationLink' => 1
					),
				) :
				array(
					'type' => 'select',
					'renderType' => 'selectSingle',
					'foreign_table' => 'tx_eventmgmt_domain_model_link',
					'minitems' => 0,
					'maxitems' => 1,
					'items' => array(
						array('',''),
					),
                    'fieldControl' => [
                        'addRecord' => [
                            'options' => [
                                'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                                'table' => 'tx_eventmgmt_domain_model_link',
                                'pid' => '###CURRENT_PID###',
                                'setValue' => 'prepend'
                            ],
                        ],
                        'editPopup' => [
                            'disabled' => false,
                            'options' => [
                                'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.edit',
                                'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                            ]
                        ]
                    ]
				),
		),
		'link' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.link',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_eventmgmt_domain_model_link',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'collapseAll' => TRUE,
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'tx_extbase_type' => array(
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.type',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'default' => 'tx_eventmgmt_event',
				'items' => array(
					array('LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.typeLabel', 'tx_eventmgmt_event','EXT:eventmgmt/Resources/Public/Icons/tx_eventmgmt_domain_model_event.png'),
				),
			),
		),
		'location' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.location',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_addressmgmt_domain_model_address',
				'size' => 1,
				'prepend_tname' => FALSE,
				'minitems' => 0,
				'maxitems' => 1,
                'fieldControl' => [
                    'addRecord' => [
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                            'table' => 'tx_addressmgmt_domain_model_address',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                    ],
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.edit',
                            'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ]
                    ]
                ]
			),
		),
		'location_relation' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.location_relation',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_addressmgmt_domain_model_relation',
				'itemsProcFunc' => 'Undkonsorten\Eventmgmt\Utility\EventLocations->getLocations',
				'items' => array (
					array('',0),
				),
				'minitems' => 0,
				'maxitems' => 1,
                'fieldControl' => [
                    'addRecord' => [
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                            'table' => 'tx_addressmgmt_domain_model_relation',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                    ],
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.edit',
                            'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ]
                    ]
                ]
			),
		),
		'location_alternative' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.location_alternative',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 4,
				'eval' => 'trim'
			),
		),
		'location_closest_city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addressmgmt/Resources/Private/Language/locallang_db.xlf:tx_addressbook_domain_model_address.closest_city',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim'
			),
		),
		'organizer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.organizer',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_addressmgmt_domain_model_address',
				'size' => 1,
				'prepend_tname' => FALSE,
				'minitems' => 0,
				'maxitems' => 1,
                'fieldControl' => [
                    'addRecord' => [
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                            'table' => 'tx_addressmgmt_domain_model_address',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                    ],
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.edit',
                            'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ]
                    ]
                ]
			),
		),
		'organizer_alternative' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.organizer_alternative',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 4,
				'eval' => 'trim'
			),
		),
		'speaker' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.speaker',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_addressmgmt_domain_model_address',
				'foreign_table' => 'tx_addressmgmt_domain_model_address',
				'MM_insert_fields' => array(
					'tablename' => 'tx_addressmgmt_domain_model_address'
				),
				'MM' => 'tx_eventmgmt_event_speaker_mm',
				'size' => 10,
				'prepend_tname' => FALSE,
				'minitems' => 0,
				'maxitems' => 200,
				'filter' => array(
					array(
						'userFunc' => 'Undkonsorten\Eventmgmt\Utility\TcaFilterUtility->filterByType',
						'parameters' => array(
							'type' => \Undkonsorten\Addressmgmt\Domain\Model\AddressInterface::PERSON,
						),
					),
				),
                'fieldControl' => [
                    'addRecord' => [
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                            'table' => 'tx_addressmgmt_domain_model_address',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                    ],
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.edit',
                            'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ]
                    ]
                ]
			),
		),
		'contact' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.contact',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_addressmgmt_domain_model_address',
				'size' => 1,
				'prepend_tname' => FALSE,
				'minitems' => 0,
				'maxitems' => 1,
				'filter' => array(
					array(
						'userFunc' => 'Undkonsorten\Eventmgmt\Utility\TcaFilterUtility->filterByType',
						'parameters' => array(
							'type' => \Undkonsorten\Addressmgmt\Domain\Model\AddressInterface::PERSON,
						),
					),
				),
                'fieldControl' => [
                    'addRecord' => [
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                            'table' => 'tx_addressmgmt_domain_model_address',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                    ],
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.edit',
                            'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ]
                    ]
                ]
			),
		),
		'contact_alternative' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.contact_alternative',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 4,
				'eval' => 'trim'
			),
		),
		'display' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.display',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectTree',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'parentField' => 'parent',
					// @todo check which is the correct line
					'rootUid' => $settings['displayCategory'],
					'rootUid' => $extensionConfiguration->getProperty('displayCategory'),
					'appearance' => array(
						'expandAll' => TRUE,
						'showHeader' => TRUE,
					),
				),
				'foreign_table' => 'sys_category',
				'foreign_table_where' => 'AND sys_category.hidden=0 AND sys_category.sys_language_uid IN (-1,0)',
				'MM' => 'tx_eventmgmt_event_category_mm',
				'MM_match_fields' => array(
					'field' => 'display'
				),
				'size' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
			),
		),
		'category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.category',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectTree',
				'foreign_table' => 'sys_category',
				'foreign_table_where' => 'AND sys_category.hidden=0 AND sys_category.sys_language_uid IN (-1,0)',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'parentField' => 'parent',
					'rootUid' => $extensionConfiguration->getProperty('normalCategory'),
					'appearance' => array(
						'expandAll' => TRUE,
						'showHeader' => TRUE,
					),
				),
				'MM' => 'tx_eventmgmt_event_category_mm',
				'MM_match_fields' => array(
					'field' => 'category'
				),
				'size' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
			),
		),
		'technic' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.technic',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 8,
				'eval' => 'trim'
			),
		),
		'program' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.program',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 8,
				'eval' => 'trim'
			),
		),
	),
];
