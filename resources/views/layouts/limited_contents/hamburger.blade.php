<div id="hamburger" class="hamburger-menu cursor-pointer" onclick="toggleMenu()">
    <div class="hamburger-icon">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<div id="overlay"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 transform translate-x-full transition-transform duration-300"
     onclick="toggleMenu()">
</div>

<div id="side_menu" class="side-menu  translate-x-full transition-transform">
    <div class="hamburger-menu close mb-4 text-left w-full flex-start-center gap-2" onclick="toggleMenu()">
        <div class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
        </div>
        閉じる
    </div>
    <div class="mb-2">コンテンツを選択してください</div>
    <ul class="menu-list">
        <li>
            <a href="{{ route('contents_manager', ['building' => $building->id, 'page_name' => 'top']) }}">
                トップ
            </a>
        </li>

        @if($app_log_id)
            @php $route_name = 'contents_customer'; @endphp
        @else
            @php $route_name = 'contents_manager'; @endphp
        @endif

        @foreach($contents_menu as $page_name => $menu)
            <li>
                <a href="{{ route($route_name, ['building' => $building->id, 'page_name' => $page_name]) }}">
                    {{ $menu }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function toggleMenu() {
        const menu = document.getElementById('side_menu');
        const overlay = document.getElementById('overlay');
        menu.classList.toggle('translate-x-full');
        menu.classList.toggle('translate-x-0');

        overlay.classList.toggle('translate-x-full');
        overlay.classList.toggle('translate-x-0');
    }

</script>