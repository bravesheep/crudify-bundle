
$(document).ready(function() {

    $('select[multiple]').each(function() {
        var select = $(this),
            search = $('<button/>', {
                'class': 'btn'
            }).append(
            $('<span/>', {
                'class': 'icon-search'
            }));
        select.removeAttr('required');
        select.parent().parent().find('span').remove();
        select.wrap($('<div/>', {
            'class': 'input-append'
        }));
        select.after(search);
        select.select2({
            'width': '350px'
        });
        search.on('click', function() {
            select.select2('open');
            return false;
        });
    });

    $('form').on('submit', function() {
        if ($(this).get(0).checkValidity() === false) {
            return;
        }
        $(this).find('a, input[type=submit], button').addClass('disabled');
    });

    $('.click-disable').on('click', function() {
        if ($(this).closest('form').length > 0) {
            if ($(this).closest('form').get(0).checkValidity() === false) {
                return;
            }
        }
        $(this).addClass('disabled');
        $(this).find('span').attr('class', 'icon-spinner icon-spin');
    });

    $('.datepicker').css('width', '100px').datepicker({
        'format': 'dd-mm-yyyy',
        'language': 'nl'
    });
});
