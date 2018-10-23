<?php

$ll = 'LLL:EXT:eventmgmt/Resources/Private/Language/locallang_db.xlf:';
$extensionConfiguration = \Undkonsorten\Addressmgmt\Service\ExtensionConfigurationService::getInstance('eventmgmt');

if($extensionConfiguration->getProperty('feUserAsRelation') == true){

    $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['interface'] = array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, short_title, teaser, description, image, files, start, end, all_day, fee, calendar, register, link, location, location_label, location_text, organizer_fe_user, speaker_fe_user, fe_user, display, category, contact_fe_user ,tx_extbase_type',
    );
     $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['types'] = array(
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

     $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns']['contact_fe_user'] = array(
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

    $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns']['organizer_fe_user'] = array(
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

    $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns']['speaker_fe_user'] = array(
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

    $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns']['fe_user'] = array(
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
