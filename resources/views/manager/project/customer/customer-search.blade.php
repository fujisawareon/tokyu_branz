
@include('components.scripts.daterangepicker')

<div class="search-area">
    <div class="accordion">
        <div class="accordion-title" id="search_1">顧客情報から検索</div>
        <div class="accordion-content flex-start-center flex-wrap" id="search_content_1" style="gap: .5rem; display: none;">

            <x-input-drop-down-checkbox name="person_in_charge[]"
                                        width_class="w-40"
                                        id="person_in_charge" placeholder="担当者"
                                        :options="$person_list"
                                        :values="old('person_in_charge', [])"
                                        :error="$errors->has('person_in_charge')"/>
            <x-input-text type="text" name="web_id" class="w-32"
                          id="web_customer_id" placeholder="WEB顧客ID"
                          :value="old('web_id',  '')"
                          :error="$errors->has('web_id')"/>
            <x-input-text type="text" name="sei" class=""
                          id="sei" placeholder="姓（セイ）"
                          autocomplete="off"
                          :value="old('sei')"
                          :error="$errors->has('sei')"/>
            <x-input-text type="text" name="mei" class=""
                          id="mei" placeholder="名（メイ）"
                          autocomplete="off"
                          :value="old('mei')"
                          :error="$errors->has('mei')"/>
            <x-input-text type="text" name="email" class="w-64"
                          id="email" placeholder="メールアドレス"
                          :value="old('email')"
                          :error="$errors->has('email')"/>
            <x-input-text type="text" name="address" class=""
                          id="address" placeholder="住所"
                          :value="old('address')"
                          :error="$errors->has('address')"/>
            <div class="flex-center-center" style="gap: .25rem;">
                <x-input-text type="text" name="min_desired_area" class="w-32"
                              id="min_desired_area" placeholder="最低希望面積"
                              :value="old('min_desired_area')"
                              :error="$errors->has('min_desired_area')"/>
                <div>～</div>
                <x-input-text type="text" name="max_desired_area" class="w-32"
                              id="max_desired_area" placeholder="最大希望面積"
                              :value="old('max_desired_area')"
                              :error="$errors->has('max_desired_area')"/>
            </div>
            <div class="flex-center-center" style="gap: .25rem;">
                <x-input-text type="text" name="min_expected_residents" class="w-40"
                              id="min_expected_residents" placeholder="最低入居予定人数"
                              :value="old('min_expected_residents')"
                              :error="$errors->has('min_expected_residents')"/>
                <div>～</div>
                <x-input-text type="text" name="max_expected_residents" class="w-40"
                              id="max_expected_residents" placeholder="最大入居予定人数"
                              :value="old('max_expected_residents')"
                              :error="$errors->has('max_expected_residents')"/>
            </div>
            <x-input-text type="text" name="purchase_purpose" class="w-48"
                          id="purchase_purpose" placeholder="購入目的"
                          :value="old('purchase_purpose')"
                          :error="$errors->has('purchase_purpose')"/>
            <x-input-drop-down-checkbox name="status[]"
                                        width_class="w-48"
                                        id="status" placeholder="ステータス"
                                        :options="$status_list"
                                        :values="old('status', [])"
                                        :error="$errors->has('status')"/>
            <x-input-drop-down-checkbox name="relation_status[]"
                                        width_class="w-32"
                                        id="relation_status" placeholder="状態"
                                        :options="$relation_status_list"
                                        :values="old('relation_status', [])"
                                        :error="$errors->has('relation_status')"/>
            <x-input-text type="text" name="entry_date" class="w-60 date-rang-text"
                          id="entry_date" placeholder="物件エントリー日"
                          autocomplete="off"
                          :value="old('entry_date')"
                          :error="$errors->has('entry_date')"/>

            <x-input-accepted-checkbox name="first_registration_flag"
                                       id="first_registration_flag"
                                       label="初回登録未完了の顧客のみ"
            />
        </div>
    </div>
    <div class="accordion">
        <div class="accordion-title" id="search_2">アクセス期間から検索</div>
        <div class="accordion-content" id="search_content_2" style="display: none;">
            @for ($i = 1; $i <= 3; $i++)
                <div class="flex-start-center access-row" >
                    <x-input-accepted-checkbox name="access_{{ $i }}"
                                      id="access_{{ $i }}"
                                      label="条件{{ $i }}を指定"
                    />
                    <div class="flex-start-center" style="gap: .25rem;">
                        <div>期間</div>
                        <x-input-text type="text" name="date_range" class="w-60 date-rang-text"
                                      id="period_{{ $i }}" placeholder="期間"
                                      :value="old('')"
                                      :error="$errors->has('')"/>
                    </div>
                    <div class="flex-start-center" style="gap: .25rem;">
                        <div>閲覧</div>
                        <div class="flex" style="gap: .5rem; flex-wrap: wrap;">
                            <x-input-radio name="contents_design_flg_{{ $i }}" class=""
                                           id="contents_design_flg_{{ $i }}"
                                           :options=" \App\Consts\CommonConsts::PRESENCE_STATUS"
                                           :value="old('contents_design_flg_{{ $i }}', 1)"
                                           :error="$errors->has('contents_design_flg_{{ $i }}')"
                            />
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="flex-start-center" style="gap: 1rem;">
        <input type="submit" class="btn min" id="search_button" value="検索">
        <input type="button" class="btn min color-gray" id="reset_button" value="リセット">
        <x-input-accepted-checkbox name="include_pin_filter"
                                   id="include_pin_filter"
                                   label="検索条件をピン止め顧客にも適用する"
        />
    </div>

</div>
