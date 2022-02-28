function showInfo(id){
    if(id){
        $('.hide-block').hide();
        $.ajax({
            url: '/warehouse/shipping-request/get-shipping-info',
            method: 'get',
            dataType: 'html',
            data: { id: id},
            success: function (data) {
                $('.mod-content').html(data);
            }
        });
    }
}

function selectProduct(){
    $.ajax({
        url: '/warehouse/product/get-products-popup',
        method: 'get',
        dataType: 'html',
        success: function (data) {
            $('#showProducts').html(data);
        }
    });
}

function checkMac(el_){
    if(el_){
        $('.hide-block').hide();
        $.ajax({
            url: '/warehouse/shipping-request/check-mac-address',
            method: 'get',
            dataType: 'json',
            data: { mac: el_.val()},
            success: function (data) {
                if(data.result == true){
                    el_.css('border','1px solid red');
                    alert('Նմանատիպ mac հասցեյով ապրանք կա խնդրում ենք փոխել');
                }
            }
        });
    }
}

// $(function(){
//     var current = location.pathname;
//     $('#w3-collapse  li a').each(function(){
//         var $this = $(this);
//         // if the current path is like this link, make it active
//         if($this.attr('href').indexOf(current) !== -1){
//             $this.addClass('active');
//         }
//     })
// })
$(document).ready(function () {

    $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
    let $body = $('body');
    let $csrfToken = $('meta[name="csrf-token"]').attr("content");

    $body.on('change','#date_create',function(){
        if(parseInt($('#shippingrequest-shipping_type').val()) != 2 && parseInt($('#shippingrequest-shipping_type').val()) != '6') {
            $('#shippingrequest-provider_warehouse_id').trigger('change');
        }
    });
    $body.on('click','.select_all', function(){
        if ($(this).is(':checked')) {
            $('input:checkbox').attr('checked','checked');
        } else {
            $('input:checkbox').removeAttr('checked');
        }
    });
    $body.on('change','.chks', function(){
        var str = '';
        $('.chks').each(function(){
            if ($(this).is(':checked')) {
                str+='"'+$(this).attr('data-mac')+'",';
            }
        });
        $('#serias').val(str);
    });

    $body.on('change', '#shippingrequest-provider_warehouse_id', function () {
        var ware_id = $(this).val();
        var date_create = $('#date_create').val();

        if(ware_id){

            $.ajax({
                url: '/warehouse/product/get-product-info',
                method: 'get',
                dataType: 'json',
                data: { wId: ware_id,date_: date_create},
                success: function (data) {
                    $('.hide-block').hide();
                    var opt = '';
                    if(data.length) {
                        opt += '<option>Ընտրել</option>';
                        for (var i = 0; i<data.length; i++) {
                            if(data[i].namiclature_data.individual != 'true') {
                                opt += '<option data-max="' + data[i].count + '" data-individual="' + data[i].namiclature_data.individual + '" value="' + data[i].id + '">' + data[i].namiclature_data.name + ' (' + data[i].count + ' ' + data[i].namiclature_data.qty_type + ') </option>';
                            } else {
                                opt += '<option data-max="' + data[i].count + '" data-individual="' + data[i].namiclature_data.individual + '" value="' + data[i].id + '">' + data[i].namiclature_data.name + ' - ' + data[i].mac_address + ' (' + data[i].count + ' ' + data[i].namiclature_data.qty_type + ')</option>';
                            }
                        }
                    }
                   $('#nomenclature_product').html(opt);
                }
            });
        } else {
            $('.hide-block').show();
        }
    });

    $body.on('click', '.check-counts', function () {
        $('.nm_products option,input').removeAttr('disabled');
        $('.counts-input input').each(function(){
            if($(this).val()>$(this).attr('max')){
                $(this).css('border','1px solid red');
                return false;
            }
        });
    });

    $body.on('change', '.nm_products', function () {
        var product_id = $(this).val();
        var max = $(this).find(':selected').data('max');
        var individual = $(this).find(':selected').data('individual');

        if(individual){
           $(this).closest('.product-block').find('.field-shippingrequest-count input').val(1).attr('disabled','disabled');
           $(this).closest('.product-block').find('.field-shippingrequest-count input').attr('max',1);
        } else {
            $(this).closest('.product-block').find('.field-shippingrequest-count input').val('').removeAttr('disabled').attr('max',max);
        }
        var v = $(this).val();
        setTimeout(function(){
            $(".nm_products").not($(this)).find("option[value='"+v+"']").attr('disabled','disabled');
        },200);

    });
    $body.on('change', '#shippingrequest-provider_warehouse_id', function () {
        var v = $(this).val();
        $("#shippingrequest-supplier_warehouse_id").find("option").removeAttr('disabled');
        $("#shippingrequest-supplier_warehouse_id").val(null).trigger('change');
        $("#shippingrequest-supplier_warehouse_id").find("option[value='"+v+"']").attr('disabled','disabled');
    });

    $body.on('click', '.btn-add-product', function () {

        $(this).closest('.module-service-form-card').find('select').select2('destroy');
        let addressBlock = $(this).closest('.module-service-form-card');
        let rowCount = addressBlock.find('.row').length + 1;

        let firstRow = $('.product-block').first();
        let clone = firstRow.clone(true).removeClass('hide');
        let randomId = makeid(5);

        clone.find('select.form-control').attr('id', function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        });
        clone.insertAfter(addressBlock.find('.row').last());

        let $nm_products = $('.module-service-form-card select.form-control');
        let $elCom = $nm_products,
            settingsCom = $elCom.attr('data-krajee-select2'),
            idCom = $elCom.attr('id');
        settingsCom = window[settingsCom];
        $nm_products.select2(settingsCom);

    });
    $body.on('click', '.card-action-btn-add-address', function () {
        let $elCy = $(this).closest('.module-service-form-card').find('.row:first').find('.country-select'),
            settingsCy = $elCy.attr('data-krajee-select2'),
            idCy = $elCy.attr('id');
        settingsCy = window[settingsCy];

        $(this).closest('.module-service-form-card').find('select').select2('destroy');
        let addressBlock = $(this).closest('.module-service-form-card');
        let rowCount = addressBlock.find('.row').length + 1;
        let firstRow = $(this).closest('.module-service-form-card').find('.row:first');
        let clone = firstRow.clone(true);
        let randomId = makeid(5);

        clone.find('select').attr('id', function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        });
        clone.find('.add-address-checkbox').attr('id' , function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        })
        clone.find('.has-star').attr('for' , function () {
            return $(this).attr('for') + '_' + (rowCount);
        })

        clone.find('input').val('');
        clone.find('.card-action-btn-remove-address').removeClass('result_address');
        clone.find('.remove-address').removeClass('d-none');
        clone.find('.hr-text').removeClass('d-none');

        clone.insertAfter(addressBlock.find('.row').last());

        let $countrySelect = $('.country-select');
        let $regionSelect = $('.region-select');
        let $citySelect = $('.city-select');
        let $communitySelect = $('.community-select');
        let $streetSelect = $('.street-select');
        let $elC = $countrySelect,
            settingsC = $elC.attr('data-krajee-select2'),
            idC = $elC.attr('id');
        settingsC = window[settingsC];

        let $elR = $regionSelect,
            settingsR = $elR.attr('data-krajee-select2'),
            idR = $elR.attr('id');
        settingsR = window[settingsR];

        let $elCi = $citySelect,
            settingsCi = $elCi.attr('data-krajee-select2'),
            idCi = $elCi.attr('id');
        settingsCi = window[settingsCi];

        let $elCom = $communitySelect,
            settingsCom = $elCom.attr('data-krajee-select2'),
            idCom = $elCom.attr('id');
        settingsCom = window[settingsCom];

        let $elStr = $streetSelect,
            settingsST = $elStr.attr('data-krajee-select2'),
            idSt = $elStr.attr('id');
        settingsST = window[settingsST];

        $countrySelect.select2();
        $regionSelect.select2(settingsC);
        $citySelect.select2(settingsCi);
        $communitySelect.select2(settingsCom);
        $streetSelect.select2(settingsST);
    });

    $('.field-nomenclature_product-select select').on('change',function(){

         var pId= $(this).val();
         var wId= $('#shippingrequest-provider_warehouse_id').val();
        if(pId && wId) {
            $.ajax({
                url: '/warehouse/product/get-product-info',
                method: 'get',
                dataType: 'json',
                data: {id: pId, wId: wId},
                success: function (data) {
                    if(data.individual == 'true'){
                        $('.field-product-mac_address').show();
                        $('#product-count').val(1).attr('disabled','disabled');
                        $('#is_vip').val(1);

                    } else {
                        $('.field-product-mac_address').hide();
                        $('#product-count').val('').removeAttr('disabled');
                        $('#is_vip').val(0);
                    }
                }
            });
        }

    });

    // Remove address
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