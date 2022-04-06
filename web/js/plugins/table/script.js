function showArrows() {

    const allTable = $('.toggle-entire-cols');
    allTable.find('.table-arrow-slides').remove();
    allTable.prepend(`
                <div class="table-arrow-slides">
                    <div class="on-hover-scroll on-hover-table-scroll-left"></div>
                    <div class="on-hover-scroll on-hover-table-scroll-right"></div>
                </div>`);
    const tableSection = $('.tableSection');
    $('.on-hover-scroll', allTable).on('mouseenter', function () {
        // let tableFullWidth = $('.tableSection').width();
        // let tableWidth = $(this).closest('.allTable').find('table').width();
        let thLength = $(this).closest('.allTable').find('thead').find('th').length;
        // check if arrow is left or right
        if ($(this).hasClass('on-hover-table-scroll-left')) {
            $('.on-hover-table-scroll-right').fadeIn(100);
            tableSection.animate({
                scrollLeft: -thLength * 250
            }, 10000);
        }
        else if ($(this).hasClass('on-hover-table-scroll-right')) {
            $('.on-hover-table-scroll-left').fadeIn(100);
            tableSection.animate({
                // scrollLeft: tableFullWidth,
                scrollLeft: thLength * 250,
            }, 10000);
        }
    });
    $('.on-hover-scroll', allTable).on('mouseleave', function () {
        tableSection.stop(true, false);
    });
    tableSection.scroll(function () {
        if (tableSection.scrollLeft() > 0) {
            $('.on-hover-table-scroll-left').fadeIn(100);
        }
        else {
            $('.on-hover-table-scroll-left').fadeOut(100);
        }
        if (Math.floor(tableSection.scrollLeft() + tableSection.innerWidth()) < tableSection[0].scrollWidth) {
            $('.on-hover-table-scroll-right').fadeIn(100);
        }
        else {
            $('.on-hover-table-scroll-right').fadeOut(100);
        }
    });

}

