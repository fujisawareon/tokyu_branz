<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Scripts --}}
        @vite([
            'resources/css/app.css',
            'resources/js/contents_app.js',
        ])

        @if (isset($js))
            {{ $js }}
        @endif

        @if (isset($css))
            {{ $css }}
        @endif

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <script>
        window.appLogId = @json($app_log_id);
        window.buildingId = @json($building->id);
    </script>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            {{-- Page Heading --}}
            @include('layouts.limited_contents.header')

            {{-- Page Content --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>

</html>
