
<div class="modal-background" id="add_movie_modal">
    <div class="modal" style="width: 700px;">
        <div class="modal-close">×</div>
        @dump($errors)

        <form method="POST" action="{{ route('manager_project_binder_add', ['building' => $building->id]) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category_id" value="">
            <div class="item-row">
                <div class="item-row-title">カテゴリ</div>
                <div class="item-row-content" id="modal_category_name">カテゴリ名が入ります</div>
            </div>
            <div class="item-row">
                <div class="item-row-title">ファイル形式</div>
                <div class="item-row-content">
                    <div class="flex">
                        <div class="flex" style="gap: 1rem; flex-wrap: wrap;">
                            <x-input-radio name="file_type" class=""
                                           id="file_type"
                                           :options="\App\Consts\CommonConsts::BINDER_FILE_TYPE"
                                           :value="old('file_type', 0)"
                                           :error="$errors->has('file_type')"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-row" id="pdf_file">
                <div class="item-row-title">ファイル</div>
                <div class="item-row-content">
                    <input type="file" name="pdf_file" accept="application/pdf">
                    <x-input-error :messages="$errors->get('pdf_file')" class="mt-1"/>
                    <div class="support-msg">※登録可能な拡張子は.pdf のみとなります</div>
                </div>
            </div>
            <div class="item-row" id="thumbnail">
                <div class="item-row-title">サムネイル</div>
                <div class="item-row-content">
                    <input type="file" name="thumbnail_file" accept="image/jpeg,image/png,image/webp">
                    <x-input-error :messages="$errors->get('thumbnail_file')" class="mt-1"/>
                    <div class="support-msg">※登録可能な拡張子は.jpg, .jpeg, .png, .webpとなります</div>

                </div>
            </div>
            <div class="item-row" id="url">
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
            <div class="item-row">
                <div class="item-row-title">登録名</div>
                <div class="item-row-content">
                    <x-input-text type="text" name="binder_name" class="w-80"
                                  id="binder_name" placeholder="登録名"
                                  :value="old('binder_name')"
                                  :error="$errors->has('binder_name')"/>
                    <x-input-error :messages="$errors->get('binder_name')" class="mt-1"/>
                </div>
            </div>
            <div class="flex-center-center">
                <input type="submit" class="btn" value="登録">
            </div>
        </form>
    </div>
</div>