@props([
    'name' => '',
    'options' => [],
    'value' => '',
    'default_class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
    'class' => '',
    'id' => '',
    'error' => false,
])

@if($error)
    @php
        $class .= ' error';
    @endphp
@endif

<select name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => $default_class . ' ' . $class]) }}
>

    @foreach($options as $option)
        <option value="{{ $option['value'] }}"
                @if(isset($option['parent']))
                    data-parent="{{ $option['parent'] }}"
                @endif
                @if($option['value'] == $value)
                    selected
                @endif
        >

            {{ $option['label'] }}
        </option>
    @endforeach

</select>
