<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/common/sortable.js'])
        @vite(['resources/js/manager/contents/limited_contents/binder.js'])
    </x-slot>

    <x-slot name="css">
        @vite(['resources/scss/manager/project/limited_contents/binder.scss'])
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 3])

    <div class="breadcrumb">
        <ol class="container">
            <li><a href="{{ route('manager_project_contents', ['building' => $building->id]) }}"
                   class="link">コンテンツ管理</a></li>
            <li><a href="" class="link">物件資料集</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">

            @include('layouts.manager.flash_message')
            <div class="page-name">物件資料集</div>

            <div style="width: 100% ">
                <div class="flex-end-center mb-2">
                    <button type="button" class="btn min" id="category_setting" onclick="">カテゴリー設定</button>
                </div>

                <div>
                    @foreach($binder_building_category as $category)
                        <div class="mb-2">
                            <div class="category-var mb-2" >{{ $category->category_name }}</div>
                        </div>

                        <div class="movie-grid mb-6">
                            {{-- 既存資料ブロック --}}
                            @foreach($category->binderBuilding as $binder)
                                <div class="binder-item">
                                    <div class="flex-between-center mb-1">
                                        <button type="button" class="btn min " data-movie_id="{{ $binder->id }}">編集</button>
                                        <button type="button" class="btn min color-red" data-movie_id="{{ $binder->id }}">削除</button>
                                    </div>
                                    <div style="width: 100%;height: 150px;background: #f4f4f4;">
                                        @if($binder->binder_type  == 0)
                                            <img src="{{ asset('storage/' . $binder->thumbnail_file_path) }}" alt="サムネイル画像" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('/svg/browser_window_ui.svg')}}" alt="サムネイル画像" style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="mt-1">{{ $binder->binder_name }}</div>
                                </div>
                            @endforeach

                            {{-- 新規資料登録ブロック --}}
                            <div class="binder-item register-new"
                                 data-category_id="{{ $category->id }}"
                                 data-category_name="{{ $category->category_name }}">
                            <div class="register-box">
                                    <div class="plus-icon">
                                        <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19" />
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                        </svg>
                                    </div>
                                    <div class="">新規資料の登録</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- 資料登録モーダル --}}
    @include('manager.modal.add-binder')

    {{-- カテゴリー設定モーダル --}}
    @include('manager.modal.add-binder-category')
</x-app-manager-project-layout>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    const building_id = {{ $building->id }};
</script>
