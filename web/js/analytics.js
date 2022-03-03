$(document).ready(function () {

    let $body = $('body');

    loadConnections();

    $body.on('change', '.connection_month', function () {
        loadConnections($(this).val())
    });

});

function loadConnections(monthFilter = null) {
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    // let monthFilter = $('.connection_month').val();

    if(window.bar != undefined) {
        window.bar.destroy();
    }

    let chart    = document.getElementById('chart').getContext('2d'),
        gradient = chart.createLinearGradient(0, 0, 0, 450);
        url = $('.line-chart').attr('data-connections-url');

    gradient.addColorStop(0, 'rgba(37, 175, 54, 0.32)');
    gradient.addColorStop(0.3, 'rgba(37, 175, 54, 0.1)');
    gradient.addColorStop(1, 'rgba(37, 175, 54, 0)');

    window.bar = new Chart(chart, {
        type: 'bar',
        data: {},
        options: {},
    });

    $.ajax({
        url : url,
        type : "POST",
        data : {
            _csrf: csrfToken,
            month: monthFilter
        },
        dataType: 'json',
        success : function(response) {
            console.log(response);

            window.bar.data = {
                labels: response.labels,
                datasets: [{
                    label: 'Միացումների քանակ',
                    backgroundColor: gradient,
                    pointBackgroundColor: '#007bff',
                    borderWidth: 1,
                    borderColor: '#007bff',
                    data: response.data
                }]
            };

            window.bar.options = {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                    easing: 'easeInOutQuad',
                    duration: 520
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: '#007bff'
                        },
                        gridLines: {
                            color: 'rgba(200, 200, 200, 0.08)',
                            lineWidth: 1
                        }
                    }],
                    xAxes:[{
                        ticks: {
                            fontColor: '#007bff'
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.4
                    }
                },
                legend: {
                    display: false
                },
                point: {
                    backgroundColor: '#007bff'
                },
                tooltips: {
                    titleFontFamily: 'Poppins',
                    backgroundColor: 'rgba(0,0,0,0.4)',
                    titleFontColor: 'white',
                    caretSize: 5,
                    cornerRadius: 2,
                    xPadding: 10,
                    yPadding: 10
                }
            };

            window.bar.update();
        }
    });
}