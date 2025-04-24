<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager\Contents;

use App\Models\MasterData;
use App\Repositories\Interfaces\MasterDataRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property array $sales_schedule_key
 */
class SalesScheduleUpdateRequest extends FormRequest
{
    /**
     * リクエストに適用させる検証ルールを取得する
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        /** @var MasterDataRepositoryInterface $master_data_repository */
        $master_data_repository = app(MasterDataRepositoryInterface::class);
        $master_sales_schedules = $master_data_repository->getMasterDataByDataType(MasterData::SALES_SCHEDULE);
        $master_sales_schedules_key = $master_sales_schedules->pluck( 'data_key')->toArray();

        return [
            'sales_schedule_key' => ['nullable', 'array'], // 配列であること
            'sales_schedule_key.*' => ['required', Rule::in($master_sales_schedules_key)],
        ];
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
