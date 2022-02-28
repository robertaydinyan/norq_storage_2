"use strict";
function createTaskPopup(task_data) {
   ajax_task_data = task_data;
    let employees = [
        { employee_status_name: "Постановщик", employee_status: "producer", employee: task_data.producer_id },
        { employee_status_name: "Ответственный", employee_status: "responsible", employee: task_data.responsible_id },
        { employee_status_name: "Соисполнители", employee_status: "co_executor", employee: task_data.co_executor_id },
        { employee_status_name: "Наблюдатели", employee_status: "observer", employee: task_data.observer_id }
    ];
    let status = "";
    let expired = false;
    let start_task;
    let stop_task;
    let completed = false;
    let delayed = false;
    if (task_data.status === "waiting") {
        start_task = true;
        stop_task = false;
        status += "Ждет выполнения";
    } else if (task_data.status === "doing") {
        start_task = false;
        stop_task = true;
        status += "Выполняется";
    } else if (task_data.status === "delayed") {
        start_task = false;
        stop_task = true;
        status += "Отложена";
        delayed = true;
    } else {
        status += "Завершена";
        stop_task = false;
        start_task = false;
        completed = true;
    }
    let deadline = task_data.taskTiming.dead_line;
    let create_date = task_data.created_add;// kanbanDateByString(task_data.created_at);
    let status_change_date = task_data.updated_at? task_data.updated_at: task_data.created_add;  //kanbanDateByString(task_data.updated_at);
    let deadline_date = deadline ? deadline :"Нет";//kanbanDateByString(deadline)
    if (deadline && (new Date(deadline) - new Date()) < 0 && !completed) {
        expired = true;
    }
    let knbn_task_popup = kanbanTemplatesGenerationRightTaskPopup({ item_get: "get-task-popup", task_id: task_data.id });
    $('.knbn-task-temp', knbn_task_popup).append(createTaskPopupHeader(task_data.title));
    $('.knbn-task-temp', knbn_task_popup).append(createTaskPopupContainer(
        {
            task_data:task_data,
            start_task: start_task,
            stop_task: stop_task,
            completed: completed,
            delayed: delayed,
            task_timing:task_data.taskTiming,
            status: status},
        task_data, start_task, stop_task, completed, delayed, status
    ));
    $('.knbn-tt-cont', knbn_task_popup).append(createTaskPopupSideBar({
        task_data: task_data,
        employees: employees,
        create_date:create_date,
        deadline_date:deadline_date,
        status_change_date: status_change_date,
        deadline:deadline,
        expired:expired,
        status: status,
        task_timing:task_data.taskTiming,
        task_tags:task_data.task_tags,
        tags: task_data.tags,
    }, task_data, create_date, deadline_date, status_change_date, deadline, expired, status));
    $('.knbn-ttc-left', knbn_task_popup).append(createZoneEightTaskBottomTab(task_data.id));
    setTimeout(() => addTaskRightPopupListeners(), 0);
    return knbn_task_popup;
}
function kanbanTemplatesGenerationRightTaskPopup(options = {}) {
    switch (options.item_get) {
        case 'get-task-popup':
            return $(`
                <div id = "${options.task_id}" class = "knbn-task-popup knbn-task-popup-z9">
                    <div>
                        <div class = "knbn-task-temp" >
                        </div>
                    </div>
<!--                    <div class = "knbn-task-popup-close-div" >-->
<!--                        <div class = 'zone-eight-close'><i class="fas fa-times"></i></div>-->
<!--                    </div>-->
                </div>`);
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}
function addTaskRightPopupListeners() {
    $('.zone-eight-close').on('click', function (e) {
        e.stopPropagation();
        let target = $(this).closest('.knbn-task-popup-z9');
        target.animate({
            width: '0',
        }, "slow").promise().done(function () {
            getKabanDataAndDrawKanban("task");
            target.hide();
        });
    });
    $(".knbn-tt-start").on("click", function (e) {
        e.stopPropagation();
        let target = $(e.target);
        let task_id = target.closest('.knbn-task-popup-z9').attr('id');
        changeTaskStatus(task_id, 'doing', 'popup');
        target.toggle();
        target.closest('.knbn-tt-toggle-buttonts-box').find('.knbn-tt-stop').toggle();
    });
    $(".knbn-tt-stop").on("click", function (e) {
        e.stopPropagation();
        let target = $(e.target);
        let task_id = target.closest('.knbn-task-popup-z9').attr('id');
        changeTaskStatus(task_id, 'waiting', 'popup');
        target.toggle();
        target.closest('.knbn-tt-toggle-buttonts-box').find('.knbn-tt-start').toggle();
    });
    $(".knbn-tt-end").on("click", function (e) {
        e.stopPropagation();
        let target = $(e.target);
        let task_id = target.closest('.knbn-task-popup-z9').attr('id');
        changeTaskStatus(task_id, 'completed', 'popup');
        target.hide();
        target.closest('.knbn-tt-toggle-buttonts-box').find('.knbn-tt-start').hide();
        target.closest('.knbn-tt-toggle-buttonts-box').find('.knbn-tt-stop').hide();
    });
    // $(".knbn-tt-edit-task").on("click", function (e) {
    //     e.stopPropagation();
    //     let task_id = $(e.target).closest('.knbn-task-popup-z9').attr('id');
    //
    // });
    $('#knbn-tt-tabs').tabs();
    addTaskRightPopupHeaderListeners();
    addZoneEightTaskBottomTabListeners();
}
