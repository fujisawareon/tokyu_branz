

import {ToggleHandler} from './../../common/ToggleHandler';


document.addEventListener("DOMContentLoaded",() => {

    // 販売中でなければ表示する項目
    ToggleHandler.shouldHiddenFeature([
        '#display-title',
        '#display-message',
    ], [
        ['sales_status', '2'],
    ]);

})

