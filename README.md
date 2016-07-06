# TYPO3: Event Management Extension (eventmgmt)

* EXT: Event Management
* Extension Key: eventmgmt
* Language: en
* Version: 1.0.0
* Keywords: calendar, events, conference, typo3
* Copyright 2006-2016, undkonsorten (www.undkonsorten.com)

---

# Table of Contents
* [What does it do?](#what-does-it-do-)
* [Screenshots](#screenshots)
* [Short Manual](#short-manual)
* [Manual](#manual)
  * [Installation](#installation)
  * [First Steps](#first-steps)
  * [Extension Manager](#typo3-extension-manager)
  * [Categories](#categories)
  * [Installation](#installation)

* [Plugin Settings](#plugin-setting)

---

## What does it do?

The TYPO3 **Event Management (eventmgmt)** extension for handling **calendars** and **events** or **conferences**.

It can be used to show events that happen over the year or also to handle a conference with days, timeslots, locations and rooms.

The events can be **searched** and **filtered** in the frontend by (two) categories. Together with the extension Addressmgmt it can as well handle **speakers**, **organizers**, **contact persons** and **geo locations**. Frondend users are also able to edit their own events.

### TYPO3 Event Management can handle
* events
* (multiple) calendars
* (multiple) categories for filtering and displaying
* speakers
* organizers
* contact persons
* locations
* locations with multiple rooms
* timeslots

### Eventmgmt has the following views
* upcoming events (List and ShortList)
* past events (archive)
* all events (useful for a conference where you do not want the events to disappear)
* events by calendar (upcoming??)
* events by speaker

Most of the views come along with a built in search and filter option.

## Screenshots

  <figcaption><h4>List view with filters for naturschutzfonds.de</h4>
  <img src="Documentation/Images/Screenshots/List-View-FE-nsf.png" style="border: 1px solid silver;padding:.5em;">
</figure>
<hr>

<figcaption><h4>List view with filters for <a href="http://www.regionen-mit-peb.de/veranstaltungen/">regionen-mit-peb.de</a></h4></figcaption>
  <img src="Documentation/Images/Screenshots/List-View-FE-rmp.png" style="border: 1px solid silver;padding:.5em;">

<hr>

  <h4>List view with search and filters for <a href="https://www.chorfest.de/programm/">chorfest.de</a><h4></figcaption>
  <img src="Documentation/Images/Screenshots/List-View-FE-chorfest-600.png" style="border: 1px solid silver;padding:.5em;">

<hr>



## Short Manual

This are the most important steps to make the Extension Eventmgmt running

* [Install](#installation) the extensions Addressmgmt and Eventmgmt
* Include the static TypoScript templates for
  * Addressbook (addressmgmt)
  * Event (eventmgmt)
  * EventBasisCss (eventmgmt)
* Create a TYPO3 SysFolder for Events. There
  * create a calendar
  * create an event
* Insert on your page the new content element *Plugin*  plugin with the Type *Event Management*

---

## Manual

### Installation

* Get the extensions **Addressmgmt and Eventmgmt** from the TYPO3 extension manager, Composer or clone it from GitHub
* **Dependencies**: Addressmgmt


### TYPO3 Extension Manager

The Extension Manager provides the following settings for the Eventmgmt extension:
 * Uid of display category [basic.displayCategory]
 * Uid of normal categories [basic.normalCategory]
 * IRRE for registration link [basic.inlineForRegister] (if not set you could forward to your contact form)
 * Use FeUser as person relation [basic.feUserAsRelation] (instead of Adressmgmt, needed for frontend editing of events)
 * Deactivate automatically tinymcE JS loading [basic.deactivateTinyMceJs] (tinymcE is only need for frontend editing for events with RTE)


### Setting up your first events

To set up the first events create in a SysFolder

* a new calendar (because every event need a calendar)
* a new event

### The Calendar

Each event can have only one calendar (required field).
Multiple **[timeslots](#timeslots)** can be connected to the calendar.

<figcaption><h4>Backend: Calendar Item</h4></figcaption>
<img src="Documentation/Images/Screenshots/Backend/Calendar-item.png">

#### Timeslots

Timeslots can be created within the calendar. The define a begin and end end time of the slot.

The frontend view *"List: by Timeslots"* will display all the available timeslots of the calendars which are selected in the plugin.

### The Event

And event dataset has realations with
* one calendar (required field)
* (multiple) categories (for filtering and displaying)
* speakers
* organizers
* contact persons
* locations / locations with multiple rooms


### Categories

Create parent categories (TYPO3 SysCategories) for your calendar if needed (e.g. 1: Events Topics, 2: Event Types)

If you want to use the **categories for filtering** the events in the frontend you also have to set the values for this parent categories in the TypoScript constants with the TYPO3 Constant Editor.

<pre>
plugin.tx_eventmgmt.settings.category.typeUid = 1
plugin.tx_eventmgmt.settings.category.regionUid = 2
plugin.tx_eventmgmt.settings.category.topicUid = 3
</pre>

Create categories like (1.1: TYPO3, 1b: WordPress, 1.2: GitHub; 2.1: Panel, 2.2: Workshop ...) as a child of the topic and/or event type categories

If you need also create a parent category for display categories (e.g. Public Events, Internal Events).

Edit the constants. Take care you set the PIDS right. Otherwise filtern and internal links (e.g "Show all events in this location") will not work.

**Normal Categories** are the ones that are shown in the Frontend (e.g. Topics like politics, history or event types like Workshop, Lecture). They can be used as Filters in the Frontend (e.g. filterbox) and in the Plugin as a filter to show/not show in the list.

**Display Categories** are not shown in Frontend and can be used as filters in the plugin only. That means the are just used to show/hide certain events from the list views.

If you set in the Plugin show/hide categories (in List), the plugin is checking the the *Normal Categories* **and** *Display Categories*.

* plugin.tx_eventmgmt.settings.category.topicUid =
* plugin.tx_eventmgmt.settings.category.regionUid =


* Create "noramal" thematical categories (e.g. "workshop", "speach" or also regional ones like "Berlin, Hamburg") and
* Dispay categories: if needed also the so called "display categories" (e.g. Microsite 1, Microsite 2). Dispay categories can be used later to show events from diffent calendars in diffenent places/domains on the TYPO3-Installations. The won't be seen in the Frontend.

### Locations

Eventmgmt provides 3 different types to edit your event locations. You can...
* 1: either just use the textarea "Location Alternative" for easy copy pasting
* 2: use a relation to and the Addressmgmt table (type: location) or
* 3: use a the location-room-relation (if you have a location with many rooms)

You can switch the available location fields available for the editors by including the XXX PageTs or by the settings in the Extension Manager (@Todo !) or hide the excludefields by PageTs, UserTs or user settings.

#### Location-Room-Relation

<img src="Documentation/Images/Screenshots/Backend/location-room-relation.png" alt="Location-Room-Relation">

---

With the location room relation you first create a location (e.g. TU Berlin, FU Berlin) and add rooms to this location. This is a bit tricky for the editors.

Rooms can be also directly added to Address items with the type *location* (see image below).

##### Address with multiple rooms

<img src="Documentation/Images/Screenshots/Backend/location-room.png" alt="Address: Location with room" style="border: 1px solid silver;padding:.5em;">

---

#### Location as address item (without rooms)

If you events happen always on different places it is better to use the second option – an **relation between the event and an Address item**. The "Location Alternative" can be still used to define the room as an additional information.

#### Location Alternative/Additional field

<img src="Documentation/Images/Screenshots/Backend/location-alternative.png" alt="Location alternative field" style="border: 1px solid silver;padding:.5em;">

The content of the **Alternative/additional location** field will always be shown in the Frontend. It can also by used by lazy editors for copy pasting the address or additional information.

## Plugin Settings

### Views

The Event Management Plugin has the following views

#### Shortlist: upcoming events

<img src="Documentation/Images/Screenshots/shortList-View-FE-nsf-400.png" alt="Shortlist: upcoming events" style="border: 1px solid silver;padding:.5em;">

This template shows all the upcoming events. It does not provide a search and filter functionality. This view could be used for example for a homepage to show the upcoming 5 events.

---

#### List: all upcoming

<img src="Documentation/Images/Screenshots/List-View-FE-rmp.png" alt="view: List all upcoming" style="border: 1px solid silver;padding:.5em;">

This template would be used for the main events page of your website. It can comes along with a search and filter functionality.

#### List: archive/past events

This list can be used for past events as an event archive. I also comes along with a search and filter functionality.

#### List: by Timeslots

This view provides a (cached) filter for timeslots (see below)

<img src="Documentation/Images/Screenshots/List-View-FE-chorfest-600.png" alt="list view with search and filters" style="border: 1px solid silver;padding:.5em;">

---

#### Detail view

This view **can** be used for displaying the single event. But also the list templates are able to display a singl event.

#### Other views

* List: upcoming events grouped by calendar
* List: all events
* List: all calendars
* List: by speaker

## Administration

Settings for the Events Management Plugin can be found
* in the Extension Manager
* in the Constant Editor (TypoScript Constants)
* via PageTS
* via TypoScript-Setup
* in the Plugin (Flexforms)

### TypoScript

Do not forget to include the static TypoScript templates:
* Addressbook (addressmgmt)
* Event (eventmgmt)
* EventBasisCss (eventmgmt) – optional for basic styling

Since the template is build with Fluid you can also create you own templates and updating your template via the Constant Editor > PLUGIN.TX_EVENTMGMT (see below).

<img src="Documentation/Images/Screenshots/Backend/constant-editor.png" alt="Contant Editor" style="border: 1px solid silver;padding:.5em;">

### Settings in the Extension Manager

* UIDs for "normal2 categories and display categories
* FE-User or Adressmanagement-Verknüpfungen  for persons relations

### BE-User settings

For using the Event Management extension you have to set the following rights to you BE Users:

* Address (DE: Adresse)
* Social Identifiers (DE: Soziales Netzwerk)
* Link (DE: Internetseite)
* Relation (Location/Room-Relation)
* Room
* Calendar
* Event
* Maybe: Timeslots

Do not to forget to set also the "Page Content Plugin Options eventmgmt_list" and addressmgmt. Otherwise the BE-User can not set the Plugin Filter Categories


## FE User vs Addressmanagement

* Beachte: Hat auch Auswirkungen auf die Templates, wenn der Speaker ein FEUser oder Addresse ist
* Wir haben den Link auf die Einzelansicht Speaker gerade für den FE-Manager in Template gebaut
* Auch ben den Searchfields muss man den die passenden PropertyName einstellen (z.B. speakerFeUser.name bzw. speakerAddress.name)

# Excludefields einrichten



## To Do / Backlog

* im Template FE-User/AdressSwitch nachvollziehen
* select address>location outomaticly instead of person/organisation (creates bugs)
