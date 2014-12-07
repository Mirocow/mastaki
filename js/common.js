/**
 * Created by slashman on 28.10.14.
 */
$(document).ready(function(){
    $('i[data-toggle=tooltip]').tooltip();
    $('.problem-details').on('show.bs.collapse', function () {
        $(this).parent().find('a i').removeClass('fa-angle-right').addClass('fa-angle-down');
        $('.problem-details.in').collapse('hide');
    });
    $('.problem-details').on('hide.bs.collapse', function () {
        $(this).parent().find('a i').removeClass('fa-angle-down').addClass('fa-angle-right');
    });
    $('input[name=phone],input[name="LoginForm[phone]"],input[name="User[phone]"],input[name="Mastak[phone]"], .popover-content input[name="LoginForm[phone]"]').mask("(999) 999-99-99");

    var date = new Date();
    date.setHours(date.getHours()+ 3);
    var startDate = date;
    var endDate = date.setMonth(date.getMonth() + 1);

    $('#dateTime').datetimepicker({
        lang: 'ru',
        minDate: 0,
        maxDate: '+1970/02/01',
        minTime: '8',
        maxTime: '24',
        defaultTime: startDate.getHours().toString(),
        formatTime: 'H',
        format:'Y-m-d H:i:s'
    });
    $('#cabinet-login').popover({
        placement: 'top',
        html : true,
        content: function() {
            return $('#popoverExampleTwoHiddenContent').html();
        },
        title: function() {
            return $('#popoverExampleTwoHiddenTitle').html();
        }
    });
    $('#cabinet-login').on('shown.bs.popover', function () {
        $('input[name=phone],input[name="LoginForm[phone]"],input[name="User[phone]"],input[name="Mastak[phone]"], .popover-content input[name="LoginForm[phone]"]').mask("(999) 999-99-99");
    });

});