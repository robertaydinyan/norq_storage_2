$(document).ready(function () {

    let $body = $('body');

    $body.on('change', '.country-select', function () {
        let country_id = $(this).val();
        let url = $(this).attr('data-url');

        let $select = $(this).closest('.row').find('.region-select');
        $select.find('option').remove().end();

        let $el = $('.region-select'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: country_id},
            dataType: 'json',
            success: function (response) {
                let select2Options = settings;
                select2Options.data = response;
                select2Options.disabled = false;
                $select.select2(select2Options).trigger('change');
            }
        });
    });

    $body.on('change', '.region-select', function () {
        let region_id = $(this).val();
        let url = $(this).attr('data-url');

        let $select = $(this).closest('.row').find('.city-select');
        $select.find('option').remove().end();

        let $el = $('.city-select'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: region_id},
            dataType: 'json',
            success: function (response) {
                let select2Options = settings;
                select2Options.data = response;
                select2Options.disabled = false;
                $select.select2(select2Options);
            }
        });

    });

    $body.on('change', '.city-select', function () {
        let city_id = $(this).val();
        let url = $(this).attr('data-url');

        let $selectCommunity = $(this).closest('.row').find('.community-select');
        $selectCommunity.find('option').remove().end();

        let $elCommunity = $('.community-select'),
            settingsCom = $elCommunity.attr('data-krajee-select2'),
            idC = $elCommunity.attr('id');
        settingsCom = window[settingsCom];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: city_id},
            dataType: 'json',
            success: function (response) {
                $('.field-community_id').show();

                let select2OptionsCom = settingsCom;
                select2OptionsCom.data = response.communities;
                select2OptionsCom.disabled = false;
                $selectCommunity.select2(select2OptionsCom);
            }
        });
    });

    $body.on('change', '.community-select', function () {
        let community_id = $(this).val();
        let url = $(this).attr('data-url');

        let $select = $(this).closest('.row').find('.street-select');
        $select.find('option').remove().end();
        let $el = $('.street-select'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: community_id},
            dataType: 'json',
            success: function (response) {
                let select2Options = settings;
                select2Options.data = response.streets;
                select2Options.disabled = false;
                select2Options.tags = true;
                $select.select2(select2Options);
            }
        });
    });
});
