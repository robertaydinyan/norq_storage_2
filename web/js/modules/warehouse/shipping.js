$(document).ready(function () {

    let $body = $('body');

    $body.on('change', '.warehouse-select', function () {
        let warehouse_id = $(this).val();
        let url = $(this).attr('data-url');

        let $select = $('body').find('.n-product-select');
        $select.find('option').remove().end();
        let $el = $('.n-product-select'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: warehouse_id},
            dataType: 'json',
            success: function (response) {
                let select2Options = settings;
                select2Options.data = response;
                select2Options.disabled = false;
                select2Options.tags = true;
                $select.select2(select2Options);
            }
        });
    });
    $body.on('change', '.n-product-select', function () {
        let n_product_id = $(this).val();
        let url = $(this).attr('data-url');

        let selectNPoduct = $(this)
        let warehouse_id = $('.warehouse-select').val();
        const data = {n_product_id: n_product_id, warehouse_id: warehouse_id};

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.data_nProducts.hasOwnProperty('individual')) {
                    selectNPoduct.parent().closest('.row').find('.product-nProduct').html(response.mac_partial)
                    $('.module-service-form-card').find('.row').last().find('.count-input').remove();
                    let addressBlock = selectNPoduct.closest('.module-service-form-card');
                    let rowCount = addressBlock.find('.row').length + 1;
                    selectNPoduct.parent().closest('.row').find('.product-nProduct').find('select').attr('id', function () {
                        $(this).val(null).trigger('change');
                        return $(this).attr('id') + '_' + (rowCount);
                    });
                    $('.kv-plugin-loading').hide();
                    let $select =  $('body').find('.mac-address-select');
                    // $select.find('option').remove().end();
                    let $el = selectNPoduct.parent().closest('.row').find('.mac-address-select'),
                        settings = $el.attr('data-krajee-select2'),
                        id = $el.attr('id');
                    settings = window[settings];
                   //console.log(settings)
                    let select2Options = settings;
                    select2Options.data = response.data_nProducts.individual;
                    select2Options.disabled = false;
                    select2Options.tags = true;
                    $select.select2(select2Options);
                } else {
                    //console.log(response.data_nProducts[0]['id']);
                    $('.module-service-form-card').find('.row').last().find('.select-mac-address').remove()
                    selectNPoduct.parent().closest('.row').find('.product-nProduct').html(response.count_partial);
                    selectNPoduct.parent().closest('.row').find('.input-count').attr('placeholder', response.data_nProducts['text']);
                    selectNPoduct.parent().closest('.row').find('.product-id-input').attr('value', response.data_nProducts['id']);
                }

            }
        });
    });

    let $csrfToken = $('meta[name="csrf-token"]').attr("content");

    $body.on('click', '.card-action-btn-add-address', function () {

        let $elN = $(this).closest('.module-service-form-card').find('.row:first').find('.n-product-select'),
            settingsN = $elN.attr('data-krajee-select2'),
            idN = $elN.attr('id');
        settingsN = window[settingsN];

        console.log($(this).closest('.module-service-form-card').find('select'))
        $(this).closest('.module-service-form-card').find('select').select2('destroy');


        let addressBlock = $(this).closest('.module-service-form-card');
        let rowCount = addressBlock.find('.row').length + 1;
        let firstRow = $(this).closest('.module-service-form-card').find('.row:first');

        let clone = firstRow.clone(true);
        clone.find('.mac-address-select').find('option').remove().end();
        clone.find('.select-mac-address').remove()
        clone.find('.count-input').remove();


        let randomId = makeid(5);

        clone.find('select').attr('id', function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        });

        clone.find('input').val('');

        clone.find('.card-action-btn-remove-address').removeClass('result_address');
        clone.find('.remove-address').removeClass('d-none');
        clone.find('.hr-text').removeClass('d-none');

        clone.insertAfter(addressBlock.find('.row').last());

        let $nProductSelect = $('.n-product-select');
        let $macAddressSelect = $('.mac-address-select');

        let $elNP = $nProductSelect,
            settingsNP = $elNP,
            idNP = $elNP.attr('id');
        settingsNP = window[settingsNP];
        console.log(settingsNP)

        let $elMA = $macAddressSelect,
            settingsMA = $elMA.attr('data-krajee-select2'),
            idMA = $elMA.attr('id');
        settingsMA = window[settingsMA];

        $nProductSelect.select2(settingsNP);
        $macAddressSelect.select2(settingsMA);
    });

    //Remove address
    $body.on('click', '.card-action-btn-remove-address', function () {

        let _this = $(this).closest('.row');
        if (!$(this).hasClass('result_address')) {
            _this.remove();
        } else {
            let address = $(this).attr('data-address-id');
            let url = $(this).attr('data-address-url');
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
                        data: {address_id: address},
                        dataType: 'json',
                        success: function (response) {
                            Swal.fire(
                                response.title,
                                response.message,
                                "success"
                            );

                            _this.remove();
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
        }
    });
});
