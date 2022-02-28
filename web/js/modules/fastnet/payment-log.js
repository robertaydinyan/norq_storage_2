let $body = $('body');

$body.on('click', '#pills-default-tab, #pills-daily-tab', function () {
    let id = $(this).attr('id');
    if (id == 'pills-default-tab') {
        $(`[aria-labelledby=pills-daily-tab]`).find('input').prop('checked', false);
    } else {
        $(`[aria-labelledby=pills-default-tab]`).find('input').prop('checked', false);
    }

    $('.grid-total-paid').text(0);
});

// Get total price for selected columns in payment log page GridView.
$body.on('change', '.total-price', function (e) {
    e.stopPropagation();
    let id = $('.grid-view').yiiGridView('getSelectedRows'); // Grid keys

    if (id.length) {

        $.ajax({
            url: '/fastnet/deal-payment-log/total-paid',
            method: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (resp) {
                $('.grid-total-paid').text(resp);
            }
        });

        $.ajax({
            url: '/fastnet/deal-payment-log/check-payment-received-status',
            method: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (resp) {
                console.log(resp);
                if (resp.status === true) {
                    $('#pay-selection').prop('disabled', false);
                } else {
                    $('#pay-selection').prop('disabled', true);
                }
            }
        });

        $.each($('.total-price:checked'), (key, checkbox) => {

            if ($(checkbox).attr('can-change') === "") {
                $('.centered-small-modal-content').prop('disabled', true);
            } else {
                $('.centered-small-modal-content').prop('disabled', false);
            }
        });
    } else {
        $('.grid-total-paid').text(0);
        $('#pay-selection, .centered-small-modal-content').prop('disabled', true);
    }

    if (id.length !== 1) {
        $('.payment-change-modal').prop('disabled', true);
    } else {
        $('.payment-change-modal').prop('disabled', false);
    }
});

// Set paid status for selected columns in payment log page GridView.
$body.on('click', '#pay-selection', function () {
    let id = $('.grid-view').yiiGridView('getSelectedRows'); // Grid keys

    if (id.length) {
        $.ajax({
            url: '/fastnet/deal-payment-log/set-paid-selected-items',
            method: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (resp) {
                if (resp === true) {
                    window.location.reload();
                } else {
                    console.log(resp);
                }
            }
        });
    } else {
    }
});



$body.on('change', '.selection-hdm', function () {
    var hdmArray = [];
    $("[name=selection_hdm]:checked").each(function() {
        hdmArray.push($(this).val());
    });

    if (hdmArray.length === 2) {
        $('.centered-small-modal-content-switch').removeAttr('title');
        $('.centered-small-modal-content-switch').prop('disabled', false);
    } else {
        $('.centered-small-modal-content-switch').attr('title', 'Ընտրեք 2 վճարում');
        $('.centered-small-modal-content-switch').prop('disabled', true);
    }
});

$body.on('click', '.centered-small-modal-content-switch', function () {
    let url = $(this).attr('data-url-submission');  // get URL from button or link

    var hdmArray = [];
    $("[name=selection_hdm]:checked").each(function() {
        hdmArray.push($(this).val());
    });

    $.ajax({
        url: url,
        method: 'POST',
        data: {ids: hdmArray},
        dataType: 'json',
        success: function (response) {
            if (response == true) {
                window.location.reload();
            }
        }
    });
});

// Open payment change modal
$body.on('click', '.centered-small-modal', function() {
    let modal = $('#modal');
    let id = $('.grid-view').yiiGridView('getSelectedRows'); // Grid keys
    let url = $(this).attr('data-url-submission');  // get URL from button or link

    $.ajax({
        url: url,
        method: 'POST',
        data: {ids: id},
        dataType: 'html',
        success: function (response) {
            $(modal).find('#centered-small-modal-content').html(response);

            $(modal).modal('show');
        }
    });
});


// Modal payment scripts

$body.on('change', '[id*=payment-select-]', function () {
    let this_ = $(this);
    let container = this_.closest('.payment-item');
    let currentPrice = this_.closest('.payment-item').find('[name=current_log_price]').val();

    let id = $(this).val();
    $.ajax({
        url: '/fastnet/deal-payment-log/get-selected-deal-info',
        method: 'POST',
        data: {id: id},
        dataType: 'html',
        success: function (response) {
            container.find('.payment-log-item-selected-table').html(response);
        }
    });

    let first_cashier = container.find('[name=first_cashier]');
    let second_cashier = container.find('[name=second_cashier]');

    $.ajax({
        url: '/fastnet/deal-payment-log/get-selected-deal-total-sum',
        method: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (response) {

            let residual = null;

            if (parseInt(currentPrice) < parseInt(response.total)) {
                residual = parseInt(response.total) - parseInt(currentPrice);
                first_cashier.val(parseInt(currentPrice));
                second_cashier.val(residual);
                container.find('[name=new_log]').val(parseInt(currentPrice));
                container.find('[name=v_1]').val(0);
                container.find('[name=v_2]').val(1);
                container.find('[name=v_3]').val(0);
            } else if(parseInt(currentPrice) > parseInt(response.total)) {
                residual = parseInt(currentPrice) - parseInt(response.total);
                first_cashier.val(residual);
                second_cashier.val(parseInt(response.total));
                container.find('[name=new_log]').val(parseInt(response.total));
                container.find('[name=v_1]').val(1);
                container.find('[name=v_2]').val(0);
                container.find('[name=v_3]').val(0);
            } else if(parseInt(currentPrice) === parseInt(response.total)) {
                container.find('[name=v_1]').val(0);
                container.find('[name=v_2]').val(0);
                container.find('[name=v_3]').val(1);
            }
        }
    });
});

/**
 * Submit cashier change.
 */
$body.on('click', '.revert-payment-cashier button', function () {
    let this_ = $(this);
    this_.css('transform', 'rotate(180deg)')
    let old_log_id = this_.closest('.payment-item').find('[name=old_log_id]').val();
    let secondCashierId = this_.closest('.payment-item').find('[id*=payment-select-]').find(':selected').val();
    let secondCashier = parseInt(this_.closest('.payment-item').find('[name=second_cashier]').val());
    let firstCashier = parseInt(this_.closest('.payment-item').find('[name=first_cashier]').val());
    let revertBallance = (firstCashier - secondCashier == 0) ? 1 : 0;
    let comment = this_.closest('.payment-item').find('[id=payment-comment]').val();


    $.ajax({
        url: '/fastnet/deal-payment-log/revert-cashier',
        method: 'POST',
        data: {
            old_log_id: old_log_id,
            secondCashierId: secondCashierId,
            revertBallance: revertBallance,
            comment: comment,

        },
        dataType: 'json',
        success: function (response) {
            this_.removeClass('text-dark');

            if (response.status == true) {
                this_.prop('disabled', true);
                this_.removeClass('text-danger');
                this_.addClass('text-primary');
            } else {
                this_.removeClass('text-primary');
                this_.addClass('text-danger');
            }
        }
    });
});

$body.on('change', '#payment-change', function () {
    let id = $(this).val();
    let this_ = $(this);

    $.ajax({
        url: '/fastnet/deal-payment-log/get-selected-deal-payment-info',
        method: 'POST',
        data: {id: id},
        dataType: 'html',
        success: function (response) {
            this_.closest('.payment-item.card').find('.payment-log-item-table-for-selected').html(response);
        }
    });
});

/**
 * Submit
 */
$body.on('click', '.submit-payment-change', function () {
    let this_ = $(this);
    let selectedDeal = $('#payment-change').val();
    let wrongPayedClient = $('[name=wrong_deal]').val();
    let wrongPayedDeal = $('[name=wrong_deal_id]').val();
    let comment = $('#wrong-payment-comment').val();
    let url = this_.attr('data-url-submission');

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            selectedDeal: selectedDeal,
            wrongPayedClient: wrongPayedClient,
            wrongPayedDeal: wrongPayedDeal,
            comment: comment,
        },
        dataType: 'json',
        beforeSend: function () {
            this_.prop('disabled', true);
        },
        success: function (response) {
            if (response.status === true) {
                window.location.reload();
            } else {
                console.log(response);
            }
        }
    });
});

$body.on('click', '.cash-register-receipt-cashier-submit', function () {

    let id = $('.grid-view').yiiGridView('getSelectedRows'); // Grid keys
    let url = $(this).attr('data-url-submission');  // get URL from button or link
    let cashier = $('#cash-register-receipt-cashier-id').val();

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            selection: id,
            cashier: cashier,
        },
        dataType: 'json',
        success: function (response) {
            window.location.reload();
        }
    });

});

