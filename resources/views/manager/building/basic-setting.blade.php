<x-app-manager-layout>

    <x-slot name="breadcrumb">
        <ol>
            <li><a href="{{ route('manager_dashboard') }}" class="link">{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('manager_building_list') }}" class="link">{{ __('Building') }}</a></li>
            <li><a href="{{ route('manager_building_basic_setting', ['building' => $building->id]) }}" class="link">{{ __('Building Basic Setting') }}</a></li>
        </ol>
    </x-slot>

    <x-slot name="view_name">
        {{ __('Building Basic Setting') }}
    </x-slot>

    <div style="padding: .25rem;">
        選択中の物件&nbsp;：&nbsp;<a href="" class="link">{{ $building->building_name }}</a>
    </div>

    <div class="main-contents">
        <div style="width: 900px;padding: 1rem 0;">
            <form method="post" action="{{ route('manager_building_update', ['building' => $building->id]) }}">
                @csrf
                @method('post')

                <div class="item-row">
                    <div class="item-row-title">物件名</div>
                    <div class="item-row-content">
                        <x-input-text type="text" name="building_name" class="w-80"
                                      id="building_name" placeholder="物件名"
                                      :value="old('building_name', $building->building_name)"
                                      :error="$errors->has('building_name')"/>
                        <x-input-error :messages="$errors->get('building_name')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">物件8桁コード</div>
                    <div class="item-row-content flex-start-center">
                        {{ $building->building_8_digit_code }}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">物件4桁コード</div>
                    <div class="item-row-content flex-start-center">
                        {{ $building->building_4_digit_code }}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">デザイン</div>
                    <div class="item-row-content flex-start-center">
                        {{ \App\Consts\CommonConsts::CUSTOM_TYPE[$building->contents_design_flg]['label'] }}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">TOP画像</div>
                    <div class="item-row-content" style="display: flex;align-items: end; gap: 1rem;">
                        @if($building->top_image)
                            <div class="image">
                                <img src="{{ asset('storage/building/' . $building->id .'/'. $building->top_image) }}" alt="">
                            </div>
                        @endif
                        <input type="file">
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">物件サムネイル画像</div>
                    <div class="item-row-content" style="display: flex;align-items: end; gap: 1rem;">
                        @if($building->top_image)
                            <div class="image">
                                <img src="{{ asset('storage/building/' . $building->id .'/'. $building->thumbnail_image) }}" alt="">
                            </div>
                        @endif
                        <input type="file">
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
                    <input type="submit" class="btn" style="margin: 0 auto;" value="更新">
                </div>
            </form>
        </div>
    </div>
</x-app-manager-layout>


