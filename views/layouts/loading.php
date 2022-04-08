<style>
    #preloder{position:fixed;width:100%;height:100%;top:0;left:0;z-index:999999;background:#fff}
    .loader {
        width:40px;
        height:40px;
        position:absolute;
        top:50%;
        left:50%;
        margin-top:-13px;
        margin-left:-13px;
        border-radius:50%!important;
        animation:loader .8s linear infinite;
        -webkit-animation:loader .8s linear infinite
    }
    @keyframes loader {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
            border: 4px solid #f44336;
            border-left-color: transparent;
        }
        50% {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
            border: 4px solid #673ab7;
            border-left-color: transparent;
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
            border: 4px solid #f44336;
            border-left-color: transparent;
        }
    }
</style>


<div id="preloder">
    <div class="loader"></div>
</div>


<script>
    $(window).on('load', function() {

        $(".loader").fadeOut();
        $("#preloder").delay(400).fadeOut("slow");
    });

</script>