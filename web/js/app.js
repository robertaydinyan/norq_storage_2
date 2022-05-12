// $(function ($) {
//
//
//
// })(jQuery);
$('.main-header2').eq(2).removeClass('main-header2')
let categoryTreeToggler = document.getElementsByClassName("caret");
let i;

for (i = 0; i < categoryTreeToggler.length; i++) {
    categoryTreeToggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
    });
}



/**
 * Generate random string/characters
 *
 * @param length
 * @returns {string}
 */
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

/**
 * Limit number between 0 - 100
 *
 * @param input
 */
function betweenNumbersLimit(input) {
    let n = input.value;
    n = Number(n);
    if (n < 0) {
        input.value = 0;
    } else if (n > 100) {
        input.value = 100;
    } else {
        input.value = n;
    }
}

/**
 * Filter input
 *
 * ex. setInputFilter(input, function(value) {
 *         return /^\d*\.?\d*$/.test(value); Allow digits and '.' only, using a RegExp
 *     });
 *
 * @param textbox
 * @param inputFilter
 */
function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    });
}

/**
 * Remove spaces from string
 *
 * @param string
 * @returns {*}
 */
function removeSpaceFromString(string) {
    return string.replace(/\s/g, '');
}


/**
 * Get Select2 setting for specific element
 *
 * @param element
 * @returns {*|jQuery}
 */
function getSelect2Settings(element) {
    if ($(element).length > 0) {
        let $el = $(element),
            settings = $el.attr('data-krajee-select2'),
            id = $el.attr('id');
        settings = window[settings];

        return settings;
    }
}

/**
 * Render Select2 with data (optional)
 *
 * @param element
 * @param settings
 * @param data
 * @returns {jQuery}
 */
function renderSelect2WithData(element, settings, data = null) {
    if ($(element).length > 0) {
        let select2Options = settings;

        if (data !== null) {
            select2Options.data = data;
        }

        return $(element).select2(select2Options).trigger('change');
    }
}

/**
 * Generate unique IDs for use as pseudo-private/protected names.
 *
 * @returns {string}
 * @constructor
 */
function ID_Name() {
    return '_' + Math.random().toString(36).substr(2, 9);
}

$('.remove-favorite').on('click', function(e) {
    e.stopPropagation();

    $(this).parent().remove();

    $.get('/warehouse/warehouse/change-favorite', {
        'status': 0,
        'user_id': $('#user-id').val(),
        'url': $(this).parent().data('url'),
    });
})

function removeBarcode() {
    $('.remove-barcode').off().on('click', function () {
        $(this).parent().removeClass('form-group');
        $(this).prev().attr('type', 'hidden').val('');
        $(this).remove();
    });
}
function cloneBarcode() {
    $('.clone-barcode').off().on('click', function () {
        let barcode = $(this).parent();
        let barcode_new = barcode.clone().insertBefore(barcode);
        barcode.find('input').val('');
        barcode_new.find('button').html('<i style="color:red;" class="fa fa-times"></i>').removeClass('clone-barcode').addClass('remove-barcode');
        removeBarcode();
    });
}

removeBarcode();
cloneBarcode();
$('.remove-report').on('click', function(e) {
    e.stopPropagation();

    $(this).parent().remove();

    $.get('/warehouse/reports/remove-report', {
        'reportID': $(this).data('report')
    });
})

function removeHistoryItem() {
    $('.remove-history-item').off().on('click', function(e) {
        e.stopPropagation();
        let id = $(this).data('id');
        $(this).parent().remove();

        $.get('/warehouse/warehouse/remove-history-item', {
            'status': 0,
            'id': id
        }).done(function(res) {
            res = JSON.parse(res);
            if (res) {
                let newH = $('.histories').children().last().clone().appendTo('.histories');
                newH.attr('onclick', 'showPage(' + res['link'] + ', ' + res['title'] + res['id'] + ')');
                newH.html(res['title'] + ' <i class="fa fa-times remove-history-item" data-id="' + res['id'] +'"></i>')
                removeHistoryItem()
            }
        });
    })
}
removeHistoryItem();
$('.star').click(function () {
    var status;
    let title = $('h1').data('title').trim();
    let title_tr = $('h1').text().split('\n')[0];
    status = $('.fa-star-o').hasClass('fa-star-o') ? 1 : 0;

    $.get('/warehouse/warehouse/change-favorite', {
        'status': status,
        'user_id': $('#user-id').val(),
        'url': $('#user-link').val(),
        'title': title,
    }).done((res) => {
        res = JSON.parse(res);
        if ($('.fa-star-o').hasClass('fa-star-o')){
            $('.fa-star-o').addClass('fa-star');
            $('.fa-star-o').removeClass('fa-star-o');
            $('.favorites').children().eq(1).append('<div class="favorite" data-url="' + $('#user-link-no-lang').val() + '" onclick="showPage(\'' + $('#user-link').val() + '\', \'' + title_tr + '\', \'' + res['id'] + ', false)">' + title_tr + ' <i class="fa fa-times star" data-remove="true"></i></div>')
        } else  {
            $('.fa-star').addClass('fa-star-o');
            $('.fa-star').removeClass('fa-star');
            $.each($('.favorites').children(), function(i, v) {
                if ($(v).data('url') === $('#user-link-no-lang').val()) {
                    $(v).remove();
                }
            });
        }
    });
});

$('.filter').on('click', function() {
    let page = $(this).data('model');
    let type = $(this).data('type');
    $.get('/site/get-table-rows', {
        'page': page,
        'type': type
    }).done(function(res) {
        $('#FilterModal').html(res);
        $('#FilterModal').modal('show');
    });
});

function startTime() {

    var today = new Date();
    var date = checkTime(today.getDate())+'.'+(checkTime(today.getMonth()+1))+'.' +checkTime(today.getFullYear());
    var time = checkTime(today.getHours()) + ":" + checkTime(today.getMinutes());
    if (document.getElementById('txt')) {
        document.getElementById('txt').innerHTML = date + "  "  + time;
        setTimeout(startTime, 1000);
    }
}
startTime()


function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


function SaveForm(el) {
    el.remove();
    localStorage.setItem('last_form_title', $('h1').text().split('/n')[0]);
    let html = $('html');
    $("input, select").each(function () {
        if ($(this).attr('type') === "checkbox" || $(this).attr('type') === "radio") {
            if ($(this).is(':checked')) {
                $(this).attr('checked', 'checked');
            }
        } else {
            $(this).attr("value", $(this).val());
        }
    });
    $("textarea").each(function () {
        $(this).attr("value", $(this).text());
    });
    html.find('.navbar').remove();
    html.find('.bookmarks').remove();
    html.find('.window').remove();
    localStorage.setItem('last_form', html.html());
    history.back()
}
let last_title = localStorage.getItem('last_form_title');
if(last_title !== "null" && last_title && last_title !== "undefined"){
    $('.bookmarks').prepend('<div class="favorites  mt-0 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 mb-3" onclick="showPage(\'/site/last-form\', \'' + last_title + '\', \'form\', false)"><button class="accordion bg-white">' + last_title +'</button></div>');
}
// setTimeout(function() {
//     if (last_form_path + '&show-header=false' === $('#user-link').val()) {
//         let values = JSON.parse(localStorage.getItem('last_form'));
//         $('.saveForm').remove();
//
//         $.each($('.form-data').find('input, select, textarea'), function(i, k) {
//             $(k).val(values[i]).change();
//         });
//         $('input[type=submit], button[type=submit]').on('click', function() {
//             localStorage.setItem('last_form_title', null);
//             localStorage.setItem('last_form', null);
//             localStorage.setItem('last_form_path', null);
//         })
//     }
// }, 1500);
function windowActions() {
    $('.slider').off().on('click', function() {
        let id = $(this).data('id');
        console.log(id)
        if (id) {
            $('.window').removeClass('nozIndex').removeClass('zIndex');
            $('.window[data-id=' + id + ']').addClass('zIndex')
        }
    });

    $('.remove-window').off().on('click', function() {
        let id = $(this).closest('.window').attr('data-id');
        $('.slider[data-id=' + id + ']').eq(0).remove();
        $(this).closest('.window').remove();
    });

    $('.remove-slider').off().on('click', function() {
        let id = $(this).closest('.slider').attr('data-id');
        $('.window[data-id=' + id + ']').eq(0).remove();
        $(this).closest('.slider').remove();
    });
}


function showPage(url, title, id, header = true){
    $('.window').on('click',function(){
        $('.window').removeClass('zIndex');
        $(this).addClass('zIndex');
    });
    var html_ = '<iframe src="' + url + (header ? '&show-header=false' : '?show-header=false') + '" style="width:90vw;min-height:50vh;border:0px;"></iframe>';
    var window_ = $('.window').first().clone().css({display: 'block', top:'20%',left:'5vw',position:'absolute'}).attr('data-id', id);
    $(window_).find('.title-bar-text').text(title);
    window_.find('.window-body').html(html_);
    $('body').append(window_);
    $( function() {
        $( ".window" ).resizable();
        $( ".window" ).draggable();
    } );

    let template = $('.slider-template');
    let new_item = template.clone();
    new_item.appendTo(template.parent()).removeClass('slider-template').attr('data-id', id)
    new_item.find('a').text(title);
    windowActions();
    // $('.modal-content-custom *').replaceWith(html_);
    // $('.modal-content-custom').show().animate({left: '10%'}, {duration: 300});
    // $('.modal-content-custom .close').click(function(){
    //     $('.modal-content-custom').animate({left: '110%'}, {duration: 300});
    //     $('.modal-content-custom .page1').remove();
    // });
}



$('.show-modal').click(function(){
    var href = $(this).attr('data-modal');
    // var html_ = $('#page-modal').html();
    // $(".regular").slick({
    //     dots: false,
    //     infinite: true,
    //     slidesToShow: 4,
    //     slidesToScroll: 1
    // });
    // $('.modal-content-custom').append(html_);
    if (window.matchMedia("(max-width: 990px)").matches) {
        $('.modal-content-custom').show().animate({left: '55%'}, {duration: 600});
    } else {
        $('.modal-content-custom').show().animate({left: '85%'}, {duration: 600});
    }

        $('.modal-content-custom .close').click(function(){
        $('.modal-content-custom').animate({left: '110%'}, {duration: 500});
        $('.modal-content-custom .page1').remove();
    });
});




$('table').attr('id','tbl');
var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) {
        return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })
    }
        , downloadURI = function(uri, name) {
        var link = document.createElement("a");
        link.download = $('h1').text();
        link.href = uri;
        link.click();
    }

    return function(table, name, fileName) {
        table = $('#' + table).clone();
        table.find('.hidden-item').remove();
        table.find('.action-column').remove();
        table.find('#w0-filters').remove();
        var ctx = {worksheet: $('h1').text() || 'Worksheet', table: table.html()}
        var resuri = uri + base64(format(template, ctx))
        downloadURI(resuri, fileName);
    }
})();
var checkList = document.getElementById('list1');
if (checkList) {
    checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
        if (checkList.classList.contains('visible'))
            checkList.classList.remove('visible');
        else
            checkList.classList.add('visible');
    }
}

$('.change-site-status').on('click', function() {
    let userID = $(this).data('user-id');
    let status = parseInt($(this).attr('data-status'));
    if (window.confirm('Համոզված եք')) {
        $.post('/site/change-site-status', {
            status: status,
            userID: userID
        }).done(() => {
            $(this).find('i').attr('class', status === 1 ? 'fas fa-ban' : 'fas fa-car');
            $(this).attr('data-status', 1 - status);
            $(this).attr('title', status === 1 ? $(this).data('stop') : $(this).data('start'));
        })
    }
});


function openNav() {
    document.getElementById("mySidenav").style.width = "220px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

$('.hide-row').on('click', function() {
    let queue = $(this).data('queue');
    $.each($('#tbl > tbody, thead').children(), (i, k) => {
        if ($(this).prop('checked'))
            $(k).children().eq(queue).removeClass('hidden-item');
        else
            $(k).children().eq(queue).addClass('hidden-item');
    });
    // $('#tbl > thead').children().eq(queue).hide();
});



$(".loader").fadeOut();
$("#preloder").delay(400).fadeOut("slow");

// import lightGallery from "https://cdn.skypack.dev/lightgallery@2.0.0-beta.3";
//
// lightGallery($('.table'), {
//     speed: 500,
//     // Append caption inside the slide item
//     // to apply some animation for the captions (Optional)
//     appendSubHtmlTo: ".lg-item",
//     // Delay slide transition to complete captions animations
//     // before navigating to different slides (Optional)
//     // You can find caption animation demo on the captions demo page
//     slideDelay: 400,
//     // plugins: [lgZoom]
// });
// if ($('#lightgallery').length) {
//     lightGallery(document.getElementById('lightgallery'), {
//         selector: '.image'
//     });
// }
let page = window.location.href.split('/').slice(3).join('/').split('?')[0];

if (localStorage[page]) {
    let widths = JSON.parse(localStorage[page]);
    $.each(widths, (i, v) => {
        $('#tbl').find('tr').children().eq(i).css('width', v);
    });
}
if ($("table").length > 0) {
    $("table").colResizable({
        onResize: function (e) {
            let page = window.location.href.split('/').slice(3).join('/').split('?')[0];
            let el = ($(e.target).parent().index())
            let widths = localStorage[page] ? JSON.parse(localStorage[page]) : [];
            widths[el] = $('table.JColResizer').find('th').eq(el).css('width');
            localStorage[page] = JSON.stringify(widths);
        }
    });
}

function maximaize(el_){
    $(el_).closest('.window').css({'width':'100%','height':'100%','top':'0px','left':'0px'});
    $(el_).closest('.window').find('iframe').css({'width':'100%','min-height':'100vh'});
}
function minimize(el_){
    $(el_).closest('.window').addClass('nozIndex');
}