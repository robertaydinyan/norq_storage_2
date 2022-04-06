$(function(){
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
//we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
    $('body').on('click', '.showModalButton', function(){
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content.

        let modal = $('#modal');
        let modalHeader = '<h5 class="mr-3">' + $(this).attr('title') + ': </h5>';
        modal.addClass('sk-rtl-modal');

        if (modal.data('shown.bs.modal')) {
            modal.find('#modalContent')
                .load($(this).attr('value'), function () {
                    //dynamiclly set the header for the modal
                    modal.find('.module-name').prepend(modalHeader);
                });
        } else {
            //if modal isn't open; open it and load content
            modal.modal('show')
                .find('#modalContent')
                .load($(this).attr('value'), function () {
                    //dynamiclly set the header for the modal
                    modal.find('.module-name').prepend(modalHeader);
                });
        }
    });

});
