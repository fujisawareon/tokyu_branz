// フラッシュメッセージを削除する時
$('.flash-message-box-close').click(function () {
    $(this).parent().toggleClass('flash-message-hidden').slideUp();
})

$(document).ready(function () {
    setTimeout(function () {
        $('.flash-message-box-close').trigger('click');
    }, 5000); // 5秒後に強制クリック

    $('.horizontal-chart-title.pointer').click(function () {
        let $parentRow = $(this).closest('.horizontal-chart-row');
        let $childBlock = $parentRow.next('.child-row');
        let $arrow = $(this).find('span').first(); // 最初の▶を取る

        if ($childBlock.length) {
            $childBlock.slideToggle(200);
            // 開閉に合わせて▶を回転させる
            $arrow.toggleClass('rotate-90');
        }
    });

});




