<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redal - Gestion file d'attente</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js', 'resources/sass/app.scss']); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      
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
        <router-view  :role="<?php echo e(json_encode($role)); ?>" ></router-view>
    </div>
        </div>
    </header>
</body>
</html><?php /**PATH C:\Users\zoro\Documents\stage\project-main\resources\views/statistiques.blade.php ENDPATH**/ ?>