/**
 * Функция получения объекта города из геообъекта Яндекса.
 *
 * @see https://tech.yandex.ru/maps/doc/jsapi/2.0/ref/reference/GeoObjectCollection-docpage/
 *
 * @param geoObject Геообъект поисковой выдачи Яндекса из коллекции геообъектов.
 * @returns {*}
 */
var cityTypeList = [{"city_type_id":"2","title":"\u0413\u043e\u0440\u043e\u0434 \u0444\u0435\u0434\u0435\u0440\u0430\u043b\u044c\u043d\u043e\u0433\u043e \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u044f","title_short":"\u0433"},{"city_type_id":"5","title":"\u041f\u043e\u0441\u0435\u043b\u043e\u043a \u0433\u043e\u0440\u043e\u0434\u0441\u043a\u043e\u0433\u043e \u0442\u0438\u043f\u0430","title_short":"\u043f\u0433\u0442"},{"city_type_id":"7","title":"\u041f\u043e\u0441\u0435\u043b\u043e\u043a \u0441\u0435\u043b\u044c\u0441\u043a\u043e\u0433\u043e \u0442\u0438\u043f\u0430","title_short":"\u043f\u0441\u0442"},{"city_type_id":"9","title":"\u0421\u0430\u0434\u043e\u0432\u043e\u0435 \u0442\u043e\u0432\u0430\u0440\u0438\u0449\u0435\u0441\u0442\u0432\u043e","title_short":"\u0441\u0430\u0434.\u0442"},{"city_type_id":"15","title":"\u041f\u043e\u0441\u0435\u043b\u043e\u043a \u043f\u0440\u0438 \u0441\u0442\u0430\u043d\u0446\u0438\u0438","title_short":"\u043f\/\u0441\u0442"},{"city_type_id":"12","title":"\u041a\u043e\u0442\u0442\u0435\u0434\u0436\u043d\u044b\u0439 \u043f\u043e\u0441\u0435\u043b\u043e\u043a","title_short":"\u043a\u043e\u0442.\u043f"},{"city_type_id":"10","title":"\u041d\u0430\u0441\u0435\u043b\u0435\u043d\u043d\u044b\u0439 \u043f\u0443\u043d\u043a\u0442","title_short":"\u043d\u043f"},{"city_type_id":"17","title":"\u0420\u0430\u0431\u043e\u0447\u0438\u0439 \u043f\u043e\u0441\u0435\u043b\u043e\u043a","title_short":"\u0440\u043f"},{"city_type_id":"13","title":"\u0416\u0438\u043b\u043e\u0439 \u043a\u043e\u043c\u043f\u043b\u0435\u043a\u0441","title_short":"\u0436\u043a"},{"city_type_id":"16","title":"\u0414\u0430\u0447\u043d\u044b\u0439 \u043f\u043e\u0441\u0435\u043b\u043e\u043a","title_short":"\u0434\u043f"},{"city_type_id":"8","title":"\u041f\u043e\u0441\u0435\u043b\u043e\u043a","title_short":"\u043f\u043e\u0441"},{"city_type_id":"11","title":"\u0421\u0442\u0430\u043d\u0446\u0438\u044f","title_short":"\u0441\u0442"},{"city_type_id":"4","title":"\u0414\u0435\u0440\u0435\u0432\u043d\u044f","title_short":"\u0434"},{"city_type_id":"14","title":"\u0421\u0442\u0430\u043d\u0438\u0446\u0430","title_short":"\u0441\u0442-\u0446\u0430"},{"city_type_id":"6","title":"\u0425\u0443\u0442\u043e\u0440","title_short":"\u0445\u0443\u0442"},{"city_type_id":"1","title":"\u0413\u043e\u0440\u043e\u0434","title_short":"\u0433"},{"city_type_id":"3","title":"\u0421\u0435\u043b\u043e","title_short":"\u0441"}];
function yaGetGeoObjectCity(geoObject) {
    let cityTypes     = cityTypeList;
    let cityTypeTitle = 'город';
    let cityTypeId    = 1;

    let geoObjectProperties = geoObject.properties;
    let prefix              = 'metaDataProperty.GeocoderMetaData.AddressDetails.Country';
    if (geoObjectProperties.get('metaDataProperty.GeocoderMetaData.kind') !== 'locality') {
        return false;
    }

    let countryTitle  = geoObjectProperties.get(prefix + '.CountryName');
    let countryCode   = geoObjectProperties.get(prefix + '.CountryNameCode');
    let regionTitle   = geoObjectProperties.get(prefix + '.AdministrativeArea.AdministrativeAreaName');
    let districtTitle = geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName');
    let cityTitle     = '';

    if (geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName')) {
        cityTitle = geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName');
    } else if (geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.Locality.DependentLocality.DependentLocalityName')) {
        cityTitle = geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.Locality.DependentLocality.DependentLocalityName');
    } else if (geoObjectProperties.get(prefix + '.AdministrativeArea.Locality.LocalityName')) {
        cityTitle = geoObjectProperties.get(prefix + '.AdministrativeArea.Locality.LocalityName');
    } else if (geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName')) {
        cityTitle = geoObjectProperties.get(prefix + '.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName');
    } else if (geoObjectProperties.get(prefix + '.AdministrativeArea.Locality.DependentLocality.DependentLocalityName')) {
        cityTitle = geoObjectProperties.get(prefix + '.AdministrativeArea.Locality.DependentLocality.DependentLocalityName');
    } else if (geoObjectProperties.get(prefix + '.AddressLine')) {
        cityTitle = geoObjectProperties.get(prefix + '.AddressLine')
    }

    // Если название региона совпадает с названием города.
    if (regionTitle === cityTitle) {
        regionTitle = '';
    }

    // Если название района совпадает с названием города.
    if (districtTitle === cityTitle) {
        districtTitle = '';
    }

    if (isFederalCity(cityTitle)) {
        cityTypeId    = 2;
        cityTypeTitle = 'город федерального значения';
        regionTitle   = '';
        districtTitle = '';
    } else {
        if (cityTitle.search(/ё/i)) {
            cityTitle = cityTitle.replace(/ё/g, "е");
        }

        for (let index in cityTypes) {
            if (cityTitle.indexOf(cityTypes[index].title.toLowerCase() + ' ') + 1) {
                cityTypeId    = cityTypes[index].city_type_id;
                cityTypeTitle = cityTypes[index].title.toLowerCase();
                cityTitle     = cityTitle.replace(cityTypes[index].title.toLowerCase() + ' ', '');
                break;
            }
        }
    }

    countryTitle  = typeof countryTitle != 'undefined' ? countryTitle : '';
    countryCode   = typeof countryCode != 'undefined' ? countryCode : '';
    regionTitle   = typeof regionTitle != 'undefined' ? regionTitle : '';
    districtTitle = typeof districtTitle != 'undefined' ? districtTitle : '';
    cityTitle     = typeof cityTitle != 'undefined' ? cityTitle : '';

    // Если название района совпадает с "Городской округ cityTitle", сбрасываем называние района.
    if (('Городской округ ' + cityTitle.replace(/ё/g, "е")).toLowerCase() === districtTitle.replace(/ё/g, "е").toLowerCase()) {
        districtTitle = '';
    }

    return {
        country_code: countryCode,
        country_title: countryTitle,
        region_title: regionTitle,
        district_title: districtTitle,
        city_type_id: cityTypeId,
        city_type_title: cityTypeTitle,
        city_title: cityTitle,
        coords: geoObject.geometry.getCoordinates() // [lat, lng]
    };
}

/**
 * Функция получения данных о точке из геообъекта Яндекса.
 *
 * @param geoObject
 * @returns {*}
 */
function yaGetGeoObjectPoint(geoObject) {
    let basePrefix = 'metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea';
    let properties = geoObject.properties;
    let fullPrefix;

    // Получаем данные по адресу.
    if (properties.get(basePrefix + '.SubAdministrativeArea')) {
        if (properties.get(basePrefix + '.SubAdministrativeArea.Locality.Thoroughfare')) {
            fullPrefix = basePrefix + '.SubAdministrativeArea.Locality.Thoroughfare';
        } else if (properties.get(basePrefix + '.SubAdministrativeArea.Locality.DependentLocality.Thoroughfare')) {
            fullPrefix = basePrefix + '.SubAdministrativeArea.Locality.DependentLocality.Thoroughfare';
        }
    } else if (properties.get(basePrefix + '.Locality')) {
        if (properties.get(basePrefix + '.Locality.DependentLocality')) {
            fullPrefix = basePrefix + '.Locality.DependentLocality';
        } else if (properties.get(basePrefix + '.Locality.Thoroughfare')) {
            fullPrefix = basePrefix + '.Locality.Thoroughfare';
        }
    }

    let street         = properties.get(fullPrefix + '.ThoroughfareName') ? properties.get(fullPrefix + '.ThoroughfareName') : '';
    let buildingNumber = properties.get(fullPrefix + '.Premise') ? properties.get(fullPrefix + '.Premise.PremiseNumber') : '';

    return {
        street: street,
        buildingNumber: buildingNumber,
        coords: geoObject.geometry.getCoordinates()
    };
}

/**
 * Является ли город городом федерального значения.
 *
 * @param cityTitle
 * @returns {boolean}
 */
function isFederalCity(cityTitle) {
    return cityTitle === 'Москва' || cityTitle === 'Санкт-Петербург' || cityTitle === 'Севастополь';
}