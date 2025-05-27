import './bootstrap';
import '../css/common.css';
import '../scss/customer/common.scss';
import './common.js';
import 'jquery-ui/themes/base/all.css';
import 'jquery-ui/dist/jquery-ui.min.js';
import {ToggleHandler} from './common/ToggleHandler';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded",() => {

    console.log(1111)
})
