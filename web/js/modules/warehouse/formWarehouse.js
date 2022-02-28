$(document).ready(function() {
    let $body = $('body');

    $body.on('change', '.add-address-checkbox', function () {
        if ($(this).is(':checked')) {
            $('.module-service-form-card').show();
        } else {
            $('.module-service-form-card').hide();
        }
    });

} );