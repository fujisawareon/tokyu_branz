


<table id="customers_access_analysis_table"  class="display nowrap list-tbl customers-access-analysis-table"
       data-url="{{ route('manager_project_get_customer_access_analysis_list', ['building' => $building->id]) }}"
       data-building="{{ $building->id }}"
>
    <thead>
    <tr>
        <th style="width: 120px;">WEB顧客ID</th>
        <th style="width: 70px;">ログ詳細</th>
        <th style="width: 300px;">名前</th>
        <th style="width: 300px;">担当</th>

        <th>スケジュール</th>
        <th>ウェビナー動画</th>
        <th>紹介動画</th>
        <th>間取</th>
        <th>専有部VR</th>
        <th>平面眺望図<br>シミュレーション</th>
        <th>日影<br>シミュレーション</th>
        <th>画像ギャラリー</th>
        <th>周辺マップ</th>
        <th>物件資料集</th>
        <th>ローンシミュレーション</th>
    </tr>
    </thead>
</table>