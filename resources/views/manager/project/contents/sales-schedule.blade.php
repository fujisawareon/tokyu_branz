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
            <li><a href="{{ route('manager_project_sales_schedule', ['building' => $building->id]) }}"
                   class="link">販売スケジュール設定</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">

            @include('layouts.manager.flash_message')
            <div class="page-name">販売スケジュール設定</div>

            <div style="width: 400px">

                <form method="POST" action="{{ route('manager_project_sales_schedule', ['building' => $building->id]) }}">
                    @csrf
                    <div class="list-element mb-2">
                        <div class="list-element-header">
                            <div class="list-element-row">
                                <div style="width: 65px">並び順</div>
                                <div style="flex: 1">カテゴリ名</div>
                                <div style="width: 65px">表示</div>
                            </div>
                        </div>
                        <div class="" id="sortable_list">
                            @foreach($sales_schedules as $sales_schedule)
                                <div class="list-element-row">
                                    <div style="width: 65px; cursor: grab;" class="drag-handle text-center">☰</div>
                                    <div style="flex: 1">{{ $sales_schedule['schedule_name'] }}</div>
                                    <div style="width: 65px" class="text-center flex-center-center">
                                        <input type="hidden" name="sales_schedule_key[{{ $sales_schedule['key'] }}]" value="{{ $sales_schedule['key'] }}">
                                        <x-input-accepted-checkbox name="display[{{ $sales_schedule['key'] }}]"
                                                                   id="display_{{ $sales_schedule['key'] }}"
                                                                   :checked="$sales_schedule['display']"
                                        />
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
    </div>

</x-app-manager-project-layout>

<style>
</style>
