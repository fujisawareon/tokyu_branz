import $ from "jquery";
import {Datatables} from '../../../common/datatables.js';
import 'datatables.net-dt/css/dataTables.dataTables.css'
import 'datatables.net-fixedcolumns';

import 'datatables.net-fixedheader-dt';

const buildingId = document.querySelector('#customers_table').dataset.building;
const customerListAjaxUrl = document.querySelector('#customers_table').dataset.url;
const customerAccessAnalysisAjaxUrl = document.querySelector('#customers_access_analysis_table').dataset.url;
let customerListTable = null;
let customerAccessAnalysisTable = null;

document.addEventListener("DOMContentLoaded", () => {

    // 顧客一覧表を作成
    function loadCustomerListTable() {
        if (customerListTable) {
            // 既に初期化されているので再描画
            customerListTable.ajax.reload();
        } else {
            customerListTable = $('#customers_table').DataTable({
                language: Datatables.language(),
                dom: Datatables.dom(),
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true, // 横スクロール有効
                lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                pageLength: 20,
                scrollCollapse: true,
                ajax: {
                    url: customerListAjaxUrl,
                    type: 'GET',
                    data: function (d) {
                        const params = makeConditions();
                        Object.assign(d, params);
                    },
                },
                order: [],
                fixedColumns: {
                    leftColumns: 5 // 左5列を固定
                },
                fixedHeader: true,
                createdRow: function (row, data, dataIndex) {
                    const isInvalidStatus = data.status_label === '無効';
                    const isInvalidCustomerStatus = ['検討中止'].includes(data.customer_status_label); // 任意の値を追加

                    if (isInvalidStatus || isInvalidCustomerStatus) {
                        $(row).addClass('disabled-row');
                    }

                },
                columns: [
                    {
                        // チェックボックス
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<label class="custom-checkbox">
                                <input type="checkbox" class="checkbox-icon" name="customers[]" value="${row.id}">
                                <span class="checkmark"></span>
                            </label>`;
                        },
                    }, {
                        // 詳細
                        data: 'actions',
                        className: 'text-center',
                        name: 'actions',
                        render: function (data, type, row, meta) {
                            return `<a href="/manager/building/${buildingId}/customer-show/${row.id}"
                        class="btn min" target="_blank">詳細</a>`;
                        },
                        orderable: false,
                    }, {
                        // WEB顧客ID
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        orderable: true,  // ← ソート
                        searchable: false  // ← ついでに検索も無効にする場合
                    },
                    {
                        // 名前
                        data: 'name',
                        name: 'name',
                        render: function (data, type, row, meta) {
                            let fullName = row.sei + ' ' + row.mei;
                            let fullKana = row.sei_kana + ' ' + row.mei_kana;
                            return `<span style="font-size: .8rem; color: gray;">${fullKana}</span>
                            <div>${fullName}</div>`;
                        },
                        searchable: false // 検索対象外にしたい場合
                    }, {
                        // 担当
                        name: 'person_in_charge',
                        data: 'person_in_charge',
                        render: function (data, type, row, meta) {
                            return row.manager_name ?? '';
                        },
                        orderable: true,
                        searchable: false
                    }, {
                        // 住所
                        data: 'address',
                        name: 'address',
                        visible: displayColumns.includes('address'),
                        searchable: false,
                    }, {
                        // 希望面積
                        data: 'desired_area',
                        name: 'desired_area',
                        visible: displayColumns.includes('desired_area'),
                        className: 'text-right',
                        render: (data) => {
                            if (data == null || data === '') return '';
                            return `${Number(data).toLocaleString()} <span style="font-size: .8rem; color: gray;">㎡</span>`;
                        },
                        searchable: false,
                    }, {
                        // 予算
                        data: 'budget',
                        name: 'budget',
                        visible: displayColumns.includes('budget'),
                        className: 'text-right',
                        render: (data) => {
                            if (data == null || data === '') return '';
                            return `${Number(data).toLocaleString()} <span style="font-size: .8rem; color: gray;">万円</span>`;
                        },
                        searchable: false
                    }, {
                        // 住居予定人数
                        data: 'expected_residents',
                        name: 'expected_residents',
                        visible: displayColumns.includes('expected_residents'),
                        className: 'text-right',
                        render: (data) => {
                            if (data == null || data === '') return '';
                            return `${Number(data).toLocaleString()} <span style="font-size: .8rem; color: gray;">人</span>`;
                        },
                        searchable: false
                    }, {
                        // 購入目的
                        data: 'purchase_purpose',
                        name: 'purchase_purpose',
                        visible: displayColumns.includes('purchase_purpose'),
                    }, {
                        // ステータス
                        data: 'customer_status',
                        name: 'customer_status',
                        visible: displayColumns.includes('customer_status'),
                        render: function (data, type, row) {
                            return `${row.customer_status_label}`;
                        },
                    }, {
                        // 基本スコア
                        data: 'base_score',
                        name: 'base_score',
                        visible: displayColumns.includes('base_score'),
                    }, {
                        // 行動スコア
                        data: 'behavior_score',
                        name: 'behavior_score',
                        visible: displayColumns.includes('behavior_score'),
                    }, {
                        // 総合スコア
                        data: 'score',
                        name: 'score',
                        visible: displayColumns.includes('score'),
                    }, {
                        // 状態
                        data: 'status_label',
                        name: 'status_label',
                        visible: displayColumns.includes('relation_status'),
                    }, {
                        // 最終ログイン
                        data: 'last_login_at',
                        name: 'last_login_at',
                        visible: displayColumns.includes('last_login_at'),
                        render: function (data, type, row) {
                            if (data == null || data === '') return '';
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }
                    }, {
                        // ピン止め
                        data: 'is_pinned',
                        name: 'is_pinned',
                        render: function (data, type, row, meta) {
                            const path = data
                                ? `<path d="m634-448 86 77v60H510v241l-30 30-30-30v-241H240v-60l80-77v-332h-50v-60h414v60h-50v332Z" fill-rule="evenodd"/>`
                                : `<path d="m634-448 86 77v60H510v241l-30 30-30-30v-241H240v-60l80-77v-332h-50v-60h414v60h-50v332Zm-313 77h312l-59-55v-354H380v354l-59 55Zm156 0Z"/>`;
                            return `
                        <div class="flex-center-center">
                            <button class="pin-btn" data-id="${row.id}">
                                <svg class="rotated-icon" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px"
                                     viewBox="0 -960 960 960" fill="var(--manager-main-color)">
                                     ${path}
                                </svg>
                            </button>
                        </div>
                    `;
                        },

                        orderable: false,    // ユーザーによるソート不要
                        searchable: false,
                    },
                ]
            });
        }
    }

    // 顧客別アクセス分析一覧表を作成
    function loadCustomerAccessAnalysisTable() {
        if (customerAccessAnalysisTable) {
            // 既に初期化されているので再描画
            customerAccessAnalysisTable.ajax.reload();
        } else {
            customerAccessAnalysisTable = $('#customers_access_analysis_table').DataTable({
                language: Datatables.language(),
                dom: Datatables.dom(),
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true, // 横スクロール有効
                lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                pageLength: 20,
                scrollCollapse: true,
                ajax: {
                    url: customerAccessAnalysisAjaxUrl,
                    type: 'GET',
                    data: function (d) {
                        const params = makeConditions();
                        Object.assign(d, params);
                    },
                },
                order: [],
                fixedColumns: {
                    leftColumns: 4 // 左4列を固定
                },
                fixedHeader: true,
                createdRow: function (row, data, dataIndex) {
                    const isInvalidStatus = data.status_label === '無効';
                    const isInvalidCustomerStatus = ['検討中止'].includes(data.customer_status_label); // 任意の値を追加

                    if (isInvalidStatus || isInvalidCustomerStatus) {
                        $(row).addClass('disabled-row');
                    }

                },
                columns: [
                    {
                        // WEB顧客ID
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        orderable: true,  // ← ソート
                        searchable: false  // ← ついでに検索も無効にする場合
                    }, {
                        // 詳細  // TODO URL作成したら修正する事
                        data: 'actions',
                        className: 'text-center',
                        name: 'actions',
                        render: function (data, type, row, meta) {
                            return `<a href="/manager/building/${buildingId}/customer-show/${row.id}"
                        class="btn min" target="_blank">詳細</a>`;
                        },
                        orderable: false,
                    }, {
                        // 名前
                        data: 'name',
                        name: 'name',
                        render: function (data, type, row) {
                            let fullName = row.sei + ' ' + row.mei;
                            let fullKana = row.sei_kana + ' ' + row.mei_kana;
                            return `<span style="font-size: .8rem; color: gray;">${fullKana}</span>
                            <div>${fullName}</div>`;
                        },
                        searchable: false // 検索対象外にしたい場合

                    }, {
                        // 担当
                        name: 'person_in_charge',
                        data: 'person_in_charge',
                        render: function (data, type, row) {
                            return row.manager_name ?? '';
                        },
                        orderable: true,
                        searchable: false
                    }, {
                        // スケジュール
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // オンラインセミナー動画
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 紹介動画
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 間取
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 専有部VR
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 平面眺望図シミュレーション
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 日影シミュレーション
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 画像ギャラリー
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 周辺マップ
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // 物件資料集
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }, {
                        // ローンシミュレーション
                        data: 'web_customer_id',
                        name: 'web_customer_id',
                        searchable: false,
                    }
                ]
            });
        }
    }

    // 検索条件を作成する
    function makeConditions() {
        return {
            // 顧客情報から検索 ===================================================
            person_in_charge: $('input[name="person_in_charge[]"]:checked') // 担当者
                .map(function () {
                    return $(this).val();
                }).get(),
            web_customer_id: $('#web_customer_id').val(),
            sei: $('#sei').val(), // 姓（セイ）
            mei: $('#mei').val(), // 名（メイ）
            email: $('#email').val(), // メールアドレス
            address: $('#address').val(), // 住所
            min_desired_area: $('#min_desired_area').val(), // 最低希望面積
            max_desired_area: $('#max_desired_area').val(), // 最大希望面積
            min_expected_residents: $('#min_expected_residents').val(), // 最低入居予定人数
            max_expected_residents: $('#max_expected_residents').val(), // 最大入居予定人数
            purchase_purpose: $('#purchase_purpose').val(), // 購入目的
            status: $('input[name="status[]"]:checked') // ステータス
                .map(function () {
                    return $(this).val();
                }).get(),
            relation_status: $('input[name="relation_status[]"]:checked') // 状態
                .map(function () {
                    return $(this).val();
                }).get(),
            entry_date: $('#entry_date').val(), // 物件エントリー日
            first_registration_flag: $('#first_registration_flag').prop('checked') ? 1 : 0, // 初回登録未完了の顧客のみ

            // アクセス期間から検索 ===================================================



            include_pin_filter: $('#include_pin_filter').prop('checked') ? 1 : 0, // 検索条件をピン止め顧客にも適用する
        };
    }

    // 顧客一覧のピン止め
    $('#customers_table').on('click', '.pin-btn', function () {
        const customerId = $(this).data('id');

        $.ajax({
            url: `/manager/building/1/customer-list/${customerId}/toggle-pin`,
            method: 'get',
            success: function () {
                $('#customers_table').DataTable().ajax.reload(null, false); // 現在ページを維持して再読み込み
            }
        });
    });

    // 項目表示設定のモーダルを開く
    $('#display-setting-btn').on('click', function () {
        $('#display-setting-modal').slideDown(100);
        $('body').css('overflow', 'hidden'); // スクロール禁止
    });

    // 項目表示設定のモーダルを閉じる
    $('#modal-close').on('click', function () {
        $('#display-setting-modal').slideUp(100);
        $('body').css('overflow', 'auto'); // スクロール復活
    });

    // タブ変更時
    $('.tab-radio-btn').on('click', function () {
        loadTable()
    });

    // 各表やグラフを描画
    function loadTable() {
        // 選択中のタブ
        const selectedValue = $('.tab-radio-btn:checked').val();

        if (selectedValue === "1") { // 顧客一覧
            loadCustomerListTable();
        } else if (selectedValue === "2") { // 顧客別アクセス分析
            loadCustomerAccessAnalysisTable()
        } else if (selectedValue === "3") { // コンテンツ別アクセス分析
            console.log(selectedValue);
        }
    }

    // 初期画面表示時に実行
    loadTable();

    // 検索ボタン押下時
    $('#search_button').on('click', function () {
        loadTable()
    });

    // リセトボタン押下時
    $('#reset_button').on('click', function () {
        console.log('作成中');
    });
});

