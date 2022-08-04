# Environment

```terminal
php artisan vendor:publish
```

## table: session

used by jetstream

## LDAP

<https://ldaprecord.com>
<https://ldaprecord.com/docs/laravel/v2/auth/sso>
composer.lock und vendor muss vor der Installation gelöscht werden, da Minor Update - kleine Laravel Updates Abhängigkeiten auf eine Version über ldap sperren

## GraphQL

<https://github.com/nuwave/lighthouse>

### Nicht unterstützt

Nohac/laravel-graphiql

## Voyager (7.2022 - ausgelegt auf Laravel Version 8)

- Model wird im app/ statt im app/Models gesucht
- Migrations werden nicht mit verändert

- Installation ohne Dummy Data schlägt fehl
- Erstellt storage-public LINK
- Manuelle Route
- Abhängigkeiten werden nicht automatisch hinzugefügt

### Installation

``` terminal
composer require tcg/voyager
php artisan voyager:install
php artisan voyager:install --with-dummy
```

``` php
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
use TCG\Voyager\Facades\Voyager;
```

## Verwendet, aber installiert eigenständig

### permission

composer require spatie/laravel-permission

'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];

### optional

APP_URL=<http://127.0.0.1:8000>
