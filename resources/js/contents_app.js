import '../css/common.css';
import '../scss/common.scss';
import '../scss/contents/common.scss';
import {Log} from './limited_contents/Log';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const appLogId = window.appLogId;
const buildingId = window.buildingId;

document.addEventListener("DOMContentLoaded", () => {
    // 10秒ごとに送信
    setInterval(() => {
        Log.updateStayTime(csrfToken, buildingId, appLogId);
    }, 10000); // 10000ms = 10秒
})

// 自動終了時のイベント
window.addEventListener('beforeunload', function (event) {
    Log.updateStayTime(csrfToken, buildingId, appLogId);
});
