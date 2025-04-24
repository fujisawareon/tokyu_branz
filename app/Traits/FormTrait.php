<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait FormTrait
{
    /**
     * コレクション型の配列をSELECTで利用できる配列に変換する
     * @param Collection $collections
     * @param string $value_name
     * @param string $label_name
     * @param array $first_item
     * @return array
     */
    private function convertCollectionToSelectArray(Collection $collections, string $value_name, string $label_name, array $first_item = []): array
    {
        $array = [];
        // 一番最初に入れたい要素があれば追加しておく ※「選択してください」等の要素
        if ($first_item) {
            $array[] = [
                'value' => $first_item['value'],
                'label' => $first_item['label'],
            ];
        }
        foreach ($collections as $collection) {
            $data = [
                'value' => $collection->$value_name,
                'label' => $collection->$label_name,
            ];

            $array[] = $data;
        }
        return $array;
    }

    /**
     * 配列をSELECTで利用できる配列に変換する
     * @param array $list
     * @param string|null $value_name
     * @param string|null $label_name
     * @param array $first_item
     * @return array
     */
    private function convertSelectArray(array $list, ?string $value_name = null, ?string $label_name = null, array $first_item = []): array
    {
        $array = [];
        // 一番最初に入れたい要素があれば追加しておく ※「選択してください」等の要素
        if ($first_item) {
            $array[] = [
                'value' => $first_item['value'],
                'label' => $first_item['label'],
            ];
        }
        foreach ($list as $key => $item) {
            $data = [];
            if ($value_name) {
                $data['value'] = $item[$value_name];
            } else {
                $data['value'] = $key;
            }
            if ($label_name) {
                $data['label'] = $item[$label_name];
            } else {
                $data['label'] = $item;
            }
            $array[] = $data;
        }
        return $array;
    }

    /**
     * クエリビルダーのWHERE句にLikeで付与する
     * @param Builder $query
     * @param string $column_name
     * @param string $value_string
     * @return Builder
     */
    private function setLikeWhere(Builder $query, string $column_name, string $value_string): Builder
    {
        $value = mb_convert_kana($value_string, 's', 'UTF-8'); // 全角スペースを半角スペースに変更
        $value_array = preg_split('/\s/', $value); // 半角スペースで配列に変換
        $list = array_filter($value_array, function ($item) { // 空の配列削除
            return !empty($item);
        });

        // WHERE 句を作成していく
        foreach ($list as $item) {
            $query->where($column_name, 'LIKE', '%' . $item . '%');
        }
        return $query;
    }


}
