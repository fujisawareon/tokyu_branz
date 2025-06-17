import {ToggleHandler} from './../../../common/ToggleHandler';

document.addEventListener("DOMContentLoaded", function () {
    // カテゴリ設定モーダルを表示
    ToggleHandler.modalDisplay('category_setting', 'add_binder_category_modal');

    // カテゴリの行を追加
    $('#add_binder_category').on('click', () => {
        max_category_id += 1;
        const sortableList = $('#sortable-list');
        const template = document.querySelector('#add_binder_category_template').innerHTML;
        const html = template.replace(/\${id}/g, max_category_id);
        sortableList.append(html);
    });

    // 追加したカテゴリを削除
    document.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('new-category-delete-btn')) {
            const row = target.closest('.list-element-row');
            row.remove();
        }
    });



    // 資料登録モーダル内での表示切替
    ToggleHandler.onClickHiddenMultipleConditions([
        '#pdf_file','#thumbnail',
    ], [
        ['file_type', '0'],
    ]);
    ToggleHandler.onClickHiddenMultipleConditions([
        '#url',
    ], [
        ['file_type', '1'],
    ]);


    ToggleHandler.modalDisplayByClassName('register-new', 'add_movie_modal');
    document.querySelectorAll('.register-new').forEach(btn => {
        btn.addEventListener('click', () => {
            const category_id = btn.dataset.category_id;
            const category_name = btn.dataset.category_name;

            document.querySelector("#modal_category_name").textContent = category_name;

            const input = document.querySelector('input[name="category_id"]');
            if (input) {
                input.value = category_id;
            }
        });
    });

});
