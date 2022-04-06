$(document).ready(function () {

    $("[data-toggle=popover]").popover({
        html : true,
        trigger: 'click',
        content: function() {
            let content = $(this).attr("data-popover-content");
            let url = $(this).attr('data-url');
            let id = $(this).attr('data-id');

            $.ajax({
                url: url,
                method: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function (response) {
                    $('.popover-service-price').text(response.service);
                    console.log(response);
                    if (response.hasPenalty === true) {
                        $('.item-penalty').removeClass('d-none');
                        $('.popover-penalty-price').text(response.penalty);
                    } else {
                        $('.item-penalty').addClass('d-none');
                    }

                    $('.popover-total-price').text(response.total);

                    if (response.contractEnd.length) {
                        $('.contract-ending-date').text(response.contractEnd);
                    }

                    if (response.remainsDay) {
                        $('.remaining-date').text(response.remainsDay);
                    }
                }
            });

            return $(content).children(".popover-body").html();
        }
    });

    $('body').on('click', '.popover-close', function () {
        $('.html-popover').popover('hide');
    });

});