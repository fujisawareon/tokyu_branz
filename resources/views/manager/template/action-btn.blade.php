
<template id="action-btn-template">
    <div class="list-element-row" style="align-items: stretch;">
        <div style="width: 65px; cursor: grab;" class="drag-handle flex-center-center">☰</div>
        <div style="width: 200px;">
            @verbatim
                <input type="text" name="button_name[${id}]" class="input-box w-full" id="button_name[${id}]" placeholder="来場予約" required>
            @endverbatim
        </div>
        <div style="flex: 1">
            @verbatim
                <input type="url" name="url[${id}]" class="input-box w-full" id="url[${id}]" placeholder="URL" required>
            @endverbatim
        </div>
        <div style="width: 65px;" class="flex-center-center">
            <label class="custom-checkbox">
                <input type="checkbox" class="checkbox-icon" name="display_flg[${id}]" value="1" id="display_flg_${id}">
                <span class="checkmark"></span>
            </label>
        </div>
        <div style="width: 65px;" class="flex-center-center">
            <button type="button" class="btn min color-red delete-btn">削除</button>
        </div>
    </div>
</template>
