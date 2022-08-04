# lv.pre

Template for Laravel Projects

MADE For Europe/German use

## documentation

[integrated dependecies.md](/doc/debug/integrated.md)
[cache.md](/doc/debug/cache.md)
[description.md](/doc/debug/desc.md)
[environment.md](/doc/debug/environment.md)
[artisan commands.md](/doc/debug/artisans.md)
[next steps.md](/doc/debug/next_steps.md)
[dependencie vaults.md](/doc/debug/dependencie_vaults.md)
[Relationships.drawio](/doc/debug/Relationship_Modell.drawio)

---

## helper

### lang

search:
'item'
replace in view
{{ __('file.name') }}
replace in logic
__('file.name')

### forbidden - wrong html

placeholder='
class='

>>

<<

btn-yellow

## variants

- image v1: has-pics, seperated-yield, ressource
- image v2: named-pics, merged-component, any

## distriction

views/components No Routing

app\
Services only Procedurally

Http\
Controllers\Modules only Objective

- Object type
- Objective Instantiate
- Procedurally static

### Symlink is need to run storage:link on EACH environment

php artisan storage:link

## Languages setttings

First Language English (US)
Second Language German (DE)
EN

- Fallback

DE

- Localisation
- Faker
