<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>KIDDOS</title>
            {{-- <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}
          @vite('resources/css/app.css')
          @vite('resources/vendors/mdi/css/materialdesignicons.min.css')
        @vite('resources/vendors/base/vendor.bundle.base.css')

    </head>
    
    <body :class="{ 'sidebar-icon-only': sidebarIconOnly }">
        <div id="app"></div>
        @vite('resources/js/app.js')
        {{-- @vite('resources/vendors/base/vendor.bundle.base.js') --}}
        @vite('resources/js/off-canvas.js')
        @vite('resources/js/hoverable-collapse.js')
        @vite('resources/js/template.js')
        {{-- @vite('resources/js/dashboard.js') --}}
        {{-- @vite('resources/js/dataTables.bootstrap4.js') --}}
        @vite('resources/js/jquery.cookie.js')
    </body>
</html>
