<x-app-manager-project-layout>

    <x-slot name="js">
    </x-slot>

    <x-slot name="css">
    </x-slot>

    @viteReactRefresh
    @vite(['resources/js/customer/sample.jsx'])


    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 1])

    <div class="main-contents">
        <div class="contents-area container">
            コンテンツ
            <div id="react-root"
                 data-user-name="{{ $building->building_name }}"
                 data-users='@json($person_charge)'>
            >
            </div>
        </div>
    </div>

</x-app-manager-project-layout>
