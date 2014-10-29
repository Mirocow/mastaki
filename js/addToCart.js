/**
 * Created by slashman on 29.10.14.
 */


var orderedProblems = [];

$(document).ready(function () {

    $('.problem-item').click(function(){
        var problemItem = $(this);
        var problemId = problemItem.attr('problem-id');
        var position = $.inArray(problemId, orderedProblems);

        if (position == -1)
        {
            orderedProblems.push(problemId);
            problemItem.parent().addClass('list-group-item-info', 300, "swing" );
        }
        else
        {
            orderedProblems.splice(position, 1);
            problemItem.parent().removeClass('list-group-item-info', 300, "swing" );
        }

        if(orderedProblems.length > 0)
            $('#order-btn').parent().parent().parent().removeClass('hidden');
        else
            $('#order-btn').parent().parent().parent().addClass('hidden');
    });

    $('#order-btn').click(function(){
        var data = {
            orderedProblems: orderedProblems,
            phone: $('input[name=phone]').val(),
            name: $('input[name=name]').val()
        };

        $.post( Yii.app.createUrl('order/createOrder'),
            {
                data: JSON.stringify(data)
            })
            .done(function(data){orderCreated(data)});
    });
});

function orderCreated(response)
{
    alert(response);
}