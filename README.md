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
*

## BE-User settings

* User must be able to change the Tables
  * Address (DE: Adresse)
  * Social Identifiers (DE: Soziales Netzwerk)
  * Link (DE: Internetseite)
  * Relation (Location/Room-Relation)
  * Room
  * Calendar
  * Event


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
