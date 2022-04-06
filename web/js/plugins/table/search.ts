interface Data {
    header: TableHeaderCell[],
    search: SearchDATA[],
}
interface SearchDATA {
    id: number
    name: string
    pinned: boolean
    list: SearchListDATA[]
}
interface TableHeaderCell {
    name: string,
    alias: string,
    type: string,
    link: string,
    sort: string,
    list: {}
}
interface SearchListDATA {
    is_visible: boolean
    alias: string
    name: string
    type: string
    list: any
    value: any
}
interface JQuery {
    select2({}: {}): void;
}
interface SliderUIParams {
    handle?: JQuery;
    value?: number;
    values?: number[] | any;
}

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
function createSearch(data: Data) {
    const search_data:SearchDATA[] = data.search;
    //finds in data which main filter is selected by  default
    const draw_right_part: any = search_data.find(item => item.pinned);
    // "search_div" draws input tag for search
    const search_div: JQuery = $(`
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
                         <button id = 'change-grand-filter' class = 'fitlter-settings-button'><i class="fas fa-cog"></i></button>
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
    let add_field_container: JQuery = $(`<div class="filter-field-drop"></div>`);

    $('.fcl-in', search_div).prepend(createGrandFiltersBlock(search_data));
    $('#add-field-toggle-block', search_div).append(add_field_container);
    $('.filter-container-right', search_div).prepend(createFilterRightPartHeader(draw_right_part.items, data.header, add_field_container));

    setTimeout(()=>addSearchListeners(),10);
    return search_div;
}

/**
 * "createGrandFiltersBlock" draws left part main filters
 * @param search_data
 */
function createGrandFiltersBlock(search_data: SearchDATA[]) {
    const grand_filters_div: JQuery = $(`<div class = 'grand-filters-block'><h5>ФИЛЬТРЫ</h5></div>`);
    const main_filters:JQuery = $(`<div class = 'main-filters'></div>`)
    search_data.forEach((item: SearchDATA) => {
        main_filters.append($(`<div data-grand-id = ${item.id} class = 'grand-filter-div'>
            <div><span class = 'grand-span-drug'><i class="fas fa-ellipsis-v"></i></span></div>
            <input class = 'grand-span-name' type="text" value="${item.name.toUpperCase()}" readonly>
            <span class = 'grand-span grand-pinned ${item.pinned ? 'down active' : ''}'><i class="fas fa-thumbtack"></i></span> 
            <span class = 'grand-span grand-edit'><i class="fas fa-pen"></i></span> 
            <span class = 'grand-span grand-close'><i class="fas fa-times"></i></span> 
        </div>`));
    });
    grand_filters_div.append(main_filters);
    return grand_filters_div;
}

/**
 * "createFilterRightPartHeader" runs through search and header data to draw filter right part header and add field popup
 * @param search_data
 * @param header_data
 * @param add_field_container
 */

function createFilterRightPartHeader(search_data: SearchListDATA[], header_data:TableHeaderCell[], add_field_container: JQuery) {
    const filter_right_part_header: JQuery = $(`<ul id = 'draggable-container' class = 'filter-right-part-header'></ul>`);
    //runs through data header to draw filters
    header_data.forEach((item: any, index:number) => {
        let list:any= item.list;
        // filter_li is default block for all fields in right part header
        let filter_li:JQuery = $(`
                <li id = ${item.alias} class = 'filter-item-toggle-div' style="display:${item.is_visible ? 'grid' : 'none'};">
                    <div><button type = 'button'  class = 'draggable-filter hid-btn'><i class="fas fa-ellipsis-v"></i></button></div>     
                   
                </li>`);
        let has_checkbox:boolean = false;
        switch (item.type) {
            case 'text':
                //draws simple input in filter right part header
                filter_li.append($(`<div class = 'filter-item-div'><input class = 'table-filter-input' placeholder = '${item.name}'></div>`));
                has_checkbox = true;
                break;
            case 'number':
                //draws number input in filter right part header
                filter_li.append($(`
                    <div class = 'filter-item-div'>
                        <input class="number-input" type="number"  min="${list.min}" max="${list.max}" value = "${item.name}">
                    </div>`));
                has_checkbox = true;
                break;
            case 'select':
                //draws select in filter right part header
                filter_li.append(filterItemSelect(item, search_data[index]));
                has_checkbox = true;
                break;
            case 'select2':
                // calls filterItemSelectTwo to draw select2 in filter right part header
                filter_li.append(filterItemSelectTwo(item, search_data[index]));
                has_checkbox = true;
                break;
            case 'number range':
                // calls searchRange to draw range in filter right part header
                filter_li.append(searchRange(item, search_data[index] ));
                has_checkbox = true;
                break;
            case 'checkbox':
            case 'image':
            case 'icon':
                //draws checkbox in filter right part header
                filter_li.append($(`
                    <div class = 'c-checkbox'>
                        <input type = 'checkbox' id = '${item.alias}145'  ${item.is_visible ? "checked" : null}/>
                        <label for = '${item.alias}145' >${item.name}</label>
                    </div>`));
                has_checkbox = true;
                break;
            case 'date':
                //draws data input in filter right part header
                filter_li.append($(`
                    <div class = 'filter-item-div'>
                        <p>${item.name}</p>
                        <input type="date" value = "${item.list['value']}"/>
                     </div> `));
                has_checkbox = true;
                break;
            case 'date range':
                //draws 2  data inputs (start end) in filter right part header
                filter_li.append($(`
                    <div class = 'filter-item-div'>
                        <p>${item.name}</p>
                        <label for = "${item.alias}2" >Start Date</label>
                        <input type="date" id = "${item.alias}1" value = "${item.list['value1']}"/>
                        <label for = "${item.alias}2" >End Date</label>
                        <input type="date" id = "${item.alias}1" value = "${item.list['value2']}"/>
                     </div>`));
                has_checkbox = true;
                break;
            case 'link':
            case 'action':
            case 'status':
            case 'html':
                //in this cases it does not draw anything, yet it just consoles
                //this types should be find by search input
                console.log('type is link, action, status, html');
                break;
            default:
                //if type is written incorrect or there is new type, shows error in console
                console.error(`type: ${item.type} - is unknown`);
        }
        filter_li.append($(`<div><button type= 'button' data-close-id = 'field-block-${item.alias}' class = 'mid-close-icon hid-btn'><i class="fas fa-times"></i></button></div>`));
        //if types are not link/action/status/html in add filed in filter right part popup do not need checkboxes to be added and fields to be drawn
        if (has_checkbox){
            filter_right_part_header.append(filter_li);
            //adds checkbox to toggle right part filter field
            add_field_container.append($(`
                <div class="c-checkbox" >
                    <input type = 'checkbox' id = 'field-block-${item.alias}' class="add-field-label"  data-mid = ${item.alias}  ${item.is_visible ? "checked" : null}/>
                    <label for = 'field-block-${item.alias}' >${item.name}</label>
                </div>`));
        }

    });
     return filter_right_part_header;
}

/**
 * "filterItemSelect" draws range in filter right part header
 * @param item
 * @param search_item
 */
function filterItemSelect(item: SearchListDATA, search_item:any ) {
    let select_div: JQuery = $(`              
        <div class = 'filter-item-div'>
            <select class = 'single-select'></select>
        </div>`);
    $('select', select_div).append($(`<option value="0">${item.name}</option>`));
    let length = item.list.list.length;
    let list = item.list.list;
    for (let i = 0; i < length; i++) {
        let option = list[i];
        if (option.value === i + 1) {
            $('select', select_div).append($(`<option value="${option.value}" selected>${option.name}</option>`));
        } else {
            $('select', select_div).append($(`<option value="${option.value}">${option.name}</option>`));
        }
    }
    return select_div;
}

/**
 * "filterItemSelectTwo" draws select2 in filter right part header
 * @param item
 * @param search_item
 */

function filterItemSelectTwo(item: SearchListDATA, search_item:any) {
    let select_two_div: JQuery = $(`           
        <div class = 'filter-item-div'>
           <select class="select2-selection--multiple js-states form-control" multiple="multiple"></select>
        </div>`);
    let list_length: number = item.list.list.length;
    let value_length: number = item.list.value.length;
    $('select', select_two_div).append($(`<option></option>`));
    for (let i = 0; i < list_length; i++) {
        let isSelected: boolean = false;
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
        } else {
            $('select', select_two_div).append($(`<option value="${option.value}">${option.name}</option>`));
        }
    }
    <any>$(".select2-selection--multiple", select_two_div).select2(
        {
            placeholder: item.name,
            width: '100%',
        }
    );
    return select_two_div;
}

/**
 * "searchRange" draws range in filter right part header
 * @param item
 * @param search_item
 */
function searchRange(item: SearchListDATA, search_item: any) {
    let list = item.list;
    let range_tooltip_right: JQuery = $(`<div class = 'ui-tooltip tooltip-right'>${list.value1}</div>`);
    let range_tooltip_left: JQuery = $(`<div class = 'ui-tooltip tooltip-right'>${list.value2}</div>`);
    let search_range: JQuery = $(`            
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
        slide: function (event, ui: SliderUIParams) {
            $(`#${item.alias}`, search_range).val(`${ui.values[0]} - ${ui.values[1]}`);
            range_tooltip_left.text(ui.values[1]);
            range_tooltip_right.text(ui.values[0]);
        }
    }).find(".ui-slider-handle").each(function (key, value) {
        key !== 0 ? value.append(range_tooltip_left[0]) : value.append(range_tooltip_right[0]);
    })

    $(`#${item.alias}`, search_range).val($(`#${item.alias}-slider-range`, search_range).slider("values", 0) +
        " - " + $(`#${item.alias}-slider-range`, search_range).slider("values", 1));

    return search_range;
}

/*
 * "addSearchListeners" adds listeners to search filter bar and search
 */
function addSearchListeners():void {
    let html_body:JQuery =$('body');
    //======================== toggles filter bar by clicking on search input
    $('.all-search-box .search-input-container').on('click', function (): void {
        $('#filter-bar').toggle();
    });
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
        console.log(1)
        // $('.grand-filter-div').removeClass('grand-filter-toggle');
        $(this).addClass('grand-filter-toggle');
    });
    //======================== opens input that adds new main filter
    $('.all-search-box #add-grand-filter').on('click', function (): void {
        $(`.new-grand-filter`).show();
        $(`.filter-footer-shown`).hide();
        $(`.filter-footer-hidden`).show();
        $('#add-grand-filter').prop('disabled', true);
        $('#change-grand-filter').prop('disabled', true);
    });
    //======================== opens popup with checkboxes on filter bar right part header that add fields
    $('.all-search-box #table-add-field-btn').on('click', function (): void {
        $('#add-field-toggle-block').toggle();
    });
    //======================== must restore
    $('.all-search-box #restore-default-fields').on('click', function (): void {
        alert('must get data and draw search right part header');
    });
    //======================== cancels left part actions
    $('.all-search-box #filter-footer-cancel').on('click', function (): void {
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
    //======================== saves left part actions
    $('.all-search-box #save-filter-fields').on('click', function (): void {
        const grand_span_drug: JQuery = $('grand-span-drug');
        let shown_footer: boolean = true;
        if (grand_span_drug.is(":visible")) {
            alert('changes are saved');
            $(`.grand-span`).hide();
            $('.grand-span.down').show();
            $('.grand-span-name').prop('readonly', true);
            grand_span_drug.hide();
        } else {
            let new_grand_filter: JQuery = $(`#new-grand-filter`);
            let new_grand_filter_value: any = new_grand_filter.val();
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
            } else {
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
    $('.all-search-box #reset-filter').on('click', function (): void {
        alert('must do something');
    });
    //======================== deletes current main filter
    $('.main-filters .grand-close').on('click', function (): void {
        $(this).closest('.grand-filter-div').remove();
    });
    //======================== makes current main filter editable
    $('.main-filters .grand-edit').on('click', function (): void {
        $(this).closest('.grand-filter-div').find('input').removeAttr('readonly');
        $(this).closest('.grand-filter-div').addClass('editable-filter');
    });
    //========================
    $('.main-filters .grand-pinned').on('click', function (): void {
        $(this).closest('.grand-filters-block').find('.down').toggleClass("down");
        $(this).toggleClass("down");
    });
    //======================== toggles right part filter field
    $('.filter-field-drop .add-field-label').on('click', function ():void {
        const elem = $(this).attr('data-mid');
        $(`#${elem}`).toggle();
    });
    //======================== hides right part filter field
    $('#draggable-container .mid-close-icon').on('click', function ():void {
        $(this).closest('.filter-item-toggle-div').hide();
        const elem = $(this).attr('data-close-id');
        $(`#${elem}`).prop("checked", false);
    });
    //======================== left part main filters are draggable
    $('.grand-filters-block .main-filters').sortable({
        //@ts-ignore
        containerSelector: '.main-filters',
        placeholder: "<div class = 'placeholder'></div>",
        itemSelector: '.grand-filter-div',
        pullPlaceholder:true,
        handle: '.grand-span-drug',
        axis: "y",
        onDrag:  function ($item:any, position:any, _super:any,) {
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
        pullPlaceholder:true,
        placeholder: '<div class = "placeholder"></div>',
        afterMove:  function ($placeholder:any) {
            $placeholder.css({
                height: "50px",
                width: 'auto',
            });
        },
        //@ts-ignore
        onDrop: function ($item:any, container:any, _super ) {
            _super($item, container);
        }
    }).disableSelection();

    html_body.on('click', function (e): void {
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
