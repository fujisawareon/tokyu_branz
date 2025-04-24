

$('#building_select_btn').click(() => {
    $('#building_select').slideDown(150);
});


function smoothCountUp(element, duration) {
    let target = parseFloat(element.getAttribute('data-target')); // 小数点対応
    let decimals = parseInt(element.getAttribute('data-decimals')) || 0; // 小数点桁数
    let start = 0;
    let startTime = null;

    function updateCount(timestamp) {
        if (!startTime) startTime = timestamp;
        let progress = timestamp - startTime;
        let percentage = Math.min(progress / duration, 1);
        let current = percentage * target;

        element.textContent = current.toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals });

        if (progress < duration) {
            requestAnimationFrame(updateCount);
        } else {
            element.textContent = target.toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
        }
    }

    requestAnimationFrame(updateCount);
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.counter').forEach(counter => {
        smoothCountUp(counter, 500); // 0.5秒でカウントアップ
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