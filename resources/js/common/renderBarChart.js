
import Chart from 'chart.js/auto';

/**
 * 汎用バーチャート描画関数
 */
export function renderBarChart(canvasId, labels, data, unit = '%') {
    const ctx = document.getElementById(canvasId)?.getContext('2d');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10,
                        callback: value => `${value}${unit}`
                    }
                }
            }
        }
    });
}