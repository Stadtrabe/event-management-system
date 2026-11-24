# Dateistruktur und Aufgaben der Projektdateien

## Projektname

Event Management System

Lernprojekt:
Umschunlung zum Fachinformatiker für Anwendungsentwicklung

© 11/2026 Frederick Mäueler

## Zweck dieses Dokuments

Dieses Dokument beschreibt die Architektur, Verzeichnisstruktur sowie die Aufgaben der einzelnen Komponenten des Event Management Systems.

Die Anwendung basiert auf dem MVC-Architekturmuster (Model-View-Controller), um eine klare Trennung zwischen Datenzugriff, Anwendungslogik und Darstellung zu gewährleisten.

---

# Architektur

## MVC-Prinzip

Das Projekt verwendet das Model-View-Controller-Muster (MVC).

### Model

Models verwalten den Datenzugriff und die Geschäftslogik.

### View

Views enthalten die Benutzeroberfläche und die Darstellung der Daten.

### Controller

Controller steuern die Geschäftslogik und verarbeiten Benutzereingaben.

---

# Projektstruktur

```text
event-management-system
│   .env
│   .gitignore
│   index.php
│   README.md
│   test_db.php
│   
├───admin
├───assets
│   ├───css
│   │       style.css
│   │       
│   └───js
│           main.js
│           
├───config
│       database.php
│       env.php
│       
├───controllers
│       AdminController.php
│       AuthControllers.php
│       EventControllers.php
│       UserControllers.php
│       
├───docs
│       database_ERD.png
│       documentation.md
│       schema.sql
│       
├───includes
│       footer.php
│       header.php
│       
├───models
│       Event.php
│       EventRegistration.php
│       Interest.php
│       User.php
│       
├───pages
└───views
    ├───admin
    │       dashboard.php
    │       
    ├───auth
    │       login.php
    │       register.php
    │       
    ├───events
    └───user
            events.php
```

---

# Verzeichnisse

## assets/

Enthält statische Dateien.

### assets/css/

Eigene Stylesheets zur Erweiterung und Anpassung von Bootstrap.

### assets/js/

JavaScript-Dateien für zukünftige Erweiterungen.

---

## config/

Enthält Konfigurationsdateien.

### Aufgaben

- Datenbankverbindung
- Umgebungsvariablen
- Zentrale Konfiguration

---

## controllers/

Enthält die Controller der Anwendung.

### AuthController

Verantwortlich für:

- Registrierung
- Login
- Logout

### UserController

Verantwortlich für:

- Benutzerprofil
- Eigene Event-Anmeldungsmarkierungen
- Eigene Event-Interessensmarkierungen

### EventController

Verantwortlich für:

- Eventliste
- Eventdetails
- Eventverwaltung
- Event-Anmeldungsmarkierungen
- Event-Interessenmarkierungen

### AdminController

Verantwortlich für:

- Dashboard
- Benutzerverwaltung
- Rollenverwaltung
- Verwaltungsfunktionen

---

## docs/

Enthält Projektdokumentation.

---

## models/

Enthält den Datenzugriff der Anwendung.

### User.php

Verwaltung von Benutzerdaten.

Funktionen:

- Benutzer suchen
- Benutzer anlegen
- Rollen verwalten

### Event.php

Verwaltung von Veranstaltungen.

Funktionen:

- Veranstaltungen anlegen
- Veranstaltungen bearbeiten
- Veranstaltungen löschen
- Veranstaltungen anzeigen

### EventRegistration.php

Verwaltung von Event-Anmeldungsmarierungen.

Funktionen:

- Anmeldungsmarkierung setrzen
- Anmeldungsmarkierung entfernen

### Interest.php

Verwaltung von Interessenmarkierungen.

Funktionen:

- Interesse markieren
- Interessesmarkierung entfernen

---

## views/

Enthält sämtliche Ansichten der Anwendung.

### views/auth/

Authentifizierung.

#### login.php

Benutzeranmeldung.

#### register.php

Benutzerregistrierung.

---

### views/events/

Veranstaltungsverwaltung und Veranstaltungsübersicht.

#### list.php

Anzeige aller Veranstaltungen.

#### details.php

Anzeige einzelner Veranstaltungsdetails.

#### form.php

Erstellen, Bearbeiten und Löschen von Veranstaltungen.

---

### views/user/

Benutzerbezogene Ansichten.

#### profile.php

Benutzerprofil.

#### my-events.php

Eigene Anmeldungen und Interessen.

---

### views/admin/

Administrationsbereich.

#### dashboard.php

Administrations-Dashboard.

Mögliche Inhalte:

- Anzahl Benutzer
- Anzahl Organisatoren
- Anzahl Veranstaltungen
- Anzahl Anmeldungen
- Anzahl Interessenmarkierungen

---

### layout/

Enthält wiederverwendbare Layout-Komponenten.

#### header.php

- HTML-Grundstruktur
- Bootstrap-Einbindung
- Navigation

#### footer.php

- Abschluss der HTML-Struktur

---

# Rollenmodell

## User

Berechtigungen:

- Registrierung
- Login
- Logout
- Veranstaltungen suchen
- Veranstaltungen ansehen
- Interesse markieren
- Event-Anmeldung markieren
- Eigene Markierungen anzeigen
- Profil bearbeiten

---

## Organizer

Zusätzlich zu den User-Funktionen:

- Eigene Veranstaltungen erstellen
- Eigene Veranstaltungen bearbeiten
- Eigene Veranstaltungen löschen
- Teilnehmerlisten einsehen

---

## Admin

Zusätzlich zu allen anderen Funktionen:

- Dashboard verwalten
- Benutzer verwalten
- Benutzer sperren
- Rollen ändern
- Veranstaltungen verwalten

---

# Datenbank

## Schema

event_management

## Tabellen

### users

Speichert Benutzerkonten.

### events

Speichert Veranstaltungen.

### event_registration

Speichert Veranstaltungsanmeldungen.

### interests

Speichert Interessenmarkierungen von Benutzern.

---

# Sicherheitskonzept

## Passwortsicherheit

Passwörter werden nicht im Klartext gespeichert.

Zur Speicherung wird die PHP-Funktion

```php
password_hash()
```

verwendet.

Die Überprüfung erfolgt mittels

```php
password_verify()
```

---

# Entwicklungswerkzeuge

- PHP 8
- MariaDB
- Bootstrap 5
- Visual Studio Code
- MySQL Workbench
- GitHub