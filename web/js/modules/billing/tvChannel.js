$(document).ready(()=> {
        let body = $('body');
        body.on('click', '.deleteX' , function () {
            $('.oldImage').val(' ');
            $(this).closest('.aboutImageDiv').remove();
        })
})