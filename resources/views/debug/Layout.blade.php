<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Debug: {{ url()->current() }}</title>
</head>

<body>


    <x-debug.sessionStatus />
    <x-debug.style />
    <div style="float: left">
        <x-debug.menu />
    </div>
    <div style="margin: auto">
        @yield('c')
    </div>
    <div style="float: right">
        <x-debug.constants />
    </div>

</body>

</html>
