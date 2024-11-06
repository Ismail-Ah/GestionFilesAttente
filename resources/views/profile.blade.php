<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redal - Gestion file d'attente</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

      
</head>
<body>
    <script>
        localStorage.clear();
    </script>
    <div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <header id="header" class="header">
        <div class="header-content">
    <div id="app">
        <router-view  :role="{{ json_encode($role) }}" ></router-view>
    </div>
        </div>
    </header>
</body>
</html>