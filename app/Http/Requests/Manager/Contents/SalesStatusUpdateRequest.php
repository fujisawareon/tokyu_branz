<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager\Contents;

use App\Models\Building;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * 販売ステータス更新時のリクエストクラス
 * @property int $sales_status
 * @property string $title
 * @property string $message
 */
class SalesStatusUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $other_on_sale = [
            Building::SALES_STATUS_BEFORE_SALE,
            Building::SALES_STATUS_CONTRACT_SOLD_OUT,
            Building::SALES_STATUS_DELIVERY_SOLD_OUT,
        ];
        return [
            'sales_status' => ['required', Rule::in(array_keys(Building::SALES_STATUS))],
            'title' => [Rule::requiredIf(in_array($this->input('sales_status'), $other_on_sale))],
            'message' => [Rule::requiredIf(in_array($this->input('sales_status'), $other_on_sale))],
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
            'title' => '表示タイトル',
            'message' => '表示メッセージ',
        ];
    }
}
