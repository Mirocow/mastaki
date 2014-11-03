/**
 * Created by slashman on 28.10.14.
 */
$(document).ready(function(){
    $('i[data-toggle=tooltip]').tooltip();
    $('input[name=phone]').mask("(999) 999-99-99");
});