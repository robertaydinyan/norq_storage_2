$(document).ready(function () {
    // add new kanban arrow step
    $('body').on('click', '.c-kanban-add', function(){
        const kanbanArrow = $(this).closest('.c-kanban-arrow');
        kanbanArrow.after(`
            <div class="c-kanban-arrow">
                <span></span>
                <button class="c-kanban-add"></button>
            </div>
        `)
    })
});