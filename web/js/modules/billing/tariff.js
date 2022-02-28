$(document).ready(function () {

    let $body = $('body');
    let $csrfToken = $('meta[name="csrf-token"]').attr("content");

    // List view
    $body.on('click', '.switch-view', function () {

        let _this = $(this);
        let viewType = _this.data('view');
        let url = _this.closest('.search-bar-setting-actions').data('url');
        let action = _this.closest('.search-bar-setting-actions').data('action');
        let $loader = $('.b-loader');
        $loader.show();

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _csrf: $csrfToken,
                viewType: viewType,
                action: action
            },
            // dataType: 'html',
            success: function (render) {

                $loader.show();

                setTimeout(function () {
                    $loader.hide();
                    $('.render-view-partial').html(render);

                    $('.switch-view .b-icon').removeClass('active');
                    _this.find('.b-icon').addClass('active');
                }, 700);
            }
        });

    });

    // Choose tariff type and set default price for selected tariff
    $body.on('change', '.choose-tariff-type', function () {

        let tariffType = $(this).attr('data-tariff-type-id');
        let url = $(this).closest('.fieldset-checkbox-group').find('.form-row').attr('data-service-url');

        // Toggle selected tariff
        let tariffBlocks = $('.module-modal-form-section').find(`[data-tariff-type="${tariffType}"]`);
        tariffBlocks.toggleClass('d-block');

        // Send ajax request for only selected tariff
        let form = $('#tariff-form').serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                $('.selected-services-price').text(response.actualPrice);
                $('.actual-price').text(response.totalTariffPrice);
                $('#tariff-hiddenactualprice').val(removeSpaceFromString(response.actualPrice));
            }
        });
    });

    // Change internet tariff
    $body.on('change', '#tariff-internet_id', function () {
        let url = $(this).closest('form').find('.form-row').attr('data-service-url');

        // Send ajax request for only selected tariff
        let form = $('#tariff-form').serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                $('.selected-services-price').text(response.actualPrice);
                $('.actual-price').text(response.totalTariffPrice);
                $('#tariff-hiddenactualprice').val(removeSpaceFromString(response.actualPrice));
            }
        });
    });

    // Change tv tariff
    $body.on('change', '#tariff-tv_packet_id', function () {
        let url = $(this).closest('form').find('.form-row').attr('data-service-url');

        // Send ajax request for only selected tariff
        let form = $('#tariff-form').serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                $('.selected-services-price').text(response.actualPrice);
                $('.actual-price').text(response.totalTariffPrice);
                $('#tariff-hiddenactualprice').val(removeSpaceFromString(response.actualPrice));
            }
        });
    });

    // Change ip tariff
    $body.on('keyup', '#tariff-ip_count', function () {
        let url = $(this).closest('form').find('.form-row').attr('data-service-url');

        // Send ajax request for only selected tariff
        let form = $('#tariff-form').serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                $('.selected-services-price').text(response.actualPrice);
                $('.actual-price').text(response.totalTariffPrice);
                $('#tariff-hiddenactualprice').val(removeSpaceFromString(response.actualPrice));
            }
        });
    });

    // Choose internet type
    $body.on('change', '[name="Tariff[internet_type]"]', function () {
        let url = $(this).closest('form').find('.form-row').attr('data-service-url');
        let form = $('#tariff-form').serialize();

        let $select = $('[id="tariff-internet_id"]');
        $select.find('option').remove().end();

        let $el = $('[id="tariff-internet_id"]'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                let select2Options = settings;
                select2Options.data = response.internet;
                $select.select2(select2Options).trigger('change');

                $('.selected-services-price').text(response.actualPrice);
                $('.actual-price').text(response.totalTariffPrice);
                $('#tariff-hiddenactualprice').val(removeSpaceFromString(response.actualPrice));
            }
        });
    });

    // Switch % / Dram
    $body.on('change', '.choose-price-unit-type', function () {
        let selectedValue = $(this).closest('.c-radio').find('label').text();
        let input = document.getElementById('tariff-actual_price');
        betweenNumbersLimit(input);
        let url = $(this).closest('form').find('.form-row').attr('data-service-url');
        let form = $('#tariff-form').serialize();

        $('.selected-services-price-unit').text(selectedValue);

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                $('.actual-price').text(response.totalTariffPrice);
            }
        });
    });

    $body.on('keyup', '#tariff-actual_price', function () {
        let form = $('#tariff-form').serialize();
        let input = document.getElementById('tariff-actual_price');
        let unit = $('.choose-price-unit-type:checked').val();
        let url = $(this).closest('form').find('.form-row').attr('data-service-url');

        // Allow digits and '.' only, using a RegExp
        setInputFilter(input, function(value) {
            return /^\d*\.?\d*$/.test(value);
        });

        // Limit number between 0 - 100
        if (unit == 1) {
            betweenNumbersLimit(input);
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: form,
            dataType: 'json',
            success: function (response) {
                $('.actual-price').text(response.totalTariffPrice);
            }
        });
    });

    /**
     * Remove spaces from string
     *
     * @param string
     * @returns {*}
     */
    function removeSpaceFromString(string) {
        return string.replace(/\s/g, '');
    }

    /**
     * Limit number between 0 - 100
     *
     * @param input
     */
    function betweenNumbersLimit(input) {
        let n = input.value;
        n = Number(n);
        if (n < 0) {
            //$('#GFG_DOWN').html('Type number between 0-100');
            input.value = 0;
        } else if (n > 100) {
            //$('#GFG_DOWN').html('Type number between 0-100');
            input.value = 100;
        } else {
            //$('#GFG_DOWN').html('You typed the valid Number.');
            input.value = n;
        }
    }

    /**
     * Filter input
     *
     * @param textbox
     * @param inputFilter
     */
    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

});