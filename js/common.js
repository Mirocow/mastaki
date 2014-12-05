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
    $('input[name=phone],input[name="LoginForm[phone]"],input[name="User[phone]"],input[name="Mastak[phone]"]').mask("(999) 999-99-99");
});