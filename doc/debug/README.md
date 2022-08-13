# Laravel Debug Template

Template for Laravel Projects

MADE For Europe/German use

## Introduction

This Template should be used instead of a normal Laravel 9 installation or by copy some needed parts to extend your debug possibilitys and speed up development.

The next steps are choose a starter Template, like jetstream or breeze if you want one and build your prefered software-stack.

contact me, if one of your software-stack tools not working with this template. The incompatibles can you found [here](/doc/debug/dependencie_vaults.md).

Jetstream should be configured with the permission. See this tutorial:
<https://geisi.dev/blog/combining-laravel-jetstream-with-spatie-permissions/>

email:
wi2z69k2w@relay.firefox.com

## using

run

```artisan
php artisan storage:link
```

write your env and app-key

## Documentation

Overview to Relationships: [draw.io File](/doc/debug/Relationship_Modell.drawio)

This Project use many default Packages [Packages](/doc/debug/integrated.md)

[This](/doc/debug/environment.md) bigger Projects are not integrated

## some stuff

How to clear your [cache](/doc/debug/cache.md)

[Some Artisan commands](/doc/debug/artisans.md)

[Descriptions and Snippets](/doc/debug/desc.md)

---

## helper

### lang

search:
'item'
replace in view
{{ __('file.name') }}
replace in logic
__('file.name')

### wrong html using

placeholder='
class='

>>

<<

Bootstrap:

btn-yellow

## distriction

views/components No Routing

app\
Services only Procedurally

Http\
Controllers\Modules only Objective

- Object type
- Objective Instantiate
- Procedurally static

## Languages setttings

First Language English (US)
Second Language German (DE)
EN

- Fallback

DE

- Localisation
- Faker

### TODO (I delete that when I have time)

/stackoverflow.com/questions/33512184/get-laravel-models-with-all-attributes

- image v1: has-pics, seperated-yield, ressource
- image v2: named-pics, merged-component, any
