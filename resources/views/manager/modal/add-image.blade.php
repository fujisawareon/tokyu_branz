
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

