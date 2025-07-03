
import Sortable from "sortablejs";

document.addEventListener("DOMContentLoaded",() => {
    let el = document.getElementById('sortable_list');
    new Sortable(el, {
        animation: 100,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
    });
})
