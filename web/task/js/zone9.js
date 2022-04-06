function drawZoneNine(callback, popup, data){
    let zone_slider = erpAllTemplates({item_get:"get-zone9-slider"});
    $(".zone9-popup-content", zone_slider).html(callback(data?data: null));
    popup.html(zone_slider);
    if(popup.hasClass("popup2")){
        $(".zone9-popup-close-div", popup).css("top", "10%")
    }

    $('.zone9-close', zone_slider).on('click', function () {
        zoneNineHideShow(popup, "hide");
        zone_slider.empty();
    });
}
