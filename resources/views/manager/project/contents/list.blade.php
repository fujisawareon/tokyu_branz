<x-app-manager-project-layout>

    <x-slot name="js">
    </x-slot>

    <x-slot name="css">
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 3])

    <div class="main-contents">
        <div class="contents-area container">

            <div class="heading-menu">物件設定</div>
            <div class="content-menus">
                <a href="{{ route('manager_project_sales_status', ['building' => $building->id]) }}">販売ステータス設定</a>
                <a href="{{ route('manager_project_sales_schedule', ['building' => $building->id]) }}">販売スケジュール設定</a>
                <a href="{{ route('manager_project_action_btn', ['building' => $building->id]) }}">アクションボタン設定</a>
            </div>
            <div class="heading-menu">コンテンツ機能管理</div>
            <div class="content-menus">
                <a href="{{ route('manager_project_limited_content', ['building' => $building->id]) }}">限定コンテンツ設定</a>
                <a href="{{ route('manager_project_share_content', ['building' => $building->id]) }}">シェア内容設定</a>
                <a href="{{ route('manager_project_information', ['building' => $building->id]) }}">お知らせ</a>
            </div>
            <div class="heading-menu">各種コンテンツ管理</div>
            <div class="content-menus">
                <a href="">スケジュール</a>
                <a href="">オンラインセミナ－動画</a>
                <a href="{{ route('manager_project_building_movie', ['building' => $building->id, 'movie_type' => 1]) }}">物件紹介動画</a>
                <a href="{{ route('manager_project_building_movie', ['building' => $building->id, 'movie_type' => 2]) }}">マンション購入の<br>基礎知識編動画</a>
                <a href="{{ route('manager_project_building_movie', ['building' => $building->id, 'movie_type' => 3]) }}">BRANZの管理と購入後の<br>サポート編動画</a>
                <a href="">間取り</a>
                <a href="" class="option">専有部VR</a>
                <a href="" class="option">平面図眺望<br>シミュレーション</a>
                <a href="" class="option">日影シミュレーション</a>
                <a href="" class="option">外観、共用部VR</a>
                <a href="{{ route('manager_project_image_gallery', ['building' => $building->id]) }}">画像ギャラリー</a>
                <a href="" class="option">家具レイアウト<br>シミュレーション</a>
                <a href="">周辺マップ</a>
                <a href="">現地写真</a>
                <a href="">物件資料集</a>
                <a href="">担当者専用資料集</a>
                <a href="">ローンシミュレーション</a>
                <a href="">販売価格表</a>
            </div>
        </div>
    </div>

</x-app-manager-project-layout>

<style>
    .content-menus {
        display: grid;
        padding: 1rem 1rem 2rem;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        width: 100%;
        text-align: center;
    }

    .content-menus > a {
        position: relative;
        height: 80px;
        width: 100%;
        padding: 1rem .5rem;
        border: solid 1px var(--manager-main-color);
        border-radius: .5rem;
        background: var(--manager-main-color);
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: .2s;
    }

    .content-menus > a.option:after {
        position: absolute;
        content: "OP";
        top: 5px;
        right: 5px;
        padding: .25rem;
        font-size: .8rem;
        border: solid 2px #fff;
        border-radius: .25rem;
    }

    .content-menus > a:hover {
        background: var(--manager-hover-color);
        color: var(--manager-main-color);
    }

    .content-menus > a.option:hover:after {
        border: solid 1px var(--manager-main-color);
    }

    @media (max-width: 1280px) {
        .content-menus {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 1025px) {
        .content-menus {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
