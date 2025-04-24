@props([
    'name' => '',
    'id' => '',
    'width_class' => '',
    'placeholder' => '',
    'options' => [],
    'values' => [],
])

<div class="custom-dropdown {{ $width_class }}">
    <div class="dropdown-input-wrapper" id="{{ $id }}">
        <input type="text" class="input-box dropdown-input" id="dropdown_text_{{ $id }}" placeholder="{{ $placeholder }}" readonly>
        <span class="dropdown-icon">▼</span>
    </div>

    <div class="dropdown-list" id="list_{{ $id }}">
        @foreach($options as $option)
            <x-input-accepted-checkbox name="{{ $name }}"
                                       id="{{ $id }}_{{ $option['value'] }}"
                                       value="{{ $option['value'] }}"
                                       data_label="{{ $option['label'] }}"
                                       label="{{ $option['label'] }}"
                                       :checked="in_array($option['value'],$values) "
            />
        @endforeach
    </div>
</div>

<style>


</style>
