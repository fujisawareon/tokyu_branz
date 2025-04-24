<x-app-manager-project-layout>

    <x-slot name="js">
        @vite([
            'resources/js/manager/project/customer/search.js',
            'resources/js/manager/project/customer/list.js',
        ])
    </x-slot>

    <x-slot name="css">
        @vite([
            'resources/scss/manager/project/customer-analysis.scss',
        ])
    </x-slot>

    <x-slot name="building_name">
        {{ $building->building_name }}
    </x-slot>

    @include('layouts.manager.navigation', ['num' => 2])

    <div class="main-contents">
        <div class="contents-area container" >
            @include('manager.project.customer.customer-search')

            <div class="flex gap-2 mb-3" style="border-bottom: solid 1px #555;">
                <input type="radio" id="tab1" name="tab" class="tab-radio-btn" value="1" checked>
                <label for="tab1" class="navigation-btn tab-label">顧客一覧</label>

                <input type="radio" id="tab2" name="tab" class="tab-radio-btn" value="2">
                <label for="tab2" class="navigation-btn tab-label">顧客別アクセス分析</label>

                <input type="radio" id="tab3" name="tab" class="tab-radio-btn" value="3">
                <label for="tab3" class="navigation-btn tab-label">コンテンツ別アクセス分析</label>
            </div>
            <div class="contents w-full">
                <div class="tab-content relative" id="customer-list-table-area">
                    @include('manager.project.customer.customer-list')
                </div>
                <div class="tab-content" id="customer-access-analysis-area">
                    @include('manager.project.customer.customer-access-analysis-list')
                </div>
                <div class="tab-content" id="contents-access-analysis-area">
                    作成中
                </div>
            </div>
        </div>
    </div>

</x-app-manager-project-layout>
