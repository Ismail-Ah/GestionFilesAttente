<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redal - Gestion file d'attente</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard/build/css/index.css" />
<script src="https://cdn.jsdelivr.net/npm/simple-keyboard/build/index.js"></script>


      
</head>
<body>
    <header id="header" class="header">
        <div class="header-content">
    <div id="app">
        <router-view  :role="{{ json_encode($role) }}" ></router-view>
    </div>
        </div>
    </header>
</body>
</html>