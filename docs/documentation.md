# Technische Dokumentation

## Event Management System

**Lernprojekt im Rahmen der Umschulung zum Fachinformatiker für Anwendungsentwicklung**

© 11/2026 Frederick Mäueler

---

# 1. Projektbeschreibung

Das Event Management System ist eine lokal ausgeführte Webanwendung zur Erstellung und Verwaltung von Veranstaltungen.

Registrierte Benutzer können Veranstaltungen einsehen, Interesse an Veranstaltungen bekunden und sich für Veranstaltungen anmelden.

Die Anwendung unterscheidet zwischen den Rollen **User**, **Organizer** und **Admin**. Abhängig von der jeweiligen Rolle stehen unterschiedliche Funktionen zur Verfügung.

Die Anwendung wurde nach dem **Model-View-Controller-Architekturmuster (MVC)** entwickelt.

---

# 2. Projektziel

Ziel des Projekts ist die Entwicklung eines webbasierten Veranstaltungsmanagementsystems mit:

- Benutzerregistrierung
- Benutzerauthentifizierung
- Rollenverwaltung
- Profilverwaltung
- Veranstaltungsverwaltung
- Interessenmarkierungen
- Veranstaltungsanmeldungen
- persönlicher Veranstaltungsübersicht
- Administrationsbereich
- rollenbasierter Zugriffskontrolle

Der Schwerpunkt liegt auf einer MVC-Softwarestruktur, relationaler Datenmodellierung, sicherer Verarbeitung von Benutzereingaben und einer nachvollziehbaren Trennung der Verantwortlichkeiten.

---

# 3. Verwendete Technologien

## Backend

- PHP 8
- PDO
- MariaDB

## Frontend

- HTML5
- CSS3
- Bootstrap 5
- Bootstrap Icons

## Entwicklungswerkzeuge

- Visual Studio Code
- MySQL Workbench
- XAMPP

---

# 4. Architektur

## 4.1 MVC-Prinzip

Die Anwendung orientiert sich am **Model-View-Controller-Muster (MVC)**.

Dadurch werden Datenzugriff, Anwendungslogik und Darstellung voneinander getrennt.

### Model

Models übernehmen hauptsächlich den Zugriff auf die Datenbank.

### View

Views übernehmen die Darstellung der Anwendung im Browser.

Die Views enthalten keine direkten SQL-Abfragen.

### Controller

Controller vermitteln zwischen Models und Views.

Sie sind unter anderem verantwortlich für:

- Verarbeitung von Benutzereingaben
- Validierung
- Berechtigungsprüfung
- Aufruf der Models
- Auswahl der passenden View
- Weiterleitungen

---

# 5. Front Controller

Die zentrale index.php dient als Front Controller.

Anfragen werden über den Parameter page an die zuständigen Controller weitergeleitet.

Der Front Controller erstellt außerdem die benötigten Model- und Controller-Objekte und stellt deren Abhängigkeiten bereit.

Dadurch müssen Views nicht direkt aufgerufen werden.

Der grundlegende Request-Ablauf lautet:

**Browser → index.php → Controller → Model → Datenbank → Controller → View**

---

# 6. Projektstruktur

event-management-system/

- .env
- .gitignore
- index.php (front controller)
- README.md

## assets/

### css/

- style.css

Enthält das individuelle Design der Anwendung.

Das verwendete Farbkonzept besteht hauptsächlich aus:

- Weiß als Hintergrundfarbe
- Gold als Primär- und Akzentfarbe
- Schwarz als Kontrast- und Schriftfarbe

### img/

Enthält grafische Ressourcen für die Fehelrseiten


---

## config/

### database.php

Erstellt die zentrale PDO-Datenbankverbindung.

Die Verbindung wird anschließend den benötigten Models zur Verfügung gestellt.

### env.php

Liest lokale Konfigurationsdaten aus der .env-Datei.

---

## controllers/

### AuthController.php

Verantwortlich für:

- Registrierung
- Login
- Logout
- Passwortprüfung
- Aufbau und Beenden der Session
- Weiterleitung nach erfolgreicher Authentifizierung

### UserController.php

Verantwortlich für:

- Benutzerprofil
- Bearbeitung der Profildaten
- optionale Passwortänderung
- persönliche Event-Anmeldungen
- persönliche Interessenmarkierungen
- Ansicht „Meine Veranstaltungen“

### EventController.php

Verantwortlich für:

- Eventliste
- Eventdetails
- Erstellen von Veranstaltungen
- Bearbeiten von Veranstaltungen
- Interessenmarkierungen
- Veranstaltungsanmeldungen
- Berechtigungsprüfung für Eventverwaltung
- Navigation zwischen Eventliste, Detailseite und persönlicher Eventübersicht

### AdminController.php

Verantwortlich für:

- Admin-Dashboard
- Benutzerübersicht
- Rollenverwaltung
- Statusverwaltung
- Admin-Zugriffsschutz

---

# 7. Models

## User.php

Das User-Model verwaltet Benutzerkonten und deren Datenbankzugriffe.

Aufgaben:

- Benutzer anhand der E-Mail-Adresse suchen
- Benutzer anhand der ID suchen
- Benutzer registrieren
- alle Benutzer abrufen
- Rolle und Status ändern
- Profildaten aktualisieren
- Passwort aktualisieren
- Benutzerstatistiken für das Admin-Dashboard bereitstellen

---

## Event.php

Das Event-Model verwaltet Veranstaltungen.

Aufgaben:

- alle Veranstaltungen abrufen
- einzelne Veranstaltung anhand der ID abrufen
- Veranstaltungen erstellen
- Veranstaltungen bearbeiten
- Veranstaltungsanzahl ermitteln
- Veranstalterdaten über eine relationale Verknüpfung abrufen

---

## Interest.php

Das Interest-Model verwaltet Interessenmarkierungen.

Aufgaben:

- Interesse setzen
- Interesse entfernen
- vorhandene Interessenmarkierung prüfen
- Interessen eines Benutzers abrufen
- vollständige interessierte Veranstaltungen eines Benutzers abrufen
- Anzahl der Interessenten einer Veranstaltung ermitteln

---

## EventRegistration.php

Das EventRegistration-Model verwaltet Veranstaltungsanmeldungen.

Aufgaben:

- Anmeldung setzen
- Anmeldung entfernen
- bestehende Anmeldung prüfen
- Anmeldungen eines Benutzers abrufen
- vollständige angemeldete Veranstaltungen eines Benutzers abrufen
- Anzahl der Anmeldungen einer Veranstaltung ermitteln

Beim Anmelden für eine Veranstaltung wird gleichzeitig eine eventuell vorhandene Interessenmarkierung entfernt.

Diese beiden Datenbankoperationen werden innerhalb einer Transaktion durchgeführt.

Dadurch gilt:

**Entweder werden beide Operationen erfolgreich ausgeführt oder keine der beiden Änderungen wird dauerhaft übernommen.**

---

# 8. Views

## views/layout/

### header.php

Enthält:

- HTML-Grundstruktur
- Bootstrap-Einbindung
- Bootstrap Icons
- eigenes Stylesheet
- Navigation
- sessionsabhängige Navigation
- rollenabhängige Admin-Navigation

### footer.php

Beendet die gemeinsame HTML-Struktur der Views.

---

## views/auth/

### register.php

Darstellung der Benutzerregistrierung.

Enthält Eingabefelder für:

- Benutzername
- E-Mail-Adresse
- Passwort
- Passwortbestätigung

### login.php

Darstellung der Benutzeranmeldung.

---

## views/events/

### list.php

Zeigt alle vorhandenen Veranstaltungen tabellarisch an.

Dargestellt werden unter anderem:

- Titel
- Beginn
- Ende
- Veranstalter
- Erstellungsdatum
- Aktionen

Benutzer können direkt aus der Liste:

- Details öffnen
- Interesse setzen oder entfernen
- Anmeldung setzen oder stornieren

### details.php

Zeigt sämtliche Informationen einer einzelnen Veranstaltung.

Zusätzlich werden angezeigt:

- Anzahl der Interessenmarkierungen
- Anzahl der Anmeldungen
- aktueller Interessenstatus des Benutzers
- aktueller Anmeldestatus des Benutzers

Organizer können eigene Veranstaltungen bearbeiten.

Admins können Veranstaltungen unabhängig vom Veranstalter bearbeiten.

### form.php

Gemeinsame View zum:

- Erstellen einer Veranstaltung
- Bearbeiten einer Veranstaltung

Dadurch muss kein separates Formular für beide Vorgänge gepflegt werden.

---

## views/user/

### profile.php

Zeigt die persönlichen Kontodaten des eingeloggten Benutzers.

Angezeigt werden unter anderem:

- Benutzer-ID
- Rolle
- Status
- Registrierungsdatum

Bearbeitet werden können:

- Benutzername
- E-Mail-Adresse
- Passwort

Rolle und Status können vom Benutzer nicht selbst verändert werden.

Zusätzlich enthält das Profil einen Link zu „Meine Veranstaltungen“.

### my-events.php

Zeigt zwei persönliche Veranstaltungslisten:

- angemeldete Veranstaltungen
- als interessant markierte Veranstaltungen

Die Darstellung orientiert sich an der allgemeinen Eventliste.

Auch dort können Anmeldungen und Interessen direkt verwaltet werden.

---

## views/admin/

### dashboard.php

Das Admin-Dashboard zeigt zentrale Kennzahlen des Systems.

Dazu gehören:

- Gesamtzahl der Benutzer
- Anzahl der User
- Anzahl der Organizer
- Anzahl der Admins
- Gesamtzahl der Veranstaltungen

Zusätzlich bietet das Dashboard Zugriff auf die Benutzerverwaltung.

### userList.php

Zeigt alle Benutzer des Systems.

Administratoren können Rolle und Status anderer Benutzer verändern.

Der eigene Admin-Account ist innerhalb dieser Verwaltung vor versehentlichen Änderungen geschützt.

---

## views/errors/

Die Anwendung verwendet eigene Views für HTTP-Fehler.

### 400.php

**400 Bad Request**

Wird verwendet, wenn eine Anfrage ungültige oder unvollständige Parameter enthält.

### 403.php

**403 Forbidden**

Wird verwendet, wenn ein authentifizierter Benutzer versucht, auf eine Funktion ohne ausreichende Berechtigung zuzugreifen.

### 404.php

**404 Not Found**

Wird verwendet, wenn eine angeforderte Ressource, beispielsweise eine Veranstaltung, nicht existiert.

---

# 9. Rollenmodell

## User

Ein normaler Benutzer kann:

- sich registrieren
- sich anmelden
- sich abmelden
- Veranstaltungen anzeigen
- Veranstaltungsdetails öffnen
- Interesse an einer Veranstaltung markieren
- Interessenmarkierung entfernen
- sich für eine Veranstaltung anmelden
- Anmeldung stornieren
- eigene Interessen anzeigen
- eigene Anmeldungen anzeigen
- Profildaten bearbeiten
- Passwort ändern

---

## Organizer

Ein Organizer besitzt zusätzlich zu den normalen User-Funktionen folgende Berechtigungen:

- eigene Veranstaltungen erstellen
- eigene Veranstaltungen bearbeiten

Ein Organizer darf Veranstaltungen anderer Organizer nicht bearbeiten.

---

## Admin

Ein Admin besitzt zusätzlich zu den Rechten vpn Organizer und User administrative Berechtigungen.

Dazu gehören:

- Zugriff auf das Admin-Dashboard
- Benutzer anzeigen
- Benutzerrollen ändern
- Benutzerstatus ändern
- Veranstaltungen administrativ bearbeiten
- Systemstatistiken einsehen

---

# 10. Benutzerstatus

Neben der Benutzerrolle besitzt ein Benutzer einen Status.

Verwendete Statuswerte:

- Überprüfung
- bestätigt
- Bearbeitung
- abgelehnt

Die Trennung zwischen Rolle und Status ermöglicht eine spätere Erweiterung der Berechtigungslogik, ohne dafür das grundlegende Rollenmodell verändern zu müssen.

---

# 11. Datenbank

## Schema

event_management

Die Datenbank wurde zunächst in MySQL Workbench als EER-Diagramm modelliert und anschließend per Forward Engineering erzeugt.

---

## Tabelle users

Speichert Benutzerkonten.

Wichtige Informationen:

- Benutzer-ID
- Benutzername
- E-Mail-Adresse
- Passwort-Hash
- Rolle
- Status
- Erstellungsdatum

Die E-Mail-Adresse besitzt einen Unique Constraint.

---

## Tabelle events

Speichert Veranstaltungen.

Enthält unter anderem:

- Event-ID
- Titel
- Veranstaltungsort
- Beschreibung
- Beginn
- Ende
- Organizer-ID
- Erstellungsdatum

Die Organizer-ID ist ein Fremdschlüssel auf die Benutzertabelle.

---

## Tabelle event_registration

Verknüpft Benutzer mit Veranstaltungen, für die eine Anmeldung besteht.

Die Kombination aus user_id und event_id ist eindeutig.

Dadurch kann sich ein Benutzer nicht mehrfach für dieselbe Veranstaltung anmelden.

---

## Tabelle interests

Verknüpft Benutzer mit Veranstaltungen, an denen Interesse besteht.

Auch hier ist die Kombination aus user_id und event_id eindeutig.

Dadurch kann eine Veranstaltung nur einmal pro Benutzer als interessant markiert werden.

---

# 12. Geschäftsregeln

## Interessen und Anmeldungen

Ein Event kann aus Sicht eines Benutzers drei relevante Zustände besitzen:

1. keine Markierung
2. interessiert
3. angemeldet

Eine Veranstaltung soll für denselben Benutzer nicht gleichzeitig als interessiert und angemeldet gelten.

Bei erfolgreicher Anmeldung wird deshalb eine vorhandene Interessenmarkierung automatisch entfernt.

Beim Stornieren einer Anmeldung wird die vorherige Interessenmarkierung nicht automatisch wiederhergestellt.

---

## Eventbearbeitung

Eine Veranstaltung darf bearbeitet werden durch:

- den Organizer, der die Veranstaltung erstellt hat
- einen Administrator

Ein anderer Organizer besitzt keine Bearbeitungsrechte.

Die Prüfung erfolgt serverseitig im Controller und nicht ausschließlich über ausgeblendete Buttons in der Benutzeroberfläche.

---

# 13. Sicherheitskonzept

## 13.1 Passwortsicherheit

Passwörter werden niemals im Klartext gespeichert.

Zur Speicherung wird password_hash() verwendet.

Bei der Benutzeranmeldung erfolgt die Prüfung mit password_verify().

Auch bei einer Passwortänderung im Benutzerprofil wird ein neuer Passwort-Hash erzeugt.

---

## 13.2 Schutz vor SQL-Injection

Datenbankabfragen werden über PDO Prepared Statements durchgeführt.

Benutzereingaben werden als Parameter an SQL-Anweisungen übergeben und nicht direkt in SQL-Befehle eingesetzt.

Dadurch können eingegebene Werte nicht als zusätzlicher SQL-Code interpretiert werden.

---

## 13.3 Schutz vor Cross-Site-Scripting

Benutzereingaben werden vor der HTML-Ausgabe mit htmlspecialchars() maskiert.

Dadurch werden HTML- oder Script-Inhalte aus Benutzereingaben nicht direkt vom Browser interpretiert.

---

## 13.4 Sessionverwaltung

Nach erfolgreichem Login werden unter anderem folgende Informationen in der PHP-Session gespeichert:

- User-ID
- Benutzername
- Rolle

Die Session wird für Authentifizierung und rollenbasierte Berechtigungsprüfungen verwendet.

Beim Logout wird die Session beendet.

---

## 13.5 Rollenbasierte Zugriffskontrolle

Geschützte Funktionen prüfen ihre Berechtigung serverseitig im jeweiligen Controller.

Beispiele:

- Adminfunktionen erfordern die Rolle admin.
- Eventerstellung erfordert organizer oder admin.
- Eventbearbeitung erfordert die Eigentümerschaft des Organizers oder die Adminrolle.

Das reine Ausblenden eines Buttons in einer View gilt nicht als Zugriffsschutz.

---

## 13.6 Validierung von Eingaben

Benutzereingaben werden serverseitig geprüft.

Dazu gehören:

- Pflichtfelder
- E-Mail-Format
- maximale Feldlängen
- gültige IDs
- Passwortlänge
- Passwortbestätigung
- Eventbeginn und Eventende
- zugelassene Rollen
- zugelassene Benutzerstatus

Clientseitige HTML-Validierungen wie required dienen zusätzlich der Benutzerfreundlichkeit.

---

## 13.7 Datenintegrität

Die Datenbank verwendet:

- Primary Keys
- Foreign Keys
- Unique Constraints
- Auto Increment
- Transaktionen

Dadurch werden ungültige oder doppelte Datenbeziehungen zusätzlich auf Datenbankebene verhindert.

---

## 13.8 Transaktionen

Bei einer Veranstaltungsanmeldung werden zwei zusammengehörige Aktionen durchgeführt:

1. Anmeldung speichern
2. vorhandene Interessenmarkierung entfernen

Diese Vorgänge werden innerhalb einer Datenbanktransaktion ausgeführt.

Bei einem Fehler erfolgt ein Rollback.

Dadurch entstehen keine widersprüchlichen Zwischenzustände.

---

## 13.9 Schutz sensibler Konfigurationsdaten

Datenbankzugangsdaten werden in einer lokalen .env-Datei gespeichert.

Die .env-Datei ist in .gitignore eingetragen und wird nicht in das GitHub-Repository übertragen.

---

# 14. Zusammenfassung

Das Event Management System demonstriert die Entwicklung einer datenbankgestützten PHP-Webanwendung mit rollenbasierter Benutzerverwaltung.

Das Projekt verbindet unter anderem:

- objektorientierte PHP-Programmierung
- MVC-Architektur
- relationale Datenmodellierung
- SQL
- PDO
- Prepared Statements
- Transaktionen
- Sessions
- Rollen- und Berechtigungsverwaltung
- serverseitige Validierung
- responsive Benutzeroberflächen mit Bootstrap
- Versionsverwaltung mit Git und GitHub

Durch die Trennung von Model, View und Controller bleibt die Anwendung trotz verschiedener Benutzerrollen und Funktionen strukturiert und erweiterbar.