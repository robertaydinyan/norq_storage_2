"use strict";
function createCheckListContainer(item = null, new_task = false) {
    let checklist_data = item;
    let completed_status = (checklist_data.checkpoint.filter((item) => { return item.completed; })).length;
    let total = checklist_data.checkpoint.length || 1;
    let checklist = templatesGenerationCheckListContainer({
        item_get: "get-tt-checklist-list",
        id: checklist_data.id || null,
        sort: checklist_data.sort,
    });
    //===========================================chechlist-cont-info ===============================//
    checklist.data("checklist-cont-info", checklist_data);
    $('.z-e-chechlist', checklist).append(templatesGenerationCheckListContainer({
        item_get: "get-z-ea-ch-header",
        title: checklist_data ? checklist_data.title : "Чек-лист 1",
        new_checklist: item ? false : true,
        completed_status: completed_status,
        total: total,
    }));
    for (let i = 0; i < total; i++) {
        if (i < completed_status) {
            $(".z-ea-ch-status", checklist).append($(`<div class = "z-ea-ch-header-status-items-green"></div>`));
        }
        else {
            $(".z-ea-ch-status", checklist).append($(`<div class = "z-ea-ch-header-status-items-grey"></div>`));
        }
    }
    let checklist_info_container = templatesGenerationCheckListContainer({ item_get: "get-tt-checklist-list-item-cont", });
    if (checklist_data) {
        checklist_data.checkpoint.sort((a, b) => (a.sort - b.sort));
        checklist_data.checkpoint.forEach((checklist_item_data, index) => {
            checklist_info_container.append(createCheckListItems(checklist, checklist_data.id, checklist_item_data, index));
        });
        $('.z-e-chechlist', checklist).append(checklist_info_container);
        $('.z-e-chechlist', checklist).append(templatesGenerationCheckListContainer({
            item_get: "get-z-e-ch-items-actions",
            block: 'block',
        }));
    }
    else {
        checklist_info_container.append(createCheckListItems(checklist));
        $('.z-e-chechlist', checklist).append(checklist_info_container);
        $('.z-e-chechlist', checklist).append(templatesGenerationCheckListContainer({
            item_get: "get-z-e-ch-items-actions",
            block: 'block',
        }));
    }
    checklist_info_container.sortable({
        handle: ".z-ea-item-btn",
        placeholder: 'z-ea-item-placeholder',
        axis: 'y',
        beforeStop: function (e, ui) {
            let chechlist_items = $(".tt-checklist-list-item", e.target);
            if (chechlist_items.length > 1) {
                $.each(chechlist_items, function (key, val) {
                    let sort = key + 1;
                    $(val).attr("data-checklist-item-sort", sort);
                    $(val).find(".checklist-item-sort").text(sort);
                    if(checklist_data){
                        console.log(111);
                    } else {
                        changeChecklistContainerItemSorting($(val).attr("id"), sort);
                    }
                });
            }
        }
    }).disableSelection();
    setTimeout(() => addCheckListContainerListeners(checklist, new_task?checklist_data:null ), 10);
    return checklist;
}
function templatesGenerationCheckListContainer(options = {}) {
    switch (options.item_get) {
        case 'get-tt-checklist-list':
            return $(`
                <li data-checklist-id = "${options.id}" data-checklist-cont-sort ="${options.sort}" class="z-e-chechlist-box">
                    <div class = "z-e-chechlist"></div>
                </li>`);
            break;
        case 'get-z-ea-ch-header':
            return $(`
            <div class = "z-ea-ch-header">
                <div class = "z-ea-ch-header-change-checklist-name">
                    <input type="text" value = "${options.title}">
                    <span class = "z-ea-ch-header-change-checklist-name-save"><i class="far fa-save"></i></span>
                </div>
                <div class = "z-ea-ch-header-left">
                    <div> ${options.new_checklist ? "" : $(`<span class = 'z-ea-drop-btn z-ea-hid-btn z-ea-hid-grab'><i class="fas fa-grip-vertical"></i></span>`)[0].outerHTML}</div>
                    <span class = "z-ea-checklist-name">${options.title}</span>
                    <div><span class = 'z-ea-drop-btn z-ea-hid-btn'><i class="fas fa-pen"></i></span></div>
                    <div class = "z-ea-ch-status"></div>
                    <span class = "z-ea-ch-done">выполнено: <span class = "z-ea-done-chpoints">${options.completed_status}</span> из <span class = "z-ea-all-chpoints">${options.total}</span></span>
                </div>
                <div class = "z-ea-ch-header-right">
<!--                    <button class="c-btn-dashed-show group-checklist-lists">Групповые действия</button>-->
                    <button class="toggle-checklist-list-items toggle-btn"><i class="fas fa-chevron-up"></i></button>
                </div>
            </div>`);
            break;
        case 'get-tt-checklist-list-item-cont':
            return $(`<ul class = "tt-checklist-list-item-cont"></ul>`);
            break;
        case 'get-z-e-ch-items-actions':
            return $(`
                <div class="z-e-ch-items-actions">
                    <div><button class = "z-e-ch-items-actions-add-point c-btn-dashed-show c-btn-dashed-show-secondary" style = "display: ${options.block}">+ добавить пункт</button></div>
                    <button class="c-btn-dashed-show c-btn-dashed-show-danger checklist-del-btn">удалить чек-лист</button>
                </div>`);
            break;
        // goes to checklistitems
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}

function addCheckListContainerListeners(checklist, checklist_data = null) {
    $('.group-checklist-lists', checklist).on('click', function (e) {
        e.stopPropagation();
        $(this).closest('.z-e-chechlist').find('.tt-checklist-list-item').find('.checklist-list-item-checkbox-cont').toggle();
    });
    $('.z-e-ch-items-actions-add-point', checklist).on("click", function (e) {
        e.stopPropagation();
        let not_target = $(".checklist-task-under-construction");
        showHideByClickingChecklistItem(not_target);
        let container = $(e.target).closest('.z-e-chechlist-box');
        container.find(".z-ea-ch-done")
        let target = container.find(".tt-checklist-list-item-cont");
        if (container.length) {
            target.append(createCheckListItems(container,null, null, null, checklist_data));
        }
    });
    $(".tt-checklist-item-top", checklist).on("click", function (e) {
        e.stopPropagation();
        if (!$(this).hasClass("checklist-task-under-construction")) {
            let target = $(this).closest("li");
            let not_target = $(".checklist-task-under-construction");
            showHideByClickingChecklistItem(not_target);
            target.addClass("checklist-task-under-construction");
            target.find(".z-ea-ch-add-empty-point-value").show();
            target.find(".checklist-responsibles-name-del").show();
            target.find(".z-ea-ch-add-name-input").prop('readonly', false);
            target.find(".z-ea-ch-add-name-input").focus();
        }
    });
    $('.z-ea-ch-header-change-checklist-name-save', checklist).on('click', function (e) {
        e.stopPropagation();
        let checklist_container_id = checklist.closest(".z-e-chechlist-box").attr("data-checklist-id");
        let title = $(this).closest('div').find('input').val();
        if (title) {
            checklist.find('.z-ea-checklist-name').text(title);
            checklist.find('.z-ea-ch-header-change-checklist-name').hide();
            if (checklist_container_id) {
                if(checklist_data){
                    ajax_checklist[0].title = title;
                    console.log(ajax_checklist[0].title);
                }else {
                    changeChecklistContainerTitle(checklist_container_id, title);
                }
            }
            else {
                checklist_data.title = title;
            }
        }
        else {
            alert('type name');
        }
    });
    $('.z-ea-drop-btn', checklist).on('click', function (e) {
        e.stopPropagation();
        $(this).closest(".z-ea-ch-header").find('.z-ea-ch-header-change-checklist-name').show();
    });
    $('.checklist-del-btn', checklist).on('click', function (e) {
        e.stopPropagation();
        let parent = $(this).closest('.z-e-chechlist-box');
        let parent_id = parent.attr("data-checklist-id");
        parent.remove();
        if(checklist_data){
            ajax_checklist = ajax_checklist.filter(item=> item.sort !== checklist_data.sort);
            console.log(checklist_data.sort);
            console.log(ajax_checklist);
        } else {
            deleteChecklist(parent_id);
        }

    });
}
