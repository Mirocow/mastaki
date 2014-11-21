/**
 * Created by slashman on 19.11.14.
 */
$(document).ready(function(){
    $('#resume-form #submit-btn').click(function(e){
        e.preventDefault();

        var emptyFields = 0;

        $('#resume-form input[type=text], #resume-form textarea').each(function(){
            if($(this).val() == '')
            {
                emptyFields++;
                $(this).parent().addClass('has-error');
            }

        });


        if (emptyFields > 0)
        {
            $('#messages').html('<div class="row"><div class="alert alert-dismissable alert-danger">Все поля обязательны для заполнения</div></div>');
        }
        else if ($('input.skill-category-checkbox:checked').length == 0 || $('input.skill-checkbox:checked').length == 0)
        {
            $('#messages').html('<div class="row"><div class="alert alert-dismissable alert-danger">Отметьте хотя бы один пункт в меню справа</div></div>');
        }
        else
            $('#resume-form').submit();
    });

    $('.skill-checkbox').change(function(){
        if($(this).is(':checked'))
            $(this).parent().parent().parent().parent().find('input.skill-category-checkbox:first').attr('checked', 'checked');
    })
});