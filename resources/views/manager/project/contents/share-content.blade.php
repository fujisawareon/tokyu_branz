<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/common/sortable.js'])
    </x-slot>

    <x-slot name="css">
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 3])

    <div class="breadcrumb">
        <ol class="container">
            <li><a href="{{ route('manager_project_contents', ['building' => $building->id]) }}"
                   class="link">コンテンツ管理</a></li>
            <li><a href="{{ route('manager_project_share_content', ['building' => $building->id]) }}"
                   class="link">シェア内容設定</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">
            <div class="page-name">シェア内容設定</div>

            @include('layouts.manager.flash_message')


            <div class="item-row">
                <div class="item-row-title">ステータス</div>
                <div class="item-row-content">
                    <form action="{{ route('manager_project_share_content', ['building' => $building->id]) }}"
                        id="select_status_form">
                        <x-input-select name="status"
                                        id="status"
                                        class="w-64"
                                        :value="old('status', $selected_status_id)"
                                        :options="$status_list"
                                        :error="$errors->has('status')"
                        />
                        <x-input-error :messages="$errors->get('status')" class="mt-1"/>
                    </form>
                </div>
            </div>

            <form method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $selected_status_id }}">
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                    <div class="border p-2">
                        <div class="border mb-2 p-2">
                            コンテンツ
                        </div>
                        @foreach($limited_content_list as $limited_content)
                            @if($limited_content['display_flg'])
                                <div class="border-b p-1">
                                    <div style="width: max-content;">
                                        <x-input-accepted-checkbox name="contents[{{ $limited_content['key'] }}]"
                                                                   label="{{ $limited_content['name'] }}"
                                                                   :checked="in_array($limited_content['key'], $share_contents_list)"
                                        />
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="border p-2">
                        間取り
                    </div>
                    <div class="border p-2">
                        物件資料集
                    </div>
                    <div class="border p-2">
                        アクションボタン
                        {{-- 物件サイト --}}
                        @if($building->buildingSetting->building_site_display_flg)
                            <div class="border-b p-1">
                                <div style="width: max-content;">
                                    <x-input-accepted-checkbox name="building_site"
                                                               label="物件サイト"
                                                               :checked="false"
                                    />
                                </div>
                            </div>
                        @endif

                        {{-- アクションボタン --}}
                        @foreach($building->actionBtnSetting as $action_btn_setting)
                            @if($action_btn_setting->display_flg)
                                <div class="border-b p-1">
                                    <div style="width: max-content;">
                                        <x-input-accepted-checkbox name="action_btn[]"
                                                                   label="{{ $action_btn_setting['button_name'] }}"
                                                                   value="{{ $action_btn_setting['id'] }}"
                                                                   :checked="in_array($action_btn_setting['id'], $share_item_list)"
                                        />
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="flex-center-center mt-2">
                    <input type="submit" class="btn" value="更新">
                </div>
            </form>

        </div>
    </div>

</x-app-manager-project-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ステータスを変更したら フォームを送信する
        $('#status').on('change', function () {
            // セレクトボックスの親フォームを取得して送信
            $('#select_status_form').closest('form').submit();
        });
    });
</script>


