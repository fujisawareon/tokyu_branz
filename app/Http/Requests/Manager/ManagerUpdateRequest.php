<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $building_name
 */
class ManagerUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required',],
        ];
    }

    /**
     * バリデーションエラーメッセージを定義
     * @return array
     */
    public function messages(): array
    {
        return [
            'building_8_digit_code.regex' => ':attributeは、半角英数字と数字で入力してください',
            'building_4_digit_code.regex' => ':attributeは、半角英数字と数字で入力してください',
            'top_image.required_if' => 'デザインをデフォルトにする場合は:attributeを設定してください',
        ];
    }

    /**
     * カスタム属性名を定義
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }
}
