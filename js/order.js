$(document).ready(function () {
    $('#orders-filter').change(function(){
        var string = $('#orders-filter').val();
        $.post( Yii.app.createUrl('admin/ajaxGetOrders'),
            {
                filter: string
            })
            .done(function(response){filter(response)});

    });
    $('button#do-filter').click(function(){
        var string = $('#orders-filter').val();
        doFiltration(string);
    });
    $('.order-short').click(function(){
        orderShortClick($(this));
    });

});

function orderSaved(data)
{
    //alert(data);
    data = JSON.parse(data);

    if(data.result == 'SUCCESS')
    {
        $('table[order-id=' + data.orderId + '] span.price').text(data.newPrice);
        $('table[order-id=' + data.orderId + '] a.save-order').attr('disabled', 'disabled').removeClass('btn-success').addClass('btn-default');
        doFiltration($('#orders-filter').val());
    }
}

function filter(data)
{
    data = JSON.parse(data);
    var html = '';
    $(data).each(function(){
        var order = $(this);
        order = order[0];
        html += '<tr order-id="' + order.id + '" class="order-short"><td>' + order.id + '</td><td>' + order.name + '</td><td>' + getOrderStatus(order.status) + '</td></tr>';
    });

    $('tbody#orders-tbody').html(html);
    $('.order-short').click(function(){
        orderShortClick($(this));
    });
}

function orderDetails(data)
{
    $('.order-table-container').html(data);
    $('.problem-status-select,.order-status-select,.discount').change(function(){
        $(this).parent().parent().parent().find('a.save-order').removeAttr('disabled').removeClass('btn-default').addClass('btn-success');
    });
    $('.save-order').click(function(){

        var problemStatuses = [];
        var orderId = $(this).attr('order-id');

        var tbody = $('table[order-id=' + orderId + ']');


        $(tbody.find('.problem-status-select')).each(function(){
            problemStatuses.push({
                status: $(this).val(),
                id: $(this).attr('order-problem-id')});
        });

        var orderStatus = tbody.find('#orderStatus').val();
        var discount = tbody.find('.discount').val();

        var data = {
            orderId: orderId,
            discount: discount,
            problemStatuses: problemStatuses,
            orderStatus: orderStatus
        };


        $.post( Yii.app.createUrl('admin/ajaxSaveOrder'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){orderSaved(response)});
    });
}

function orderShortClick(order)
{
    $.get( Yii.app.createUrl('admin/ajaxGetOrder'),
        {
            id: order.attr('order-id')
        })
        .done(function(response){orderDetails(response)});
}

function doFiltration(string)
{

    $.post( Yii.app.createUrl('admin/ajaxGetOrders'),
        {
            filter: string
        })
        .done(function(response){filter(response)});
}