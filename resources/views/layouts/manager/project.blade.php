
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        @vite(['resources/css/manager/app.css', 'resources/js/manager_project.js'])

        @if (isset($js))
            {{ $js }}
        @endif

        @if (isset($css))
            {{ $css }}
        @endif

    </head>
    <body class="font-sans antialiased">
        <div class="flex flex-col min-h-screen" >
            @include('layouts.manager.header')

            {{-- Page Content --}}
            {{ $slot }}
        </div>
    </body>
</html>
