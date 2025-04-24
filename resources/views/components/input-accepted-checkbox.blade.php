@props([
    'name' => '',
    'id' => '',
    'value' => '1',
    'checked' => false,
    'label' => '',
    'data_label' => '',
])
<label class="custom-checkbox">
    <input type="checkbox" class="checkbox-icon" name="{{ $name }}" value="{{ $value }}" id="{{ $id }}"
           @if($data_label)
               data-label="{{ $data_label }}"
           @endif
           @if($checked) checked="checked" @endif
    >
    <span class="checkmark"></span>

    @if($label)
        <span class="checkbox-label">{{ $label }}</span>
    @endif
</label>