<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>KIDDOS</title>
            
          <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
          <?php echo app('Illuminate\Foundation\Vite')('resources/vendors/mdi/css/materialdesignicons.min.css'); ?>
        <?php echo app('Illuminate\Foundation\Vite')('resources/vendors/base/vendor.bundle.base.css'); ?>

    </head>
    
    <body :class="{ 'sidebar-icon-only': sidebarIconOnly }">
        <div id="app"></div>
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
        
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/off-canvas.js'); ?>
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/hoverable-collapse.js'); ?>
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/template.js'); ?>
        
        
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/jquery.cookie.js'); ?>
    </body>
</html>
<?php /**PATH C:\System\kiddos_system\resources\views/welcome.blade.php ENDPATH**/ ?>