import {ToggleHandler} from './../common/ToggleHandler';
import {Animator} from './../common/Animator';
import {renderBarChart} from './../common/renderBarChart';

document.addEventListener("DOMContentLoaded", function () {

    // 物件選択時のモーダルの開閉
    ToggleHandler.modalDisplay( 'building_select_btn','building_select');

    // 数値カウントのアニメーション
    document.querySelectorAll('.counter').forEach(counter => {
        Animator.smoothCountUp(counter, 300);
    });

    // 横棒グラフのアニメーション
    document.querySelectorAll('.horizontal-chart-bar').forEach(bar => {
        Animator.horizontalBar(bar);
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

    renderBarChart('first_login_rate_chart', building_label, chart_data);
    renderBarChart('entry_count_chart', building_label, [32, 44, 12], '人');
    renderBarChart('building_pv_chart', building_label, [234, 122, 85], '件');
    renderBarChart('building_visit_rate_chart', building_label, [234, 122, 85], '件');
    renderBarChart('building_portal_site_entry_rate_chart', building_label, [234, 122, 85], '件');
    renderBarChart('building_form_rate_chart', building_label, [234, 122, 85], '件');

});
