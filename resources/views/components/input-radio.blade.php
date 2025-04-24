@props([
    'name' => '',
    'id' => '',
    'options' => [],
    'value' => '',
])

@foreach($options as $option)
    <label class="custom-radio">
        <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}"
            id="{{ $id . '_' . $option['value'] }}"
               @if($option['value'] == $value)
                   checked="checked"
               @endif
            >
        <span class="radio-mark"></span>
        <span>{{ $option['label'] }}</span>
    </label>
@endforeach