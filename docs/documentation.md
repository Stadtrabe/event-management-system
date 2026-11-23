# Dateistruktur und Aufgaben der Projektdateien

## Projektname

Event Management System

## Zweck dieses Dokuments

Dieses Dokument beschreibt die Struktur des Projekts sowie die Aufgaben der einzelnen Dateien und Verzeichnisse. Ziel ist eine übersichtliche und wartbare Projektarchitektur.

---

# Projektstruktur

# Verzeichnisse

## admin/

Enthält alle Verwaltungsfunktionen für Administratoren.

Geplante Inhalte:

- Benutzerverwaltung
- Rollenverwaltung
- Veranstaltungsverwaltung
- Statistiken und Dashboard

---

## assets/

Enthält statische Dateien.

### css/

Speichert eigene Stylesheets.

### js/

Speichert JavaScript-Dateien für zukünftige Erweiterungen.
Ob es genutzt wird, steht noch nicht fest.

---

## config/

Enthält Konfigurationsdateien der Anwendung.

- Datenbankverbindung
- Umgebungsvariablen

---

## docs/

Enthält Projektdokumentation

---

## includes/

Enthält wiederverwendbare Codebestandteile, die in mehreren Seiten genutzt werden.

- Kopfbereich der Webseite
- Fußbereich der Webseite

---

## pages/

Enthält die eigentlichen Anwendungsseiten.

Beispiele:

- Registrierung
- Login
- Veranstaltungsübersicht
- dashboard

---

# Dateien

## index.php

### Aufgabe

Startseite der Anwendung.

### Funktion

- Einstiegspunkt für Benutzer
- Anzeige allgemeiner Informationen
- Weiterleitung zu wichtigen Bereichen der Anwendung

---

## README.md

### Aufgabe

Projektbeschreibung für GitHub.


---

## .gitignore

### Aufgabe

Ausschluss bestimmter Dateien und Verzeichnisse aus der Versionsverwaltung.


---

## .env

### Aufgabe

Speicherung sensibler Konfigurationsdaten.


### Hinweis

Die Datei wird nicht veröffentlicht.

---

# Dateien im Verzeichnis config

## database.php

### Aufgabe

Aufbau der Datenbankverbindung.

### Funktion

- Verbindung zu MariaDB herstellen
- Fehlerbehandlung konfigurieren
- Standard-Einstellungen für PDO festlegen

---

## env.php

### Aufgabe

Einlesen der Umgebungsvariablen aus der .env-Datei.

### Funktion

- Trennung von Quellcode und Zugangsdaten
- Erhöhung der Sicherheit

---

# Dateien im Verzeichnis includes

## header.php

### Aufgabe

Gemeinsamer Kopfbereich aller Seiten.

### Funktion

- HTML-Grundstruktur
- Bootstrap-Einbindung
- Navigation (Navbar)
- Einbindung eigener CSS-Dateien

### Vorteil

Änderungen müssen nur an einer Stelle vorgenommen werden.

---

## footer.php

### Aufgabe

Gemeinsamer Seitenabschluss.

### Funktion

- Schließen der HTML-Struktur

---

# Dateien im Verzeichnis pages

## register.php

### Aufgabe

Benutzerregistrierung.

### Geplante Funktionen

- Eingabe von Benutzername
- Eingabe der E-Mail-Adresse
- Passwortvergabe
- Passwortbestätigung
- Speicherung des Benutzers in der Datenbank

---

## login.php

### Aufgabe

Benutzeranmeldung.

### Geplante Funktionen

- Anmeldung per E-Mail-Adresse
- Passwortprüfung
- Start einer Benutzersession

---

## events.php

### Aufgabe

Anzeige verfügbarer Veranstaltungen.

### Geplante Funktionen

- Veranstaltungsübersicht
- Suchfunktion
- Anmeldung zu Veranstaltungen
- Interessenmarkierung

---

# Dateien im Verzeichnis assets/css

## style.css

### Aufgabe

Anwendungsspezifisches Design.

### Funktion

- Definition des Farbkonzepts
- Anpassung des Bootstrap-Designs
- Eigene Layout-Elemente

### Aktuelles Farbkonzept

- Primärfarbe: Gold
- Hintergrundfarbe: Weiß
- Kontrast- und Schriftfarbe: Schwarz
- Bootstrap dient als gestalterische Grundlage

---

# Datenbank

## Schema

event_management

### Tabellen

#### users

Speichert Benutzerkonten.

#### events

Speichert Veranstaltungen.

#### event_registration

Speichert Veranstaltungsanmeldungen.

#### interests

Speichert Interessenmarkierungen von Benutzern.

---

# Architekturprinzipien

Die Anwendung basiert auf folgenden Grundprinzipien:

- Trennung von Logik und Darstellung
- Wiederverwendbarkeit durch Includes
- Zentrale Datenbankverwaltung
- Rollenbasierte Zugriffskontrolle
- Sichere Speicherung von Passwörtern
- Versionsverwaltung mittels Git und GitHub
```