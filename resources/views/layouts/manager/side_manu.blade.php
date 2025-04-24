<?php
$route_num = 0;
$route_name = Route::currentRouteName();

switch ($route_name) {
    case 'manager_dashboard':
        $route_num = 1;
        break;
    case str_starts_with($route_name, 'manager_building'):
        $route_num = 2;
        break;
    case str_starts_with($route_name, 'manager_user'):
        $route_num = 3;
        break;
    case str_starts_with($route_name, 'manager_customer'):
        $route_num = 4;
        break;
    case str_starts_with($route_name, 'manager_download'):
        $route_num = 5;
        break;
}

?>

<div class="side-menu-list">
    <a href="{{ route('manager_dashboard') }}" class="@if($route_num === 1) active @endif">
        <div>ダッシュボード</div>
    </a>
    <a href="{{ route('manager_building_list') }}" class="@if($route_num === 2) active @endif">
        <div>物件</div>
    </a>
    <a href="{{ route('manager_user_list') }}" class="@if($route_num === 3) active @endif">
        <div>業務ユーザー</div>
    </a>
    <a href="{{ route('manager_customer_list') }}" class="@if($route_num === 4) active @endif">
        <div>顧客ユーザー</div>
    </a>
    <a href="{{ route('manager_download') }}" class="@if($route_num === 5) active @endif">
        <div>アクセスログ</div>
    </a>
    <a href="{{ route('manager_download') }}" class="@if($route_num === 6) active @endif">
        <div>スコアインポート</div>
    </a>
</div>
