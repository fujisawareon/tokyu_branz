<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/common/sortable.js'])
        @vite(['resources/js/manager/contents/action_btn_setting.js'])
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
            <li><a href="{{ route('manager_project_action_btn', ['building' => $building->id]) }}"
                   class="link">アクションボタン設定</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">

            @include('layouts.manager.flash_message')
            <div class="page-name">アクションボタン設定</div>

            <button type="button" id="add_btn" class="btn min mb-2">追加</button>

            <div style="width: 850px">
                <form method="POST" action="{{ route('manager_project_action_btn', ['building' => $building->id]) }}">
                    @csrf
                    <div class="list-element mb-2">
                        <div class="list-element-header">
                            <div class="list-element-row">
                                <div style="width: 65px">並び順</div>
                                <div style="width: 200px">ボタン名</div>
                                <div style="flex: 1">URL</div>
                                <div style="width: 65px">表示</div>
                                <div style="width: 65px">削除</div>
                            </div>
                        </div>
                        {{-- 物件サイト --}}
                        <div class="list-element-row">
                            <div style="width: 65px;" class="text-center"></div>
                            <div style="width: 200px" class="flex-start-center">物件サイト</div>
                            <div style="flex: 1">
                                <x-input-text type="url" name="building_site_url" class="w-full"
                                              id="building_site_url" placeholder="URL"
                                              :value="old('building_site_url', $building->buildingSetting->building_site_url?? '')"
                                              :error="$errors->has('building_site_url')"/>
                                <x-input-error :messages="$errors->get('building_site_url')" class="mt-2" />
                            </div>
                            <div style="width: 65px">
                                <div class="flex-center-center h-full">
                                    <div>
                                        <x-input-accepted-checkbox name="building_site_display_flg"
                                                                   id="building_site_display_flg"
                                                                   :checked="$building->buildingSetting->building_site_display_flg?? 0"
                                        />
                                        <x-input-error :messages="$errors->get('building_site_display_flg')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div style="width: 65px"></div>
                        </div>

                        {{-- アクションボタン --}}
                        <div class="" id="sortable_list">
                            @foreach($building->actionBtnSetting as $action_btn_setting )
                                <div class="list-element-row" style="align-items: stretch;">
                                    <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">
                                        ☰
                                    </div>
                                    <div style="width: 200px">
                                        <x-input-text type="text" name="button_name[{{ $action_btn_setting->id }}]"
                                                      class="w-full"
                                                      id="button_name_{{ $action_btn_setting->id }}" placeholder="来場予約"
                                                      :value="old('button_name.' . $action_btn_setting->id , $action_btn_setting->button_name)"
                                                      :error="$errors->has('button_name.' . $action_btn_setting->id)"/>
                                        <x-input-error :messages="$errors->get('button_name.' . $action_btn_setting->id)" class="mt-2" />
                                    </div>
                                    <div style="flex: 1">
                                        <x-input-text type="url" name="url[{{ $action_btn_setting->id }}]" class="w-full"
                                                      id="url_{{ $action_btn_setting->id }}" placeholder="URL"
                                                      :value="old('url.' . $action_btn_setting->id, $action_btn_setting->url)"
                                                      :error="$errors->has('url.' . $action_btn_setting->id)"/>
                                        <x-input-error :messages="$errors->get('url.' . $action_btn_setting->id)" class="mt-2" />
                                    </div>
                                    <div style="width: 65px" class="flex-center-center">
                                        <x-input-accepted-checkbox name="display_flg[{{ $action_btn_setting->id }}]"
                                                                   id="display_flg_{{ $action_btn_setting->id }}"
                                                                   :checked="$action_btn_setting->display_flg"
                                        />
                                        <x-input-error :messages="$errors->get('display_flg.' . $action_btn_setting->id)" class="mt-2" />
                                    </div>
                                    <div style="width: 65px" class="flex-center-center">
                                        <button type="button" class="btn min color-red delete-btn">削除</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-center-center">
                        <input type="submit" class="btn" value="更新">
                    </div>
                </form>
            </div>

            @error('sales_schedule_key.*')
            <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        {{-- 行を追加する時の複製用テンプレート --}}
        @include('manager.template.action-btn')
    </div>
</x-app-manager-project-layout>

<script>
    let max_action_btn_id = @json($max_action_btn_id);
</script>
