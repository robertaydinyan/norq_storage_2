let $body = $('body');

function getRegions(element, selected = [], zoneId = null) {
    let region_id = $(element).val();
    let url = $(element).attr('data-url');

    $('#zone_regions').trigger('change');

    let $select = $('#zone_city');
    $select.find('option').remove().end();

    let $el = $('#zone_city'),
        settings = $el.attr('data-krajee-select2'),
        id = $el.attr('id');
    settings = window[settings];

    if (region_id) {
        $.ajax({
            url: url,
            type: 'POST',
            data: {id: region_id, zoneId: zoneId},
            dataType: 'json',
            success: function (response) {
                let select2Options = settings;
                select2Options.data = response.optionsList;
                select2Options.disabled = false;
                $select.select2(select2Options).trigger('refresh');

                let selected = response.selected;
                if (!$.isEmptyObject(selected)) {
                    $select.val(Object.keys(selected)).trigger('refresh');
                }
            }
        });
    }
}

function getCommunityAndStreets(element, selected = [], zoneId = null) {
    let city_id = $(element).val();
    let url = $(element).attr('data-url');
    let model = $('#zone-id').val();


    let $select = $('#zone_communities');
    $select.find('option').remove().end();

    let $selectStreet = $('#zone_streets');
    $selectStreet.find('option').remove().end();

    let $el = $('#zone_communities'),
        settings = $el.attr('data-krajee-select2'),
        id = $el.attr('id');
    settings = window[settings];

    let $elStreet = $('#zone_streets'),
        settingsStreet = $elStreet.attr('data-krajee-select2'),
        idStreet = $elStreet.attr('id');
    settingsStreet = window[settingsStreet];

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: city_id, zoneId: zoneId},
        dataType: 'json',
        success: function (response) {
            let select2Options = settings;
            select2Options.data = response.communityOptionsList;
            select2Options.disabled = false;
            $select.select2(select2Options);

            if (model) {
                $select.trigger('refresh');
            }

            let selected = response.selected;
            if (!$.isEmptyObject(selected)) {
                $select.val(Object.keys(selected)).trigger('refresh');
            }

            let select2OptionsStreet = settingsStreet;
            select2OptionsStreet.data = response.streetOptionsList;
            select2OptionsStreet.disabled = false;
            $selectStreet.select2(select2OptionsStreet);

            if (model) {
                $selectStreet.trigger('refresh');
            }

            let selectedStreet = response.selectedStreet;
            if (!$.isEmptyObject(selectedStreet)) {
                $selectStreet.val(Object.keys(selectedStreet)).trigger('refresh');
            }
        }
    });
}

$body.on('change', '#zone_regions', function (e) {

    let region_id = $(this).val();
    let url = $(this).attr('data-url');
    let zoneId = $(this).attr('data-id');

    let $select = $('#zone_city');
    $select.find('option').remove().end();

    let $el = $('#zone_city'),
        settings = $el.attr('data-krajee-select2'),
        id = $el.attr('id');
    settings = window[settings];

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: region_id, zoneId: zoneId},
        dataType: 'json',
        success: function (response) {
            let select2Options = settings;
            select2Options.data = response.optionsList;
            select2Options.disabled = false;
            $select.html("");
            $select.select2(select2Options).trigger('refresh');
            let selected = response.selected
            if (!$.isEmptyObject(selected)) {
                $select.val(Object.keys(selected)).trigger('refresh');
            }
        }
    });
});

$body.on('change', '#zone_city', function (e) {
    let city_id = $(this).val();
    let url = $(this).attr('data-url');
    let zoneId = $(this).attr('data-id');
    let model = $('#zone-id').val();


    let $select = $('#zone_communities');
    $select.find('option').remove().end();

    let $selectStreet = $('#zone_streets');
    $selectStreet.find('option').remove().end();

    let $el = $('#zone_communities'),
        settings = $el.attr('data-krajee-select2'),
        id = $el.attr('id');
    settings = window[settings];

    let $elStreet = $('#zone_streets'),
        settingsStreet = $elStreet.attr('data-krajee-select2'),
        idStreet = $elStreet.attr('id');
    settingsStreet = window[settingsStreet];

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: city_id, zoneId: zoneId},
        dataType: 'json',
        success: function (response) {
            let select2Options = settings;
            select2Options.data = response.communityOptionsList;
            select2Options.disabled = false;
            $select.html("");
            $select.select2(select2Options);

            if (model) {
                $select.trigger('change');
            }

            let selected = response.selected;
            if (!$.isEmptyObject(selected)) {
                $select.val(Object.keys(selected)).trigger('change');
            }

            let select2OptionsStreet = settingsStreet;
            select2OptionsStreet.data = response.streetOptionsList;
            select2OptionsStreet.disabled = false;
            $selectStreet.html("");
            $selectStreet.select2(select2OptionsStreet);

            if (model) {
                $selectStreet.trigger('change');
            }

            let selectedStreet = response.selectedStreet;
            if (!$.isEmptyObject(selectedStreet)) {
                $selectStreet.val(Object.keys(selectedStreet)).trigger('change');
            }
        }
    });
});

$body.on('change', '#zone_communities', function () {
    let region_id = $(this).val();
    let url = $(this).attr('data-url');

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: region_id},
        dataType: 'json',
        success: function (response) {
            $('#dela_list').html(response);
        }
    });
});