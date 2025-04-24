import './bootstrap';
import '../css/common.css';
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
        '#sssssssssss',
    ], [
        ['contents_design_flg', '0'],
    ]);

})
