<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager\Contents;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @property int $category_id
 * @property int $movie_category_id
 * @property string $title
 * @property string $url
 * @property string $vimeo_id
 */
class BinderCategoryUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_name' => ['array'],
            'category_name.*' => ['required', 'string'],
        ];
    }

    /**
     * バリデーションエラーメッセージを定義
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }

    /**
     * カスタム属性名を定義
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => 'タイトル',
            'vimeo_id' => 'URLのVimeo_ID',
        ];
    }
}
