<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Budaya Nusantara</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo_rounded.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Append version number to CSS file name -->
    <link rel="stylesheet" href="{{ asset('css/app.css?v=1.03') }}">
    <!-- Add cache-control headers for CSS and JavaScript files -->
    <link rel="preload" href="{{ asset('css/app.css?v=1.03') }}" as="style" crossorigin="anonymous" />
</head>

<body class="font-roboto">
    <!-- component -->
    @unless (Route::currentRouteName() === 'login.form' || Route::currentRouteName() === 'register.form')
        @include('layouts.components.navbar')
    @endunless
    <main>
        @yield('content')
    </main>
</body>

</html>
