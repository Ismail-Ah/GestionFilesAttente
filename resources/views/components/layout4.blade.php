<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redal - Gestion file d'attente</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

</head>
<body>
    <style>
        body{
            background-color: aliceblue;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 90vh;
            margin: 0;
            padding: 0;
        }
    </style>
    <script>
        localStorage.clear();
    </script>
    
    <svg viewBox="0 0 1356 200" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="rgba(2, 48, 71, 1)" d="M 0 0 C 344.5 0 344.5 110 689 110 L 689 110 L 689 0 L 0 0 Z" stroke-width="0"></path> <path fill="rgba(2, 48, 71, 1)" d="M 688 110 C 1022 110 1022 0 1356 0 L 1356 0 L 1356 0 L 688 0 Z" stroke-width="0"></path> </svg>
            <div class="container d-flex justify-content-center">

            <a class="navbar-brand logo-image" href="/"><img  style="height:50px;width:100px;margin-top:-320px;margin-left:30px"  src="/img/redal.png" alt="alternative"></a> 

            
        </div> 
    </nav>
    
    <div id="app">
        {{$slot}}
    </div>
</body>
</html>