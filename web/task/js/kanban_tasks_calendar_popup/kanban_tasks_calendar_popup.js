"use strict";

function addRightCalendarPopupBtnListener() {

}
// addRightCalendarPopupBtnListener();

function createKanbanCalendarTasks(data, refresh = false) {
    // debugger;
    let knbn_calendar_popup = kanbanTemplatesTasksCalendarPopup({ item_get: 'get-knbn-right-popup' });
    let knbn_calendar_tasks = $('<div class = "knbn-c-task-cont"></div>');
    let today = moment();
    data.forEach((item) => {
        let expired = false;
        let background_color = "#ECFAFF";
        let draw_date = '';
        let completed = false;
        let pause = false;
        let task_delayed = false;
        let deadline = item.deadline;
        if (item.status === "waiting") {
            pause = false;
        }
        else if (item.status === "doing") {
            pause = true;
        }
        else {
            completed = true;
            draw_date += "Завершена";
        }
        if (deadline && (new Date(deadline) - new Date()) < 0 && !completed) {
            expired = true;
            background_color = "#FFF7F0";
        }
        if ((!deadline || deadline === 'delayed') && !completed) {
            draw_date = !deadline ? 'Не указано' : 'Отложена';
            background_color = '#ffffff';
            task_delayed = true;
        }
        else if (!completed) {
            draw_date = getKanbanDate(deadline, today);
        }
        knbn_calendar_tasks.append(kanbanTemplatesTasksCalendarPopup({
            item_get: 'get-knbn-c-cont',
            id: item.id,
            priority: item.priority,
            title: item.title,
            date: draw_date,
            producer_name: item.producer_id[0].full_name,
            background_color: background_color,
            expired: expired,
            completed: completed,
            alert: item.notification_alert,
            pause: pause,
            pinned: item.pinned,
        }));
    });
    if(refresh){
        return knbn_calendar_tasks;
    } else {
        $('.knbn-right-tasks', knbn_calendar_popup).html(knbn_calendar_tasks);
        $('#kbn-calendar', knbn_calendar_popup).datetimepicker({
            inline: true,
            timepicker: false,
            onSelectDate:function(ct,$i){
                let date  = moment(ct).format();
                let index  = date.indexOf("T");
                kanbanCalendarbyDate(date.slice(0, index));
            }
        });
        setTimeout(() => addCalendarTasksListneres(), 10);
        return knbn_calendar_popup;
    }
}

function kanbanTemplatesTasksCalendarPopup(options = {}) {
    switch (options.item_get) {
        case 'get-knbn-right-popup':
            return $(`           
                <div class = 'knbn-right-cont'>
                    <div class = 'knbn-calendar'>
                        <input id="kbn-calendar" type="text" >
                    </div>
                    <div class = 'knbn-calendar-filter'>
                        <div class = "knbn-cf-btns">
                            <button type = "button" class="knbn-cf-main-btn c-btn">Список Задач</button>
                        </div>
                        <div class = "knbn-c-filters">
                            <button type = "button" class="c-btn knbn-task-list-btn">Список Задач</button>
                            <button type = "button" class="c-btn c-btn-info knbn-today-task-list-btn">На Сегодня</button>
                            <button type = "button" class="c-btn c-btn-warning knbn-expired-task-list-btn">Просроченные</button>
                            <button type = "button" class="c-btn c-btn-danger knbn-no-limit-task-list-btn">Без срока</button>
                        </div>
                    </div>
                    <div class ='knbn-right-tasks'></div>
                </div>`);
            break;
        case 'get-knbn-c-cont':
            return $(`
            <div id = "${options.id}" class = "knbn-c-cont" style="background-color: ${options.background_color}">
                <div class = "knbn-c-left">
                    <div><span class = 'knbn-t-num'>${options.priority}</span><span class = "knbn-t-title">${options.title}</span></div>
                    <div class = 'knbn-resp-cont'>
                        <span class = "sec-resp">${options.producer_name}</span>
                    </div>
                    <div class = "knbn-cl-date"><span>${options.date}</span></div>
                </div>
                <div class ="knbn-cr-top">
                    <span class = "knbn-overdue">${options.expired ? "просрочено" : ""}</span>
                    ${options.expired ? $('<span><i class="fas fa-fire"></i></span>')[0].outerHTML : ''}
                    <div class = 'knbn-cr-top-pinned ${options.pinned ? 'ispinned' : ''}' style="display: ${options.pinned ? "block" : "none"}">
                        <span class = 'knbn-unpined' style="display: ${options.pinned ? "none" : "block"}"><i class="fas fa-thumbtack"></i></span>
                        <span class = 'knbn-pined' style="display: ${options.pinned ? "block" : "none"}"><i class="fas fa-thumbtack"></i></span>
                    </div>
                </div>
                <div class ="knbn-cr-bot">
                    <div>
                        <div>
                            <span class = "knbn-cr-icon-alert" style="display: ${options.alert ? 'block' : 'none'}"><i class="fas fa-bell-slash"></i></span>
                            <span class = "knbn-cr-icon-noalert" style="display: ${options.alert ? 'none' : 'block'}"><i class="fas fa-bell"></i></span>
                        </div>
                        <div style="display: ${options.completed ? 'none' : 'block'}">
                            <span class = "knbn-t-icon-pp cr-task-play" style="display: ${options.pause ? 'none' : 'block'}"><i class="fas fa-play-circle"></i></span>
                            <span class = "knbn-t-icon-pp cr-task-pause" style="display: ${options.pause ? 'block' : 'none'}"><i class="fas fa-pause-circle"></i></span>
                        </div>
                        <span class = "knbn-cr-icon-complete" style="display: ${options.completed ? 'none' : 'block'}"><i class="fas fa-flag"></i></span>                          
                    </div>
                </div>
            </div>`);
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}

function addCalendarTasksListneres(isRefresh = false) {
    if(!isRefresh){
        $('.knbn-task-list-btn').on('click', function (e) {
            e.stopPropagation();
            getTaskDataForKanbanCalendar();
            let main_btn = $(this).closest(".knbn-calendar-filter").find(".knbn-cf-main-btn");
            main_btn.text($(this).text()).css("background-color", `${$(this).css("background-color")}`);
            $(this).closest(".knbn-c-filters").hide();
        });
        $('.knbn-today-task-list-btn').on('click', function (e) {
            e.stopPropagation();
            kanbanCalendarbyDate("today");
            let main_btn = $(this).closest(".knbn-calendar-filter").find(".knbn-cf-main-btn");
            main_btn.text($(this).text()).css("background-color", `${$(this).css("background-color")}`);
            $(this).closest(".knbn-c-filters").hide();
        });
        $('.knbn-expired-task-list-btn').on('click', function (e) {
            e.stopPropagation();
            kanbanCalendarbyDate("expired");
            let main_btn = $(this).closest(".knbn-calendar-filter").find(".knbn-cf-main-btn");
            main_btn.text($(this).text()).css("background-color", `${$(this).css("background-color")}`);
            $(this).closest(".knbn-c-filters").hide();
        });
        $('.knbn-no-limit-task-list-btn').on('click', function (e) {
            e.stopPropagation();
            kanbanCalendarbyDate("no limit");
            let main_btn = $(this).closest(".knbn-calendar-filter").find(".knbn-cf-main-btn");
            main_btn.text($(this).text()).css("background-color", `${$(this).css("background-color")}`);
            $(this).closest(".knbn-c-filters").hide();
        });
        $(".knbn-cf-main-btn").on("click", function (e) {
            e.stopPropagation();
            $(this).closest(".knbn-calendar-filter").find(".knbn-c-filters").toggle();
        });
    }

    $('.knbn-c-cont').on('mouseover', function (e) {
        $(this).find('.knbn-cr-top-pinned').show();
    });
    $('.knbn-c-cont').on('mouseout', function (e) {
        if (!$(this).find('.knbn-pined').is(":visible")) {
            $(this).find('.knbn-cr-top-pinned').hide();
        }
    });
    $('.knbn-cr-top-pinned').on('click', function (e) {
        e.stopPropagation();
        $(this).find(".knbn-unpined").toggle();
        $(this).find(".knbn-pined").toggle();
        let task_id = $(this).closest(".knbn-c-cont").attr('id');
        if ($(this).hasClass('ispinned')) {
            kanbanTaskPinned(task_id, false);
            $(this).removeClass('ispinned');

        }
        else {
            kanbanTaskPinned(task_id, true);
            $(this).addClass('ispinned');
        }
    });
    $('.knbn-cr-icon-alert').on('click', function (e) {
        e.stopPropagation();
        let task = $(e.target).closest('div');
        let task_id = task.closest(".knbn-c-cont").attr('id');
        notificationAlertToggle(task_id, false);
        task.find(".knbn-cr-icon-alert").toggle();
        task.find(".knbn-cr-icon-noalert").toggle();
    });
    $('.knbn-cr-icon-noalert').on('click', function (e) {
        e.stopPropagation();
        let task = $(e.target).closest('div');
        let task_id = task.closest(".knbn-c-cont").attr('id');
        notificationAlertToggle(task_id, true);
        task.find(".knbn-cr-icon-alert").toggle();
        task.find(".knbn-cr-icon-noalert").toggle();
    });
    $('.cr-task-play').on('click', function (e) {
        e.stopPropagation();
        let task = $(e.target).closest('div');
        let task_id = task.closest(".knbn-c-cont").attr('id');
        task.find(".cr-task-pause").toggle();
        task.find(".cr-task-play").toggle();
        taskStartStop(task_id, false);
    });
    $('.cr-task-pause').on('click', function (e) {
        let task = $(e.target).closest('div');
        let task_id = task.closest(".knbn-c-cont").attr('id');
        task.find(".cr-task-pause").toggle();
        task.find(".cr-task-play").toggle();
        taskStartStop(task_id, true);
    });
    $('.knbn-cr-icon-complete').on('click', function (e) {
        e.stopPropagation();
        let task = $(e.target).closest('.knbn-c-cont');
        changeTaskStatus(task.attr('id'), "completed", 'kanban-calendar');
    });
}

