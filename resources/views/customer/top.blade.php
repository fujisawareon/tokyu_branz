<x-app-customer-layout>
    <x-slot name="view_name">
        マイページトップ
    </x-slot>

    <x-slot name="css">
        @vite(['resources/scss/customer/my_page.scss'])
    </x-slot>

    <div class="container-position">
        <div class="main-contents">
            @foreach($buildings as $building)
                <div class="building-box">
                    <div class="basic-data">
                        <div class="building-name">{{ $building->building_name }}</div>
                        <div class="building-thumbnail-image">
                            <img src="{{ asset('storage/building/' . $building->id .'/'. $building->thumbnail_image) }}" alt="">
                        </div>
                    </div>
                    <div class="details-area">
                        <div>{{ $building->buildingSetting->location }}</div>
                        <div>{{ $building->buildingSetting->nearest_station }}</div>
                        <div class="notice">
                            <div class="details-title">お知らせ</div>
                            <div>・お知らせがある場合は入ります</div>
                            <div>・お知らせがある場合は入ります</div>
                        </div>
                        <div class="sales-schedule-area p-2">
                            <div class="details-title">販売スケジュール</div>
                            <div class="flex" style="">
                                @foreach($building->filteredSalesSchedule as $sales_schedule)
                                    <div class="sales-schedule">
                                        <div class="flex mark" style="justify-content: center">
                                            @if(!$loop->last)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                                                    <circle cx="24" cy="24" r="20" fill="#002b5c" />
                                                    <path d="M15 24.5l6 7l12 -13" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                                                    <circle cx="24" cy="24" r="20" stroke="#b0c0d0" stroke-width="2" fill="none" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="schedule-name {{ $sales_schedule->schedule_key }}">{{ $sales_schedule_list[$sales_schedule->schedule_key] }}</div>
                                    </div>

                                    @if (!$loop->last)
                                        <div class="pt-4">
                                            {{-- 矢印SVG --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" width="22" height="22" fill="none">
                                                <path d="M2 10h16M12 2l8 8l-8 8" stroke="#002b5c" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="btn-area text-right">
                        <div class="action-btn-area">
                            <div class="inline-block mb-2">
                                <a href="{{ route('contents_customer', [
                                        'building' => $building->id,
                                        'page_name' => 'top']) }}"
                                   class="action-btn content-btn"
                                   target="_blank">限定コンテンツ</a>
                            </div>
                            @foreach($building->actionBtnSetting as $action_btn)
                                @if($action_btn->display_flg)
                                    <div class="inline-block mb-2">
                                        <a href="{{ $action_btn->url }}"
                                           class="action-btn" target="_blank">{{ $action_btn->button_name }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @if($building->buildingSetting->building_site_display_flg)
                            <div class="inline-block mb-2">
                                <a href="{{ $building->buildingSetting->building_site_url }}"
                                   class="action-btn building-site-btn" target="_blank">物件サイト</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-customer-layout>


