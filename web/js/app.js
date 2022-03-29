// $(function ($) {
//
//
//
// })(jQuery);
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
                newH.attr('onclick', 'showPage(' + res['link'] + ')');
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

    if ($('.fa-star-o').hasClass('fa-star-o')){
        status = 1;
        $('.fa-star-o').addClass('fa-star');
        $('.fa-star-o').removeClass('fa-star-o');
        $('.favorites').append('<div class="favorite" data-url="' + $('#user-link-no-lang').val() + '" onclick="showPage(\'' + $('#user-link').val() + '\')">' + title_tr + ' <i class="fa fa-times star" data-remove="true"></i></div>')
    } else  {
        status = 0;
        $('.fa-star').addClass('fa-star-o');
        $('.fa-star').removeClass('fa-star');
        $.each($('.favorites').children(), function(i, v) {
            if ($(v).data('url') === $('#user-link-no-lang').val()) {
                $(v).remove();
                return false;
            }
        });
    }
    $.get('/warehouse/warehouse/change-favorite', {
        'status': status,
        'user_id': $('#user-id').val(),
        'url': $('#user-link').val(),
        'title': title,
    });
});

$('.filter').on('click', function() {
    let page = $(this).data('model');
    $.get('/warehouse/warehouse/get-table-rows?lang=' + $('html').attr('lang'), {
        'page': page,
    }).done(function(res) {
        $('#FilterModal').html(res);
        $('#FilterModal').modal('show');
    });
});

function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =  h + ":" + m ;
    setTimeout(startTime, 1000);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


function SaveForm(el) {
    el.remove();
    let arr = [];
    $.each($('.form-data').find('input, select, textarea'), function(i, k) {
        arr.push($(k).val())
    });
    localStorage.setItem('last_form_title', $('h1').text().split('/n')[0]);
    localStorage.setItem('last_form', JSON.stringify(arr));
    localStorage.setItem('last_form_path', $('#user-link').val());
    history.back()
}

let last_title = localStorage.getItem('last_form_title');
let last_form_path = localStorage.getItem('last_form_path');
if(last_form_path !== "null" && last_title !== "null"){
    $('.bookmarks').prepend('<div class="favorite" onclick="showPage(\'' + last_form_path + '\')">' + last_title +'</div>');
}
setTimeout(function() {
    if (last_form_path + '&show-header=false' === $('#user-link').val()) {
        let values = JSON.parse(localStorage.getItem('last_form'));
        $('.saveForm').remove();

        $.each($('.form-data').find('input, select, textarea'), function(i, k) {
            $(k).val(values[i]).change();
        });
        $('input[type=submit], button[type=submit]').on('click', function() {
            localStorage.setItem('last_form_title', null);
            localStorage.setItem('last_form', null);
            localStorage.setItem('last_form_path', null);
        })
    }
}, 1500);

var checkList = document.getElementById('list1');
checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
    if (checkList.classList.contains('visible'))
        checkList.classList.remove('visible');
    else
        checkList.classList.add('visible');
}
