<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Management</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js', 'resources/sass/app.scss']); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
    <div id="app">
        <router-view   :role="<?php echo e(json_encode($role)); ?>"></router-view>
    </div>
</body>
</html>
<?php /**PATH D:\Documents\stage\project\resources\views\ajouteragence.blade.php ENDPATH**/ ?>