function readURL(input) {

    if (input.files && input.files[0]) {

        for(var i in input.files) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.image-upload-wrap').hide();
                let cl = $('.file-upload-content').clone();
                cl.find('.file-upload-image').attr('src', e.target.result);
                cl.show();
                cl.find('.image-title').html(input.files[i].name);
                $('.file-upload').append(cl);
            };

            reader.readAsDataURL(input.files[i]);
        }

    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
function setProducs(){
    if( $('.product-old').length>0){
        $('.product-old').each(function(){
            let id = $(this).attr('data-id');
            console.log(id);
            $(this).find('option[value='+id+']').attr('selected','selected');
        });
    }
}
$(document).ready(function () {

    // deal modale scriptes //

    $('body').on('change','.deal_type_id', function(){
        let type_id = parseInt($(this).val());
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            method: 'post',
            data: {type_id: type_id},
            dataType: 'html',
            success: function(res){
                $('.right-part').replaceWith(res);
                let option_html = '';
                $('.crm-entity-section-status-step').each(function () {
                    option_html+='<option value="'+$(this).attr('data-id')+'" >'+$(this).attr('data-name')+'</option>';
                });
                $('#deal-status_id').html(option_html);
            }
        });
        // if(parseInt($(this).val()) == 2){
        //     $('.form-fields-comp-deal').show();
        // } else {
        //     $('.form-fields-comp-deal').hide();
        // }
    });
    $('body').on('change', '.eq_type', function(){
        var type = parseInt($(this).val());
        var url = $(this).attr('data-url');
        let self_ = $(this);
        $.ajax({
            url: url,
            method: 'post',
            data: {type_id: type},
            dataType: 'json',
            success: function(res){
                let option_html = '<option>-</option>';
                for (var i in res){
                    option_html+='<option value="'+res[i].id+'" data-count="'+res[i].count+'">'+res[i].name+'</option>';
                }
                self_.closest('.deal_connect').find('.product').html(option_html);
            }
        });
    });
    $('body').on('click','.choose-eq-type',function () {
        if($(this).is(':checked')) {
            let title = $(this).next().text();
            let cloneEl = $('.clone-bl').first().clone().removeClass('hide').removeClass('clone-bl');
            cloneEl.find('.t-title').text(title);

            var type = parseInt($(this).attr('data-type-id'));
            var type_id = type;
            if(type == 4){
                type_id = 1;
            }
            cloneEl.addClass('eq_item_' + type);
            cloneEl.find('.form-row').append('<input type="hidden" name="Deal_connect[eq_type][]" value="' + type + '">');
            $('.cloned-type-block').append(cloneEl);
            var url = $(this).attr('data-url');
            let self_ = $(this);
            $.ajax({
                url: url,
                method: 'post',
                data: {type_id: type_id},
                dataType: 'json',
                success: function (res) {
                    let option_html = '<option>-</option>';
                    for (var i in res) {
                        option_html += '<option data-unit="' + res[i].unit_id + '" data-price="' + res[i].base_amount + '" value="' + res[i].id + '" >' + res[i].name + '</option>';
                    }
                    $('body .eq_item_' + type).find('.product').html(option_html);
                }
            });
        } else {
            var type = parseInt($(this).attr('data-type-id'));
            $('body .eq_item_' + type).hide();

        }
    });
    $('body').on('click','.choose-eq-type-update',function () {
        if($(this).is(':checked')) {
            let title = $(this).next().text();
            let cloneEl = $('.clone-bl').first().clone().removeClass('hide').removeClass('clone-bl');
            cloneEl.find('.t-title').text(title);

            var type = parseInt($(this).attr('data-type-id'));
            var type_id = type;
            if(type == 4){
                type_id = 1;
            }
            cloneEl.addClass('eq_item_' + type);
            cloneEl.find('.form-row').append('<input type="hidden" name="New_deal_connect[eq_type][]" value="' + type + '">');
            $('.cloned-type-block').append(cloneEl);
            var url = $(this).attr('data-url');
            let self_ = $(this);
            $.ajax({
                url: url,
                method: 'post',
                data: {type_id: type_id},
                dataType: 'json',
                success: function (res) {
                    let option_html = '<option>-</option>';
                    for (var i in res) {
                        option_html += '<option data-unit="' + res[i].unit_id + '" data-price="' + res[i].base_amount + '" value="' + res[i].id + '" >' + res[i].name + '</option>';
                    }
                    $('body .eq_item_' + type).find('.product').html(option_html);
                }
            });
        } else {
            var type = parseInt($(this).attr('data-type-id'));
            $('body .eq_item_' + type).hide();
        }
    });
    $('body').on('change', '.product', function(e){
        let productPrice = $(this).find('option:selected').attr('data-price');
        let unit = $(this).find('option:selected').attr('data-unit');

        $(this).closest('.form-row').find('.price').val(productPrice);
        $(this).closest('.form-row').find('.unit').val(unit);


    });
    // end deal modale scriptes //
    $('body').on('change', '#tarif_id_share', function(e){
        let tarifs = $(this).val();
        var url = $(this).attr('data-url');
        var service_id = $('#service_id_share').val();
        var tarif_data;
        if(tarifs.length>0){
            $.ajax({
                url: url,
                method: 'post',
                data: {ids: tarifs, service_id: service_id},
                dataType: 'html',
                success: function(res){
                    $('.tariffs_all').html('');
                    $('.tariffs_all').append(res);
                }
            });
        } else {
            $('.tariffs_all').html('');
        }

    });
    $('body').on('change', '#service_id_share', function(e){
        let service_id  = $(this).val();
        var url = $(this).attr('data-url');
        console.log(service_id);
        if(service_id){
            $.ajax({
                url: url,
                method: 'post',
                data: {id: service_id},
                dataType: 'json',
                success: function(res){
                    let option_html = '';
                    for (var i in res){
                        option_html+='<option value="'+i+'">'+res[i]+'</option>';
                    }
                    $('#tarif_id_share').html(option_html);
                }
            });
        }
    });
    $('body').on('change', '.radiolist input', function () {
        if(parseInt($(this).val()) == 1){
            $('.random').show();
        } else {
            $('.random').hide();
        }
    });
    $('body').on('click','.remove-email', function(){
        let res = confirm('Удалить ?');
        let self_ = $(this);
        if(res){
            let id = parseInt($(this).attr('data-id'));
            if(!Number.isNaN(id)){
                $.ajax({
                    url: '/crm/contact/remove-email',
                    method: 'post',
                    data: {id: id},
                    dataType: 'html',
                    success: function(){
                        self_.closest('.email-clone').remove();
                    }
                });
            } else {
                $(this).closest('.email-clone').remove();
            }
        }
    });
    $('body').on('click','.remove-phone', function(){
        let res = confirm('Удалить ?');
        let self_ = $(this);
        if(res){
            let id = parseInt($(this).attr('data-id'));
            if(!Number.isNaN(id)){
                $.ajax({
                    url: '/crm/contact/remove-contact',
                    method: 'post',
                    data: {id: id},
                    dataType: 'html',
                    success: function(){
                        self_.closest('.phone-clone').remove();
                    }
                });
            } else {
                $(this).closest('.phone-clone').remove();
            }
        }
    });
    $('body').on('click','.remove-form', function(){
        let res = confirm('Удалить ?');
        let self_ = $(this);
        if(res){
            let id = parseInt($(this).attr('data-id'));
            if(!Number.isNaN(id)){
                $.ajax({
                    url: '/crm/deal/remove-connect',
                    method: 'post',
                    data: {id: id},
                    dataType: 'html',
                    success: function(){
                        self_.closest('.form-row').remove();
                    }
                });
            } else {
                $(this).closest('.form-row').remove();
            }
        }
    });
    $('body').on('click','.remove-ip', function(){
        let res = confirm('Удалить ?');
        let self_ = $(this);
        if(res){
            let id = parseInt($(this).attr('data-id'));
            if(!Number.isNaN(id)){
                $.ajax({
                    url: '/billing/configs/remove-ip',
                    method: 'post',
                    data: {id: id},
                    dataType: 'html',
                    success: function(){
                        self_.closest('.ipAddresses-list-item').remove();
                    }
                });
            } else {
                $(this).closest('.ipAddresses-list-item').remove();
            }
        }
    });
    // $('body').on('click','.remove-file', function(){
    //     let res = confirm('Удалить ?');
    //     let self_ = $(this);
    //     if(res){
    //         let id = parseInt($(this).attr('data-id'));
    //         if(!Number.isNaN(id)){
    //             $.ajax({
    //                 url: '/crm/deal/remove-file',
    //                 method: 'post',
    //                 data: {id: id},
    //                 dataType: 'html',
    //                 success: function(){
    //                     self_.closest('.file-block').remove();
    //                 }
    //             });
    //         } else {
    //             $(this).closest('.file-block').remove();
    //         }
    //     }
    // });
    $('body').on('click','.card-action-btn-add', function(){
        $(this).closest('.row').find('.phone-blok').find('select').select2('destroy');
        let $el = $('#contact-phonetype-new-0'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        let cloneEl = $('.phone-clone').first().clone();
        cloneEl.find('input').val('');

        cloneEl.find('.col-md-4').attr('class', 'col-md-3');

        cloneEl.find('.remove-phone').closest('.col-md-1').removeClass('hide');
        // cloneEl.find('.remove-phone').show();
        var c = $('.phone-clone').length;
        let time_ = new Date().getTime();
        cloneEl.find('.is_mailing input').removeAttr('checked').attr('id','phone-'+c+'-new-m').attr('name','Contact[is_mailing_phone][new-'+time_+']');
        cloneEl.find('input[type=text]').attr('name','Contact[phone][new-'+time_+']');
        cloneEl.find('select').attr('name','Contact[phoneType][new-'+time_+']').attr('id', 'contact-phonetype-new-0'+ID_Name()).attr('data-select2-id', 'contact-phonetype-new-0'+ID_Name());
        cloneEl.find('.is_mailing label').attr('for','phone-'+c+'-new-m');
        cloneEl.find('.is_notification input').removeAttr('checked').attr('id','phone-'+c+'-new-n').attr('name','Contact[is_notification_phone][new-'+time_+']');
        cloneEl.find('.is_notification label').attr('for','phone-'+c+'-new-n');
        $('.phone-blok').append(cloneEl);

        $('.phone-type-select').select2(settings).trigger('change');
    });
    $('body').on('click','.card-action-btn-add-conect', function(){
        let cloneEl = $(this).closest('.deal_connect').find('.form-row').first().clone();
        cloneEl.find('input[type=text],input[type=number],select,textarea').val('');
        $(this).closest('.deal_connect').find('.cloned-elements-block').append(cloneEl);
    });

    $('body').on('click','.card-action-btn-update-conect', function(){
        var cloneEl = $('.clone-bl').find('.form-row').clone();
        var type = $(this).attr('data-type');
        var type_id = type;
        if(type == 4){
            type_id = 1;
        }
        cloneEl.append('<input type="hidden" name="New_deal_connect[eq_type][]" value="' + type + '">');
        var url = $(this).attr('data-url');
        let self_ = $(this);
        var option_html = '<option>-</option>';
        $.ajax({
            url: url,
            method: 'post',
            data: {type_id: type_id},
            dataType: 'json',
            success: function (res) {
                for (var i in res) {
                    option_html += '<option data-unit="' + res[i].unit_id + '" data-price="' + res[i].base_amount + '" value="' + res[i].id + '" >' + res[i].name + '</option>';
                }
                cloneEl.find('.product').html(option_html);
            }
        });

        cloneEl.find('input[type=text],input[type=number],select,textarea').val('');
        $(this).closest('.deal_connect').find('.cloned-elements-block').append(cloneEl);
    });

    $('body').on('click','.card-action-btn-add-company', function(){
        let cloneEl = $('.address-clone').first().clone();
        $('.address-clone-paste').append(cloneEl);

        let time_ = new Date().getTime();
        cloneEl.find('select').attr('id', function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + time_;
        }).attr('name','Company[country_id][new-'+time_+']');

        let $el = $('select.form-control'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $el.select2(settings).trigger('change');
        $('.kv-plugin-loading').hide();
    });
    $('body').on('click','.card-action-btn-add-email', function(){
        $(this).closest('.row').find('.email-blok').find('select').select2('destroy');
        let $el = $('#contact-emailtype-new-0'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        let cloneEl = $('.email-clone').first().clone();
        cloneEl.find('input').val('');

        cloneEl.find('.col-md-4').attr('class', 'col-md-3');

        cloneEl.find('.remove-email').closest('.col-md-1').removeClass('hide');

        var c = $('.email-clone').length;
        let time_ = new Date().getTime();
        cloneEl.find('.is_mailing input').removeAttr('checked').attr('id','email-'+c+'-new-m').attr('name','Contact[is_mailing][new-'+time_+']');
        cloneEl.find('input[type=text]').attr('name','Contact[email][new-'+time_+']');
        cloneEl.find('select').attr('name','Contact[emailType][new-'+time_+']').attr('id', 'contact-emailtype-new-0'+ID_Name()).attr('data-select2-id', 'contact-emailtype-new-0'+ID_Name());
        cloneEl.find('.is_mailing label').attr('for','email-'+c+'-new-m');
        cloneEl.find('.is_notification input').removeAttr('checked').attr('id','email-'+c+'-new-n').attr('name','Contact[is_notification][new-'+time_+']');
        cloneEl.find('.is_notification label').attr('for','email-'+c+'-new-n');
        cloneEl.find('.remove-email').removeClass('hide');
        // cloneEl.find('.remove-email').show();
        $('.email-blok').append(cloneEl);
        $('.email-type-select').select2(settings).trigger('change');
    });
    $('body').on('change', '.input-share-price,.share-radio', function(e){
        let tarifPrice = parseFloat($(this).closest('.tariff-blok-share').find('.t_price').val());
        let type_ =  parseFloat($(this).closest('.tariff-blok-share').find('.share-radio:checked').val());
        let inputPrice = parseFloat($(this).closest('.tariff-blok-share').find('.input-share-price').val());
        if(!Number.isNaN(inputPrice)){
            if(type_ == 2) {
                tarifPrice -= inputPrice;
            } else {
                if (parseInt($('.input-share-price').val()) > 100 || parseInt($('.input-share-price').val()) < 0) {
                    $('.input-share-price').val('');
                }
                tarifPrice -= ((tarifPrice*inputPrice)/100);
            }
        }
        $(this).closest('.tariff-blok-share').find('.tot_price').text(tarifPrice+' Драм');
        $('#deal-amount').val(tarifPrice);
    });

    // check if in service  tariff % number < 0 or >  100  set '' in input
    $('body').on('change','.tariff-actual_price', function () {
        if ($('.type_1').is(':checked')) {
            if ($('.tariff-actual_price').val() > 100 || $('.tariff-actual_price').val() < 0) {
                $('.tariff-actual_price').val('');
                return true;
            }
        }
    })
    $('body').on('click','.type_1', function () {
        if ($('.tariff-actual_price').val() > 100 || $('.tariff-actual_price').val() < 0) {
            $('.tariff-actual_price').val('');
            return true;
        }
        $('.selected-services-price-unit').html('%');
    })
    $('body').on('click','.type_2', function () {
        $('.selected-services-price-unit').html('Драм');
    })
    $('body').on('change', '.choose-price-unit-type,.tariff-actual_price,.service_product', function(e){
        let productPrice = parseFloat($(this).closest('.tariff-blok').find('.service_product option:selected').attr('data-price'));
        let tarifPrice = parseFloat($(this).closest('.tariff-blok').find('.main_price').val());
        let tarifPrice_sum = parseFloat($(this).closest('.tariff-blok').find('.t_cost').text());
        let type_ =  parseFloat($(this).closest('.tariff-blok').find('.choose-price-unit-type:checked').val());
        let inputPrice = parseFloat($(this).closest('.tariff-blok').find('.tariff-actual_price').val());
        let l = 0;
        if(!Number.isNaN(productPrice)){
            tarifPrice += productPrice;
            l++;
        }
        if(!Number.isNaN(inputPrice)){
            if(type_ == 2) {
                tarifPrice += inputPrice;
            } else {
                tarifPrice += ((tarifPrice*inputPrice)/100);
            }
            l++;
        }
        if(l!=0) {
            $(this).closest('.tariff-blok').find('.actual-price-total').text(tarifPrice);
            $(this).closest('.tariff-blok').find('.total_price').val(tarifPrice);
        } else {
            $(this).closest('.tariff-blok').find('.actual-price-total').text(tarifPrice_sum);
            $(this).closest('.tariff-blok').find('.total_price').val(tarifPrice_sum);
        }

    });

    $('body').on('change', '#tarif_id', function(e){
        let tarifs = [];
        $(this).find("option").each(
            function () {
                if($(this).is(':selected')){
                    tarifs.push($(this).val());
                }
            }
        );
        var tarif_data;
        if(tarifs.length>0){
            $.ajax({
                url: '/billing/tariff/get-tariffs-by-ids',
                method: 'post',
                data: {ids: tarifs},
                dataType: 'html',
                success: function(res){

                    $('.tariffs').html(res);
                    var increment = 0;

                    $('.tariffs').find('select').attr('id', function () {
                        $(this).val(null).trigger('change');
                        return $(this).attr('id') + '_' + (increment++);
                    });
                    $('.service_product').select2();


                    // let $el = $('.service_product'),
                    //     settings = $el.attr('data-krajee-select2'),
                    //     id = $el.attr('id');
                    // settings = window[settings];
                    // $el.select2(settings).trigger('change');
                    $('.kv-plugin-loading').hide();
                }
            });
        }

    });

    $('body').on('change', '.tariff-blok-share input[type=radio]', function(e){
        console.log(parseInt($(this).attr('data-type')));
        console.log($(this));
        if(parseInt($(this).attr('data-type')) != 2) {
            if(parseInt($(this).attr('data-type')) != 3) {
                if (parseInt($(this).val()) !== 0) {
                    $(this).closest('.border-green,.tariff-blok-share').find('.tv_ip_blok').hide(200);
                } else {
                    $(this).closest('.border-green,.tariff-blok-share').find('.tv_ip_blok').show(200);
                }
                $(this).closest('.border-green,.tariff-blok-share').find('.free-month-blok').hide(200);
                $(this).closest('.border-green,.tariff-blok-share').find('.radio-price-blok').hide(200);
            } else {
                $(this).closest('.border-green,.tariff-blok-share').find('.free-month-blok').show(200);
                $(this).closest('.border-green,.tariff-blok-share').find('.tv_ip_blok').hide(200);
                $(this).closest('.border-green,.tariff-blok-share').find('.radio-price-blok').hide(200);
            }
        } else {
            $(this).closest('.border-green,.tariff-blok-share').find('.free-month-blok').hide(200);
            $(this).closest('.border-green,.tariff-blok-share').find('.tv_ip_blok').hide(200);
            $(this).closest('.border-green,.tariff-blok-share').find('.radio-price-blok').show(200);
        }
    });
    $('body').on('change', '.checkbox-list input[type=checkbox]', function(e){

        let type_ = parseInt($(this).attr('data-type'));
        if($(this).is(':checked') && type_ === 1){
            $(this).closest('.tv_ip_blok').find('.forInternet').show();
        } else if(type_ === 1) {
            $(this).closest('.tv_ip_blok').find('.forInternet').hide();
        }
        if($(this).is(':checked') && type_ === 2){
            $(this).closest('.tv_ip_blok').find('.forTv').show();
        } else if(type_ === 2){
            $(this).closest('.tv_ip_blok').find('.forTv').hide();
        }
        if($(this).is(':checked') && type_ === 3){
            $(this).closest('.tv_ip_blok').find('.forIp').show();
        } else if(type_ === 3){
            $(this).closest('.tv_ip_blok').find('.forIp').hide();
        }

    });

});


function confirmDeletion (text){
    let confirm_deletion_popup_cont =$(".erp-confirm-deletion")
    let confirm_deletion_popup = $(` 
        <div class = "confirm-del-popup">
            <div class = "confirm-del-warning-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class = "confirm-del-text-1">Подтвердите действие!<br>Действие необратимо.</div>
            <div class = "confirm-del-text-2">
                <span><strong>Вы действительно хотите удалить <span>${text}</span></strong></span>
            </div>
            <div>
                <button id = "cancel-deletion-btn" class = "c-btn c-btn-secondary c-btn-ol">отменить</button>
                <button id = "confirm-deletion-btn" class = "c-btn c-btn-danger">УДАЛИТЬ</button>
            </div>
        </div>`);
    confirm_deletion_popup_cont.html(confirm_deletion_popup).show();
    $("#cancel-deletion-btn", confirm_deletion_popup).on("click", function (e) {
        confirm_deletion_popup_cont.hide();
    });
    let delete_btn = $("#confirm-deletion-btn", confirm_deletion_popup);
    return {delete_btn: delete_btn, confirm_deletion_popup_cont: confirm_deletion_popup_cont};
}
function zoneNineHideShow(popup, status){
    if(status === "show"){
        popup.animate({ width: "100%", right: "+=75px"}, 300 );
    } else {
        popup.animate({ width: "0", right: "-=75px"}, 300);
    }
}
$(document).ready(() => {
    let speed = 300;
    let easing ="linear";
    $('.iconNav').on('click', function () {
        let container =$(".main-content");
        let sidebar = $('.zone2-div');
        let zone_six = $('.zone6');
        let zone_width = "150";
        if ($(this).hasClass('opened')) {
            sidebar.animate({
                width: '40px'
            }, speed, easing);
            $(this).removeClass('opened');
            container.animate({
                marginLeft: `-=${zone_width}px`,
            }, speed, easing);
            zone_six.animate({
                width: `+=${zone_width}px`,
            }, speed, easing);
        } else {
            sidebar.animate({
                width: `190px`
            }, speed, easing);
            $(this).addClass('opened');
            container.animate({
                marginLeft: `+=${zone_width}px`,
            }, speed, easing);
            zone_six.animate({
                width: `-=${zone_width}px`,
            }, speed, easing);
        }
    });
    $('.starCheck').on('click', function () {
        if (!$(this).hasClass('checked')) {
            $(this).css('color', '#007bff');
            $(this).addClass('checked');
        } else {
            $(this).css('color', '#bababa');
            $(this).removeClass('checked');
        }
    });
    $('.arrowUp').on('click', function () {
        let zone_seven = $('.zone7');
        let zone_height = "200";
        if (!zone_seven.hasClass('opened')) {
            $({rotation: 0}).animate({rotation: 180}, {
                duration: 500,
                easing: 'linear',
                step: function () {
                    $('.arrowZ7').css({transform: 'rotate(' + this.rotation + 'deg)'});
                }
            });
            zone_seven.animate({
                height: `+${zone_height}px`,
            }, speed, easing);
            zone_seven.addClass("opened");
        } else {
            $({rotation: 180}).animate({rotation: 0}, {
                duration: 500,
                easing: 'linear',
                step: function () {
                    $('.arrowZ7').css({transform: 'rotate(' + this.rotation + 'deg)'});
                }
            });
            zone_seven.animate({
                height: `-${zone_height}px`,
            }, speed, easing);
            zone_seven.removeClass("opened");
        }
    });

    $('.arrowLeft').on('click', function (e) {
        let zone_eight = $('.zone8');
        let container =$(".main-content");
        let zone_six = $('.zone6');
        let zone_width = "304";
        if (!zone_eight.hasClass('opened')) {
            $({rotation: 0}).animate({rotation: 180}, {
                duration: 500,
                easing: 'linear',
                step: function () {
                    $('.arrowZ8').css({transform: 'rotate(' + this.rotation + 'deg)'});
                }
            });
            zone_six.animate({
                width: `-=${zone_width}px`,
            }, speed, easing);
            container.animate({
                marginRight: `+=${zone_width}px`
            }, speed, easing);
            zone_eight.animate({
                width: `+${zone_width}px`,
            }, speed, easing);
            zone_eight.addClass('opened');
            zone_eight.addClass('opened');
        } else {
            $({rotation: 180}).animate({rotation: 0}, {
                duration: 500,
                easing: 'linear',
                step: function () {
                    $('.arrowZ8').css({transform: 'rotate(' + this.rotation + 'deg)'});
                }
            });
            zone_six.animate({
                width: `+=${zone_width}px`,
            }, speed, easing);
            container.animate({
                marginRight: `-=${zone_width}px`
            }, speed, easing);
            zone_eight.animate({
                width: `-${zone_width}px`,
            }, speed, easing);
            zone_eight.css('width', '0');
            zone_eight.removeClass('opened');
        }
    });
    $('.zone-nine-new-task').on('click', function (e) {
        setTimeout(function () {
            $(".knbn-new-task-popup-z8").html(addNewTaskPopup(null));
        }, 500);

        // let popup = $('.popup2');
        // drawZoneNine(addNewTaskPopup, popup)
        // zoneNineHideShow(popup, "show");
    });

    $('body').on('click' , '.deleteButtonCard' ,function () {
        $(this).closest('#section-blok').remove();
    })


    $('body').on('mousemove','input', function () {
        $(this).attr("autocomplete","off");
    })


});
