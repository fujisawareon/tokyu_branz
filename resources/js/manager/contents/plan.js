
document.addEventListener("DOMContentLoaded", () => {
    const template = document.querySelector('#plan_template').innerHTML;

    // 追加ボタンクリック時の処理
    $('#add_btn').on('click', function () {
        max_action_btn_id += 1;

        const html = template.replace(/\${id}/g, max_action_btn_id);
        $('#sortable_list').append(html);
    });

    // 削除ボタンクリック時の処理（動的要素にも対応）
    $(document).on('click', '.delete-btn', function () {
        $(this).closest('.list-element-row').remove();
    });
});
