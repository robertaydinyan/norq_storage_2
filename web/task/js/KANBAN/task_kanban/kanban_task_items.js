"use strict";
/**
 * createKanbanTaskItems
 * @param task_data
 * @param alias
 * @param color
 * @param index
 */
function createKanbanTaskItems(task_data, alias, color, index) {
    let knbn_column = kanbanTemplatesGenerateTaskItems({
        item_get: 'get-knbn-task-column',
        index: index,
    });
    knbn_column.data("taskContInfo", { column_color: color, column_alias: alias, });
    let today = moment();
    let notification_color = index ? '#9dcf00' : '#f54819';
    task_data.forEach((item) => {
        let background_color = color;
        let deadline = item.deadline;
        let draw_date = '';
        let date_grey_color = "";
        let task_delayed;
        let no_limit = !item.deadline;
        let completed = false;
        let pause = false;
        switch(item.status) {
            case "waiting":
                pause = false;
                break;
            case "doing":
                pause = true;
                break;
            case "delayed":
                draw_date = 'Отложена';
                background_color = '#ffffff';
                date_grey_color += "knbn-tc-date-grey";
                task_delayed = "delayed";
                break;
            case "completed":
                completed = true;
                draw_date += "Завершена";
                date_grey_color += "knbn-tc-date-grey";
                break;
            default:
                console.log("something wrong happend");
        }
        if (!draw_date && no_limit) {
            draw_date = 'Не указано';
            background_color = '#ffffff';
            date_grey_color += "knbn-tc-date-grey";
        } else if (!completed && !draw_date) {
            draw_date = getKanbanDate(deadline, today);
            deadline = moment(deadline).format;
        }
        `${item.producer_id[0].first_name} ${item.producer_id[0].last_name}`
        const knbn_task = kanbanTemplatesGenerateTaskItems({
            item_get: 'get-knbn-task-item',
            id: item.id,
            priority: item.priority,
            title: item.title,
            date: deadline,
            sort: item.sort,
            producer_img: item.producer_id[0] && item.producer_id[0].avatar? `${url}${item.producer_id[0].avatar.url}` : +item.gender?  "/task/images/female-user-128.png" : "/task/images/user-male-128.png" ,
            producer_alt: item.producer_id[0] ? `${item.producer_id[0].first_name} ${item.producer_id[0].last_name}` : "no name",
            responsible_img: item.responsible_id[0] && item.responsible_id[0].avatar ? `${url}${item.responsible_id[0].avatar.url}`: +item.gender?  "/task/images/female-user-128.png" : "/task/images/user-male-128.png",
            responsible_alt: item.producer_id[0]? `${item.responsible_id[0].first_name} ${item.responsible_id[0].last_name}`: "no name",
            notification_color: notification_color,
            notification: item.notification,
            alias: alias,
            grey: date_grey_color,
            no_limit: no_limit,
            draw_date: draw_date,
            background_color: background_color,
            color: color,
            completed: completed,
            alert: item.notification_alert,
            pause: pause,
            checklists_info: item.checklists_info,
        });
        if(item.checklists_info){
            $(".knbn-tasks-item-checklist", knbn_task).append($(`<span><i class="far fa-check-square"></i></span>`));
            $(".knbn-tasks-item-checklist", knbn_task).append($(`<span>${item.checklists_info}</span>`));
        }
        if(item.tag_id.length){
            item.tag_id.forEach(tag => {
                $(".knbn-tasks-tags", knbn_task).append($(`<span data-tag-id = "${tag.id}">${tag.name}</span>`));
            });
        }
        knbn_task.data("taskInfo", { alias: alias, status: item.status});
        knbn_column.append(knbn_task);
        $('.knbn-task-calendar', knbn_column).datetimepicker({
            inline: true,
            minDate: '0',
            minTime: new Date(),
            disabledWeekDays: [0, 6],
            dayOfWeekStart: 1,
        });
        setTimeout(() => addTaskItemListeners(knbn_task), 100)
    });
    return knbn_column;
}
function kanbanTemplatesGenerateTaskItems(options = {}) {
    switch (options.item_get) {
        case 'get-knbn-task-column':
            return $(`
                <ul class = "${options.index ? 'knbn-task-column' : 'knbn-task-undropable'}">
                    <li class = 'knbn-task-add'>
                        <div class="add-task-popup">
                            <div class="add-task-item">
                                <div class="c-floating-label">
                                    <textarea rows="7" class = "knbn-task-textarea" placeholder=" "></textarea>
                                    <label>Название #тег</label>
                                </div>
                            </div>
                            <div class="add-task-item">
                                <div class="c-floating-label">
                                    <select class="knbn-add-task-select" placeholder=" ">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9" selected>9</option>
                                    </select>
                                    <label>приоритет</label>
                                </div>
                            </div>
                            <div class="add-task-item">
                                <button class = 'knbn-new-task-save c-btn c-btn-sm'>Сохранить</button>
                                <button class = 'knbn-new-task-cancel c-btn c-btn-sm c-btn-link'>Отменить</button>
                            </div>
                        </div>
                    </li>
                </ul>`);
            break;
        case "get-knbn-task-item":

            let modalUrl = $('.task-modal').attr('data-task-module-url');
            return $(`
            <li id = "${options.id}" data-priority = "${options.priority}"  data-sort = "${options.sort}" class = "knbn-task-item" style = "border-right-color: ${options.color}">
                <div class = "knbn-task-cont">
                    <div>
                        <div class = "knbn-tc-top">
                            <div>
                                <span class = "knbn-tc-alert" style = "display: ${options.alert ? 'none' : 'inline'}"><i class="fas fa-bell-slash"></i></span>
                                <span class="knbn-t-num task-priority-color-${options.priority}">${options.priority}</span>
                            </div>
                            <span class = 'knbn-item-link' data-value='${modalUrl}' title='TV Каналл'>${options.title}</span>
                        </div>
                        <div class="knbn-tasks-item-info" style="margin-bottom: ${options.checklists_info? "8px" : "0"}">
                            <div class="knbn-tasks-tags"></div>
                            <div class="knbn-tasks-item-checklist" style="border: ${options.checklists_info? "1px solid #25af36" : "none"}"></div>
                            <div class="knbn-tasks-item-files"></div>
                        </div>
                        <div class = "knbn-ti-date">
                            <div class = "knbn-ti-task-date">
                                <span class  = "knbn-tc-date ${options.grey}" style = "background-color: ${options.completed ? "#ffffff" : options.background_color}">${options.draw_date}</span>
                            </div>
                            <div class = "knbn-ti-calendar">
                                <input class="knbn-task-calendar" type="text" value="${options.date}" >
                                <div class="knbn-task-calendar-buttons">
                                    <button class = 'knbn-task-calendar-pic-time c-btn c-btn-sm'>Выбрать</button>
                                    <button class="knbn-task-calendar-close c-btn c-btn-secondary c-btn-ol c-btn-sm">Закрыть</button>
                                </div>
                            </div>
                        </div>
                        <div class="knbn-item-bottom">
                            <div class = 'knbn-resp-cont'>
                                <img  id = "${options.producer_id}" data-employee-status = "producer" class = 'knbn-employee-img' src ="${options.producer_img}" alt="${options.producer_alt}"/>
                                <span class = "sec-resp"><i class="fas fa-chevron-right"></i><img data-employee-status = "responsible" class = 'knbn-employee-img' src = "${options.responsible_img}" alt = "${options.responsible_alt}"/></span>
                                <div class = "knbn-resp-cont-popup"></div>
                            </div>
                            <div class = 'knbn-t-icon-cont'>
                                <div>
                                    <div>
                                        <span class = "knbn-t-icon-alert" style="display: ${options.alert ? 'block' : 'none'}"><i class="fas fa-bell-slash"></i></span>
                                        <span class = "knbn-t-icon-noalert" style="display: ${options.alert ? 'none' : 'block'}"><i class="fas fa-bell"></i></span>
                                    </div>
                                    <div style="display: ${options.completed ? 'none' : 'block'}">
                                        <span class = "knbn-t-icon-pp task-play" style="display: ${options.pause ? 'none' : 'block'}"><i class="fas fa-play-circle"></i></span>
                                        <span class = "knbn-t-icon-pp task-pause" style="display: ${options.pause ? 'block' : 'none'}"><i class="fas fa-pause-circle"></i></span>
                                    </div>
                                    <span class = "knbn-t-icon-complete" style="display: ${options.completed ? 'none' : 'block'}"><i class="fas fa-flag"></i></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    ${options.notification ? $(`<span class = "knbn-tc-r-num" style = "background-color: ${options.notification_color}">${options.notification}</span>`)[0].outerHTML : ''}
                </div>
            </li>`);
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}

function addTaskItemListeners(knbn_task) {
    ///======================= expired column is not draggable==============================/
    $('.knbn-task-undropable').sortable({
        connectWith: ".knbn-task-column",
        handle: ".knbn-task-cont",
        placeholder: 'knbn-item-placeholder',
        cursor: 'grabbing',
        stop: function (event, ui) {
            let elem = $(ui.item);
            generateKanbanTaskColorAndDate(elem);
        }
    }).disableSelection();

    $('.knbn-task-column').sortable({
        items: "li:not(.knbn-task-add)",
        connectWith: ".knbn-task-column",
        handle: ".knbn-task-cont",
        placeholder: 'knbn-item-placeholder',
        cursor: 'grabbing',
        stop: function (event, ui) {
            let elem = $(ui.item);
            generateKanbanTaskColorAndDate(elem);
        }
    }).disableSelection();

    $(".knbn-tc-date", knbn_task).on("click", function (e) {
        e.stopPropagation();
        let item = $(e.target).closest('.knbn-ti-date').find('.knbn-ti-calendar');
        if (item.is(":visible")) {
            item.hide();
        } else {
            $('.knbn-ti-calendar').hide();
            item.show();
        }
    });

    $('.knbn-item-link', knbn_task).on('click', function (e) {
        e.stopPropagation();
        let task_id = $(this).closest('li').attr('id');
        let popup = $(".popup1");
        let modal = $('#modal');
        modal.modal('show')
            .addClass('sk-rtl-modal')
            .find('#modalContent')
            .load($(this).attr('data-value'), function () {
                //dynamiclly set the header for the modal
            });
        setTimeout(function () {
            openCurrentTaskInfo(task_id, "popup");
        }, 200)
        // openCurrentTaskInfo(task_id, "popup");
        // zoneNineHideShow(popup, "show");
    });

    $('.knbn-t-icon-alert', knbn_task).on('click', function (e) {
        e.stopPropagation();
        toggleNotificationAlert($(e.target).closest('li'), false);
    });

    $('.knbn-t-icon-noalert', knbn_task).on('click', function (e) {
        e.stopPropagation();
        toggleNotificationAlert($(e.target).closest('li'), true);
    });

    $('.knbn-t-icon-complete', knbn_task).on('click', function (e) {
        e.stopPropagation();
        onChangeTaskStatus($(e.target).closest('li'), "completed");
    });

    $('.task-play',knbn_task).on('click', function (e) {
        e.stopPropagation();
        onChangeTaskStatus($(e.target).closest('li'), "doing");
    });

    $('.task-pause', knbn_task).on('click', function (e) {
        e.stopPropagation();
        onChangeTaskStatus($(e.target).closest('li'), "waiting");
    });

    $('.knbn-task-calendar-pic-time', knbn_task).on('click', function (e) {
        e.stopPropagation();
        let time_picker = $(this).closest(".knbn-ti-calendar").find('.knbn-task-calendar');
        let task_id = $(this).closest('li').attr('id');
        let date = time_picker.datetimepicker('getValue');
        calculateDateChangedByDateTimePicker(task_id, date);
    });

    $('.knbn-task-calendar-close', knbn_task).on('click', function (e) {
        e.stopPropagation();
        $(this).closest(".knbn-ti-calendar").hide();
    });

    $('.knbn-employee-img', knbn_task).on('click', function (e) {
        e.stopPropagation();
        let target = $(this);
        let opened_popups = $('.knbn-resp-cont-popup');
        let popup = $(this).closest('li').find('.knbn-resp-cont-popup');
        if (opened_popups.length){
            opened_popups.hide();
            popup.show();
        } else {
            opened_popups.hide();
        }
        // var offset = target.offset();
        // popup.css("top", offset.top - 80);
        // let window_width = $(window).width();
        // if (window_width - offset.left >= 600) {
        //     popup.css("right", 'unset');
        //     popup.css("left", offset.left - 430);
        // }
        // else {
        //     popup.css("left", 'unset');
        //     popup.css("right", window_width - offset.left - 100);
        // }
        getEmployees(popup, target.attr('data-employee-status'), target.closest('li').attr('id'), false);
    });

    $("body").on("click", function (e) {
        let target = $(e.target);
        let popup = $('.knbn-resp-cont-popup');
        if (!target.closest('.knbn-resp-cont-popup').length && popup.is(":visible")) {
            popup.hide();
        }
    });

    $('body').on("click", function (e) {
        let target = $(e.target);
        if(!target.closest(".knbn-ti-calendar").length){
            $(".knbn-ti-calendar").hide();
        }
    });
}
function onChangeTaskStatus (task, text){
    if(text === "completed"){
        changeTaskStatus(task.attr('id'), text, 'kanban');
    } else {
        task.find(".task-pause").toggle();
        task.find(".task-play").toggle();
        changeTaskStatus(task.attr('id'), text, 'kanban');
    }
}
function toggleNotificationAlert (task, boolean){
    notificationAlertToggle(task.attr('id'), boolean);
    task.find(".knbn-tc-alert").toggle();
    task.find(".knbn-t-icon-alert").toggle();
    task.find(".knbn-t-icon-noalert").toggle();
}