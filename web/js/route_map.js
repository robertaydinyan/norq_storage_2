// Точка центровки карт по умолчанию (центр Москвы).

const DEFAULT_CENTER = ['40.177200', '44.503490'];


const station_verified_colors = [
    'islands#redCircleDotIcon',
    'islands#greenCircleDotIcon',
    'islands#yellowCircleDotIcon'
];
// Карты в модальных окнах добавления города и станции.
let mapCity;


// Метки на картах.
let placemarkCity;

// Текущий <select> выбора станции точки маршрута.

let geocoder = $('#geocoder');
let clusterer;

$(function () {
    ymaps.ready(init);

    function init() {
        let coordsCenter =  DEFAULT_CENTER;
        let mapOptions   = {
            center: coordsCenter,
            zoom: 10,
            controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
        };

        mapCity    = new ymaps.Map('map-city', mapOptions);


        clusterer = new ymaps.Clusterer({
            gridSize: 80,
            clusterIconLayout: 'default#pieChart',
            groupByCoordinates: false,
            clusterDisableClickZoom: false,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        });


        // Задаём иденитификаторы для карт для проверок при общей логике.
        mapCity.identifier    = 'city';


        let searchControlCity    = new ymaps.control.SearchControl({
            options: {
                float: 'left',
                floatIndex: 100,
                noPlacemark: true,
                noCentering: true
            }
        });

        createPlacemark(mapCity, DEFAULT_CENTER);
        // Ловим событие "Пользователь выбрал результат".
        // https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/control.SearchControl-docpage/
        searchControlCity.events.add('resultselect', function () {
            // Определяем координаты результатов поиска
            let results     = searchControlCity.getResultsArray();
            let index       = searchControlCity.getSelectedIndex();
            let result      = results[index];
            let coordinates = result.geometry.getCoordinates();
            console.log(coordinates);
            mapCity.setCenter(coordinates);
            movePlacemark(mapCity, coordinates);
        }, this);



        mapCity.controls.add(searchControlCity);




    }

    // При вводе названия города, если координаты не были введены, то карта скролится к нужно области
    $('input[name=title]').blur(function () {
        let titleQuery = $('input[name=region]').val() + $(this).val();
        if (!placemarkCity) {
            ymaps.geocode(titleQuery, {
                results: 1
            }).then(function (res) {
                let firstGeoObject = res.geoObjects.get(0);                      // Выбираем первый результат геокодирования.
                let coordinates    = firstGeoObject.geometry.getCoordinates();   // Координаты геообъекта.
                let bounds         = firstGeoObject.properties.get('boundedBy'); // Область видимости геообъекта.

                movePlacemark(mapCity, coordinates);                             // Масштабируем карту на область видимости геообъекта.
                mapCity.setBounds(bounds, {
                    checkZoomRange: true // Проверяем наличие тайлов на данном масштабе.
                });
            });
        }
    });




});

/**
 * Перемещение метки в указанную координатами точку.
 *
 * @param map
 * @param coordinates
 */
function movePlacemark(map, coordinates) {
    $('input[name=lat]').val(coordinates[0]);
    $('input[name=lng]').val(coordinates[1]);

    // Если метка уже создана – просто передвигаем её, если нет – создаём.
    switch (map.identifier) {
        case 'city':
            if (placemarkCity) {
                placemarkCity.geometry.setCoordinates(coordinates);
            } else {
                createPlacemark(mapCity, coordinates);
            }
            refreshCityData(coordinates);
            break;

    }
}

function createPlacemark(map, coordinates) {
    let placemark;

    switch (map.identifier) {
        case 'city':
            placemarkCity = new ymaps.Placemark(coordinates, {}, {
                draggable: true
            });
            placemark     = placemarkCity;
            // Слушаем событие окончания перетаскивания на метке.
            placemark.events.add('drag', function () {
                var coordinates = placemarkCity.geometry.getCoordinates();
                $('input[name=lat]').val(coordinates[0]);
                $('input[name=lng]').val(coordinates[1]);

            });
            placemark.events.add('dragend', function () {
                var coordinates = placemarkCity.geometry.getCoordinates();
                movePlacemark(map, coordinates);
            });
            break;

    }

    // Масштабируем карту на область видимости геообъекта.
    map.setCenter(coordinates);
    map.geoObjects.add(placemark);
}

/**
 * Заполнение полей формы в окне города с помощью геокодера.
 *
 * @param searchTerm
 */
function refreshCityData(searchTerm) {
    ymaps.geocode(searchTerm, {kind: 'locality', results: 1}).then(function (result) {
        // Выбираем первый результат геокодирования.
        var geoSelect = yaGetGeoObjectCity(result.geoObjects.get(0));

        // Заполнение данными
        $('input[name=country]').val(geoSelect.country_title).trigger('change');
        $('input[name=country_code]').val(geoSelect.country_code).trigger('change');
        $('input[name=region]').val(geoSelect.region_title).trigger('change');
        $('input[name=district]').val(geoSelect.district_title).trigger('change');
        $('input[name=city_type_id]').val(geoSelect.city_type_id).trigger('change');
        $('input[name=city_type_title]').val(geoSelect.city_type_title).trigger('change');
        $('input[name=title]').val(geoSelect.city_title).trigger('change');
    });
}



function refreshMap(map, searchTerm) {
    let kind;

    switch (map.identifier) {
        case 'city':
            kind = 'locality';
            break;

    }
        console.log(ymaps.geocode);
    ymaps.geocode(searchTerm, {
        kind: kind,
        results: 1
    }).then(function (result) {
        // Выбираем первый результат геокодирования.
        let firstGeoObject = result.geoObjects.get(0);                   // Выбираем первый результат геокодирования.
        let coordinates    = firstGeoObject.geometry.getCoordinates();   // Координаты геообъекта.
        let bounds         = firstGeoObject.properties.get('boundedBy'); // Область видимости геообъекта.
        if (map.identifier == 'city') {
            movePlacemark(map, coordinates);                             // Масштабируем карту на область видимости геообъекта.
        }

        map.setBounds(bounds, {
            checkZoomRange: true // Проверяем наличие тайлов на данном масштабе.
        });
        let geoSelect = yaGetGeoObjectCity(firstGeoObject);

        // Заполнение данными.
        switch (map.identifier) {
            case 'city':
                $('input[name=country]').val(geoSelect.country_title).trigger('change');
                $('input[name=country_code]').val(geoSelect.country_code).trigger('change');
                $('input[name=region]').val(geoSelect.region_title).trigger('change');
                $('input[name=district]').val(geoSelect.district_title).trigger('change');
                $('input[name=city_type_id]').val(geoSelect.city_type_id).trigger('change');
                $('input[name=city_type_title]').val(geoSelect.city_type_title).trigger('change');
                $('input[name=title]').val(geoSelect.city_title).trigger('change');
                break;

        }
    });
}

/**
 * Перенос метки в центральную точку по умолчанию.
 *
 * @param map
 */
function clearMap(map) {
    map.setCenter(DEFAULT_CENTER);
    switch (map.identifier) {
        case 'city':
            if (placemarkCity) {
                placemarkCity.geometry.setCoordinates(DEFAULT_CENTER);
            }
            break;

    }
    $('#form-city-add-edit input').val("").trigger('change');
}


setTimeout(()=> {
    $('.flashInfo').remove();
},2000)


