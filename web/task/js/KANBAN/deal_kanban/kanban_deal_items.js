function createKanbanDealItems(order, color, colimn_id) {
    let knbn_column = kanbanTemplatesGenerationDealItems({ item_get: 'get-knbn-deal-column' });
    const monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
    order.forEach((item) => {
        let deadline = new Date(item.date);
        let draw_date = monthNames[deadline.getMonth() + 1] + ' ' + deadline.getDate();
        let kanban_deal = kanbanTemplatesGenerationDealItems({
            item_get: "get-knbn-deal-item",
            id: item.id,
            title: item.title,
            amount: item.amount,
            currency: item.currency,
            draw_date: draw_date,
            border_color: color
        });
        kanban_deal.append(kanbanTemplatesGenerationDealItems({
            item_get:"get-erp-knbn-item-connect",
            contact_phone: item.contact_phone,
            contact_mail: item.contact_mail,
            chat: item.chat,
        }));
        $('.knbn-icon-passive', kanban_deal).attr("title", "Отсутствует");
        knbn_column.append(kanban_deal);
    });
    return knbn_column;
}
function kanbanTemplatesGenerationDealItems(options = {}) {
    switch (options.item_get) {
        case "get-knbn-deal-column":
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
                                    </div>
                                    <div class = "add-item">
                                        <p>Контакт</p>
                                        <div>
                                        
                                        </div>
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
        case "get-knbn-deal-item":
            return $(`
                <li data-id = "${options.id}" data-pos = "${options.position}" class = "knbn-deal-item" style = "border-left-color: ${options.border_color} ">
                    <div class = "deal-cont">
                        <div class = 'deal-cont-d-col'>
                            <div>
                                <a  href = "#" class = 'deal-name'>${options.title}</a>
                            </div>
                            <div>
                                <span class = 'deal-curr'>${options.amount} ${options.currency}</span>
                            </div>
                            <div>
                                <span class = 'deal-date'>${options.draw_date}</span>
                            </div>
                        </div>
                        <div class="deal-cont-d-flex">
                            <div><span>Дела: </span><span class="affair-num">1</span></div>
                            <div class="knbn-deal-schedule">
                                <span class = "knbn-deal-schedule">+ Запланировать</span>
                                <div class = "knbn-deal-schedule-hid">
                                    <div class = "knbn-deal-schedule-cont">
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
            return $(`<div>Some Error Occured while drawing deal</div>`);
    }
    return $(`<div>Some Error Occured while drawing deal</div>`);
}