<x-app-manager-layout>

    <x-slot name="breadcrumb">
        <ol>
            <li><a href="{{ route('manager_dashboard') }}" class="link">{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('manager_building_list') }}" class="link">{{ __('Building') }}</a></li>
        </ol>
    </x-slot>

    <x-slot name="view_name">
        {{ __('Manager User') }}
    </x-slot>

    <div class="main-contents">
        <div>
            <a href="" type="button" class="btn">新しい業務ユーザーを登録する</a>
        </div>

        <div class="my-4">
            <input type="text" class="input-box" placeholder="ユーザー名">
            <input type="text" class="input-box" placeholder="メールアドレス">
            <select class="input-box">
                @foreach($role_list as $role)
                    <option value="{{ $role['value'] }}" >{{ $role['label'] }}</option>
                @endforeach
            </select>
            <input type="submit" class="btn" value="検索">
        </div>

        <div style="width: 1000px;">
            {{ $manager_list->appends(request()->input()) }}
            <table class="list-tbl">
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th style="width:160px;">権限</th>
                    <th style="width:200px;">最終ログイン日時</th>
                    <th style="width:90px;">設定</th>
                </tr>
                @foreach($manager_list as $manager)
                    <tr>
                        <td>{{ $manager->name }}</td>
                        <td>{{ $manager->email }}</td>
                        <td class="text-center">{{ \App\Models\Manager::ROLE_TYPE_LIST[$manager->role_type] }}</td>
                        <td>-</td>
                        <td class="text-center">
                            <a href="{{ route('manager_user_show', ['manager' => $manager->id]) }}" class="btn min">設定</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-manager-layout>
