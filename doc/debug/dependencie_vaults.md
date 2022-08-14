# dependencie vaults

kind of problem | details |possible solution | deps: | #1 | #2
--- | --- | --- | --- | --- | ---
several role and permission systems | voyager use own perm. system | use only one | libs, there use own permission system | Vojager | spatie_permissions
|deps only for development| contributer specifie using only local or debug |-||sail => docker Instance|vite_dev command => headless changes

## Voyager (ausgelegt auf Laravel Version 8)

- Model wird im app/ statt im app/Models gesucht
- Migrations werden nicht mit verändert

- Installation ohne Dummy Data schlägt fehl
- Erstellt storage-public LINK
- Manuelle Route
- Abhängigkeiten werden nicht automatisch hinzugefügt

<!-- dusk scrennshot display wrong configuration | dusk run with own env. configuration |-| | config validator | laravel dusk | -->