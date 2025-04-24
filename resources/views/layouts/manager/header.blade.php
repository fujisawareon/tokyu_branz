<div class="header">
    <div class="container h-full flex justify-between items-center gap-2" >
        <div class="flex-start-center" style="gap: 1rem;">
            <div class="logo">MyBRANZ</div>
            @if(isset($building_name))
                <div class="">{{ $building_name }}</div>
            @endif
        </div>

        <div class="flex-start-center" style="gap: 1rem;">
            @if(isset($building_name))
                <a href="{{ route('manager_building_list') }}" class="navigation-btn active">物件一覧に戻る</a>
            @endif
            <div>ようこそ {{ Auth::guard('managers')->user()->name }} さん</div>
        </div>

    </div>
</div>