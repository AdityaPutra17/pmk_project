<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logopmknew.png') }}">
    
</head>
<body class="bg-gray-50 min-h-screen overflow-x-hidden">

    @include('layout.sidebar')
    @include('layout.header')

    <!-- MAIN CONTENT -->
    <main class="pl-0 lg:pl-64 pr-4 sm:pr-6 pb-6">
        @yield('content')
    </main>

</body>

</html>