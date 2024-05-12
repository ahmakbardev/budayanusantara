<!DOCTYPE html>
<html x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Budaya Nusantara</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo_rounded.png') }}" type="image/x-icon">

    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.0/dist/alpine.min.js" defer></script> --}}
    <script src="{{ asset('admin/assets/js/init-alpine.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="{{ asset('admin/assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('admin/assets/js/charts-pie.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
</head>

<body>
    <div class="flex h-screen bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('admin.layouts.components.aside')
        <div class="flex flex-col flex-1 w-full">
            @include('admin.layouts.components.navbar')
            @yield('admin_content')
        </div>
    </div>
    @livewireScripts
</body>


</html>
