<x-app-manager-layout>

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
            <form method="post" action="">
                @csrf
                @method('post')

                @php $building_name = $conditions['building_name']?? ''; @endphp
                <input type="text" name="building_name" class="input-box" value="{{ $building_name }}" placeholder="物件名">
                <select class="input-box">
                    @foreach($status_list as $status)
                        <option value="{{ $status['value'] }}" >{{ $status['label'] }}</option>
                    @endforeach
                </select>
                <input type="submit" class="btn" value="検索">
            </form>
        </div>

        <div style="width: 900px;">
            {{ $building_list->appends(request()->input()) }}
            <table class="list-tbl">
                <tr>
                    <th>物件名</th>
                    <th style="width: 120px;">販売ステータス</th>
                    <th style="width: 120px;">エントリー数</th>
                    <th style="width: 120px;">登録数</th>
                    <th style="width: 120px;">閲覧ページ数</th>
                    <th style="width: 90px;">物件設定</th>
                </tr>
                @foreach($building_list as $building)
                    <tr>
                        <td>
                            <a href="{{ route('manager_project_home', ['building' => $building->id]) }}" class="link">{{ $building->building_name }}</a>
                        </td>
                        <td class="text-center">{{ \App\Models\Building::SALES_STATUS[$building->sales_status] }}</td>
                        <td class="text-right num-count">
                            @if(isset($analytics_data['entry_count'][$building->id]))
                                {{ number_format($analytics_data['entry_count'][$building->id]) }}<span class="unit">名</span>
                            @else
                                0<span class="unit">名</span>
                            @endif
                        </td>

                        <td class="text-right">0名</td>

                        <td class="text-right num-count">
                            @if(isset($analytics_data['view_count'][$building->id]))
                                {{ number_format($analytics_data['view_count'][$building->id]) }}<span class="unit">PV</span>
                            @else
                                0<span class="unit">PV</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('manager_building_basic_setting', ['building' => $building->id]) }}" class="btn min">設定</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-manager-layout>
