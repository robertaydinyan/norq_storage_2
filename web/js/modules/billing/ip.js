$('body').on('change', '#base_station_id', function () {
    let id = $(this).val();
    let url = $(this).attr('data-url');

    $.ajax({
        url: url,
        method: 'POST',
        data: {id: id},
        dataType: 'html',
        success: function (response) {
            $('.arround-ip-addresses .ipAddresses').remove();
            $(response).insertBefore('.mapForIp');
        }
    });
});