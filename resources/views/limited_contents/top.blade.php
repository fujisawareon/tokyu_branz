<x-limited-contents-layout :building="$building" :contentsMenu="$contents_menu">

    <x-slot name="css">
    </x-slot>

    <x-slot name="js">
        @viteReactRefresh
        @vite([
        ])
    </x-slot>

    <div class="container-position">
        <div class="main-contents">
            <img src="{{ Storage::url('building/'. $building->id  .'/'. $building->top_image) }}" alt="トップ画像">
        </div>
    </div>
</x-limited-contents-layout>
<style>
    .main-contents > img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>


