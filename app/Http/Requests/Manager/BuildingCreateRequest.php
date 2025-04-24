<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $building_name
 * @property string $building_8_digit_code
 * @property string $building_4_digit_code
 * @property int $site_url_flg
 * @property string $site_url
 * @property int $contents_url_flg
 * @property $top_image TODO
 * @property $thumbnail_image
 */
class BuildingCreateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'building_name' => ['required', 'string', 'between:1,50', 'unique:buildings,building_name',],
            'building_8_digit_code' => ['required', 'string', 'regex:/^[a-zA-Z0-9_]+$/', 'size:8',],
            'building_4_digit_code' => ['required', 'string', 'regex:/^[a-zA-Z0-9_]+$/', 'size:4',],
            'contents_design_flg' => ['required', Rule::in(array_keys(\App\Consts\CommonConsts::CUSTOM_TYPE)),],
            'top_image' => ['required_if:contents_design_flg,0', 'image', 'max:10240', ],
            'thumbnail_image' => ['required', 'image', 'max:10240', ],
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
