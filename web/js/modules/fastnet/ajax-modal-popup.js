//------------------------------------------------------------------------------
// Modal-Popup.js
// Source: https://www.yiiframework.com/wiki/806/render-form-in-popup-via-ajax-create-and-update-with-ajax-validation-also-load-any-page-via-ajax-yii-2-0-2-3
// Author: skworden
//------------------------------------------------------------------------------
// Instructions:
// - Register this file in /assets/AppAsset.php
// - Add a Bootstrap modal to default layout in /views/layouts/main.php:
//   Eg:
//      <?php
//          yii\bootstrap\Modal::begin([
//              'headerOptions' => ['id' => 'modalHeader'],
//              'id'            => 'id-modal-main',
//              'size'          => yii\bootstrap\Modal::SIZE_LARGE,
//
//              // Keyboard:
//              //   Keeps from closing modal with ESC key or by clicking out of the modal.
//              //   User must click Cancel or X to close.
//              //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
//          ]);
//          echo "<div id='modal-content-details'>";
//          echo "    <div style='text-align:center'>";
//          echo "        <span class='fa fa-refresh fa-spin fa-1x fa-fw'></span>" . Yii::t('app', 'Loading Data...');  // Loading icon
//          echo "    </div>";
//          echo "</div>";
//          yii\bootstrap\Modal::end();
//      ?>
//------------------------------------------------------------------------------
$(function() {
    //--------------------------------------------------------------------------
    // Get the modal button click to create / update item.
    //--------------------------------------------------------------------------
    //
    // We get the button by class not by ID, because you can only have one id on a page,
    // and you can have multiple classes.  Therefore, you can have multiple open
    // modal buttons on a page, all with or without the same link.
    //
    // We use on() so the DOM element can be called again if they are nested.
    // Otherwise, when we load the content once, it kills the DOM element,
    // and it won't let you load another modal 'on click' without a page refresh.
    $(document).on('click', '.showModalButton', function() {

        var modal = $('#id-modal-main');

        var btnDismissModal = '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '    <span aria-hidden="true">&times;</span>' +
            '</button>';

        // Check if the modal is open.  If it is open, just reload content, not whole modal.
        // Also, this allows you to nest buttons inside of modals to reload
        // the content it is in. The if-else logic is intentionally separated instead
        // of putting it into a function to get the button, since it is using a class
        // not an #id. There might be many of them, and we need to ensure we get
        // the right button and content.
        if ( $(modal).data('bs.modal').isShown ) {

            //alert('Loading modal for 2nd time...');

            // Load content from specified link
            $(modal).find('#modal-content-details')
                //.load($(this).attr('value'));  // or .load($(this).attr('href'));
                .load($(this).attr('data-url-submission'));  // or .load($(this).attr('href'));

            $(modal).find('#modal-content-error').css('height', '0px');
            $(modal).find('#modal-content-error').css('background-color', 'transparent');
            $(modal).find('#modal-content-error').html('');

            // Set the header for the modal dynamically
            //document.getElementById('modalHeader').innerHTML = btnDismissModal + '<h4>' + $(this).attr('title') + '</h4>';
            $(modal).find('#modalHeader').html( btnDismissModal + '<h4>' + $(this).attr('title') + '</h4>' );

        } else {
            // If modal is not open; open it now and load content
            //$('#id-modal-main').modal('show')
            //    .find('#modal-content-details')
            //    .load($(this).attr('value'));

            //alert('Loading modal for 1st time...');

            //var url = $(this).attr('value');  // get URL from button or link
            var url = $(this).attr('data-url-submission');  // get URL from button or link
            console.log(url);

            $(modal).find('#modal-content-error').css('height', '0px');
            $(modal).find('#modal-content-error').css('background-color', 'transparent');
            $(modal).find('#modal-content-error').html('');

            // Load content from specified link
            $(modal).find('#modal-content-details').load(url, function( response, status, xhr ) {
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error: ";
                    //$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
                    console.log(msg + xhr.status + " " + xhr.statusText );
                    alert(msg + xhr.status + " " + xhr.statusText );
                }
            });

            // Set the header for the modal dynamically
            //document.getElementById('modalHeader').innerHTML = btnDismissModal + '<h4>' + $(this).attr('title') + '</h4>';
            $(modal).find('#modalHeader').html( btnDismissModal + '<h4>' + $(this).attr('title') + '</h4>' );

            modal.modal('show');  // open modal
        }
    });
});