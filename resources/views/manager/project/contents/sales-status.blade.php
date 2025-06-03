<x-app-manager-project-layout>

    <x-slot name="js">
        @vite(['resources/js/manager/contents/sales_status.js'])
    </x-slot>

    <x-slot name="css">
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 3])

    <div class="breadcrumb">
        <ol class="container">
            <li><a href="{{ route('manager_project_contents', ['building' => $building->id]) }}"
                   class="link">コンテンツ管理</a></li>
            <li><a href="{{ route('manager_project_sales_status', ['building' => $building->id]) }}" class="link">販売ステータス設定</a>
            </li>
        </ol>
    </div>

    <div class="main-contents">
        <div class="contents-area" style="width: 800px">

            @include('layouts.manager.flash_message')
            <div class="page-name">販売ステータス設定</div>

            <form method="POST" action="">
                @csrf
                @method('post')

                <div class="item-row">
                    <div class="item-row-title">状態</div>
                    <div class="item-row-content">
                        <div class="flex">
                            <div class="flex" style="gap: 1rem; flex-wrap: wrap;">
                                <x-input-radio name="sales_status" class=""
                                               id="sales_status"
                                               :options="$sales_status"
                                               :value="old('sales_status',$building->sales_status)"
                                               :error="$errors->has('sales_status')"
                                />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('sales_status')" class="mt-1"/>
                        <div class="support-msg">※準備中は全顧客が限定コンテンツを閲覧できません</div>
                        <div class="support-msg">※契約完売は契約をした顧客だけが限定コンテンツを閲覧できません</div>
                        <div class="support-msg">※引渡完売は全顧客が限定コンテンツを閲覧できません</div>
                    </div>
                </div>
                <div class="item-row" id="display-title" style="display: none;">
                    <div class="item-row-title">表示タイトル</div>
                    <div class="item-row-content">
                        <div class="flex" style="gap: .25rem;">
                            <x-input-text type="text" name="title" class="w-full"
                                          id="title" placeholder="全戸申込御礼"
                                          :value="old('title', ($building->buildingSetting->sales_suspension_title)?? null)"
                                          :error="$errors->has('title')"/>
                        </div>
                        <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                    </div>
                </div>
                <div class="item-row" id="display-message" style="display: none;">
                    <div class="item-row-title">表示メッセージ</div>
                    <div class="item-row-content">
                        <div class="flex" style="gap: .25rem;">
                            <textarea name="message" rows="8"
                                      class="input-box w-full">{{ old('message', ($building->buildingSetting->sales_suspension_message)?? null) }}</textarea>
                        </div>
                        <x-input-error :messages="$errors->get('message')" class="mt-1"/>
                    </div>
                </div>
                <div style="display: flex;">
                    <input type="submit" class="btn" style="margin: 0 auto;" value="更新">
                </div>
            </form>

        </div>
    </div>

</x-app-manager-project-layout>
