"use strict";
// there are 11 functions in this file, that are creating table
// 1. "createTable" == starts creating table
// 2. "drawHeaderData" == creates thead for table
// 3. "drawHeaderMenu" == creates dropdown menu for thead
// 4. "drawBodyData" == creates tbody for table
// 5. "drawBodyMenu" == creates dropdown menus for tbody
// 6. "tableStatusCreator" == creates status td cell in tbody>tr if type is status
// 7. "createTableFooter" ==  creates section that draws pagination etc
// 8. "createPagination" draws pagination for table
// 9. "creatFooterCountByPage" draws select to choose how many rows must be shown in table
//10. "tableFooterOption" draws select in table footer
//11. "addTableListeners" hangs listeners on table after it is created
/**
 * "createTable" starts creating table
 * @param table_data
 */
function createTable(table_data , type_ = false) {

    const html_table = $(`<table class ='toggle-entire-cols'></table>`);
    function isEmpty(obj) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
    if (isEmpty(table_data)) {
        console.error('data is empty object');
    }
    else {
        if (!Array.isArray(table_data.header) || !table_data.header.length) {
            console.error('data["header"] is empty array [] or is not an array or is not defined ');
        }
        else {
            //=======start creating thead by giving data.header

            try {
                html_table.append(drawHeaderData(table_data['header'], (!Array.isArray(table_data.body)) ? 0 : table_data['body'].length, table_data['multiselect'], table_data['draggable'], table_data['sort']));
            } catch (err) {
                console.error(`Error occurred reading data['header']`, err.message, err.name);
            }

            if (!Array.isArray(table_data.body) || !table_data.body.length) {
                console.error('data["body"] is empty array [] or is not an array or is not defined');
            }
            else {
                try {
                    //=======start creating tbody by giving data.body, data.header and data.menu
                    html_table.append(drawBodyData(table_data['body'], table_data['header'], table_data['menu'], table_data['number'], table_data['multiselect'], table_data['draggable']));
                }
                catch (err) {
                    console.error(`Error occurred reading data['body']`, err.message, err.name);
                }
            }
        }
    }
    if(type_ == false) {
        let table_footer = $('.tableFooterSection');
        table_footer.html(createTableFooter(table_data['pagination'], table_data['option_data']));
    } else {
        setTimeout(function () {
            $('.popup .z963 .tableFooterSection').html(createTableFooter(table_data['pagination'], table_data['option_data']));
            $('.tf-first-section').hide();
            $('.tf-second-section').css('border-top','0px');
        },300);

    }
    setTimeout(() => addTableListeners(), 400);
    return html_table;
}
/**
 * "drawHeaderData" draws thead in table
 * @param data
 * @param length
 * @param multiselect
 * @param draggable
 */
function drawHeaderData(data, length, multiselect, draggable, sort = true) {

    let html_table_head = $(`<thead class = 'sorted_head'></thead>`);
    //=======create first two cells in thead>tr
    let html_table_tr = $(`<tr class = "drag-thead-cell"><th style="width: 50px"><span>&#8470;</span></th></tr>`);
    if (multiselect) {
        html_table_tr.prepend($(`<th style="width: 50px">
            <label class="c-label-checkbox">
                <input type="checkbox" class="table-multi-check">
                <span></span>
            </label>
        </th>`));
    }
    if (length > 1 && draggable) {
        html_table_tr.prepend($(`<th style="width: 50px"></th>`));
    }
    //create dropdown menu cell (th)
    let drop_th = $(`<th style="width: 50px"><button class = 'tbl-header-btn'><i class="fas fa-cog"></i></button></th>`);
    //=======calls function that creates dropdown menu and appends hidden menu to th
    drop_th.append(drawHeaderMenu(data));
    //appends th to thead>tr
    html_table_tr.append(drop_th);
    //======= from here starts creating rest th-cells running through table data
    data.forEach((th) => {
        var md = $('.current-module').attr('data-module');
        if((md == '/billing/client') && (th['alias'] =='status')){
            return false;
        }
        let header_cell = $(`<th class = 'ui-resizable drag-sort' data-column="${th['alias']}" ${th['sort'] ? 'data-sort = "'+th['sort']+'"' : 'data-sort = "NONE"'} ></th>`);
        header_cell.css({
            'display': `${th['is_visible'] ? 'table-cell' : 'none'}`,
            'width': `${th['width'] + th['width_unit']}`,
        });
        //=======switch checks the type of data for current cell
        switch (th['type']) {
            case 'icon':
                header_cell.append($(`<div class = 'col-drag'><i class = "${th['class']}"></i></div>`));
                break;
            case 'image':
                header_cell.append($(`<div class = 'col-drag'><img src = "${th['link']}" alt = "${th['name']}" class = 'thead-img'></div>`));
                break;
            case 'html':
                if(sort != false || th['sort_show'] != false) {

                    if(th['sort'] == 'ASC'){
                        header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-down"></i></div>${th['name']}</div>`));
                    } else if(th['sort'] == 'DESC'){
                        header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-up"></i></div>${th['name']}</div>`));
                    } else {
                        header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></div>${th['name']}</div>`));
                    }
                } else {
                    header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"></div>${th['name']}</div>`));
                }
                break;
            default:

                if(sort != false && th['sort_show'] != false) {
                    if(th['sort'] == 'ASC'){
                        header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-down"></i></div>${th['name']}</div>`));
                    } else if(th['sort'] == 'DESC'){
                        header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-up"></i></div>${th['name']}</div>`));
                    } else {
                        header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></div>${th['name']}</div>`));
                    }
                } else {
                    header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"></div><span>${th['name']}</span></div>`)); //<input type = 'text' value = "${th['name']}" readonly/>

                }
        }
        html_table_tr.append(header_cell);
    });
    html_table_head.append(html_table_tr);
    return html_table_head;
}
/**
 * "drawHeaderMenu" draws dropdown menu in thead>tr>3-rd td
 * @param data
 */
function drawHeaderMenu(data) {
    let header_hidden_menu = $(`<div class = 'table-header-menu'></div>`);
    let header_drop_menu = $(`<div></div>`);
    //======= runs through table header-data and draws checkboxes that will toggle relevant columns
    data.forEach((item) => {
        var md = $('.current-module').attr('data-module');
        if((md == '/billing/client') && (item['alias'] =='status')){
            return false;
        }
        header_drop_menu.append($(`<div class="header-menu-item" >
            <div class="c-checkbox">
                <input type="checkbox"  class = 'tbl-menu-checkbox' name = "${item['alias']}" id="${item['alias']}" ${item['is_visible'] ? 'checked' : ''}>
                <label for = "${item['alias']}"> ${item['name']} </label>
            </div>
        </div>`));
    });
    header_hidden_menu.append(header_drop_menu);
    return header_hidden_menu;
}
/**
 * "drawBodyData" draws tbody in table
 * @param data
 * @param columns
 * @param body_menu
 * @param sort
 * @param multiselect
 * @param draggable
 */
function drawBodyData(data, columns, body_menu, sort, multiselect, draggable) {
    let html_table_body = $(`<tbody class = 'z6-table-body' data-asc-desc = '${sort}'></tbody>`);
    let num = data.length; // num is maximum table body rows that will be reversed
    let length = num;


    // ======================== runs through body data to draw table rows
    data.forEach(function (table_tr, tr_index) {

        //======================== creates tr and first two cells in tbody>tr
        let html_table_tr = $(`<tr data-row = "${table_tr['order']}" class = 'tbody-row'><td class="num-column"><span>${sort === 'ASC' ? tr_index + 1 : num--}</span></td></tr>`);
        if (multiselect) {
            html_table_tr.prepend($(`<th>
                <label class="c-label-checkbox">
                    <input type="checkbox" class="table-single-check">
                    <span></span>
                </label>
            </th>`));
        }
        if (length >= 1 && draggable) {
            html_table_tr.prepend($(`<td class="dragger-td"><button type = 'button' class = 'draggable-column table-row-dragger'><i class="fas fa-grip-vertical"></i></button></td>`));
        }
        //======================== create dropdown menu cell (td)
        let drop_td = $(`<td><button class = 'tbody-menu-btn'><i class="fas fa-bars"></i></button></td>`);
        //======================== calls function that creates dropdown menu and appends hidden menu to td
        drop_td.append(drawBodyMenu(body_menu, table_tr['id'], table_tr['document_type_id']));
        html_table_tr.append(drop_td);
        columns.forEach((td, td_index) => {
            var md = $('.current-module').attr('data-module');
            if((md == '/billing/client') && (td['alias'] =='status')){
                return false;
            }
            let r;
            if(td['type'] =='text'){
                r = "<input class='td-input' value='' autocomplete='off'>";
            } else {

                let optionHtml = '';

                $.each( td['list'], function (k, v) {
                    if(v.value != td['value'] ) {
                        optionHtml += `<option value="${v.id}">${v.value}</option>`;
                    } else {
                        optionHtml += `<option selected value="${v.id}">${v.value}</option>`;
                    }
                } );
                r = "<select class='td-input'><option>"+optionHtml+"</option></select>";
            }
            html_table_tr.append($(`<td id = "edit-${tr_index}${td_index}" class = 'tbody-cell' data-column="${td['alias']}" style = "display: ${td['is_visible'] ? 'table-cell' : 'none'}; text-align : ${td['align']}"><span class="empty-cell">-</span>${td.editable ? r : ''}</td>`));
        });
        //======================== runs through body-data nested arrays to create rest tbody>tr td
        table_tr['items'].forEach(function (td) {

            //======================== switch checks the type of data for current cell if type is not recognised draws 'unknown'
            let tbody_cell = html_table_tr.find(`[data-column='${td['alias']}']`);
            let append = null;
            let input_append = null;
            let empty = false;

            switch (td.type) {
                case 'select':
                    let optionsHtml = '';
                    var value_ = td['value'];
                    $.each( td['list'], function (k, v) {
                        if(v.value != parseInt(td['value'])) {
                            optionsHtml += `<option value="${v.id}">${v.value}</option>`;
                        } else {
                            optionsHtml += `<option selected value="${v.id}">${v.value}</option>`;
                            value_ = v.name;
                        }
                    } );

                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${value_}</span>`);
                    if(td['editable']) {
                        input_append = $(`<select data-edit = 'td-input' class = 'td-input' value = "${td['value']}">${optionsHtml}</select>`);
                    }
                    empty = true;
                    break;
                case 'number':
                case 'number range':
                case 'text':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${td['value']}</span>`);
                    if(td['editable']) {
                        input_append = $(`<input data-edit = 'td-input' class = 'td-input' value = "${td['value']}">`);
                    }
                    empty = true;
                    break;
                case 'date':
                case 'date range':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${td['value']}</span>`);
                    input_append = $(`<input data-edit = 'td-input' class = 'td-input c-calendar' type="date" value = "${td['value']}"/>`);
                    empty = true;
                    break;
                case 'checkbox':
                    append = $(`
                        <label class="c-label-checkbox">
                            <input type="checkbox" ${td['value'] ? 'checked' : 'none'}>
                            <span></span>
                        </label>
                    `);
                    empty = true;
                    break;
                case 'image':
                    append = $(`<img class = 'tbody-img' src="${td['link']}" alt=${td['value']}>`);
                    empty = true;
                    break;
                case 'html':
                    append = $(td['value']);
                    empty = true;
                    break;
                case 'icon':
                    append = $(`<i class = "${td['link']}"></i>`);
                    empty = true;
                    break;
                case 'link':
                    append = $(`<a href="${td['link']}">${td['value']}</a>`);
                    input_append = '';
                    empty = true;
                    break;
                case 'action':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span' onclick="${td['link']}(${table_tr['id']})">${td['value']}</span>`);
                    input_append = $(`<input data-edit = 'td-input' class = 'td-input' value = "${td['value']}">`);
                    empty = true;
                    break;
                case 'status':
                    append = tableStatusCreator(td['value']);
                    empty = true;
                    break;
                default:
                    console.error(`type: ${td['type']} is not defined`, '[data type ERROR]');
            }
            if (empty) {
                tbody_cell.empty();
            }
            if (append) {
                tbody_cell.append(append);
                if (input_append) {
                    tbody_cell.append(input_append);
                }
            }
            if (td['class']) {
                tbody_cell.addClass(td['class']);
            }
        });
        html_table_body.append(html_table_tr);
    });
    return html_table_body;
}
function drawBodyDataWithoutTag(data, columns, body_menu, sort, multiselect, draggable) {
    let html_table_body = '';
    let num = data.length; // num is maximum table body rows that will be reversed
    let length = num;


    // ======================== runs through body data to draw table rows
    data.forEach(function (table_tr, tr_index) {
        //======================== creates tr and first two cells in tbody>tr
        let html_table_tr = $(`<tr data-row = "${table_tr['order']}" class = 'tbody-row'><td class="num-column"><span>${sort === 'ASC' ? tr_index + 1 : num--}</span></td></tr>`);
        if (multiselect) {
            html_table_tr.prepend($(`<th>
                <label class="c-label-checkbox">
                    <input type="checkbox" class="table-single-check">
                    <span></span>
                </label>
            </th>`));
        }
        if (length >= 1 && draggable) {
            html_table_tr.prepend($(`<td class="dragger-td"><button type = 'button' class = 'draggable-column table-row-dragger'><i class="fas fa-grip-vertical"></i></button></td>`));
        }
        //======================== create dropdown menu cell (td)
        let drop_td = $(`<td><button class = 'tbody-menu-btn'><i class="fas fa-bars"></i></button></td>`);
        //======================== calls function that creates dropdown menu and appends hidden menu to td
        drop_td.append(drawBodyMenu(body_menu, table_tr['id'],table_tr['document_type_id']));
        html_table_tr.append(drop_td);
        columns.forEach((td, td_index) => {
            let r;
            if(td['type'] =='text'){
                r = "<input class='td-input' value='' autocomplete='off'>";
            } else {

                let optionHtml = '';
                $.each( td['list'], function (k, v) {
                    if(v.value != td['value'] ) {
                        optionHtml += `<option value="${v.id}">${v.value}</option>`;
                    } else {
                        optionHtml += `<option selected value="${v.id}">${v.value}</option>`;
                    }
                } );
                r = "<select class='td-input'><option>"+optionHtml+"</option></select>";
            }
            html_table_tr.append($(`<td id = "edit-${tr_index}${td_index}" class = 'tbody-cell' data-column="${td['alias']}" style = "display: ${td['is_visible'] ? 'table-cell' : 'none'}; text-align : ${td['align']}"><span class="empty-cell">-</span>${td.editable ? r : ''}</td>`));
        });
        //======================== runs through body-data nested arrays to create rest tbody>tr td
        table_tr['items'].forEach(function (td) {

            //======================== switch checks the type of data for current cell if type is not recognised draws 'unknown'
            let tbody_cell = html_table_tr.find(`[data-column='${td['alias']}']`);
            let append = null;
            let input_append = null;
            let empty = false;

            switch (td.type) {
                case 'select':
                    let optionsHtml = '';
                    $.each( td['list'], function (k, v) {
                        if(v.value != td['value'] ) {
                            optionsHtml += `<option value="${v.id}">${v.value}</option>`;
                        } else {
                            optionsHtml += `<option selected value="${v.id}">${v.value}</option>`;
                        }
                    } );
                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${td['value']}</span>`);
                    if(td['editable']) {
                        input_append = $(`<select data-edit = 'td-input' class = 'td-input' value = "${td['value']}">${optionsHtml}</select>`);
                    }
                    empty = true;
                    break;
                case 'number':
                case 'number range':
                case 'text':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${td['value']}</span>`);
                    if(td['editable']) {
                        input_append = $(`<input data-edit = 'td-input' class = 'td-input' value = "${td['value']}">`);
                    }
                    empty = true;
                    break;
                case 'date':
                case 'date range':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${td['value']}</span>`);
                    input_append = $(`<input data-edit = 'td-input' class = 'td-input c-calendar' type="date" value = "${td['value']}"/>`);
                    empty = true;
                    break;
                case 'checkbox':
                    append = $(`
                        <label class="c-label-checkbox">
                            <input type="checkbox" ${td['value'] ? 'checked' : 'none'}>
                            <span></span>
                        </label>
                    `);
                    empty = true;
                    break;
                case 'image':
                    append = $(`<img class = 'tbody-img' src="${td['link']}" alt=${td['value']}>`);
                    empty = true;
                    break;
                case 'html':
                    append = $(td['value']);
                    empty = true;
                    break;
                case 'icon':
                    append = $(`<i class = "${td['link']}"></i>`);
                    empty = true;
                    break;
                case 'link':
                    append = $(`<a href="${td['link']}">${td['value']}</a>`);
                    input_append = '';
                    empty = true;
                    break;
                case 'action':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span' onclick="${td['link']}(${table_tr['id']})">${td['value']}</span>`);
                    input_append = $(`<input data-edit = 'td-input' class = 'td-input' value = "${td['value']}">`);
                    empty = true;
                    break;
                case 'status':
                    append = tableStatusCreator(td['value']);
                    empty = true;
                    break;
                default:
                    console.error(`type: ${td['type']} is not defined`, '[data type ERROR]');
            }
            if (empty) {
                tbody_cell.empty();
            }
            if (append) {
                tbody_cell.append(append);
                if (input_append) {
                    tbody_cell.append(input_append);
                }
            }
            if (td['class']) {
                tbody_cell.addClass(td['class']);
            }
        });
        html_table_body+= '<tr class="tbody-row">'+html_table_tr.html()+'</tr>';
    });
    return html_table_body;
}
/**
 * "drawBodyMenu" draws menu in tbody>tr>3-rd td
 * @param menu
 * @param id
 */
function drawBodyMenu(menu, id, type_id) {
    let body_hidden_menu = $(`<div class = 'table-body-menu'></div>`);
    let body_drop_menu = $(`<div></div>`);
    try {
        //======= runs through table menu-data and rows relevant fields
        menu.forEach(function (item) {
            var url = '#';

            if(item['url']){
                url = item['url']+'/'+id;

                if (item['method'] == 'post') {
                    body_drop_menu.append($(`<a style="cursor:pointer;display: block;" data-confirm="${item['confirm']}" data-method="${item['method']}" href="${url}" title="${item['form']}">${item['value']}</a>`));
                } else {
                    body_drop_menu.append($(`<button style="cursor:pointer;display: block;padding:0;text-align:left;" class="showModalButton" data-confirm="${item['confirm']}" data-method="${item['method']}" value="${url}" title="${item['form']}">${item['value']}</button>`));
                }

            } else {
                body_drop_menu.append($(`<a style="cursor:pointer;display: block;" href="${url}"  data-type-id="${type_id}"  data-id="${id}" data-url="${item['url']}" data-form="${item['form']}" class="${item['class']}">${item['value']}</a>`));

            }
        });
        // if (!menu.length){
        //     //@ts-ignore
        //     throw new Error('data["menu"] is an empty array');
        // }
        body_hidden_menu.append(body_drop_menu);
    }
    catch (e) {
        console.error(`Error occurred reading data[menu]`, e.name, e.message);
    }
    return body_hidden_menu;
}
/**
 * "tableStatusCreator" draws status td in tbody>tr if type is status
 * @param status_data
 */
function tableStatusCreator(status_data) {
    const status_bar_parent = $('<div></div>');
    const status_bar = $('<div class = "table-status-bar"></div>');
    for (let i = 0; i < status_data.length; i++) {
        let status = $(`<div class = 'status-cell table-status-item' style="background-color: ${status_data[i]['status']};" title="${status_data[i]['name']}"></div>`);
        status_bar.append(status);
    }
    status_bar_parent.prepend(status_bar);
    return status_bar_parent;
}
/**
 * "createTableFooter" creates section that draws pagination etc
 * @param pagination
 * @param option
 */
function createTableFooter(pagination, option) {
    const tableFooter = $(`<div class = "table-footer">
                <div class = "tf-first-section">
                    <div class="tf-first-section-box">
                        <button class="c-btn c-btn-ol tf-show-more">Показать eщё</button>
                    </div>
                </div>
                <div class = "tf-second-section">
                    <div class="tf-second-section-box">
                        <div class="tf-all-rows-count">
                            <span >Отмечено:
                                <span class="tf-checked-row-count">0</span> /
                                <span class="tf-rows-count">${pagination['count_by_page']}</span>
                            </span>
                        </div>
                        <div>
                            <span class="tf-quantity">
                                Всего:
                                <span class="tf-show-quantity">показать количество</span>
                                <span class="tf-num-quantity" style = "display: none">${pagination['all_pages']}</span>
                            </span>
                        </div>
                        <div class="tf-pages">
                            <span>Страницы:</span>
                        </div>
                        <div class="tf-records">
                              <div class="c-floating-label tf-records-select-box">
                                <label>records</label>
                             </div>
                        </div>
                    </div>
                </div>
        
            </div>`);
    $('.tf-pages', tableFooter).append(createPagination(pagination));
    $('.tf-records-select-box', tableFooter).prepend(creatFooterCountByPage(pagination['count_by_page']));
    $('.tf-third-option', tableFooter).append(tableFooterOption(option));
    return tableFooter;
}
/**
 * "createPagination" draws pagination for table
 * @param data
 */
function createPagination(data) {

    let pagination = $(`<div>
            <span class="tf-pages-last tf-select-first"><i class="fas fa-step-backward"></i></span>
            <span class="tf-pages-last tf-select-before"><i class="fas fa-chevron-left"></i></span>
        </div>`);
    let select = $(`<select class = 'c-select'></select>`);
    for (let i = 0; i < data.pages; i++) {
        if (parseInt(data.current) === i + 1) {
            select.append($(`<option selected value="${i + 1}">${i + 1}</option>`));
        }
        else {
            select.append($(`<option value="${i + 1}">${i + 1}</option>`));
        }
    }
    pagination.append(select);
    pagination.append('<span class="tf-pages-next next-page"><i class="fas fa-chevron-right"></i></span><span class="tf-pages-next last"><i class="fas fa-step-forward"></i></span>');
    return pagination;
}
/**
 * "creatFooterCountByPage" draws select to choose how many rows must be shown in table
 * @param num
 */
function creatFooterCountByPage(num) {

    let arr = [5, 10, 20, 50, 100];
    let count_by_page = $(`<select class="tf-records-select jq-select"></select>`);
    arr.forEach(item => {
        if (item === parseInt(num)) {
            count_by_page.append($(`<option value="${item}" selected >${item}</option>`));
        }
        else {
            count_by_page.append($(`<option value="${item}">${item}</option>`));
        }
    });
    return count_by_page;
}
/**
 * "tableFooterOption" draws select in table footer
 * @param data
 */
function tableFooterOption(data) {
    let select = $('<select class="c-select jq-select"></select>');
    let len = data.length;
    for (let i = 0; i < len; i++) {
        select.append($(`<option value="${data[i]}">${data[i]}</option>`));
    }
    return select;
}
/**
 * "addTableListeners" hangs listeners on table
 */
function addTableListeners() {


    let html_body = $('body');
    // let active_input;
    //======================== changes icon when clicked
    $('.drag-thead-cell .col-sort').on('click', function (e) {
        var elem = $(this);
        var elemth = elem.closest('th');
        let active_page = $('.current-module').attr('data-module');

        if (elemth.attr('data-sort') === 'NONE' ) {
            elemth.attr('data-sort', 'ASC');
                //@ts-ignore
                localStorage.setItem(active_page,elemth.attr('data-column'));
                //@ts-ignore
                localStorage.setItem(active_page+'-type','ASC');
        }
        else if (elemth.attr('data-sort') === 'ASC') {
            elemth.attr('data-sort', 'DESC');
                //@ts-ignore
                localStorage.setItem(active_page, elemth.attr('data-column'));
                //@ts-ignore
                localStorage.setItem(active_page+'-type','DESC');
        }
        else if (elemth.attr('data-sort') === 'DESC') {
            elemth.attr('data-sort', 'NONE');
                //@ts-ignore
            localStorage.setItem(active_page,elemth.attr('data-column'));
            //@ts-ignore
            localStorage.setItem(active_page+'-type','none');

        }

        let col = elemth.attr('data-column');
        let sort_type = elemth.attr('data-sort');

        $.ajax({
            url:active_page+'/page',
            data: {page: 1, sort: sort_type, column:col },
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

    });
    //======================== table header checkbox is checked shows in table footer shows all checked
    $('.drag-thead-cell .table-multi-check').on('click', function (e) {
        e.stopPropagation();
        let count = $('.tf-checked-row-count');
        if ($('.table-multi-check').is(":checked")) {
            $('.table-single-check').prop('checked', true).closest('tr').addClass('table-checked-tr');
            let all_checked = +$('.tf-rows-count').text();
            count.empty();
            count.text(`${all_checked}`);
            $('.tbl-f-btn').prop('disabled', false);
            $('.tbody-row').addClass('row-edit');
        }
        else {
            $('.table-single-check').prop('checked', false).closest('tr').removeClass('table-checked-tr');
            count.empty();
            count.text(`0`);
            $('.tbl-f-btn').prop('disabled', true);
            $('.tbody-row').removeClass('row-edit');
        }
    });
    //======================== clicking button shows or hides dropdown thead menu
    $('body').on('click','.tbl-header-btn', function () {
        let drop = $(this).closest('th').find('.table-header-menu');
        drop.toggle();
    });
    $('#table-cancel-btn').on('click', function (e) {
        e.stopPropagation();
        let elem = $(e.target);
        elem.closest('.f-third-section-box').find('#table-cancel-btn, #table-save-btn').hide();
        elem.closest('.f-third-section-box').find('#table-edit-btn').show();
        //@ts-ignore
        editableTable(e);
    });
    //======================== by clicking checkbox, it finds column in table with data-column = "...thead", and toggles it
    $('.table-header-menu .tbl-menu-checkbox').on('click', function () {
        let column = $('.toggle-entire-cols').find(`[data-column="${$(this).attr('name')}"]`);
        let data = {};
        let str = '';
        $('.table-header-menu .tbl-menu-checkbox').each(function(){
            str += $(this).attr('name')+'-'+$(this).is(':checked')+',';
        });
        let active_page = $('.current-module').attr('data-module');

        data['str_status'] = str;
        $.ajax({
            url:active_page+'/update-table',
            data: {data: data},
            method: 'post',
            dataType: 'json'
        });
        column.toggle();
    });
    //======================== by clicking button shows or hides dropdown thead menu
    $('.tbody-row .tbody-menu-btn').on('click', function () {
        $(`.table-body-menu`).hide();
        let drop = $(this).closest('td').find('.table-body-menu');
        drop.toggle();
    });
    // ======================== creates dropdown image bigger size of of current image
    $('.tbody-cell .tbody-img').on('click', function (e) {
        e.stopPropagation();
        const target = $(e.target);
        const parentTable = target.closest('td');
        $(`.table-drop-img-container`).remove();
        const offset = target.offset();
        const src = target.attr('src');
        const drop = $(`<div class="table-drop-img-container"><img src="${src}" class="table-drop-img" alt="icon"></div>`);
        parentTable.append(drop);
        drop.offset({ top: offset.top - 12, left: offset.left + 30 });
    });
    //======================== when checked table footer 'отмечено' +1  when uncheck -1
    $('.tbody-row .table-single-check').on('click', function (e) {
        e.stopPropagation();
        let item = $(e.target);
        let multi_check = $('.table-multi-check');
        let count = $('.tf-checked-row-count');
        let text = +count.text();
        let container = item.closest('.tbody-row');
        if (item.is(":checked")) {
            item.closest('tr').removeClass('table-checked-tr');
            count.empty();
            count.text(`${text + 1}`);
            $('.tbl-f-btn').prop('disabled', false);
            container.addClass('row-edit');
        }
        else {
            item.closest('tr').addClass('table-checked-tr');
            multi_check.prop('checked', false);
            multi_check.removeClass('table-checked-tr');
            count.empty();
            count.text(`${text - 1}`);
            if (!+count.text()) {
                $('.tbl-f-btn').prop('disabled', true);
            }
            container.removeClass('row-edit');
        }
    });
    //======================== shows table data quantity in table footer
    $('.tf-quantity .tf-show-quantity').on('click', function (e) {
        e.stopPropagation();
        $('.tf-show-quantity').hide();
        $('.tf-num-quantity').css({'display':'inline-block','color':'#25af36','font-weight':'600'});
    });
    //======================== makes resizable table cells, that have class 'ui-resizable'
    $('.drag-thead-cell .ui-resizable').resizable({
        handles: 'e',
        minWidth: 20,
    });
    //======================== makes table>tbody>tr movable (drug drop)
    $('.toggle-entire-cols .z6-table-body').sortable({
        //@ts-ignore
        containerSelector: 'tbody',
        handle: '.draggable-column',
        axis: "y",
        itemSelector: 'tr',
        pullPlaceholder: true,
        placeholder: '<tr class="placeholder"></tr>',
        afterMove: function ($placeholder, container) {
            console.log('sdfgdsds');
            let height = $(container.items[0]).css('height');
            let width = $(container.items[0]).css('width');
            $placeholder.css({
                height: height,
                width: width,
            });
        },
        onDrop: function ($item, container, _super) {
            _super($item, container);
            let arr = $(`.num-column`);
            let len = arr.length;
            let num = len;
            let isASC = $('.table-body').attr('data-asc-desc');
            for (let i = 0; i < len; i++) {
                if (isASC === 'ASC') {
                    $(arr[i]).html(`${i + 1}`);
                }
                else {
                    $(arr[i]).html(`${num--}`);
                }
            }
        }
    }).disableSelection();
    let oldIndex;
    let width;
    $('.drag-thead-cell').sortable({
        containerSelector: 'tr',
        itemSelector: '.drag-sort',
        handle: '.col-drag',
        placeholder: '<th class="placeholder"></th>',
        vertical: false,
        pullPlaceholder: true,
        onDragStart: function ($item, container, _super) {
            width = $item.css('width');
            oldIndex = $item.index();
            $item.appendTo($item.parent());
            _super($item, container);
        },
        onDrop: function ($item, container, _super) {
            let newIndex = $item.index();
            if (newIndex !== oldIndex) {
                $item.closest('table').find('tbody tr').each(function (i, row) {
                    row = $(row);
                    if (newIndex < oldIndex) {
                        row.children().eq(newIndex).before(row.children()[oldIndex]);
                    }
                    else if (newIndex > oldIndex) {
                        row.children().eq(newIndex).after(row.children()[oldIndex]);
                    }
                });
            }
            //@ts-ignore
            _super($item, container);
            let data = {};
            let str = '';
            $('.tableSection th.ui-resizable').each(function(){
                str +=$(this).attr('data-column')+',';
            });

            let url = $('.current-module').attr('data-module');

            let active_page = $('.main-header .nav-item .active').attr('href').replace("/index", "");
            data['page'] = active_page;
            data['str'] = str;

            $.ajax({
                url: url + '/update-table',
                data: {data: data},
                method: 'post',
                dataType: 'json',
                complete:function(r){
                    console.log(r);
                }
            });
            $item.css('width', `${width}`);
        }
    }).disableSelection();
    //======================== by clicking outside hides popup menues
    html_body.on('click', function (e) {
        if (!$(e.target).closest('.table-body-menu, .tbody-menu-btn').length) {
            $(`.table-body-menu`).hide();
        }
        if (!$(e.target).closest('.table-drop-img-container, .tbody-img').length) {
            $(`.table-drop-img-container`).remove();
        }
        if (!$(e.target).closest('.table-header-menu, .tbl-header-btn').length) {
            $(`.table-header-menu`).hide();
        }
    });
    //======================== enter key onclick makes td input hide and td span appear
    $('.td-input').on('keydown', function (e) {
        e.stopPropagation();
        if (e.keyCode === 13) {
            editableTable(e);
        }
    });
    //========================
    $('.td-input').on('change', function (e) {
        e.stopPropagation();
        let target = $(e.target);
        //@ts-ignore
        let value = e.target.value;
        if (value) {
            target.closest("td").find('.td-span').empty().text(value);
        }
    });
    //========================


    $('.c-select').on('change', function (e) {
        let page = $(this).val();
        let url = $('.current-module').attr('data-module');
        var searchData = getSearchData();

        $.ajax({
            url:url+'/page',
            data: {page: page,dataSearch:searchData},
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
    });
    $('.tf-records-select').on('change', function (e) {
        let data = {};
        let count_show = $(this).val();
        let url = $('.current-module').attr('data-module');
        data['page'] = url;
        data['count_show'] = count_show;
        $.ajax({
            url:url+'/update-table',
            data: {data: data},
            method: 'post',
            dataType: 'json',
            success: function () {
               window.location.reload();
            }
        });
    });
    $('.next-page').on('click', function (e) {
        let page = parseInt($('.tf-pages .c-select').val());
        let last_page = parseInt($('.tf-pages .c-select option').last().val());
        let url = $('.current-module').attr('data-module');
        if(last_page >= (page+1)) {
            page = page + 1;
        } else {
            return false;
        }
        var searchData = getSearchData();
        $.ajax({
            url:url+'/page',
            data: {page: page,dataSearch:searchData},
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


    });
    $('.last').on('click', function (e) {
        var searchData = getSearchData();
        let page = parseInt($('.tf-pages .c-select option').last().val());
        let url = $('.current-module').attr('data-module');

        $.ajax({
            url:url+'/page',
            data: {page: page,dataSearch:searchData},
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

    });
    $('.tf-select-first').on('click', function (e) {
        var searchData = getSearchData();
        let url = $('.current-module').attr('data-module');
        $.ajax({
            url:url+'/page',
            data: {page: 1,dataSearch:searchData},
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

    });
    $('body').on('click','.tf-show-more', function (e) {
        e.stopPropagation();
        let url = $('.current-module').attr('data-module');
        var page = parseInt($('.tf-pages .c-select').val())+1;
        let last_page = parseInt($('.tf-pages .c-select option').last().val());
        var searchData = getSearchData();
        if(last_page < page) {
            $('.tf-show-more').hide();
            return false;
        }
        $.ajax({
            url:url+'/page',
            data: {page: page,dataSearch:searchData},
            method: 'post',
            dataType: 'json',
            success: function (table_data) {
                if(table_data != null) {
                    $(`.z6-table-body`).append(drawBodyDataWithoutTag(table_data['body'], table_data['header'], table_data['menu'], table_data['number'], table_data['multiselect'], table_data['draggable']))
                    $('.tf-pages .c-select option').removeAttr('selected');
                    $('.tf-pages .c-select option[value='+page+']').attr('selected','selected');
                } else {
                    $('.tf-show-more').hide();
                }

            }
        });

       setTimeout(function () {
           $($('.z6-table-body tr').get().reverse()).each(function (item,key) {
               $(this).find('.num-column span').text(item+1);
           });
       },200);

    });
    $('.tf-select-before').on('click', '',function (e) {
        let page = parseInt($('.c-select').val());
        let url = $('.current-module').attr('data-module');
        var searchData = getSearchData();
        if(page>1) {
            page = page - 1;
        } else {
            return false;
        }
        $.ajax({
            url:url+'/page',
            data: {page: page,dataSearch:searchData},
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
    });
    //========================

    showArrows();
}
function getSearchData(){
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
    return dataSeach;
}
let table_value_inputs_arr = [];
function editableTable(e) {
    let target = $(e.target);
    let data_attr = target.attr('data-edit');
    let tbody = $('tbody');
    let checkedRow = tbody.find('.table-single-check:checked').closest('tr');
    switch (data_attr) {
        case 'td-cell':
            if (!tbody.hasClass('tbody-edit')) {
                let hidden_span = tbody.find('.td-input');

                hidden_span.hide();
                hidden_span.closest("td").find('.td-span').show();
                target.toggle();
                target.closest("td").find('.td-input').toggle().focus();
            }
            break;
        case 'td-input':
            if (!tbody.hasClass('tbody-edit')) {
                target.toggle();
                target.closest("td").find('.td-span').toggle();
            }
            break;
        case 'edit-btn':
            target.closest('.f-third-section-box').find('#table-cancel-btn, #table-save-btn').show();
            target.hide();
            editSaveCancelFooter(true);
            let table_td_input_arr = $('.row-edit .td-input');
            let length = table_td_input_arr.length;
            for (let i = 0; i < length; i++) {
                let item_id = $(table_td_input_arr[i]).closest('td').attr('id');
                let item_value = $(table_td_input_arr[i]).val();
                table_value_inputs_arr.push({ 'input_id': `${item_id}`, 'input_value': `${item_value}` });
            }

            checkedRow.find('.select2').show();
            // $('.z6-table-body select').select2('destroy');
            checkedRow.find('.empty-cell').toggle();
            break;
        case 'table-save-btn':
            editSaveCancelFooter(false);
            let selects = checkedRow.find('select.td-input');
            $.each(selects, (k, v)=>{
                let selectText = $(v).find('option:selected').text();
                $(v).closest('td').find('.td-span').text(selectText);
            });

            checkedRow.find('.td-cell').text();
            break;
        case 'table-cancel-btn':
            table_value_inputs_arr.forEach((item) => {
                $(`#${item.input_id} .td-input`).val(`${item.input_value}`);
                $(`#${item.input_id} .td-span`).empty().text(`${item.input_value}`);
            });
            editSaveCancelFooter(false);
            break;
        default:
    }
}
function editSaveCancelFooter(isEdit) {
    let container = $('.row-edit');
    let tbody = $('tbody');
    $.each(container, function (index, item) {
        let span = $(item).find('.td-span');
        let input = $(item).find('.td-input');
        isEdit ? span.hide() : span.show();
        isEdit ? input.show() : input.hide();
        isEdit ? tbody.addClass('tbody-edit') : tbody.removeClass('tbody-edit');
        $('tbody .table-single-check, thead .table-multi-check').prop('disabled', isEdit);
    });
}
