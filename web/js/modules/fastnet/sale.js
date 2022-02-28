let $body = $('body');

$body.on('change', 'input[name=deal_sale]', function () {
    let this_ = $(this);

    if (this_.val() == 0) {
        $('.deal-sale-filter').show();
        $('.base-station-filter').hide();
    } else {
        $('.deal-sale-filter').hide();
        $('.base-station-filter').show();
    }
});

$body.on('change', '#base_station', function () {
    let station_id = $(this).val();
    let url = $(this).attr('data-url');

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: station_id, baseStation: true},
        dataType: 'json',
        success: function (response) {
            $('#base_station_clients_list').html(response);
        }
    });
});

/***** Sale *****/
function getRegions(element, selected = [], zoneId = null) {
    let region_id = $(element).val();
    let url = $(element).attr('data-url');

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
                $select.select2(select2Options).trigger('change');

                if (!$.isEmptyObject(selected)) {
                    $select.val(Object.keys(selected)).trigger('change');
                }
            }
        });
    }
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
    let zoneId = '';

    let $select = $('#zone_communities');
    $select.find('option').remove().end();

    let $el = $('#zone_communities'),
        settings = $el.attr('data-krajee-select2'),
        id = $el.attr('id');
    settings = window[settings];

    $.ajax({
        url: url,
        type: 'POST',
        data: {id: city_id, zoneId: zoneId},
        dataType: 'json',
        success: function (response) {
            let select2Options = settings;
            select2Options.data = response.communities;
            select2Options.disabled = false;
            $select.select2(select2Options).trigger('refresh');

            let selected = response.selected
            if (!$.isEmptyObject(selected)) {
                $select.val(Object.keys(selected)).trigger('refresh');
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

function toggleAvailableSales(source) {
    let checkboxes = document.getElementsByName('Sale[]');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
}
