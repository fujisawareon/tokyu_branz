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
class AddMovieRequest extends FormRequest
{
    const VIMEO_MOVIE_URL = 'https://vimeo.com/';

    protected function prepareForValidation(): void
    {
        $url = $this->input('url');

        if (Str::startsWith($url, self::VIMEO_MOVIE_URL)) {
            $trimmed = Str::after($url, self::VIMEO_MOVIE_URL);

            $vimeo_id = preg_split('/[\/?#]/', $trimmed)[0]; // スラッシュや?や#で区切る
            $this->merge([
                'vimeo_id' => $vimeo_id,
            ]);
        }
    }

    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'movie_category_id' => ['required'],
            'title' => ['required'],
            'url' => ['required', 'starts_with:' . self::VIMEO_MOVIE_URL],
            'vimeo_id' => ['required', 'max:10', 'regex:/^\d+$/'], // 数字かつ10桁以下
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
