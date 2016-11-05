/**
 * User: NGUYỄN HỒNG KHANH
 * Date: 4/2/2015
 * Time: 9:10 PM
 */
function preg_replace(pattern, replacement, subject, limit) {
    if (typeof limit == "undefined") limit = -1;


    if (subject.match(eval(pattern))) {


        if (limit == -1) { //no limit

            return subject.replace(eval(pattern + "g"), replacement);

        } else {

            for (x = 0; x < limit; x++) {
                subject = subject.replace(eval(pattern), replacement);
            }

            return subject;
        }


    } else {
        return subject;
    }

}

function alias(txt) {
    txt = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'a', txt);
    txt = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'e', txt);
    txt = preg_replace("/(ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ)/", 'i', txt);
    txt = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'o', txt);
    txt = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'u', txt);
    txt = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'y', txt);
    txt = preg_replace("/(đ|Đ)/", 'd', txt);
    txt = preg_replace('/\s[\s]+/', '-', txt); // Strip off multiple spaces
    txt = preg_replace('/[\s\W]+/', '-', txt); // Strip off spaces and non-alpha-numeric
    txt = preg_replace('/^[\-]+/', '', txt); // Strip off the starting hyphens
    txt = preg_replace('/[\_]+$/', '', txt); // // Strip off the ending hyphens
    txt = txt.toLowerCase();
    txt = txt.replace(/["~!@#$%^&*\(\)_+=`{}\[\]\|\\:;'<>,.\/?"\- \t\r\n]+/g, '-');
    txt = txt.replace(/ /g, '-');
    return txt;
}
$(document).ready(function () {
    var object = 'form#form';
    var tabindex = 1;
    $(object).find('input[type="text"], input[type="password"],textarea, select, button').each(function (unusedIndex, child) {
            if (this.type != "hidden") {
                var $input = $(this);
                $input.attr("tabindex", tabindex);
                tabindex++;
            }
        }
    );
    $(object).find('input').each(
        function (unusedIndex, child) {
            $(this).attr("autocomplete", 'off');
        }
    );
    $(object).each(function () {
        $("input[type='text'],input[type='number'], input[type='password'], select, textarea").each(function () {
            var name = $(this).attr("name");
            if (!$(this).attr("id")) {
                $(this).attr('id', name);
            }

        });
    });
    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };
//$('a').each(function () {
//    if ($(this).hasAttr('title') === false) {
//        var name = $(this).text();
//        $(this).attr('title', name);
//    }
//});
    $('a.btn, button, input[type="button"], input[type="reset"], input[type="submit"]').each(function () {
        $(this).addClass('waves-effect');
    });
});
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";

    var fixedName = '<%= Request["formName"] %>';
    name = fixedName + name;

    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

$(document).ready(function () {
    setTimeout(function () {
        $('ul.errors').fadeOut();
    }, 10000)
});

function my_date_picker(arr) {
    //$('#ngay_van_ban').datepicker({dateFormat: 'dd/mm/yy',maxDate: "+0D", firstDay: 1, showButtonPanel: true, changeMonth: true, changeYear: true});
    jQuery.each(arr, function (i, val) {
        $('#' + val).datepicker({dateFormat: 'dd/mm/yy', maxDate: "+0D", firstDay: 1, showButtonPanel: true, changeMonth: true, changeYear: true})
    });
}
$(document).on('click', '.browse', function () {
    var file = $(this).parent().parent().parent().find('.file');
    file.trigger('click');
});
$(document).on('change', '.file', function () {
    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});