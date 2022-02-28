"use strict";
function createEmployeePopup(data, employee_status, task_id, checklist = false, isNewTaskChecklist = false) {
    let container = templatesGenerationEmployeePopup({ item_get: "get-employee-popup" });
    let employer_container = $(`.tch-ied-container-employees-cont`, container);
    data.forEach((item) => {
        let avatar = item.avatar? `${url}${item.avatar.url}` : +item.gender?  "/task/images/female-user-128.png" : "/task/images/user-male-128.png" ;
        employer_container.append(templatesGenerationEmployeePopup({
            item_get: "get-tch-ied-container-employee",
            id: item.id,
            image: avatar ,
            name: `${item.first_name} ${item.last_name}`,
            position: item.position,
        }));
    });
    setTimeout(() => addEmployeePopupListeners(employer_container, checklist, employee_status, task_id), 0);
    return container;
}
function templatesGenerationEmployeePopup(options = {}) {
    switch (options.item_get) {
        case "get-employee-popup":
            return $(`
                <div class = "tch-ied-employees-popup">
                    <div class = "tch-ied-input"><input type="text" value = ""/></div>
                    <div class = "tch-ied-container">
                        <div class = "tch-ied-container-left">
                            <div class = 'tch-ied-container-department'><span>Люди:</span></div>
                            <div class = 'tch-ied-container-employees-cont'></div>
                        </div>
                        <div class = "tch-ied-container-right">
                            <span>Последние</span>
                            <span>Сотрудники и отделы</span>
                            <span>Почтовые ползователи</span>
                            <span>Поиск</span>
                        </div>
                    </div>
                </div>`);
            break;
        case 'get-tch-ied-container-employee':
            return $(`
                <div id = "${options.id}" class = 'tch-ied-container-employee'>
                    <img src = "${options.image}" alt ="${options.name}"/>
                    <div><span>${options.name}</span></div>
                </div>`);
            break;
        default:
            return $(`<div style="font-size: 25px; color: red">Some Error Occured</div>`);
    }
    return $(`<div style="font-size: 25px; color: red">Some Error Occured</div>`);
}

function addEmployeePopupListeners(employer_container, checklist, employee_status, task_id, isNewTaskChecklist) {
    if(isNewTaskChecklist){
        $(".tch-ied-container-employee", employer_container).on('click', function () {
            alert(isNewTaskChecklist);
        });
    }
    else {
        $(".tch-ied-container-employee", employer_container).on('click', function () {
            let employee_id = +$(this).attr('id');
            let position;
            if ($(this).closest(".knbn-main").length) {
                position = "kanban";
            } else {
                position = "task-popup";
            }
            if ($(this).closest(".knbn-new-task-popup").length) {
                let employee_container = $(this).closest(".knt-add-employee").find(".knt-add-employee-name-cont");
                let emp_status = employee_container.attr("data-emp-status");
                let new_employee = kanbanTemplatesGenerationRightNewTaskPopup({
                    item_get: "get-add-new-employee-type",
                    employee: $(this).text(),
                    employee_id: +$(this).attr("id") });
                switch (emp_status) {
                    case "producer":
                        if (employee_id !== ajax_task_data.producer_id) {
                            ajax_task_data.producer_id = +employee_id;
                            new_employee.find(".knt-delete-employee").remove();
                            employee_container.empty().append(new_employee);
                        }
                        break;
                    case "responsible":
                        if(typeof ajax_task_data.responsible_id === "number"){
                            ajax_task_data.responsible_id = +employee_id;
                            employee_container.empty().append(new_employee);
                        } else if (!(ajax_task_data.responsible_id.filter((item) => item === +employee_id)).length) {
                            ajax_task_data.responsible_id.push(+employee_id );
                            employee_container.append(new_employee);
                        }
                        break;
                    case "co-executor":
                        if(!ajax_task_data.co_executor_id){
                            ajax_task_data.co_executor_id= [];
                        }
                        if (!(ajax_task_data.co_executor_id.filter((item) => item === +employee_id)).length) {
                            ajax_task_data.co_executor_id.push(employee_id);
                            employee_container.append(new_employee);
                        }
                        break;
                    case "observer":
                        if(!ajax_task_data.observer_id){
                            ajax_task_data.observer_id= [];
                        }
                        if (!(ajax_task_data.observer_id.filter((item) => item === +employee_id)).length) {
                            ajax_task_data.observer_id.push(employee_id);
                            employee_container.append(new_employee);
                        }
                        break;
                    default:
                        console.log("didn`t get employee");
                }
                $(".knt-delete-employee", new_employee).on("click", function (e) {
                    alert(1);
                });
            }
            else {
                if (checklist) {
                    let checklist = $(this).closest("li");
                    let checklist_id = checklist.attr("id");
                    let employee_id = $(this).attr("id");
                    let isCompleted = checklist.find(".z-ea-ch-check-btn").find("input").prop("checked");
                    let name = $(this).find("span").text();
                    checklist.find(".tt-checklist-observer-cont").append(templatesGenerationCheckListItemContainer({
                        item_get: "get-tt-checklist-list-employees",
                        id: employee_id,
                        name: name,
                        completed: isCompleted,
                    }));
                    postChecklistEmployees(checklist_id, employee_id, employee_status === "observer"? 4 : 3);
                } else {
                    switch (employee_status) {
                        case "producer":
                            changeEmployees({from: 2, status:1, person_id: employee_id, task_id: +task_id}, position);
                            break;
                        case "responsible":
                            changeEmployees({from: 2, status:2, person_id: employee_id, task_id: +task_id}, position);
                            break;
                        case "co_executor":
                            changeEmployees({from: 3, status:3, person_id: employee_id, task_id: +task_id}, position);
                            break;
                        case "observer":
                            changeEmployees({from: 3, status:4, person_id: employee_id, task_id: +task_id}, position);
                            break;
                        default:
                            console.log("employee status is not defined");
                    }
                }
            }
        });
    }

    $("body").on("click", function (e) {
        e.stopPropagation();
        let target = $(e.target);
        if (!target.closest(".tch-ied-employees-popup").length) {
            $(".tch-ied-employees-popup").parent().hide().empty();
        }
    });
}
