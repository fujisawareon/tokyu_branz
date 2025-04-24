<x-app-manager-project-layout>

    <x-slot name="js">
    </x-slot>

    <x-slot name="css">
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 2])

    <div class="main-contents">
        <div class="contents-area container">
            <form method="POST" action="{{ route('manager_project_customer_register', ['building' => $building->id]) }}"
                  style="width: 800px;">
                @csrf

                <div class="item-row">
                    <div class="item-row-title require">名前</div>
                    <div class="item-row-content">
                        <div class="flex" style="gap: .25rem;">
                            <x-input-text type="text" name="sei" class="w-40"
                                          id="sei" placeholder="田中"
                                          :value="old('sei')"
                                          :error="$errors->has('sei')"/>
                            <x-input-text type="text" name="mei" class="w-40"
                                          id="mei" placeholder="太郎"
                                          :value="old('mei')"
                                          :error="$errors->has('mei')"/>
                        </div>
                        <x-input-error :messages="$errors->get('sei')" class="mt-1"/>
                        <x-input-error :messages="$errors->get('mei')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title require">フリガナ</div>
                    <div class="item-row-content">
                        <div class="flex" style="gap: .25rem;">
                            <x-input-text type="text" name="sei_kana" class="w-40"
                                          id="sei_kana" placeholder="田中"
                                          :value="old('sei_kana')"
                                          :error="$errors->has('sei_kana')"/>
                            <x-input-text type="text" name="mei_kana" class="w-40"
                                          id="mei_kana" placeholder="太郎"
                                          :value="old('mei_kana')"
                                          :error="$errors->has('mei_kana')"/>
                        </div>
                        <x-input-error :messages="$errors->get('sei_kana')" class="mt-1"/>
                        <x-input-error :messages="$errors->get('mei_kana')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title require">メールアドレス</div>
                    <div class="item-row-content">
                        <div class="flex" style="gap: .25rem;">
                            <x-input-text type="email" name="email" class="w-80"
                                          id="email" placeholder="sample@sample.jp"
                                          :value="old('email')"
                                          :error="$errors->has('email')"/>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">WEB顧客ID</div>
                    <div class="item-row-content">
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">住所</div>
                    <div class="item-row-content">
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">生年月日</div>
                    <div class="item-row-content">
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">性別</div>
                    <div class="item-row-content"></div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">電話番号</div>
                    <div class="item-row-content"></div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">職業</div>
                    <div class="item-row-content"></div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">予算</div>
                    <div class="item-row-content"></div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">年収（本人）</div>
                    <div class="item-row-content"></div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">年収（世帯全体）</div>
                    <div class="item-row-content"></div>
                </div>

                <div class="flex-center-center">
                    <input type="submit" class="btn" value="登録">
                </div>
            </form>
        </div>
    </div>

</x-app-manager-project-layout>

