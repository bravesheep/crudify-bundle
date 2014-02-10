$(document).ready(function() {

    if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        $('select[multiple]').selectize();
    }

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
        $(this).find('span').attr('class', 'fa fa-spinner fa-spin');
    });

    $('.datepicker').css('width', '100px').datepicker({
        'format': 'dd-mm-yyyy',
        'language': 'nl'
    });
});
