<?php $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min/**/.js'); ?>
<script>
    window.onload = (event) => {
        document.getElementsByTagName("html")[0].innerHTML = localStorage.getItem('last_form');
    };
</script>