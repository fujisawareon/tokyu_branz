<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerBuilding;
use App\Repositories\Interfaces\CustomerPinRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    private CustomerRepositoryInterface $customer_repository;
    private CustomerPinRepositoryInterface $customer_pin_repository;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->customer_repository = app(CustomerRepositoryInterface::class);
        $this->customer_pin_repository = app(CustomerPinRepositoryInterface::class);
    }

    /**
     * 「顧客分析」画面の「顧客一覧表」の作成に使用するクエリを作成する
     * @param int $building_id
     * @param array $request
     * @return Builder
     */
    public function makeCustomerListQuery(int $building_id, array $request): Builder
    {
        $manager_id = Auth::guard('managers')->user()->id;

        $select = [
            'customers.*',  // 必要な項目に絞ること
            'customer_building.relation_status',
            'customer_building.budget',
            DB::raw("CONCAT(customer_building.city, ' ', customer_building.town) AS address"),
            'customer_building.expected_residents',
            'customer_building.purchase_purpose',
            'customer_building.person_in_charge',
            'customer_building.desired_area',
            'customer_building.base_score',
            'customer_building.behavior_score',
            'customer_building.score',
            'customer_building.customer_status',
            'managers.name as manager_name',
            DB::raw('CASE WHEN customer_pins.customer_id IS NULL THEN 0 ELSE 1 END AS is_pinned'),
        ];

        $query = Customer::select($select)
            ->join('customer_building', 'customers.id', '=', 'customer_building.customer_id')
            ->leftJoin('managers', 'customer_building.person_in_charge', '=', 'managers.id')
            ->leftJoin('customer_pins', function ($join) use ($building_id, $manager_id) {
                $join->on('customers.id', '=', 'customer_pins.customer_id')
                    ->where('customer_pins.manager_id', $manager_id)
                    ->where('customer_pins.building_id', $building_id)
                    ->whereNull('customer_pins.deleted_at');
            })
            ->where('customer_building.building_id', $building_id)
            ->orderByDesc('is_pinned'); // ← ピン止めは常に上に表示させる

        // 「検索条件をピン止め顧客にも適用する」にチェックが入っていない
        if (!$request['include_pin_filter']) {
            if ($this->hasCondition($request)) {
                $query->where(function ($q) use ($request, $building_id, $manager_id) {
                    // ピン止めされている顧客は無条件で表示
                    $q->whereExists(function ($sub) use ($manager_id, $building_id) {
                        $sub->select(DB::raw(1))
                            ->from('customer_pins')
                            ->whereColumn('customer_pins.customer_id', 'customers.id')
                            ->where('customer_pins.manager_id', $manager_id)
                            ->where('customer_pins.building_id', $building_id)
                            ->whereNull('customer_pins.deleted_at');
                    });

                    // ピン止めされていない顧客に対する条件
                    $q->orWhere(function ($subQuery) use ($request) {
                        // 担当者
                        if (isset($request['person_in_charge'])) {
                            $subQuery->whereIn('customer_building.person_in_charge', $request['person_in_charge']);
                        }

                        // WEB顧客ID
                        if (isset($request['web_customer_id'])) {
                            $subQuery->where('customers.web_customer_id', 'LIKE', '%' . $request['web_customer_id'] . '%');
                        }

                        // 姓
                        if (isset($request['sei'])) {
                            // 全角スペースを半角スペースに変換して、空白で分割
                            $keywords = preg_split('/\s+/', mb_convert_kana($request['sei'], 's'));

                            $subQuery->where(function ($query) use ($keywords) {
                                foreach ($keywords as $word) {
                                    $query->where(function ($q) use ($word) {
                                        $q->where('sei', 'LIKE', "%$word%")
                                            ->orWhere('sei_kana', 'LIKE', "%$word%");
                                    });
                                }
                            });
                        }

                        // 姓
                        if (isset($request['mei'])) {
                            // 全角スペースを半角スペースに変換して、空白で分割
                            $keywords = preg_split('/\s+/', mb_convert_kana($request['mei'], 's'));

                            $subQuery->where(function ($query) use ($keywords) {
                                foreach ($keywords as $word) {
                                    $query->where(function ($q) use ($word) {
                                        $q->where('mei', 'LIKE', "%$word%")
                                            ->orWhere('mei_kana', 'LIKE', "%$word%");
                                    });
                                }
                            });
                        }


                        // 初回登録未完了の顧客のみ
                        if (isset($request['first_registration_flag'])) {
                            $subQuery->where('customers.first_registration_flag', 0);
                        }

                    });
                });
            }
        } else { // 「検索条件をピン止め顧客にも適用する」にチェックが入っている
            // 担当者
            if (isset($request['person_in_charge'])) {
                $query->whereIn('customer_building.person_in_charge', $request['person_in_charge']);
            }

            // WEB顧客ID
            if (isset($request['web_customer_id'])) {
                $query->where('customers.web_customer_id', 'LIKE', '%' . $request['web_customer_id'] . '%');
            }

            // 姓
            if (isset($request['sei'])) {
                // 全角スペースを半角スペースに変換して、空白で分割
                $keywords = preg_split('/\s+/', mb_convert_kana($request['sei'], 's'));

                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $word) {
                        $query->where(function ($q) use ($word) {
                            $q->where('sei', 'LIKE', "%$word%")
                                ->orWhere('sei_kana', 'LIKE', "%$word%");
                        });
                    }
                });
            }

            // 姓
            if (isset($request['mei'])) {
                // 全角スペースを半角スペースに変換して、空白で分割
                $keywords = preg_split('/\s+/', mb_convert_kana($request['mei'], 's'));

                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $word) {
                        $query->where(function ($q) use ($word) {
                            $q->where('mei', 'LIKE', "%$word%")
                                ->orWhere('mei_kana', 'LIKE', "%$word%");
                        });
                    }
                });
            }

            // 初回登録未完了の顧客のみ
            if (isset($request['first_registration_flag'])) {
                $query->where('customers.first_registration_flag', 0);
            }
        }

        // メールアドレス
        // 住所
        // 最低希望面積
        // 最大希望面積
        // 最低入居予定人数
        // 最大入居予定人数
        // 購入目的
        // ステータス
        // 状態
        // 物件エントリー日

        return $query;
    }

    /**
     * @return Builder
     */
    public function makeCustomerAccessAnalysisQuery(int $building_id, array $request): Builder
    {

        $manager_id = Auth::guard('managers')->user()->id;

        $select = [
            'customers.*',
            'customer_building.relation_status',
            'customer_building.budget',
            DB::raw("CONCAT(customer_building.city, ' ', customer_building.town) AS address"),
            'customer_building.expected_residents',
            'customer_building.purchase_purpose',
            'customer_building.person_in_charge',
            'customer_building.desired_area',
            'customer_building.base_score',
            'customer_building.behavior_score',
            'customer_building.score',
            'customer_building.customer_status',
            'managers.name as manager_name',
            DB::raw('CASE WHEN customer_pins.customer_id IS NULL THEN 0 ELSE 1 END AS is_pinned'),
        ];

        $query = Customer::select($select)
            ->join('customer_building', 'customers.id', '=', 'customer_building.customer_id')
            ->leftJoin('managers', 'customer_building.person_in_charge', '=', 'managers.id')
            ->leftJoin('customer_pins', function ($join) use ($building_id, $manager_id) {
                $join->on('customers.id', '=', 'customer_pins.customer_id')
                    ->where('customer_pins.manager_id', $manager_id)
                    ->where('customer_pins.building_id', $building_id)
                    ->whereNull('customer_pins.deleted_at');
            })
            ->where('customer_building.building_id', $building_id)
            ->orderByDesc('is_pinned'); // ← ピン止めは常に上に表示させる

        return $query;
    }


    /**
     * 顧客を作成して返却する
     * @param array $param
     * @return Customer
     */
    public function createCustomer(array $param): Customer
    {
        return $this->customer_repository->createCustomer($param);
    }

    /**
     * 顧客と物件のリレーションを作成する
     * @param int $customer_id
     * @param int $building_id
     * @return CustomerBuilding
     */
    public function createCustomerBuildingRelation(int $customer_id, int $building_id): CustomerBuilding
    {
        return $this->customer_repository->createCustomerBuildingRelation($customer_id, $building_id);
    }

    /**
     * 顧客一覧のピン止めのつけ外しを行なう
     * @param int $building_id
     * @param int $customer_id
     * @return void
     */
    public function togglePin(int $building_id, int $customer_id): void
    {
        $manager_id = Auth::guard('managers')->user()->id;
        $customer_pin = $this->customer_pin_repository->getRecord($building_id, $manager_id, $customer_id);

        if ($customer_pin) {
            $this->customer_pin_repository->delete($customer_pin);
        } else {
            $this->customer_pin_repository->create([
                'manager_id' => $manager_id,
                'building_id' => $building_id,
                'customer_id' => $customer_id,
            ]);
        }

    }

    /**
     * リクエストに検索条件が含まれているか判定する
     * @param array $request
     * @return bool
     */
    private function hasCondition(array $request): bool
    {
        // チェック対象となる条件のキーを配列で定義
        $condition_keys = [
            'person_in_charge', // 担当者
            'web_customer_id',
            'sei',
            'mei',
            'first_registration_flag', // 初回登録未完了の顧客のみ
        ];

        // リクエストの中にいずれかの条件が含まれているかをチェック
        $has_conditions = false;
        foreach ($condition_keys as $key) {
            if (!empty($request[$key])) {
                $has_conditions = true;
                break;
            }
        }

        return $has_conditions;
    }

}
