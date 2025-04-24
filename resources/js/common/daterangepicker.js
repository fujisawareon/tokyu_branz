

$(function() {
    $('.date-rang-text').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD',
            separator: ' - ',
            applyLabel: "反映",
            cancelLabel: "キャンセル",
            fromLabel: "開始日",
            toLabel: "終了日",
            customRangeLabel: "自分で指定",
            weekLabel: "週",
            daysOfWeek: ["日", "月", "火", "水", "木", "金", "土"],
            monthNames: ["1月", "2月", "3月", "4月", "5月", "6月",
                "7月", "8月", "9月", "10月", "11月", "12月"],
            firstDay: 0
        },
        alwaysShowCalendars: true,
        showCustomRangeLabel: true,
        opens: 'right',
        autoUpdateInput: false,
        ranges: {
            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '過去7日間': [moment().subtract(6, 'days'), moment()],
            '過去30日間': [moment().subtract(29, 'days'), moment()],
            '今月': [moment().startOf('month'), moment().endOf('month')],
            '先月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
});

// カレンダー選択後、自動的に値をテキストに入れる
$('.date-rang-text').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
});

// キャンセルでクリア
$('.date-rang-text').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});

