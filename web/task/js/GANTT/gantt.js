function createTaskGantt (midObj){
    var data_row_id = 1;
    function getOrderGanttContent(gant_list, addGanttBooll = true, start = false ,showKf = false) {

        let div_size = { size: 1 };
        var kf = 1.4;
        let active_call_type = localStorage.getItem('active_call_type');
        if(showKf) {
            if (active_call_type == 'day') {
                kf = 60 * (60 / (24 * 6.45));
            } else if (active_call_type == 'mount') {
                kf = 60 * 7.83;
            }
        }
        let parentClass = this;
        let gant_list_id, gant_list_parent_id, gant_list_link_type, rsForNormalLength;
        let pe, ps, nLength, etapName, etapId, operation_id;
        $('.gant').empty();
        $('.gantt-col-1-list').empty();
        $('.gantt-col-2-list').empty();
        $('.gantt-col-3-list').empty();
        $('.gantt-col-4-list').empty();

        let data_row_id = 0;
        $('body').on('click', '.gantt-col-1-list-item', function () {
            let el = $(this).attr('data-id');
            $('.append-place').css('background', 'none');
            $('.clicked-gantt[data-id=' + el + ']').parent().parent().css('background', '#e1e1e1');
        });
        $('body .gantt-left-arrow').on('click', function () {
            let active = $(this).attr('data-active');
            if (active == 'false') {
                $('.gantt-left-col-3,.gantt-left-col-2').animate({
                    width: 0,
                }, 150);
                $('.gantt-left-col-1').css({ 'border-right': 0 });
                $(this).find('img').css('transform', 'rotate(180deg)');
                $(this).attr('data-active', 'true');
                $('#my_calendar_en').rescalendar({
                    id: 'my_calendar_en',
                    format: 'YYYY-MM-DD',
                    refDate: moment().format('YYYY-MM-DD'),
                    jumpSize: 0,
                    calSize: 19,
                    locale: 'ru',
                    disabledDays: [],
                    disabledWeekDays: [],
                    data: {}
                });
            }
            else {
                $('.gantt-left-col-3').animate({
                    width: 150,
                }, 150);
                $('.gantt-left-col-2').animate({
                    width: 45,
                }, 150);
                $(this).find('img').css('transform', 'rotate(360deg)');
                $(this).attr('data-active', 'false');
                $('#my_calendar_en').rescalendar({
                    id: 'my_calendar_en',
                    format: 'YYYY-MM-DD',
                    refDate: moment().format('YYYY-MM-DD'),
                    jumpSize: 0,
                    calSize: 16,
                    locale: 'ru',
                    disabledDays: [],
                    disabledWeekDays: [],
                    data: {}
                });
            }
        });
        $('body .show-filter').on('click', function () {
            let active = $(this).attr('data-active');
            if (active == 'false') {
                $(this).parent().find('.filter-modal').show();
                $(this).parent().find('.overlay').show();
                $(this).attr('data-active', 'true');
            }
            else {
                $(this).parent().find('.filter-modal').hide();
                $(this).parent().find('.overlay').hide();
                $(this).attr('data-active', 'false');
            }
        });
        $('body .filter-button .overlay').on('click', function (e) {
            if (!$(this).hasClass('show-filter')) {
                $('body .filter-button').find('.filter-modal').hide();
                $('body .overlay').hide();
            }
        });

        setTimeout(() => {
            drawGant($('body .gant2'), gant_list, div_size, kf);
            let i = 0;
            $('.clicked-gantt').first().find('.beforeGantLateHorizonLineGray').show();
            $('.clicked-gantt').first().find('.beforeGantLateLineGray').show().width('30px');
            $('.clicked-gantt').last().find('.afterGantLateHorizonLineGray').show();
            $('.clicked-gantt>div').each(function () {
                let link_type = $(this).closest('.append-place').next().find('.clicked-gantt').attr('data-link-type');
                if (parseInt(link_type) == 4) {
                    let left_ = $(this)[0].offsetLeft + $(this).width();
                    $(this).closest('.append-place').next().find('.header-div').css('margin-left', left_ + 'px');
                }
                i++;
            });
            let start = new Date(div_size.start) / 1000 / 60 / kf;
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var hour = d.getHours();
            var minute = d.getMinutes();
            var output = d.getFullYear() + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                (('' + day).length < 2 ? '0' : '') + day + ' ' + hour + ':' + minute;
            let current = new Date(output) / 1000 / 60 / kf;
            let res = current - start;
            $('.gant').scroll(function () {
                $('.create-cicle-icon-gantt').css({ 'left': $(this).scrollLeft() });
            });
            let toolTypeMrLeft = $('.lateLineGant').width();
            if ($('.lateLineGant').css('display') !== 'none') {
                $('.gatnSToolTip').css('margin-left', toolTypeMrLeft);
            }
            $('.c-toolType').last().find('.c-triangle-toolType-top').removeClass('c-triangle-toolType-top').addClass('c-triangle-toolType-bottom');
            $('.c-toolType').last().css('top', '-60px');
            $('.append-place .left-head-div').each(function () {
                let mid_width = $(this).next().width();
                let right_width = $(this).next().next().width();
                if (mid_width > 0 && right_width > 0) {
                    $(this).css('border-radius', '4px 0px 0px 4px');
                    $(this).next().next().css('border-radius', '0px 4px 4px 0px');
                }
                else if (right_width <= 0 && mid_width > 0) {
                    $(this).css('border-radius', '4px 0px 0px 4px');
                    $(this).next().css('border-radius', '0px 4px 4px 0px');
                }
                else {
                    $(this).css('border-radius', '4px 0px 0px 4px');
                }
            });
        }, 1000);
    }


    function drowRelations(item, getted_link_type_id, dataId, dataParentId) {
        if (getted_link_type_id === 2 && dataId === dataParentId) {
            $(item).find('.firstLeftRelation').addClass('border-view1');
            $(item).closest('.append-place').prev().find('.secondLeftRelation').addClass('border-view3');
            let itemMarginLeft = parseInt($(item).find('.header-div')[0].style.marginLeft);
            let itemMarginLeftPrev = parseInt($(item).closest('.append-place').prev().find('.header-div')[0].style.marginLeft);
            if (itemMarginLeft > itemMarginLeftPrev) {
                let resultMathMinus1 = itemMarginLeft - itemMarginLeftPrev;
                let currentWidth = $(item).find('.firstLeftRelation').width();
                let currentLeft = $(item).find('.firstLeftRelation')[0].offsetLeft;
                $(item).find('.firstLeftRelation').css({
                    'width': +resultMathMinus1 + currentWidth + 1,
                    'left': -resultMathMinus1 + currentLeft
                });
            }
            else if (itemMarginLeft < itemMarginLeftPrev) {
                let resultMathMinus2 = itemMarginLeftPrev - itemMarginLeft;
                let else_version = $(item).closest('.append-place').prev().find('.secondLeftRelation');
                let currentWidth = $(item).find('.secondLeftRelation').width();
                let currentLeft = $(item).find('.secondLeftRelation')[0].offsetLeft;
                else_version.css({
                    'width': +resultMathMinus2 + currentWidth + 1,
                    'left': -resultMathMinus2 + currentLeft
                });
            }
        }
        else if (getted_link_type_id === 3 && dataId === dataParentId) {
            $(item).find('.firstRightRelation').addClass('border-view2');
            $(item).closest('.append-place').prev().find('.secondRightRelation').addClass('border-view4');
            if (isNaN(rsTestForRemoveWidth.rs)) {
                $(item).find('.right-head-div').css('width', 0);
                $(item).find('.mid-head-div').css('width', 0);
                $(item).closest('.append-place').prev().find('.mid-head-div').css('width', 0);
                $(item).closest('.append-place').prev().find('.right-head-div').css('width', 0);
            }
            let rightRelSize = item.getBoundingClientRect().right;
            let rightRelSizePrev = $(item).closest('.append-place').prev().find('.header-div')[0].getBoundingClientRect().right;
            if (rightRelSize > rightRelSizePrev) {
                let resultMathMinus1 = rightRelSize - rightRelSizePrev;
                let currentWidth = $(item).find('.secondRightRelation').width();
                $(item).closest('.append-place').prev().find('.secondRightRelation').css({ 'width': currentWidth + resultMathMinus1, });
            }
            else if (rightRelSize < rightRelSizePrev) {
                let resultMathMinus2 = rightRelSizePrev - rightRelSize;
                let herselfWidth = $(item).find('.firstRightRelation')[0].offsetWidth;
                $(item).find('.firstRightRelation').css('width', resultMathMinus2 + herselfWidth);
            }
        }
        else if (getted_link_type_id === 4 && dataId === dataParentId) {
            $(item).find('.firstLeftRelation').addClass('border-view5to7');
            $(item).closest('.append-place').prev().find('.secondRightRelation').addClass('border-view6to8');
        }
    }

    function drawElement() {
        data_row_id++;
        let normal_length_html;
        normal_length_html = ``;
        return `<div  class="div append-place"  data-row-id="${data_row_id}" data-id="${etapId}" style="height: 22px" >
                 <!-- two relation div -->
                <div class="draggable2 over-div">
                  <div   data-rs="" class=" clicked-gantt  ui-widget-content drag-sect  for-modal-text" data-planning-start="${ps}" data-planning-end="${pe}" data-normal-length="${nLength}" data-link-type="${gant_list_link_type}" data-parent="${gant_list_parent_id}" data-id="${gant_list_id}" data-child-width="" style="height: 22px">
                  <div class="d-flex h-100 header-div get-gantt getModalForm" data-toggle="modal" data-target="#exampleModal" >
                  <div class="c-toolType gatnSToolTip" style="display: none">
                  <div class="c-toolType-header">
                  </div>
                  <div class="c-triangle-toolType-top">
                  </div>
                  <div  class="c-toolType-body">
                      ${etapName}
                      </div>
                   </div>
                        <div class="left_relation_grup">
                            <div class="firstLeftRelation">&nbsp;</div>
                            <div class="secondLeftRelation">&nbsp;</div>
                                <span class="arrowForRelations">
                                <svg width="15" height="15" viewBox="0 0 405 405" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                    <path d="M108.669 404.375C104.489 404.375 100.832 402.808 97.6981 399.673C91.4291 393.404 91.4291 383.477 97.6981 377.73L273.763 202.187L97.6981 26.645C91.4291 20.376 91.4291 10.449 97.6981 4.70199C103.967 -1.56701 113.894 -1.56701 119.641 4.70199L306.678 191.216C309.813 194.351 311.38 198.008 311.38 202.187C311.38 206.367 309.813 210.546 306.678 213.158L119.641 399.673C116.506 402.808 112.849 404.375 108.669 404.375Z" fill="#E8E7E6"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0">
                                    <rect width="404.375" height="404.375" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                                </span>
                        </div>
                          <div class="beforeGantLateHorizonLineGray">&nbsp;</div>
                          <div class="beforeGantLateLineGray" >&nbsp;</div>
                          <div class="status_2 beforeGantLateLine" style="width:0px;">&nbsp;</div>
                          <div class="left-head-div gantt-div" style="width: 0">
                              <div class="left-head-div-child">&nbsp;</div>
                          </div>
                          <div class="mid-head-div gantt-div" style="width: 0">
                              <div class="mid-head-div-child">&nbsp;</div>
                          </div>
                            <div class="orange-head-div " style="width: 0px;">
                              <div class="orange-head-div-child">&nbsp;</div>
                          </div>
                          <div class="right-head-div gantt-div" style="width: 0">
                              <div class="right-head-div-child">&nbsp;</div>
                          </div>
                          <div class="afterGantLateHorizonLineGray" >&nbsp;</div>
                         
                          <div class="right_relation_grup">
                                 <span class="delete-cicle-icon-gantt"><i class="fas fa-times-circle iconDelete"></i></span>
                                <div class="firstRightRelation">
                                &nbsp;
                                </div>
                                <div class="secondRightRelation">
                                &nbsp;
                                </div>
                            </div>
                            ${normal_length_html}
                      </div>
                  </div>
                  <!-- two relation div -->
                </div>
          </div>`;
    }

    function drawGant(html_object, gant_list, div_size, kf) {

        let rsTestForRemoveWidth;
        if (gant_list) {

            for (let i = 0; i < gant_list.length; i++) {
                $('.gantt-left-cols-box').find(`.gantt-left-col-1,  .gantt-left-col-2, .gantt-left-col-3`).show();
                gant_list_id = gant_list[i].id;
                gant_list_parent_id = gant_list[i].parent_id;
                gant_list_link_type = gant_list[i].link_type;
                rsForNormalLength = gant_list[i].times.real.start;
                ps = gant_list[i].times.planing.start;
                pe = gant_list[i].times.planing.end;
                nLength = gant_list[i].normal_length / kf;
                etapName = gant_list[i].etap_name;
                etapId = gant_list[i].id;
                operation_id = gant_list[i].operation_id;
                user_name = gant_list[i].user_name;
                $('.gantt-col-1-list').append(`<div class="gantt-col-list-item gantt-col-1-list-item" data-id="${etapId}"><span>${etapName}</span></div>`);
                $('.gantt-col-2-list').append(`<div class="gantt-col-list-item gantt-col-2-list-item"><span class="tree-priority-point tree-priority-color-` + gant_list[i].priority + `"><span>[` + gant_list[i].priority + `]</span></span></div>`);
                $('.gantt-col-3-list').append(`<div class="gantt-col-list-item gantt-col-3-list-item"><span>${user_name}</span></div>`);
                // $('.gantt-col-4-list').append(`<div class="gantt-col-list-item gantt-col-4-list-item"><span>${operation_id}</span></div>`);
                let date_list_obj = {
                    ps: new Date(gant_list[i].times.planing.start) / 1000 / 60 / kf,
                    pe: new Date(gant_list[i].times.planing.end) / 1000 / 60 / kf,
                    rs: new Date(gant_list[i].times.real.start) / 1000 / 60 / kf,
                    re: new Date(gant_list[i].times.real.end) / 1000 / 60 / kf
                };

                let loc_div_size_start = new Date(div_size.start) / 1000 / 60 / kf;
                let loc_div_size_end = new Date(div_size.end) / 1000 / 60 / kf;
                let loc_div_size = div_size.size;
                let sortable = [];
                for (let result in date_list_obj) {
                    sortable.push([result, date_list_obj[result]]);
                }
                sortable.sort(function (a, b) { return a[1] - b[1]; });
                let item = $(drawElement());
                item.find('.normal-length').css({
                    width: gant_list[i].normal_length * loc_div_size,
                    position: 'relative',
                    height: 30,
                    border: '1px solid grey',
                });
                let j = 0, norm = 0;
                rsTestForRemoveWidth = date_list_obj;
                item.find('.header-div').children('.gantt-div').each(function () {
                    $(this).css({ 'z-index': 2 });
                    let width = (sortable[j + 1][1] - sortable[j][1]) * loc_div_size;
                    $(this).css({ width: width });
                    if (sortable[j][1] >= date_list_obj.ps && sortable[j + 1][1] <= date_list_obj.pe) {
                        $(this).css({ background: '#e8e7e6' });
                        $(this).children().css({ background: '#9e9e9e' });
                        $(this).addClass('resize-grey');
                    }
                    var f = false;
                    if (sortable[j][1] >= Math.max(date_list_obj.ps, date_list_obj.rs) && sortable[j + 1][1] <= Math.min(date_list_obj.pe, date_list_obj.re)) {
                        $(this).css({ background: 'rgb(183,209,186)' });
                        $(this).children().css({ background: '#007bff' });
                        $(this).removeClass('resize-grey');
                        $(this).closest('.clicked-gantt').addClass('not-resize');
                        $(this).parent().parent().parent().removeClass('draggable2');
                        if (sortable[3][0] == 're' && sortable[1][0] == 'rs') {
                            norm = (sortable[3][1] - sortable[1][1]);
                        }
                        if (sortable[2][0] == 're' && sortable[1][0] == 'rs' && sortable[0][0] == 'ps' && sortable[3][0] == 'pe') {
                            norm = (sortable[2][1] - sortable[1][1]) + (sortable[3][1] - sortable[2][1]);
                        }
                        $(this).closest('.clicked-gantt').find('.delete-cicle-icon-gantt').remove();
                    }
                    j++;
                });
                $(item).find('.normal-length').css({ left: -(norm) });
                html_object.append(item);
                let html_ob_green = '', html_ob_orange = '', global_width = 0, global_width_orange = 0;
                for (let it in gant_list[i].times.all) {

                    let start = new Date(gant_list[i].times.all[it].time) / 1000 / 60 / kf;
                    let end = new Date(gant_list[i].times.all[it].end) / 1000 / 60 / kf;
                    let tot = parseInt(end - start);
                    if (date_list_obj.re > date_list_obj.pe) {
                        if (start < date_list_obj.re && end < date_list_obj.re) {
                            html_ob_green += '<span class="gant_block status_' + gant_list[i].times.all[it].status_id + '" style="display:inline-block;width:' + tot + 'px;height: 12px">&nbsp;<span >&nbsp;</span></span>';
                        }
                        else if (start < date_list_obj.re && end > date_list_obj.re) {
                            let green_blok = date_list_obj.re - start;
                            html_ob_green += '<span class="gant_block status_' + gant_list[i].times.all[it].status_id + '" style="display:inline-block;width:' + green_blok + 'px;height: 12px">&nbsp;<span >&nbsp;</span></span>';
                            let orange_blok = end - date_list_obj.re;
                            html_ob_orange += '<span class="gant_block status_' + gant_list[i].times.all[it].status_id + '" style="display:inline-block;width:' + orange_blok + 'px;height: 12px">&nbsp;<span >&nbsp;</span></span>';
                        }
                        else {
                            html_ob_orange += '<span class="gant_block status_' + gant_list[i].times.all[it].status_id + '" style="display:inline-block;width:' + tot + 'px;height: 12px">&nbsp;<span >&nbsp;</span></span>';
                        }
                    }
                    else {
                        html_ob_green += '<span class="gant_block status_' + gant_list[i].times.all[it].status_id + '" style="display:inline-block;width:' + tot + 'px;height: 12px">&nbsp;<span >&nbsp;</span></span>';
                    }
                }
                html_ob_green += '<span class="status_1 right-head-div-last" style="display:inline-block;width:0px;height: 12px">&nbsp;<span >&nbsp;</span></span>';
                $(item).find('.mid-head-div-child').html(html_ob_green);
                $(item).find('.right-head-div-child').html(html_ob_orange);
                let bet = 0, minus_width = 0;
                if (gant_list[i - 1] != undefined) {
                    if ((new Date(gant_list[i].times.planing.end) / 1000 / 60 / kf) > (new Date(gant_list[i].times.real.end) / 1000 / 60 / kf)) {
                        if (gant_list[i + 1]) {
                            bet = (new Date(gant_list[i + 1].times.real.start) / 1000 / 60 / kf) - (new Date(gant_list[i].times.planing.end) / 1000 / 60 / kf);
                        }
                        else {
                            bet = (Date.now() / 1000 / 60 / kf) - (new Date(gant_list[i].times.planing.end) / 1000 / 60 / kf);
                        }
                        $(item).find('.beforeGantLateLine').css('width', bet + 'px');
                    }
                    else {
                        let bet = 0;
                        if (gant_list[i + 1]) {
                            bet = (new Date(gant_list[i + 1].times.real.start) / 1000 / 60 / kf) - (new Date(gant_list[i].times.real.end) / 1000 / 60 / kf);
                        }
                        else {
                            bet = (Date.now() / 1000 / 60 / kf) - (new Date(gant_list[i].times.real.end) / 1000 / 60 / kf);
                        }
                        $(item).find('.beforeGantLateLine').css('width', bet + 'px');
                    }
                }
                if ($(item).find('.mid-head-div-child .gant_block').length > 0) {
                    global_width_orange = 0;
                    $(item).find('.mid-head-div-child .gant_block').each(function () {
                        global_width_orange += $(this).width();
                        if ($(this).hasClass('status_3') || $(this).hasClass('status_2')) {
                            minus_width = minus_width + parseInt($(this).width());
                        }
                    });
                    let Rwidth = $(item).find('.right-head-div').width();
                    $(item).find('.right-head-div').css('width', (Rwidth - minus_width) + 'px');
                    $(item).find('.mid-head-div').css('width', global_width_orange + 'px');
                }
                let wp = date_list_obj.pe - date_list_obj.ps;
                let w = date_list_obj.pe - date_list_obj.ps - global_width_orange;
                if (date_list_obj.re > date_list_obj.pe) {
                    if (w > 0 && global_width_orange > 0) {
                        $(item).find('.right-head-div-last').css('width', w + 'px');
                        $(item).find('.mid-head-div').css('width', wp + 'px');
                    }
                }
                else {
                    let total_width = parseInt($(item).find('.clicked-gantt').attr('data-normal-length'));
                    let left_width = parseInt($(item).find('.left-head-div').width());
                    let mid_width = parseInt($(item).find('.mid-head-div').width());
                    $(item).find('.right-head-div').attr('data-width', (total_width - left_width - mid_width) + 'px');
                    $(item).find('.right-head-div').css('width', (total_width - left_width - mid_width) + 'px');
                }
                if ($(item).find('.right-head-div-chaild .gant_block').length > 0) {
                    $(item).find('.right-head-div-chaild .gant_block').each(function () {
                        global_width += $(this).width();
                    });
                    $(item).find('.right-head-div').css('width', global_width + 'px');
                }
            }
        }
        $.each($('.clicked-gantt'), (index, item) => {
            let getted_link_type_id = $(item).data('link-type');
            let dataId = $(item).data('id');
            let dataParentId = $(item).closest('.append-place').next().find('.clicked-gantt').data('parent');
            if ($(item).closest('.append-place').next().length === 0) {
                let lastDataParentId = $(item).data('parent');
                let lastPrevItemDAta = $(item).closest('.append-place').prev().find('.clicked-gantt').data('id');
                if (lastDataParentId === lastPrevItemDAta) {
                    drowRelations(item, getted_link_type_id, lastDataParentId, lastPrevItemDAta);
                }
            }
            else if ($(item).closest('.append-place').next().length && getted_link_type_id === 4) {
                $(item).find('.firstLeftRelation').addClass('border-view5to7');
                $(item).closest('.append-place').prev().find('.secondRightRelation').addClass('border-view6to8');
            }
            drowRelations(item, getted_link_type_id, dataId, dataParentId);
        });

    }

    setTimeout(function () {
        $('.arrowForRelations')[0].remove();
        $('.main-content-tab-wrap .calendar').html('<div class="rescalendar" id="my_calendar_en"></div>');
        // @ts-ignore
        $('#my_calendar_en').rescalendar({
            id: 'my_calendar_en',
            format       : 'YYYY-MM-DD',
            //@ts-ignore
            refDate      : moment().format( 'YYYY-MM-DD' ),
            jumpSize     : 0,
            calSize      : 16,
            locale       : 'ru',
            disabledDays : [],
            disabledWeekDays: [],
            data: {}
        });
        $('body .main-content-tab-wrap .gantt-left-arrow').on('click',function(){
            let active = $(this).attr('data-active');
            if(active == 'false'){
                $('.gantt-left-col-3,.gantt-left-col-2').animate({
                    width: 0,
                }, 150);
                $('.gantt-left-col-1').css({'border-right': 0});
                $(this).find('img').css('transform','rotate(180deg)');
                $(this).attr('data-active','true');
                //@ts-ignore
                if(localStorage.getItem('active_call_type') =='day') {
                    //@ts-ignore
                    $('#my_calendar_en').rescalendar({
                        id: 'my_calendar_en',
                        format: 'YYYY-MM-DD',
                        //@ts-ignore
                        refDate: moment().format('YYYY-MM-DD'),
                        jumpSize: 0,
                        calSize: 19,
                        locale: 'ru',
                        disabledDays: [],
                        disabledWeekDays: [],
                        data: {}
                    });
                }
            } else {
                $('.gantt-left-col-3').animate({
                    width: 150,
                }, 150);
                $('.gantt-left-col-2').animate({
                    width: 45,

                }, 5000);

                $(this).find('img').css('transform','rotate(360deg)');
                $(this).attr('data-active','false');
                if(localStorage.getItem('active_call_type') =='day') {
                    //@ts-ignore
                    $('#my_calendar_en').rescalendar({
                        id: 'my_calendar_en',
                        format: 'YYYY-MM-DD',
                        //@ts-ignore
                        refDate: moment().format('YYYY-MM-DD'),
                        jumpSize: 0,
                        calSize: 16,
                        locale: 'ru',
                        disabledDays: [],
                        disabledWeekDays: [],
                        data: {}
                    });
                }
            }
        });
        $('body .main-content-tab-wrap .show-filter').on('click',function(){
            let active = $(this).attr('data-active');
            if(active == 'false'){
                $(this).parent().find('.filter-modal').show();
                $(this).parent().find('.overlay').show();
                $(this).attr('data-active','true');

            } else {
                $(this).parent().find('.filter-modal').hide();
                $(this).parent().find('.overlay').hide();
                $(this).attr('data-active','false');
            }
        });
        $('body .filter-button .overlay').on('click',function(e){
            if(!$(this).hasClass('show-filter')) {
                $('body .main-content-tab-wrap .filter-button').find('.filter-modal').hide();
                $('body .main-content-tab-wrap .overlay').hide();

            }
        });
        $('.beforeGantLateLineGray').remove();
        $('.beforeGantLateLine').remove();





    },3000);

    function editData (data= []) {
        let start ;
        let resData = [
        ];
        for (let i = 0; i < data.length; i++ ) {
            $.each( data[i], function( key, value ) {
                let end ;
                if (key == 'id') {
                    midObj.id = value    ;
                    midObj.operation_id = value;
                }
                if (key == 'start_date') {
                    midObj.times.planing.start = value;
                    start = Number(Date.parse(value));
                }
                if (key == 'finish_date') {
                    midObj.times.planing.end = value;
                    end = Number(Date.parse(value));
                    let res = (end - start);
                    midObj.normal_length = res / 1000 / 60;
                }
                if (key == 'begin_date') {
                    midObj.times.real.start = value    ;
                }
                if (key == 'done_date') {
                    midObj.times.real.end = value    ;
                }
            });
            resData.push(midObj);
        }
        // getOrderGanttContent(editData(resData), false, false);
    }
    getOrderGanttContent(midObj, false, false);
    setTimeout(()=>{
        $( function() {
            let oldSize, newSize,sumOldNewSizes;
            let leftDivWidth , midDivWidth,orangeDivWidth;
            $( ".header-div" ).resizable({
                containment: ".append-place",
                handles: 'e',
                // grid: 20,
                start: function( event, ui ) {
                    leftDivWidth  = $(ui.element[0]).find('.left-head-div').width();
                    midDivWidth = $(ui.element[0]).find('.mid-head-div').width();
                    orangeDivWidth = $(ui.element[0]).find('.orange-head-div').width();
                },
                resize: function( event, ui ) {
                    let self = $(this);
                    $(this).find('.left-head-div').css({
                        minWidth: leftDivWidth+'px',
                        maxWidth: leftDivWidth+'px',
                    });
                    $(this).find('.mid-head-div').css({
                        minWidth: midDivWidth+'px',
                        maxWidth: midDivWidth+'px',
                    });
                    $(this).find('.orange-head-div').css({
                        minWidth: orangeDivWidth+'px',
                        maxWidth: orangeDivWidth+'px',
                    });
                    $(this).find('.right-head-div').width('100%');
                    oldSize = ui.originalSize.width;
                    newSize = ui.size.width;
                },
                stop: function( event, ui ) {
                    let checkLinkType = $(this).closest('.append-place').nextAll().find('.clicked-gantt');
                    let self = $(this);
                    let itemsML = [];
                    function checkType (item) {

                        for (let i =0; i < item.length;i++) {

                            if ($(item[i]).attr('data-link-type') == 4 )  {


                                if (oldSize < newSize) {
                                    sumOldNewSizes = newSize - oldSize;
                                    let oldMarginLeft = parseInt($(item[i]).find('.header-div').css('margin-left'));
                                    let res = oldMarginLeft + sumOldNewSizes ;
                                    $(item[i]).find('.header-div').css('margin-left',res+'px' )
                                    checkType(item[i]);
                                }else {
                                    sumOldNewSizes = oldSize - newSize;
                                    let oldMarginLeft = parseInt($(item[i]).find('.header-div').css('margin-left'));
                                    let res = parseInt(oldMarginLeft) - sumOldNewSizes ;
                                    $(item[i]).find('.header-div').css('margin-left',res+'px' )
                                    checkType(item[i]);
                                }



                            } else {
                                return false;
                            }
                        }
                    }
                    checkType(checkLinkType);
                    let thisPlanningEnd = ui.element[0].closest('.clicked-gantt').getAttribute('data-planning-end');
                    let fromDateToNumber = Date.parse(thisPlanningEnd);
                    let newWidth = ui.element[0].clientWidth ;
                    let oldWidth =ui.originalSize.width;
                    let type = $('.set-date-type').children("option:selected").val();
                    let newPlanningEndVal;
                    if (type === 'not-set'){newPlanningEndVal = (fromDateToNumber + ((newWidth - oldWidth)  * 60 * 60 * 1000  / 6.45  ));}
                    else if (type === 'month'){newPlanningEndVal = (fromDateToNumber + ((newWidth - oldWidth)  * 60 * 60 * 1000 * 24 * 30 / 60  ));}
                    else{newPlanningEndVal = (fromDateToNumber + ((newWidth - oldWidth)   * 60 * 1000     ));}
                    let newPlanningEnd = new Date(newPlanningEndVal);
                    let taskId =  ui.element[0].closest('.clicked-gantt').getAttribute('data-id');
                    let newPlanningDate = newPlanningEnd.getFullYear() + '-' +('0' + (newPlanningEnd.getMonth()+1)).slice(-2)+ '-' +  ('0' + newPlanningEnd.getDate()).slice(-2) + ' '+newPlanningEnd.getHours()+ ':'+('0' + (newPlanningEnd.getMinutes())).slice(-2)+ ':'+newPlanningEnd.getSeconds();
                    ui.element[0].closest('.clicked-gantt').setAttribute('data-planning-end', newPlanningDate ) ;
                    let newInfo = [{id : taskId,planning_end : newPlanningDate}];
                    console.log(newInfo);
                }
            });

        } );
    },1000);
    $(function marginLeftItems () {
        let currDate = `${createDateForGantt (moment().startOf('day').format())}`;
        let startsDateInt = Number(Date.parse(currDate));
        console.log(Number(Date.parse(currDate)));
        console.log(Number(Date.parse("2020-09-08 00:00")));
        let defZoomDay = 24;
        setTimeout(()=>{
            $('body').on('change' , '.set-date-type' , function () {
                let res = $(this).children("option:selected").val();
                if (res === 'month') {
                    let defZoomMonth = 24 ;
                    let defZoomMonthSecond = 30 ;
                    headWidth(defZoomMonth , defZoomMonthSecond);
                    headMargin(defZoomMonth , defZoomMonthSecond);
                } else if (res === 'time') {
                    defZoomDay = 1;
                    headWidth(defZoomDay);
                    headMargin(defZoomDay);
                } else {
                    console.log('mtav')
                    defZoomDay = 24;
                    headWidth(defZoomDay);
                    headMargin(defZoomDay);
                }
            })
            function setAttributeForItems () {
                let divHead = $('.header-div');
                for (let i = 0 ; i < divHead.length; i++) {
                    $(divHead[i]).closest('.clicked-gantt').attr("data-child-width", $(divHead[i]).width());
                }
            }
            setAttributeForItems();
            function headWidth (res , res2=1) {
                let divHead = $('.header-div');
                for (let i = 0 ; i < divHead.length; i++) {
                    // $(divHead[i]).closest('.clicked-gantt').attr("data-child-width", $(divHead[i]).width());
                    let itemWidth = parseInt($(divHead[i]).closest('.clicked-gantt').attr('data-child-width')) / res / res2;
                    $(divHead[i]).css('width' , itemWidth+'px');
                }
            }
            headWidth(24);

            function headMargin (res,res2=1) {
                let items = $('.clicked-gantt');
                for (let i = 0; i< items.length; i++)
                {
                    let itemForML = $(items[i]).find('.header-div');
                    let planningStart = items[i].getAttribute('data-planning-start');
                    planningStart = Number(Date.parse(planningStart));
                    let result = (planningStart - startsDateInt) / 1000 / 60 / res / res2 ;
                    itemForML.css('margin-left' , result+'px');
                }
            }
            headMargin(24);

        },3000)
    })
}
