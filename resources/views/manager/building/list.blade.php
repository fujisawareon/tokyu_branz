<x-app-manager-layout>

    <x-slot name="js">
        @vite([
            'resources/js/manager/building_list.js',
        ])
    </x-slot>

    <x-slot name="breadcrumb">
        <ol>
            <li><a href="{{ route('manager_dashboard') }}" class="link">{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('manager_building_list') }}" class="link">{{ __('Building') }}</a></li>
        </ol>
    </x-slot>

    <x-slot name="view_name">
        {{ __('Building List') }}
    </x-slot>

    <div class="main-contents">
        <div>
            <a href="{{ route('manager_building_create') }}" type="button" class="btn">新しい物件を登録する</a>
        </div>

        <div class="my-4">
            <input type="text" name="building_name" id="building_name" class="input-box" value="" placeholder="物件名">
            <select class="input-box" id="sales_status">
                @foreach($status_list as $status)
                    <option value="{{ $status['value'] }}" >{{ $status['label'] }}</option>
                @endforeach
            </select>
            <input type="submit" class="btn min" id="search_button" value="検索">
        </div>

        <div style="width: 1000px">
            <table id="customers_table" class="display nowrap list-tbl customer-list-tbl"
                   data-url="{{ route('manager_get_building_list') }}"
                   >
                <thead>
                <tr>
                    <th>物件名</th>
                    <th style="width: 150px;">販売ステータス</th>
                    <th style="width: 130px;">エントリー数</th>
                    <th style="width: 130px;">登録数</th>
                    <th style="width: 130px;">閲覧ページ数</th>
                    <th style="width: 100px;">編集</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</x-app-manager-layout>

<style>

    {{-- TODO 共通化したい --}}
    .top,
    .bottom {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-bottom: .25rem;
        margin-top: .25rem;

        .dt-paging-button {
            border: solid 1px #bbb !important;
        }
    }

    .table-number {
        font-variant-numeric: tabular-nums;
    }

    table.dataTable thead th.text-center {
        text-align: center !important;
    }

    table.dataTable thead th.text-right {
        text-align: right !important;
    }
</style>