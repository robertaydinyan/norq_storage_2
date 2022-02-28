$(document).ready(function () {

    let $body = $('body');

    $body.on('change', '#countries', function () {
        let country_id = $(this).val();
        let url = $(this).attr('data-url');

        let $select = $('#regions');
        $select.find('option').remove().end();

        let $el = $('#regions'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: country_id},
            dataType: 'json',
            success: function (response) {
                console.log(response);
                let select2Options = settings;
                select2Options.data = response;
                select2Options.disabled = false;
                $select.select2(select2Options).trigger('change');

                console.log(response);
            }
        });
    });

    $body.on('change', '#regions', function () {
        let region_id = $(this).val();
        let url = $(this).attr('data-url');

        let $select = $('#city');
        $select.find('option').remove().end();

        let $el = $('#city'),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        $.ajax({
            url: url,
            type: 'POST',
            data: {id: region_id},
            dataType: 'json',
            success: function (response) {
                console.log(response);
                let select2Options = settings;
                select2Options.data = response;
                select2Options.disabled = false;
                $select.select2(select2Options).trigger('change');

                console.log(response);
            }
        });
    });

});
function loadChart(type,data){
    var ctx = document.getElementById('statisticChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: type,

        // The data for our dataset
        data: {
            labels: ['Январь','февраль','март','апрель','май','июнь','июль'],
            datasets: [{
                label: 'Статистика (2020)',
                backgroundColor: 'rgb(37, 175, 54)',
                borderColor: 'rgb(37, 175, 54)',
                data: data
            }]
        },

        // Configuration options go here
        options: {}
    });
    var ctxPie = document.getElementById('statisticChartPie').getContext('2d');
    var chartPie = new Chart(ctxPie, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: ['Январь','февраль','март','апрель'],
            datasets: [{
                label: 'Статистика (2020)',
                backgroundColor: [
                    "#f38b4a",
                    "#56d798",
                    "#ff8397",
                    "#6970D5"
                ],
                borderColor:  [
                    "#f38b4a",
                    "#56d798",
                    "#ff8397",
                    "#6970D5"
                ],
                data: data
            }]
        },

        // Configuration options go here
        options: {}
    });

}
