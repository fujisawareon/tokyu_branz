

<header>
    <div class="flex-between-center h-full">
        <a href="{{ route('contents_manager', ['building' => $building->id, 'page_name' => 'top']) }}">
            <div class="logo">
                <img src="{{ asset('image/logo.svg') }}" alt="MyBRANZロゴ">
            </div>
        </a>
        <div>{{ $building->building_name }}</div>
        <div class="flex gap-3">
            <div>ペンツール</div>
            <div>おしらせ</div>
            @include('layouts.limited_contents.hamburger')
        </div>
    </div>
</header>
