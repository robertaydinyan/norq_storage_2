"use strict";
function kanbanTemplatesGeneration(options = {}) {
    // debugger;
    switch (options.item_get) {
        case 'get-kanban':
            return $(`
                <div class = "kanban kanban-${options.kanban_type}">
                    <div class="erp-arrow-slides">
                        <div class="on-hover-scroll on-hover-table-scroll-left"></div>
                        <div class="on-hover-scroll on-hover-table-scroll-right"></div>
                    </div>
                    <div class ='knbn-main'>
                       <ul class = "knbn-${options.kanban_type}-body"></ul>
                    </div>
                </div>`);
            break;
        case 'get-knbn-plus-btn':
            return $(`<div class = 'knbn-plus-btn knbn-header-plus'><span class="knbn-plus-icon"><i class="fas fa-plus"></i></span></div>`);
            break;
        case 'get-knbn-header-hid':
            return $(`
                <div class = 'knbn-header-hid' >
                    <div class = 'knbn-popup-header'>
                        <div class = 'knbn-h-popup-first'><span>Выбрано: </span><span class = "knbn-selected-lead"></span><span class = 'knbn-header-close'><i class="fas fa-times"></i></span></div>
                        <div class = 'knbn-h-popup-div'><span><i class="fas fa-trash"></i></span><span class = "knbn-lead-delete"> Удалить</span></div>
                        <div class = 'knbn-h-popup-div'><span><i class="far fa-list-alt"></i></span><span> В списке исключений</span></div>
                        <div class = 'knbn-h-popup-div'>
                            <span><i class="fas fa-arrow-right"></i></span><span> Сменить Статус</span>
                            <div class = "knbn-status-hidden">
                                <div class = "knbn-status-container"></div>
                            </div>
                        </div>
                        <div class = 'knbn-h-popup-div'><span><i class="fas fa-user"></i></span><span> Назначить ответственного</span></div>
                        <div class = 'knbn-h-popup-div'><span><i class="far fa-check-square"></i></span><span> Создать задачу</span></div>
                        <div class = 'knbn-h-popup-div'><span><i class="fas fa-phone-alt"></i></span><span> Создать обзвон</span></div>
                        <div class = 'knbn-h-popup-div'><span><i class="fas fa-thumbs-up"></i></span><span> Качественный Лид</span></div>
                    </div>
                </div>`);
            break;
        case 'get-knbn-header-hidden':
            return $(`
            <div class = "knbn-header-hidden">
                <div class = "knbn-${options.kanban_type}-step" style = "background-color: ${options.color}; color:${options.color};">
                    <input class = 'knbn-step-input' value = "${options.title}" type = "text">
<!--                    <div class = "knbn-edit-hid">-->
                        <input type='text' id ="color-${options.id}" class = "knbn-column-colorpicker"/>
<!--                    <span class = "knbn-color-pic"><i class="fas fa-palette"></i></span>-->
                    <span class  = 'knbn-col-del'><i class="fas fa-times"></i></span>
<!--                </div>-->
                </div>
            </div>`);
            break;
        case 'get-knbn-edit-cont':
            return $(`
            <div class = "knbn-edit-cont">
                 <span class = "knbn-edit-col"><i class="fas fa-pen"></i></span>
                 <span class  = 'knbn-add-col'><i class="fas fa-plus-circle"></i></span>
            </div>`)
            break;
        case 'get-knbn-col':

            return $(`
            <li data-pos = "${options.position}" data-id = "${options.id}" data-alias = "${options.alias}" class = "knbn-col">
                <div class = "knbn-col">
                    <div class = "knbn-header" >
                        <div class = "knbn-${options.kanban_type}-step" style = "background-color: ${options.color}; color:${options.color};">
                            <span class  = 'knbn-step-span'>${options.title}</span>
                        </div>
                        
                    </div>
                    
                </div>
            </li>`);
            break;
        default:
            return $(`<div>Some Error Occured drawing lead kanban</div>`);
    }
    return $(`<div>Some Error Occured drawing lead kanban</div>`);
}
// let knbn_column:JQuery = kanbanTemplatesGeneration({item_get: 'get-kanban', isLead: isLead, id:column.id, title: column.title, color: column.color })
