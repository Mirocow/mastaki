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
        var liToMove = arrow.parent();
        var liToReplace;
        if(direction == 'up')
            liToReplace = $(liToMove).prev();
        else
            liToReplace = $(liToMove).next();

        $(liToMove).swap($(liToReplace));

        //$.post( Yii.app.createUrl('ajax/sortElement'),
        //    {
        //        data: JSON.stringify(data)
        //    })
        //    .done(function(response){
        //        var liToMove = arrow.parent();
        //        if(direction == 'up')
        //            liToMove.prev().after(liToMove);
        //        else
        //            liToMove.next().before(liToMove);
        //    });
    });
    $(document).on('click', '.manufacturers-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('manufacturer-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            id: id,
            action: 'manufacturer'
        };
        var liToMove = arrow.parent();
        var liToReplace;
        if(direction == 'up')
            liToReplace = $(liToMove).prev();
        else
            liToReplace = $(liToMove).next();

        $(liToMove).swap($(liToReplace));

        //$.post( Yii.app.createUrl('ajax/sortElement'),
        //    {
        //        data: JSON.stringify(data)
        //    })
        //    .done(function(response){
        //        var liToMove = arrow.parent();
        //        if(direction == 'up')
        //            liToMove.prev().after(liToMove);
        //        else
        //            liToMove.next().before(liToMove);
        //    });
    });
    $(document).on('click', '.devices-list .move', function(){
        var arrow = $(this);
        var id = $(this).parent().find('span:last').attr('device-id');
        var direction;

        if(arrow.hasClass('up'))
            direction = 'up';
        else
            direction = 'down';

        var data = {
            direction: direction,
            id: id,
            action: 'device'
        };
        var liToMove = arrow.parent();
        var liToReplace;
        if(direction == 'up')
            liToReplace = $(liToMove).prev();
        else
            liToReplace = $(liToMove).next();

        $(liToMove).swap($(liToReplace));

        //$.post( Yii.app.createUrl('ajax/sortElement'),
        //    {
        //        data: JSON.stringify(data)
        //    })
        //    .done(function(response){
        //        var liToMove = arrow.parent();
        //        if(direction == 'up')
        //            liToMove.prev().after(liToMove);
        //        else
        //            liToMove.next().before(liToMove);
        //    });
    });
});