import {ToggleHandler} from './../../../common/ToggleHandler';

document.addEventListener("DOMContentLoaded", function () {
    ToggleHandler.modalDisplay( 'add_image_btn','add_image');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            deleteImage(id);
        });
    });


    function deleteImage(id) {
        if (confirm('本当に削除しますか？')) {
            fetch(`/manager/building/${building_id}/image_gallery/${id}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            }).then(response => {
                if (response.ok) {
                    location.reload(); // 成功したらリロード
                } else {
                    alert('削除に失敗しました');
                }
            });
        }
    }
});
