<div class="header">
    <div class="container-position h-full flex justify-between items-center gap-2" >
        <div class="flex-start-center" style="gap: 1rem;">
            <div class="logo">MyBRANZ</div>
            @if(isset($building_name))
                <div class="">{{ $building_name }}</div>
            @endif
        </div>

        <div class="flex-start-center" style="gap: 1rem;">
            <div>ようこそ {{ Auth::guard('customers')->user()->sei . Auth::guard('customers')->user()->mei }} さん</div>
        </div>
    </div>
</div>