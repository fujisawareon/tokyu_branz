import $ from "jquery";
import {Datatables} from '../common/datatables.js';
import 'datatables.net-dt/css/dataTables.dataTables.css'
import 'datatables.net-fixedheader-dt';

const buildingListAjaxUrl = document.querySelector('#customers_table').dataset.url;
let buildingListTable = null;

document.addEventListener("DOMContentLoaded", () => {

    // 顧客一覧表を作成
    function loadCustomerListTable() {
        if (buildingListTable) {
            // 既に初期化されているので再描画
            buildingListTable.ajax.reload();
        } else {
            buildingListTable = $('#customers_table').DataTable({
                language: Datatables.language(),
                dom: '<"top"ipl>t<"bottom"ip><"clear">',
                processing: true,
                serverSide: true,
                autoWidth: false,
                lengthMenu: Datatables.lengthMenu(),
                pageLength: 20,
                scrollCollapse: true,
                columnDefs: [
                ],
                ajax: {
                    url: buildingListAjaxUrl,
                    type: 'GET',
                    data: function (d) {
                        const params = makeConditions();
                        Object.assign(d, params);
                    },
                },
                columns: [
                    {
                        // 物件名
                        data: 'building_name',
                        name: 'building_name',
                        render: function (data, type, row, meta) {
                            return `<a href="/manager/building/${row.id}/home"
                            class="link">${row.building_name}</a>`;
                        },
                    }, {
                        // 販売ステータス
                        data: 'sales_status_name',
                        name: 'sales_status',
                        className: 'text-center',
                        orderable: true,
                    }, {
                        // エントリー数
                        data: 'entry_count',
                        name: 'entry_count',
                        className: 'text-right',
                        orderable: true,
                        render: function (data, type, row, meta) {
                            const formatted = Number(data).toLocaleString(); // カンマ区切り
                            return `<span class="table-number">${formatted}<span class="unit">名</span></span>`;
                        },
                    },
                    {
                        // 登録者数
                        data: 'registration_count',
                        name: 'registration_count',
                        className: 'text-right',
                        orderable: true,
                        render: function (data, type, row, meta) {
                            const formatted = Number(data).toLocaleString(); // カンマ区切り
                            return `<span class="table-number">${formatted}<span class="unit">名</span></span>`;
                        },
                    }, {
                        // 閲覧ページ数
                        name: 'view_count',
                        data: 'view_count',
                        className: 'text-right',
                        orderable: true,
                        render: function (data, type, row, meta) {
                            const formatted = Number(data).toLocaleString(); // カンマ区切り
                            return `<span class="table-number">${formatted}<span class="unit">PV</span></span>`;
                        },
                    }, {
                        // 編集ボタン
                        className: 'text-center',
                        orderable: false,
                        render: function (data, type, row, meta) {
                            return `<a href="/manager/building/basic-setting/${row.id}" class="btn min">編集</a>`;
                        },
                    },
                ]
            });
        }
    }

    // 検索条件を作成する
    function makeConditions() {
        return {
            building_name: $('#building_name').val(),
            sales_status    : $('#sales_status').val(),
        };
    }

    // 初期画面表示時に実行
    loadCustomerListTable();

    // 検索ボタン押下時
    $('#search_button').on('click', function () {
        loadCustomerListTable()
    });

});

