# brainapp - Das Web-Haushaltsbuch

Entstanden als studentische Projektarbeit an der [**Hochschule für Telekommunikation Leipzig (HfTL)**](http://www.hft-leipzig.de).

<hr>

Die Webanwendung nutzt das PHP Framework [**Symfony Standard Edition**](https://symfony.com/) und folgende zusätzliche Bundles:
 
  * [**FOSUserBundle**](https://github.com/FriendsOfSymfony/FOSUserBundle) - Benutzerverwaltung mit FriendsOfSymfonyUserBundle
  * [**twitter/bootstrap**](http://getbootstrap.com/) - Front-end Framework Bootstrap 3 
  * [**components/jquery**](https://github.com/components/jquery) - JQuery Bibliotheken
  * [**components/jqueryui**](https://github.com/components/jqueryui) JQueryUI Bibliothek
  * [**components/font-awesome**](https://github.com/components/font-awesome) - Font Awesome Bibliothek

### Demo

[**Live Demo**](http://brainapp.reu-network.de/web) 

## Voraussetzungen

 * Webserver
 * PHP >=5.3
 * MySQL-Datenbank

## Installation

Eine ausführliche Anleitung zur Einrichtung der **Entwicklungsumgebung** befindet sich im [**Wiki**](https://github.com/thebrain1/brainapp/wiki/Einrichtung-Entwicklungsumgebung)

<hr>

### Repository clonen

Das Repository sollte im entsprechenden Verzeichnis des Webservers "ausgecheckt" werden.

    git clone https://github.com/thebrain1/brainapp.git

### Pakete installieren
Nachdem die Dateien aus dem Repository heruntergeladen wurden, müssen die notwendigen Paketdateien heruntergeladen und installaiert werden. 

#### Methode 1 - Installation mittels ``composer``

Die einfachste Variante der Installation erfolgt mittels ``composer``. Weitere Informationen zur Installation und Verwendung auf der [offiziellen Webseite](https://getcomposer.org/).  
*Diese Variante ist sowohl unter Linux als auch unter Windows empfehlenswert.*

	// im Hauptverzeichnis
	php composer update 
	// oder bei global installiertem composer
	composer update
	
installiert alle notwendigen Pakete und aktualisiert Kernel.

### Parameter.yml anpassen

Bei der Installation mittels ``composer`` wird die ``parameters.yml`` automatisch angelegt und die Werte abgefragt. Nachträglich können diese unter ``app/config/parameters.yml`` angepasst werden.  

Die Parameter **müssen** entsprechend der Laufzeitumgebung angepasst werden!
Sollte die ``parameters.yml`` nicht vorhanden sein, ist eine Beispieldatei unter ``app/config/parameters.yml.dist`` abgelegt.

	# app/config/parameters.yml
	parameters:
	    database_host: 127.0.0.1
	    database_port: null
	    database_name: symfony
	    database_user: symfony
	    database_password: null
	    mailer_transport: smtp
	    mailer_host: 127.0.0.1
	    mailer_user: null
	    mailer_password: null
	    secret: ThisTokenIsNotSoSecretChangeIt
