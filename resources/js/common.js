// フラッシュメッセージを削除する時
$('.flash-message-box-close').click(function () {
    $(this).parent().toggleClass('flash-message-hidden').slideUp();
})

$(document).ready(function () {
    setTimeout(function () {
        $('.flash-message-box-close').trigger('click');
    }, 5000); // 5秒後に強制クリック


});




