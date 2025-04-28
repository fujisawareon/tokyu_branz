
/**
 * Animator クラス
 * 数値カウントアップのアニメーションを提供するユーティリティクラス。
 * 主にダッシュボードや統計表示などで使用される。
 */
export class Animator {

    /**
     * 指定要素をスムーズにカウントアップする
     * @param element カウント表示するHTML要素
     * @param duration アニメーションの所要時間（ms）
     */
    static smoothCountUp(element, duration) {
        // カウントアップの目標値（data-target 属性から取得）
        const target = parseFloat(element.getAttribute('data-target') || '0'); // 小数点対応
        const decimals = parseInt(element.getAttribute('data-decimals') || '0'); // 小数点桁数
        let startTime = null; // アニメーション開始時刻

        // アニメーションフレームごとに呼び出される更新関数
        function updateCount(timestamp) {
            // 最初のフレーム時に開始時刻を記録
            if (!startTime) startTime = timestamp;
            // 経過時間を計算（ミリ秒）
            const progress = timestamp - startTime;

            // 進捗率（0〜1）を算出。1を超えないよう Math.min で制限
            const percentage = Math.min(progress / duration, 1);

            // 現在の表示値を目標値に対する進捗分で算出
            const current = percentage * target;

            // 表示を更新（桁区切りや小数点桁数も整形）
            element.textContent = current.toLocaleString(undefined, {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
            });

            // アニメーションが完了していなければ、次のフレームをリクエスト
            if (progress < duration) {
                requestAnimationFrame(updateCount);
            } else {
                // 最後に正確な目標値を表示して終了（進捗率の誤差を修正）
                element.textContent = target.toLocaleString(undefined, {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals,
                });
            }
        }

        requestAnimationFrame(updateCount);
    }

    /**
     * 横棒グラフをスムーズに伸ばす
     * @param element
     */
    static horizontalBar (element) {
        const targetWidth = element.dataset.width;
        if (targetWidth) {
            element.style.width = targetWidth + '%';
        }
    }

}











