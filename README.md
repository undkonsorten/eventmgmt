# Event Management (eventmgmt)



## What does it do?

Event Management is a TYPO3-Calendar extension. You can manage with this extension

* Events (Views: all, upcoming, archive, filter/search, detail)
* Locations (with location and rooms)
* Speakers (FEUser oder Adressmanagement)

## Installation

Installation über den Extension-Manager

### Abhängigkeiten

* Adressmanagement



## Setup, Steps

* Create SysFolder for Events there ....
* Edit the constants. Take care you set the PIDS right. Otherwise filtern and internal links (e.g "Show all events in this location") will not work.

* Create "noramal" thematical categories (e.g. "workshop", "speach" or also regional ones like "Berlin, Hamburg") and
* Dispay categories: if needed also the so called "display categories" (e.g. Microsite 1, Microsite 2). Dispay categories can be used later to show events from diffent calendars in diffenent places/domains on the TYPO3-Installations. The won't be seen in the Frontend.

## Plugin Settings

### Categories

**Normal Categories** are the ones that are shown in the Frontend (e.g. Topics like politics, history or event types like Workshop, Lecture). They can be used as Filters in the Frontend (e.g. filterbox) and in the Plugin as a filter to show/not show in the list.

**Display Categories** are not shown in Frontend and can be used as filters in the Plugin only. That means the are just used to show/hide certain events from the list views.

If you set in the Plugin show/hide categories (in List), the plugin is checking the the *Normal Categories* **and** *Display Categories*.

* plugin.tx_eventmgmt.settings.category.topicUid = 
* plugin.tx_eventmgmt.settings.category.regionUid = 



## BE-User settings

* User must be able to change the Tables
  * Address (DE: Adresse)
  * Social Identifiers (DE: Soziales Netzwerk)
  * Link (DE: Internetseite)
  * Relation (Location/Room-Relation)
  * Room
  * Calendar
  * Event
  * Maybe: Timeslots
* Do not to forget to set also the "Page Content Plugin Options eventmgmt_list" and addressmgmt. Otherwise the BE-User can not set the Plugin Filter Categories

## Settings in Extension Manager

* UIDs for "normal2 categories and display categories
* FE-User or Adressmanagement-Verknüpfungen  for persons relations

# FE User vs Addressmanagement

* Beachte: Hat auch Auswirkungen auf die Templates, wenn der Speaker ein FEUser oder Addresse ist
* Wir haben den Link auf die Einzelansicht Speaker gerade für den FE-Manager in Template gebaut
* Auch ben den Searchfields muss man den die passenden PropertyName einstellen (z.B. speakerFeUser.name bzw. speakerAddress.name)

# Excludefields einrichten




# Creating Events

* Create first a calendar (every event needs a calendar)
* Create a new event



# To Do

* im Template FE-User/AdressSwitch nachvolziehen
