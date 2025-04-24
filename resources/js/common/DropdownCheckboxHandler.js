export class DropdownCheckboxHandler {

    /**
     */
    static setTextBox(id_name, checkbox_name) {
        // チェックしているラベルを取得してテキストボックスに記入する
        const exec = () => {
            // チェックが入っている要素を取得
            const checkedBoxes = document.querySelectorAll(
                `input[name="${checkbox_name}"]:checked`
            );

            // 各チェックボックスの data-label の値を取得
            const labels = Array.from(checkedBoxes).map(box => box.getAttribute("data-label"));

            // 文字列に変換
            const label_string = labels.join(', ')

            $('#dropdown_text_' + id_name).val(label_string);
        }

        // 画面表示時
        exec();

        // チェックボックスをクリックした時
        $(`input[name="${checkbox_name}"]`).change(function () {
            exec();
        });

        // ドロップダウンを開閉（同じ親コンテナ内の他のドロップダウンを閉じる）
        $('#' + id_name).click(function () {
            const parentContainer = $(this).closest('form, .modal, .container, body'); // 適切な親要素を探す
            const parent = $(this).closest('.custom-dropdown'); // クリックされたドロップダウン
            const list = parent.find('.dropdown-list'); // そのリスト

            // 同じ親コンテナ内の他のドロップダウンを閉じる
            parentContainer.find('.dropdown-list').not(list).hide();

            // クリックされたリストを開閉
            list.toggle();
        });
    }

}
