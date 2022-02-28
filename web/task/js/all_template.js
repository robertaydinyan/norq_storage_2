function erpAllTemplates(options){
    switch(options.item_get) {
        case "get-zone9-slider":
            return $(`
                <div class="zone9-slide slide-${options.slide_count}">
                    <div class="zone9-popup-close-div">
                        <div class="zone9-close"><i class="fas fa-times"></i></div>
                    </div>
                    <div class = "zone9-popup-content"></div>
                </div>`);
        case "":
            return $(``);
        default:
            console.log("wrong template");
    }
}
