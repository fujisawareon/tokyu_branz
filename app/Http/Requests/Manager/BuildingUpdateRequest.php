<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string building_name
 */
class BuildingUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $building = $this->route('building');
        return [
            'building_name' => [
                'required', 'string', 'between:1,50', Rule::unique('buildings')->ignore($building->id),
            ],
            'site_url_flg' => ['required', Rule::in(array_keys(\App\Consts\CommonConsts::SETTING_TYPE)),],
            'site_url' => ['nullable', 'required_if:site_url_flg,1', 'url',],
        ];
    }

    /**
     * バリデーションエラーメッセージを定義
     * @return array
     */
    public function messages(): array
    {
        return [
            'site_url.required_if' => ':attributeを設定する場合はURLを入力してください',
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
