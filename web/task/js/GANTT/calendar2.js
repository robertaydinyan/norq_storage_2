(function($) {

    $.fn.rescalendar = function( options ) {
        var self = this;
        function alert_error( error_message ){

            return [
                '<div class="error_wrapper">',

                      '<div class="thumbnail_image vertical-center">',

                        '<p>',
                            '<span class="error">',
                                error_message,
                            '</span>',
                        '</p>',
                      '</div>',

                    '</div>'
            ].join('');
        }

        function set_template( targetObj, settings ){

            var template = '',
                id = targetObj.attr('id') || '';
            if( settings.refDate.length !== 10 ){
                targetObj.html( alert_error( settings.lang.no_ref_date ) );
                return false;
            }
            template = settings.template_html( targetObj, settings );
            targetObj.html( template );
            return true;
        };
        function dateInRange( date, startDate, endDate ){

            if( date == startDate || date == endDate ){
                return true;
            }

            var date1        = moment( startDate, settings.format ),
                date2        = moment( endDate, settings.format ),
                date_compare = moment( date, settings.format);

            return date_compare.isBetween( date1, date2, null, '[]' );
        }

        function dataInSet( data, name, date ){

            var obj_data = {};
            for( var i=0; i < data.length; i++){
                obj_data = data[i];
                if(
                    name == obj_data.name &&
                    dateInRange( date, obj_data.startDate, obj_data.endDate )
                ){
                    return obj_data;
                }
            }
            return false;
        }

        function setDayCells( targetObj, refDate ){

            // data - 10
            // mounth - 2
            // time - 5
            // if(refDate.length != 10){
            //     return true;
            // }
            localStorage.setItem('active_day',refDate );


            $('.rescalendar-controls-flex *').show();
            var format   = settings.format,
                f_inicio = moment( refDate, format ).subtract(settings.jumpSize, 'days'),
                f_fin    = moment( refDate, format ).add(settings.jumpSize, 'days'),
                today    = moment( ).startOf('day'),
                html            = '<td class="firstColumn"><button type="button" class="move_to_yesterday"><img src="images/Vector.svg" class="prev-date" /></button></td>',
                f_aux           = '',
                f_aux_format    = '',
                dia             = '',
                dia_semana      = '',
                num_dia_semana  = 0,
                mes             = '',
                clase_today     = '',
                clase_middleDay = '',
                clase_disabled  = '',
                middleDay       = targetObj.find('input.refDate').val();

            for( var i = 0; i< (settings.calSize + 1) ; i++){

                clase_disabled = '';
                f_aux        = moment( f_inicio ).add(i, 'days');
                f_aux_format = f_aux.format( format );

                dia        = f_aux.format('DD');
                mes        = f_aux.locale( settings.locale ).format('MMM').replace('.','');
                dia_semana = f_aux.locale( settings.locale ).format('dd');
                num_dia_semana = f_aux.day();

                f_aux_format == today.format( format ) ? clase_today     = 'today'         : clase_today = '';
                f_aux_format == middleDay              ? clase_middleDay = 'middleDay' : clase_middleDay = '';

                if(
                    settings.disabledDays.indexOf(f_aux_format) > -1 ||
                    settings.disabledWeekDays.indexOf( num_dia_semana ) > -1
                ){

                    clase_disabled = 'disabledDay';
                }
                let bg_color = '';
                if(dia_semana == 'сб' || dia_semana == 'вс'){
                    bg_color = 'style="background:rgba(255, 191, 9, 0.26);"';
                }
                html += [
                    '<td '+bg_color+' class="day_cell ' + clase_today + ' ' + clase_middleDay + ' ' + clase_disabled + '" data-cellDate="' + f_aux_format + '">',
                        '<span class="dia">' + dia + '</span>',
                        '<span class="dia_semana">' + dia_semana + '</span>',
                        '<span class="mes">' + mes + '</span>',
                        '<span class="border"></span>',
                    '</td>'
                ].join('');
            }
            $('.rescalendar-controls-flex').find('h2').text(mes);
            html += '<td class="lastColumn"><button type="button" class="move_to_tomorrow"><img src="images/Vector.svg"  /></button><span class="border"></span></td>';

            targetObj.find('.rescalendar_day_cells').html( html );
            $('.rescalendar_day_cells').css('margin-left','0px');
            addTdClickEvent( targetObj );
        }

        function addTdClickEvent(targetObj){

            let day_cell = targetObj.find('td.day_cell');
            day_cell.on('click', function(e){
                let selectedDate = $(e.currentTarget).find('.mes').text();
                $('.rescalendar-controls-flex h2').text(selectedDate);
                let cellDate = e.currentTarget.attributes['data-cellDate'].value;
                targetObj.find('input.refDate').val( cellDate );
                $('.day_cell').removeClass('active');
                let sel_id = localStorage.getItem('active_stage_id');
                let order_id = localStorage.getItem('order_id');
                let model_id = localStorage.getItem('model_id');
               // let Production = new B_Production();
                let endDate = $('.main-content-tab-wrap .day_cell').length;
                console.log(endDate);
                //Production.getModelGanttData(model_id, sel_id, order_id, cellDate);
                setDayCells(targetObj,cellDate);
                $('.middleDay').addClass('active');

            });
        }

        function addTdClickMoEvent(targetObj){

            let day_cell = targetObj.find('td.day_cell_mo');

            day_cell.on('click', function(e){

                let selectedDate = $(e.currentTarget).find('.mes').text();
                $('.rescalendar-controls-flex h2').text(selectedDate);
                let cellDate = e.currentTarget.attributes['data-cellDate'].value;
                targetObj.find('input.refDate').val( cellDate );
                $('.day_cell').removeClass('active');
                let sel_id = localStorage.getItem('active_stage_id');
                let order_id = localStorage.getItem('order_id');
                let model_id = localStorage.getItem('model_id');
               // let Production = new B_Production();
               // Production.getModelGanttData(model_id, sel_id, order_id, cellDate);
                setMonthType(cellDate);
                $('.middleDay').addClass('active');

            });
        }

        function addTdClickTeEvent(targetObj){

            let day_cell = targetObj.find('td.day_cell_te');

            day_cell.on('click', function(e){

                let selectedDate = $(e.currentTarget).find('.mes').text();
                $('.rescalendar-controls-flex h2').text(selectedDate);
                let cellDate = e.currentTarget.attributes['data-cellDate'].value;
                targetObj.find('input.refDate').val( cellDate );
                $('.day_cell').removeClass('active');
                let sel_id = localStorage.getItem('active_stage_id');
                let order_id = localStorage.getItem('order_id');
                let model_id = localStorage.getItem('model_id');
               // let Production = new B_Production();
                let old_format = cellDate;
                cellDate = localStorage.getItem('active_day')+' '+cellDate;

              //  Production.getModelGanttData(model_id, sel_id, order_id, cellDate);
                setTimeType(old_format);
                $('.middleDay').addClass('active');

            });
        }
        function change_day( targetObj, action, num_days ){

            var refDate = targetObj.find('input.refDate').val(),
                f_ref = '';
            if(num_days==1){
                if( action == 'subtract'){
                    f_ref = moment( refDate, settings.format ).subtract(num_days, 'days');
                }else{
                    f_ref = moment( refDate, settings.format ).add(num_days, 'days');
                }
            } else {
                if( action == 'subtract'){
                    f_ref = moment( refDate, settings.format ).subtract(1, 'months').startOf('month');
                }else{
                    f_ref = moment( refDate, settings.format ).add(1, 'months').startOf('month');
                }
            }


           console.log(f_ref);
            targetObj.find('input.refDate').val( f_ref.format( settings.format ) );

            $('.day_cell').removeClass('active');
            let sel_id = localStorage.getItem('active_stage_id');
            let order_id = localStorage.getItem('order_id');
            let model_id = localStorage.getItem('model_id');
           // let Production = new B_Production();

           // Production.getModelGanttData(model_id, sel_id, order_id, f_ref.format( settings.format ));
            setDayCells(targetObj,f_ref);
            $('.middleDay').addClass('active');
        }

        // INITIALIZATION
        let settings = $.extend({
            id           : 'rescalendar',
            format       : 'YYYY-MM-DD',
            refDate      : moment().format( 'YYYY-MM-DD' ),
            jumpSize     : 1,
            calSize      : 10,
            locale       : 'ru',
            disabledDays : [],
            disabledWeekDays: [],
            data: {},
            lang: {
                'init_error' : 'Error when initializing',
                'no_data_error': 'No data found',
                'no_ref_date'  : 'No refDate found',
                'today'   : 'Today'
            },

            template_html: function( targetObj, settings ){
                let id      = targetObj.attr('id'),
                    refDate = settings.refDate ;
                    currentMonth = moment().format('MMM');
                 $('.main-content-tab-wrap .filter-modal').html( `<div class="rescalendar_controls">
                          <div class="rescalendar-controls-flex">
                     <button class="move_to_last_month">
                     <svg width="10" height="10" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.598211 0.23794C0.424945 0.411206 0.424945 0.691286 0.598211 0.864552L5.15959 5.42595L0.598211 9.98733C0.424945 10.1606 0.424945 10.4407 0.598211 10.6139C0.771477 10.7872 1.05156 10.7872 1.22482 10.6139L6.09952 5.73925C6.18594 5.65283 6.22937 5.53939 6.22937 5.42593C6.22937 5.31247 6.18594 5.19903 6.09952 5.11262L1.22482 0.237919C1.05156 0.0646734 0.771477 0.0646734 0.598211 0.23794Z" fill="#474747"/>
                     </svg>
                     </button>
                      <h2>`+currentMonth+`</h2>
                     <button class="move_to_next_month">
                     <svg width="10" height="10" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.598211 0.23794C0.424945 0.411206 0.424945 0.691286 0.598211 0.864552L5.15959 5.42595L0.598211 9.98733C0.424945 10.1606 0.424945 10.4407 0.598211 10.6139C0.771477 10.7872 1.05156 10.7872 1.22482 10.6139L6.09952 5.73925C6.18594 5.65283 6.22937 5.53939 6.22937 5.42593C6.22937 5.31247 6.18594 5.19903 6.09952 5.11262L1.22482 0.237919C1.05156 0.0646734 0.771477 0.0646734 0.598211 0.23794Z" fill="#474747"/>
                     </svg>
                     </button>
                     </div>
                     <div class="set-type">
                     <select class="set-date-type">
                     <option value="not-set">дата</option>
                     <option value="month">месяц</option>
                     <option value="time">время</option>
                     </select>
                     </div>
                     </div>`);
                return [
                    '<div class="rescalendar ' , id , '_wrapper">',
                        '<div class="table-responsive">',
                            '<table class="rescalendar_table">',
                              '<input class="refDate" type="hidden" value="' + refDate + '" />',
                                '<thead>',
                                    '<tr class="rescalendar_day_cells"></tr>',
                                '</thead>',
                                '<tbody class="rescalendar_data_rows">',

                                '</tbody>',
                            '</table>',
                        '</div>',
                    '</div>',
                ].join('');
            }
        }, options);

        // Set type
        function setTimeType(refDate = false) {
            $('.rescalendar-controls-flex *').hide();
            let time_parts = [];
            let time = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00',
                        '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
            let targetObj = $('.rescalendar');
            let html = '';
            let hours = '';
            let currentTime;
            if(!refDate) {
                currentTime = moment().format('HH');
            } else {
                currentTime = refDate;
            }
            let cut = false;
            let cut_index = -1;

            for (var i =0;i<time.length;i++){

                if(currentTime.substring(
                    currentTime.lastIndexOf(":") -2 , 2 ) === time[i].substring(
                    time[i].lastIndexOf(":") -2 , 2 )){
                    cut_index = i;
                    cut = true;
                }

                if(cut === true){
                    time_parts.unshift(time[i]);
                }
            }
           if(cut_index != -1){
               time.splice(cut_index,time.length);
           }
            if(time_parts.length>0){
                let tm = time_parts;
                for (let l = 0; l < tm.length; l++){
                    time.unshift(tm[l]);
                }
            }
            $.each(time, (key, value) => {

                html += [
                    `<td class="day_cell_te  ${currentTime.substring(
                        currentTime.lastIndexOf(":") -2 , 2 ) === value.substring(
                        value.lastIndexOf(":") -2 , 2 ) ? 'current-time' : ''}" data-celldate="${value}"><span style="line-height: 60px; margin-top: 0;">${value}</span><span class="border"></span></td>`
                ].join('');
                i++;
            });

            $('#my_calendar_en').find('.rescalendar_day_cells').html( html );
            $('.rescalendar_day_cells').css('margin-left','0px');
            addTdClickTeEvent( targetObj );
        }

        // Set type
        function setMonthType(refDate = false) {
            $('.rescalendar-controls-flex *').hide();
            let month = {
                '01': 'янв',
                '02': 'февр',
                '03': 'март',
                '04': 'апр',
                '05': 'май',
                '06': 'июнь',
                '07': 'июль',
                '08': 'авг',
                '09': 'сент',
                '10': 'окт',
                '11': 'нояб',
                '12': 'дек'
            };

            let currentMonth;
            if(!refDate) {
                currentMonth = moment().format('MM');
            } else {
                currentMonth = refDate;
            }
            localStorage.setItem('active_mount',currentMonth );

            let cut = false;
            let cut_index = -1;
            let old_parts = {};
            let new_parts = {};
            for (var i in month){
                if(parseInt(currentMonth) === parseInt(i)){
                    cut_index = i;
                    cut = true;
                }
                if(cut === true){
                    new_parts[i] = month[i];
                } else {
                    old_parts[i] = month[i];
                }
            }


            let targetObj = $('.rescalendar');
            let html = '';
            $.each(new_parts, (key, value) => {
                html += [
                    `<td class="day_cell_mo ${parseInt(currentMonth) === parseInt(key) ? 'current-month' : ''}" data-celldate="${key}"><span style="line-height: 60px; margin-top: 0;">${value}</span><span class="border"></span></td>`
                ].join('');
            });
            $.each(old_parts, (key, value) => {
                html += [
                    `<td class="day_cell_mo ${parseInt(currentMonth) === parseInt(key) ? 'current-month' : ''}" data-celldate="${key}"><span style="line-height: 60px; margin-top: 0;">${value}</span><span class="border"></span></td>`
                ].join('');
            });

            targetObj.find('.rescalendar_day_cells').html( html );

            addTdClickMoEvent( targetObj );
        }

        $('body').on('change', '.set-date-type', function () {
            let value = $(this).val();

            if (value === 'month') {
               setMonthType();
            } else if (value === 'time') {
                setTimeType();
            } else if (value === 'not-set') {
                let targetObj = $('.rescalendar');
                setDayCells( targetObj, settings.refDate );
            }
        });

            let targetObj = $(this);
            set_template( targetObj, settings);
            setDayCells( targetObj, settings.refDate );
            // Events
            let move_to_last_month = $('.main-content-tab-wrap').find('.move_to_last_month');
            let move_to_next_month = $('.main-content-tab-wrap').find('.move_to_next_month');
            let  move_to_yesterday  = targetObj.find('.move_to_yesterday'),
                move_to_tomorrow   = targetObj.find('.move_to_tomorrow'),
                move_to_today      = targetObj.find('.move_to_today'),
                refDate            = targetObj.find('.refDate');

            move_to_last_month.on('click', function(e){
              let currentMonth = moment().endOf('month').format('DD');
              change_day( targetObj, 'subtract', currentMonth);
            });

            targetObj.on('click', '.move_to_yesterday',  function(e){
                alert('Poxuma naxord or file : calendar.js tox : 442 ; ');
                // change_day( targetObj, 'subtract', 1);
            });
            targetObj.on('click', '.move_to_tomorrow',  function(e){
                alert('Poxuma myus or file : calendar.js tox : 445 ; ');
                // change_day( targetObj, 'add', 1);
            });

            move_to_next_month.on('click', function(e){
              let currentMonth = moment().endOf('month').format('DD');
              change_day( targetObj, 'add', currentMonth);
            });
            refDate.on('blur', function(e){
                let refDate = targetObj.find('input.refDate').val();
                setDayCells( targetObj, refDate );
            });
            move_to_today.on('click', function(e){
                let today = moment().startOf('day').format( settings.format );
                targetObj.find('input.refDate').val( today );
                setDayCells( targetObj, today );
            });
            return this;

    } // end rescalendar plugin

}(jQuery));
