
var form_page = $('#form_page').val();
$('.addVacation').on('click',function(){
    let start_date = $('#crmdealvacation-data_start').val();
    let end_date = $('#crmdealvacation-data_end').val();
    let deal_id = $('#deal_id').val();
    let vacation_id = null;

    if ($('#vacation_id').length) {
        vacation_id = $('#vacation_id').val();
    }

    let url = $(this).attr('data-url');
    if(deal_id && end_date && start_date){
        $.ajax({
            url: url,
            method: 'post',
            data: {id: deal_id, start_date:start_date, end_date:end_date, vacation_id:vacation_id},
            dataType: 'json',
            success: function(res){
                $('.addVacation').hide();
            }
        });
    } else {
        alert('aranc orer@ nshelu otpusk chen talis ay balam');
    }

});
$('#terminate').on('click',function(){
    let id = $(this).attr('data-id');
    let url = $(this).attr('data-url');

    $.ajax({
        url: url,
        method: 'post',
        data: {id: id},
        dataType: 'html',
        success: function(){
            $('.close').click();
        }
    });


});

$('#add-section').on('click',function(){
    var clone = $('#card-edit').clone();
    clone.removeAttr('id');
    $('#section-blok').append(clone);
    clone.show();
    clone.find('span.card-title-text').hide();
    clone.find('input.card-title-text').show().focus().val(clone.find('input.card-title-text').val());
    $( "input.card-title-text" ).focusout(function() {
        let val = $(this).val();
        $(this).closest('.card-edit').find('span.card-title-text').text(val);
        $(this).closest('.card-edit').find('.card-title-edit-icon').css('display','inline-block');
        $(this).closest('.card-edit').find('span.card-title-text').show();
        $(this).closest('.card-edit').find('input.card-title-text').hide();
    });
    $('.card-title-edit-icon').on('click',function(){
        $(this).closest('.card-edit').find('span.card-title-text').hide();
        $(this).closest('.card-edit').find('input.card-title-text').show().focus().val($(this).closest('.card-edit').find('input.card-title-text').val());
        $(this).closest('.card-edit').find('.card-title-edit-icon').hide();
    });
    addSection('/crm/'+form_page+'/create-section', clone.find('input.card-title-text').val(), clone);
    $('input.card-title-text').on('keyup', function () {
        let id = $(this).closest('.card-edit').attr('data-id');
        let text = $(this).val();
        changeSectionTitle('/crm/'+form_page+'/update-section', id, text);
    });
    $('.delete').bind('click',function(){
        let id = $(this).closest('.card-edit').attr('data-id');
        var res = confirm('Вы уверены что хотите удалить ?');
        if(res){
            deleteSection('/crm/'+form_page+'/delete-section', id, $(this));
        }
    });

    $('.card-action-btn').on('click',function(e){
        let id = $(this).closest('.card-edit').attr('data-id');
        $('#popup-window').attr('data-id',id);
        $('#popup-window').show();
        // console.log(e);
        var mouseX=e.clientX;
        var mouseY=e.clientY;
        $('.popup-window').css({position:'absolute','z-index': '1000',padding: '0px',top:mouseY,left:mouseX});
    });
});

$('body').on('click', '.setting-icon', function(){
    let settingsDropdown = $(this).closest('.form-group-old').find('.setting-blok');
    settingsDropdown.toggleClass('d-block');
});

$('.card-action-btn').on('click',function(e){
    console.log(e);
    let id = $(this).closest('.card-edit').attr('data-id');
    let left = $(this).offset().left;
    let popup = $('#popup-window');
    let insertAfterElement = $(this).closest('.card-edit').find('.card-content');

    popup.attr('data-id',id);
    $('.popup-window').insertAfter(insertAfterElement);

    popup.toggleClass('d-none');
    $('.popup-window').toggleClass('popup-window-show');
    $('.popup-window-show').css({left: '125px', top: '80%'});
});

$('body').on('change','.service_id', function(){
    let service_id  = $(this).val();
    var url = $(this).attr('data-url');
    if(service_id){
        $.ajax({
            url: url,
            method: 'post',
            data: {id: service_id},
            dataType: 'json',
            success: function(res){
                let option_html_tr = '<option>Выбрать</option>';
                let option_html_shr = '<option>Выбрать</option>';
                for (var i in res.prices){
                    option_html_tr+='<option value="'+res.prices[i].id+'" data-price="'+res.prices[i].price+'">'+res.prices[i].name+'</option>';
                }

                for (var j in res.shares){
                    option_html_shr+='<option value="'+res.shares[j].id+'" >'+res.shares[j].name+'</option>';
                }
                $('#tariffs').html(option_html_tr);
                $('#tariffs_deal').html(option_html_tr);
                $('.share_id').html(option_html_shr);
            }
        });
    }

});

$('body').on('change','.share_id', function(){
    let share_id  = $(this).val();
    var url = $(this).attr('data-url');
    if(share_id){
        $.ajax({
            url: url,
            method: 'post',
            data: {id: share_id},
            dataType: 'json',
            success: function(res){
                console.log(res);
                let option_html_tr = '<option>Выбрать</option>';
                for (var i in res){
                    option_html_tr+='<option data-share-price="'+res[i].tariff_share_data.share_price_value+'" data-price-type="'+res[i].tariff_share_data.share_price_type+'" value="'+res[i].tariff_data.id+'" data-price="'+res[i].tariff_data.price+'">'+res[i].tariff_data.name+'</option>';
                }
                $('#tariffs_deal').html(option_html_tr);
            }
        });
    }
});
$('body').on('change','#share', function(){
    if($(this).is(':checked')){
        let price = parseInt($('body').find('.t_price').val());
        let share_price = $('#tariffs_deal').find('option:selected').attr('data-share-price');
        let share_type = $('#tariffs_deal').find('option:selected').attr('data-price-type');
        let new_price = 0;
        if(share_price){
            if(share_type == 1){
                new_price = (price - (price*share_price)/100);
            } else {
                new_price = price - share_price;
            }
            $('#deal-amount').val(new_price);
        } else {
            $('#deal-amount').val(price);
        }
        $('body').find('.action-blok').hide();
    } else {
        $('.service_id').change();
        $('#deal-amount').val(0);
        $('.tariff_info').html('');

    }
});
$('body').on('change','.client-type',function(){
    $('.contact-type,.company-type').addClass('hide');
    let checked_ = $('.client-type:checked').attr('data-type');
    $('.'+checked_+'-type').removeClass('hide');
});
$('body').on('change','#tariffs', function(){

    let tarif = $(this).val();
    var url = $(this).attr('data-url');
    var share_id = $('#deal-share_id').val();
    var service_id = $('.service_id').val();
    var tarif_data;
    if(tarif){
        $.ajax({
            url: url,
            method: 'post',
            data: {id: tarif, service_id: service_id, share_id: share_id},
            dataType: 'html',
            success: function(res){
                $('.tariff_info').html(res);
                if($('#share').is(':checked')){
                    $('body').find('.action-blok').hide();
                }
                let price = parseInt($('body').find('.t_price').val());
                $('#deal-amount').val(price);
            }
        });
    }
    // var price = $(this).find(':selected').attr('data-price');
    // $('#deal-amount').val(parseFloat(price));
});
$('body').on('change','#tariffs_deal', function(){

    let tarif = $(this).val();
    var url = $(this).attr('data-url');
    var share_id = $('#deal-share_id').val();
    var service_id = $('.service_id').val();
    var tarif_data;
    let self_ = $(this);
    if(tarif){
        $.ajax({
            url: url,
            method: 'post',
            data: {id: tarif, service_id: service_id, share_id: share_id},
            dataType: 'html',
            success: function(res){
                $('.tariff_info').html(res);
                if($('#share').is(':checked')){
                    $('body').find('.action-blok').hide();
                }
                let price = parseInt($('body').find('.t_price').val());
                let share_price = parseInt(self_.find('option:selected').attr('data-share-price'));
                let share_type = parseInt(self_.find('option:selected').attr('data-price-type'));
                let new_price = 0;
                if(share_price && $('#share').is(':checked')){
                    if(share_type == 1){
                        new_price = (price - (price*share_price)/100);
                    } else {
                        new_price = price - share_price;
                    }
                    $('#deal-amount').val(new_price);
                } else {
                    $('#deal-amount').val(price);
                }
            }
        });
    }
    // var price = $(this).find(':selected').attr('data-price');
    // $('#deal-amount').val(parseFloat(price));
});
$('body').on('change','.contact-fields', function(){

    var type_ = $(this).attr('data-type');
    var val = $(this).val();
    var url = $(this).attr('data-url');
    $.ajax({
        url: url,
        method: 'post',
        data: {value: val, type_: type_},
        dataType: 'json',
        success: function(res){
            if(typeof res == 'object'){
                $('#user_address').html('');
                let options_html = '<option>Выбрать</option>';
                for(var i in res){
                    options_html += '<option value="'+i+'">'+res[i]+'</option>';
                }
                $('#user_address').html(options_html);
            } else {
                $('#user_address').html('');
            }
        },
    });

});
$('body').on('change','#user_address', function(){

    var val = $(this).val();
    var url = $(this).attr('data-url');

    if (val.length) {
        $('body').find('.form-fields-comp-deal').show();
    } else {
        $('body').find('.form-fields-comp-deal').hide();
    }

    $.ajax({
        url: url,
        method: 'post',
        data: {value: val},
        dataType: 'json',
        success: function(res){

            if(typeof res == 'object'){
                $('.service_id').html('');
                let options_html = '<option>Выбрать</option>';
                for(var i in res){
                    options_html += '<option value="'+i+'">'+res[i]+'</option>';
                }
                $('.service_id').html(options_html);

            } else {
                $('.service_id').html('');
            }
        }
    });

});


$('body').on('click','.create-field-item', function(e){
    let id = $(this).closest('#popup-window').attr('data-id');
    let type = $(this).attr('data-type');
    let type_id = $(this).attr('data-type-id');
    let label = $(this).find('.create-field-item-title').text();
    $('.new-fields-btn-container').show();
    if(type == 'list') {
        $('.card-edit[data-id=' + id + '] .form-group').html($('.input-group-for-clone').clone().show());
        $('.card-edit[data-id=' + id + '] .form-group').parent().show();
        $('.content-block-add-field').click(function () {
            let clone_el = $('.js--add-new-row').first().clone();
            clone_el.removeAttr('id').css('margin-top', '1.5rem');
            $('.card-edit[data-id=' + id + '] .form-group .option-group').append(clone_el);
        });
    } else {
        $('.card-edit[data-id='+id+'] .form-group').html(`<div class="sk-floating-label" data-type="`+type+`" data-type-id="`+type_id+`">
                                                              <input type="text" name="" class="form-input form-control bg-white">
                                                              <label class="control-label">Название поля</label>
                                                          </div>
                                                          <div class="required-blok">
                                                              <div class="c-checkbox">
                                                                  <input type="checkbox" id="element-required-${id}" class="element-required" value="1">
                                                                  <label for="element-required-${id}">Обязательный</label>
                                                              </div>
                                                          </div>`);

        $('.card-edit[data-id='+id+'] .form-group').parent().show();
    }
    $('#popup-window').removeAttr('data-id');
    $('#popup-window').hide();
});
$('.delete').bind('click',function(){
    let id = $(this).closest('.card-edit').attr('data-id');
    var res = confirm('Вы уверены что хотите удалить ?');
    if(res){
        deleteSection('/crm/'+form_page+'/delete-section', id, $(this));
    }
});
$('.remove-mode').bind('click',function(){
    let id = $(this).closest('.form-group-old').attr('data-id');
    let res = confirm('Вы уверены что хотите удалить ?');
    let type = $(this).closest('.form-group-old').attr('data-id');
    if(res){
        deleteField('/crm/'+form_page+'/delete-field', id, $(this));
    }
});
$('input.card-title-text').on('keyup', function () {
    let id = $(this).closest('.card-edit').attr('data-id');
    let text = $(this).val();
    changeSectionTitle('/crm/'+form_page+'/update-section', id, text);
});
$('.card-title-edit-icon').on('click',function(){
    $(this).closest('.card-edit').find('span.card-title-text').hide();
    $(this).closest('.card-edit').find('input.card-title-text').show().focus().val($(this).closest('.card-edit').find('input.card-title-text').val());
    $(this).closest('.card-edit').find('.card-title-edit-icon').hide();

});
$('body').on('click',function (e) {
    if($(e.target).attr('class') != 'setting-blok' && $(e.target).attr('class') != 'setting-icon'){
        $('.setting-blok').hide();
    }
})
$('body').on('click','.edite-mode-show', function(){
    $(this).closest('.card-edit').find('.hide-blok').show();
    $(this).closest('.card-edit').find('input,select').removeAttr('disabled').removeClass('disabled');
    $(this).closest('.card-edit').find('.setting-icon').removeClass('hide');
    $(this).closest('.card-edit').find('.card-content').show();
    $(this).text('Отменить');
    $(this).removeClass('edite-mode-show');
    $(this).addClass('cancel-edite-mode');

});
$('body').on('click','.cancel-edite-mode', function(){
    $(this).closest('.card-edit').find('.hide-blok').hide();
    $(this).closest('.card-edit').find('input,select').attr('disabled','disabled').addClass('disabled');
    $(this).text('Изменить');
    $(this).closest('.card-edit').find('.card-content').hide();
    $(this).closest('.card-edit').find('.setting-icon').addClass('hide');
    $(this).addClass('edite-mode-show');
    $(this).removeClass('cancel-edite-mode');
});


setTimeout(function () {
    $('.iti').find('input').addClass('form-input').addClass('disabled').attr('disabled','disabled');
},200);

$('.setting-blok li').on('click', function () {
    $(this).closest('.setting-blok').removeClass('d-block');
});

// Hide custom field setting dropdown outside click
$(document).mouseup(function (e) {
    if ($(e.target).next().length !== 0) {
        $('.setting-blok').removeClass('d-block');
    }
});

function reset_all(this_){
    console.log($(this_).attr('class'));
    $('.form-group-old .input-group-for-clone').remove();
    $('.form-group-old .edite-fields-btn-container').remove();
    $('.form-group-old>.form-input').show();
}

function removeField(this_) {
    $(this_).closest('.js--add-new-row').remove();
}

function saveField(this_){

    var type = $(this_).closest('.card-content').find('.sk-floating-label').attr('data-type');
    var field_type = $(this_).closest('.card-content').find('.sk-floating-label').attr('data-type-id');
    var section_id = $(this_).closest('.card-edit').attr('data-id');
    var required = $(this_).closest('.card-edit').find('.required-blok input').is(':checked');
    var form_page = $('#form_page').val();

    if(required){
        required = 1;
    } else {
        required = 0;
    }

    var field_type;
    var options = '';

    if(type !== 'list'){
        var name = $(this_).closest('.card-content').find('.form-input').val();
    } else {
        field_type = 2;
        var name = $(this_).closest('.card-content').find('.form-input').val();

        $(this_).closest('.card-content').find('.field-blok').each(function(){
            let option_val = $(this).find('.list-item').val();
            if(option_val){
                options+= option_val+',';
            }
        });

    }

    addField('/crm/' + form_page + '/add-field', field_type, type, section_id, name, required, options, $(this_));
    $(this_).closest('.card-content').find('.input-group-for-clone,.input-group').hide();
    $(this_).closest('.card-content').find('.new-fields-btn-container').hide();
}

function editeMode(this_,type){

    $('.form-group-old .input-group-for-clone').remove();
    $('.form-group-old .edite-fields-btn-container').remove();
    $('.form-input').show();
    var req = 'checked';
    var buttons = $('.edite-fields-btn-container').first().clone().show();
    let label;
    let uniqueIDs = makeid(5);

    $(this_).closest('.form-group-old').find('.form-group').hide();
    $(this_).closest('.form-group-old').find('.setting-icon').hide();
    $(this_).closest('.form-group-old').removeClass('d-flex');

    if(type != 2) {
        label = this_.closest('.form-group-old').find('label').text();
        this_.closest('.form-group-old').find('.form-input').hide();
        if (!this_.closest('.form-group-old').find('.form-input').prop('required')) {
            req = '';
        }
        this_.closest('.form-group-old').append('<div class="input-group input-group-for-clone" data-type="text" data-type="1">' +
            '<div class="sk-floating-label">' +
            '<input type="text" name="" class="form-input form-control">' +
            '<label class="control-label">Название поля</label>' +
            '</div>' +
            '<div class="required-blok mb-2">' +
            '<div class="c-checkbox">' +
            '<input ' + req + ' type="checkbox" class="element-required" id="element-required-' + uniqueIDs + '" value="1">' +
            '<label for="element-required-' + uniqueIDs + '">Обязательный</label>' +
            '</div>' +
            '</div>' +
            '</div>');
        this_.closest('.form-group-old').append(buttons);
        this_.closest('.form-group-old').find('.form-input').val(label);
    } else {
        label = this_.closest('.form-group-old').find('label').text();
        this_.closest('.form-group-old').find('.form-input').hide();
        this_.closest('.form-group-old').append($('.input-group-for-clone').clone().show());
        if(!this_.closest('.form-group-old').find('.form-input').prop('required')){
            req = '';
        }
        this_.closest('.form-group-old').find('.list').val(label);
        this_.closest('.form-group-old').append(buttons);
        // $('.card-edit[data-id='+id+'] .form-group').parent().show();

        $('.content-block-add-field').click(function () {
            let clone_el = $('#form-input-clone').first().clone();
            clone_el.removeAttr('id').css('margin-top','5px').val('');
            this_.closest('.form-group-old').find('.option-group').append(clone_el);
        });

        if(req != ''){
            this_.closest('.form-group-old').find('.element-required').attr('checked','checked');
        }
        let options = this_.closest('.form-group-old').find('select option');
        let i = 0;
        for(var op in options){
            if(i==0){
                this_.closest('.form-group-old').find('.option-group').html('');
            }
            i++;
            if(typeof options[op].text == 'string') {
                addOption(this_, options[op].text);
            }
        }

    }

    $('#popup-window').removeAttr('data-id');
    $('#popup-window').hide();

}

function addOption(this_, val_) {
    let clone_el = $('#form-input-clone').first().clone();
    clone_el.removeAttr('id').css('margin-top','5px');
    clone_el.find('input').val(val_);
    this_.closest('.form-group-old').find('.option-group').append(clone_el);
}

$('body').on('click', '.switch-crm-log-partials', function (e) {
    e.preventDefault();

    let _this = $(this);
    let partial = $(this).data('partial');
    let href = $(this).attr('href');

    if (partial) {
        $.ajax({
            url: href,
            method: 'POST',
            data: {partial: partial},
            dataType: 'html',
            success: function (response) {
                $('.switch-crm-log-partials').removeClass('active');
                _this.addClass('active');
                $('.render-crm-log').html(response);
            }
        });
    }
});


