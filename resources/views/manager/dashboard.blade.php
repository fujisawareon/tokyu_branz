<x-app-manager-layout>

    <x-slot name="js">
        @vite(['resources/js/manager/dashboard.js'])
    </x-slot>

    <x-slot name="css">
        @vite(['resources/css/manager/dashboard.css'])
    </x-slot>

    <x-slot name="breadcrumb">
        <ol>
            <li><a href="{{ route('manager_dashboard') }}" class="link">{{ __('Dashboard') }}</a></li>
        </ol>
    </x-slot>

    <x-slot name="view_name">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="main-contents">
        <div class="building-selected flex-between-center" style="">
            <div class="flex-start-center" style="gap: 1rem; flex-wrap: wrap">
                @foreach($selected_buildings as $building)
                    <div class="building-name">{{ $building->building_name }}</div>
                @endforeach
            </div>
            <button class="btn" id="building_select_btn">物件を選択する</button>
        </div>
        <div class="dashboard-contents">
            <div class="element">
                <span class="title">エントリー数</span>
                <div class="element-value">
                    <span class="counter count-font" style="font-size: 5rem;"
                          data-target="999">0</span>名
                </div>
            </div>
            <div class="element">
                <span class="title">登録者数</span>
                <div class="element-value">
                    <span class="counter count-font" style="font-size: 5rem;"
                          data-target="999">0</span>名
                </div>
            </div>
            <div class="element">
                <span class="title">アクティブユーザー数（直近1か月）</span>
                <div class="element-value">
                    <span class="counter count-font" style="font-size: 5rem;"
                          data-target="999">0</span>名
                </div>
            </div>
            <div class="element">
                <span class="title">総PV数</span>
                <div class="element-value">
                    <span class="counter count-font" style="font-size: 4rem;"
                          data-target="{{ $total_view_count }}">0</span>PV
                </div>
            </div>
            <div class="element">
                <span class="title">物件別初回ログイン率</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">物件別エントリー者数</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">物件別PV数</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">物件別来場率</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">物件別ポータルサイトエントリー率</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">物件別フォーム遷移率</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">コンテンツ別閲覧数</span>
                <div class="element-value"></div>
            </div>
            <div class="element">
                <span class="title">ポータルサイト資料請求数</span>
                <div class="element-value"></div>
            </div>
        </div>
    </div>


    <div class="modal-background" id="building_select">
        <div class="modal" style="width: 800px;">
            <div class="modal-close">×</div>
            <form method="POST">
                @csrf
                <div class="flex mb-2" style="gap: 1rem; flex-wrap: wrap;">
                    <x-input-checkbox name="select_building[]" class=""
                                   id="select_building"
                                   :options="$building_list"
                                   :values="$selected_building_ids"
                                   :error="$errors->has('select_building')"
                    />
                </div>
                <input type="submit" class="btn" id="" value="選択する">
            </form>
        </div>
    </div>


</x-app-manager-layout>
