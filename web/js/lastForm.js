window.onload = (event) => {
    // document.body.innerHTML = '';
    // document.head.innerHTML = '';
    let scripts = [], local_scripts = [], script, script_link = '';
    let text = localStorage.getItem('last_form');
    let start = 0, end = 0, start2, jquery;

    while (true) {
        end += start;
        start = text.indexOf('<script');
        if (start < 0) break;
        end = text.substring(start).indexOf("/script>") + 8;
        script = text.substr(start, end);
        // if (!text.substr(start, end).includes('script')) break;
        // if (text.substr(start, end).includes('barEl.querySelectorAll(blockSelect')) continue;
        // script += text.substr(start, end);
        // console.log(text)
        // start = text.search(/(?=s').+?/);
        // console.log(start);
        // console.log(text.substring(start));
        // if (start) {
        //     end = text.substring(start).search(/(?=>).+?/);
        //     console.log(text.substring(0, end));
        // }
        start2 = script.indexOf('src="') + 5;
        text = text.substring(0, start) + text.substring(start + end);

        if (start2 !== 4) {
            script_link = script.substring(start2, script.substring(start2).indexOf('"') + start2);
            script = document.createElement('script');
            if (script_link.includes('jquery.js') || script_link.includes('yandex')) {
                continue;
            }
            script.src = script_link;
            scripts.push(script);
        } else {
            script_link = script.substr(8, script.length - 17);
            script_link = script_link.replace('type="text/javascript">', '');
            script = document.createElement('script');
            script.text = script_link
            local_scripts.push(script);
        }
        // document.body.appendChild(script);
    }
    // document.head.innerText = text.substring(15, text.indexOf('</head>'));
    // document.appendChild(text);// + scripts;
    // console.log(document.body);
    // setTimeout(() => {
    document.body.innerHTML = text + document.body.innerHTML;
    $('.hasDatepicker').removeClass('hasDatepicker');
    $('#ui-datepicker-div').remove();
    // }, 2000);
    // $('html').empty().append(localStorage.getItem('last_form'))
    // document.getElementsByTagName("html")[0].innerHTML = localStorage.getItem('last_form')

    // fix select2

    $.each(scripts.concat(local_scripts), (i, k) => {
        document.body.appendChild(k);
    });
    setTimeout(function() {

        fixSelect2();
    }, 6000);
    setTimeout(function() {

        $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
    }, 10000);
};
function fixSelect2() {
    el = $('.select2-hidden-accessible');
    el.next().remove();
    el.next().remove();
    el.attr('style', '');
    el.removeClass('select2-hidden-accessible')
    el.val(el.attr('value'));
    el.select2();
}