"use strict";
/**
 *
 * @param data
 * @param kanban_type
 */
function createKanban(data, kanban_type) {
    let lead = "lead";
    let task = "task";
    let deal = "deal";
    let html_kanban;
    let kanban_body;
    //================ gets kanban template by type ================
    switch(kanban_type) {
        case lead:
            html_kanban = kanbanTemplatesGeneration({ item_get: 'get-kanban', kanban_type: lead});
            kanban_body = $('.knbn-lead-body', html_kanban);
            //================ if lead kanban draws header that appears when clicking on kanaban item ================
            $('.knbn-main', html_kanban).prepend(kanbanTemplatesGeneration({ item_get: 'get-knbn-header-hid', kanban_type: lead}));
            break;
        case task:
            html_kanban = kanbanTemplatesGeneration({ item_get: 'get-kanban', kanban_type: task});
            kanban_body = $('.knbn-task-body', html_kanban);
            break;
        case deal:
            html_kanban = kanbanTemplatesGeneration({ item_get: 'get-kanban', kanban_type: deal});
            kanban_body = $('.knbn-deal-body', html_kanban);
            $('.knbn-main', html_kanban).prepend(kanbanTemplatesGeneration({ item_get: 'get-knbn-header-hid',kanban_type: deal}));
            break;
        default:
            alert("somethin wrong happend! why?");
    }

    //================ runs through data and creates columns ================
    data.forEach((column, index) => {
        //================ gets kanban column template ================
        let knbn_column = kanbanTemplatesGeneration({
            item_get: 'get-knbn-col',
            kanban_type: kanban_type,
            id: column.id,
            title: column.title,
            color: column.color,
        });
        if (kanban_type === lead) {
            knbn_column.attr("id", `${column.id}`)
            knbn_column.data("lead_column", {id: column.id, title: column.title, color: column.color, position: index+1});
            //=========================== draw header hidden editable part        ============================//
            $('.knbn-col', knbn_column).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-header-hidden",
                kanban_type: kanban_type,
                color: column.color,
                title: column.title,
                id: column.id,
            }));
            $(`#color-${column.id}`,knbn_column ).spectrum({
                color: `${column.color}`,
                change: function(color) {
                    let selected_color =  color.toHexString();
                    let knbn_column =$(this).closest("li");
                    knbn_column.find(".knbn-lead-step").css({"background-color": `${selected_color}`, "color": `${selected_color}`});
                    knbn_column.find("li").css("border-color", `${selected_color}`);
                }
            });
            //============================ draw header hidden buttons  =============================//
            $('.knbn-header', knbn_column).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-edit-cont",
            }));

            //================ if lead kanban draw plus btn that adds new leads ================
            $('.knbn-col', knbn_column).append(kanbanTemplatesGeneration({item_get: "get-knbn-plus-btn"}));

            //================ if lead kanban starts creating kanban items in column ================
            knbn_column.append(createKanbanLeadItems(column.order, column.color));

        } else if(kanban_type === task) {
           knbn_column.attr("data-alias", `${column.alias}`);
            //================ if task kanban draw plus btn that adds new tasks ================
            $('.knbn-col', knbn_column).append(index ? $(`<div class = 'knbn-plus-btn knbn-header-task-plus'><span class="knbn-plus-icon"><i class="fas fa-plus"></i></span></div>`) : $(`<div class = 'knbn-plus-btn'><span></span></div>`));

            //================ if task starts creating kanban items in column ================
            knbn_column.append(createKanbanTaskItems(column.column_tasks, column.alias, column.color, index));
        } else {
            knbn_column.data("deal_column", {id: column.id, title: column.title, color: column.color, position: index+1});
            $('.knbn-col', knbn_column).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-header-hidden",
                kanban_type: kanban_type,
                color: column.color,
                title: column.title,
                id: column.id,
            }));
            $('.knbn-col', knbn_column).append(kanbanTemplatesGeneration({
                item_get: "get-deal-knbn-total",
                total: column.total,
            }));
            $(`#color-${column.id}`,knbn_column ).spectrum({
                color: `${column.color}`,
                change: function(color) {
                    let selected_color =  color.toHexString();
                    let knbn_column =$(this).closest("li");
                    knbn_column.find(".knbn-deal-step").css({"background-color": `${selected_color}`, "color": `${selected_color}`});
                    knbn_column.find("li").css("border-color", `${selected_color}`);
                }
            });
            $('.knbn-header', knbn_column).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-edit-cont",
            }));
            $('.knbn-col', knbn_column).append(kanbanTemplatesGeneration({item_get: "get-knbn-plus-btn"}));
            knbn_column.append(createKanbanDealItems(column.order, column.color));
        }
        kanban_body.append(knbn_column);
    });
    //================ after kanban is drawn adds arrow slides ================
    drawArrowSliders($(".erp-arrow-slides", html_kanban), $(".knbn-main", html_kanban));

    //================ after kanban is drawn adds listeners ================
    setTimeout(() => addKanbanListeners(kanban_type), 10);
    return html_kanban;
}
/**
 *
 * @param isLead
 */
function addKanbanListeners(kanban_type) {
    let body = $("body");
    let lead = "lead";
    let task = "task";
    let deal = "deal";
    // =================================kanban lead listeners ====================
    if(kanban_type === lead) {
        $(".knbn-header-close").click("click", function (e){
            $(this).closest(".knbn-header-hid").hide("blind");
            $(".knbn-hidden").hide();
        });
        $('.knbn-lead-delete').on("click", function () {
            let selected = $(".knbn-selected").closest("li");
            let selected_ids = getSelectedLeads(selected);
            if(selected_ids.length){
                let delete_confirm = confirmDeletion("Лиды");
                delete_confirm.delete_btn.on("click", function (e) {
                    delete_confirm.confirm_deletion_popup_cont.hide();
                    console.log(selected_ids);
                    selected.remove();
                });
            }
        });
        $(".knbn-lead-schedule").on("click", function (e) {
            e.stopPropagation();
            $(this).closest("div"). find(".knbn-lead-schedule-hid").toggle();
        });
        $('.knbn-header-plus').on('click', function (e) {
            e.stopPropagation();
            let popup = $(e.target).closest('li').find('.knbn-item-popup');
            let column_ul = $(e.target).closest("li").find(".knbn-column");
            $( column_ul ).scrollTop( 0 );
            if (popup.is(":hidden")) {
                $('.knbn-item-popup:visible').hide('blind');
                popup.show('blind');
            } else {
                $('.knbn-item-popup:visible').hide('blind');
                popup.hide('blind');
            }
        });
        $(".knbn-save").on("click", function (e){
            e.stopPropagation();
            hideLeadAddPart ($(e.target));
        });
        $('.knbn-cancel').on('click', function (e) {
            e.stopPropagation();
            hideLeadAddPart ($(e.target));
        });
        $('.add-new-cont').on('click', function (e) {
            e.stopPropagation();
            $(`<div class = "add-item">
                <p>Контакт</p>
                <div class="c-floating-label">
                    <input type="text" placeholder=" ">
                    <label>Лид #</label>
                </div>
            </div>`).insertBefore($(e.target));
        });
        $('.knbn-lead-item').on('click', function (e) {
            const lead = $(this);//.closest('li');
            let selected = $(".knbn-selected-lead");
            lead.find('.knbn-t-chbx').toggle();
            lead.toggleClass('knbn-selected');
            let selected_lead_count = $('.knbn-selected').length;
            if (selected_lead_count) {
                $('.knbn-header-hid').show('blind');
                $(".erp-knbn-item-connect").hide();
            } else {
                $('.knbn-header-hid').hide('blind');
                $(".erp-knbn-item-connect").show();

            }
            selected.text(selected_lead_count);
        });
        $(".lead-name").on("click", function (e){
            let lead_id = $(this).closest("li").attr("data-id");
            e.stopPropagation();
            function drawLeadInfo(data){return $(`<div>${data}</div>`)}
            drawZoneNine(drawLeadInfo, $(".popup1"), lead_id);
            zoneNineHideShow($(".popup1"), "show");
        })
        $('.knbn-edit-col').on('click', function (e) {
            editColumnInfo($(this));
        });
        $(".knbn-col-del").on("mousedown",  function (e){
            e.stopPropagation();
            deleteColumn($(e.target))
        });
        body.on("change", ".knbn-header-hidden", function (e){//.knbn-header-hidden
            e.stopPropagation();
            if($(e.target).is(".knbn-column-colorpicker")){
                $(e.target).closest("div").find(".knbn-step-input").focus();
            } else {
                changeColumnName($(this).find(".knbn-step-input"), lead);
            }
        });
        body.on("click", function (e) {
            e.stopPropagation();
            let target = $(e.target);
            if(!target.closest(".knbn-header-hidden, .knbn-edit-col, .knbn-add-col").length){
               if($(".knbn-header-hidden:visible").length) {
                   changeColumnName($(".knbn-header-hidden:visible").find(".knbn-step-input"), lead);
               }
            }
        });
        $(".erp-knbn-item-connect span").on("click", function (e){
            e.stopPropagation();
        });
        $('.knbn-add-col').on('click', function (e) {
            let id = $(this).closest("li").attr("data-id");
            let column =  {id: 'col09', title: 'column-09', position: 1, color: '#ff5752', order: []}
            let new_col = kanbanTemplatesGeneration({
                item_get: "get-knbn-col",
                kanban_type: lead,
                id: column.id,
                title: column.title,
                color: column.color,}).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-header-hidden",
                kanban_type: lead,
                id: column.id,
                color: column.color,
                title: column.title,})).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-plus-btn"}));
            $('.knbn-header', new_col).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-edit-cont",
            }));
            new_col.data("lead_column", {id: column.id, title: column.title, color: column.color});
            $('.knbn-col-del', new_col).on('click', function (e) {
                e.stopPropagation();
                $(this).closest('li').remove();
            });
            $(e.target).closest('li').after(new_col);
            $(".knbn-header", new_col).hide();
            $(".knbn-header-hidden", new_col).show();
            $('.knbn-edit-col', new_col).on('click', function (e) {
                editColumnInfo($(this));
            });
            $(`#color-${column.id}`,new_col ).spectrum({
                color: column.color,
                change: function(color) {
                    let selected_color =  color.toHexString();
                    let knbn_column =$(this).closest("li");
                    knbn_column.find(".knbn-lead-step").css({"background-color": `${selected_color}`, "color": `${selected_color}`});
                    knbn_column.find("li").css("border-color", `${selected_color}`);
                }
            });
        });
        $('.knbn-column').sortable({
            items: "li:not(.knbn-item-popup)",
            connectWith: ".knbn-column",
            handle: ".lead-cont",
            placeholder: 'knbn-item-placeholder',
            cursor: 'grabbing',
            opacity: 0.5,
            start: function(event, ui) {
                ui.item.data('start_pos', {start_pos_index: $(ui.item).index(), start_column_id: $(ui.item).closest(".knbn-main-col").attr("data-id")});
            },
            stop: function (event, ui) {
                let elem = $(ui.item);
                let elem_data = elem.data('start_pos');
                let elem_id = elem.attr("data-id");
                let column = elem.closest(".knbn-main-col");
                let column_id =  column.attr("data-id");
                if (!(elem_data.start_pos_index === elem.index() && elem_data.start_column_id === column_id)){
                    // let left_id = elem.prev().attr("data-id")? elem.prev().attr("data-id") : null;
                    // let right_id = elem.next().attr("data-id") ? elem.next().attr("data-id") : null;
                    elem.css("border-left-color", `${column.find(".knbn-lead-step").css("background-color")}`);
                    // console.log(`column_id: ${column_id}  elem_id: ${elem_id}   left_id: ${left_id} right_id: ${right_id}`);
                }
            },
        }).disableSelection();
        $('.knbn-lead-body').sortable({
            handle: '.knbn-header',
            placeholder: 'knbn-column-placeholder',
            cursor: 'grabbing',
            cancel: "",
            axis: "x",
            stop: function (event, ui) {
                let elem = $(ui.item);
                if( elem.data('lead_column').position !== elem.index()+1){
                    let from_id = elem.attr("data-id");
                    let left_id = elem.prev().attr("data-id")? elem.prev().attr("data-id") : null;
                    let right_id = elem.next().attr("data-id") ? elem.next().attr("data-id") : null;
                    console.log(`from_id: ${from_id}   left_id: ${left_id}   right_id: ${right_id}`);
                }
            }
        }).disableSelection();
        $('.kanban-lead').tooltip();
    }else if (kanban_type === task) {
        $('.knbn-header-task-plus').on('click', function (e) {
            e.stopPropagation();
            let item = $(e.target).closest('li').find('.knbn-task-add');
            $(this).closest('li').find('.knbn-add-task-select').prop('selectedIndex', 9);
            $(this).closest('li').find('.add-task-priority-text').removeAttr('class').addClass('add-task-priority-text');
            $(this).closest('li').find('.add-task-priority-text').text("Приоритет");
            if (item.is(":visible")) {
                $('.knbn-task-add:visible').hide();
                item.hide('blind');
            } else {
                $('.knbn-task-add:visible').hide();
                let text_box = item.find('textarea');
                text_box.val('');
                item.show();
            }
        });
        $('.knbn-new-task-save').on('click', function (e) {
            e.stopPropagation();
            let parent = $(this).closest('li');
            let title = parent.find('.knbn-task-textarea').val();
            if (title) {
                let select = parent.find('.knbn-add-task-select');
                let priority = +select.val();
                let column = parent.closest('ul');
                let alias = column.data('taskContInfo').column_alias;
                let color = column.data('taskContInfo').column_color;
                let date;
                if (alias === "no_limit") {
                    date = null;
                }
                else {
                    date = getDateWhenTaskChangesColumnOrAddNewDate({ week: alias });
                }
                column.append(kanbanTemplatesGenerateTaskItems({
                    item_get: "get-knbn-task-item",
                    priority: priority,
                    title: title,
                    date: date,
                    producer_img: user_image,
                    producer_alt: user.name,
                    responsible_img: user_image,
                    responsible_alt: user.name,
                    alias: alias,
                    delayed: false,
                    no_limit: alias === 'no_limit',
                    draw_date: getKanbanDate(date, moment()),
                    background_color: color,
                    color: color,
                    completed: false,
                    alert: true,
                    pause: false,
                }));
                addNewTaskInKanban(priority, title, date);
                $(this).closest('li').hide();
                select.prop('selectedIndex', 0);
            }
            else {
                alert('you did not add task name');
            }
        });
        $('.knbn-new-task-cancel').on('click', function (e) {
            e.stopPropagation();
            let parent = $(this).closest('li');
            parent.hide('blind');
            parent.find('.knbn-add-task-select').prop('selectedIndex', 0);
            parent.find('.add-task-priority-text').removeAttr('class').addClass('add-task-priority-text');
        });
    } else if (kanban_type === deal) {
        $(".knbn-header-close").click("click", function (e){
            $(this).closest(".knbn-header-hid").hide("blind");
            $(".knbn-hidden").hide();
        });
        $('.knbn-deal-delete').on("click", function () {
            let selected = $(".knbn-selected").closest("li");
            let selected_ids = getSelectedLeads(selected);
            if(selected_ids.length){
                let delete_confirm = confirmDeletion("Лиды");
                delete_confirm.delete_btn.on("click", function (e) {
                    delete_confirm.confirm_deletion_popup_cont.hide();
                    console.log(selected_ids);
                    selected.remove();
                });
            }
        });
        $(".knbn-deal-schedule").on("click", function (e) {
            e.stopPropagation();
            $(this).closest("div"). find(".knbn-deal-schedule-hid").toggle();
        });
        $('.knbn-header-plus').on('click', function (e) {
            e.stopPropagation();
            let popup = $(e.target).closest('li').find('.knbn-item-popup');
            let column_ul = $(e.target).closest("li").find(".knbn-column");
            $( column_ul ).scrollTop( 0 );
            if (popup.is(":hidden")) {
                $('.knbn-item-popup:visible').hide('blind');
                popup.show('blind');
            } else {
                $('.knbn-item-popup:visible').hide('blind');
                popup.hide('blind');
            }
        });
        $(".knbn-save").on("click", function (e){
            e.stopPropagation();
            hideLeadAddPart ($(e.target));
        });
        $('.knbn-cancel').on('click', function (e) {
            e.stopPropagation();
            hideLeadAddPart ($(e.target));
        });
        $('.add-new-cont').on('click', function (e) {
            e.stopPropagation();
            $(`<div class = "add-item">
                <p>Контакт</p>
                <div class="c-floating-label">
                    <input type="text" placeholder=" ">
                    <label>Лид #</label>
                </div>
            </div>`).insertBefore($(e.target));
        });
        $('.knbn-deal-item').on('click', function (e) {
            const deal = $(this);//.closest('li');
            let selected = $(".knbn-selected-deal");
            deal.find('.knbn-t-chbx').toggle();
            deal.toggleClass('knbn-selected');
            let selected_lead_count = $('.knbn-selected').length;
            if (selected_lead_count) {
                $('.knbn-header-hid').show('blind');
                $(".erp-knbn-item-connect").hide();
            } else {
                $('.knbn-header-hid').hide('blind');
                $(".erp-knbn-item-connect").show();

            }
            selected.text(selected_lead_count);
        });
        $(".deal-name").on("click", function (e){
            let lead_id = $(this).closest("li").attr("data-id");
            e.stopPropagation();
            function drawLeadInfo(data){return $(`<div>${data}</div>`)}
            drawZoneNine(drawLeadInfo, $(".popup1"), lead_id);
            zoneNineHideShow($(".popup1"), "show");
        })
        $('.knbn-edit-col').on('click', function (e) {
            editColumnInfo($(this));
        });
        $(".knbn-col-del").on("mousedown",  function (e){
            e.stopPropagation();
            deleteColumn($(e.target))
        });
        body.on("change", ".knbn-header-hidden", function (e){//.knbn-header-hidden
            e.stopPropagation();
            if($(e.target).is(".knbn-column-colorpicker")){
                $(e.target).closest("div").find(".knbn-step-input").focus();
            } else {
                changeColumnName($(this).find(".knbn-step-input"),deal);
            }
        });
        body.on("click", function (e) {
            e.stopPropagation();
            let target = $(e.target);
            if(!target.closest(".knbn-header-hidden, .knbn-edit-col, .knbn-add-col").length){
                if($(".knbn-header-hidden:visible").length) {
                    changeColumnName($(".knbn-header-hidden:visible").find(".knbn-step-input"), deal);
                }
            }
        });
        $(".erp-knbn-item-connect span").on("click", function (e){
            e.stopPropagation();
        });
        $('.knbn-add-col').on('click', function (e) {
            let id = $(this).closest("li").attr("data-id");
            let column =  {id: 'col09', title: 'column-09', position: 1, color: '#ff5752', order: []}
            let new_col = kanbanTemplatesGeneration({
                item_get: "get-knbn-col",
                kanban_type: deal,
                id: column.id,
                title: column.title,
                color: column.color,}).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-header-hidden",
                kanban_type: deal,
                id: column.id,
                color: column.color,
                title: column.title,})).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-plus-btn"}));
            $('.knbn-header', new_col).append(kanbanTemplatesGeneration({
                item_get: "get-knbn-edit-cont",
            }));
            new_col.data("lead_column", {id: column.id, title: column.title, color: column.color});
            $('.knbn-col-del', new_col).on('click', function (e) {
                e.stopPropagation();
                $(this).closest('li').remove();
            });
            $(e.target).closest('li').after(new_col);
            $(".knbn-header", new_col).hide();
            $(".knbn-header-hidden", new_col).show();
            $('.knbn-edit-col', new_col).on('click', function (e) {
                editColumnInfo($(this));
            });
            $(`#color-${column.id}`,new_col ).spectrum({
                color: column.color,
                change: function(color) {
                    let selected_color =  color.toHexString();
                    let knbn_column =$(this).closest("li");
                    knbn_column.find(".knbn-deal-step").css({"background-color": `${selected_color}`, "color": `${selected_color}`});
                    knbn_column.find("li").css("border-color", `${selected_color}`);
                }
            });
        });
        $('.knbn-column').sortable({
            items: "li:not(.knbn-item-popup)",
            connectWith: ".knbn-column",
            handle: ".deal-cont",
            placeholder: 'knbn-item-placeholder',
            cursor: 'grabbing',
            opacity: 0.5,
            start: function(event, ui) {
                ui.item.data('start_pos', {start_pos_index: $(ui.item).index(), start_column_id: $(ui.item).closest(".knbn-main-col").attr("data-id")});
            },
            stop: function (event, ui) {
                let elem = $(ui.item);
                let elem_data = elem.data('start_pos');
                let elem_id = elem.attr("data-id");
                let column = elem.closest(".knbn-main-col");
                let column_id =  column.attr("data-id");
                if (!(elem_data.start_pos_index === elem.index() && elem_data.start_column_id === column_id)){
                    elem.css("border-left-color", `${column.find(".knbn-deal-step").css("background-color")}`);
                }
            },
        }).disableSelection();
        $('.knbn-deal-body').sortable({
            handle: '.knbn-header',
            placeholder: 'knbn-column-placeholder',
            cursor: 'grabbing',
            cancel: "",
            axis: "x",
            stop: function (event, ui) {
                let elem = $(ui.item);
                if( elem.data('deal_column').position !== elem.index()+1){

                }
            }
        }).disableSelection();
    }
}
function changeColumnName(target, kanban_type){
    let column = target.closest("li");
    let column_color = target.closest(`.knbn-${kanban_type}-step`).css("color")
    let parent = target.closest('.knbn-main-col');
    let column_title = target.val().trim();
    let column_name_span = target.closest(".knbn-col").find(".knbn-step-span");
    if (column_title) {
        column_name_span.text(column_title);
    } else {
        column_name_span.text("Название");
    }
    parent.find(".knbn-header").show();
    parent.find(".knbn-header-hidden").hide();
    parent.find(".knbn-lead-step").css("cursor", "grab");
    let column_data = column.data("lead_column");
    if(column_data.title !== column_title){
        console.log(`column - "${column.attr("data-id")}" title was changed: ${column_title}`);
        column.data("lead_column").title = column_title;
    }
    if(column_data.color !== column_color){
        console.log(`column - "${column.attr("data-id")}" color was changed: ${column_color}`);
        column.data("lead_column").color = column_color;
    }
}
function editColumnInfo(target, kanban_type){
    let hidden_header = $(".knbn-header-hidden:visible")
    if(hidden_header.length){
        changeColumnName(hidden_header.find(".knbn-step-input"), kanban_type)
    }
    let parent = target.closest('.knbn-main-col');
    parent.find(".knbn-header").hide();
    parent.find(".knbn-header-hidden").show();
    parent.find(".knbn-step-input").focus();
    parent.find(".knbn-lead-step").css("cursor", "default");
}
 function hideLeadAddPart (target){
     target.closest('li').hide('blind');
     target.closest('li').find('.knbn-plus-cont').find('.add-item').remove();
 }
 function getSelectedLeads(selected_leads){
     let array = [];
     selected_leads.each(function (){
         array.push($(this).attr("data-id"));
     });
    return array;
 }
 function deleteColumn(target) {
     let column = target.closest("li");
     let deleted_id = column.attr("data-id");
     let delete_confirm = confirmDeletion (target.closest("li").find(".knbn-step-span").text());
     delete_confirm.delete_btn.on("click", function (e) {
         delete_confirm.confirm_deletion_popup_cont.hide();
         console.log(deleted_id);
         column.remove();
     });
 }
