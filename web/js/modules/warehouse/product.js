$('body').append('<div id="modal-log"></div>');
function showLog(mac){
    if(mac){
        $.ajax({
            url: '/warehouse/product/show-log',
            method: 'get',
            dataType: 'html',
            data: { mac: mac},
            success: function (data) {
                $('body').find('#modal-log').html(data);
            }
        });
    } else {
        return false;
    }
}
