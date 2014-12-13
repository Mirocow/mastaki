$(document).ready(function(){
    $('#save-client').click(function(e){

        var form = new FormData($('#client-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/saveClient'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            var tr = $('tr.client-row[client-id="' + $('#clientId').val() + '"]');
            tr.find('td:eq(1)').text($('#name-input').val());
            tr.find('td:eq(2)').text($('#phone-input').val());
            tr.find('td:eq(4)').text($('#discount-input').val());
        });
    });

    $('.clients-container tr').click(function(){
        var clientId = $(this).attr('client-id');
        $('#clientId').val(clientId);

        $.post( Yii.app.createUrl('ajax/clientInfo'),
            {
                id:clientId
            })
            .done(function(response){
                response = JSON.parse(response);

                $('#name-input').val(response.name);
                $('#phone-input').val(response.phone);
                $('#email-input').val(response.email);
                $('#address-input').val(response.address);
                $('#discount-input').val(response.discount);
                $('#clientId').val(response.id);
            });
        $.post( Yii.app.createUrl('ajax/clientOrders'),
            {
                id:clientId
            })
            .done(function(response){
                $('.orders-table-container').html(response);
            });
    });

    $('#sendSms').click(function(){
        var content = $('#smsContent').val();
        $.post( Yii.app.createUrl('ajax/sendSms'),
            {
                id:$('#clientId').val(),
                message: content
            })
            .done(function(response){
                alert("Ваше сообщение отправлено!");
            });

    });

});