function drawArrowSliders(parent, section_target) {
    $('.on-hover-scroll', parent).on('mouseenter', function () {
        if ($(this).hasClass('on-hover-table-scroll-left')) {
            // $('.on-hover-table-scroll-right').fadeIn(100);
            section_target.animate({
                scrollLeft: -3000
            }, 2000);
        }
        else if ($(this).hasClass('on-hover-table-scroll-right')) {
            // $('.on-hover-table-scroll-left').fadeIn(100);
            section_target.animate({
                scrollLeft: 3000,
            }, 2000);
        }
    });
    $('.on-hover-scroll', parent).on('mouseleave', function () {
        section_target.stop(true, false);
    });
}
