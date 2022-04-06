$(document).ready(()=> {
    let body = $('body');
      body.on('click','.addInput',function () {
        let clone = $(this).prev().prev().clone();
        let time_ = new Date().getTime();
        clone.find('.colorWidgetStatus').removeAttr('id').attr('id','color-'+time_);
        clone.find('input').val('');
        clone.css('margin-top','40px');
        $(this).closest('.module-component-content-card').find('.module-component-content-card-clone').append(clone);
    })

})