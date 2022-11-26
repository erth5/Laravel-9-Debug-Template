echo off
cd ../

if EXIST "script/model.txt" (
    for /F %%i in (script/model.txt) do (
            if exist "app/Models/%%i.php" (
                echo Model %%i existiert bereits
            ) else (
                php artisan make:model %%i
                echo Model %%i wurde angelegt
            )
        )
)
