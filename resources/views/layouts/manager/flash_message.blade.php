<?php
$success_list = session(\App\Consts\SessionConst::FLASH_MESSAGE_SUCCESS);
$error_list = session(\App\Consts\SessionConst::FLASH_MESSAGE_ERROR);
?>

@if ($success_list || $error_list || $errors->has('validate_display'))
    <div class="flash-area">
        <div class="flash-message-area">
            {{-- サクセスメッセージ --}}
            @if ($success_list)
                @foreach ($success_list as $success)
                    <div class="flash-message-box flash-message-success">
                        <div class="flash-message-box-close">×</div>
                        {{ $success }}
                    </div>
                @endforeach
            @endif

            {{-- エラーメッセージ --}}
            @if ($error_list)
                @foreach ($error_list as $error)
                    <div class="flash-message-box flash-message-error">
                        <div class="flash-message-box-close">×</div>
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            {{-- バリデーションにおけるエラーメッセージ --}}
            @if ($errors->has('validate_display'))
                @foreach ($errors->get('validate_display') as $error)
                    <div class="flash-message-box flash-message-error">
                        <div class="flash-message-box-close">×</div>
                        {{ $error }}
                    </div>
                @endforeach
            @endif

        </div>
    </div>
@endif