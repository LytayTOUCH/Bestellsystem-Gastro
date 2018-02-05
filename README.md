# Bestellsystem-Gastro

Dieses System ist für kleinere Lokale mit Bestellungen und Tischverwaltungen sinnvoll um 
die Bestellabläufe einfach und unkompliziert zu realisieren. Dieses System wurde durch
Dennis Heinrich <dennis@cloudmaker97.de> entwickelt.

Diese Software ist nicht haftbar durch Ausfälle an Software, Bedienung oder Infrastruktur,
da es sich hierbei um eine private, kostenfreie "Open-Source" Software handelt.

Installationsanleitung:
- .env Anpassen für Einstellungen
- In der .env die Sentry-DSN setzen / APP_ENV auf "productive" setzen
- Composer für den Updater global installieren
- NodeJS installieren
- Node-Server starten und in Startup anbinden (https://www.npmjs.com/package/forever)
