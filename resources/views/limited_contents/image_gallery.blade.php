<x-limited-contents-layout :building="$building" :contentsMenu="$contents_menu" :appLogId="$app_log_id">
<x-slot name="css">
    </x-slot>

    <x-slot name="js">
        @viteReactRefresh
        @vite(['resources/js/limited_contents/image_gallery/App.jsx'])
    </x-slot>

    <div class="main-contents">
        <div id="react_root"
             data-contents='@json($contents_data)'
        ></div>
    </div>
</x-limited-contents-layout>

<style>
</style>
                