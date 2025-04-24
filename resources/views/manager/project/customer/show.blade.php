<x-app-manager-project-layout>

    <x-slot name="js">
    </x-slot>

    <x-slot name="css">
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 2])
    <div class="breadcrumb">
        <ol class="container">
            <li><a href="{{ route('manager_project_customer', ['building' => $building->id]) }}"
                   class="link">顧客一覧</a></li>
            <li><a href="{{ route('manager_project_customer_show', ['building' => $building->id, 'customer' => $customer->id,]) }}"
                   class="link">顧客基本情報編集</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area container">

            <div class="mb-1" style="border-bottom: solid 1px var(--blue-200);padding: .5rem">
                {{ $customer->sei . $customer->mei }}&nbsp;({{ $customer->sei_kana . $customer->mei_kana }}) 様
            </div>

            @include('layouts.manager.customer_navigation', ['num' => 1])

            <div class="flex flex-wrap my-3 py-2" style="gap: 1rem;">
                <div class="one-contents" style="width: calc(50% - 0.5rem)">
                    <div class="one-contents-title">顧客基本情報</div>
                    <div class="item-row">
                        <div class="item-row-title">メールアドレス</div>
                        <div class="item-row-content flex-start-center">{{ $customer->email }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">住所</div>
                        <div class="item-row-content flex-start-center">
                            <div>
                                <div>{{ $customer_building->domestic_flag }}</div>
                                <div>{{ $customer_building->zip_code_3 . '-' . $customer_building->zip_code_4 }}</div>
                                <div>{{ $customer_building->prefecture . ' ' . $customer_building->city }}</div>
                                <div>{{ $customer_building->town . ' ' . $customer_building->chome }}</div>
                                <div>{{ $customer_building->banchi . ' ' . $customer_building->apartment_detail }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">電話番号</div>
                        <div class="item-row-content flex-start-center">{{ $customer->tel }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">希望面積</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->desired_area }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">予算</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->budget }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">住居予定人数</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->expected_residents }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">購入目的</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->purchase_purpose }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">状態</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->relation_status }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">ステータス</div>
                        <div class="item-row-content flex-start-center">{{ $customer->customer_status }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">基本スコア</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->base_score }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">行動スコア</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->behavior_score }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">スコア</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->score }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">担当</div>
                        <div class="item-row-content flex-start-center">
                            <select class="input-box w-60" name="role_type">
                                @foreach($person_charge_list as $person_charge)
                                    <option value="{{ $person_charge['value'] }}"
                                        @if($person_charge['value'] == $customer_building->person_in_charge) selected @endif>{{ $person_charge['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="one-contents" style="width: calc(50% - 0.5rem)">
                    <div class="one-contents-title">各ステータス更新</div>
                    <div class="item-row">
                        <div class="item-row-title">インナー</div>
                        <div class="item-row-content flex-start-center">
                            <x-input-accepted-checkbox name=""
                                                       id=""
                                                       :checked="($customer_status)?? false"
                            />
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">物件エントリー日時</div>
                        <div class="item-row-content flex-start-center">{{ $customer_building->entry_at }}</div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">ウェビナー動画視聴</div>
                        <div class="item-row-content flex-start-center">
                            <x-input-accepted-checkbox name=""
                                                       id=""
                                                       :checked="($customer_status)?? false"
                            /></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">オンライン商談予約</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">オンライン商談</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">フリー見学予約</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">フリー見学</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">初来場予約</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">初来場</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">要望受付</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">登録受付</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">お申込み</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">ご契約</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">お引渡し</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                    <div class="item-row">
                        <div class="item-row-title">検討中止</div>
                        <div class="item-row-content flex-start-center"></div>
                    </div>
                </div>
                <div class="flex-center-center w-full">
                    <input type="submit" class="btn" value="更新">
                </div>
            </div>

        </div>
    </div>

</x-app-manager-project-layout>

