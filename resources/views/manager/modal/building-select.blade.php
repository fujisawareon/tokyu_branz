
<div class="modal-background" id="building_select">
    <div class="modal" style="width: 800px;">
        <div class="modal-close">×</div>
        <form method="POST">
            @csrf
            <div class="flex mb-2" style="gap: 1rem; flex-wrap: wrap;">
                <x-input-checkbox name="select_building[]" class=""
                                  id="select_building"
                                  :options="$building_list"
                                  :values="$selected_building_ids"
                                  :error="$errors->has('select_building')"
                />
            </div>
            <input type="submit" class="btn" id="" value="選択する">
        </form>
    </div>
</div>
