@props([
    'type' => 'text',
    'require' => false,
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'disabled' => false,
    'error' => false,
    'default_class' => 'input-box ',
    'class' => '',
])

@if($error)
    @php
        $class .= ' error';
    @endphp
@endif

<input type="{{ $type }}" name="{{ $name }}"
       {{ $attributes->merge(['class' => $default_class . ' ' . $class]) }}
       id="{{ $id }}"
       placeholder="{{ $placeholder }}"
       {{ $disabled ? 'disabled' : '' }}
>
