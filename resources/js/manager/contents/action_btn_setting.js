
document.addEventListener("DOMContentLoaded", () => {
    const $addBtn = $('#add_btn');
    const $sortableList = $('#sortable_list');
    const template = document.querySelector('#action-btn-template').innerHTML;

    // アクションボタンの数をカウントし、追加ボタンの表示を制御する
    const updateAddButtonVisibility = () => {
        const count = $sortableList.children().length;
        $addBtn.toggle(count < 4);
    };

    // 追加ボタンクリック時の処理
    $addBtn.on('click', function () {
        max_action_btn_id += 1;

        const html = template.replace(/\${id}/g, max_action_btn_id);
        $sortableList.append(html);

        updateAddButtonVisibility();
    });

    // 削除ボタンクリック時の処理（動的要素にも対応）
    $(document).on('click', '.delete-btn', function () {
        $(this).closest('.list-element-row').remove();
        updateAddButtonVisibility();
    });
});
