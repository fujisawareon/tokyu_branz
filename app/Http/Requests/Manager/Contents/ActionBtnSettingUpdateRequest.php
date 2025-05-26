<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager\Contents;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $building_site_url
 * @property string $building_site_display_flg
 * @property array $button_name
 * @property array $url
 * @property array $display_flg
 */
class ActionBtnSettingUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 物件サイト
            'building_site_url' => ['nullable', 'required_if:building_site_display_flg,1', 'url'],
            'building_site_display_flg' => ['sometimes', 'in:1'],

            // アクションボタン
            'button_name' => ['nullable','array'],
            'button_name.*' => ['required', 'string', 'max:20'],
            'url' => ['nullable', 'array'],
            'url.*' => ['required', 'url'],
            'display_flg' => ['nullable', 'array'],
            'display_flg.*' => ['in:1'],
        ];
    }

    /**
     * カスタムバリデーション
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $button_names = $this->button_name ?? [];
            $urls = $this->url ?? [];
            $display_flags = $this->display_flg ?? [];

            // button_name と url のキー一致を確認
            if (array_keys($button_names) !== array_keys($urls)) {
                $validator->errors()->add('validate_display', 'ボタン名とURLが一致していません。');
            }

            // display_flg のキーが button_name に存在しているか確認
            foreach ($display_flags as $key => $value) {
                if (!array_key_exists($key, $button_names)) {
                    $validator->errors()->add('validate_display', '表示に不正な値が含まれています');
                }
            }
        });
    }

    /**
     * バリデーションエラーメッセージを定義
     * @return array
     */
    public function messages(): array
    {
        return [
            'building_site_url.required_if' => '表示する場合はURLを設定して下さい。',
        ];
    }

    /**
     * カスタム属性名を定義
     * @return array
     */
    public function attributes(): array
    {
        return [
            'building_site_url' => '物件サイトURL',
            'building_site_display_flg' => '物件サイトの表示値',
            'button_name.*' => 'ボタン名',
            'url.*' => 'URL',
        ];
    }
}
