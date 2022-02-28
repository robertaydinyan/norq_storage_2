"use strict";
function createCheckListItems(parent, itemID = null, checklist_item = null, index = null, checklist_data = null) {
    let checklist_item_data;
    let new_checklist_item = false;
    if (checklist_item) {
        checklist_item_data = checklist_item;
    } else {
        let number = parent.find(".tt-checklist-list-item").length + 1;
        checklist_item_data = { sort: number, completed: false, important: false, context: "", image: null, executor_id: [], observer_id: [] };
        ajax_checkponts.push(checklist_item_data);
        if(checklist_data){
            checklist_data.lists.push(checklist_item_data);
        }
        new_checklist_item = true;
    }
    let checklist_item_cont = templatesGenerationCheckListItemContainer({ item_get: "get-checklist-item", new_checklist_item: new_checklist_item, id: checklist_item_data.id, sort: checklist_item_data.sort });
    checklist_item_cont.data("checklist-item-cont", checklist_item_data);
    checklist_item_cont.append(templatesGenerationCheckListItemContainer({ item_get: "get-checklist-item-editor-panel", new_checklist_item: new_checklist_item, important: checklist_item_data.important }));
    let checklist_item_cont_top = templatesGenerationCheckListItemContainer({
        item_get: 'get-checklist-item-top',
        completed: checklist_item_data.status === "1",
        sort: checklist_item_data.sort,
        context: checklist_item_data.context,
        important: +checklist_item_data.important,
        new_checklist_item: new_checklist_item
    });
    let checklist_observer_coexecutor_cont = $(".tt-checklist-list-item-observer-coexecutor-cont", checklist_item_cont_top);
    let checklist_item_image_cont = $(".tt-checklist-list-item-images-cont", checklist_item_cont_top);
    if (checklist_item_data.image) {
        checklist_item_image_cont.append(templatesGenerationCheckListItemContainer({ item_get: "get-checklist-item-image", image: checklist_item.image }));
    }

    if (checklist_item) {
        let executor_container = $(".tt-checklist-executor-cont", checklist_observer_coexecutor_cont);
        let observer_container = $(".tt-checklist-observer-cont", checklist_observer_coexecutor_cont);
            checklist_item.checkpointPerson.forEach(emp=>{
                if(emp.status === '3'){
                    executor_container.append(templatesGenerationCheckListItemContainer({
                        item_get: "get-tt-checklist-list-employees",
                        id: emp.checkpointPersonNames.user_id,
                        name: `${emp.checkpointPersonNames.first_name} ${emp.checkpointPersonNames.last_name}`,
                        completed: checklist_item.status === "1",
                    }));
                    executor_container.css("display", "flex")
                } else {
                    observer_container.append(templatesGenerationCheckListItemContainer({
                        item_get: "get-tt-checklist-list-employees",
                        id: emp.checkpointPersonNames.user_id,
                        name: `${emp.checkpointPersonNames.first_name} ${emp.checkpointPersonNames.last_name}`,
                        completed: checklist_item.status === "1",
                    }));
                    observer_container.css("display", "flex");
                }
            });

    //     new Promise((res, rej) => {
    //         let employee = {};
    //         // getCurrentEmployee(employee, checklist_item_data.id);
    //         setTimeout(() => res(employee), 100);
    //     }).then((employee) => {
    //         checklist_observer_coexecutor_cont.append(drawExecutorAndObservers(employee.executor_id, $(".tt-checklist-executor-cont", checklist_observer_coexecutor_cont), checklist_item.completed, true));
    //         checklist_observer_coexecutor_cont.append(drawExecutorAndObservers(employee.observer_id, $(".tt-checklist-observer-cont", checklist_observer_coexecutor_cont), checklist_item.completed, false));
    //     });
    }
    checklist_item_cont.data("checklist-info", {
        checklist_id: itemID || null,
        checklist_item_id: checklist_item_data.sort,
        sort: checklist_item_data.sort,
        context: checklist_item_data.context,
        completed: checklist_item_data.status === "1"
    });
    checklist_item_cont.append(checklist_item_cont_top);
    if (new_checklist_item) {
        setTimeout(() => $(".z-ea-ch-add-name-input", checklist_item_cont).focus(),10);
    }
    setTimeout(() => addcreateCheckListItemsListeners(checklist_item_cont, checklist_data, checklist_data?checklist_item_data: null ), 100);
    return checklist_item_cont;
}

function templatesGenerationCheckListItemContainer(options = {}) {
    switch (options.item_get) {
        case "get-checklist-item":
            return $(`
                <li id = "${options.id}"  data-checklist-item-sort = "${options.sort}" class = "tt-checklist-list-item ${options.new_checklist_item ? "checklist-task-under-construction" : ""}">
                    <span class="z-ea-hid-grab z-ea-item-btn"><i class="fas fa-grip-vertical"></i></span>
                    <button class="z-ea-hid-delete"><i class="far fa-trash-alt"></i></button>
                    <label class="c-label-checkbox checklist-list-item-checkbox-cont">
                        <input type="checkbox" class="checklist-list-item-checkbox">
                        <span></span>
                    </label>
                </li>`);
            break;
        case 'get-checklist-item-top':
            return $(`
                <div class = "tt-checklist-item-top">
                    <div class = "tt-checklist-item-top-info">
                        <div class="z-ea-ch-check-btn">
                            <label class="c-label-checkbox c-label-checkbox-round">
                                <input type="checkbox"  class = "checklist-point-status" ${options.completed ? "checked" : ""}>
                                <span></span>
                            </label>
                        </div>
                        <span class = "checklist-item-sort">${options.sort}</span>
                        <div><span class = 'zone-e-important-fire checklist-item-important ${options.important ? "fire-orange" : ""}' style="display: ${options.important ? "block" : "none"}"><i class="fab fa-gripfire"></i></span></div>
                        <div class = "z-ea-ch-add-name">
                            <input type ="text" class = "z-ea-ch-add-name-input" placeholder="Название пункта" value="${options.context}" ${options.new_checklist_item ? "" : "readonly"}>
    <!--                        <span class = "z-ea-ch-add-empty-point-value" style="display:${options.new_checklist_item ? "contents" : "none"}"><i class="fas fa-times"></i></span>-->
                        </div>
                        
                    </div>
                    <div class = "tt-checklist-list-item-observer-coexecutor-cont">
                        <div class = "tt-checklist-executor-cont" style="display: ${options.executor}">
                            <div><span class="tt-checklist-list-responsibles-icon"><i class="fas fa-user"></i></span></div>
                        </div>
                        <div class = "tt-checklist-observer-cont" style="display: ${options.observer}">
                            <div><span class="tt-checklist-list-responsibles-icon"><i class="fas fa-eye"></i></span></div>
                        </div>
                    </div>
                    <div class="tt-checklist-list-item-images-cont"></div>
                </div>`);
            break;
        case 'get-checklist-item-editor-panel':
            return $(`
            <div class = "tasks-checklist-item-editor-panel" style="display: ${options.new_checklist_item ? "flex" : "none"}">
                <div>
                    <div>
                        <span class = "tasks-checklist-item-observer"><i class="fas fa-eye"></i> + наблюдатель</span>
                        <div class = "tch-ied-popup">
                        </div>
                    </div>
                    <div>
                        <span class = "tasks-checklist-item-co-executor"><i class="fas fa-user"></i> + соисполнитель</span>
                        <div class = "tch-ied-popup">
                        </div>
                    </div>
<!--                    <div>-->
<!--                        <span class = "tch-ied-add-img"><i class="far fa-image"></i></span> <span><i class="fas fa-align-right"></i></span> <span><i class="fas fa-align-left"></i></span>-->
<!--                         <div class = "tch-ied-popup">-->
<!--                             <div class = 'tch-ied-choose-pic'>-->
<!--                                 <span>Выбрать на компютере</span>-->
<!--                                 <span>Найти в ЕРП</span>-->
<!--                                 <span>Загрузить из внешнего диска</span>-->
<!--                             </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div>
                        <span class = "tasks-checklist-item-imortant ${+options.important ? "fire-orange" : ""}"><i class="fab fa-gripfire"></i> важно</span>
                    </div>
<!--                    <div class = "tasks-checklist-item-other">-->
<!--                        <span><i class="fas fa-list-ul"></i> в другой чек лист</span>-->
<!--                        <div class = "tch-ied-popup">-->
<!--                             <div class = 'tch-ied-choose-checklist'>-->
<!--                                 <span>Чек-лист 1</span>-->
<!--                                 <span>Чек-лист 2</span>-->
<!--                                 <span>+ создать новый</span>-->
<!--                             </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div>
                        <span class = "tasks-checklist-item-del"><i class="fas fa-trash"></i></span>
                    </div>
                </div>
            </div>`);
            break;
        case 'get-tt-checklist-list-employees':
            return $(`
                <div data-user-id = "${options.id}" class = 'tt-checklist-list-responsibles'>
                    <span class="tt-checklist-list-responsibles-name ${options.completed ? "tt-checklist-list-responsibles-name-del" : ""}" >${options.name}</span>
                    <span class = "checklist-responsibles-name-del" style="display: none"><i class="fas fa-times"></i></span>
                </div>`);
            break;
        case 'get-checklist-item-image':
            return $(`<img src = "${options.image}" alt = "image"/>`);
            break;
        default:
            return $(`<div style="font-size: 25px; color: #ff0000">Some Error Occured</div>`);
    }
    return $(`<div style="font-size: 25px; color: red">Some Error Occured</div>`);
}

function addcreateCheckListItemsListeners(checklist_item_cont, checklist_data = null, checklist_item_data) {
    $('.z-ea-drop-btn', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        $(this).closest(".z-ea-ch-header").find('.z-ea-ch-header-change-checklist-name').show();
    });
    // toggle checklist items
    $('.toggle-checklist-list-items', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        $(this).closest('.z-e-chechlist', checklist_container).find('.tt-checklist-list-item-cont, .z-e-ch-items-actions').toggle('blind');
        $(this).toggleClass('toggle-btn-rotate');
    });
    $('.tasks-checklist-item-del, .z-ea-hid-delete', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        let target = $(this);
        let chechlist_item = target.closest('.tt-checklist-list-item');
        let checklist_id = chechlist_item.attr("id");
        let chechlist_items_cont = target.closest(".tt-checklist-list-item-cont");
        chechlist_item.hide('normal').remove();
        let chechlist_items_arr = chechlist_items_cont.find(".tt-checklist-list-item");
        $.each(chechlist_items_arr, function (key, val) {
            let sort = key + 1;
            $(val).attr("data-checklist-item-sort", sort);
            $(val).find(".checklist-item-sort").text(sort);
            if(checklist_data){
                checklist_item_data
                checklist_data.lists.filter(item=>item.sort !== checklist_item_data.sort)
                console.log(checklist_data);
            } else {
                changeChecklistContainerItemSorting($(val).attr("id"), sort);
            }

        });
        if(checklist_data){
            console.log(checklist_data);
        } else {
            deleteChecklistItem(checklist_id);
        }
    });
    $('.z-ea-ch-check-btn', checklist_item_cont).on('click', function (e) { e.stopPropagation(); });
    $('.checklist-point-status', checklist_item_cont).on('change', function (e) {
        let checklist_cont = $(this).closest('.z-e-chechlist-box');
        let parent_id = $(this).closest(".tt-checklist-list-item").attr("id");
        let target_name = $(this).closest('.tt-checklist-item-top-info').find(".tt-checklist-list-responsibles-name");
        let checkbox = $(this);
        if (checkbox.prop('checked')) {
            let status = checklist_cont.find(".z-ea-ch-header-status-items-grey");
            status.eq(0).removeClass("z-ea-ch-header-status-items-grey").addClass("z-ea-ch-header-status-items-green");
            if(checklist_data){
                console.log(checklist_data);
            } else {
                // changeChecklistItemCompletedStatus(parent_id, true);
            }
        }
        else {
            let status = checklist_cont.find(".z-ea-ch-header-status-items-green");
            status.eq(status.length - 1).removeClass("z-ea-ch-header-status-items-green").addClass("z-ea-ch-header-status-items-grey");
            if(checklist_data){
                console.log(checklist_data);
            } else {
                // changeChecklistItemCompletedStatus(parent_id, false);
            }

        }
        target_name.toggleClass("tt-checklist-list-responsibles-name-del");
    });
    $('.tasks-checklist-item-imortant', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        let task_id = checklist_data? null: +$(this).closest(`.knbn-task-popup-z9`).attr('id');
        let target = $(this).closest("li").find(".zone-e-important-fire");
        let checkpoint = $(this).closest('.tt-checklist-list-item');
        let checklist_container_id = $(this).closest(".z-e-chechlist-box").attr("data-checklist-id");
        let status = checkpoint.find('.checklist-point-status').is(':checked');
        let sort = +checklist_item_cont.find(".checklist-item-sort").text();
        let context = checkpoint.find(".z-ea-ch-add-name-input").val();
        if ($(this).hasClass('fire-orange')) {
            target.removeC
            lass('fire-orange').hide();
            if(checklist_data){
                checklist_item_data.important= false;
            } else {
                // changeChecklistItemImportance(parent_id, false);
                addNewChecklistItem(task_id, checklist_container_id, sort, context, 0, status, $(this).closest('.tt-checklist-list-item'));
            }
        }
        else {
            target.addClass('fire-orange').show();
            if(checklist_data){
                checklist_item_data.important= false;
            } else {
                // changeChecklistItemImportance(parent_id, true);
                addNewChecklistItem(task_id, checklist_container_id, sort, context, 1, status, $(this).closest('.tt-checklist-list-item'));
            }
        }
        $(this).toggleClass('fire-orange');
    });
    $('.tasks-checklist-item-observer', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        let target = $(e.target).closest('div').find('.tch-ied-popup');
        if (target.is(":visible")) {
            target.hide();
        }
        else {
            $('.tch-ied-popup').hide();
            getEmployees(target, 'observer', target.closest(".knbn-task-popup-z9").attr("id"), true, true);
            target.show();
        }
    });
    $('.tasks-checklist-item-co-executor', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        let target = $(e.target).closest('div').find('.tch-ied-popup');
        if (target.is(":visible")) {
            target.hide();
        }
        else {
            $('.tch-ied-popup').hide();
            getEmployees(target, "co-executor", target.closest(".knbn-task-popup-z9").attr("id"), true, true);
            target.show();
        }
    });
    $('.tch-ied-add-img', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        let target = $(e.target).closest('div').find('.tch-ied-popup');
        if (target.is(":visible")) {
            target.hide();
        }
        else {
            $('.tch-ied-popup').hide();
            target.show();
        }
    });
    $('.tasks-checklist-item-other', checklist_item_cont).on('click', function (e) {
        e.stopPropagation();
        let target = $(e.target).closest('div').find('.tch-ied-popup');
        if (target.is(":visible")) {
            target.hide();
        }
        else {
            $('.tch-ied-popup').hide();
            target.show();
        }
    });
    $(".z-ea-ch-add-empty-point-value", checklist_item_cont).on('click', function (e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        $(this).closest("div").find("input").val("");
    });
    if(checklist_data){
        console.log(checklist_data);
        $('.z-ea-ch-add-name-input', checklist_item_cont).on('blur', function (e) {
            let not_target = $(".checklist-task-under-construction");
            showHideByClickingChecklistItem(not_target);
        }).on('keyup', function (e) {
            if (e.keyCode === 13) {
                let not_target = $(this).closest(".checklist-task-under-construction");
                showHideByClickingChecklistItem(not_target);
            }
        });
    }
    $('.z-ea-ch-add-name-input', checklist_item_cont).on('dbclick', function (e) {
        $(this).prop('readonly', false);
        $(this).addClass("input-under-construction");
    });
    $('.z-ea-ch-add-name-input', checklist_item_cont).on('change', function (e) {
        let task_id = checklist_data? null: +$(this).closest(`.knbn-task-popup-z9`).attr('id');
        let checklist_id = checklist_item_cont.attr("id");
        let context = $(this).val();
        let sort = +checklist_item_cont.find(".checklist-item-sort").text();
        let checklist_container = checklist_item_cont.closest(".z-e-chechlist-box");
        let checklist_container_id = checklist_container.attr("data-checklist-id");
        let status = checklist_container.find('.checklist-point-status').is(':checked');
        let important = $(this).closest("li").find(".zone-e-important-fire").hasClass("fire-orange")? 1 : 0;
        if (context) {
            if (checklist_id != "undefined") {
                if(checklist_data){
                    console.log(checklist_data);
                } else {
                    addNewChecklistItem(task_id, checklist_container_id, sort, context, important, status, $(this).closest('.tt-checklist-list-item'));
                    // changeChecklistItemContext(checklist_id, context);
                }
            } else {

                if(checklist_data){
                    console.log(checklist_data);
                } else {
                    addNewChecklistItem(task_id, checklist_container_id, sort, context, important, status, $(this).closest('.tt-checklist-list-item'));
                }
            }
        }
    });
    $(".tt-checklist-list-item").on("mouseenter", function (e) {
        $(this).find(".tasks-checklist-item-editor-panel").show();
    });
    $(".tt-checklist-list-item").on("mouseleave", function (e) {
        $(this).find(".tasks-checklist-item-editor-panel").hide();
    });
    //     $('.tasks-checklist-item-del', checklist_point).on('click', function (e) {
    //         e.stopPropagation();
    //        $(this).closest(".z-ea-ch-add-point").remove();
    //     });
    //     $(".z-ea-ch-add-empty-point-value", checklist_point).on('click', function (e) {
    //         e.stopPropagation();
    //         $(this).closest("div").find("input").val("");
    //     });
}
