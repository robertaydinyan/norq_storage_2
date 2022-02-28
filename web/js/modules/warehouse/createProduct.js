$(document).ready(function() {

    $('#role').click(function(){
        if($(this).is(":checked")){
            $('.texnik-group').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.texnik-group').hide();
        }
    });
    $('#mac-address').click(function(){
        if($(this).is(":checked")){
            $('.show-mac').show();
        }
        else if($(this).is(":not(:checked)")){
            $('.show-mac').hide();
        }
    });

} );