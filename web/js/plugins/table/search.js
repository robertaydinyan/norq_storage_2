"use strict";
// there are 7 functions in this file, that are creating table
// 1. "createSearch" get data for table and starts creating search input and filter bar for table
// 2. "createGrandFiltersBlock" draws left part main filters
// 3. "createFilterRightPartHeader" runs through search and header data to draw filter right part header and add field popup
// 4. "filterItemSelect" draws range in filter right part header
// 5. "filterItemSelectTwo" draws select2 in filter right part header
// 6. "searchRange" draws range in filter right part header
// 7. "addSearchListeners" adds listeners to search filter bar and search after they are created
/**
 * "createSearch" get data for table and starts creating search input and filter bar for table
 * @param data
 */
var param = $('meta[name=csrf-param]').attr("content");
var token = $('meta[name=csrf-token]').attr("content");

function createSearch(data) {
    const search_data = data.search;
    //finds in data which main filter is selected by  default
    const draw_right_part = search_data.find(item => item.pinned);
    // "search_div" draws input tag for search

    const search_div = $(`
        <div class="all-search-box">
            <div class = 'search-input-container'>
                <div class ='default-grand'>
                    ${draw_right_part.name}
                </div>
                <input placeholder="ПОИСК" type="text" class="c-input table-search-input" id ='search' autocomplete="off">
                <div class="search-icon"></div>
            </div>
        </div>`);
    // draws  hidden div for filter bar (when search input is clicked toggles search filter bar)
    search_div.append($(`
        <div id = 'filter-bar' class = 'z-four-search-dropdowns'>
            <div class = 'search-filter-container' id = 'table-filter-bar'>
                <div class = 'filter-container-left'>
                    <div class = 'fcl-in'>
                        <div class = 'new-grand-filter'>
                            <div class="c-floating-label">
                                <input id ='new-grand-filter' type = 'text' placeholder='НАЗВАНИЕ ФИЛЬТРА'>
                            </div>
                        </div>
                    </div>
                    <div class = 'add-grand-filter'>
                         <button id = 'add-grand-filter' class="fitlter-settings-button">СОЗДАТЬ ФИЛЬТР</button>
<!--                         <button id = 'change-grand-filter' class = 'fitlter-settings-button'><i class="fas fa-cog"></i></button>-->
                    </div>
                </div>
                <div class = 'filter-container-right'>
                    <div class="search-field-box">
                        <div id = 'add-field-toggle-block'></div>
                        <button  id="table-add-field-btn" class = 'search-field-box button'>добавить</button>
                        <button  id="restore-default-fields" class = 'search-field-box button'>по умалчанию</button>
                    </div>
                    <div class = 'filter-right-part-footer'>
                        <div class = 'filter-footer-shown'>
                            <div>
                                <button id = 'start-search' class = 'c-btn search-first-btn'><i class="fas fa-search"></i> НАЙТИ</button>
                                <button id = 'reset-filter' class = 'c-btn c-btn-ol search-first-btn'>СБРОСИТЬ</button>
                            </div>
                        </div>
                        <div class = 'filter-footer-hidden'>
                            <div>
                                <button id = 'save-filter-fields' class = 'c-btn search-first-btn'>СОХРАНИТЬ</button>
                                <button id = 'filter-footer-cancel' class = 'c-btn c-btn-ol search-first-btn'>ОТМЕНИТЬ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`));

    let add_field_container = $(`<div class="filter-field-drop"></div>`);
    $('.fcl-in', search_div).prepend(createGrandFiltersBlock(search_data));

    $('#add-field-toggle-block', search_div).append(add_field_container);

    $('.filter-container-right', search_div).prepend(createFilterRightPartHeader(draw_right_part.items, data.header, add_field_container));

     setTimeout(() => addSearchListeners(), 10);

    return search_div;
}
/**
 * "createGrandFiltersBlock" draws left part main filters
 * @param search_data
 */
function createGrandFiltersBlock(search_data) {
    var grand_filters_div = $("<div class = 'grand-filters-block'><h5>\u0424\u0418\u041B\u042C\u0422\u0420\u042B</h5></div>");
    search_data.forEach(function (item) {

        if (item.pinned && item.id != '1') {
            setTimeout(function () {
                var filterItemDiv = $(grand_filters_div).closest('.search-filter-container').find('.filter-item-div');
                item.items.forEach(function (i, index) {

                    var elem = $(filterItemDiv).find("[data-name=\"" + i.alias + "\"]");
                    var elemTag = $(elem).prop('tagName');

                    switch (elemTag) {
                        case "SELECT":

                            elem.find("option[value=\"" + i.value + "\"]").attr('selected', 'selected');
                            break;
                        case "INPUT":
                            var elemValue = void 0;
                            i.value === 0 ? elemValue = "" : elemValue = i.value;
                            elem.val(elemValue);
                            break;
                    }
                });
            }, 0);
        }
        grand_filters_div.append($("<div data-grand-id = " + item.id + " class = 'grand-filter-div " + (item.pinned ? 'active_grand' : '') + "'>\n            <div class=\"grand-left-side\">\n                <div><span class = 'grand-span-drug'><i class=\"fas fa-grip-vertical\"></i></span></div>\n                <input class = 'grand-span-name' type=\"text\" value=\"" + item.name.toUpperCase() + "\" readonly>\n            </div>\n            <div class=\"grand-btn-box\">\n                <span class = 'grand-span grand-pinned " + (item.pinned ? 'down active' : '') + "'><i class=\"fas fa-thumbtack\"></i></span> \n                <span class = 'grand-span grand-edit'><i class=\"fas fa-pen\"></i></span> \n                <span class = 'grand-span grand-close'><i class=\"fas fa-times\"></i></span> \n            </div>\n        </div>"));
    });
    $('.grand-close', grand_filters_div).on('click', function () {
        $(this).closest('.grand-filter-div').remove();
    });
    $('.grand-edit', grand_filters_div).on('click', function () {
        $(this).closest('.grand-filter-div').find('.grand-span-name').removeAttr('readonly').addClass('grand-span-name-editing');
    });
    $('.grand-pinned', grand_filters_div).on('click', function () {
        $(this).closest('.grand-filters-block').find('.grand-span').toggleClass("down");
        $(this).toggleClass("down");
    });

    $(grand_filters_div).sortable({
        handle: '.grand-span-drug',
        cancel: '',
        cursor: 'grab',
    });
    $(grand_filters_div).disableSelection();
    return grand_filters_div;
}
/**
 * "createFilterRightPartHeader" runs through search and header data to draw filter right part header and add field popup
 * @param search_data
 * @param header_data
 * @param add_field_container
 */
function createFilterRightPartHeader(search_data, header_data, add_field_container) {
    var filter_right_part_header = $("<div id = 'druggable-container' class = 'filter-right-part-header'></div>");
    header_data.forEach(function (item, index) {
        var list = item.list;
        var visiable_item = search_data[index].is_visible;
        var md = $('.current-module').attr('data-module');
        if((md == '/billing/payment') && (item.alias =='debt' || item.alias =='deal_start' ) || (md == '/billing/client' && item.alias =='status')){
            return false;
        }
        switch (item.type) {
            case 'text':
                filter_right_part_header.append($("<div id = \"" + item.alias + "-asd\" class = 'filter-item-toggle-div' style=\"display:" + (visiable_item ? 'grid' : 'none') + ";\">\n                    <div><button type = 'button'  class = 'druggable-filter hid-btn'><i class=\"fas fa-grip-vertical\"></i></button></div>     \n                    <div class = 'filter-item-div'>\n                        <input type=\"text\" class = 'table-filter-input c-input' data-name=\"" + item.alias + "\" placeholder = '" + item.name + "'>\n                    </div>\n                    <div><button type= 'button' data-close-id = 'field-block-" + item.alias + "' class = 'mid-close-icon hid-btn'><i class=\"fas fa-times\"></i></button></div>\n                </div>"));
                add_field_container.append($("<div class=\"c-checkbox\"  style=\"" + (item.is_visible ? 'display: block' : 'display: none') + "\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                    <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                </div>"));
                break;
            case 'number':
                filter_right_part_header.append($("<div id = \"" + item.alias + "-asd\" class = 'filter-item-toggle-div' style=\"display:" + (visiable_item ? 'grid' : 'none') + ";\">\n                     <div><button type = 'button'  class = 'druggable-filter hid-btn'><i class=\"fas fa-grip-vertical\"></i></button></div>     \n                    <div class = 'filter-item-div'>\n                        <input data-name=\"" + item.alias + "\" class=\"number-input c-input\" type=\"number\"  min=\"" + list.min + "\" max=\"" + list.max + "\" placeholder= \"" + item.name + "\" value= \"" + item.name + "\">\n                    </div>\n                    <div><button type= 'button' data-close-id = 'field-block-" + item.alias + "' class = 'mid-close-icon hid-btn'><i class=\"fas fa-times\"></i></button></div>\n                </div>"));
                add_field_container.append($("\n                    <div class=\"c-checkbox\">\n                        <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                        <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                    </div>\n                "));
                break;
            case 'select':
                filter_right_part_header.append(filterItemSelect(item, search_data[index], visiable_item));
                add_field_container.append($("<div class=\"c-checkbox\" style=\"" + (item.is_visible ? 'display: block' : 'display: none') + "\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                    <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                </div>"));
                break;
            case 'select2':
                filter_right_part_header.append(filterItemSelectTwo(item, search_data[index], visiable_item));
                add_field_container.append($("<div class=\"c-checkbox\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                    <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                 </div>"));
                break;
            case 'number range':
                filter_right_part_header.append(searchRange(item, search_data[index], visiable_item));
                add_field_container.append($("<div class=\"c-checkbox\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                    <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                </div>"));
                break;
            case 'checkbox':
            case 'image':
            case 'icon':
                filter_right_part_header.append($("<div id = \"" + item.alias + "-asd\" class = 'filter-item-toggle-div' style=\"display:" + (visiable_item ? 'grid' : 'none') + ";\">\n                      <div><button type = 'button'  class = 'druggable-filter hid-btn'><i class=\"fas fa-grip-vertical\"></i></button></div>               \n                     <div class = 'c-checkbox'>\n                        <input type = 'checkbox' id = '" + item.alias + "145'  " + (item.is_visible ? "checked" : null) + "/>\n                        <label for = '" + item.alias + "145' >" + item.name + "</label>\n                    </div>\n                    <div><button type= 'button' data-close-id = 'field-block-" + item.alias + "' class = 'mid-close-icon hid-btn'><i class=\"fas fa-times\"></i></button></div>\n                </div>"));
                add_field_container.append($("<div class=\"c-checkbox\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                    <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                </div>"));
                break;
            case 'date':
                filter_right_part_header.append($("<div id = \"" + item.alias + "-asd\" class = 'filter-item-toggle-div' style=\"display:" + (visiable_item ? 'grid' : 'none') + ";\">\n                     <div><button type = 'button'  class = 'druggable-filter hid-btn'><i class=\"fas fa-grip-vertical\"></i></button></div>              \n                     <div class = 'filter-item-div'>\n                        <span class=\"filter-item-title\">" + item.name + "</span>\n                        <input type=\"date\" value = \"" + item.list['value'] + "\" class=\"c-input\">\n                     </div> \n                    <div><button type= 'button' data-close-id = 'field-block-" + item.alias + "' class = 'mid-close-icon hid-btn'><i class=\"fas fa-times\"></i></button></div>\n                </div>"));
                add_field_container.append($("<div class=\"c-checkbox\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                     <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                </div>"));
                break;
            case 'date range':
                filter_right_part_header.append($("<div id = \"" + item.alias + "-asd\" class = 'filter-item-toggle-div' style=\"display:" + (visiable_item ? 'grid' : 'none') + ";\">\n                     <div><button type = 'button'  class = 'druggable-filter hid-btn'><i class=\"fas fa-grip-vertical\"></i></button></div>                \n                     <div class = 'filter-item-div filter-item-block'>\n                        <span class=\"filter-item-title\">" + item.name + "</span>\n                        <label class=\"filter-item-title-label\" for = \"" + item.alias + "2\" >Start Date</label>\n                        <input type=\"date\" id = \"" + item.alias + "1\" value = \"" + item.list['value1'] + "\" class=\"c-input\">\n                        <label class=\"filter-item-title-label\" for = \"" + item.alias + "2\" >End Date</label>\n                        <input type=\"date\" id = \"" + item.alias + "1\" value = \"" + item.list['value2'] + "\" class=\"c-input\">\n                     </div> \n                     <div><button type= 'button' data-close-id = 'field-block-" + item.alias + "' class = 'mid-close-icon hid-btn'><i class=\"fas fa-times\"></i></button></div>\n                </div>"));
                add_field_container.append($("<div class=\"c-checkbox\">\n                    <input type = 'checkbox' id = 'field-block-" + item.alias + "' class=\"add-field-label\"  data-mid = " + item.alias + "  " + (visiable_item ? "checked" : null) + "/>\n                    <label for = 'field-block-" + item.alias + "' >" + item.name + "</label>\n                </div>"));
                break;
            case 'link':
            case 'action':
            case 'status':
            case 'html':
                console.log('type is link, action, status, html');
                break;
            default:
                console.error("type: " + item.type + " - is unknown");
        }
    });
    $('.add-field-label', add_field_container).on('click', function () {
        var elem = $(this).attr('data-mid');
        $("#" + elem + "-asd").toggle();
        var data = {};
        var str = '';
        var active_grand = $('.active_grand').attr('data-grand-id');
        if (parseInt(active_grand) == 1) {
            $('.search-field-box .add-field-label').each(function () {
                if ($(this).is(':checked')) {
                    str += $(this).attr('data-mid') + '-true,';
                }
                else {
                    str += $(this).attr('data-mid') + '-false,';
                }
            });
        }
        else {
            $('.filter-item-toggle-div').each(function () {
                var val = $(this).find('input,select').val();
                if (!val) {
                    val = '';
                }
                if ($(this).css('display') == 'grid') {
                    str += $(this).attr('id').replace("-asd", "") + '-true|' + val + ',';
                }
                else {
                    str += $(this).attr('id').replace("-asd", "") + '-false|' + val + ',';
                }
            });
        }
        data['page'] = $('.current-module').attr('data-module');
        var active_grand = $('.active_grand').attr('data-grand-id');
        data['str_search'] = str;
        data['active'] = active_grand;
        let active_page = $('.current-module').attr('data-module');
        $.ajax({
            url:active_page+'/update-search',
            data: {data: data,param:token},
            method: 'post',
            dataType: 'json'
        });

    });
    $('.mid-close-icon', filter_right_part_header).on('click', function () {
        $(this).closest('.filter-item-toggle-div').hide();
        var elem = $(this).attr('data-close-id');
        var data = {};
        var str = '';
        $('.search-field-box .add-field-label').each(function () {
            if ($(this).is(':checked')) {
                str += $(this).attr('data-mid') + '-true,';
            }
            else {
                str += $(this).attr('data-mid') + '-false,';
            }
        });
        data['page'] = $('#w1 .nav-item .active').attr('href');
        var active_grand = $('.active_grand').attr('data-grand-id');
        data['str_search'] = str;
        data['active'] = active_grand;
        let active_page = $('#w1 .nav-item .active').attr('href');
        $.ajax({
            url:active_page+'/update-search',
            data: {data: data,param:token},
            method: 'post',
            dataType: 'json'
        });
        $("#" + elem).prop("checked", false);
    });


    $(filter_right_part_header).sortable({
        handle: '.druggable-filter',
        cancel: '',
        placeholder: 'search-sore-placeholder',
        axis: 'y',
        cursor: 'grab',
    });
    $(filter_right_part_header).disableSelection();
    return filter_right_part_header;
}
/**
 * "filterItemSelect" draws range in filter right part header
 * @param item
 * @param search_item
 */
function filterItemSelect(item, search_item) {
    let select_div = $(`     
        <div id='`+ item.alias + `-asd' class="filter-item-toggle-div" style="display:grid;"> 
        <div><button type="button" class="druggable-filter hid-btn"><i class="fas fa-grip-vertical"></i></button></div>
        <div  class = 'filter-item-div'>
            <select data-name="`+ item.alias + `"  class = 'single-select form-control'></select>
        </div></div>`);
    $('select', select_div).append($(`<option value="0">${item.name}</option>`));

    let length = item.list.length;
    let list = item.list;
    for (let i = 0; i < length; i++) {
        let option = list[i];
        $('select', select_div).append($(`<option value="${option.value}">${option.name}</option>`));
    }
    return select_div;
}
/**
 * "filterItemSelectTwo" draws select2 in filter right part header
 * @param item
 * @param search_item
 */
function filterItemSelectTwo(item, search_item) {
    let select_two_div = $(`           
        <div class = 'filter-item-div'>
           <select class="select2-selection--multiple js-states form-control" multiple="multiple"></select>
        </div>`);

    let list_length = item.list.list.length;
    let value_length = item.list.value.length;
    $('select', select_two_div).append($(`<option></option>`));
    for (let i = 0; i < list_length; i++) {
        let isSelected = false;
        let option = item.list.list[i];
        for (let j = 0; j < value_length; j++) {
            let val = item.list.value[j];
            if (val === i) {
                isSelected = true;
                break;
            }
        }
        if (isSelected) {
            $('select', select_two_div).append($(`<option value="${option.value}" selected>${option.name}</option>`));
        }
        else {
            $('select', select_two_div).append($(`<option value="${option.value}">${option.name}</option>`));
        }
    }
    $(".select2-selection--multiple", select_two_div).select2({
        placeholder: item.name,
        width: '100%',
    });
    return select_two_div;
}
/**
 * "searchRange" draws range in filter right part header
 * @param item
 * @param search_item
 */
function searchRange(item, search_item) {
    let list = item.list;
    let range_tooltip_right = $(`<div class = 'ui-tooltip tooltip-right'>${list.value1}</div>`);
    let range_tooltip_left = $(`<div class = 'ui-tooltip tooltip-right'>${list.value2}</div>`);
    let search_range = $(`            
            <div class = 'filter-item-div filter-range'>
                <div>
                     <label for="${item.alias}">${item.name}:</label>
                     <input type="text" id="${item.alias}" readonly style="border:0;">
                </div>
                <div id="${item.alias}-slider-range"></div>
            </div>`);
    $(`#${item.alias}-slider-range`, search_range).slider({
        range: true,
        min: list.min,
        max: list.max,
        step: list.step,
        values: [list.value1, list.value2],
        slide: function (event, ui) {
            $(`#${item.alias}`, search_range).val(`${ui.values[0]} - ${ui.values[1]}`);
            range_tooltip_left.text(ui.values[1]);
            range_tooltip_right.text(ui.values[0]);
        }
    }).find(".ui-slider-handle").each(function (key, value) {
        key !== 0 ? value.append(range_tooltip_left[0]) : value.append(range_tooltip_right[0]);
    });
    $(`#${item.alias}`, search_range).val($(`#${item.alias}-slider-range`, search_range).slider("values", 0) +
        " - " + $(`#${item.alias}-slider-range`, search_range).slider("values", 1));
    return search_range;
}
/*
 * "addSearchListeners" adds listeners to search filter bar and search
 */
function addSearchListeners() {

    let html_body = $('body');
    //======================== toggles filter bar by clicking on search input
    $('.all-search-box .search-input-container').on('click', function () {
        $('#filter-bar').toggle();
    });

    $('#start-search').on('click', function () {

        var dataSeach = '';
        $('.filter-item-toggle-div').each(function () {
            if ($(this).css('display') != 'none') {
                var name_1 = $(this).attr('id');
                var value = $(this).find('input,select').val();
                if (value && value != 0) {
                    dataSeach += name_1.replace("-asd", "") + '|' + value + ',';
                }
            }
        });
        let page = parseInt($('.c-select').val());

        let active_page = $('.main-header .nav-item .active').attr('href').replace("/index", "");
        let _csrf = $('#csrf').val();
        let _csrfN = $('#csrfN').val();

        $.ajax({
            url:active_page+'/page',
            data: {page: page,dataSearch:dataSeach,param:token},
            method: 'post',
            dataType: 'json',
            success: function (data) {
                if(data != null) {
                    $('.tableSection').html(createTable(data));
                } else {
                    $('.z6-table-body').html('<tr><td colspan="5"><h2 style="text-align: center;">Поиск не дал результатов</h2></td></tr>');
                }
            }
        });

        $('#filter-bar').toggle();
        return false;
    });
    if(parseInt($('.active_grand').attr('data-grand-id')) != 1){
        updateSearch();
    }
    //======================== opens buttons (pin, edit, delete) on filter bar left part, main filter section
    $('.all-search-box #change-grand-filter').on('click', function () {
        $('.grand-span-drug').show();
        $(`.grand-span`).show();
        $(`.filter-footer-shown`).hide();
        $(`.filter-footer-hidden`).show();
        $('#add-grand-filter').prop('disabled', true);
        $('#change-grand-filter').prop('disabled', true);
        $('.grand-filter-div').addClass('grand-toggle');
    });
    //========================
    $('.all-search-box .grand-toggle').on('click', function () {
        console.log(1);
        // $('.grand-filter-div').removeClass('grand-filter-toggle');
        $(this).addClass('grand-filter-toggle');
    });
    //======================== opens input that adds new main filter
    $('.all-search-box #add-grand-filter').on('click', function () {
        $(`.new-grand-filter`).show();
        $(`.filter-footer-shown`).hide();
        $(`.filter-footer-hidden`).show();
        $('#add-grand-filter').prop('disabled', true);
        $('#change-grand-filter').prop('disabled', true);
    });
    //======================== opens popup with checkboxes on filter bar right part header that add fields
    $('.all-search-box #table-add-field-btn').on('click', function () {
        $('#add-field-toggle-block').toggle();
    });
    //======================== must restore
    $('.all-search-box #restore-default-fields').on('click', function () {
        alert('must get data and draw search right part header');
    });
    //======================== cancels left part actions
    $('.all-search-box #filter-footer-cancel').on('click', function () {
        $(`.grand-span`).hide();
        $('.grand-span.down').show();
        $('.grand-span-drug').hide();
        $('.grand-span-name').prop('readonly', true);
        $('#add-grand-filter').prop('disabled', false);
        $('#change-grand-filter').prop('disabled', false);
        $(`.new-grand-filter`).hide();
        $(`.filter-footer-shown`).show();
        $(`.filter-footer-hidden`).hide();
        $(`#new-grand-filter`).val('');
        $('.grand-filter-div').removeClass('grand-toggle');
    });

    $('.grand-filter-div').on('click', function () {
        var data = {};
        var pin = parseInt($(this).attr('data-grand-id'));
        let active_page = $('.main-header .nav-item .active').attr('href').replace("/index", "");
        data['pin'] = pin;
        $.ajax({
            url:active_page+'/update-table',
            data: {data: data,param:token},
            method: 'post',
            dataType: 'json',
            success:function () {
                window.location.reload();
            }
        });

    });
    //======================== saves left part actions
    $('.all-search-box #save-filter-fields').on('click', function () {
        const grand_span_drug = $('grand-span-drug');
        let shown_footer = true;
        var data = {};
        var str_1 = '';
        $('.filter-item-toggle-div').each(function () {
            var val = $(this).find('input,select').val();
            if (!val) {
                val = '';
            }
            if ($(this).css('display') == 'grid') {
                str_1 += $(this).attr('id').replace("-asd", "") + '-true|' + val + ',';
            }
            else {
                str_1 += $(this).attr('id').replace("-asd", "") + '-false|' + val + ',';
            }
        });
        data['page'] = $('.main-header .nav-item .active').attr('href').replace("/index", "");
        data['str_search'] = str_1;
        data['active'] = -1;
        data['name'] = $(`#new-grand-filter`).val();
        let active_page = $('.main-header .nav-item .active').attr('href').replace("/index", "");
        $.ajax({
            url:active_page+'/update-search',
            data: {data: data,param:token},
            method: 'post',
            dataType: 'json'
        });
        if (grand_span_drug.is(":visible")) {
            alert('changes are saved');
            $(`.grand-span`).hide();
            $('.grand-span.down').show();
            $('.grand-span-name').prop('readonly', true);
            grand_span_drug.hide();
        }
        else {
            let new_grand_filter = $(`#new-grand-filter`);
            let new_grand_filter_value = new_grand_filter.val();
            if (new_grand_filter_value) {
                $('.new-grand-filter').hide();
                new_grand_filter.val('');
                $(`.grand-filters-block`).append($(`
                <div data-grand-id = "${new_grand_filter_value}" class = 'grand-filter-div'>
                    <div><span class = 'grand-span-drug'><i class="fas fa-ellipsis-v"></i></span></div>
                    <input class = 'grand-span-name' type="text" value="${new_grand_filter_value.toUpperCase()}" readonly>
                    <span class = 'grand-span grand-pinned'><i class="fas fa-thumbtack"></i></span>
                    <span class = 'grand-span grand-edit'><i class="fas fa-pen"></i></span>
                    <span class = 'grand-span grand-close'><i class="fas fa-times"></i></span>
                </div>`));
            }
            else {
                alert('you need to give name');
                shown_footer = false;
            }
        }
        if (shown_footer) {
            $('#add-grand-filter').prop('disabled', false);
            $('#change-grand-filter').prop('disabled', false);
            $(`.filter-footer-shown`).show();
            $(`.filter-footer-hidden`).hide();
        }
    });
    //======================== must return to default values of main filter
    $('.all-search-box #reset-filter').on('click', function () {
        $('.search-filter-container .filter-container-right').find('input').val('');
        $('.search-filter-container .filter-container-right').find('select').val(0).change();
    });
    //======================== deletes current main filter
    $('.main-filters .grand-close').on('click', function () {
        $(this).closest('.grand-filter-div').remove();
    });
    //======================== makes current main filter editable
    $('.main-filters .grand-edit').on('click', function () {
        $(this).closest('.grand-filter-div').find('input').removeAttr('readonly');
        $(this).closest('.grand-filter-div').addClass('editable-filter');
    });
    //========================
    $('.main-filters .grand-pinned').on('click', function () {
        $(this).closest('.grand-filters-block').find('.down').toggleClass("down");
        $(this).toggleClass("down");
    });
    //======================== toggles right part filter field
    $('.filter-field-drop .add-field-label').on('click', function () {
        const elem = $(this).attr('data-mid');
        $(`#${elem}`).toggle();
    });
    //======================== hides right part filter field
    $('#draggable-container .mid-close-icon').on('click', function () {
        $(this).closest('.filter-item-toggle-div').hide();
        var elem = $(this).attr('data-close-id');
        var data = {};
        var str = '';
        $('.search-field-box .add-field-label').each(function () {
            if ($(this).is(':checked')) {
                str += $(this).attr('data-mid') + '-true,';
            }
            else {
                str += $(this).attr('data-mid') + '-false,';
            }
        });
        data['page'] =  $('.main-header .nav-item .active').attr('href').replace("/index", "");
        var active_grand = $('.active_grand').attr('data-grand-id');
        data['str_search'] = str;
        data['active'] = active_grand;
        let active_page = $('.current-module').attr('data-module');
        $.ajax({
            url:active_page+'/update-search',
            data: {data: data,param:token},
            method: 'post',
            dataType: 'json'
        });
        $("#" + elem).prop("checked", false);
    });
    //======================== left part main filters are draggable
    $('.grand-filters-block .main-filters').sortable({
        //@ts-ignore
        containerSelector: '.main-filters',
        placeholder: "<div class = 'placeholder'></div>",
        itemSelector: '.grand-filter-div',
        pullPlaceholder: true,
        handle: '.grand-span-drug',
        axis: "y",
        onDrag: function ($item, position, _super) {
            $item.css(position);
        }
    }).disableSelection();
    //======================== right part filter field are draggable
    $('.filter-right-part-header').sortable({
        //@ts-ignore
        containerSelector: '.filter-right-part-header',
        handle: '.draggable-filter',
        axis: "y",
        itemSelector: '.filter-item-toggle-div',
        pullPlaceholder: true,
        placeholder: '<div class = "placeholder"></div>',
        afterMove: function ($placeholder) {
            $placeholder.css({
                height: "50px",
                width: 'auto',
            });
        },
        //@ts-ignore
        onDrop: function ($item, container, _super) {
            _super($item, container);
        }
    }).disableSelection();
    html_body.on('click', function (e) {
        //========================  closes popup with checkboxes on filter bar right part header that add fields
        if (!$(e.target).closest('#add-field-toggle-block, #table-add-field-btn').length) {
            $(`#add-field-toggle-block`).hide();
        }
        //========================
        if (!$(e.target).closest('.editable-filter').length) {
            $('.editable-filter').find('input').attr('readonly', 'true');
            $('.grand-filter-div').removeClass('editable-filter');
        }
    });
}
function updateSearch(){
    var dataSeach = '';
    $('.filter-item-toggle-div').each(function () {
        if ($(this).css('display') != 'none') {
            var name_1 = $(this).attr('id');
            var value = $(this).find('input,select').val();
            if (value && value != 0) {
                dataSeach += name_1.replace("-asd", "") + '|' + value + ',';
            }
        }
    });
    let page = parseInt($('.c-select').val());

    let active_page = $('.main-header .nav-item .active').attr('href').replace("/index", "");
    let _csrf = $('#csrf').val();
    let _csrfN = $('#csrfN').val();

    $.ajax({
        url:active_page+'/page',
        data: {page: page,dataSearch:dataSeach,param:token},
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if(data != null) {
                $('.tableSection').html(createTable(data));
            } else {
                $('.z6-table-body').html('<tr><td colspan="5"><h2 style="text-align: center;">Поиск не дал результатов</h2></td></tr>');
            }
        }
    });

    return false;
}
