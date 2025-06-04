import './bootstrap';
import '../css/common.css';
import '../scss/common.scss';
import '../scss/manager/common.scss';
import '../scss/manager/base.scss';
import './common.js';
import 'jquery-ui/themes/base/all.css';
import 'jquery-ui/dist/jquery-ui.min.js';
import {ToggleHandler} from './common/ToggleHandler';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded",() => {

    ToggleHandler.onClickHiddenMultipleConditions([
        '#top_image',
    ], [
        ['contents_design_flg', '0'],
    ]);

    $('.horizontal-chart-title.pointer').click(function () {
        let $parentRow = $(this).closest('.horizontal-chart-row');
        let $childBlock = $parentRow.next('.child-row');
        let $arrow = $(this).find('span').first(); // 最初の▶を取る

        if ($childBlock.length) {
            $childBlock.slideToggle(200);
            // 開閉に合わせて▶を回転させる
            $arrow.toggleClass('rotate-90');
        }
    });

})
