<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/common/sortable.js'])
        @vite(['resources/js/manager/contents/limited_contents/image_gallery.js'])
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
            <li><a href="{{ route('manager_project_image_gallery', ['building' => $building->id]) }}"
                   class="link">画像ギャラリー</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">

            @include('layouts.manager.flash_message')
            <div class="page-name">画像ギャラリー</div>

            <div style="width: 850px">
                <form method="POST" action="{{ route('manager_project_image_gallery_update', ['building' => $building->id]) }}">
                    @csrf
                    <div class="item-row">
                        <div class="item-row-title">注釈文</div>
                        <div class="item-row-content">
                            <textarea name="image_gallery_annotation" rows="4"
                                      class="input-box w-full">{{ old('message', ($building->buildingSetting->image_gallery_annotation)?? null) }}</textarea>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">画像一覧</div>
                        <div class="item-row-content">
                            <div>
                                <div class="flex-center-center mb-2">
                                    <button type="button" class="btn min" id="add_image_btn" onclick="">画像追加</button>
                                </div>
                                <div class="list-element mb-2">
                                    <div class="list-element-header">
                                        <div class="list-element-row">
                                            <div style="width: 65px">並び順</div>
                                            <div style="width: 300px">画像タイトル</div>
                                            <div style="flex: 1">画像</div>
                                            <div style="width: 65px">削除</div>
                                        </div>
                                    </div>
                                    <div class="" id="sortable-list">
                                        @foreach($image_gallery_list as $image_gallery)
                                            <div class="list-element-row">
                                                <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">☰</div>
                                                <div style="width: 300px" class="flex-center-center">
                                                    <div class="w-full">
                                                        <x-input-text type="text" name="title" class="w-full"
                                                                      placeholder="画像タイトル"
                                                                      :value="old('title', $image_gallery->title)"
                                                                      :error="$errors->has('title')"/>
                                                        <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                                                    </div>
                                                </div>
                                                <div style="flex: 1" class="">
                                                    <div style="height: 100px; width: 150px;margin: 0 auto;">
                                                        <img src="{{ Storage::url($building->id . '/image_gallery/thumbnail/' . $image_gallery->image_file_name) }}"
                                                             alt="{{ $image_gallery->title }}"
                                                            style="object-fit: cover;height: 100%; width: 100%;"
                                                        >
                                                    </div>
                                                </div>
                                                <div style="width: 65px" class="flex-center-center">
                                                    <button type="button" class="btn min color-red delete-btn" data-id="{{ $image_gallery->id }}">削除</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-center-center">
                        <input type="submit" class="btn" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- モーダル --}}
    <div class="modal-background" id="add_image">
        <div class="modal" style="width: 800px;">
            <div class="modal-close">×</div>

            <form method="POST" action="{{ route('manager_project_image_gallery_add', ['building' => $building->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="item-row">
                    <div class="item-row-title">画像タイトル</div>
                    <div class="item-row-content">
                        <x-input-text type="text" name="title" class="w-80"
                                      id="title" placeholder="画像タイトル"
                                      :value="old('title')"
                                      :error="$errors->has('title')"/>
                        <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">画像</div>
                    <div class="item-row-content">
                        <input type="file" name="image">
                        <x-input-error :messages="$errors->get('image')" class="mt-1"/>
                        <div class="support-msg">※登録可能な拡張子は.jpg, .jpeg, .png, .webpとなります</div>
                        <div class="support-msg">※ファイルサイズは3MBまでとなります</div>
                    </div>
                </div>
                <div class="flex-center-center">
                    <input type="submit" class="btn" value="登録">
                </div>
            </form>


        </div>
    </div>
</x-app-manager-project-layout>

<script>
    const building_id = {{ $building->id }};
</script>
