import {ToggleHandler} from './../../../common/ToggleHandler';

document.addEventListener("DOMContentLoaded", function () {
    ToggleHandler.modalDisplay( 'category_setting','add_movie_category');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.movie_id;
            deleteImage(id);
        });
    });


    // 新規動画の登録を押下時
    ToggleHandler.modalDisplayByClassName( 'register-new','add_movie_modal');
    document.querySelectorAll('.register-new').forEach(btn => {
        btn.addEventListener('click', () => {
            const category_id = btn.dataset.category_id;
            const input = document.querySelector('input[name="movie_category_id"]');
            if (input) {
                input.value = category_id;
            }
        });
    });


    function deleteImage(id) {
        if (confirm('本当に削除しますか？')) {

            console.log(id)
        }
    }
});
