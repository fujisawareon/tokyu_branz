<x-limited-contents-layout>
    <x-slot name="css">
        @vite(['resources/scss/customer/my_page.scss'])
    </x-slot>

    <x-slot name="js">
        @viteReactRefresh
        @vite(['resources/js/limited_contents/sample.jsx'])
    </x-slot>

    <x-slot name="header">
        {{ $building->building_name }}
    </x-slot>

    <div class="container-position">
        <div class="main-contents">
            <div id="react-root"
                 data-user-name="react"
            ></div>
        </div>
    </div>
</x-limited-contents-layout>


