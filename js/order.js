$(document).ready(function () {
    $('#orders-filter').change(function(){
        var string = $('#orders-filter').val();
        $.post( Yii.app.createUrl('admin/ajaxGetOrders'),
            {
                filter: string
            })
            .done(function(response){filter(response)});

    });
    $('#do-filter').click(function(e){
        var string = $('#orders-filter').val();
        doFiltration(string);

    });
    $('.order-short').on('click', function(){
        orderShortClick($(this));
    });
    $(document).on('click', 'button.add-problem', function(){
        var orderId = $('table.order-details-table').attr('order-id');

        var data = {
            orderId: orderId,
            problemId: $('select.new-problem-select').val()
        };

        $.post( Yii.app.createUrl('order/ajaxAddProblemToOrder'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){problemAdded(response)});

    });
    $(document).on('click', '.save-order', function(){

        var problemStatuses = [];
        var orderId = $(this).attr('order-id');

        var tbody = $('table[order-id=' + orderId + ']');


        $(tbody.find('.problem-status-select')).each(function(){
            var orderProblemId = $(this).attr('order-problem-id');

            problemStatuses.push({
                status: $(this).val(),
                discount: $('tr[order-problem-id=' + orderProblemId +'] input.discount').val(),
                id: orderProblemId
            });
        });

        var orderStatus = tbody.find('#orderStatus').val();
        var discount = tbody.find('.discount').val();

        var data = {
            orderId: orderId,
            problemStatuses: problemStatuses,
            orderStatus: orderStatus
        };


        $.post( Yii.app.createUrl('order/ajaxSaveOrder'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){orderSaved(response)});
    });
});

function orderSaved(data)
{
    data = JSON.parse(data);

    if(data.result == 'SUCCESS')
    {
        $('table[order-id=' + data.orderId + '] span.price').text(data.newPrice);
        $('table[order-id=' + data.orderId + '] span.total-discount').text(data.newDiscount);
        $('table[order-id=' + data.orderId + '] a.save-order').attr('disabled', 'disabled').removeClass('btn-success').addClass('btn-default');
        doFiltration($('#orders-filter').val());
    }
}

function problemAdded(data)
{
    data = JSON.parse(data);
    $('td.main-td').attr('rowspan', parseInt($('td.main-td').attr('rowspan')) + 1);
    var html = '<tr class="problem-row" order-problem-id="' + data.problemId + '"><td>' + data.position + '</td><td>' + data.device + '</td><td>' + data.name + '</td><td>' + data.price + '</td><td>' + data.discount + '</td><td>' + data.status + '</td></tr>';

    $('table.order-details-table tr.problem-row:last').after(html);
}

function orderDetails(data)
{
    data = JSON.parse(data);
    $('.order-table-container').html(data.output);

    drawProblemsDropdown(data.problems);

    $('.problem-status-select,.order-status-select,.discount').change(function(){
        $('table.order-details-table a.save-order').removeAttr('disabled').removeClass('btn-default').addClass('btn-success');
    });
}

function orderShortClick(order)
{
    $.get( Yii.app.createUrl('order/ajaxGetOrder'),
        {
            id: order.attr('order-id')
        })
        .done(function(response){orderDetails(response)});
}

function doFiltration(string)
{

    $.post( Yii.app.createUrl('order/ajaxGetOrders'),
        {
            filter: string,
            status: $('#select-orders-status').val()
        })
        .done(function(response){$('.orders-table-container').html(response)});
}

function drawProblemsDropdown(problems)
{
    var html = '<button class="btn btn-warning add-problem col-md-2">Добавить работу</button>';
    html += '<div class="col-md-10"><select class="form-control col-md-10 new-problem-select">';
    $.each(problems, function(key, value){
        html += '<option value="' + key + '">' + value + '</option>';
    });
    html += '</select></div>';
    $('#problems-dropdown-container').html(html);
}