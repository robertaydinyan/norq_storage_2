"use strict";
function addNewTaskPopup(task_data) {
    let logined_user = user;
    let knbn_task_popup = kanbanTemplatesGenerationRightNewTaskPopup({ item_get: "get-add-task-popup" });
    let isNewTask = task_data ? false: true;
    let planning_start = '';
    let planning_end = '';
    let deadline = '';
    if(!isNewTask){
        ajax_task_data= task_data;
        // ajax_task_data.id = task_data.id;
        // ajax_task_data.responsible_id = [ajax_task_data.responsible_id];
        planning_start = ajax_task_data.taskTiming.planning_start? ajax_task_data.taskTiming.planning_start: "";
        planning_end = ajax_task_data.taskTiming.planning_end? ajax_task_data.taskTiming.planning_end: "";
        deadline = ajax_task_data.taskTiming.dead_line? ajax_task_data.taskTiming.dead_line: "";
    } else {
        ajax_task_data = {};
        ajax_task_data.taskTiming = {};
        ajax_task_data.producer_id = user.id;
        ajax_task_data.responsible_id = [user.id];
        ajax_task_data.priority = 9;
    }
    $('.knbn-new-task-temp', knbn_task_popup).append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-knbn-tt-header",
    }));
    $('.knbn-new-task-temp', knbn_task_popup).append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-knbn-tt-cont",
        title: !isNewTask? ajax_task_data.title: "",
        description: !isNewTask? ajax_task_data.description: "",
    }));
    $(".knbn-new-ttc-top", knbn_task_popup).append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-new-task-checklist",
    }));

    $(".knbn-new-ttc-top", knbn_task_popup).append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-cont-employees-date-cont",
        responsible_id: isNewTask? logined_user.id: ajax_task_data.responsible_id[0].id ,
        responsible: isNewTask? `${logined_user.first_name} ${logined_user.last_name}`: `${ajax_task_data.responsible_id[0].first_name} ${ajax_task_data.responsible_id[0].last_name}`,
        producer_id: isNewTask? logined_user.id: ajax_task_data.producer_id[0].id,
        producer: isNewTask? `${logined_user.first_name} ${logined_user.last_name}`: `${ajax_task_data.producer_id[0].first_name} ${ajax_task_data.producer_id[0].last_name}`,
        isNewTask: isNewTask,
    }));
    if(!isNewTask){
        ajax_task_data.responsible_id = +ajax_task_data.responsible_id[0].id;
        ajax_task_data.producer_id = +ajax_task_data.producer_id[0].id;
    }
    $(".knbn-new-ttc-top", knbn_task_popup).append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-new-task-additional",
        minutes: !isNewTask ? (+ajax_task_data.taskTiming.time_track_planned_duration/60)%60 : "",
        hours: !isNewTask ? Math.floor(+ajax_task_data.taskTiming.time_track_planned_duration/3600) : "",
    }));
    if(!isNewTask){
        $(".knbn-additionally-time-check", knbn_task_popup).prop('checked', true);
        $(".bnbn-aditionally-times-box", knbn_task_popup).css("display", "block");
    }
    // let task_date_time_picker = kanbanTemplatesGenerationRightNewTaskPopup({item_get: "get-task-date-picker", data: new Date ()});
    for(let i = 0; i < 10; i++){
        let option = $(`<option value="${i}" >${i}</option>`);
        if(!isNewTask){
            if(i === ajax_task_data.priority){
                option.attr("selected", true);
            }
        } else if(i ===9){
            option.attr("selected", true)
        }
        $(".knbn-add-task-select",knbn_task_popup).append(option);
    }

    let executor_container =$(`.knt-add-new-employee-type-executor .knt-add-employee-name-cont`, knbn_task_popup);
    let observer_container =$(`.knt-add-new-employee-type-observer .knt-add-employee-name-cont`, knbn_task_popup);
    if (!isNewTask){
        if(ajax_task_data.observer_id.length){
            ajax_task_data.observer_id.forEach((item, i) =>{
                observer_container.append(kanbanTemplatesGenerationRightNewTaskPopup({
                    item_get: "get-add-new-employee-type",
                    employee_id:item.id,
                    employee:`${item.first_name} ${item.last_name}`
                }));
                ajax_task_data.observer_id[i] = +item.id;
            });
        }
        if(ajax_task_data.co_executor_id.length){
            ajax_task_data.co_executor_id.forEach((item, i) =>{
                executor_container.append(kanbanTemplatesGenerationRightNewTaskPopup({
                    item_get: "get-add-new-employee-type",
                    employee_id:item.id,
                    employee:`${item.first_name} ${item.last_name}`
                }));
                ajax_task_data.co_executor_id[i] = +item.id;
            });
        }
    }
    $('.knt-add-deadline .knt-date-span', knbn_task_popup).text(deadline);
    $('.knt-add-start-date .knt-date-span', knbn_task_popup).text(planning_start);
    $('.knt-add-end-date .knt-date-span', knbn_task_popup).text(planning_end);
    let set_deadline = $(".knt-add-deadline-popup-container", knbn_task_popup);
    let set_planning_start = $(".knt-task-start-date", knbn_task_popup);
    let set_end_date = $(".knt-task-end-date", knbn_task_popup);
    set_deadline.append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-task-date-picker",
        date: !isNewTask? deadline : moment().format("YYYY-MM-DD HH:mm:ss"),
        date_type: "deadline",
    }));
    set_planning_start.append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-task-date-picker",
        date: !isNewTask? planning_start : moment().format("YYYY-MM-DD HH:mm:ss"),
        date_type: "start"
    }));
    set_end_date.append(kanbanTemplatesGenerationRightNewTaskPopup({
        item_get: "get-task-date-picker",
        date: !isNewTask? planning_end : moment().format("YYYY-MM-DD HH:mm:ss"),
        date_type: "end" }));
    let start_picker = $(".task-date-picker", set_planning_start);
    let end_picker = $(".task-date-picker", set_end_date);
    let deadline_picker = $(".task-date-picker", knbn_task_popup);

    start_picker.datetimepicker({
        inline: true,
        timepicker: true,
        minDate: 0,
        minTime: moment().format(),
        disabledWeekDays: [0, 6],
        dayOfWeekStart: 1,
        scrollMonth:false,
    });
    end_picker.datetimepicker({
        inline: true,
        timepicker: true,
        minDate: 0,
        minTime: moment().format(),
        disabledWeekDays: [0, 6],
        dayOfWeekStart: 1,
        scrollMonth:false,
    });
    deadline_picker.datetimepicker({
        inline: true,
        timepicker: true,
        minDate: 0,
        minTime: moment().format(),
        disabledWeekDays: [0, 6],
        dayOfWeekStart: 1,
        scrollMonth:false,
    });

    setTimeout(() => addNewTaskRightPopupListeners(start_picker, end_picker, deadline_picker, isNewTask), 10);
    return knbn_task_popup;
}

function kanbanTemplatesGenerationRightNewTaskPopup(options = {}) {
    switch (options.item_get) {
        case "get-add-task-popup":
            return $(`
                <div class = "knbn-new-task-popup knbn-new-task-popup-z8">
                    <div class = "knbn-new-task-temp"></div>
                    <div class = "knbn-new-task-popup-save-container">
                        <button class = "save-new-task c-btn">Поставить Задачу</button>
                        <button id = "cancel-new-task" class = "c-btn c-btn-primary c-btn-ol">Отменить</button>
                   </div>
                </div>`);
            break;
        case 'get-knbn-tt-header':
            return $(`
                <div class = "knbn-tt-header">
                    <span class = "knbn-tt-header-task-name">Новая Задача</span>
                    <div class = 'knbn-tth-btn-group'>
                        <div>
                            <button type="button" class = 'c-btn c-btn-ol zone-eight-menu'><i class="fas fa-cog" ></i></button>
                            <div class = "menu-popup-items"></div>
                        </div>
                        <div class = 'knbn-tth-btn'>
                            <button type="button" class = 'c-btn zone-eight-open-task-popup'>Шаблоны задач<i class="fas fa-chevron-down"></i></button>
                            <div  class = "knbn-add-tasks"></div>
                </div></div></div>`);
            break;
        case 'get-add-new-employee-type':
            return $(`
                <div id = "${options.employee_id}" class = "knt-add-employee-name">
                    <span>${options.employee}</span>
                    <span class = "knt-delete-employee"><i class="fas fa-times"></i></span>
                </div>`);
            break;
        case 'get-task-date-picker':
            return $(`
                <div class = "task-date-picker-container">
                    <input data-date-type = "${options.date_type}" class="task-date-picker" type="text" value = "${options.date}">
                    <div class="task-date-picker-btns-cont">
                        <button class = "task-date-set c-btn c-btn-sm">Выбрать</button>
                        <button class = "task-date-cancel c-btn c-btn-primary c-btn-ol c-btn-sm">Закрыть</button>
                    </div>
                </div>`);
            break;
        case 'get-knbn-tt-cont':
            return $(`
                <div class = "knbn-tt-cont">
                    <div class = "knbn-new-ttc-left">
                        <div class = "knbn-new-ttc-top">
                            <div>
                                <div class="c-floating-label knbn-new-task-input-box">
                                    <input id = "task-title" type="text" placeholder=" " class="knbn-new-task-input" value = "${options.title}">
                                    <label>Введите название задачи</label>
                                </div>
                                <div class = "knbn-new-task-pr-box">
                                    <div class="c-floating-label knbn-new-ttc-set-priority">
                                        <select class="knbn-add-task-select" placeholder=" "></select>
                                        <label>приоритет</label>
                            </div></div></div>
                            <div>
                                <div class="knbn-new-task-textarea-box">
                                    <div class="c-floating-label">
                                        <textarea placeholder=" " class="knbn-new-task-textarea">${options.description}</textarea>
                                        <label>задача</label>
                </div></div></div></div></div></div>`);
            break;
        case 'get-new-task-checklist':
            return $(`
                 <div class = "ttttc-new-task-checklist">
                    <div class="knbn-new-task-checklist-body">
                        <ul class="knbn-new-task-checklist"></ul>
                    </div>
                    <div class="knbn-new-task-add-ch"><button class="c-btn-dashed-show c-btn-dashed-show-secondary new-task-add-checklist">+ добавить чеклист</button></div>
                </div>`)
            break;
        case 'get-cont-employees-date-cont':
            return  $(`
            <div>
                <div class="knbn-new-task-responsible-area">
                    <div class="knbn-new-task-responsible-row knt-add-new-employee-type">
                        <span class="responsible-row-item">Ответственный</span>
                        <div>
                            <div class = "knt-add-employee knt-border-div responsible-row-item" style="min-width: 300px">
                                <div data-emp-status = "responsible" class = "knt-add-employee-name-cont">
                                    <div id = "${options.responsible_id}" class = "knt-add-employee-name">
                                        <span>${options.responsible}</span>
                                        <span class = "knt-delete-employee"><i class="fas fa-times"></i></span>
                                    </div>
                                </div>
                                <div class = "knt-add-employee-add-change knt-add-employee-btn">
                                    <span data-employee-status = "responsible">${options.isNewTask? "+ добавить": "сменить"}</span>
                                </div>
                                <div class="knt-add-employee-popup"></div>
                            </div>
                            <div class="knbn-new-task-responsible-buttons responsible-row-item">
                                <button data-emplyee-type = "producer" class="c-btn-dashed knt-add-new-emp-type">Постановщик</button>
                                <button data-emplyee-type = "co-executor" class="c-btn-dashed knt-add-new-emp-type">Соисполнители</button>
                                <button data-emplyee-type = "observer" class="c-btn-dashed knt-add-new-emp-type">Наблюдатели</button>
                    </div></div></div>
                    <div class="knt-add-new-employee-type-producer">
                        <div class="knbn-new-task-responsible-row">
                            <span class="responsible-row-item">Постановщик</span>
                            <div class = "knt-add-employee knt-border-div responsible-row-item">
                                <div data-emp-status = "producer" class = "knt-add-employee-name-cont">
                                    <div id = "${options.producer_id}" class = "knt-add-employee-name">
                                        <span>${options.producer}</span>
                                </div></div>
                                <div class = "knt-add-employee-add-change knt-add-employee-btn">
                                    <span data-employee-status = "producer">+ сменить</span>
                                </div>
                                <div class="knt-add-employee-popup"></div>
                    </div></div></div>
                    <div class="knt-add-new-employee-type-executor">
                        <div  class="knbn-new-task-responsible-row">
                            <span class="responsible-row-item">Соисполнители</span>
                            <div class = "knt-add-employee knt-border-div responsible-row-item">
                                <div data-emp-status = "co-executor" class = "knt-add-employee-name-cont"></div>
                                <div class = "knt-add-employee-add-change knt-add-employee-btn">
                                    <span data-employee-status = "co-executor">+ добавить</span>
                                </div>
                                <div class="knt-add-employee-popup"></div>
                    </div></div></div>
                    <div class="knt-add-new-employee-type-observer">
                        <div class="knbn-new-task-responsible-row">
                            <span class="responsible-row-item">Наблюдатели</span>
                            <div class = "knt-add-employee knt-border-div responsible-row-item">
                                <div data-emp-status = "observer" class = "knt-add-employee-name-cont"></div>
                                <div class = "knt-add-employee-add-change knt-add-employee-btn">
                                    <span data-employee-status = "observer">+ добавить</span>
                                </div>
                                <div class="knt-add-employee-popup"></div>
                    </div></div></div>
                    <div class="knbn-new-task-responsible-row">
                        <span class="responsible-row-item">Крайний срок</span>
                        <div>
                            <div class="knt-border-div knt-add-deadline-popup-container">
                                <div class = "knt-add-deadline">
                                    <span class = "knt-date-span"></span>
                                    <span><i class="far fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="knbn-new-task-responsible-buttons responsible-row-item">
                                <button class="c-btn-dashed new-task-responsible-plane-btn">Планирование сроков</button>
                                <button class="c-btn-dashed new-task-responsible-more-btn">Еще</button>
                    </div></div></div>
                    <div class="knbn-new-task-responsible-row">
                        <div></div>
                        <div class = "knt-plane-box">
                            <div class="new-task-responsible-plane-row">
                                <div>
                                    <span>Начать задачу с</span>
                                    <div class="knt-border-div knt-add-startend-popup-container knt-task-start-date">
                                        <div class = "knt-add-startend knt-add-start-date">
                                            <span class = "knt-date-span"></span>
                                            <span><i class="far fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="responsible-plane-duration-box ">
                                     <span>Длительность</span>
                                     <div class="knt-border-div">
                                         <input type="text" class = "knt-duration" placeholder="">
                                     </div>
                                     <div class="responsible-plane-duration-buttons">
                                        <button data-dhm = "days" class="c-btn-dashed-show duration-btn">дней</button>
                                        <button data-dhm = "hours" class="c-btn-dashed-show duration-btn">часов</button>
                                        <button data-dhm = "minutes" class="c-btn-dashed-show duration-btn duration-btn-active">минут</button>
                                    </div>
                                </div>
                                <div>
                                    <span>Завершение</span>
                                    <div class="knt-border-div knt-add-startend-popup-container knt-task-end-date">
                                        <div class = "knt-add-startend knt-add-end-date">
                                                <span class = "knt-date-span"></span>
                                                <span><i class="far fa-calendar"></i></span>
                        </div></div></div></div></div>
                        <button class="new-task-responsible-plane-chooser"><i class="fas fa-thumbtack"></i></button>
                    </div>
                    <div class="new-task-responsible-more-box">
                        <div class="new-task-responsible-more-checkboxes">
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Разрешить ответственному менять сроки задачи</span>
                                </label>
                            </div>
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Пропустить выходные и праздничные дни</span>
                                </label>
                            </div>
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Принять работу после завершения задачи</span>
                                </label>
                            </div>
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Добавить себе в избранное</span>
                                </label>
                            </div>
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Добавить в план рабочего дня</span>
                                </label>
                            </div>
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Сроки определяются сроками подзадач</span>
                                </label>
                            </div>
                            <div class="responsible-more-checkbox-item">
                                <label class="c-label-checkbox">
                                    <input type="checkbox">
                                    <span>Автоматически завершать задачу при завершении подзадач (и наоборот)</span>
                                </label>
                            </div></div>
                        <button class="new-task-responsible-chooser"><i class="fas fa-thumbtack"></i></button>
                    </div></div>
            </div>`);
            break;
        case 'get-new-task-additional':
            return $(`
                <div class="knbn-new-task-additionally-box">
                    <div class="additionally-box-head">
                        <span class="additionally-box-head-title">
                            <span class="additionally-box-head-title-icon"><i class="fas fa-chevron-down"></i></span>
                            <span class="additionally-box-head-title-name">Дополнительно</span>
                        </span>
                        <span class="additionally-box-head-text">( Проект Учет времени Напомнить Повторять Гант CRM Подзадача Теги Поля )</span>
                    </div>
                    <div class="additionally-box-body">
                    
<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Проект</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <button class="c-btn c-btn-ol additionally-add-btn"><i class="fas fa-plus"></i> Добавить</button>-->
<!--                                    <button class="c-btn c-btn-link additionally-add-project">Создать проект</button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="knbn-additionally-box-item-wrap">
                            <div class="knbn-additionally-box-item">
                                <span class="additionally-box-item-title">Учет времени</span>
                                <div class="additionally-box-item-content">
<!--                                    <div>-->
<!--                                        <label class="c-label-checkbox">-->
<!--                                            <input type="checkbox" class="knbn-additionally-time-check">-->
<!--                                            <span>Время для выполнения задачи</span>-->
<!--                                        </label>-->
<!--                                    </div>-->
                                    <div class="bnbn-aditionally-times-box">
                                        <div class="c-floating-label">
                                            <input class = "time-track-hours" type="text" placeholder=" " value = "${options.hours}"maxlength="2" size="2">
                                            <label>часов</label>
                                        </div>
                                        <div class="c-floating-label">
                                            <input class = "time-track-minutes" type="text" placeholder=" " value = "${options.minutes}" maxlength="4" size="4">
                                            <label>минут</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Напомнить о задаче</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <button class="c-btn-dashed-show c-btn-dashed-show-primary"><i class="fas fa-plus"></i> Добавить напоминание</button>-->
<!--                                    <span class="additionally-box-item-text">сообщением или по e-mail</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Повторять задачу</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <label class="c-label-checkbox">-->
<!--                                        <input type="checkbox" class="knbn-additionally-regular-check">-->
<!--                                        <span>Сделать задачу регулярной</span>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="knbn-additionally-regular-box">-->
<!--                                <h1>regular content</h1>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Гант</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <button class="c-btn-dashed-show c-btn-dashed-show-primary">Добавить предшествующую задачу</button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">CRM</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <select>-->
<!--                                        <option value="">opyion 1</option>-->
<!--                                        <option value="">opyion 2</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Сделать подзадачей</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <select>-->
<!--                                        <option value="">option 1</option>-->
<!--                                        <option value="">option 2</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Теги</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <select>-->
<!--                                        <option value="">option 1</option>-->
<!--                                        <option value="">option 2</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Пользовательские поля</span>-->
<!--                                <div class="additionally-box-item-content item-content-flex">-->
<!--                                    <div class="knbn-additionally-user-field"><input type="date" class="knbn-additionally-user-field-input"></div>-->
<!--                                    <div><button class="c-btn-dashed-show c-btn-dashed-show-primary knbn-additionally-add-field">Добавить</button></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <button class="c-btn-dashed-show c-btn-dashed-show-primary knbn-additionally-show-field">Показать поле</button>-->
<!--                        </div>-->

<!--                        <div class="knbn-additionally-box-item-wrap">-->
<!--                            <div class="knbn-additionally-box-item">-->
<!--                                <span class="additionally-box-item-title">Связанные задачи</span>-->
<!--                                <div class="additionally-box-item-content">-->
<!--                                    <select>-->
<!--                                        <option value="">opyion 1</option>-->
<!--                                        <option value="">opyion 2</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>`);
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}

function addNewTaskRightPopupListeners(start_picker, end_picker, deadline_picker, isNewTask) {
    $(".new-task-add-checklist").on("click", function (e) {
        e.stopPropagation();
        let sort = $(".z-e-chechlist-box").length + 1;
        let checklist = {
            sort: sort,
            title: `Чек-лист ${sort}`,
            checklist_task:[],
            lists:[],
        }
        ajax_checklist.push(checklist);
        $(this).closest(".ttttc-new-task-checklist").find(".knbn-new-task-checklist").append(createCheckListContainer(checklist, true));
    });
    $('.time-track-hours').on("change", function (e){
        let parent = $(this).closest(".bnbn-aditionally-times-box");
        let minutes = parent.find(".time-track-minutes").val();
        let value = $(this).val();
        if(value/1){
            ajax_task_data.taskTiming.time_track_planned_duration = +value*3600 + +minutes*60;
            ajax_task_data.taskTiming.time_track_actual_duration = 0;
            // console.log(ajax_task_data.taskTiming);
        } else {$(this).val("");}

    });
    $('.time-track-minutes').on("change", function (e){
        let parent = $(this).closest(".bnbn-aditionally-times-box");
        let hours = parent.find(".time-track-hours").val();
        let value = $(this).val();
        if(value/1){
            ajax_task_data.taskTiming.time_track_planned_duration = +value*60 + +hours*3600;
            ajax_task_data.taskTiming.time_track_actual_duration = 0
            // console.log(ajax_task_data.taskTiming);
        } else { $(this).val("");}
    });
    // $(".knbn-new-task-popup-close").on('click', function () {
    //     ajax_task_data = {};
    // });
    $("#task-title").on("change", function (e) {
        if($(this).val().trim()){
            ajax_task_data.title = $(this).val();
        }
    });
    $(".knbn-new-task-textarea").on("change", function (e) {
        if($(this).val().trim()){
            ajax_task_data.description = $(this).val();
        }
    });
    $('.knbn-new-task-pr-check').on('change', function (e) {
        ajax_task_data.important = ajax_task_data.important ? false : true;
        // console.log(ajax_task_data);
        $(this).closest('.knbn-new-task-pr-box').find('.knbn-new-task-fire').toggleClass('knbn-new-task-fire-active');
    });
    $(".knt-add-new-emp-type").on("click", function (e) {
        let parent = $(this).closest(".knbn-new-task-responsible-area");
        let employee_status = $(this).attr("data-emplyee-type");
        switch (employee_status) {
            case "producer":
                parent.find(".knt-add-new-employee-type-producer").toggle("blind");
                break;
            case "co-executor":
                parent.find(".knt-add-new-employee-type-executor").toggle("blind");
                break;
            case "observer":
                parent.find(".knt-add-new-employee-type-observer").toggle("blind");
                break;
            default:
                alert("none");
        }
    });
    $("body").on("click", '.knt-add-employee-btn', function (e) {
        e.stopImmediatePropagation();
        let target = $(this).closest(".knt-add-employee").find(".knt-add-employee-popup");
        let employee_status = $(this).attr("data-employee-status");
        if (target.is(":visible")) {
            target.hide();
        }
        else {
            getEmployees(target, employee_status, null, false);
        }
    });
    // toggle new task additionally
    $('.additionally-box-head').on('click', function () {
        $(this).closest('.knbn-new-task-additionally-box').find('.additionally-box-body').toggle('blind');
        $(this).find('.additionally-box-head-title-icon').toggleClass('additionally-box-head-title-icon-rotate');
    });
    // toggle new task plane
    $('.new-task-responsible-plane-btn').on('click', function () {
        $(this).closest('.knbn-new-task-responsible-area').find('.knt-plane-box').toggle('blind');
    });
    // toggle new task duration active button
    $('.responsible-plane-duration-buttons .duration-btn').on('click', function () {
        let dhm = $(this).attr("data-dhm");
        let duration = $(this).closest(".responsible-plane-duration-box ").find(".knt-duration").val();
        $(this).closest('.responsible-plane-duration-buttons').find('.duration-btn').removeClass("duration-btn-active");
        $(this).addClass('duration-btn-active');
        if (duration) {
            let text_span = $(this).closest(".new-task-responsible-plane-row").find(".knt-add-end-date").find(".knt-date-span");
            ajax_task_data.taskTiming.planning_end = calculateDurationStartEndDate(dhm, duration, ajax_task_data.taskTiming.planning_start);
            text_span.text(kanbanDateByString(ajax_task_data.taskTiming.planning_end));
        }
        // console.log(ajax_task_data.taskTiming);
    });
    // toggle new task more
    $('.new-task-responsible-more-btn').on('click', function () {
        $(this).closest('.knbn-new-task-responsible-area').find('.new-task-responsible-more-box').toggle('blind');
    });
    // toggle new task plane dates
    $('.new-task-responsible-plane-chooser').on('click', function () {
        $(this).toggleClass('new-task-responsible-plane-chooser-checked');
    });
    // toggle new task more checkboxes list
    $('.new-task-responsible-chooser').on('click', function () {
        $(this).toggleClass('new-task-responsible-chooser-checked');
    });
    // toggle additionally time inputs
    $('.knbn-additionally-time-check').on('change', function () {
        $(this).closest('.additionally-box-item-content').find('.bnbn-aditionally-times-box').toggle('blind');
    });
    // toggle additionally regular task
    $('.knbn-additionally-regular-check').on('change', function () {
        $(this).closest('.knbn-additionally-box-item-wrap').find('.knbn-additionally-regular-box').toggle('blind');
    });
    // add user field date input
    $('.knbn-additionally-add-field').on('click', function () {
        let field = $(this).closest('.additionally-box-item-content').find('.knbn-additionally-user-field')[0];
        let clonedField = $(field).clone(true).append('<button class="knbn-additionally-user-field-delete"><i class="fas fa-times"></i></button>');
        $(this).parent().before(clonedField);
    });
    // delete user field date input
    $('.additionally-box-item-content').on('click', '.knbn-additionally-user-field-delete', function () {
        $(this).closest('.knbn-additionally-user-field').hide('normal', function () { $(this).remove(); });
    });
    $(".knt-delete-employee").on("click", function (e) {
        deleteNewEmployee($(this));
    });
    $(".knt-add-deadline").on("click", function (e) {
        let container = $(this).closest(".knt-border-div").find(".task-date-picker-container");
        if(container.is(":visible")){
            container.hide();
        } else {
            $(".task-date-picker-container").hide();
            container.show();
        }
    });
    $(".knt-add-start-date").on("click", function (e) {
        let container = $(this).closest(".knt-task-start-date").find(".task-date-picker-container");
        if(container.is(":visible")){
            container.hide();
        } else {
            $(".task-date-picker-container").hide();
            container.show();
        }
    });
    $(".knt-add-end-date").on("click", function (e) {
        let container = $(this).closest(".knt-task-end-date").find(".task-date-picker-container");
        if(container.is(":visible")){
            container.hide();
        } else {
            $(".task-date-picker-container").hide();
            container.show();
        }
    });
    $(".task-date-cancel").on("click", function (e) {
        $(this).closest(".task-date-picker-container").hide();
    });
    $(".task-date-set").on("click", function (e) {
        let parent = $(this).closest(".knt-border-div");
        let grand_parent = parent.closest(".new-task-responsible-plane-row");
        let dhm = grand_parent.find(".duration-btn-active").attr("data-dhm");
        let duration = grand_parent.find(".knt-duration");
        let planning_start_span = grand_parent.find(".knt-add-start-date").find(".knt-date-span");
        let end_date_span = grand_parent.find(".knt-add-end-date").find(".knt-date-span");
        let time_picker = $(this).closest(".task-date-picker-container").find('.task-date-picker');
        let date = time_picker.datetimepicker('getValue');
        let draw_date = kanbanDateByString(date);
        switch (time_picker.attr("data-date-type")) {
            case "end":
                parent.find(".knt-date-span").text(draw_date);
                 
                ajax_task_data.taskTiming.planning_end = moment(date).format('YYYY-MM-DD HH:mm:ss');
                if (ajax_task_data.taskTiming.planning_start && duration.val()) {
                    let dur = calculateDurationOfNewTAsk(ajax_task_data.taskTiming.planning_start, ajax_task_data.taskTiming.planning_end, dhm);
                    duration.val(dur);
                }
                // console.log(ajax_task_data.taskTiming);
                break;
            case "start":
                parent.find(".knt-date-span").text(draw_date);
                ajax_task_data.taskTiming.planning_start = moment(date).format('YYYY-MM-DD HH:mm:ss');
                end_picker.datetimepicker({ minDate: date });
                if (ajax_task_data.taskTiming.planning_end && ajax_task_data.taskTiming.planning_end < ajax_task_data.taskTiming.planning_start) {
                    end_picker.datetimepicker({ value: date });
                    end_date_span.text(kanbanDateByString(ajax_task_data.taskTiming.planning_start));
                }
                if (duration.val()) {
                    let dur = calculateDurationOfNewTAsk(ajax_task_data.taskTiming.planning_start, ajax_task_data.taskTiming.planning_end, dhm);
                    duration.val(dur);
                }
                // console.log(ajax_task_data.taskTiming);
                break;
            case "deadline":
                parent.find(".knt-date-span").text(draw_date);
                ajax_task_data.taskTiming.dead_line = moment(date).format('YYYY-MM-DD HH:mm:ss');
                // console.log(ajax_task_data.taskTiming);
                break;
            default:
                alert("none");
        }
        $(this).closest(".task-date-picker-container").hide();
    });
    $('.knbn-add-task-select').on("change", function () {
        ajax_task_data.priority = $(this).val();
    })
    $(".knt-duration").on("keydown", function (e) {
        let parent = $(this).closest(".new-task-responsible-plane-row");
        let planning_start_node = parent.find(".knt-add-start-date");
        let end_date_node = parent.find(".knt-add-end-date");
        let keyCode = e.keyCode;
        let input_value = $(this).val().trim();
        let dhm = $(".duration-btn-active").attr("data-dhm");
        let planning_start = ajax_task_data.taskTiming.planning_start ? ajax_task_data.taskTiming.planning_start : moment();
        if (!ajax_task_data.taskTiming.planning_start) {
            ajax_task_data.taskTiming.planning_start = planning_start;
            planning_start_node.find(".knt-date-span").text(kanbanDateByString(planning_start));
            // console.log(ajax_task_data.taskTiming);
        }
        // console.log(ajax_task_data.taskTiming);
        let date;
        if (keyCode === 8) {
            if (input_value) {
                input_value = input_value.substring(0, input_value.length - 1);
                date = calulateStartEndDate(planning_start, +input_value, dhm);
            }
        }
        else if (keyCode >= 48 && keyCode <= 57 || keyCode >= 96 && keyCode <= 105) {
            let key_value = e.originalEvent.key;
            let time = input_value + key_value;
            date = calulateStartEndDate(planning_start, +time, dhm);
        }
        else {
            return false;
        }
         
        ajax_task_data.taskTiming.planning_end = moment(date).format('YYYY-MM-DD HH:mm:ss');
        // console.log(ajax_task_data.taskTiming);
        let draw_date = kanbanDateByString(date);
        end_date_node.find(".knt-date-span").text(draw_date);
        end_picker.datetimepicker({ value: date });
    });
    $('#cancel-new-task').on("click", function (e) {
        ajax_task_data = {};
        $('#modal').modal('hide');
        getKabanDataAndDrawKanban("task");
    });
    $('.save-new-task').on("click", function (e) {
        let title = $("#task-title").val()
        if(title.trim()){
            if(ajax_task_data.id){
                updateTaskFromPopup(ajax_task_data);
            } else {
                addNewTaskFromPopup(ajax_task_data);
            }
        } else {
            let title_input = $("#task-title");
            $('.popup2, .knbn-new-task-temp').animate({
                scrollTop: title_input.offset().top
            }, 1000);
            title_input.css({"border-color": "#ff5752"});
            title_input.closest("div").find("label").css("color", "#ff5752");
        }
    });
    $(".zone9").on("click", function (e){
        let target = $(e.target);
        if(!target.closest(".task-date-picker-container, .knt-add-deadline, .knt-add-startend").length) {
            $(".task-date-picker-container").hide();
        }
    });
}

function deleteNewEmployee(target){
    let target_cont = target.closest(".knt-add-employee-name");
    let target_id = +target_cont.attr("id");
    let employee_status = target.closest(".knt-add-employee-name-cont").attr("data-emp-status");
    switch (employee_status) {
        case "responsible":
            ajax_task_data.responsible_id = ajax_task_data.responsible_id.filter(item => item !== target_id);
            break;
        case "co-executor":
            ajax_task_data.co_executor_id = ajax_task_data.co_executor_id.filter(item => item !== target_id);
            break;
        case "observer":
            ajax_task_data.observer_id = ajax_task_data.observer_id.filter(item => item !== target_id);
            break;
    }
    target_cont.remove();
}
