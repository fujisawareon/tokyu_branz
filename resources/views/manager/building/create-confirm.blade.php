<x-app-manager-layout>

    <x-slot name="breadcrumb">
        <ol>
            <li><a href="{{ route('manager_dashboard') }}" class="link">{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('manager_building_create') }}" class="link">{{ __('Building Create') }}</a></li>
        </ol>
    </x-slot>

    <x-slot name="view_name">
        {{ __('Building Create') }}
    </x-slot>

    <div class="main-contents">
        <div style="width: 700px;padding: 1rem 0;">
            <form method="POST" action="{{ route('manager_building_register') }}">
                @csrf
                @method('post')
                <input type="hidden" name="flow_token" value="{{ $request['flow_token'] }}" >
                <div class="item-row">
                    <div class="item-row-title">物件名</div>
                    <div class="item-row-content flex-start-center">{{ $request['building_name'] }}</div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">物件8桁コード</div>
                    <div class="item-row-content">
                        {{ $request['building_8_digit_code'] }}
                        <div class="support-msg">※物件管理システムの8桁コード</div>
                        <div class="support-msg">※物件登録後の変更は出来ません</div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">物件4桁コード</div>
                    <div class="item-row-content">
                        {{ $request['building_4_digit_code'] }}
                        <div class="support-msg">※物件管理システムの4桁コード</div>
                        <div class="support-msg">※物件登録後の変更は出来ません</div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">デザイン</div>
                    <div class="item-row-content">
                        {{ \App\Consts\CommonConsts::CUSTOM_TYPE[$request['contents_design_flg']]['label'] }}
                        <div class="support-msg">※URLの変更はできません</div>
                        <div class="support-msg">※物件登録後の変更はできません</div>
                    </div>
                </div>
                @if(isset($request['top_image']))
                    <div class="item-row">
                        <div class="item-row-title">TOP画像</div>
                        <div class="item-row-content flex-start-center">
                            <div class="image">
                                <img src="{{ asset('storage/tmp/' . $request['top_image']) }}" alt="">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="item-row">
                    <div class="item-row-title">物件サムネイル画像</div>
                    <div class="item-row-content flex-start-center">
                        <div class="image">
                            <img src="{{ asset('storage/tmp/' . $request['thumbnail_image']) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">所在</div>
                    <div class="item-row-content flex-start-center">{{ $request['location'] }}</div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">最寄り</div>
                    <div class="item-row-content flex-start-center">
                        {!! nl2br(e($request['nearest_station'])) !!}
                    </div>
                </div>
                <div style="display: flex;">
                    <input type="submit" class="btn" style="margin: 0 auto;" value="登録">
                </div>
            </form>
        </div>

    </div>
</x-app-manager-layout>


