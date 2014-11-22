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
        });
    });

    $('.clients-container tr').click(function(){
        var clientId = $(this).attr('client-id');

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
            });
        $.post( Yii.app.createUrl('ajax/clientOrders'),
            {
                id:clientId
            })
            .done(function(response){
                $('.orders-table-container').html(response);
            });
    })

});