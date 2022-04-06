// Init kartik select2
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }

$(function () {
   $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function(){

   let $body = $('body');

   /**
    * Open create/update form modal
    */
   $body.on('click', '.open_docs_form', function(e){
      e.preventDefault();
      let url;
      let id = $(this).attr('data-id');
      let document_type_id = $(this).attr('data-type-id');
      let form_name = $(this).attr('data-form');

      if (id) {
         url = $(this).attr('data-url');
      } else {
         url = $(this).closest('.search-bar-actions').attr('data-url');
      }

      openModal(id, url, document_type_id, form_name);
   });

   $body.on('change', '#deal-is_daily', function () {
      if ($(this).is(':checked')) {
         $('.is-not-daily').hide();
         $('.is-daily').show();
      } else {
         $('.is-not-daily').show();
         $('.is-daily').hide();
      }
   });

   $body.on('change', '#tarif_id', function(e){
      let tarifs = [];
      $(this).find("option").each(
          function () {
              if($(this).is(':selected')){
                 tarifs.push($(this).val());
              }
          }
      );
      var tarif_data;
      if(tarifs.length > 0){

         let $select = $('#service_id_product');
         $select.find('option').remove().end();

         $.ajax({
            url: '/billing/tariff/get-tariffs-by-ids',
            method: 'post',
            data: {ids: tarifs},
            dataType: 'json',
            success: function(res){
               $('.tariffs').html('');
               let increment = 1;
               for (var i in res){
                  var clone = $('.tariff-blok').clone(true).show();
                  clone.removeClass('tariff-blok');
                  clone.find('.tariff-actual_price').val(res[i].actual_price);

                  clone.find('.title').text(res[i].name);
                  clone.find('input[type=radio]').attr('name','Tariff[actual_price_type]['+i+']');
                  clone.append('<input type="hidden" name="Tariff[tariff_id][]" value="'+res[i].id+'">');
                  if(res[i].actual_type == 1){
                     clone.find('.type_1').attr('checked','checked');
                  } else {
                     clone.find('.type_2').attr('checked','checked');
                  }

                  $('.tariffs').append(clone);

                  clone.find('select').attr('id', function () {
                     $(this).val(null).trigger('change');
                     return $(this).attr('id') + '_' + (increment++);
                  });

                  let $el = $('#service_id_product'),
                      settings = $el.attr('data-krajee-select2'),
                      id = $el.attr('id');
                  settings = window[settings];

                  $el.select2(settings).trigger('change');
               }
            }
         });
      }
   });
   /**
    * Open data view modal
    */
   $body.on('click', '.open_docs_view', function (e) {
      e.preventDefault();
      let url;
      let id = $(this).attr('data-id');

      if (id) {
         url = $(this).attr('data-url');
      } else {
         url = $(this).closest('.search-bar-actions').attr('data-url');
      }

      openViewModal(id, url);
   });
   $body.on('click', '.open_second_modal', function (e) {
      e.preventDefault();
      let url;
      let id = $(this).attr('data-id');

      if (id) {
         url = $(this).attr('data-url');
      } else {
         url = $(this).closest('.search-bar-actions').attr('data-url');
      }

      openViewModalSecond(id, url);
   });

   $body.on('change', '.tariff_total_price', function(){

      let tariffTvPrice = $('#tariff-tv_id').val() ?  ($('#tariff-tv_id option:selected').text().split('/')[1]) * 1 : 0;
      let tariffIpCount = (typeof  ($('#tariff-ip_count').val()*1)) == 'number'  ? $('#tariff-ip_count').val()* 1000 : 0;
      let tariffInetPrice = $('#tariff-inet_price').val();
      tariffInetPrice = +tariffInetPrice ? tariffInetPrice : 0;
      $('.tariff_total').html(parseInt(tariffTvPrice)+parseInt(tariffIpCount)+parseInt(tariffInetPrice));
   });

   $body.on('change', '#deal-crm_contact_id', function () {
      let addresses = $('#deal-addresses');
      let customer_addresses = $('#deal-customer-addresses');

      if ($(this).val()) {
         if ($('#is_new_client').is(':checked')) {
            addresses.show();
         } else {
            customer_addresses.show();
         }
      } else {
         addresses.hide();
         customer_addresses.hide();
      }
   });

   $body.on('change', '#deal-crm_company_id', function () {
      let addresses = $('#deal-addresses');
      let customer_addresses = $('#deal-customer-addresses');

      if ($(this).val()) {
         if ($('#is_new_client').is(':checked')) {
            addresses.show();
         } else {
            customer_addresses.show();
         }
      } else {
         addresses.hide();
         customer_addresses.hide();
      }
   });

   // Get addresses list by selected customer contact|company
   $body.on('change', '#deal-crm_contact_id, #deal-crm_company_id', function (event, wasTriggered) {
      let addresses = $('#deal-addresses');
      let customer_addresses = $('#deal-customer-addresses');
      let url = $('#address_id').attr('data-url');
      let customer_id = $(this).val();
      var customer_type = 0;

      if ($(this).attr('id') == 'deal-crm_contact_id') {
         customer_type = 1;
      }

      if ($(this).attr('id') == 'deal-crm_company_id') {
         customer_type = 2
      }

      if (customer_type !== 0) {

         if (wasTriggered) {
         } else {
            let $select = $('#address_id');
            $select.find('option').remove().end();

            let $el = $('#address_id'),
                settings = $el.attr('data-krajee-select2'),
                id = $el.attr('id');
            settings = window[settings];

            $.ajax({
               url: url,
               method: 'POST',
               data: {customer: customer_id, customer_type: customer_type},
               dataType: 'json',
               success: function (response) {

                  if (response.length) {
                     let select2Options = settings;
                     select2Options.data = response;
                     $select.select2(select2Options).trigger('refresh');

                     addresses.hide();
                     customer_addresses.show();
                  } else {
                     addresses.show();
                     customer_addresses.hide();
                  }
               }
            });
         }
      }

   });

   $body.on('change', '#deal-user_type', function(){
      let contact = $('#deal-crm_contact_id');
      let company = $('#deal-crm_company_id');
      let contactField = $('#crm-contact_for_deal');
      let companyField = $('#crm-company_for_deal');
      let addresses = $('#deal-addresses');

      if ($(this).val() == 1) {

         contact.attr('disabled', true).val('').trigger('change', true);
         company.attr('disabled', false);
         $('.show_dis_price_deal').css("display", "block");

         if ($('#is_new_client').is(':checked')) {
            companyField.css('display','block');
            addresses.css('display','block');
         } else {
            companyField.hide();
            addresses.hide();
         }
         contactField.hide();
      } else {
         company.attr('disabled', true).val('').trigger('change', true);
         contact.attr('disabled', false);
         $('.show_dis_price_deal').css("display", "none");
         if ($('#is_new_client').is(':checked')) {
            contactField.css('display','block')
            addresses.css('display','block');
         } else {
            contactField.hide();
            addresses.hide();
         }
      }
   });

   $body.on('change', '#is_new_client', function(){
      let contactField = $('#crm-contact_for_deal');
      let companyField = $('#crm-company_for_deal');
      let addresses = $('#deal-addresses');
      let productsModule = $('#products-module');

      if ($(this).is(':checked')) {
         $('#deal-crm_contact_id').attr('disabled', true).val('').trigger('change', true);
         $('#deal-crm_company_id').attr('disabled', true).val('').trigger('change', true);
      } else {

         if ($('#deal-user_type').val() == 0) {
            $('#deal-crm_contact_id').attr('disabled', false).val('').trigger('change', true);
         } else {
            $('#deal-crm_company_id').attr('disabled', false).val('').trigger('change', true);
         }
      }

      if($('#deal-user_type').val() != '' && $('#deal-crm_contact_id').val() == '' && $('#deal-crm_company_id').val() == ''){
         if ($(this).is(':checked')) {
            if ($('#deal-user_type').val() == 0) {
               contactField.css('display','block');
               companyField.hide();
            } else {
               contactField.hide();
               companyField.css('display','block');
            }

            addresses.show();
            productsModule.show();
         }else{
            contactField.hide();
            companyField.hide();
            addresses.hide();
            productsModule.hide();
         }
      }

   });

   $body.on('change', '#deal-is_wifi', function(){
      let wifiCode = $('.field-deal-wifi_code');
      $(this).is(':checked') ? wifiCode.show() :  wifiCode.hide();
   });

   $body.on('change', '#deal-base_station_id', function(){
      getIPList(this);
   });

   $body.on('change', '#deal-service_type', function(){
      getPacket(this);
   });

   $body.on('change', '#deal-connect_id', function(){
      let self = $(this);
      let url = self.attr('data-url');

      $.ajax({
         url: url,
         method: 'post',
         data: {connect_id: self.val()},
         dataType: 'json',
         success: function(response){
           $('#deal-amount').val(response);
         }
      });
   });

   // Fastnet module | Deal | Dynamically add IP fields
   $body.on('click', '.js--add-ip-field', function () {
      let _this = $(this);
      let container = $('.js--add-multiple-ip');
      let cloneField = _this.closest(container).find('.form-group.col-md-4:first');
      let cloneFieldCopy = _this.closest(container).find('.form-group.col-md-4:last');
      let rowCount = _this.closest(container).find('.form-group.col-md-4').length;

      clone = cloneField.clone(true);
      clone.find('.input-group-prepend.d-none').removeClass('d-none');

      clone.find('#deal-ip_status').attr('id', function () {
         return $(this).attr('id') + '_' + (rowCount);
      });

      clone.find('.deal-ip_status').attr('for', function () {
         return $(this).attr('for') + '_' + (rowCount);
      });

      clone.find('#deal-ip_status-0').attr('id', function () {
         return $(this).attr('id') + '_' + (rowCount);
      });

      clone.insertAfter(cloneFieldCopy);

      clone.find('input:text').val('');
      clone.find('input:checkbox').val(rowCount);
      clone.find('input:checkbox').prop('checked', false);
   });

   $body.on('click', '.js--add-phone-field', function () {

      let _this = $(this);

      let cloneField = $('.field-contact-phone:first');
      let cloneFieldCopy = $('.field-contact-phone:last');
      let rowCount = $('.field-contact-phone').length;

      clone = cloneField.clone(true);
      clone.find('.input-group-prepend.d-none').removeClass('d-none');

      clone.find('#contact-phone').attr('id', function () {
         return $(this).attr('id') + '_' + (rowCount);
      });
      clone.find('.control-label').attr('for', function () {
         return $(this).attr('for') + '_' + (rowCount);
      });

      clone.insertAfter(cloneFieldCopy);

      clone.find('input:text').val('');
   });

   // Fastnet module | Deal | Dynamically remove IP fields
   $body.on('click', '.js--remove-phone-field', function () {
      let _this = $(this);
      _this.closest('.field-contact-phone').remove();
   });

   $body.on('click', '.js--add-phone-company-field', function () {

      let _this = $(this);

      let cloneField = $('.field-company-phone:first');
      let cloneFieldCopy = $('.field-company-phone:last');
      let rowCount = $('.field-company-phone').length;

      clone = cloneField.clone(true);
      clone.find('.input-group-prepend.d-none').removeClass('d-none');

      clone.find('#company-phone').attr('id', function () {
         return $(this).attr('id') + '_' + (rowCount);
      });
      clone.find('.control-label').attr('for', function () {
         return $(this).attr('for') + '_' + (rowCount);
      });

      clone.insertAfter(cloneFieldCopy);

      clone.find('input:text').val('');
   });

   // Fastnet module | Deal | Dynamically remove IP fields
   $body.on('click', '.js--remove-phone-company-field', function () {
      let _this = $(this);
      _this.closest('.field-company-phone').remove();
   });

   $body.on('change', '#filter-payment-log-kvdate input', function() {
      let dateRangeStart = $('#filter-payment-log').val();
      let dateRangeEnd = $(this).closest('#filter-payment-log-kvdate').find('[id^=w]').val();
      let dealNumber = $('#deal_number').val();

      $.ajax({
         url: '/fastnet/deal/history',
         method: 'post',
         data: {start_date: dateRangeStart, end_date: dateRangeEnd, deal_number: dealNumber},
         dataType: 'html',
         success: function(response) {
            $('.history_log').html(response);
         }
      });
   });

});

function openModal(id, url, document_type_id, form_name) {

   $.ajax({
      url: url,
      method: 'post',
      data: {document_type_id: document_type_id, form_name: form_name, id: id},
      dataType: 'json',
      success: function(res){

         $('#myModalLabel2').text(res.docName);
         if(res.html){
            $('.form-content').html(res.html);
         }
         $('#sidebarModal').modal('show');
      }
   });
}

function openViewModal(id, url) {
   $.ajax({
      url: url,
      method: 'post',
      data: {id: id},
      dataType: 'html',
      success: function(res){
         if(res){
            $('#myModalLabel2').text('Просмотр документа');
            $('.form-content').html(res);
         }
         $('#sidebarModal').modal('show');
      }
   });
}

function openViewModalSecond(id, url) {
   $.ajax({
      url: url,
      method: 'get',
      data: {id: id},
      dataType: 'html',
      success: function(res){
         if(res){
            $('#myModalLabel2').text('Просмотр документа');
            $('#modalContent').html(res);
         }
         $('#sidebarModal').modal('show');
      }
   });
}

$('.nav .aside-toggle').click(toggleAside);

let isAsideOpen = true;

function toggleAside() {
   if (isAsideOpen) {
      $(this).css({'right': '15px'});
      $('.aside-box').css({'min-width': '55px', 'transition': '.5s'});
      $('.aside-box aside').css({'min-width': '55px', 'transition': '.5s'});

      isAsideOpen = false;
      setTimeout(() => {
         $('.aside-box .aside-toggle').css('right', '8px');
         $('.aside-box .nav .aside-admin-name span').hide();
         $('.aside-box .nav .nav-link span.sidebar-link').hide();
         $('aside .nav .nav-link svg').css({'margin-right': '0'});
      }, 200);
   } else {
      $(this).css({'right': '4px'});
      $('.aside-box').css({'min-width': '250px', 'transition': '.5s'});
      $('.aside-box aside').css({'min-width': '250px', 'transition': '.5s'});
      isAsideOpen = true;
      setTimeout(() => {
         $('.aside-box .aside-toggle').css('right', '15px');
         $('.aside-box .nav .aside-admin-name span').show();
         $('.aside-box .nav .nav-link span.sidebar-link').show();
         $('aside .nav .nav-link svg').css({'margin-right': '15px'});
      }, 100);
   }
}

function getIPList(element, selected = null) {
   let deal_number = $(element).attr('data-model-id');
   let base_id = $(element).val();
   let url = $(element).attr('data-url');
   let $select = $('[id="deal-base_station_ip"]');
   $select.find('option').remove().end();

   let $el = $('[id="deal-base_station_ip"]'),
       settings = $el.attr('data-krajee-select2')
   id = $el.attr('id');
   settings = window[settings];

   if(base_id) {
      $.ajax({
         url: url,
         method: 'post',
         data: {id: deal_number, base_id: base_id},
         dataType: 'json',
         success: function (response) {
            let select2Options = settings;
            select2Options.data = response;
            $select.select2(select2Options).trigger('change');

            if (selected !== null) {
               $select.val(selected).trigger('change');
            }
         }
      });
   }
}

function getPacket(element, selected = null) {
   let self = $(element);
   let url = self.attr('data-url');
   let $select = $('[id="deal-connect_id"]');
   $select.find('option').remove().end();
   let $el = $('[id="deal-connect_id"]'),
       settings = $el.attr('data-krajee-select2')
   id = $el.attr('id');
   settings = window[settings];
   $.ajax({
      url: url,
      method: 'post',
      data: {type: self.val()},
      dataType: 'json',
      success: function(response){
         let select2Options = settings;
         select2Options.data = response;
         $select.select2(select2Options).trigger('change');

         if (selected !== null) {
            $select.val(selected).trigger('change');
         }
      }
   });
}