$(document).ready(()=> {
    $('body').on('change' , '.internet', function () {
        $('.internetForm').show();
        $('.packetForm').hide();
    })

    $('body').on('change' , '.packet', function () {
       $('.internetForm').hide();
       $('.packetForm').show();
    })


    $('body').on('change' , '#internet_is_low' , function () {
        if ($(this).is(':checked')) {
            $('.lowerSpeedSetPlace').show();
        } else {
            $('.lowerSpeedSetPlace').hide();
        }
    })


    $('body').on('change' , '.choose-on' , function () {
        if ($(this).is(':checked')) {
            $('.sizeLowSpeed').show();
        }
    })

    $('body').on('change' , '.choose-off' , function () {
        if ($(this).is(':checked')) {
            $('.sizeLowSpeed').hide();
        }
    })
})