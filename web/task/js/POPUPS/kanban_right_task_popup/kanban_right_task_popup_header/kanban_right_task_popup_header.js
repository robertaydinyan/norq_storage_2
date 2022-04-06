"use strict";
function createTaskPopupHeader(title) {
    let popup_header = kanbanTemplatesGenerationRightTaskPopupHeader({
        item_get: "get-knbn-tt-header",
        task_name: title,
    });
    return popup_header;
}
function kanbanTemplatesGenerationRightTaskPopupHeader(options = {}) {
    switch (options.item_get) {
        case 'get-knbn-tt-header':
            return $(`
                <div class = "knbn-tt-header">
                    <span class = "knbn-tt-header-task-name">${options.task_name}</span>
                    <div class = 'knbn-tth-btn-group'>
                        <div>
                            <button type="button" class = 'c-btn c-btn-ol zone-eight-menu'><i class="fas fa-cog" ></i></button>
                            <div  class = "menu-popup-items">
                                <div>
                                    <div>
                                        <span><i class="fas fa-check"></i></span>
                                        <span>Показать выполненые</span>
                                    </div>
                                    <div>
                                        <span><i class="fas fa-check"></i></span>
                                        <span>Показать только мои</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = 'knbn-tth-btn'>
                            <button type="button" class = 'c-btn zone-eight-open-new-popup'>Добавить</button>
                            <button type="button" class = 'c-btn c-btn-ol zone-eight-open-task-popup'><i class="fas fa-chevron-down"></i></button>
                            <div  class = "knbn-add-tasks">
                                <div>
                                    <span>Добавить задачу</span>
                                    <span>Добавить задачу из шаблона <span><i class="fas fa-angle-right"></i></span></span>
                                    <span>Добавить подзадачу</span>
                                    <span>Список шаблонов</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}
function addTaskRightPopupHeaderListeners() {
    $('.zone-eight-open-task-popup').on('click', function (e) {
        e.stopPropagation();
        $('.knbn-add-tasks').toggle();
    });
    $('.zone-eight-menu').on('click', function (e) {
        e.stopPropagation();
        $('.menu-popup-items').toggle();
    });
    $('.zone-eight-open-new-popup').on('click', function (e) {
        // let popup = $('.popup2');
        // drawZoneNine(addNewTaskPopup, popup)
        // zoneNineHideShow(popup, "show");
    });
}
