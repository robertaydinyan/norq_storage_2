"use strict";
function createTaskPopupSideBar(options) {
    let task_rating = '';
    let task_rating_color = "#80868e";
    if (options.task_data.rating === "2") {
        task_rating += "Отрицательная";
        task_rating_color = "#F33434";
    }
    else if (options.task_data.rating === "1") {
        task_rating += "Положительная";
        task_rating_color = "#00dd1c";
    }
    else {
        task_rating += "Нет оценки";
    }
    let popup_sidebar = kanbanTemplatesGenerationRightTaskPopupSidebar({
        item_get: "get-knbn-ttc-right",
        status: options.status,
        status_changed: options.status_change_date,
    });

    $(".knbn-ttcr-middle", popup_sidebar).append(kanbanTemplatesGenerationRightTaskPopupSidebar({
        item_get: "get-knbn-ttcr-middle",
        deadline_date: options.deadline_date,
        expired: options.expired,
        deadline: options.deadline,
        created_date: options.create_date,
        planning_start: options.task_timing.planning_start,
        planning_end: options.task_timing.planning_end,
        rating: task_rating,
        task_rating_color: task_rating_color,
    }));
    options.employees.forEach((item) => {
        let status = item.employee_status;
        let employee_cont = kanbanTemplatesGenerationRightTaskPopupSidebar({
            item_get: "get-knbn-ttcr-cont-bottom",
            employee_status: status,
            employee_status_name: item.employee_status_name,
            text: (item.employee_status === "producer" || item.employee_status === "responsible")? "сменить":"+добавить"
        });
        if (length) {
            item.employee.forEach((employee) => {
                // let emp_position = positions.find(pos => pos.id ===employee.position);
                let emp = kanbanTemplatesGenerationRightTaskPopupSidebar({
                    item_get: "get-knbn-ttcr-cont-bottom-items",
                    employee_name: `${employee.first_name} ${employee.last_name}`,
                    employee_src: employee.avatar? `${url}${employee.avatar.url}` : +employee.gender?  "/task/images/female-user-128.png" : "/task/images/user-male-128.png" ,
                    // employee_position: emp_position.name,
                    employee_status: status,
                    expired: options.expired,
                });
                if(status === "observer" || status === "co_executor"){
                    $(".knbn-ttcr-cont-emloyee", emp).append(kanbanTemplatesGenerationRightTaskPopupSidebar({
                        item_get: "get-employee-remove-btn",
                        employee_status: status,
                        id: employee.relation_id,
                    }));
                }
                employee_cont.append(emp);
            });
        }
        $('.knbn-ttcr-bottom', popup_sidebar).append(employee_cont);
    });
    $('.knbn-ttcr-bottom', popup_sidebar).append(kanbanTemplatesGenerationRightTaskPopupSidebar({ item_get: 'get-knbn-ttcr-cont-bottom-add-item' }));
    $('.knbn-ttcr-bottom', popup_sidebar).append(kanbanTemplatesGenerationRightTaskPopupSidebar({ item_get: 'get-task-all-tags' }));
    let task_id =  +options.task_data.id;
    let task_tags = options.task_tags;
    let all_tags = options.tags;
    ajax_tags = {
        task_tags: [],
        all_tags: options.tags,
    };
    for(let i= 0; i < all_tags.length; i++){
        let tag_id = all_tags[i].id;
        let x = task_tags.filter(item=> item.tag_id === tag_id && item.task_id === task_id)[0];
        if (x){
            ajax_tags.task_tags.push(ajax_tags.all_tags.filter(item=> item.id === tag_id)[0]);
            ajax_tags.all_tags = ajax_tags.all_tags.filter(item=> item.id !== tag_id);
        }
    }
    drawTagsPopup($(".task-add-tag-toggle-cont",popup_sidebar), ajax_tags);
    $('.knbn-ttcr-middle-deadline-calendar', popup_sidebar).datetimepicker({
        inline: true,
        minDate: '0',
        minTime: new Date(),
        disabledWeekDays: [0, 6],
        dayOfWeekStart: 1,
        scrollMonth:false,
    });
    setTimeout(() => addTaskPopupSideBarListeners(popup_sidebar), 0);
    return popup_sidebar;
}

function drawTagsPopup(popup, tags){
    popup.html(kanbanTemplatesGenerationRightTaskPopupSidebar({item_get:"get-tags-part"}));
    let other_tags = popup.find(".task-cont-tag-other");
    let related_tags = popup.find(".task-cont-tag-related");
    tags.task_tags.forEach(item =>{
        related_tags.append(kanbanTemplatesGenerationRightTaskPopupSidebar({
            item_get: "get-tag-checkbox-cont",
            title: item.name,
            id: item.id
        }));
        $("input", related_tags).prop('checked', true);
    });
    tags.all_tags.forEach(item =>{
        other_tags.append(kanbanTemplatesGenerationRightTaskPopupSidebar({
            item_get: "get-tag-checkbox-cont",
            title: item.name,
            id: item.id
        }));
    });
    setTimeout(() =>
        $(".task-tag-checkbox", popup).on("change", function (e) {
            let target = $(this);
            let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
            let tag_id = target.attr("data-tag-id");
            if(!target.is(":checked")){
                ajax_tags.all_tags.push( ajax_tags.task_tags.filter(item => item.id === +tag_id)[0]);
                ajax_tags.task_tags = ajax_tags.task_tags.filter(item => item.id!== +tag_id);
                updateTaskTag(0, tag_id, task_id, ajax_tags, popup);
            } else {
                ajax_tags.task_tags.push(ajax_tags.all_tags.filter(item => item.id === +tag_id)[0]);
                ajax_tags.all_tags = ajax_tags.all_tags.filter(item => item.id!== +tag_id);
                updateTaskTag(1, tag_id, task_id, ajax_tags, popup);
            }
        }), 0);
}

function kanbanTemplatesGenerationRightTaskPopupSidebar(options = {}) {
    switch (options.item_get) {
        case 'get-knbn-ttc-right':
            return $(`
                <div class = "knbn-ttc-right">
                    <div class = "knbn-ttcr-top">
                        <span>${options.status}</span>
                        <span>с ${options.status_changed}</span>
                    </div>
                    <div class = "knbn-ttcr-middle"></div>
                    <div class = "knbn-ttcr-bottom"></div> 
                </div>`);
            break;
        case 'get-knbn-ttcr-middle':
            return $(`
                <div class = "knbn-ttcr-cont-top">
                    <div>
                        <span>Крайний срок:</span>
                        <div>
                            <span class = "knbn-ttcr-cont-top-open-deadline-calendar dashed-span-link-btn">${options.deadline_date}</span>
                            <div class = "knbn-ttcr-middle-calendar">
                                <input class="knbn-ttcr-middle-deadline-calendar" type="text" value="${options.deadline}" >
                                <div class="knbn-ttcr-middle-calendar-buttons">
                                    <button class = 'knbn-ttcr-middle-calendar-pic-time c-btn c-btn-sm'>Выбрать</button>
                                    <button class="knbn-ttcr-middle-calendar-close c-btn c-btn-secondary c-btn-ol c-btn-sm">Закрыть</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "knbn-ttcr-cont-top-expired" style="display: ${options.expired ? "block" : "none"}"><span>Задача просрочена</span><span class="knbn-task-firespan"><i class="fab fa-gripfire"></i></span></div>
<!--                    <div><span>Напоминание:</span><span class = "dashed-span-link-btn">Напомнить</span></div>-->
<!--                    <div><span>Автоматизация:</span><span class = "dashed-span-link-btn">Роботы</span></div>-->
                    <div><span>Поставлена:</span><span >${options.created_date}</span></div>
                    <div style="display: ${options.planning_start ? "grid" : "none"}"><span>Старт:</span><span>${kanbanDateByString(options.planning_start)}</span></div>
                    <div style="display: ${options.planning_end ? "grid" : "none"}"><span>Финиш:</span><span>${kanbanDateByString(options.planning_end)}</span></div>
                    <div>
                        <span>Оценка:</span>
                        <span class = "dashed-span-link-btn knbn-ttcr-cont-middle-rating-btn" style = "color: ${options.task_rating_color}">${options.rating}</span>
                        <div class = "knbn-ttcr-cont-middle-rating-bar">
                            <div>
                                <div><span>Оценка</span></div>
                                <div data-rating = "0" class = "task-rating-status"><span class = 'cont-middle-rating-bar-unreated'><i class="far fa-circle"></i></span><span>Нет оценки</span></div>
                                <div data-rating = "1" class = "task-rating-status"><span class = 'cont-middle-rating-bar-positive'><i class="fas fa-plus-circle"></i></span><span>Положительная</span></div>
                                <div data-rating = "2" class = "task-rating-status"><span class = 'cont-middle-rating-bar-negative'><i class="fas fa-minus-circle"></i></span><span>Отрицательная</span></div>
                            </div>
                        </div>
                    </div>
                </div> `);
            break;
        case 'get-knbn-ttcr-cont-bottom':
            return $(` 
                <div class = "knbn-ttcr-cont-bottom">
                    <div>
                        <span class="knbn-ttcr-cont-bottom-item-person">${options.employee_status_name}</span>
                        <span data-employee-status ="${options.employee_status}" class="dashed-span-link-btn knbn-ttcr-cont-bottom-item-person-change">${options.text}</span>
                        <div class = "tch-ied-popup"></div>
                    </div>
                </div>`);
            break;
        case 'get-knbn-ttcr-cont-bottom-items':
            return $(`
                <div class = "knbn-ttcr-cont-bottom-items ${options.expired ? 'ttcr-cont-task-expired' : ''}">
                    <div  class = "knbn-ttcr-cont-emloyee">
                        <div><img src = "${options.employee_src}" alt="${options.employee_name}"></div>
                        <div class = "knbn-ttcr-cont-bottom-items-info">
                            <a href = "#">${options.employee_name}</a>
<!--                            <span>${options.employee_position}</span>-->
                        </div>
                    </div>
                </div>`);
            break;
        case 'get-employee-remove-btn':
            return $(`<div data-del-id ="${options.id}"  class = "remove-employee-btn"><span><i class="fas fa-times"></i></span></div>`);
            break;
        case 'get-task-all-tags':
            return $(`<div class = "knbn-task-all-tags"></div>`);
            break;
        case 'get-knbn-ttcr-cont-bottom-add-item':
            return $(` 
                 <div class = "knbn-ttcr-cont-bottom-add-item">
                     <span>Теги</span>
                     <div class = "knbn-ttcr-cont-bottom-add-item zone-eight-add-tag">
                         <span class = "knbn-ttcr-open-tag-cont dashed-span-link-btn">+ добавить</span>
                         <div class = "task-add-tag-toggle-cont">
                            
                        </div>
                     </div>
                  </div>`);
            break;
        case "get-tags-part":
            return $(
                `<div class = "task-add-tag-cont">
                    <div class ="task-cont-tag-top">
                        <input type="text">
                        <span class = "small-btn task-add-new-tag"><i class="fas fa-plus-square"></i></span>
                    </div>
                    <div class ="task-cont-tag-middle">
                        <div class = "task-cont-tag-related"></div>
                        <div class = "task-cont-tag-other"></div>
                    </div>
<!--                                <div class ="task-cont-tag-bottom">-->
<!--                                    <button class="task-tag-choose c-btn">ВЫБРАТЬ</button>-->
<!--                                    <button class="c-btn c-btn-link">ОТМЕНИТЬ</button>-->
<!--                                </div>-->
                </div>`);
            break;
        case "get-tag-checkbox-cont":
            return $(` 
                <div class ="task-tag-checkbox-cont">
                    <label class="c-label-checkbox">
                        <input data-tag-id = "${options.id}" type="checkbox" class ="task-tag-checkbox">
                       <span class = "task-tag-name">${options.title}</span>
                   </label>
               </div>`)
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}

function addTaskPopupSideBarListeners(tag_popup) {
    $(".remove-employee-btn").on("click", function (e){
        let id = $(this).attr("data-del-id");
        changeEmployees({from:4, id:id});
        $(this).closest(".knbn-ttcr-cont-bottom-items ").remove();
    });
    $(".knbn-ttcr-open-tag-cont").on("click", function (e) {
        $(this).closest("div").find(".task-add-tag-toggle-cont").toggle();
    });
    $('.task-add-new-tag').on("click", function (e) {
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        let tag_name = $(this).closest(".task-cont-tag-top").find("input").val().trim();
        let tag_popup = $(this).closest(".task-add-tag-toggle-cont");
        if(tag_name) {
            creatTagsForTask(tag_name, task_id,  tag_popup);
        }
    });
    // $('.task-tag-choose').on("click", function (e) {
    //     let tag_name = $(this).closest(".task-cont-tag-top").find("input").val();
    //     if(tag_name){alert(tag_name)}
    // });
    $(".knbn-ttcr-cont-bottom-item-person-change").on("click", function (e) {
        e.stopPropagation();
        let target = $(e.target);
        let popup = target.closest('div').find('.tch-ied-popup');
        if (popup.is(":visible")) {
            popup.hide();
        } else {
            $('.tch-ied-popup').hide();
            let employee_status = target.attr('data-employee-status');
            getEmployees(popup, employee_status, popup.closest(".knbn-task-popup-z9").attr("id"), false);
        }
    });
    $('.knbn-ttcr-cont-top-open-deadline-calendar').on('click', function (e) {
        e.stopPropagation();
        let item = $(e.target).closest('div').find('.knbn-ttcr-middle-calendar');
        if (item.is(":visible")) {
            item.hide();
        }
        else {
            $('.knbn-ttcr-middle-calendar').hide();
            item.show();
        }
    });
    $('.knbn-ttcr-middle-calendar-pic-time').on('click', function (e) {
        e.stopPropagation();
        let container = $(this).closest(".knbn-ttcr-middle-calendar");
        let time_picker = container.find('.knbn-ttcr-middle-deadline-calendar');
        let task_id = container.closest('.knbn-task-popup-z9').attr('id');
        let date = time_picker.datetimepicker('getValue');
        calculateDateChangedByDateTimePicker(task_id, date);
        container.hide();
        $('.knbn-ttcr-cont-top-open-deadline-calendar').text(kanbanDateByString(date));
    });
    $('.knbn-ttcr-middle-calendar-close').on('click', function (e) {
        e.stopPropagation();
        $(this).closest(".knbn-ttcr-middle-calendar").hide();
    });
    $('.knbn-ttcr-cont-middle-rating-btn').on('click', function (e) {
        e.stopPropagation();
        $(this).closest("div").find(".knbn-ttcr-cont-middle-rating-bar").toggle();
    });
    $('.task-rating-status').on('click', function (e) {
        let target = $(e.target);
        e.stopPropagation();
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        let target_status = target.closest('.task-rating-status').attr("data-rating");
        changeTaskRating(task_id, target_status);
        $(this).closest(".knbn-ttcr-cont-middle-rating-bar").hide();
        let rating_btn = $(".knbn-ttcr-cont-middle-rating-btn");
        switch(target_status) {
            case "1":
                rating_btn.text("Положительная");
                rating_btn.css('color', "#00dd1c");
                break;
            case "2":
                rating_btn.text("Отрицательная");
                rating_btn.css('color', "#F33434");
                break;
            default:
                rating_btn.text("Нет оценки");
                rating_btn.css('color', "#80868e");
        }

    });
    $('.task-rating-unreated').on('click', function (e) {
        e.stopPropagation();
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        changeTaskRating(task_id, "unrated");
        $(this).closest(".knbn-ttcr-cont-middle-rating-bar").hide();
        let target = $(".knbn-ttcr-cont-middle-rating-btn");
        target.text("Нет оценки");
        target.css('color', "#80868e");
    });
    $('.task-rating-positive').on('click', function (e) {
        e.stopPropagation();
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        changeTaskRating(task_id, "positive");
        $(this).closest(".knbn-ttcr-cont-middle-rating-bar").hide();
        let target = $(".knbn-ttcr-cont-middle-rating-btn");
        target.text("Положительная");
        target.css('color', "#00dd1c");
    });
    $('.task-rating-negative').on('click', function (e) {
        e.stopPropagation();
        let task_id = $(this).closest('.knbn-task-popup-z9').attr('id');
        changeTaskRating(task_id, "negative");
        $(this).closest(".knbn-ttcr-cont-middle-rating-bar").hide();
        let target = $(".knbn-ttcr-cont-middle-rating-btn");
        target.text("Отрицательная");
        target.css('color', "#F33434");
    });

}
