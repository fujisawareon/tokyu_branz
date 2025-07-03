
<div class="modal-background" id="add_movie_category">
    <div class="modal" style="width: 600px;">
        <div class="modal-close">×</div>

        <div class="flex-end-center mb-2">
            <button type="button" class="btn min" id="" onclick="">カテゴリを追加</button>
        </div>

        <form method="POST" action="{{ route('building_movie_category_update', ['building' => $building->id, 'movie_type' => $movie_type]) }}" >
            @csrf

            <div class="list-element mb-2">
                <div class="list-element-header">
                    <div class="list-element-row">
                        <div style="width: 65px">並び順</div>
                        <div style="flex: 1">カテゴリー名</div>
                        <div style="width: 65px">削除</div>
                    </div>
                </div>
                <div class="" id="sortable_list">
                    @foreach($movie_list as $movie_category)
                        <div class="list-element-row">

                            <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">☰</div>
                            <div style="flex: 1" class="flex-center-center">

                                <x-input-text type="text" name="category_name" class="w-full"
                                              id="web_customer_id" placeholder="WEB顧客ID"
                                              :value="old('category_name', $movie_category->category_name)"
                                              :error="$errors->has('category_name')"/>
                            </div>
                            <div style="width: 65px" class="flex-center-center">
                                <button type="button" class="btn min color-red delete-btn" >削除</button>
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
