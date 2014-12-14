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
            problemItem.parent().addClass('list-group-item-info', 300, "swing").css('background-color', "#c7e894");
            problemItem.parent().find('i.details-arrow').css('background-color', '#FFFFFF');
        }
        else
        {
            orderedProblems.splice(position, 1);
            problemItem.parent().removeClass('list-group-item-info', 300, "swing" ).css('background-color', "white");
            problemItem.parent().find('i.details-arrow').css('background-color', '#D4E3EF');
        }

        if(orderedProblems.length > 0)
            $('#order-btn').removeAttr('disabled');
        else
            $('#order-btn').attr('disabled', 'disabled');
    });

    $('#order-btn').click(function(){
        $('#phone-input').removeClass('has-error', 300, "swing" );
        $('#name-input').removeClass('has-error', 300, "swing" );

        var data = {
            orderedProblems: orderedProblems,
            phone: $('input[name=phone]').val(),
            name: $('input[name=name]').val(),
            date: $('input[name=date]').val()
        };

        $.post( Yii.app.createUrl('order/createOrder'),
            {
                data: JSON.stringify(data)
            })
            .done(function(data){orderCreated(data)});
    });

    $('#form-message-close').click(function(){
        $('#form-message').hide(500);
        $('#form-div').show(500);
    });
});

function orderCreated(data)
{
    data = JSON.parse(data);

    if(data.result == 'SUCCESS')
    {
        orderedProblems = [];
        $('#order-btn').attr('disabled', 'disabled');
        $('.problem-item').parent().removeClass('list-group-item-info', 300, "swing" );

        if(data.userPhone != null && data.userPassword != null && data.orderId != null)
        {
            $('#additional-message').html('Номер телефона:' + data.userPhone + ' Пароль:' + data.userPassword + ' № Заказа: ' + data.orderId);
        }
        else if(data.orderId != null)
        {
            $('#additional-message').html('№ Заказа: ' + data.orderId);
        }

        $('#form-div').hide(500);
        $('#form-message').show(500);
    }
    if(data.result == 'ERROR')
    {
        if(data.errorPhone == 1)
        {
            $('#phone-input').addClass('has-error', 300, "easeOutBack" );
        }
        if(data.errorName == 1)
        {
            $('#name-input').addClass('has-error', 300, "easeOutBack" );
        }
    }
}