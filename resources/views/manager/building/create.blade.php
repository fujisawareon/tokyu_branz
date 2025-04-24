<x-app-manager-layout>

    <x-slot name="breadcrumb">
        <ol>
            <li><a href="{{ route('manager_dashboard') }}" class="link">{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('manager_building_list') }}" class="link">{{ __('Building') }}</a></li>
            <li><a href="{{ route('manager_building_create') }}" class="link">{{ __('Building Create') }}</a></li>
        </ol>
    </x-slot>

    <x-slot name="view_name">
        {{ __('Building Create') }}
    </x-slot>

    <div class="main-contents">
        <div style="width: 700px;padding: 1rem 0;">
            <form method="post" action="{{ route('manager_building_create_confirm') }}" enctype="multipart/form-data">
                @csrf
                @method('post')

                <div class="item-row">
                    <div class="item-row-title require">物件名</div>
                    <div class="item-row-content">
                        <x-input-text type="text" name="building_name" class="w-80"
                                      id="building_name" placeholder="物件名"
                                      :value="old('building_name')"
                                      :error="$errors->has('building_name')"/>
                        <x-input-error :messages="$errors->get('building_name')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title require">物件8桁コード</div>
                    <div class="item-row-content">
                        <x-input-text type="text" name="building_8_digit_code" class="w-80"
                                      id="building_8_digit_code" placeholder="XXXXXXXX"
                                      :value="old('building_8_digit_code')"
                                      :error="$errors->has('building_8_digit_code')"/>
                        <x-input-error :messages="$errors->get('building_8_digit_code')" class="mt-1"/>
                        <div class="support-msg">※物件管理システムの8桁コード</div>
                        <div class="support-msg">※物件登録後の変更は出来ません</div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title require">物件4桁コード</div>
                    <div class="item-row-content">
                        <x-input-text type="text" name="building_4_digit_code" class="w-80"
                                      id="building_4_digit_code" placeholder="XXXX"
                                      :value="old('building_4_digit_code')"
                                      :error="$errors->has('building_4_digit_code')"/>
                        <x-input-error :messages="$errors->get('building_4_digit_code')" class="mt-1"/>
                        <div class="support-msg">※物件管理システムの4桁コード</div>
                        <div class="support-msg">※物件登録後の変更は出来ません</div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title require">デザイン</div>
                    <div class="item-row-content">
                        <div class="flex">
                            <div class="flex" style="gap: 1rem; flex-wrap: wrap;">
                                <x-input-radio name="contents_design_flg" class=""
                                               id="contents_design_flg"
                                               :options=" \App\Consts\CommonConsts::CUSTOM_TYPE"
                                               :value="old('contents_design_flg', 0)"
                                               :error="$errors->has('contents_design_flg')"
                                />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('contents_design_flg')" class="mt-1"/>
                        <div class="support-msg">※URLの変更はできません</div>
                        <div class="support-msg">※物件登録後の変更はできません</div>
                        <div class="support-msg">※カスタムデザインをする場合はさら社にご依頼ください</div>
                    </div>
                </div>
                <div class="item-row" id="sssssssssss">
                    <div class="item-row-title require">TOP画像</div>
                    <div class="item-row-content">
                        <input type="file" name="top_image">
                        <x-input-error :messages="$errors->get('top_image')" class="mt-1"/>
                        <div class="support-msg">※限定コンテンツのTOP画像となります</div>
                        <div class="support-msg">※登録可能な拡張子は.jpg, .jpeg, .pngとなります</div>
                        <div class="support-msg">※ファイルサイズは5MBまでとなります</div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title require">物件サムネイル画像</div>
                    <div class="item-row-content">
                        <input type="file" name="thumbnail_image">
                        <x-input-error :messages="$errors->get('thumbnail_image')" class="mt-1"/>
                        <div class="support-msg">※顧客のマイページの物件一覧で表示されます</div>
                        <div class="support-msg">※登録可能な拡張子は.jpg, .jpeg, .pngとなります</div>
                        <div class="support-msg">※ファイルサイズは2MBまでとなります</div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">所在</div>
                    <div class="item-row-content">
                        <x-input-text type="text" name="aaaaaaaa" class="w-80"
                                      id="" placeholder="東京都港区"
                                      :value="old('aaaaaaaa')"
                                      :error="$errors->has('aaaaaaaa')"/>
                        <x-input-error :messages="$errors->get('aaaaaaaa')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">最寄り</div>
                    <div class="item-row-content">
                        <textarea type="file" name="bbbbbbbbbb" class="input-box w-80" placeholder="都営新宿線〇〇駅徒歩〇〇分&#13;&#10;都営新宿線〇〇駅徒歩〇〇分">{{ old('bbbbbbbbbb') }}</textarea>
                        <x-input-error :messages="$errors->get('bbbbbbbbbb')" class="mt-1"/>
                    </div>
                </div>
                <div style="display: flex;">
                    <input type="submit" class="btn" style="margin: 0 auto;" value="確認">
                </div>
            </form>
        </div>
    </div>
</x-app-manager-layout>


