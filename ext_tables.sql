#
# Table structure for table 'tx_eventmgmt_domain_model_calendar'
#
CREATE TABLE tx_eventmgmt_domain_model_calendar (

	events int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	subtitle varchar(255) DEFAULT '' NOT NULL,
	single_pid int(11) unsigned DEFAULT '0' NOT NULL,
	timeslots varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_eventmgmt_domain_model_event'
#
CREATE TABLE tx_eventmgmt_domain_model_event (

	title text DEFAULT '' NOT NULL,
	subtitle text NOT NULL,
	slug varchar(2048),
	short_title varchar(255) DEFAULT '' NOT NULL,
	teaser text NOT NULL,
	description text NOT NULL,
	image int(11) unsigned DEFAULT '0' NOT NULL,
	files int(11) unsigned DEFAULT '0' NOT NULL,
	start int(11) DEFAULT '0' NOT NULL,
	end int(11) DEFAULT '0' NOT NULL,
	all_day tinyint(1) unsigned DEFAULT '0' NOT NULL,
	fee tinytext NOT NULL,
	entrytime int(11) DEFAULT '0' NOT NULL,
	calendar int(11) unsigned DEFAULT '0' NOT NULL,
	content_elements int(11) DEFAULT '0' NOT NULL,
	register int(11) unsigned DEFAULT '0',
	link int(11) unsigned DEFAULT '0',
	location int(11) unsigned DEFAULT '0',
	location_relation int(11) unsigned DEFAULT '0',
	location_alternative text NOT NULL,
	location_closest_city varchar(255) DEFAULT '' NOT NULL,
	organizer int(11) unsigned DEFAULT '0',
	organizer_fe_user int(11) unsigned DEFAULT '0',
	organizer_alternative text NOT NULL,
	contact int(11) unsigned DEFAULT '0',
	contact_fe_user int(11) unsigned DEFAULT '0',
	speaker int(11) unsigned DEFAULT '0',
	speaker_fe_user int(11) unsigned DEFAULT '0',
	fe_user int(11) unsigned DEFAULT '0',
	contact_alternative text NOT NULL,
	display int(11) unsigned DEFAULT '0' NOT NULL,
	category int(11) unsigned DEFAULT '0' NOT NULL,
	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,
	technic text NOT NULL,
	program text NOT NULL,

);

#
# Table structure for table 'tx_eventmgmt_domain_model_link'
#
CREATE TABLE tx_eventmgmt_domain_model_link (

	text varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_eventmgmt_domain_model_timeslot'
#
CREATE TABLE tx_eventmgmt_domain_model_timeslot (

	title varchar(255) DEFAULT '' NOT NULL,
	start int(11) unsigned DEFAULT '0' NOT NULL,
	end int(11) unsigned DEFAULT '0' NOT NULL,
	calendar int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_people_domain_model_person'
#
CREATE TABLE tx_people_domain_model_person (

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_eventmgmt_domain_model_calendar'
#
CREATE TABLE tx_eventmgmt_domain_model_calendar (

	event  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_eventmgmt_event_category_mm'
#
CREATE TABLE tx_eventmgmt_event_category_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	field varchar(50) DEFAULT '' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_eventmgmt_event_speaker_mm'
#
CREATE TABLE tx_eventmgmt_event_speaker_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	tablename varchar(255) DEFAULT '' NOT NULL,
	field varchar(50) DEFAULT '' NOT NULL,


	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_eventmgmt_event_feuser_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	field varchar(50) DEFAULT '' NOT NULL,


	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_eventmgmt_event_calendar_mm'
#
CREATE TABLE tx_eventmgmt_event_calendar_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_eventmgmt_related_event int(11) DEFAULT '0' NOT NULL,
);
