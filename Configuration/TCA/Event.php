<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$ll = 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:';
$extensionConfiguration = \Undkonsorten\Addressmgmt\Service\ExtensionConfigurationService::getInstance('eventmgmt');

$TCA['tx_eventmgmt_domain_model_event'] = array(
	'ctrl' => $TCA['tx_eventmgmt_domain_model_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, short_title, teaser, description, image, files, start, end, entrytime, all_day, fee, calendar, register, technic, program, link, location, location_relation, location_label, location_text, location_additional, organizer, speaker display, category, contact ,tx_extbase_type',
	),
	'types' => array(
		'tx_eventmgmt_event' => array('showitem' => '
				calendar, title;;title,
				--palette--;' . $ll .'palettes.dates;dates, image, teaser, description, program, link, files,location_additional,
				--palette--;' . $ll .'palettes.registration;registration, technic,
			--div--;' . $ll .'tabs.location,--palette--;;location,
			--div--;' . $ll .'tabs.persons,--palette--;;organizer,--palette--;;contact, speaker,
			--div--;' . $ll .'tabs.categories, category, display,
			--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,hidden,sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, starttime, endtime'
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
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
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
				'wizards' => array(
					'RTE' => array(
						'icon' => 'actions-document-open',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rte',
						),
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
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
					'foreign_types' => array(
						'0' => array(
							'showitem' => '
								--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
								--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
								'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
					),

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
				'size' => 10,
				'eval' => 'datetime, required',
				'checkbox' => 1,
			),
		),
        'entrytime' => array(
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.entrytime',
            'config' => array(
                'type' => 'input',
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
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 0,
					'_DISTANCE' => 2,
				),
			),
		),
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
				'wizards' => array(
					'_PADDING' => 1,
					'_DISTANCE' => 2,
					'_POSITION' => 'bottom',
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'module' => array(
							'name' => 'wizard_edit',
						),
						'icon' => 'actions-open',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'actions-add',
						'params' => array(
							'table' => 'tx_eventmgmt_domain_model_link',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'module' => array(
							'name' => 'wizard_add',
						),
					),
					'suggest' => array(
							'type' => 'suggest',
					),
				),

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
						'iconsInOptionTags' => TRUE,
						'noIconsBelowSelect' => TRUE,
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
	            'wizards' => array(
	                '_PADDING' => 1,
	                'edit' => array(
	                    'type' => 'popup',
	                    'title' => 'Edit',
	                    'module' => array(
	                        'name' => 'wizard_edit',
	                    ),
	                    'icon' => 'actions-open',
	                    'popup_onlyOpenIfSelected' => 1,
	                    'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
	                ),
	                'add' => Array(
	                    'type' => 'script',
	                    'title' => 'Create new',
	                    'icon' => 'actions-add',
	                    'params' => array(
	                        'table' => 'tx_addressmgmt_domain_model_address',
	                        'pid' => '###CURRENT_PID###',
	                        'setValue' => 'prepend'
	                    ),
	                    'module' => array(
	                        'name' => 'wizard_add',
	                    ),
	                    ),
	                'suggest' => array(
	                    'type' => 'suggest',
	                ),
	            ),
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
          'wizards' => array(
              '_PADDING' => 1,
              'edit' => array(
                  'type' => 'popup',
                  'title' => 'Edit',
									'module' => array(
										'name' => 'wizard_edit',
									),
									'icon' => 'actions-open',
                  'popup_onlyOpenIfSelected' => 1,
                  'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
              ),
              'add' => Array(
                  'type' => 'script',
                  'title' => 'Create new',
                  'params' => array(
                      'table' => 'tx_addressmgmt_domain_model_relation',
                      'pid' => '###CURRENT_PID###',
                      'setValue' => 'prepend'
                  ),
									'module' => array(
										'name' => 'wizard_add',
									),
									'icon' => 'actions-add',
                  ),
              //@FIXME why is suggest not working for room and location
              /*'suggest' => array(
                  'type' => 'suggest',
                    'default' => array(
                        'searchWholePhrase' => 1,
                    ),
              ),*/
          ),
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
				'wizards' => array(
						'_PADDING' => 1,
						'edit' => array(
								'type' => 'popup',
								'title' => 'Edit',
								'module' => array(
									'name' => 'wizard_edit',
								),
								'icon' => 'actions-open',
								'popup_onlyOpenIfSelected' => 1,
								'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
						'add' => Array(
								'type' => 'script',
								'title' => 'Create new',
								'icon' => 'actions-add',
								'params' => array(
										'table' => 'tx_addressmgmt_domain_model_address',
										'pid' => '###CURRENT_PID###',
										'setValue' => 'prepend'
								),
								'module' => array(
									'name' => 'wizard_add',
								),
						),
						'suggest' => array(
								'type' => 'suggest',
						),
				),
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
	            'wizards' => array(
	                '_PADDING' => 1,
	                'edit' => array(
	                    'type' => 'popup',
	                    'title' => 'Edit',
	                    'module' => array(
	                        'name' => 'wizard_edit',
	                    ),
	                    'icon' => 'actions-open',
	                    'popup_onlyOpenIfSelected' => 1,
	                    'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
	                ),
	                'add' => Array(
	                    'type' => 'script',
	                    'title' => 'Create new',
	                    'icon' => 'actions-add',
	                    'params' => array(
	                        'table' => 'tx_addressmgmt_domain_model_address',
	                        'pid' => '###CURRENT_PID###',
	                        'setValue' => 'prepend'
	                    ),
	                    'module' => array(
	                        'name' => 'wizard_add',
	                    ),
	                    ),
	                'suggest' => array(
	                    'type' => 'suggest',
	                ),
	            ),
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
				'wizards' => array(
					'_PADDING' => 1,
					'edit' => array(
							'type' => 'popup',
							'title' => 'Edit',
							'module' => array(
								'name' => 'wizard_edit',
							),
							'icon' => 'actions-open',
							'popup_onlyOpenIfSelected' => 1,
							'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
					'add' => Array(
							'type' => 'script',
							'title' => 'Create new',
							'icon' => 'actions-add',
							'params' => array(
									'table' => 'tx_addressmgmt_domain_model_address',
									'pid' => '###CURRENT_PID###',
									'setValue' => 'prepend'
							),
							'module' => array(
								'name' => 'wizard_add',
							),
					),
					'suggest' => array(
							'type' => 'suggest',
					),
				),
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
				'size' => 10,
				'autoSizeMax' => 30,
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
				'size' => 10,
				'autoSizeMax' => 30,
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
);

if($extensionConfiguration->getProperty('feUserAsRelation') == true){
    
    $TCA['tx_eventmgmt_domain_model_event']['interface'] = array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, short_title, teaser, description, image, files, start, end, all_day, fee, calendar, register, link, location, location_label, location_text, organizer_fe_user, speaker_fe_user, fe_user, display, category, contact_fe_user ,tx_extbase_type',
    );
     $TCA['tx_eventmgmt_domain_model_event']['types'] = array(
		'tx_eventmgmt_event' => array('showitem' => '
				calendar, title;;title,
				--palette--;' . $ll .'palettes.dates;dates, image, files, teaser,description, program, link,
				--palette--;' . $ll .'palettes.registration;registration, technic,
			--div--;' . $ll .'tabs.location,location;;location_additional,
		    --div--;' . $ll .'tabs.persons, organizer_fe_user;;organizer_additional,contact_fe_user;;contact_additional, speaker_fe_user, fe_user,
			--div--;' . $ll .'tabs.categories, category, display,
		    --div--;' . $ll .'tabs.roles,,
			--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,hidden,sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, starttime, endtime'
		),
	);

     $TCA['tx_eventmgmt_domain_model_event']['columns']['contact_fe_user'] = array(
         'exclude' => 1,
         'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.contact',
         'config' => array(
             'type' => 'select',
						 'renderType' => 'selectSingle',
             'foreign_table' => 'fe_users',
             'items' => array (
                 array('',0),
             ),
             'size' => 1,
             'minitems' => 0,
             'maxitems' => 1,
             'wizards' => array(
                 '_PADDING' => 1,
                 'edit' => array(
                     'type' => 'popup',
                     'title' => 'Edit',
										 'module' => array(
											 'name' => 'wizard_edit',
										 ),
                     'icon' => 'actions-open',
                     'popup_onlyOpenIfSelected' => 1,
                     'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                 ),
                 'add' => Array(
                     'type' => 'script',
                     'title' => 'Create new',
                     'icon' => 'actions-add',
                     'params' => array(
                         'table' => 'fe_users',
                         'pid' => '###CURRENT_PID###',
                         'setValue' => 'prepend'
                     ),
										 'module' => array(
											 'name' => 'wizard_add',
										 ),
                     ),
                 'suggest' => array(
                     'type' => 'suggest',
                 ),
             ),
         ),
     );

    $TCA['tx_eventmgmt_domain_model_event']['columns']['organizer_fe_user'] = array(
        'exclude' => 1,
        'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.organizer',
        'config' => array(
            'type' => 'select',
						'renderType' => 'selectSingle',
            'foreign_table' => 'fe_users',
            'items' => array (
                array('',0),
            ),
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'wizards' => array(
                '_PADDING' => 1,
                'edit' => array(
                    'type' => 'popup',
                    'title' => 'Edit',
										'module' => array(
											'name' => 'wizard_edit',
										),
                    'icon' => 'actions-open',
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                ),
                'add' => Array(
                    'type' => 'script',
                    'title' => 'Create new',
                    'icon' => 'actions-add',
                    'params' => array(
                        'table' => 'fe_users',
                        'pid' => '###CURRENT_PID###',
                        'setValue' => 'prepend'
                    ),
										'module' => array(
											'name' => 'wizard_add',
										),
                    ),
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        ),
    );

    $TCA['tx_eventmgmt_domain_model_event']['columns']['speaker_fe_user'] = array(
        'exclude' => 1,
        'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.speaker',
        'config' => array(
            'type' => 'select',
						'renderType' => 'selectSingle',
            'foreign_table' => 'fe_users',
            'foreign_table_where' => ' ORDER BY name',
            'MM_insert_fields' => array(
                'tablename' => 'fe_users'
            ),
            'MM' => 'tx_eventmgmt_event_speaker_mm',
            'size' => 10,
            'minitems' => 0,
            'maxitems' => 200,
            'wizards' => array(
                '_PADDING' => 1,
                'edit' => array(
                    'type' => 'popup',
                    'title' => 'Edit',
										'module' => array(
											'name' => 'wizard_edit',
										),
                    'icon' => 'actions-open',
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                ),
                'add' => Array(
                    'type' => 'script',
                    'title' => 'Create new',
                    'icon' => 'actions-add',
                    'params' => array(
                        'table' => 'fe_users',
                        'pid' => '###CURRENT_PID###',
                        'setValue' => 'prepend'
                    ),
										'module' => array(
											'name' => 'wizard_add',
										),
                    ),
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        ),
    );

    $TCA['tx_eventmgmt_domain_model_event']['columns']['fe_user'] = array(
        'exclude' => 1,
        'label' => 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:tx_eventmgmt_domain_model_event.fe_user',
        'config' => array(
            'type' => 'select',
						'renderType' => 'selectSingle',
            'foreign_table' => 'fe_users',
            'MM' => 'tx_eventmgmt_event_feuser_mm',
            'size' => 10,
            'minitems' => 0,
            'maxitems' => 200,
            'wizards' => array(
                '_PADDING' => 1,
                'edit' => array(
                    'type' => 'popup',
                    'title' => 'Edit',
										'module' => array(
											'name' => 'wizard_edit',
										),
                    'icon' => 'actions-open',
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                ),
                'add' => Array(
                    'type' => 'script',
                    'title' => 'Create new',
                    'icon' => 'actions-add',
                    'params' => array(
                        'table' => 'fe_users',
                        'pid' => '###CURRENT_PID###',
                        'setValue' => 'prepend'
                    ),
										'module' => array(
											'name' => 'wizard_add',
										),
                    ),
                'suggest' => array(
                    'type' => 'suggest',
                ),
            ),
        ),
    );
}
if( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) < 7000000){
    $TCA['tx_eventmgmt_domain_model_event']['columns']['description']['config']['wizards']['RTE']['icon'] = 'wizard_rte2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['register']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['register']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['location']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['location']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['organizer']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['organizer']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['location_relation']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['location_relation']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['contact']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['contact']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['speaker']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['speaker']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['contact_fe_user']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['contact_fe_user']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['organizer_fe_user']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['organizer_fe_user']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['speaker_fe_user']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['speaker_fe_user']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['fe_user']['config']['wizards']['add']['icon'] = 'EXT:t3skin/icons/gfx/new_record.gif';
    $TCA['tx_eventmgmt_domain_model_event']['columns']['fe_user']['config']['wizards']['edit']['icon'] = 'edit2.gif';
    
}
?>
