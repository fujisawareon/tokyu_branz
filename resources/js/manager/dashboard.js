import {ToggleHandler} from './../common/ToggleHandler';
import {CounterAnimator} from './../common/CounterAnimator';

document.addEventListener("DOMContentLoaded", function () {

    // 物件選択時のモーダルの開閉
    ToggleHandler.modalDisplay( 'building_select_btn','building_select');

    // カウンターのアニメーション
    document.querySelectorAll('.counter').forEach(counter => {
        CounterAnimator.smoothCountUp(counter, 300);
    });

    const form = document.querySelector("form");
    // チェックボックスの取得
    const checkboxes = document.querySelectorAll('input[name="select_building[]"]');
    // エラーメッセージを表示する場所（追加する場合）
    const errorMessage = document.createElement("p");
    errorMessage.style.color = "red";
    errorMessage.style.display = "none";
    errorMessage.textContent = "少なくとも1つの建物を選択してください。";
    form.appendChild(errorMessage);

    // フォーム送信時の処理
    form.addEventListener("submit", function (event) {
        let checked = false;

        // すべてのチェックボックスをループして、1つでもチェックされているか確認
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                checked = true;
            }
        });

        if (!checked) {
            // エラーメッセージを表示
            errorMessage.style.display = "block";
            // フォーム送信をキャンセル
            event.preventDefault();
        } else {
            // エラーメッセージを非表示
            errorMessage.style.display = "none";
        }
    });


});