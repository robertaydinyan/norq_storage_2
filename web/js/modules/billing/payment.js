let $body = $('body');

$('.addVacation').on('click',function(){

    let start_date = $('#crmdealvacation-data_start').val();
    let end_date = $('#crmdealvacation-data_end').val();
    let end_date_old = $('#old_date_end').val();
    let deal_number = $('#deal_number').val();
    let comment = $('#comment').val();
    let vacation_type = $('#vacation-type').val();

    let url = $(this).attr('data-url');
    if(deal_number && end_date && start_date){
        $.ajax({
            url: url,
            method: 'post',
            data: {deal_number: deal_number, start_date:start_date, end_date_old:end_date_old, end_date:end_date, vacation_type:vacation_type, comment:comment},
            success: function(res){

                window.location.reload();
            }
        });
    } else {
        alert('Առանց օրերը նշելու արձակուրդ չեք կարող ուղղարկել');
    }

});

$('#end_vc').on('click',function(){

    let end_date_old = $('#old_date_end').val();
    let deal_number = $('#deal_number').val();
    let url = $(this).attr('data-url');
    let vacation_id = $('#vacation_id').val();
    if(deal_number){
        $.ajax({
            url: url,
            method: 'post',
            data: {deal_number: deal_number, vacation_id:vacation_id, end_date_old:end_date_old},
          //  dataType: 'json',
            success: function(res){
               // window.location.reload();
            }
        });
    }
});

$('#disruption').on('click',function(){
    let this_ = $(this);
    let deal_id = $('#deal_id').val();
    let reason = $('#reason').val();
    let reason_text = $('.reason_text').val();
    let url = $(this).attr('data-url');
    let totalPaid = $('input[name=total_paid]').val();

    if(reason == 'other' && reason_text == ''){
        alert('Պատճառը նշված չէ');
    } else {
        if(deal_id){
            $.ajax({
                url: url,
                method: 'post',
                data: {id: deal_id,reason:reason,reason_text:reason_text, totalPaid: totalPaid},
                dataType: 'json',
                beforeSend: function () {
                    this_.addClass('disabled')
                    this_.prop('disabled', true);
                    this_.find('.spinner-border').show();
                },
                complete: function(r){
                    window.location.reload();
                }
            });
        }
    }
});

$body.on('change','#cancel',function (){
    if($(this).is(':checked')){
        $('#reason').parent().show(50);
        $('.show_any').removeClass('hide');
        $('.cancel_btn').parent().show(50);
    } else {
        $('.hide').hide();
        $('.show_any').addClass('hide').hide(50);
    }
});

$body.on('change','#reason',function (){
    if($(this).val() == 'other'){
        $('.reason_text').parent().show(50);
    } else {
        $('.reason_text').parent().hide(50);
    }
});

// Disable company service manually
$body.on('click', '#disable-company-service', function () {
    let this_ = $(this);
    let url = $(this).attr('data-url');
    let deal_id = $('#deal_id').val();

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: deal_id},
        dataType: 'json',
        beforeSend: function () {
            this_.addClass('disabled')
            this_.prop('disabled', true);
            this_.find('.spinner-border').show();
        },
        success: function (response) {
            window.location.reload();
        }
    });
});

$body.on('click', '.add-payment', function() {
    let this_ = $(this);
    let dealId = $('#payment-pay').attr('data-deal-id');
    let requestUrl = $('#payment-pay').attr('data-url');
    let priceValue = parseInt($('#payment-pay').val());
    let responsible_id = $('#responsible_id').val();
    let payment_date = $('#set-payment-date').val();
    let hdm = 0;
    let total = parseInt($('.payment-price').attr('data-paid'));

    if ($('#deal-hdm').prop('checked')) {
        hdm = 1;
    }

    if(responsible_id && priceValue){
        $('#payment-pay').attr('style', 'border: 1px solid #ced4da !important;');
        $('#responsible_id').next().attr('style', 'border: 1px solid #ced4da !important;');
        $.ajax({
            url: requestUrl,
            type: 'POST',
            data: {id: dealId, price: priceValue,operator_id:responsible_id, hdm: hdm, payment_date: payment_date},
            dataType: 'html',
            beforeSend: function () {
                this_.addClass('disabled')
                this_.prop('disabled', true);
                this_.find('.spinner-border').show();
            },
            success: function (response) {
                window.location.reload();
            }
        });
    } else {
        if(!responsible_id){
            $('#responsible_id').next().attr('style', 'border: 1px solid red !important;');
        } else {
            $('#responsible_id').next().attr('style', 'border: 1px solid #ced4da !important;');
        }
        if(!priceValue){
            $('#payment-pay').attr('style', 'border: 1px solid red !important;');
        } else {
            $('#payment-pay').attr('style', 'border: 1px solid #ced4da !important;');
        }
    }


});