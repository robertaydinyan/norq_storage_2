"use strict";
function createTaskPopupContainer(options) {
    let task_items_list = options.task_data.checklist_id;
    let time_manage_track = false;
    let time_track_actual_duration;
    let time_track_planned_duration;
    if(+options.task_timing.time_track_planned_duration){
        time_manage_track = true;
        time_track_planned_duration = generateTimesForTracker(+options.task_timing.time_track_planned_duration).time_text;
        if (!+options.task_timing.time_track_actual_duration){
            time_track_actual_duration = "00:00:00";
        } else {
            if(options.task_timing.time_track_start){
                let now = new Date();
                let dur = new Date(options.task_timing.time_track_start);
                let duration = Math.floor((now - dur )/1000);
                time_track_actual_duration = generateTimesForTracker(duration + +options.task_timing.time_track_actual_duration);
            } else {
                time_track_actual_duration = generateTimesForTracker(+options.task_timing.time_track_actual_duration).time_text;
            }

        }
    }
    let popup_container = kanbanTemplatesGenerationRightTaskPopupContainer({
        item_get: "get-knbn-tt-cont",
        task_id: options.task_data.id,
        task_status: options.status,
        priority: options.task_data.priority,
        favorite: options.task_data.favorite,
        start_task: options.start_task,
        stop_task: options.stop_task,
        completed: options.completed,
        tracker: time_manage_track,
        delayed: options.delayed,
        comment: options.task_data.description,
        time_track_actual_duration:time_track_actual_duration,
        time_track_planned_duration: time_track_planned_duration,
        started: options.task_timing.time_track_start,
    });
    let existing_checklist_container = $('.zone-eight-check-list', popup_container);
    if(task_items_list && task_items_list.length){
        task_items_list.sort((a, b) => (a.sort - b.sort));
        task_items_list.forEach((item) => {
            existing_checklist_container.append(createCheckListContainer(item));
        });
    }
    // if(substasks.length){
    //     let table_cont = $(".knbn-ttc-middle", popup_container);
    //     table_cont.append($(`<span>Подзадачи</span>`));
    //     table_cont.append(kanbanTemplatesGenerationRightTaskPopupContainer({
    //         item_get: "get-subtasks-table",
    //     }));
    //     substasks.forEach(item=>{
    //         let row = $("<tr></tr>");
    //         row.append($(`<td>${item.id}</td>`));
    //         row.append($(`<td>${item.title}</td>`));
    //         row.append($(`<td>${item.priority}</td>`));
    //         let status = "";
    //         if (item.status === "waiting") {
    //             status += "Ждет выполнения";
    //         }
    //         else if (item.status === "doing") {
    //             status += "Выполняется";
    //         }
    //         else if (item.status === "delayed") {
    //             status += "Отложена";
    //         }
    //         else {
    //             status += "Завершена";
    //         }
    //         row.append($(`<td>${status}</td>`));
    //         row.append($(`<td>${kanbanDateByString(item.deadline)}</td>`));
    //         $("tbody",table_cont ).append(row);
    //     });
    // }
    existing_checklist_container.sortable({
        handle: ".z-ea-hid-btn",
        placeholder: 'z-ea-head-placeholder',
        axis: 'y',
        beforeStop: function (e, ui) {
            let chechlist_conts = $(".z-e-chechlist-box", e.target);
            if (chechlist_conts.length > 1) {
                $.each(chechlist_conts, function (key, val) {
                    let sort = key + 1;
                    $(val).attr("data-checklist-cont-sort", sort);
                    changeChecklistContainerSorting($(val).attr("data-checklist-id"), sort);
                });
            }
        }
    }).disableSelection();
    if(options.task_timing.time_track_start){
        let now = new Date();
        let dur = new Date(options.task_timing.time_track_start);
        let duration = Math.floor((now - dur )/1000);
        let tracker = $(".task-tracker-actual-time", popup_container );
        let time = generateTimesForTracker(duration + +options.task_timing.time_track_actual_duration);
        tracker_interval = setInterval( ()=>timeTracker(time, tracker), 1000);
    }
    setTimeout(() => addTaskPopupContainerListeners(), 10);
    return popup_container;

}

function kanbanTemplatesGenerationRightTaskPopupContainer(options = {}) {
    switch (options.item_get) {
        case 'get-knbn-tt-cont':
            return $(`
               <div class = "knbn-tt-cont">
                    <div class = "knbn-ttc-left">
                        <div class = "knbn-ttc-top">
                            <div>
                                <div class = "knbn-ttct-taskname"><span>Задача № ${options.task_id}</span><span> - ${options.task_status}</span></div>
                                <div class = "knbn-ttct-taskpriority task-priority-color-${options.priority}" style="border:none">
                                    <span>Приоритет</span>
                                    <span>${options.priority}</span>
                                </div>
                            </div>
                            <div>
                                <span class="knbn-ttct-comment">${options.comment}</span>
                                <span class = "knbn-ttct-star ${options.favorite ? 'fire-orange favorite' : ''}"><i class="fas fa-star"></i></span>
                            </div>
                            <div>
                                <div class = "knbn-tt-checklist-body">
                                    <ul class = "zone-eight-check-list"></ul>
                                </div>
                                <div class = "knbn-tt-add"><button class = 'c-btn-dashed-show c-btn-dashed-show-secondary z-eight-add-checklist'>+ добавить чеклист</button></div>
                            </div>
                            <div>
<!--                                <div class = "knbn-tt-taskinproj">-->
<!--                                    <span>Задача в проекте (группе): </span>-->
<!--                                    <span class = "knbn-tt-add-project">Добавить</span>-->
<!--                                </div>-->
                            </div>
                            <div>
                                <div class="knbn-tt-toggle-buttonts-box">
                                    <div class="knbn-tt-toggle-btn-item " style="display: ${options.tracker  ? 'inline-flex' : 'none'}; ">
                                        <div class="knbn-tt-start-my-time-box">
                                            <span><i class="far fa-clock"></i></span>
                                            <span class="knbn-tt-start-my-time-point"><span class = "task-tracker-actual-time">${options.time_track_actual_duration}</span>/${options.time_track_planned_duration}</span>
                                        </div>
                                        <button class = "knbn-tt-start-my-time c-btn" style="display: ${options.started ? 'none' :'inline-block'}">Начать учет моего времени</button>
                                    </div>
                                    <div class="knbn-tt-toggle-btn-item" >
                                        <button class = "knbn-tt-pause c-btn" style="display: ${options.started ? 'inline-block' : 'none'}">На паузу</button>
                                    </div>
                                    <div class="knbn-tt-toggle-btn-item" style="display: ${options.tracker  ? 'none' : 'inline-block'}">
                                        <button class = "knbn-tt-start c-btn" style="display: ${options.start_task ? 'inline-block' : 'none'}">Начать выполнение</button>
                                    </div>
                                    <div class="knbn-tt-toggle-btn-item" style="display: ${options.tracker  ? 'none' : 'inline-block'}">
                                        <button class = "knbn-tt-stop c-btn" style="display: ${options.stop_task && !options.delayed ? 'inline-block' : 'none'}">Приостановить</button>
                                    </div>
                                    <div class="knbn-tt-toggle-btn-item">
                                        <button class = "knbn-tt-end c-btn" style="display: ${options.completed ? 'none' : 'inline-block'}">Завершить</button>
                                    </div>
                                    <div class = "knbn-ttc-top-else-btn knbn-tt-toggle-btn-item">
                                       <button class = "knbn-tt-more c-btn c-btn-secondary c-btn-ol">Еще <i class="fas fa-chevron-down"></i></button>
                                       <div class = "tch-ied-popup">
                                           <div class = "knbn-ttc-top-more">
<!--                                               <div class = "knbn-ttc-top-task-copy"><span><i class="far fa-copy"></i></span><span>Копировать</span></div>-->
<!--                                               <div><span><i class="fas fa-plus"></i></span><span>Добавить подзадачу</span></div>-->
<!--                                               <div><span><i class="far fa-clock"></i></span><span>Добвавить в план рабочего дня</span></div>-->
                                               <div class = "knbn-ttc-top-task-delay ${options.completed || options.delayed ? "knbn-ttc-hide" : ""}"><span><i class="far fa-pause-circle"></i></span><span>Отложить</span></div>
                                               <div class = "knbn-ttc-top-task-restore ${options.completed || options.delayed ? "" : "knbn-ttc-hide"}"><span><i class="fas fa-redo"></i></span><span>Возабновить</span></div>
                                               <div class = "knbn-ttc-top-task-delete"><span><i class="fas fa-times"></i></span><span>Удалить</span></div>
<!--                                               <div><span></span>Приложения<span></span></div>-->
                                           </div>
                                       </div>
                                    </div>
                                    <div class="knbn-tt-toggle-btn-item">
                                        <span class="knbn-tt-edit-task c-btn c-btn-link knbn-tt-edit">Редактировать</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                        <div class = "knbn-ttc-middle"></div>
                        <div class = "knbn-ttc-bottom">
                        </div>
                    </div>
                </div>`);
            break;
        case "get-subtasks-table":
            return $(`
                <div class = "knbn-ttc-middle-table">
                    <table>
                        <thead>
                            <tr><th>ID</th><th>Название</th><th>Приоритет</th><th>Статус</th><th>Крайний срок</th></tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>`)
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}

function addTaskPopupContainerListeners() {
    $(".knbn-tt-start-my-time").on("click", function (e){
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        $(this).closest(".knbn-tt-toggle-buttonts-box").find(".knbn-tt-pause").show();
        $(this).hide();
        let tracker = $(".task-tracker-actual-time");
        let time = generateTimesForTracker(+ajax_task_data.taskTiming.time_track_actual_duration);
        tracker_interval = setInterval( ()=>timeTracker(time, tracker), 1000);
        timeTrackStatusChange(task_id, moment().format('YYYY-MM-DD HH:mm:ss'), +ajax_task_data.taskTiming.time_track_actual_duration, 2);
    });
    $(".knbn-tt-pause").on("click", function (e){
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        $(this).closest(".knbn-tt-toggle-buttonts-box").find(".knbn-tt-start-my-time").show();
        $(this).hide();
        let now = new Date();
        let dur = new Date(ajax_task_data.taskTiming.time_track_start);
        let duration = Math.floor((now - dur )/1000);
        clearInterval(tracker_interval);
        timeTrackStatusChange(task_id, null, duration, 1);
    });

    $(`.knbn-ttct-star`).on("click", function (e) {
        e.stopPropagation();
        let target = $(e.target);
        let task_id = target.closest('.knbn-task-popup-z9').attr('id');
        if (target.hasClass('favorite')) {
            toggleTaskFavorite(task_id, false);
        }
        else {
            toggleTaskFavorite(task_id, true);
        }
        target.toggleClass('fire-orange');
        target.toggleClass('favorite');
    });
    $(".knbn-tt-edit-task").on("click", function (e) {
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        // let popup = $('.popup2')
        openCurrentTaskInfo(task_id, "new-popup");
    });
    $('.knbn-tt-more').on('click', function (e) {
        $(this).closest('div').find('.tch-ied-popup').toggle();
    });
    $('.knbn-tt-add-project').on('click', function (e) {
        alert("open popup");
    });
    $(".z-eight-add-checklist").on("click", function (e) {
        e.stopPropagation();
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        let sort = $(".z-e-chechlist-box").length + 1;
        addNewChecklistContainer(task_id, sort, `Чек-лист ${sort}`);
    });
    $(".knbn-ttc-top-task-copy").on("click", function (e) {
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        openCurrentTaskInfo(task_id, "new-popup");
    });
    $(".knbn-ttc-top-task-delay").on("click", function (e) {
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        changeTaskStatus(task_id, "delayed", "popup");
    });
    $(".knbn-ttc-top-task-restore").on("click", function (e) {
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        changeTaskStatus(task_id, "waiting", "popup");
    });
    $(".knbn-ttc-top-task-delete").on("click", function (e) {
        e.stopPropagation();
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        // let popup = $(this).closest('.zone9');
        // let delete_confirm =  confirmDeletion ("задачу");
        deleteTask(task_id, $(this).closest("#modal"));


        // delete_confirm.delete_btn.on("click", function (e) {
        //     delete_confirm.confirm_deletion_popup_cont.hide();
        //     deleteTask(task_id, $(this).closest(".zone9"));
        //     // zoneNineHideShow(popup, "hide");
        //     getKabanDataAndDrawKanban("task");
        // });
    });
}
