<x-app-manager-project-layout>

    <x-slot name="js">
        {{-- TODO --}}
        @vite(['resources/js/manager/contents/sales_schedule.js'])
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

            <button type="button" class="btn min mb-2">追加</button>

            <div style="width: 800px">
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
                                <x-input-text type="text" name="building_site_url" class="w-full"
                                              id="building_site_url" placeholder="URL"
                                              :value="old('building_site_url', $building->buildingSetting->building_site_url?? '')"
                                              :error="$errors->has('building_site_url')"/>
                            </div>
                            <div style="width: 65px">
                                <div class="flex-center-center h-full">
                                <x-input-accepted-checkbox name="building_site_display_flg"
                                                           id="building_site_display_flg"
                                                           :checked="$building->buildingSetting->building_site_display_flg?? 0"
                                />
                                </div>
                            </div>
                            <div style="width: 65px">
                            </div>
                        </div>

                        {{-- アクションボタン --}}
                        <div class="" id="sortable-list">
                            <div class="list-element-row" style="align-items: stretch;">
                                <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">
                                    ☰
                                </div>
                                <div style="width: 200px">
                                    <x-input-text type="text" name="button_name[1]" class="w-full"
                                                  id="button_name_1" placeholder="来場予約"
                                                  :value="old('button_name[1]')"
                                                  :error="$errors->has('button_name[1]')"/>
                                </div>
                                <div style="flex: 1">
                                    <x-input-text type="text" name="title" class="w-full"
                                                  id="title" placeholder="URL"
                                                  :value="old('title')"
                                                  :error="$errors->has('title')"/>
                                </div>
                                <div style="width: 65px" class="flex-center-center">
                                    <input type="hidden" name="sales_schedule_key[]" value="">
                                    <x-input-accepted-checkbox name="display[]"
                                                               id="display_"
                                                               :checked="0"
                                    />
                                </div>
                                <div style="width: 65px" class="flex-center-center">
                                    <button type="button" class="btn min color-red">削除</button>
                                </div>
                            </div>
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
    </div>

</x-app-manager-project-layout>

<style>
    .sortable-item {
        padding: 10px;
        background-color: #f0f0f0;
        margin: 5px;
        cursor: grab;
    }
    .sortable-ghost {
        opacity: 0.5;
        background: #001C5133;
    }
</style>
