interface TableHeaderCell {
    align: string,
    class: string,
    name: string,
    alias: string,
    is_visible: boolean,
    type: string,
    width: number,
    width_unit: string,
    link: string,
    sort: string,
    list: {},
}
interface BodyMenu {
    [key:string]: string;
}
interface Status {
    name: string,
    status: string,
}
interface TableBodyCellData {
    type: string,
    value:  any,
    alias: string,
    link?: string,
    class?: string,
}
interface TableBodyData {
    id:number
    order: number
    items: TableBodyCellData[]
}
interface Menu {
    [key:string]: string
}
interface Pagination {
    all_pages?: number,
    pages: number,
    current: number,
    count_by_page:number,
}
interface ValueInputs {
    input_id?: string,
    input_value?: string | number | string[],
}
interface Data {
    header: TableHeaderCell[],
    body:TableBodyData[],
    menu: Menu[],
    number: string,
    multiselect: boolean,
    draggable: boolean,
    pagination: {pages:number, current:number, count_by_page: number},
    option_data:string[]
}

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
function createTable(table_data: Data) {
    const html_table: JQuery = $(`<table class ='toggle-entire-cols'></table>`);
    function isEmpty(obj: any) {
        for(let key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    if (isEmpty(table_data)){console.error('data is empty object');} else {
        if ( !Array.isArray(table_data.header) || !table_data.header.length){console.error('data["header"] is empty array [] or is not an array or is not defined ');} else {
            //=======start creating thead by giving data.header
            try {
                html_table.append(
                    drawHeaderData(table_data['header'], (!Array.isArray(table_data.body)) ? 0 : table_data['body'].length, table_data['multiselect'], table_data['draggable'])
                );
            } catch (err) {console.error(`Error occurred reading data['header']`, err.message, err.name);}
            if (!Array.isArray(table_data.body) || !table_data.body.length) {console.error('data["body"] is empty array [] or is not an array or is not defined');} else {
                try {
                    //=======start creating tbody by giving data.body, data.header and data.menu
                    html_table.append(
                        drawBodyData(table_data['body'], table_data['header'], table_data['menu'], table_data['number'], table_data['multiselect'], table_data['draggable'])
                    );
                } catch (err) {console.error(`Error occurred reading data['body']`, err.message, err.name);}
            }
        }
    }
    let table_footer:JQuery = $('.tableFooterSection');
    table_footer.append(createTableFooter(table_data['pagination'], table_data['option_data']));
    setTimeout(()=> addTableListeners(), 10);
    return html_table;
}

/**
 * "drawHeaderData" draws thead in table
 * @param data
 * @param length
 * @param multiselect
 * @param draggable
 */
function drawHeaderData(data:TableHeaderCell[], length:number, multiselect: boolean, draggable: boolean) {
    let html_table_head:JQuery = $(`<thead class = 'sorted_head'></thead>`);
    //=======create first two cells in thead>tr
    let html_table_tr: JQuery = $(`<tr class = "drag-thead-cell"><th style="width: 20px"><span>&#8470;</span></th></tr>`);
    if(multiselect){
        html_table_tr.prepend($(`<th style="width: 25px">
            <label class="c-label-checkbox">
                <input type="checkbox" class="table-multi-check">
                <span></span>
            </label>
        </th>`))
    }
    if (length > 1 && draggable) {
        html_table_tr.prepend($(`<th style="width: 25px"></th>`));
    }

    //create dropdown menu cell (th)
    let drop_th:JQuery = $(`<th style="width: 20px"><button class = 'tbl-header-btn'><i class="fas fa-cog"></i></button></th>`);

    //=======calls function that creates dropdown menu and appends hidden menu to th
    drop_th.append(drawHeaderMenu(data));

    //appends th to thead>tr
    html_table_tr.append(drop_th);

    //======= from here starts creating rest th-cells running through table data
    data.forEach((th:TableHeaderCell)=> {
        let header_cell:JQuery  = $(`<th class = 'ui-resizable drag-sort' data-column="${th['alias']}-tbl" ${data.sort? 'data-sort = "none"': ''} ></th>`);
        header_cell.css({
            'display': `${th['is_visible']? 'table-cell': 'none'}`,
            'width': `${th['width']+th['width_unit']}`,
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
                header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></div>${th['name']}</div>`));
                break;
            default:
                header_cell.append($(`<div class = "col-drag thead-box"><div class="col-sort"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></div><span>${th['name']}</span></div>`));//<input type = 'text' value = "${th['name']}" readonly/>
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
function drawHeaderMenu(data:TableHeaderCell[]) {
    let header_hidden_menu: JQuery = $(`<div class = 'table-header-menu'></div>`);
    let header_drop_menu:JQuery = $(`<div></div>`);

    //======= runs through table header-data and draws checkboxes that will toggle relevant columns
    data.forEach((item:TableHeaderCell)=> {
        header_drop_menu.append($(`<div class="header-menu-item" >
            <div class="c-checkbox">
                <input type="checkbox"  class = 'tbl-menu-checkbox' name = "${item['alias']}-tbl" id="${item['alias']}-tbl" ${item['is_visible'] ? 'checked' : ''}>
                <label for = "${item['alias']}-tbl"> ${item['name']} </label>
            </div>
        </div>`));
    })
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
function  drawBodyData(data:TableBodyData[], columns: TableHeaderCell[], body_menu: Menu[], sort: string, multiselect: boolean, draggable: boolean){
    let html_table_body:JQuery =  $(`<tbody class = 'z6-table-body' data-asc-desc = '${sort}'></tbody>`);
    let num:number = data.length; // num is maximum table body rows that will be reversed
    let length:number = num;
    // ======================== runs through body data to draw table rows

    data.forEach(function(table_tr:TableBodyData, tr_index:number){
        //======================== creates tr and first two cells in tbody>tr
        let html_table_tr: JQuery = $(`<tr data-row = "${table_tr['order']}" class = 'tbody-row'><td class="num-column"><span>${sort === 'ASC'? tr_index+1 :num-- }</span></td></tr>`);
        if(multiselect){
            html_table_tr.prepend($(`<th>
                <label class="c-label-checkbox">
                    <input type="checkbox" class="table-single-check">
                    <span></span>
                </label>
            </th>`));
        }
        if (length > 1 && draggable) {
            html_table_tr.prepend($(`<td class="dragger-td"><button type = 'button' class = 'draggable-column table-row-dragger'><i class="fas fa-grip-vertical"></i></button></td>`));
        }

        //======================== create dropdown menu cell (td)
        let drop_td:JQuery = $(`<td><button class = 'tbody-menu-btn'><i class="fas fa-bars"></i></button></td>`);

        //======================== calls function that creates dropdown menu and appends hidden menu to td
        drop_td.append(drawBodyMenu(body_menu, table_tr['id']));
        html_table_tr.append(drop_td);

        columns.forEach((td:TableHeaderCell, td_index:number)=> {
            html_table_tr.append($(`<td id = "edit-${tr_index}${td_index}" class = 'tbody-cell' data-column="${td['alias']}-tbl" style = "display: ${td['is_visible']? 'table-cell': 'none'}; text-align : ${td['align']}"><span class="empty-cell">(empty)</span></td>`))
        });

        //======================== runs through body-data nested arrays to create rest tbody>tr td
        table_tr['items'].forEach(function(td: TableBodyCellData){
            //======================== switch checks the type of data for current cell if type is not recognised draws 'unknown'
            let tbody_cell: JQuery = html_table_tr.find(`[data-column='${td['alias']}-tbl']`);
            let append:null |JQuery = null;
            let input_append: null |JQuery = null;
            let empty:boolean = false;

            switch (td.type) {
                case 'number':
                case 'number range':
                case 'text':
                case 'select':
                case 'select2':
                    append = $(`<span data-edit = 'td-cell' class = 'td-span'>${td['value']}</span>`);
                    input_append = $(`<input data-edit = 'td-input' class = 'td-input' value = "${td['value']}">`);
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
                            <input type="checkbox" ${td['value'] ? 'checked': 'none'}>
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
                    input_append = $(`<input class = 'link-input' ${td['value']}/>`);
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
                    console.error(`type: ${td['type']} is not defined`,'[data type ERROR]');
            }
            if(empty){tbody_cell.empty();}
            if(append){
                tbody_cell.append(append);
                if (input_append) {tbody_cell.append(input_append);}
            }
            if (td['class']){tbody_cell.addClass(td['class']);}
        });
        html_table_body.append(html_table_tr);
    });
    return html_table_body;
}

/**
 * "drawBodyMenu" draws menu in tbody>tr>3-rd td
 * @param menu
 * @param id
 */
function drawBodyMenu(menu:Menu[], id: number) {
    let body_hidden_menu: JQuery = $(`<div class = 'table-body-menu'></div>`);
    let body_drop_menu: JQuery = $(`<div></div>`);
    try {
        //======= runs through table menu-data and rows relevant fields
        menu.forEach(function (item:BodyMenu) {
            switch (item.type) {
                case 'link':
                    body_drop_menu.append($(`<a href="${item['action']}">${item['value']}</a>`));
                    break;
                case 'function':
                    body_drop_menu.append($(`<span onclick="${item['action']}(${id})">${item['value']}</span>`));
                    break;
                default:
                    body_drop_menu.append($(`<span>unknown</span>`));
            }
        });
        // if (!menu.length){
        //     //@ts-ignore
        //     throw new Error('data["menu"] is an empty array');
        // }
        body_hidden_menu.append(body_drop_menu);
    } catch (e) {
        console.error(`Error occurred reading data[menu]`, e.name, e.message)
    }
    return body_hidden_menu;
}

/**
 * "tableStatusCreator" draws status td in tbody>tr if type is status
 * @param status_data
 */
function tableStatusCreator(status_data: []) {
    const status_bar_parent:JQuery = $('<div></div>');
    const status_bar:JQuery = $('<div class = "table-status-bar"></div>');
    for (let i = 0; i < status_data.length; i++) {
        let status:JQuery = $(`<div class = 'status-cell table-status-item' style="background-color: ${status_data[i]['status']};" title="${status_data[i]['name']}"></div>`);
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
function createTableFooter(pagination: Pagination, option: string[]) {
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
                <div class = "tf-third-section">
                    <div class="f-third-section-box">
                        <button id = 'table-edit-btn' class="c-btn c-btn-link tbl-f-btn" data-edit = "edit-btn" disabled>
                            <i class="fas fa-pencil-alt"></i>
                            edit
                        </button>
                        <button id = 'table-save-btn' class="c-btn c-btn-ol tbl-f-btn" data-edit = "table-save-btn">
                            save
                        </button>
                        <button id = 'table-cancel-btn' class="c-btn c-btn-danger c-btn-ol" data-edit = "table-cancel-btn">
                            cancel
                        </button>
                        <button class="c-btn c-btn-ol tbl-f-btn" disabled>
                            обзвонить
                        </button>
                        <div class="  tf-third-option"></div>
                        <div class="c-checkbox for-all-checkbox">
                            <input type="checkbox" id="tf-checkbox">
                            <label for="tf-checkbox">для всех</label>
                        </div>
                    </div>
                </div>
            </div>`);
    $('.tf-pages', tableFooter).append(createPagination(pagination));
    $('.tf-records-select-box', tableFooter).prepend(creatFooterCountByPage(pagination['count_by_page']));
    $('.tf-third-option', tableFooter).append(tableFooterOption(option))

    return tableFooter;
}

/**
 * "createPagination" draws pagination for table
 * @param data
 */
function createPagination(data:Pagination) {
    let pagination:JQuery = $(`<div>
            <span class="tf-pages-last"><i class="fas fa-step-backward"></i></span>
            <span class="tf-pages-last tf-select-before"><i class="fas fa-chevron-left"></i></span>
        </div>`);
    let select:JQuery =$(`<select class = 'c-select'></select>`);
    for(let i = 0; i < data.pages; i++ ){
        if (data.pages === i + 1) {
            select.append($(`<option selected>${i + 1}</option>`));
        } else {
            select.append($(`<option>${i + 1}</option>`));
        }
    }
    pagination.append(select);
    pagination.append('<span class="tf-pages-next"><i class="fas fa-chevron-right"></i></span><span class="tf-pages-next"><i class="fas fa-step-forward"></i></span>');
    return pagination;
}

/**
 * "creatFooterCountByPage" draws select to choose how many rows must be shown in table
 * @param num
 */

function creatFooterCountByPage(num: number) {
    let arr = [5, 10, 20, 50, 100];
    let count_by_page = $(`<select class="tf-records-select jq-select"></select>`);
    arr.forEach(item => {
        if (item === num) {
            count_by_page.append($(`<option selected >${item}</option>`));
        }
        else {
            count_by_page.append($(`<option>${item}</option>`));
        }
    });
    return count_by_page;
}
/**
 * "tableFooterOption" draws select in table footer
 * @param data
 */
function tableFooterOption(data: string[]) {
    let select:JQuery = $('<select class="c-select jq-select"></select>');
    let len:number = data.length;
    for(let i = 0; i < len; i++){
        select.append($(`<option>${data[i]}</option>`));
    }
    return select
}



/**
 * "addTableListeners" hangs listeners on table
 */
function addTableListeners():void {
    let html_body:JQuery = $('body');
    // let active_input;
    //======================== changes icon when clicked
    $('.drag-thead-cell .col-sort').on('click', function (e) {
        e.stopPropagation();
        let elem: JQuery = $(this);
        let elemth = elem.closest('th');
        if (elemth.attr('data-sort') === 'none'){
            elemth.attr('data-sort', 'ASC');
            elem.find('.fa-caret-up').hide()
            elem.find('.fa-caret-down').show();
            console.log('none', elemth.attr('data-column'))
        } else if(elemth.attr('data-sort') === 'ASC') {
            elemth.attr('data-sort', 'DESC');
            elem.find('.fa-caret-up').show();
            elem.find('.fa-caret-down').hide();
            console.log('ASC', elemth.attr('data-column'))
        } else if (elemth.attr('data-sort') === 'DESC'){
            elemth.attr('data-sort', 'none');
            elem.find('.fa-caret-up').show();
            elem.find('.fa-caret-down').show();
            console.log('DESC', elemth.attr('data-column'))
        }
    });

    //======================== table header checkbox is checked shows in table footer shows all checked
    $( '.drag-thead-cell .table-multi-check').on('click', function (e) {
        e.stopPropagation();
        let count:JQuery = $('.tf-checked-row-count');
        if ($('.table-multi-check').is(":checked")){
            $('.table-single-check').prop('checked', true).closest('tr').addClass('table-checked-tr');
            let all_checked:number = +$('.tf-rows-count').text();
            count.empty();
            count.text(`${all_checked}`);
            $('.tbl-f-btn').prop('disabled', false);
            $('.tbody-row').addClass('row-edit');
        } else {
            $('.table-single-check').prop('checked', false).closest('tr').removeClass('table-checked-tr');
            count.empty();
            count.text(`0`);
            $('.tbl-f-btn').prop('disabled', true);
            $('.tbody-row').removeClass('row-edit');
        }
    });

    //======================== clicking button shows or hides dropdown thead menu
    $('.drag-thead-cell .tbl-header-btn').on('click', function(){
        let drop:JQuery = $(this).closest('th').find('.table-header-menu');
        drop.toggle();
    });

    //======================== by clicking checkbox, it finds column in table with data-column = "...thead", and toggles it
    $('.table-header-menu .tbl-menu-checkbox').on('click', function () {
        let column:JQuery = $('.toggle-entire-cols').find(`[data-column="${$(this).attr('name')}"]`);
        column.toggle();
    });

    //======================== by clicking button shows or hides dropdown thead menu
    $('.tbody-row .tbody-menu-btn').on('click', function ():void {
        $(`.table-body-menu`).hide();
        let drop:JQuery = $(this).closest('td').find('.table-body-menu');
        drop.toggle();
    });

    // ======================== creates dropdown image bigger size of of current image
    $('.tbody-cell .tbody-img').on('click',function (e) {
        e.stopPropagation();
        const target: JQuery = $(e.target);
        const parentTable:JQuery = target.closest('td');
        $(`.table-drop-img-container`).remove();
        const offset: any = target.offset();
        const src: any = target.attr('src');
        const drop:JQuery = $(`<div class="table-drop-img-container"><img src="${src}" class="table-drop-img" alt="icon"></div>`);
        parentTable.append(drop);
        drop.offset({top: offset.top - 12, left: offset.left + 30});
    });

    //======================== when checked table footer 'отмечено' +1  when uncheck -1
    $('.tbody-row .table-single-check').on('click', function(e){
        e.stopPropagation();
        let item:JQuery =$(e.target);
        let multi_check:JQuery = $('.table-multi-check');
        let count:JQuery = $('.tf-checked-row-count');
        let text = +count.text();
        let container:JQuery = item.closest('.tbody-row');
        if (item.is(":checked")){
            item.closest('tr').removeClass('table-checked-tr');
            count.empty();
            count.text(`${text + 1}`);
            $('.tbl-f-btn').prop('disabled', false);
            container.addClass('row-edit');
        } else {
            item.closest('tr').addClass('table-checked-tr');
            multi_check.prop('checked', false);
            multi_check.removeClass('table-checked-tr');
            count.empty();
            count.text(`${text - 1}`);
            if (!+count.text()){
                $('.tbl-f-btn').prop('disabled', true);
            }
            container.removeClass('row-edit');
        }
    });

    //======================== shows table data quantity in table footer
    $('.tf-quantity .tf-show-quantity').on('click', function (e) {
        e.stopPropagation();
        $('.tf-show-quantity').hide();
        $('.tf-num-quantity').show();
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
        pullPlaceholder:true,
        placeholder: '<tr class="placeholder"></tr>',
        afterMove:  function ($placeholder:any, container:any):void {
            let height = $(container.items[0]).css('height');
            let width = $(container.items[0]).css('width');
            $placeholder.css({
                height: height,
                width: width,
            })
        },
        onDrop: function ($item:any, container:any, _super:any):void {
            _super($item, container);
            let arr: JQuery = $(`.num-column`);
            let len:number = arr.length;
            let num:number = len;
            let isASC = $('.table-body').attr('data-asc-desc');
            for (let i =0; i<len; i++){
                if (isASC === 'ASC') {
                    $(arr[i]).html(`${i+1}`);
                } else {
                    $(arr[i]).html(`${num--}`);
                }
            }
        }
    }).disableSelection();

    let oldIndex:any;
    let width:string;
    $('.drag-thead-cell').sortable({
        //@ts-ignore
        containerSelector: 'tr',
        itemSelector: '.drag-sort',
        handle: '.col-drag',
        placeholder: '<th class="placeholder"></th>',
        vertical: false,
        pullPlaceholder: true,
        onDragStart: function ($item:JQuery, container:JQuery, _super:void) {
            width = $item.css('width');
            oldIndex = $item.index();
            $item.appendTo($item.parent());
            //@ts-ignore
            _super($item, container);
        },
        onDrop: function  ($item:JQuery, container:JQuery, _super:void) {
            let newIndex = $item.index();
            if(newIndex !== oldIndex) {
                //@ts-ignore
                $item.closest('table').find('tbody tr').each(function (i:number, row:any) {
                    row = $(row);
                    if(newIndex < oldIndex) {
                        row.children().eq(newIndex).before(row.children()[oldIndex]);
                    } else if (newIndex > oldIndex) {
                        row.children().eq(newIndex).after(row.children()[oldIndex]);
                    }
                });
            }
            //@ts-ignore
            _super($item, container);
            $item.css('width', `${width}`);
        }
    }).disableSelection();

    //======================== by clicking outside hides popup menues
    html_body.on('click', function (e):void {
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
        let target:JQuery = $(e.target);
        //@ts-ignore
        let value:string | null  = e.target.value;
        if (value){
            target.closest("td").find('.td-span').empty().text(value);
        }
    });
    //========================

    $('.tbody-cell .td-span').on('dblclick', function (e) {
        e.stopPropagation();
        editableTable(e);
    });
    $('#table-edit-btn').on('click', function (e) {
        e.stopPropagation();
        editableTable(e);
    });
    //========================
    $('#table-save-btn, #table-cancel-btn').on('click', function (e) {
        e.stopPropagation();
        let elem:JQuery = $(e.target);
        elem.closest('.f-third-section-box').find('#table-cancel-btn, #table-save-btn').hide();
        elem.closest('.f-third-section-box').find('#table-edit-btn').show();
        editableTable(e);
    });
}
let table_value_inputs_arr:ValueInputs[] = [];
function editableTable(e:any):void {
    let target:JQuery = $(e.target);
    let data_attr = target.attr('data-edit');
    let tbody:JQuery = $('tbody');
    switch(data_attr) {
        case 'td-cell':
            if(!tbody.hasClass('tbody-edit')){
                let hidden_span:JQuery = tbody.find('.td-input');
                hidden_span.hide();
                hidden_span.closest("td").find('.td-span').show();
                target.toggle();
                target.closest("td").find('.td-input').toggle().focus();
            }
            break;
        case 'td-input':
            if(!tbody.hasClass('tbody-edit')){
                target.toggle();
                target.closest("td").find('.td-span').toggle();
            }
            break;
        case 'edit-btn':
            target.closest('.f-third-section-box').find('#table-cancel-btn, #table-save-btn').show();
            target.hide();
            editSaveCancelFooter(true)
            let table_td_input_arr  = $('.row-edit .td-input');
            let length:number = table_td_input_arr.length;
            for (let i = 0; i <length; i++){
                let item_id = $(table_td_input_arr[i]).closest('td').attr('id');
                let item_value = $(table_td_input_arr[i]).val()
                table_value_inputs_arr.push({'input_id': `${item_id}`, 'input_value': `${item_value}`});
            }
            break;
        case 'table-save-btn':
            editSaveCancelFooter(false);
            break;
        case 'table-cancel-btn':
            table_value_inputs_arr.forEach((item:ValueInputs)=>{
                $(`#${item.input_id} .td-input`).val(`${item.input_value}`);
                $(`#${item.input_id} .td-span`).empty().text(`${item.input_value}`);
            });
            editSaveCancelFooter(false);
            break;
        default:
    }
}
function editSaveCancelFooter(isEdit:boolean) {
    let container:JQuery = $('.row-edit');
    let tbody:JQuery = $('tbody');
    $.each(container, function (index, item) {
        let span:JQuery = $(item).find('.td-span');
        let input:JQuery = $(item).find('.td-input');
        isEdit? span.hide(): span.show();
        isEdit? input.show(): input.hide();
        isEdit ? tbody.addClass('tbody-edit'): tbody.removeClass('tbody-edit');
        $('tbody .table-single-check, thead .table-multi-check').prop('disabled', isEdit);
    });
}