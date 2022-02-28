"use strict";
/**
 *
 * @param order
 */
function createKanbanLeadItems(order, color, colimn_id) {
    let knbn_column = kanbanTemplatesGenerateLeadItems({ item_get: 'get-knbn-column' });
    const monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
    order.forEach((item) => {
        let deadline = new Date(item.date);
        let draw_date = monthNames[deadline.getMonth() + 1] + ' ' + deadline.getDate();
        let kanban_lead = kanbanTemplatesGenerateLeadItems({
            item_get: 'get-knbn-lead-item',
            id: item.id,
            title: item.title,
            amount: item.amount,
            currency: item.currency,
            draw_date: draw_date,
            border_color: color
        });
        kanban_lead.append(kanbanTemplatesGenerateLeadItems({
            item_get:"get-erp-knbn-item-connect",
            contact_phone: item.contact_phone,
            contact_mail: item.contact_mail,
            chat: item.chat,
        }));
        $('.knbn-icon-passive', kanban_lead).attr("title", "Отсутствует");
        knbn_column.append(kanban_lead);
    });

    return knbn_column;
}
/**
 *
 * @param options
 */
function kanbanTemplatesGenerateLeadItems(options = {}) {
    switch (options.item_get) {
        case 'get-knbn-column':
            return $(`
                <ul class = "knbn-column" >
                    <li class = 'knbn-item-popup'>
                        <div class ="add-item-popup">
                            <div class = "add-item add-knbn-item">
                                <p>Название лида</p>
                                <div class="c-floating-label">
                                    <input type="text" placeholder=" ">
                                    <label>Лид #</label>
                                </div>
                            </div>
                            <div class = "add-item add-knbn-item">
                                <p>Клиент</p>
                                <div class ='knbn-add-contact'>
                                    <div class = "add-item">
                                        <p>Компания</p>
                                        <div>
                                        
                                        </div>
<!--                                        <div class="c-floating-label">-->
<!--                                            <input type="text" placeholder=" ">-->
<!--                                            <label>Лид #</label>-->
<!--                                        </div>-->
                                    </div>
                                    <div class = "add-item">
                                        <p>Контакт</p>
                                        <div>
                                        
                                        </div>
<!--                                        <div class="c-floating-label">-->
<!--                                            <input type="text" placeholder=" ">-->
<!--                                            <label>Лид #</label>-->
<!--                                        </div>-->
                                    </div>
                                    <div class = 'knbn-plus-cont'>
                                        <button class="c-btn-dashed add-new-cont">+ Добавить участника</button>
                                    </div>
                                </div>
                            </div>
                            <div class = "knbn-card add-knbn-item"><i class="fas fa-users-cog"></i></div>
                            <div class = "knbn-add-save add-knbn-item">
                                <button type = 'button' class = 'knbn-save c-btn c-btn-sm'>Сохранить</button>
                                <button type = 'button' class = 'knbn-cancel c-btn c-btn-sm c-btn-link'>Отменить</button>
                            </div>
                        </div>
                    </li>
                </ul>`);
            break;
        case 'get-knbn-lead-item':
            return $(`
                <li data-id = "${options.id}" class = "knbn-lead-item" style = "border-left-color: ${options.border_color} ">
                    <div class = "lead-cont">
                        <div class = 'lead-cont-d-col'>
                            <div>
                                <a  href = "#" class = 'lead-name'>${options.title}</a>
                            </div>
                            <div>
                                <span class = 'lead-curr'>${options.amount} ${options.currency}</span>
                            </div>
                            <div>
                                <span class = 'lead-date'>${options.draw_date}</span>
                            </div>
                        </div>
                        <div class="lead-cont-d-flex">
                            <div><span>Дела: </span><span class="affair-num">1</span></div>
                            <div class="knbn-lead-schedule">
                                <span class = "knbn-lead-schedule">+ Запланировать</span>
                                <div class = "knbn-lead-schedule-hid">
                                    <div class = "knbn-lead-schedule-cont">
                                        <span>Звонок</span>
                                        <span>Встреча</span>
                                        <span>Визит</span>
                                        <span>Задача</span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class = "knbn-t-chbx knbn-hidden"></div>
                </li>`);
            break;
        case 'get-erp-knbn-item-connect':
            return $(`
            <div class = "erp-knbn-item-connect">
                <span class = "${options.contact_phone? "knbn-icon-active" : "knbn-icon-passive"}"><a href="#"><i class="fas fa-phone"></i></a></span>
                <span class = "${options.contact_mail ? "knbn-icon-active" : "knbn-icon-passive"}"><a href="#"><i class="fas fa-envelope"></i></a></span>
                <span class = "${options.chat ? "knbn-icon-active" : "knbn-icon-passive"}"><a href="#"><i class="fas fa-comment-dots"></i></a></span>
            </div>`);
            break;
        default:
            return $(`<div>Some Error Occured while drawing lead</div>`);
    }
    return $(`<div>Some Error Occured while drawing lead</div>`);
}
// ${options.contact_phone ? $(`<span class = 'knbn-icon-active'><i class="fas fa-phone"></i></span>`)[0].outerHTML : $(`<span class = "knbn-icon-passive"><a href="#" title="Отсутствует"><i class="fas fa-phone"></i></a></span>`)[0].outerHTML}
// ${options.contact_mail ? $(`<span class = 'knbn-icon-active'><i class="fas fa-envelope"></i></span>`)[0].outerHTML : $(`<span class = "knbn-icon-passive"><a href="#" title="Отсутствует"><i class="fas fa-envelope"></i></a></span>`)[0].outerHTML}
// ${options.chat ? $(`<span class = 'knbn-icon-active'><i class="fas fa-comment-dots"></i></span>`)[0].outerHTML : $(`<span class = "knbn-icon-passive"><a href="#" title="Отсутствует"><i class="fas fa-comment-dots"></i></a></span>`)[0].outerHTML}