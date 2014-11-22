/**
 * Created by slashman on 13.11.14.
 */


$(document).ready(function(){
    $(document).on('click', '.device-types-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('device-type-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            id: id,
            action: 'deviceType'
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
    $(document).on('click', '.manufacturers-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('manufacturer-id');
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            deviceTypeId: deviceTypeId,
            id: id,
            action: 'manufacturer'
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
    $(document).on('click', '.devices-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('device-id');
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var manufacturerId = $('.manufacturers-list .bg-info span').attr('manufacturer-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            deviceTypeId: deviceTypeId,
            manufacturerId: manufacturerId,
            id: id,
            action: 'device'
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
