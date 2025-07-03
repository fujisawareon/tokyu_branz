
<div class="modal-background" id="add_binder_category_modal">
    <div class="modal" style="width: 600px;">
        <div class="modal-close">×</div>

        <div class="flex-end-center mb-2">
            <button type="button" class="btn min" id="add_binder_category" onclick="">カテゴリを追加</button>
        </div>

        <form method="POST" action="{{ route('manager_project_binder_category_update', ['building' => $building->id]) }}" >
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
                    @foreach($binder_building_category as $category)
                        <div class="list-element-row">
                            <input type="hidden" name="id[{{ $category->id }}]" value="{{ $category->id }}">
                            <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">☰</div>
                            <div style="flex: 1" class="flex-center-center">
                                <x-input-text type="text" name="category_name[{{ $category->id }}]" class="w-full"
                                              id="category_name" placeholder="WEB顧客ID"
                                              :value="old('category_name', $category->category_name)"
                                              :error="$errors->has('category_name')"/>
                            </div>
                            <div style="width: 65px" class="flex-center-center">
                                <button type="submit"
                                        form="delete-form-{{ $category->id }}"
                                        class="btn min color-red"
                                        onclick="return confirm('本当に削除しますか？\nこの操作は取り消せません。')">削除</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex-center-center">
                <input type="submit" class="btn" value="更新">
            </div>
        </form>

        {{-- 削除用フォームたち（form外） --}}
        @foreach($binder_building_category as $category)
                <form method="POST" id="delete-form-{{ $category->id }}" action="{{ route('manager_project_binder_category_delete', [
                    'building' => $building->id,
                    'binder_building_category' => $category->id
                ]) }}"
                  style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach


        {{-- 行を追加する時の複製用テンプレート --}}
        <template id="add_binder_category_template">
            <div class="list-element-row" style="align-items: stretch;">
                <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">☰</div>
                <div style="flex: 1">
                    @verbatim
                        <input type="text" name="category_name[${id}]" class="input-box w-full" id="category_name[${id}]" placeholder="カテゴリー名" required>
                    @endverbatim
                </div>
                <div style="width: 65px;" class="flex-center-center">
                    <button type="button" class="btn min color-red new-category-delete-btn">削除</button>
                </div>
            </div>
        </template>
    </div>
</div>


@php
    $maxId = $binder_building_category->max('id') ?? 0;
@endphp

<script>
    let max_category_id = @json($maxId);
</script>

