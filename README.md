# brainapp - Das Web-Haushaltsbuch

Entstanden als studentische Projektarbeit an der [**Hochschule für Telekommunikation Leipzig (HfTL)**](http://www.hft-leipzig.de).

<hr>

Die Webanwendung nutzt das PHP Framework [**Symfony Standard Edition**](https://symfony.com/) und folgende zusätzliche Bundles:
 
  * [**FOSUserBundle**](https://github.com/FriendsOfSymfony/FOSUserBundle) - Benutzerverwaltung mit FriendsOfSymfonyUserBundle



## Installation


F�r die Entwicklung, muss zuvor ein Webserver mit PHP 5.3 und eine MySQL Datenbank vorhanden sein. F�r die lokale Entwicklung bietet sich bspw. [**XAMPP**](http://www.apachefriends.org) an. 

Nachdem die Dateien aus dem Repository heruntergeladen wurden, m�ssen die notwendigen Paketdateien heruntergeladen und installaiert werden. 



### Methode 1 - Installation mittels ``composer``

Die einfachste Variante der Installation erfolgt mittels ``composer``. Weitere Informationen zur Installation und Verwendung auf der [offiziellen Webseite](https://getcomposer.org/).  
*Diese Variante ist sowohl unter Linux als auch unter Windows empfehlenswert.*

	// im Hauptverzeichnis
	php composer update 
	// oder bei global installiertem composer
	composer update
	
installiert alle notwendigen Pakete und aktualisiert Kernel.
