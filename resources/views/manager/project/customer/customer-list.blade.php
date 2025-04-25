
<div class="absolute flex-end-center gap-2 mb-2" style="right: 0;z-index: 50;">
    <a href="{{ route('manager_project_customer_create', ['building' => $building->id]) }}" class="btn min">顧客登録</a>
    <button class="btn min color-red">削除</button>
    <button class="btn min" id="display_setting_btn">項目表示設定</button>
</div>

<table id="customers_table" class="display nowrap list-tbl customer-list-tbl"
       data-url="{{ route('manager_project_get_customer_list', ['building' => $building->id]) }}"
       data-building="{{ $building->id }}">
    <thead>
    <tr>
        <th style="width: 60px;">
            <div class="flex-center-center">
                <x-input-accepted-checkbox name="customers"
                                           id="customers"
                />
            </div>
        </th>
        <th style="width: 70px;">詳細</th>
        <th style="width: 120px;">WEB顧客ID</th>
        <th>名前</th>
        <th>担当</th>

        <th>住所</th>
        <th>希望面積</th>
        <th>予算</th>
        <th>住居<br>予定人数</th>
        <th>購入目的</th>
        <th>ステータス</th>
        <th>基本スコア</th>
        <th>行動スコア</th>
        <th>総合スコア</th>
        <th>状態</th>
        <th>最終ログイン</th>
        <th>ピン止め</th>
    </tr>
    </thead>
</table>

<div class="modal-background" id="display_setting_modal">
    <div class="modal" style="width: 400px">
        <div class="modal-close">×</div>
        <div class="mb-2">表示したい項目にチェックを入れてください</div>
        <form method="POST" action="{{ route('manager_project_customer_show_column', ['building' => $building->id]) }}">
            @csrf
            <div class="item-row">
                <div class="item-row-title">住所</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[1]"
                                               id="display_"
                                               value="address"
                                               :checked="in_array('address', $display_customer_list_columns)"
                    />
                </div>
            </div>
            <div class="item-row">
                <div class="item-row-title">希望面積</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[2]"
                                               id="display_"
                                               value="desired_area"
                                               :checked="in_array('desired_area', $display_customer_list_columns)"
                    />
                </div>
            </div>

            <div class="item-row">
                <div class="item-row-title">予算</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[3]"
                                               id="display_"
                                               value="budget"
                                               :checked="in_array('budget', $display_customer_list_columns)"
                    />
                </div>
            </div>
            <div class="item-row">
                <div class="item-row-title">住居予定人数</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[4]"
                                               id="display_"
                                               value="expected_residents"
                                               :checked="in_array('expected_residents', $display_customer_list_columns)"
                    />
                </div>
            </div>
            <div class="item-row">
                <div class="item-row-title">購入目的</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[5]"
                                               id="display_"
                                               value="purchase_purpose"
                                               :checked="in_array('purchase_purpose', $display_customer_list_columns)"
                    />
                </div>
            </div>
            <div class="item-row">
                <div class="item-row-title">ステータス</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[6]"
                                               id="display_"
                                               value="customer_status"
                                               :checked="in_array('customer_status', $display_customer_list_columns)"
                    />
                </div>
            </div>
            @if($manager->role_type <= \App\Models\Manager::ROLE_TYPE_EMPLOYEE)
                <div class="item-row">
                    <div class="item-row-title">基本スコア</div>
                    <div class="item-row-content flex-start-center">
                        <x-input-accepted-checkbox name="display[7]"
                                                   id="display_"
                                                   value="base_score"
                                                   :checked="in_array('base_score', $display_customer_list_columns)"
                        />
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">行動スコア</div>
                    <div class="item-row-content flex-start-center">
                        <x-input-accepted-checkbox name="display[8]"
                                                   id="display_"
                                                   value="behavior_score"
                                                   :checked="in_array('behavior_score', $display_customer_list_columns)"
                        />
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">総合スコア</div>
                    <div class="item-row-content flex-start-center">
                        <x-input-accepted-checkbox name="display[9]"
                                                   id="display_"
                                                   value="score"
                                                   :checked="in_array('score', $display_customer_list_columns)"
                        />
                    </div>
                </div>
            @endif
            <div class="item-row">
                <div class="item-row-title">状態</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[10]"
                                               id="display_"
                                               value="relation_status"
                                               :checked="in_array('relation_status', $display_customer_list_columns)"
                    />
                </div>
            </div>
            <div class="item-row">
                <div class="item-row-title">最終ログイン日時</div>
                <div class="item-row-content flex-start-center">
                    <x-input-accepted-checkbox name="display[11]"
                                               id="display_"
                                               value="last_login_at"
                                               :checked="in_array('last_login_at', $display_customer_list_columns)"
                    />
                </div>
            </div>
            <div class="w-full flex-center-center">
                <input type="submit" class="btn" value="更新">
            </div>
        </form>
    </div>
</div>

<script>
    const displayColumns = @json($display_customer_list_columns);
</script>
