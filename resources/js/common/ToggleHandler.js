import $ from "jquery";

export class ToggleHandler {

    /**
     * 条件に一致していなければ特定の項目を非表示にする
     * @param {string[]} target_names
     * @param {array} conditions
     */
    static onClickHiddenMultipleConditions(target_names, conditions) {
        const exec = () => {
            let active = true;
            conditions.forEach(function (condition) {
                let elem_name = condition[0]; // 確認する要素
                let cond_values = condition[1]; // 活性化させるための条件となる値
                let selected_values = []; // 選択している値を配列で取得するため初期化

                $('input[name=' + elem_name + ']:checked').each(function () {
                    selected_values.push($(this).val());
                })

                // nullを条件とする場合
                if (cond_values == null) {
                    // 何かしら選択していたら false と判断
                    if (selected_values.length >= 1) {
                        active = false;
                    }
                } else {
                    // 条件となる値を選択していない場合は false と判断
                    if (selected_values.includes(cond_values) === false) {
                        active = false;
                    }
                }
            })

            // 対象のdisableを切り替える
            target_names.forEach(function (target_name) {
                if (active) {
                    $(target_name).slideDown(200);
                } else {
                    $(target_name).slideUp(200);
                }
            })
        }

        exec();
        conditions.forEach(function (condition) {
            $('input[name=' + condition[0] + ']').change(function () {
                exec();
            })
        })
    }

    /**
     * @param {string[]} target_names
     * @param {array} conditions
     */
    static clickDisableConditions(target_names, conditions) {
        const exec = () => {
            let active = true;
            conditions.forEach(function (condition) {
                let elem_name = condition[0]; // 確認する要素
                let cond_values = condition[1]; // 活性化させるための条件となる値
                let selected_values = []; // 選択している値を配列で取得するため初期化

                $('input[name=' + elem_name + ']:checked').each(function () {
                    selected_values.push($(this).val());
                })

                // nullを条件とする場合
                if (cond_values == null) {
                    // 何かしら選択していたら false と判断
                    if (selected_values.length >= 1) {
                        active = false;
                    }
                } else {
                    // 条件となる値を選択していない場合は false と判断
                    if (selected_values.includes(cond_values) === false) {
                        active = false;
                    }
                }
            })

            // 対象のdisableを切り替える
            target_names.forEach(function (target_name) {
                if (active) {
                    $(target_name).prop('disabled', false);
                } else {
                    $(target_name).prop('disabled', true);
                }
            })
        }

        exec();
        conditions.forEach(function (condition) {
            $('input[name=' + condition[0] + ']').change(function () {
                exec();
            })
        })
    }

    /**
     * 特定の条件に一致した場合に特定の項目を非表示にする
     * @param {string[]} target_names
     * @param {array} conditions
     */
    static shouldHiddenFeature(target_names, conditions) {
        const exec = () => {
            let active = true;
            conditions.forEach(function (condition) {
                let elem_name = condition[0]; // 確認する要素
                let cond_values = condition[1]; // 活性化させるための条件となる値
                let selected_values = []; // 選択している値を配列で取得するため初期化

                $('input[name=' + elem_name + ']:checked').each(function () {
                    selected_values.push($(this).val());
                })

                // 条件となる値を選択していない場合は false と判断
                if (selected_values.includes(cond_values)) {
                    active = false;
                }


            })

            // 対象のdisableを切り替える
            target_names.forEach(function (target_name) {
                if (active) {
                    $(target_name).slideDown(200);
                } else {
                    $(target_name).slideUp(200);
                }
            })
        }

        exec();
        conditions.forEach(function (condition) {
            $('input[name=' + condition[0] + ']').change(function () {
                exec();
            })
        })
    }

    /**
     * 特定の要素をクリックした際に、対になる要素を表示を切り替える
     * 切り替える基準は .openクラス が扶養されているか否か
     * @param {string} trigger_id_name
     * @param {string} child_id_name
     */
    static onClickOpenToggle(trigger_id_name, child_id_name) {
        const parent = '#' + trigger_id_name;
        const child = '#' + child_id_name;

        const exec = (click) => {
            if (click) { // クリックしている場合はopenクラスのつけ外しをする
                $(parent).toggleClass('open');
            }

            // openクラスがついているかで表示非表示を切り替える
            if ($(parent).hasClass('open')) {
                $(child).slideDown(200);
            } else {
                $(child).slideUp(200);
            }
        }

        // 画面表示時
        exec(false);

        // 要素クリック時
        $(parent).on('click', function () {
            exec(true);
        })
    }

    /**
     * モーダルの開閉を行う
     * @param btn_id モーダルを表示する為のボタンのID
     * @param display_id 表示するモーダル自体のID
     *
     * ※このメソッドを利用するためにはモーダルが下記の構成になっている事が前提となる
     * <div class="modal-background" id="{$display_id}">
     *     <div class="modal" style="width: ___px;">
     *         <div class="modal-close">×</div>
     *     </div>
     * </div>
     */
    static modalDisplay(btn_id, display_id) {
        // モーダルを開くボタンのクリックでモーダル表示
        $('#' + btn_id).click(() => {
            $('#' + display_id).slideDown(100);
            $('body').css('overflow', 'hidden'); // スクロール禁止
        });

        // モーダル内の .modal-close がクリックされたら非表示
        $('#' + display_id).find('.modal-close').click(function () {
            $(this).closest('#' + display_id).slideUp(100);
            $('body').css('overflow', 'auto'); // スクロール復活
        });
    }
    /**
     * モーダルの開閉を行う
     * @param class_name モーダルを表示する為のボタンのclass名
     * @param display_id 表示するモーダル自体のID
     *
     * ※このメソッドを利用するためにはモーダルが下記の構成になっている事が前提となる
     * <div class="modal-background" id="{$display_id}">
     *     <div class="modal" style="width: ___px;">
     *         <div class="modal-close">×</div>
     *     </div>
     * </div>
     */
    static modalDisplayByClassName(class_name, display_id) {
        // モーダルを開くボタンのクリックでモーダル表示
        $('.' + class_name).click(() => {
            $('#' + display_id).slideDown(100);
            $('body').css('overflow', 'hidden'); // スクロール禁止
        });

        // モーダル内の .modal-close がクリックされたら非表示
        $('#' + display_id).find('.modal-close').click(function () {
            $(this).closest('#' + display_id).slideUp(100);
            $('body').css('overflow', 'auto'); // スクロール復活
        });
    }
}
