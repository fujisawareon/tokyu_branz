<x-app-customer-layout>
    <x-slot name="view_name">
        マイページトップ
    </x-slot>

    <x-slot name="css">
        @vite(['resources/scss/customer/my_page.scss'])
    </x-slot>

    <div class="container-position">
        <div class="main-contents">
            @foreach($buildings as $building)
                <div class="building-box">
                    <div class="">
                        {{ $building->building_name }}
                    </div>
                    <div class="">
                        <a href="{{ route('contents_customer', [
                                'building' => $building->id,
                                'page_name' => 'top']) }}" class="content-btn">限定コンテンツ</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-customer-layout>


