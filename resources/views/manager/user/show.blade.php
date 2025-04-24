<x-app-manager-layout>

    <x-slot name="js">
        @vite(['resources/js/manager/manager_show.js'])
    </x-slot>

    <x-slot name="view_name">
        {{ __('Manager User') }}
    </x-slot>

    <div class="main-contents">
        <div class="heading-menu">基本情報</div>
        <div class="p-3" style="width: 550px;">
            <form method="POST" action="{{ route('manager_user_update', ['manager' => $manager->id]) }}">
                @csrf
                <div class="item-row">
                    <div class="item-row-title">ユーザー名</div>
                    <div class="item-row-content flex-start-center">{{ $manager->name }}</div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">メールアドレス</div>
                    <div class="item-row-content flex-start-center">{{ $manager->email }}</div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">権限</div>
                    <div class="item-row-content">
                        <select class="input-box" name="role_type">
                            @foreach($role_list as $role)
                                <option value="{{ $role['value'] }}"
                                        @if($role['value'] == $manager->role_type) selected @endif>{{ $role['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-row-title">状態</div>
                    <div class="item-row-content flex-start-center">
                        <div class="flex" style="gap: 1rem; flex-wrap: wrap;">
                            <x-input-radio name="status" class=""
                                           id="status"
                                           :options="\App\Consts\CommonConsts::STATUS_TYPE"
                                           :value="old('status',$manager->status)"
                                           :error="$errors->has('status')"
                            />
                        </div>
                    </div>
                </div>
                <div class="my-1 flex-center-center">
                    <input type="submit" class="btn" value="更新">
                </div>
            </form>

        </div>

        @if($manager->role_type >= \App\Models\Manager::ROLE_TYPE_EMPLOYEE)
            <div class="heading-menu">招待済み物件</div>
            <div class="p-3" style="width: 550px;">
                <p>※権限が「販売担当者」である場合に、利用可能な物件と物件に対する役割です</p>

                <input type="submit" class="btn min my-2" id="building_invitation_add_btn" value="物件招待">
                <table class="list-tbl">
                    <tr>
                        <th style="width: 500px">物件名</th>
                        <th style="width: 250px">役割</th>
                        <th style="width: 80px">削除</th>
                    </tr>
                    @foreach($manager->invitationBuilding as $invitation_building)
                        <tr>
                            <td>{{ $invitation_building->building->building_name }}</td>
                            <td>
                                <select class="input-box" name="role_type">
                                    @foreach($building_role_list as $building_role)
                                        <option value="{{ $building_role['value'] }}"
                                            @if($building_role['value'] == $invitation_building->role) selected @endif>{{ $building_role['label'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="submit" class="btn min color-red" value="削除">
                            </td>
                        </tr>
                    @endforeach

                </table>
                <div class="my-1 flex-center-center">
                    <input type="submit" class="btn" value="更新">
                </div>
            </div>

            {{-- モーダル --}}
            <div class="" id="building_invitation_add" style="display: none;">
                <div class="building-invitation-add-area">
                    <div id="modal_close"></div>
                    <form method="POST" action="{{ route('manager_user_building_invitation', ['manager' => $manager->id]) }}">
                        @csrf
                        <div class="flex mb-4" style="gap: 1rem; flex-wrap: wrap;">
                            <x-input-checkbox name="select_building[]" class=""
                                              id="select_building"
                                              :options="$all_building_list"
                                              :values="[]"
                                              :error="$errors->has('select_building')"
                            />
                        </div>
                        <div class="w-full flex-center-center">
                            <input type="submit" class="btn" value="招待">
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-manager-layout>

<style>
    #building_invitation_add {
        position: absolute;
        background: #1118;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
    }

    .building-invitation-add-area {
        position: relative;
        background: white;
        padding: 1rem;
        width: 90%;
        max-width: 1200px;
        margin: 100px auto;
    }

    #modal_close {
        position: absolute;
        top: -25px;
        right: -25px;
        width: 50px;
        height: 50px;
        background: black;
        color:white;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
    }

    #modal_close:after {
        content: "×";
        font-size: 3rem;
        transition: .2s;
    }
    #modal_close:hover:after {
        transform: rotate(45deg);
    }
</style>
