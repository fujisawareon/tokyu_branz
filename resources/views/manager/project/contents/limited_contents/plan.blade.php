<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/common/sortable.js'])
        @vite(['resources/js/manager/contents/plan.js'])
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
            <li><a href="" class="link">間取り設定</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="container">
            <div class="contents-area" style="width: 900px">

                @include('layouts.manager.flash_message')
                <div class="page-name">間取り設定</div>

                <div class="heading-menu mb-2">基本設定</div>
                <form action="">
                    <div class="item-row">
                        <div class="item-row-title">環境性能画像</div>
                        <div class="item-row-content">
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">注釈</div>
                        <div class="item-row-content">
                                <textarea name="image_gallery_annotation" rows="4"
                                          class="input-box w-full"></textarea>
                        </div>
                    </div>
                    <div class="flex-center-center">
                        <input type="submit" class="btn" value="更新">
                    </div>
                </form>

                <div class="heading-menu my-2">タイプ設定</div>

                <button type="button" id="add_btn" class="btn min mb-2">追加</button>

                <form method="POST" action="{{ route('manager_project_plan_update', ['building' => $building->id]) }}" style="width: 650px;">
                    @csrf
                    @method('post')

                    <div class="list-element mb-2">
                        <div class="list-element-header">
                            <div class="list-element-row">
                                <div style="width: 65px">並び順</div>
                                <div style="flex: 1">タイプ名</div>
                                <div style="width: 65px">表示</div>
                                <div style="width: 90px">プラン</div>
                                <div style="width: 90px">プラン設定</div>
                                <div style="width: 70px">削除</div>
                            </div>
                        </div>
                        <div class="" id="sortable_list">
                            @foreach($plans as $plan)
                                <div class="list-element-row">
                                    <div style="width: 65px; cursor: grab;"
                                         class="drag-handle flex-center-center">☰
                                    </div>
                                    <div style="flex: 1" class="flex-center-center">
                                        <div class="w-full">
                                            <x-input-text type="text" name="type_name" class="w-full"
                                                          placeholder="タイプ名"
                                                          :value="old('type_name', $plan->type_name)"
                                                          :error="$errors->has('type_name')"/>
                                            <x-input-error :messages="$errors->get('type_name')"
                                                           class="mt-1"/>
                                        </div>
                                    </div>
                                    <div style="width: 65px" class="text-center flex-center-center">
                                        <x-input-accepted-checkbox name="display[]"
                                                                   id="display_"
                                                                   :checked="$plan->display_flg"
                                        />
                                    </div>
                                    <div style="width: 90px"></div>
                                    <div style="width: 90px" class="flex-center-center">
                                        <button type="button" class="btn min">設定</button>
                                    </div>
                                    <div style="width: 70px" class="flex-center-center">
                                        <button type="button" class="btn min color-red delete-btn"
                                                data-id="{{ $plan }}">削除
                                        </button>
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
    </div>

    {{-- 行を追加する時の複製用テンプレート --}}
    @include('manager.template.plan')
</x-app-manager-project-layout>

<script>
    let max_action_btn_id = @json(1);
</script>
