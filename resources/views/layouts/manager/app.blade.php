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
        @vite(['resources/css/app.css', 'resources/js/manager_app.js'])

        @if (isset($js))
            {{ $js }}
        @endif

        @if (isset($css))
            {{ $css }}
        @endif

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col">
            @include('layouts.manager.header')

            <div class="flex flex-auto">
                <div class="side-manu">
                    @include('layouts.manager.side_manu')
                </div>
                <div class="page-contents-area">

                    {{-- パンくず --}}
{{--                    @if (isset($breadcrumb))--}}
{{--                        <div class="breadcrumb">--}}
{{--                            {{ $breadcrumb }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

                    {{-- 画面名 --}}
                    <div class="view-name">
                        {{ $view_name }}
                    </div>

                    @include('layouts.manager.flash_message')

                    {{-- Page Content --}}

                    <div class="page-contents">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
