/**
 * Created by slashman on 14.11.14.
 */

$(document).ready(function(){
    $(document).on('click', '.problem-categories-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('problem-category-id');
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            id: id,
            deviceTypeId: deviceTypeId,
            action: 'problemCategory'
        };


        $.post( Yii.app.createUrl('ajax/sortElement'),
            {
                data: JSON.stringify(data)
            }).done(function(response){
                response = JSON.parse(response);
                if(typeof response.result !== 'undefined')
                {
                    if(response.result == 'OK')
                    {
                        var liToMove = arrow.parent();
                        var liToReplace;
                        if(direction == 'up')
                            liToReplace = $(liToMove).prev();
                        else
                            liToReplace = $(liToMove).next();

                        $(liToMove).swap($(liToReplace));
                    }
                }
            });
    });
    $(document).on('click', '.breakdowns-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('breakdown-id');
        var problemCategoryId = $('.problem-categories-list .bg-info span').attr('problem-category-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            problemCategoryId: problemCategoryId,
            id: id,
            action: 'breakdown'
        };

        $.post( Yii.app.createUrl('ajax/sortElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                response = JSON.parse(response);
                if(typeof response.result !== 'undefined')
                {
                    if(response.result == 'OK')
                    {
                        var liToMove = arrow.parent();
                        var liToReplace;
                        if(direction == 'up')
                            liToReplace = $(liToMove).prev();
                        else
                            liToReplace = $(liToMove).next();

                        $(liToMove).swap($(liToReplace));
                    }
                }
            });
    });
    $(document).on('click', '.problems-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('problem-id');
        var problemCategoryId = $('.problem-categories-list .bg-info span').attr('problem-category-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            problemCategoryId: problemCategoryId,
            id: id,
            action: 'problem'
        };

        $.post( Yii.app.createUrl('ajax/sortElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                response = JSON.parse(response);
                if(typeof response.result !== 'undefined')
                {
                    if(response.result == 'OK')
                    {
                        var liToMove = arrow.parent();
                        var liToReplace;
                        if(direction == 'up')
                            liToReplace = $(liToMove).prev();
                        else
                            liToReplace = $(liToMove).next();

                        $(liToMove).swap($(liToReplace));
                    }
                }
            });
    });
});