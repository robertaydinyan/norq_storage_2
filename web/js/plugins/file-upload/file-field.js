(function ($) {

    $(document).ready(function () {

        let $body = $('body');

        // Input file trigger click
        $body.on('click', '.images .pic', function () {
            let _this = $(this);
            _this.find('.file-uploader').get(0).click();
        });

        // Preview
        $body.on('change', '.file-uploader', function () {

            let _this = $(this);
            let isMultiple = $(this).attr('multiple');

            if (typeof isMultiple !== typeof undefined && isMultiple !== false) { // Multiple

                let counter = -1, file;
                //
                // if (!_this.hasClass('result_file_exist')) {
                //   _this.closest('.images').find('.img').remove();
                // }
                _this.closest('.images').find('.img.new-img').remove();

                while (file = this.files[++counter]) {
                    let ext = file.name.split('.').pop();

                    let fileType = file["type"];
                    let validImageTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];

                    let removeButton = '';

                    if (!_this.hasClass('disable-delete')) {
                        removeButton = '<span class="remove-pic"><i class="fal fa-times"></i></span>';
                    }

                    if ($.inArray(fileType, validImageTypes) > 0) {
                        let reader = new FileReader();
                        reader.onloadend = (function () {

                            return function() {
                                _this.closest('.images').append('<div class="img new-img" style="background-image: url(\'' + reader.result + '\');" rel="'+ reader.result  +'">' + removeButton + '</div>');
                            };
                        })(file);

                        reader.readAsDataURL(file);
                    } else {
                        _this.closest('.images').append(`<div class="img new-img" style="background-image: url(/img/icons/file.svg); background-color: #fff; background-size: auto;">
                                                            ${removeButton}
                                                            <div class="img-file-info">${file.name}</div>
                                                        </div>`);
                    }

                }

            } else { // Single
                let reader = new FileReader();
                reader.onload = function(event) {
                    _this.closest('.images').prepend('<div class="img" style="background-image: url(\'' + event.target.result + '\');" rel="'+ event.target.result  +'"><span class="remove-pic"><i class="fal fa-times"></i></span></div>');
                    _this.closest('.images').find('.pic').hide();
                }
                reader.readAsDataURL(_this.get(0).files[0]);
            }
        });

        // Remove selected
        $body.on('click', '.remove-pic', function () {
            let _this = $(this);
            let isMultiple = _this.closest('.images').find('.file-uploader').attr('multiple');

            if (_this.hasClass('result_file')) {

                let fileId = _this.attr('data-file-id');
                let url = $(this).attr('data-file-url');
                let title = $(this).attr('data-title');
                let confirmText = $(this).attr('data-confirm-text');
                let cancelText = $(this).attr('data-cancel-text');

                Swal.fire({
                    title: title,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText,
                    buttonsStyling: true,
                    // customClass: {
                    //     confirmButton: 'btn-sm'
                    // },
                    onBeforeOpen: function(ele) {
                        $(ele).find('button.swal2-confirm.swal2-styled').toggleClass('swal2-confirm swal2-styled swal2-confirm btn btn-md');
                        $(ele).find('button.swal2-cancel.swal2-styled').toggleClass('swal2-cancel swal2-styled btn btn-md btn-light ml-3');
                    }
                }).then(function (e) {

                    if (e.value === true) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {file_id: fileId},
                            dataType: 'json',
                            success: function (response) {

                                if (response.status === true) {

                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        "success"
                                    );

                                    // Hide add more button for single image
                                    if (isMultiple == 'multiple') {
                                        _this.closest('.images').find('.pic').show();
                                    }

                                    _this.closest('.img').remove();
                                } else {
                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        "error"
                                    );
                                }

                            },
                            failure: function (response) {
                                Swal.fire(
                                    "Internal Error",
                                    "Oops, your note was not saved.", // had a missing comma
                                    "error"
                                )
                            }
                        });
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                });
            } else {
                // Hide add more button for single image
                if (isMultiple == 'multiple') {
                    _this.closest('.images').find('.pic').show();
                }

                _this.closest('.img').remove();
            }

        });

    });

})(jQuery);
