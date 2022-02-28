"use strict";
// const user_image = user.avatar ?`${url}${user.avatar.url}`: user.gender === "male" ? "images/user-male-128.png": "images/female-user-128.png";
//
// let history_types =["Крайний срок", "Статус", "Пункт чек-листа выполнен", "Пункт чек-листа стал невыполненным", "Соисполнители", "Ответственный","Наблюдатели",
//     "Добавлен пункт в чек-лист", "Теги", "Создана задача", "Оценка", "Планируемая дата начала", "Планируемая дата окончания", "Открыл страницу"];
//

let user = {id: 2, avatar: null, gender: "male", image_src: "/task/images/user-male-512.png", first_name: "Hovsep", last_name: "Shirinyan"};
let ajax_tags = {
    task_tags: [],
    all_tags: [],
};
let ajax_checklist = [];
let ajax_checkponts = [];
let ajax_task_data = {};
const user_image = user.image_src;
let task_popup_data;
let tracker_interval;
$(document).ready(()=>{
    getKabanDataAndDrawKanban("task");
});
function getKabanDataAndDrawKanban(type) {
    $.ajax({
        type: 'POST',
        url: '/task/tasks/all-tasks',
        data : {type: type},
        dataType: "json",
        success: function (res){
            let data = [];
            res.forEach(item=>{
                let status = "";
                switch(item.status) {
                    case '1': status = "waiting";   break;
                    case '2': status = "doing";     break;
                    case '3': status = "completed"; break;
                    case '4': status = "delayed";   break;
                }
                let producer_id = [];
                let responsible_id = [];
                item.taskPerson.forEach(item => {
                    switch(item.status) {
                        case '1':
                            producer_id.push({
                                id:item.person_id,
                                first_name: item.person.first_name,
                                last_name: item.person.last_name,
                                gender: +item.person.gender? "female" : "male",
                                avatar:null,
                            });
                            break;
                        case '2':
                            responsible_id.push({
                                id:item.user_id,
                                first_name: item.first_name,
                                last_name: item.last_name,
                                gender: +item.gender? "female" : "male",
                                avatar:null,
                            });
                            break;
                    }
                    item.status_id
                });
                data.push({
                    id: item.id,
                    title: item.title,
                    status: status,
                    notification_alert: true,
                    deadline: item.dead_line,
                    priority: item.priority,
                    producer_id: producer_id,
                    responsible_id: responsible_id,
                    tag_id :item.tags,
                    checklists_info: item.checklist_count? `${item.checklist_checked?item.checklist_checked: 0}/${item.checklist_count}`: item.checklist_count,
                });
            });
            arrangeTaskByColumns(data, type);
        }
    });
}

// function notificationAlertToggle(task_id, bool) {
//     let data = { notification_alert: bool };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/task-data/${task_id}`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false
//     }).done(function (data) {
//         console.log('not alert done');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to change notification'); });
// }

// function kanbanTaskPinned(task_id, bool) {
//     let data = { pinned: bool };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/task-data/${task_id}`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false
//     }).done(function (data) {
//         console.log('not alert done');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to change pin in kanban'); });
// }

function selectColumnForTask(task_id, date, sort) {
    let data = { id: task_id, deadline: date !== "no_limit"? moment(date).format('YYYY-MM-DD HH:mm:ss'): null};
    $.ajax({
        method: 'POST',
        url: '/task/tasks/update-task',
        dataType: "json",
        data: data,
        success: function (res){
            // makeTaskHistory (`#${data.id}`, history_types[9], data.id);
            // getKabanDataAndDrawKanban("task");
            console.log(res);
        }
    });
}

function addNewTaskInKanban(priority, title, date) {
    let ajax_date = date? moment(date).format('YYYY-MM-DD HH:mm:ss') : date;
    let data = {
        from : 0,
        title: title,
        priority: priority,
        status: "waiting",
        rating: "unrated",
        deadline: ajax_date,
        producer_id: user.id,
        responsible_id: user.id,
    };
    $.ajax({
        method: 'POST',
        url: '/task/tasks/create',
        dataType: "json",
        data: data,
        success: function (res){
            getKabanDataAndDrawKanban("task");
        }
    });
}

function calculateDateChangedByDateTimePicker(task_id, date) {
    let data = {id: task_id, deadline: date? moment(date).format('YYYY-MM-DD HH:mm:ss'): null };
    console.log(data)
    let today = new Date();
    let difference = date - today;
    if (difference >= 0) {
        $.ajax({
            method: 'POST',
            url: '/task/tasks/update-task',
            dataType: "json",
            data: data,
            success: function (res){
                // makeTaskHistory (`#${data.id}`, history_types[9], data.id);
                getKabanDataAndDrawKanban("task");
            }
        });
    }
}

function openCurrentTaskInfo(task_id, popup) {
    $.ajax({
        method: 'POST',
        url: '/task/tasks/one-task',
        dataType: "json",
        data: {id : task_id},
        success: function (res){
            // console.log(res);
            let status = "";
            switch(res.status) {
                case '1': status = "waiting";   break;
                case '2': status = "doing";     break;
                case '3': status = "completed"; break;
                case '4': status = "delayed";   break;
            }
            let producer_id = [];
            let responsible_id = [];
            let co_executor_id =[];
            let observer_id = [];
            res.taskPerson.forEach(item => {
                let person  = item.person;
                switch(item.status) {
                    case '1':
                        producer_id.push({
                            id: person.user_id,
                            first_name: person.first_name,
                            last_name: person.last_name,
                            gender: +person.gender? "female" : "male",
                            avatar:null,
                            relation_id: item.id,
                        });
                        break;
                    case '2':
                        responsible_id.push({
                            id:person.user_id,
                            first_name: person.first_name,
                            last_name: person.last_name,
                            gender: +person.gender? "female" : "male",
                            avatar:null,
                            relation_id: item.id,
                        });
                        break;
                    case '3':
                        co_executor_id.push({
                            id:person.user_id,
                            first_name: person.first_name,
                            last_name: person.last_name,
                            gender: +person.gender? "female" : "male",
                            avatar:null,
                            relation_id: item.id,
                        });
                        break;
                    case '4':
                        observer_id.push({
                            id:person.user_id,
                            first_name: person.first_name,
                            last_name: person.last_name,
                            gender: +person.gender? "female" : "male",
                            avatar:null,
                            relation_id: item.id,
                        });
                        break;
                }
                item.status_id
            });

            let data = {
                id: res.id,
                created_add: res.created_add,
                title: res.title,
                description: res.description? res.description: '',
                status: status,
                notification_alert: false,
                priority: res.priority,
                producer_id: producer_id,
                rating:res.rating,
                responsible_id: responsible_id,
                co_executor_id: co_executor_id,
                observer_id: observer_id,
                taskTiming: res.taskTiming,
                task_tags : res.tasktags,
                tags: res.tags,
                checklist_id: res.taskCheckList,
                histories:[],
            };
            task_popup_data = data;

            if(popup === "new-popup"){
                $('#modalContent').html(addNewTaskPopup(task_popup_data));
            } else {
                $('.knbn-task-popup-z9').html(createTaskPopup(task_popup_data));
            }
        }
    });
}

// function getTaskDataForKanbanCalendar(refresh = true, popup) {
//     $.ajax(`${url}/task-data?_sort=pinned:DESC`, {
//         type: "GET",
//         dataType: "json",
//         headers: headersData,
//         contentType: 'application/json',
//         async: false,
//     }).done(function (data) {
//         let task_data = getCurrentUserTasks (data);
//         if(!refresh){
//             $(".knbn-right-popup-main-cont", popup).html(createKanbanCalendarTasks(task_data, false));
//         } else {
//             $(".knbn-right-tasks").html(createKanbanCalendarTasks(task_data, true));
//             addCalendarTasksListneres(true);
//         }
//     }).fail(function (jqxhr, settings, ex) { alert('get task data failed'); });
// }
//
// function toggleTaskFavorite(task_id, bool) {
//     let data = { favorite: bool };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/task-data/${task_id}`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false,
//     }).done(function (data) {
//         console.log('favorite status is changed');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to change favorite'); });
// }
//

function changeTaskRating(task_id, rating) {
    let data = { task_id:+task_id, rating: +rating };
    $.ajax({
        method: 'POST',
        url: '/task/tasks/update-rate',
        dataType: "json",
        data: data,
        success: function (res){
            // let old_rating =getRatingName(task_data.rating);
            // let new_rating =getRatingName(data.rating);
            // makeTaskHistory (`${old_rating} -> ${new_rating}`, history_types[10], task_id);
        }
    })
}

function changeTaskStatus(task_id, status, position) {
    let ajax_status = null;
    switch(status) {
        case "waiting":  ajax_status = 1; break;
        case "doing":    ajax_status = 2; break;
        case "completed":ajax_status = 3; break;
        case "delayed":  ajax_status = 4; break;
    }
    let data = {from: 1, id:task_id,  status: ajax_status };
    $.ajax({
        method: 'POST',
        url: '/task/tasks/update-task',
        dataType: "json",
        data: data,
        success: function (res){
            switch (position) {
                case "kanban":
                    getKabanDataAndDrawKanban("task");
                    break;
                case "popup":
                    openCurrentTaskInfo(task_id, "popup");
                    break;
                case "kanban-calendar":
                    getTaskDataForKanbanCalendar();
                    break;
                default:
                    alert("error");
            }
        }
    });
}

function getEmployees(target, employee_status, task_id, checklist, isNewTaskChecklist = false) {
    $.ajax({
        url:'/task/tasks/persons',
        method: "POST",
        dataType: "json",
        success: function (data) {
            target.empty().append(createEmployeePopup(data, employee_status, task_id, checklist)).show();
        }
    });
}

function changeEmployees(data, position) {
    $.ajax({
        url:'/task/tasks/update-task',
        method: "POST",
        dataType: "json",
        data: data,
        success: function (res) {
            if (position === "kanban") {
                getKabanDataAndDrawKanban('task');
            } else if (position === "task-popup") {
                openCurrentTaskInfo(data.task_id, "popup");
            }
        }
    });
}

function postChecklistEmployees(checkpoint_id, employee_id, status) {
    let data = {checkpoint_id:checkpoint_id, person_id:employee_id, person_status: status };
    $.ajax({
        url:'/task/tasks/person-to-checklist',
        method: "POST",
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(`employeer was changed to ${employee_id}`);
            //     if (position === "kanban") {
            //         getKabanDataAndDrawKanban('task');
            //     } else if (position === "task-popup") {
            //         openCurrentTaskInfo(task_id, "popup");
            //     }
        }
    });
}

// function postEmployees(data, task_id, position) {
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/task-data/${task_id}`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false,
//     }).done(function () {
//         console.log(`employee was added`);
//         if (position === "kanban") {
//             getKabanDataAndDrawKanban('task');
//         }
//         else if (position === "task-popup") {
//             openCurrentTaskInfo(task_id, "popup");
//         }
//     }).fail(function (jqxhr, settings, ex) { alert('failed to add employee'); });
// }

// function getCurrentEmployee(employee, checklist_id) {
//     $.ajax(`${url}/checklist-items/${checklist_id}`, {
//         type: "GET",
//         dataType: "json",
//         headers: headersData,
//         contentType: 'application/json',
//         async: false,
//     }).done(function (data) {
//         employee.executor_id = data.executor_id;
//         employee.observer_id = data.observer_id;
//     }).fail(function (jqxhr, settings, ex) { alert('failed'); });
// }
//

function deleteEmployeeData(data, task_id) {
    $.ajax({
        url: '/task/tasks/person-to-checklist',
        method: "POST",
        dataType: "json",
        data: data,
        success: function (data) {
            // console.log(`employee was added`);
            // if (position === "kanban") {
            //     getKabanDataAndDrawKanban('task');
            // }
            // else if (position === "task-popup") {
            //     openCurrentTaskInfo(task_id, "popup");
            // }
        }
    });
}

// function changeChecklistItemImportance(checklist_id, bool) {
//     let data = { important: bool };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/checklist-items/${checklist_id}`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false,
//     }).done(function (data) {
//         console.log('not alert done');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to change importance'); });
// }

// function changeChecklistItemCompletedStatus(checklist_id, bool) {
//     // console.log(checklist_id, bool);
//     let data = { completed: bool };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/checklist-items/${checklist_id}}`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false,
//     }).done(function (data) {
//         console.log('checlist status changed');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to change status'); });
// }

// function deleteChecklistItem(checklist_id) {
//     $.ajax({
//         url: `${url}/checklist-items/${checklist_id}}`,
//         headers: headersData,
//         type: 'DELETE',
//         async: false,
//     }).done(function (result) {
//         console.log("deleted");
//     }).fail(function (jqxhr, settings, ex) { alert("failed to delete"); console.log(request, msg, error); });
// }

// function deleteChecklist(checklist_id) {
//     $.ajax({
//         url: `${url}/checklists/${checklist_id}}`,
//         type: 'DELETE',
//         headers: headersData,
//         async: false,
//     }).done(function (result) {
//         console.log("deleted");
//     }).fail(function (jqxhr, settings, ex) { alert("failed to delete"); console.log(request, msg, error); });
// }

// function changeChecklistItemContext(checklist_id, context) {
//     let data = {
//         context: context,
//     };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/checklist-items/${checklist_id}`,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         headers: headersData,
//         async: false,
//     }).done(function (data) {
//         console.log('not alert done');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to change checklist context'); });
// }

function changeChecklistContainerTitle(checklist_container_id, title) {
    let data = { type: 1, id: checklist_container_id, title: title };
    $.ajax({
        method: "POST",
        url:'/task/tasks/create-checklist',//url: `${url}/checklist-items`,
        dataType: "json",
        data: data,
        success: function (res) {
            checkpoint.attr('id',res)
            console.log('new checklist item is added');
        }
    });
    // $.ajax({
    //     type: 'PUT',
    //     url: `${url}/checklists/${checklist_container_id}`,
    //     contentType: 'application/json',
    //     data: JSON.stringify(data),
    //     headers: headersData,
    //     async: false,
    // }).done(function (data) {
    //     console.log('not alert done');
    // }).fail(function (jqxhr, settings, ex) { alert('failed to change checklist title'); });
}

function addNewChecklistItem(task_id, checklist_container_id, sort, context,  important, status, checkpoint) {
    let checkpoint_id = +checkpoint.attr('id');
    let data = {
        id: checkpoint_id ? checkpoint_id : null,
        sort: sort,
        context: context,
        list_id: +checklist_container_id ,
        task_id: +task_id,
        important: important,
        status:status? 1 : 0,
    };
    console.log(data);
    $.ajax({
        method: "POST",
        url:'/task/tasks/add-checkpoint',//url: `${url}/checklist-items`,
        dataType: "json",
        data: data,
        success: function (res) {
            checkpoint.attr('id',res)
            console.log('new checklist item is added');
        }
    });
}

function addNewChecklistContainer(task_id, sort, title, edit = false) {
    let data = {
        type: 0,
        sort: sort,
        title: title,
        task_id:  task_id,
    };
    $.ajax({
        method: "POST",
        url:'/task/tasks/create-checklist',
        dataType: "json",
        data: data,
        success: function (checklist_id) {
            let checklist_data = [
                {
                    id: checklist_id,
                    sort: +sort,
                    title: title,
                    checkpoint:[],
                }
            ]
            if(edit){

            } else {
                let existing_checklist_container = $('.zone-eight-check-list');
                checklist_data.sort((a, b) => (a.sort - b.sort));
                checklist_data.forEach((item) => {
                    existing_checklist_container.append(createCheckListContainer(item));
                });
            }
            // console.log('new checklist item is added');
        }
    });
}

// function changeChecklistContainerSorting(checklist_cont_id, sort) {
//     let data = { sort: sort };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/checklists/${checklist_cont_id}}`,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         headers: headersData,
//         async: false,
//     }).done(function (data) {
//         console.log('checklist cont sort done');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to sort'); });
// }

// function changeChecklistContainerItemSorting(checklist_id, sort) {
//     let data = { sort: sort };
//     $.ajax({
//         type: 'PUT',
//         url: `${url}/checklist-items/${checklist_id}}`,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         headers: headersData,
//         async: false,
//     }).done(function (data) {
//         console.log('checklist sort done');
//     }).fail(function (jqxhr, settings, ex) { alert('failed to sort'); });
// }
//

function deleteTask(task_id, popup) {
    console.log(task_id)
    $.ajax({
        method: 'POST',
        url: '/task/tasks/delete', //`${url}/task-data`,
        dataType: 'json',
        data: {task_id : task_id},
        success : (res)=>{
            $('#modal').modal('hide');
            getKabanDataAndDrawKanban("task");
        }
    });
}

// function kanbanCalendarbyDate(date) {
//     let next_url;
//     if(date === "expired"){
//         let expired = moment().toISOString();
//         next_url=`deadline_lt=${expired}&_sort=pinned:DESC`;
//     } else if(date === "today"){
//         let today_now = moment().toISOString();
//         console.log(today_now);
//         let tommorow = moment().add(1,'days').startOf('day');
//         let today_end = tommorow.toISOString();
//         next_url=`deadline_gte=${today_now}&deadline_lt=${today_end}`;//&_sort=pinned:DESC
//     } else if(date === "no limit") {
//         next_url =`deadline_null=true`;
//     } else {
//         next_url =`deadline_sort=pinned:DESC`;
//     }
//     $.ajax(`${url}/task-data?${next_url}`, {
//         type: "GET",
//         dataType: "json",
//         headers: headersData,
//         contentType: 'application/json',
//         async: false,
//     }).done(function (data) {
//         $(".knbn-right-tasks").html(createKanbanCalendarTasks(data, true));
//         addCalendarTasksListneres(true);
//     }).fail(function (jqxhr, settings, ex) { alert('get task data failed'); });
// }

function addNewTaskFromPopup(tasks) {
    console.log(tasks);
    $.ajax({
        method: 'POST',
        url: '/task/tasks/create',
        dataType: 'json',
        data: tasks,
        success : (res)=>{
            $('#modal').modal('hide');
            getKabanDataAndDrawKanban("task");
        }
    });
}
function updateTaskFromPopup(tasks) {
    console.log(tasks);
    $.ajax({
        method: 'POST',
        url: '/task/tasks/update-task-from-popup',
        dataType: 'json',
        data: tasks,
        success : (res)=>{
            $('#modal').modal('hide');
            getKabanDataAndDrawKanban("task");
        }
    });
}

function timeTrackStatusChange (task_id, date, duration, status){
    ajax_task_data.taskTiming.time_tracking_start = date;
    ajax_task_data.taskTiming.time_track_actual_duration = duration;
    let data = {
        status:status,
        task_id:task_id,
        time_tracking_start:date,
        time_track_actual_duration: duration,
    }

    $.ajax({
        method: 'POST',
        url: '/task/tasks/task-tracking',
        dataType: 'json',
        data: data,
        success : (res)=> {
            console.log('res');
        }
    });
    // $.ajax({
    //     type: 'PUT',
    //     url: `${url}/task-data/${task_id}`,
    //     contentType: 'application/json',
    //     data: JSON.stringify(data),
    //     headers: headersData,
    //     async: false,
    // }).done(function (data) {
    //     console.log("changes to time tracker done");
    //     // changeTaskStatus(task_id, date? "doing" : "waiting", "popup")
    // }).fail(function (jqxhr, settings, ex) { alert('failed to track'); });
}

function creatTagsForTask(tag_name, task_id, popup) {
    let data = {
        task_id:task_id,
        title:tag_name,
    };
    $.ajax({
        method: 'POST',
        url: '/task/tasks/create-tag',
        dataType: 'json',
        data: data,
        success : (res)=> {
            ajax_tags.task_tags.push({id:res, name: tag_name});
            drawTagsPopup(popup, ajax_tags )
        }
    });
}

function updateTaskTag(from, tag_id, task_id, ajax_tags, popup) {
    let data = {from:from, tag_id:tag_id, task_id:task_id};
    $.ajax({
        method: 'POST',
        url: '/task/tasks/create-tag-rel',
        dataType: 'json',
        data: data,
        success : (res)=> {
            drawTagsPopup(popup, ajax_tags);
        }
    });
}

// function getTasksTags (refresh= false, popup){
//     $.ajax(`${url}/task-tags `, {
//         type: "GET",
//         dataType: "json",
//         headers: headersData,
//         contentType: 'application/json',
//         async: false,
//     }).done(function(data) {
//         task_tags = data;
//         if(refresh){
//             drawTagsPopup(popup, true);
//         }
//     });
// }

// function makeTaskHistory (context = null, type= null, task_id= null){
//     let data = {
//         author: {id:user.id},
//         action: type,
//         new_state: context,
//         task_data: task_id,
//     }
//     $.ajax({
//         type: 'POST',
//         url: `${url}/histories`,
//         headers: headersData,
//         contentType: 'application/json',
//         data: JSON.stringify(data),
//         async: false,
//     }).done(function (data) {
//     }).fail(function (jqxhr, settings, ex) { alert('failed to add history'); });
// }

// function getTaskHistory(task_id) {
//     $.ajax(`${url}/histories?task_data=${task_id},_limit=10`, {
//         type: "GET",
//         dataType: "json",
//         headers: headersData,
//         contentType: 'application/json',
//         async: false,
//     }).done(function(data) {
//         history=  data;
//     });
//     return history;
// }

// function getStatusName(type) {
//     switch(type) {
//         case "waiting":
//             return "Ждет выполнения"
//         case "doing":
//             return "Выполняется"
//         case "delayed":
//             return "Отложена";
//         case "completed":
//             return "Завершена"
//         default:
//             return "";
//     }
// }

// function getRatingName(type) {
//     switch(type) {
//         case "unrated":
//             return "Нет оценки"
//         case "positive":
//             return "Положительная"
//         case "negative":
//             return "Отрицательная";
//         default:
//             return "";
//     }
// }

// function getChecklistsByTaskID(task_id, edit = false){
//     $.ajax(`${url}/checklists?checklist_task=${task_id}`, {
//         type: "GET",
//         dataType: "json",
//         headers: headersData,
//         contentType: 'application/json',
//         async: false,
//     }).done(function(data) {
//         if(edit){
//
//         } else {
//             let existing_checklist_container = $('.zone-eight-check-list');
//             existing_checklist_container.empty();
//             data.sort((a, b) => (a.sort - b.sort));
//             data.forEach((item) => {
//                 existing_checklist_container.append(createCheckListContainer(item));
//             });
//         }
//         console.log("refreshed");
//     });
// }
