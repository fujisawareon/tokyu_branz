

<header>
    <div class="flex-between-center h-full">

        @if($presentation_mode)
            @php $route_name = 'contents_manager'; @endphp
        @else
            @php $route_name = 'contents_customer'; @endphp
        @endif

        <a href="{{ route($route_name, ['building' => $building->id, 'page_name' => 'top']) }}">
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
