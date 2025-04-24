@props([
    'name' => '',
    'id' => '',
    'options' => [],
    'values' => [],
])

@foreach($options as $option)
    <label class="custom">
        <input type="checkbox" name="{{ $name }}" value="{{ $option['value'] }}"
            id="{{ $id . '_' . $option['value'] }}"
               @if(in_array($option['value'], $values))
                   checked="checked"
               @endif
            >
        <span>{{ $option['label'] }}</span>
    </label>
@endforeach