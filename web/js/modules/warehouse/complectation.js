
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
         var l = 0;
            $('.mac').each(function(){
                if($(this).val() == el_.val()){
                    l++;
                }
            });
            if(l>1){
                alert('Նմանատիպ mac հասցեյով արդեն կա մուտք');
            }
    }
}

$(document).ready(function () {

           let $body = $('body');
           $body.on('change','.product-nomenclature_product_id',function(){
            var th = $(this);
            setTimeout(function(){
                var cd = th.closest('.module-service-form-card').find('.field-product-count').css('display');
                if(cd == 'block' ){
                    $('.check-counts').attr('disabled','disabled');
                } else{
                    $('.check-counts').removeAttr('disabled');
                }
            },400);
               
            });
        $body.on('change','.product-count',function(){
                if($(this).val()){
                    $('.check-counts').removeAttr('disabled');
                } else{
                    $('.check-counts').attr('disabled','disabled');
                }
               
            });
    $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
    let $csrfToken = $('meta[name="csrf-token"]').attr("content");

    $body.on('change','#complectation-created_at',function(){
       
            $('#complectation-warehouse_id').trigger('change');
        
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

    $body.on('change', '#complectation-warehouse_id', function () {
        var ware_id = $(this).val();
        var date_create = $('#complectation-created_at').val();

        if (ware_id) {

             $.ajax({
                url: '/warehouse/product/get-product-info',
                method: 'get',
                dataType: 'json',
                data: { wId: ware_id,date_: date_create},
                success: function (data) {
                    let lang = $('#lang').val();
                    $('.hide-block').hide();
                    var opt = '';
                    if(data.length) {
                        opt += '<option>Ընտրել</option>';
                        for (var i = 0; i<data.length; i++) {
                            opt += '<option data-max="' + data[i].count + '" data-individual="' + data[i].namiclature_data.individual + '" value="' + data[i].id + '">' + data[i].namiclature_data['name_' + lang] + ' (' + data[i].count + ' ' + data[i].namiclature_data.qty_type + ') </option>';
                        }
                    }
                    $('#nomenclature_product').html(opt);
                }
            });
        } else {
            $('.hide-block').show();
        }
    });

    $body.on('change', '.nm_products', function (e) {
        e.preventDefault();
        var product_id = $(this).val();
        _this = $(this);
        var ware_id = $('#complectation-warehouse_id').val();
         var individual = $(this).find(':selected').data('individual');
        if(individual){
             _this.removeAttr('name');
             var date_create = $('#complectation-created_at').val();
               if(ware_id && product_id){
                $.ajax({
                    url: '/warehouse/product/get-product-info',
                    method: 'get',
                    dataType: 'json',
                    data: { wId: ware_id,date_: date_create,nid:product_id},
                    success: function (data) {
                        let lang = $('#lang').val();
                        $('.hide-block').hide();
                        var opt = '';
                        if(data.length) {
                            opt += '<option>Ընտրել</option>';
                            for (var i = 0; i<data.length; i++) {
                                if(data[i].namiclature_data.individual == 'true') {
                                    opt += '<option data-max="' + data[i].count + '" data-individual="' + data[i].namiclature_data.individual + '" value="' + data[i].id + '">' + data[i].namiclature_data['name_' + lang] + ' - ' + data[i].mac_address + ' (' + data[i].count + ' ' + data[i].namiclature_data.qty_type + ')</option>';
                                }
                            }
                        }
                       _this.closest('.product-block').find('.ns_products').html(opt);
                    }
                });
            } 
             _this.closest('.product-block').find('.nm_products').removeAttr('name')
            _this.closest('.product-block').find('select.ns_products').attr('name',"ComplectationProducts[product_id][]").show();
            _this.closest('.product-block').find('select.ns_products').attr('name',"ComplectationProducts[product_id][]").attr('required','required')
        } else {
            _this.attr('name',"ComplectationProducts[product_id][]");
            _this.closest('.product-block').find('.ns_products').removeAttr('name').hide();
            _this.closest('.product-block').find('.ns_products').removeAttr('required');
            var max = $(this).find(':selected').data('max');
            $(this).closest('.product-block').find('.field-shippingrequest-count input').val('').removeAttr('readonly').attr('max',max);
        }
        

    });
    $body.on('change', '.ns_products', function () {
        var product_id = $(this).val();
        var max = $(this).find(':selected').data('max');
        var individual = $(this).find(':selected').data('individual');
        
        if(individual){
            $(this).closest('.product-block').find('.field-complectationproducts-n_product_count input').val(1).attr('readonly','readonly');
            $(this).closest('.product-block').find('.field-complectationproducts-n_product_count input').attr('max',1);
        } else {
            $(this).closest('.product-block').find('.field-complectationproducts-n_product_count input').val('').removeAttr('readonly').attr('max',max);
        }
        var v = $(this).val();
    
        
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
    $body.on('change', '.counts-input input', function () {
        var rc = 0;
        if(parseInt($(this).val())> parseInt($(this).attr('max'))){
            $(this).closest('.counts-input').find('.help-block').text('Ապրանքների քանակը պահեստում '+$(this).attr('max')+' Է չեք կարող տեղափոխել ' +$(this).val());
            $(this).css('border','1px solid red');
            $('.check-counts').attr('disabled','disabled');
            rc++;
        } else {
            $(this).css('border','1px solid #ccc');
            $(this).closest('.counts-input').find('.help-block').text('');
        }
        if(rc==0){
            $('.counts-input input').css('border','1px solid #ccc');
            $('.check-counts').removeAttr('disabled');
        }
    });

    $body.on('change', '#shippingrequest-provider_warehouse_id', function () {
        var v = $(this).val();
        $("#shippingrequest-supplier_warehouse_id").find("option").removeAttr('disabled');
        $("#shippingrequest-supplier_warehouse_id").val(null).trigger('change');
        $("#shippingrequest-supplier_warehouse_id").find("option[value='"+v+"']").attr('disabled','disabled');
    });

    $body.on('click', '.btn-add-product', function () {

        $(this).closest('.module-service-form-card').find('select.nm_products').select2('destroy');
        let addressBlock = $(this).closest('.module-service-form-card');
        let rowCount = addressBlock.find('.row').length + 1;

        let firstRow = $('.product-block').first();
        let clone = firstRow.clone(true).removeClass('hide');
        let randomId = makeid(5);

        clone.find('select.nm_products').attr('id', function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        });
        clone.find('.ns_products').html('');
        clone.insertAfter(addressBlock.find('.row').last());

        let $nm_products = $('.module-service-form-card select.nm_products');
        console.log($nm_products);
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
                        if($('#shippingrequest-shipping_type').val() != 5){
                           $('#product-count').val(1).attr('disabled','disabled');
                         }
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

});
// $('.clone-product').off().on('click', function() {
//     alert('aaa')
//     var el_ = $(this).closest('.product-form').clone();
//     el_.find('input,select').val(null);
//     var ct = $('.product-form').length;
//     el_.find('.mac').attr('name','Product[mac_address]['+ct+'][]');
//     el_.find('.cloned').remove();
//     $('#product-add-block').append('<br/>');
//     $('#product-add-block').append(el_);
// });

window.onload = function(){

        $('body').on('click','.clone-mac',function (){
            var el_ = $(this).closest('.cloned-mac').clone();
            el_.addClass('cloned').css('padding-top','10px');
            el_.find('input,select').val(null);
            el_.find('.remove-mac').closest('.col-sm-1').removeClass('hide');
            el_.find('input,select').css('border','1px solid #C2CAD4');
            $(this).closest('.field-product-mac_address').append(el_);
        });
        $('body').on('change','.mac',function (){
            checkMac($(this));
         });
        $('#shippingrequest-supplier_warehouse_id').on('change', function(){
            if($(this).val() != '' &&  $('#shippingrequest-shipping_type').val() != 6) {
                $('.check-counts').removeAttr('disabled');
            }
        });
        $('#shippingrequest-shipping_type').on('change', function(){
            if($(this).val() == 7 && $('#shippingrequest-supplier_warehouse_id').val() =='') {
                $('.field-shippingrequest-request_id').hide();
                $('.field-shippingrequest-tp').closest('.col-sm-2').removeClass('hide');
                $('.check-counts').attr('disabled','disabled');
            } else if($(this).val() == 7 && $('#shippingrequest-supplier_warehouse_id').val() !='') {
                $('.field-shippingrequest-tp').closest('.col-sm-2').removeClass('hide');
                $('.field-shippingrequest-request_id').hide();
                $('.check-counts').removeAttr('disabled');
            } else {
                $('.field-shippingrequest-tp').closest('.col-sm-2').addClass('hide'); 
            }
            if($(this).val() == 9) {
                 $('.field-shippingrequest-request_id').hide();
                $('.price-input').closest('.col-sm-12').removeClass('hide');
            } else {
                $('.price-input').closest('.col-sm-12').addClass('hide');
            }

            if($(this).val() == 2 || $(this).val() == 6 || $(this).val() == 5){
            var tp = $(this).val();
               $.get( "/warehouse/shipping-request/create-product", function( data ) {
                   $( "#product-add-block" ).html( data );
                   
                   $('#deal-addresses').hide();
                   $('.hide-block').hide();
                   $('.for_bay').show();
                   if(tp == 5){
                     $('.field-product-mac_address').remove();
                   }
                    if(tp == 6){
                     $('.field-shippingrequest-request_id').show();
                   } else {
                      $('.field-shippingrequest-request_id').hide();
                   }
                   $('#product-add-block').show();
                   $('.provider_warehouse').hide();
                   $('.for_sale').hide();
                   $('.field-shippingrequest-supplier_warehouse_id').show();
               });
           } else if($(this).val() == 8 || $(this).val() == 9){
               $('.field-shippingrequest-request_id').hide();
               $('.field-shippingrequest-supplier_warehouse_id').hide();
               if($(this).val() == 9){
                   $('.for_sale').show();
               } else {
                   $('.for_sale').hide();
               }
           } else {
               $('.for_sale').hide();
               $('.field-shippingrequest-supplier_warehouse_id').show();
               $( "#product-add-block" ).hide();
               $('#deal-addresses').show();
               $('.hide-block').show();
               $('.for_bay').hide();
               $('.provider_warehouse').show();
           }
           if(($(this).val() == 2 || $(this).val() == 6 || $(this).val() == 5)){
              $('.check-counts').attr('disabled','disabled');
           } 
        });

        if ($('#shippingrequest-shipping_type').val() == 2 || $('#shippingrequest-shipping_type').val() == 6 || $('#shippingrequest-shipping_type').val() == 5) {
            var tp = $('#shippingrequest-shipping_type').val();
            $.get( "/warehouse/shipping-request/create-product", function( data ) {
                $( "#product-add-block" ).html( data );
                $('#deal-addresses').hide();
                $('.hide-block').hide();
                if(tp == 5){
                     $('.field-product-mac_address').remove();
                   }
                $('.for_sale').hide();
                $('.for_bay').show();
                $('#product-add-block').show();
                $('.provider_warehouse').hide();
                $('.field-shippingrequest-supplier_warehouse_id').show();
            });
        } else if ($('#shippingrequest-shipping_type').val() == 8 || $('#shippingrequest-shipping_type').val() == 9) {
            $('.field-shippingrequest-supplier_warehouse_id').hide();
            $('#shippingrequest-provider_warehouse_id').change();
            if($('#shippingrequest-shipping_type').val() == 9 ){
                $('.for_sale').show();
                $('.field-shippingrequest-supplier_warehouse_id').hide();
            } else {
                $('.for_sale').hide();
            }
        } else if ($('#shippingrequest-shipping_type').val() == 7) {
            $('.field-shippingrequest-supplier_warehouse_id').show();
            $("#product-add-block").hide();
            $('#deal-addresses').show();
            $('.hide-block').show();
            $('.for_bay').hide();
            $('.for_sale').hide();
            $('.provider_warehouse').show();
        }
        if($('#shippingrequest-shipping_type').val() == 9) {
            $('.price-input').closest('.col-sm-12').removeClass('hide');
        } else {
            $('.price-input').closest('.col-sm-12').addClass('hide');
        }
        
        $(window).keyup(
          function(event){
             if((event.keyCode == 13)){  
                        event.preventDefault();
                        return false;
                    
               }
              
        });
         $(window).keydown(
          function(event){
            
               if(( event.keyCode == 13 )){
                        event.preventDefault();
                        return false;
                    
               }
          
        });
          // $(document).on('click', 'input[type="checkbox"]', function () {
          //       $('input[type="checkbox"]').not(this).prop('checked', false);
          //   });

        $('.warehouse_type').change(function () {
             var vl = $(this).val();
             if(vl == 2){
                 $('.region').hide();
                 $('.subgroup').show();
                 $('.community').hide();
             } else {
                 $('.subgroup').hide();
                 $('.region').show();
             }
        });
        $('.region_').change(function(){
                var reg_ = $(this).val();
                $('.community').show();
                $.ajax({
                    url: '/warehouse/warehouse/get-community',
                    method: 'get',
                    dataType: 'html',
                    data: { region_id: reg_},
                    success: function (data) {
                        $('.community_select').html(data);
                    }
                });
            });
            $('.community_select').change(function(){
                var community_ = $(this).val();
                var type_ = $('.warehouse_type').val();
                $('.ware').show();
                $.ajax({
                    url: '/warehouse/warehouse/get-warehouses',
                    method: 'get',
                    dataType: 'html',
                    data: { community: community_},
                    success: function (data) {
                        $('.ware_select').html(data);
                    }
                });
            });
            $('.virtual_type').change(function(){
                var virtual_type_ = $(this).val();
                var type_ = $('.warehouse_type').val();
                $('.ware').show();
                $.ajax({
                    url: '/warehouse/warehouse/get-warehouses-by-type',
                    method: 'get',
                    dataType: 'html',
                    data: { virtual_type: virtual_type_},
                    success: function (data) {
                        $('.ware_select').html(data);
                    }
                });
            });
            $('#report_form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'get',
                    url: '/warehouse/reports/generate',
                    data: $('form').serialize(),
                    success: function (data) {
                        $('#result_block').html(data);
                    }
                });
            });
             $('#search_button').on('click', function (e) {
                e.preventDefault();
                var q = $('#search_input').val();

                $.ajax({
                    type: 'get',
                    url: '/warehouse/warehouse/get-deals',
                    data: {q:q},
                    success: function (data) {
                        $('#search_results').html(data);
                    }
                });
            });
            $(document).on('click','.file-tree [type="checkbox"]', function(){
          
                $('.file-tree input:checkbox').removeAttr('checked');
                if ($(this).is(':checked')) {
               
                    if($('#shippingrequest-supplier_warehouse_id').val()){
                       $('[type="submit"]').removeAttr('disabled');
                    } else {
                        $('[type="submit"]').attr('disabled','disabled');
                    }
                } else {
                     $('[type="submit"]').attr('disabled','disabled');
                }
            });
        $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });

    }
