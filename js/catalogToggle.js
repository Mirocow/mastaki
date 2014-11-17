$(document).ready(function(){
    $(document).on('click', '.problem-categories-list .fa-toggle-on, .problem-categories-list .fa-toggle-off', function(){
        var problemCategoryId = $(this).parent().find('span').attr('problem-category-id');
        var active = false;

        if($(this).hasClass('fa-toggle-on'))
            active = true;

        $.post( Yii.app.createUrl('ajax/toggle'),
            {
                id: problemCategoryId
            })
            .done(function(response){
                response = JSON.parse(response);
                if(active)
                {
                    $(this).removeClass('fa-toggle-on text-success');
                    $(this).addClass('fa-toggle-off text-mute');
                    $('.breakdowns-list .fa').removeClass('fa-toggle-on text-success');
                    $('.problems-list .fa').removeClass('fa-toggle-on text-success');
                    $('.breakdowns-list .fa').addClass('fa-toggle-off text-mute');
                    $('.problems-list .fa').addClass('fa-toggle-off text-mute');
                }
                else
                {
                    $(this).removeClass('fa-toggle-off text-mute');
                    $(this).addClass('fa-toggle-on text-success');
                }
            });
        //updatePrices();
    });
});