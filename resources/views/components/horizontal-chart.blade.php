@props([
    'data_list' => [],
    'max_value' => 0,
    'unit' => '件',
])

<div class="horizontal-chart-area">
    <div class="horizontal-chart-back"></div>
    @foreach($data_list as $data)
        <div class="horizontal-chart-row">
            <div class="horizontal-chart-title flex {{ isset($data['children']) ? 'pointer' :''}}">
                <span class="toggle-arrow {{ isset($data['children']) ? '' : 'invisible' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" fill="currentColor" />
                    </svg>
                </span>
                <span class="toggle-title">{{ $data['title'] }}</span>
            </div>
            <div class="horizontal-chart-line">
                <div class="horizontal-chart-bar" data-width="{{ $data['value'] / $max_value * 100 }}">
                    <p class="horizontal-chart-value"><span class="counter count-font" data-target="{{ $data['value'] }}">0</span>{{ $unit }}</p>
                </div>
            </div>
            <div class="horizontal-chart-space"></div>
        </div>

        @if(isset($data['children']))
            <div class="w-full child-row" style="display: none;">
                @foreach($data['children'] as $children)
                    <div class="horizontal-chart-row">
                    <div class="horizontal-chart-title">　&nbsp;└&nbsp;{{ $children['title'] }}</div>
                        <div class="horizontal-chart-line">
                            <div class="horizontal-chart-bar" data-width="{{ $children['value'] / $max_value * 100 }}">
                                <p class="horizontal-chart-value"><span class="counter count-font" data-target="{{ $children['value'] }}">0</span>{{ $unit }}</p>
                            </div>
                        </div>
                        <div class="horizontal-chart-space"></div>
                    </div>
                @endforeach
            </div>
        @endif

    @endforeach
</div>

