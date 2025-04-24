<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager\Contents;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array<int, string> $limited_content
 * @property ?array<string, int> $display
 */
class LimitedContentsUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'limited_content' => ['nullable', 'array'], // 配列であること
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $limited = $this->input('limited_content', []);
            $display = $this->input('display', []);

            $invalid_keys = array_diff(array_keys($display), $limited);

            if (!empty($invalid_keys)) {
                $validator->errors()->add('display', '不正な値が選択されました');
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
            'sales_schedule_key.*.in' => '不正なカテゴリが設定されています',
        ];
    }

    /**
     * カスタム属性名を定義
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => '表示タイトル',
            'message' => '表示メッセージ',
        ];
    }
}
