export class Datatables {

    static language() {
        return {
            processing: "処理中...",
            emptyTable: '該当するデータがありません',
            lengthMenu: "_MENU_ 件表示",
            zeroRecords: "該当するデータが見つかりませんでした",
            info: "_TOTAL_ 件中 _START_件 ～ _END_件 を表示",
            infoEmpty: "0 件中 0 から 0 を表示",
            infoFiltered: "（全 _MAX_ 件からフィルター）",
            infoPostFix: "",
            search: "検索:",
            // paginate: {
            //     first: "先頭",
            //     previous: "前",
            //     next: "次",
            //     last: "最後"
            // },
        };
    }

    static dom() {
        return '<"top"ipl>t<"bottom"ip><"clear">';
    }

    static lengthMenu() {
        return [[10, 20, 50, 100], [10, 20, 50, 100]];
    }

}
