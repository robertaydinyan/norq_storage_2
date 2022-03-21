$(document).ready(function(){
    $(window).on('load', function () {
        // $.ajax({
        //     url: '/crm/lead/calendar-list',
        //     type: 'post',
        //     dataType: 'json',
        //     success: function (res) {
        //
        //         $('#calendar').fullCalendar({
        //             lang: 'ru',
        //             buttonText: {
        //                 //Here I make the button show French date instead of a text.
        //                 today: 'Сегодня'
        //             },
        //             events: res,
        //             eventClick: function (calEvent, jsEvent, view) {
        //                 showCrmModal(calEvent.title,calEvent.data_url);
        //             },
        //             eventRender: function (event, element) {
        //                 var bg = event.status == 1 ? '#d9edf7' : '#ccc';
        //                 element.addClass('ride_edit_'+event.id);
        //                 element.css({
        //                     'background-color': bg,
        //                     'border-color': '#d9edf7',
        //                     'color': '#333',
        //                     'cursor': 'pointer'
        //                 });
        //                 if (event.icon) {
        //                     var color = event.bus_id ? '#5cb85c' : '#e7502e';
        //                     element.find(".fc-title").prepend("<i style='color: " + color + "' class='fa fa-" + event.icon + "'></i> ");
        //                     if((event.payedTicketCount * 1) > 0){
        //                         element.find(".fc-title").prepend("<span title='Количество проданных билетов' class='label label-success'>"+event.payedTicketCount+"</span>");
        //                     }
        //
        //                 }
        //             }
        //
        //         });
        //     }
        // });
    });
});

function showCrmModal(title,url){
    //check if the modal is open. if it's open just reload content not whole modal
    //also this allows you to nest buttons inside of modals to reload the content it is in
    //the if else are intentionally separated instead of put into a function to get the
    //button since it is using a class not an #id so there are many of them and we need
    //to ensure we get the right button and content.

    let modal = $('#modal');
    let modalHeader = '<h2>' + title + '</h2>';
    modal.addClass('sk-rtl-modal');

    if (modal.data('shown.bs.modal')) {
        modal.find('#modalContent')
            .load(url, function () {
                //dynamiclly set the header for the modal
                modal.find('.module-name').html(modalHeader);
            });
    } else {
        //if modal isn't open; open it and load content
        modal.modal('show')
            .find('#modalContent')
            .load(url, function () {
                //dynamiclly set the header for the modal
                modal.find('.module-name').html(modalHeader);
            });
    }
}