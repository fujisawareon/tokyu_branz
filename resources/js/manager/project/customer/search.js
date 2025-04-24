import {ToggleHandler} from '../../../common/ToggleHandler';
import {DropdownCheckboxHandler} from '../../../common/DropdownCheckboxHandler';
import $ from "jquery";
import 'datatables.net-dt/css/dataTables.dataTables.css'
import 'datatables.net-fixedcolumns';

document.addEventListener("DOMContentLoaded", () => {

    ToggleHandler.onClickOpenToggle('search_1', 'search_content_1');
    ToggleHandler.onClickOpenToggle('search_2', 'search_content_2');
    ToggleHandler.onClickOpenToggle('search_3', 'search_content_3');

    // アクセス期間から検索の有効無効を切り替える
    ToggleHandler.clickDisableConditions([
        '#period_1',
        '#contents_design_flg_1_0',
        '#contents_design_flg_1_1',
    ], [
        ['access_1', '1'],
    ]);

    ToggleHandler.clickDisableConditions([
        '#period_2',
        '#contents_design_flg_2_0',
        '#contents_design_flg_2_1',
    ], [
        ['access_2', '1'],
    ]);

    ToggleHandler.clickDisableConditions([
        '#period_3',
        '#contents_design_flg_3_0',
        '#contents_design_flg_3_1',
    ], [
        ['access_3', '1'],
    ]);

    DropdownCheckboxHandler.setTextBox('person_in_charge', 'person_in_charge[]');
    DropdownCheckboxHandler.setTextBox('status', 'status[]');
    DropdownCheckboxHandler.setTextBox('relation_status', 'relation_status[]');

    $(document).click(function (event) {
        if (!$(event.target).closest('.custom-dropdown').length) {
            $('.dropdown-list').hide();
        }
    });

});

