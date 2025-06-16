<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/common/sortable.js'])
        @vite(['resources/js/manager/contents/limited_contents/movie.js'])

        <script src="https://player.vimeo.com/api/player.js"></script>
    </x-slot>

    <x-slot name="css">
        @vite(['resources/scss/manager/project/limited_contents/movie.scss'])
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 3])

    <div class="breadcrumb">
        <ol class="container">
            <li><a href="{{ route('manager_project_contents', ['building' => $building->id]) }}"
                   class="link">コンテンツ管理</a></li>
            <li><a href="" class="link">{{ $view_title }}</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">

            @include('layouts.manager.flash_message')
            <div class="page-name">{{ $view_title }}</div>

            <div style="width: 100% ">
                <div class="flex-end-center mb-2">
                    <button type="button" class="btn min" id="category_setting" onclick="">カテゴリー設定</button>
                </div>

                <div>
                    @foreach($movie_list as $movie_category)
                        <div class="mb-2">
                            <div class="category-var mb-2" >{{ $movie_category->category_name }}</div>
                        </div>

                        <div class="movie-grid mb-6">
                            {{-- 既存動画ブロック --}}
                            @foreach($movie_category->movie as $movie)
                                <div class="movie-item">
                                    <iframe
                                            src="https://player.vimeo.com/video/{{ $movie->vimeo_id }}?api=1&player_id=vimeo-player"
                                            allow="autoplay; fullscreen"
                                            allowfullscreen>
                                    </iframe>
                                    <div class="px-2">{{ $movie->title }}</div>
                                    <div class="flex-end-center p-1">
                                        <button type="button" class="btn min color-red delete-btn" data-movie_id="{{ $movie->id }}">削除</button>
                                    </div>
                                </div>
                            @endforeach

                            {{-- 新規動画登録ブロック --}}
                            <div class="movie-item register-new" data-category_id="{{ $movie_category->id }}">
                                <div class="register-box">
                                    <div class="plus-icon">
                                        <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19" />
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                        </svg>
                                    </div>
                                    <div class="">新規動画の登録</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- 動画登録モーダル --}}
    @include('manager.modal.add-movie')

    {{-- カテゴリー設定モーダル --}}
    @include('manager.modal.add-movie-category')
</x-app-manager-project-layout>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    const building_id = {{ $building->id }};
</script>
