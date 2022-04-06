let $body = $('body');

$(document).keypress(function(event){
    if (event.which == '13') {
        event.preventDefault();
    }
});

$body.on('change', '#deal-connect_type', function () {
    if ($(this).val() !== '' && $(this).val() == 2) {
        $('.antenna-ip-address').show();
        getIpAntenna($(this));
    } else {
        $('.antenna-ip-address').hide();
    }
});

function getIpAntenna(element, selected = null) {
    let self = $(element);
    let base_station_id = $('#deal-base_station_id').val();
    let url = self.attr('data-url');
    let $select = $('[id="deal-antenna_ip"]');
    $select.find('option').remove().end();
    let $el = $('[id="deal-antenna_ip"]'),

        settings = $el.attr('data-krajee-select2')
    id = $el.attr('id');
    settings = window[settings];
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            base_station_id: base_station_id
        },
        success: function(response){
            let select2Options = settings;
            select2Options.data = response;
            $select.select2(select2Options).trigger('change');

            if (selected !== null) {
                $select.val(selected).trigger('change');
            }
        }
    });
}

$body.on('click', '.send-agreement', function () {

    let this_ = $(this);
    let deal_number = $('#deal_number').val();
    let url = this_.attr('data-url-submission');

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            deal_number: deal_number
        },
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
        }
    });
});