
<div class="modal-background" id="add_movie_modal">
    <div class="modal" style="width: 600px;">
        <div class="modal-close">×</div>
        @dump($errors)

        <form method="POST" action="{{ route('manager_project_building_movie_add', ['building' => $building->id, 'movie_type' => $movie_type]) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="movie_category_id" value="">
            <div class="item-row">
                <div class="item-row-title">カテゴリ</div>
                <div class="item-row-content">カテゴリ名が入ります</div>
            </div>
            <div class="item-row">
                <div class="item-row-title">タイトル</div>
                <div class="item-row-content">
                    <x-input-text type="text" name="title" class="w-80"
                                  id="title" placeholder="動画タイトル"
                                  :value="old('title')"
                                  :error="$errors->has('title')"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                </div>
            </div>
            <div class="item-row">
                <div class="item-row-title">URL</div>
                <div class="item-row-content">
                    <x-input-text type="url" name="url" class="w-80"
                                  id="url" placeholder="https://vimeo.com/XXXXXXXXXX"
                                  :value="old('url')"
                                  :error="$errors->has('url') || $errors->has('vimeo_id')"
                    />
                    <x-input-error :messages="$errors->get('url')" class="mt-1"/>
                    <x-input-error :messages="$errors->get('vimeo_id')" class="mt-1"/>
                </div>
            </div>
            <div class="flex-center-center">
                <input type="submit" class="btn" value="登録">
            </div>
        </form>
    </div>
</div>