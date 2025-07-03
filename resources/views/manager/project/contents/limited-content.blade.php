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
            <li><a href="{{ route('manager_project_limited_content', ['building' => $building->id]) }}"
                   class="link">限定コンテンツ設定</a></li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area" style="width: 500px">

            @include('layouts.manager.flash_message')
            <div class="page-name">限定コンテンツ設定</div>

            <form method="POST" action="">
                @csrf

                <div class="list-element mb-2">
                    <div class="list-element-header">
                        <div class="list-element-row">
                            <div style="width: 65px">並び順</div>
                            <div style="flex: 1">コンテンツ名</div>
                            <div style="width: 65px">表示</div>
                        </div>
                    </div>
                    <div class="" id="sortable_list">
                        @foreach($limited_content_list as $limited_content)
                            <div class="list-element-row">
                                <div style="width: 65px; cursor: grab;" class="drag-handle text-center">☰</div>
                                <div style="flex: 1">{{ $limited_content['name'] }}
                                    @if(in_array($limited_content['key'], \App\Consts\CommonConsts::OPTION_CONTENTS))
                                        (OP)
                                    @endif
                                </div>
                                <div style="width: 65px" class="text-center flex-center-center">
                                    <input type="hidden" name="limited_content[]" value="{{ $limited_content['key'] }}">
                                    <x-input-accepted-checkbox name="display[{{ $limited_content['key'] }}]"
                                                               id="display_{{ $limited_content['key'] }}"
                                                               :checked="$limited_content['display_flg']"
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
    </div>

</x-app-manager-project-layout>

<style>
</style>

