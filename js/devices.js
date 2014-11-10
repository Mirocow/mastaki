function assignEvents()
{
    $('.device-type-li').click(function(){
        var deviceTypeId = $(this).attr('device-type-id');

        $('.device-type-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('#device-type-input').val($(this).text());

        var data = {
            deviceTypeId: deviceTypeId,
            action: 'deviceType'
        };

        $.post( Yii.app.createUrl('ajax/getDevices'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){updateDevices(response)});
    });
    $('.manufacturer-li').click(function(){
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var manufacturerId = $(this).attr('manufacturer-id');

        $('.manufacturer-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('#manufacturer-input').val($(this).text());

        var data = {
            deviceTypeId: deviceTypeId,
            manufacturerId: manufacturerId,
            action: 'manufacturer'
        };

        $.post( Yii.app.createUrl('ajax/getDevices'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){updateDevices(response)});
    });
    $('.device-li').click(function(){
        $('.device-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('#device-input').val($(this).text());
    });
}

$(document).ready(function(){

    $('#save-device-type').click(function(){
        var id = $('.device-types-list .bg-info span').attr('device-type-id');
        var value = $('#device-type-input').val();

        var data = {
            action: 'deviceType',
            id: id,
            value: value
        };

        $.post( Yii.app.createUrl('ajax/saveElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                $('.device-types-list .bg-info span').text(value);
            });
    });
    $('#save-manufacturer').click(function(){
        var id = $('.manufacturers-list .bg-info span').attr('manufacturer-id');
        var value = $('#manufacturer-input').val();

        var data = {
            action: 'manufacturer',
            id: id,
            value: value
        };

        $.post( Yii.app.createUrl('ajax/saveElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                $('.manufacturers-list .bg-info span').text(value);
            });
    });
    $('#save-device').click(function(){
        var id = $('.devices-list .bg-info span').attr('device-id');
        var value = $('#device-input').val();

        var data = {
            action: 'device',
            id: id,
            value: value
        };

        $.post( Yii.app.createUrl('ajax/saveElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                $('.devices-list .bg-info span').text(value);
            });
    });
    assignEvents();
});

function updateDevices(data)
{
    data = JSON.parse(data);

    var html = '';
    var first = true;

    if(data.action == 'deviceType')
    {
        $.each(data.manufacturers, function(id, name){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span manufacturer-id="' + id + '" class="manufacturer-li">' + name + '</span></li>';

            first = false;
        });
        $('.manufacturers-list').html(html);

        html = '';
        first = true;
        $.each(data.devices, function(id, name){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-id="' + id + '" class="device-li">' + name + '</span></li>';

            first = false;
        });
        $('.devices-list').html(html);
    }
    if(data.action == 'manufacturer')
    {
        html = '';
        first = true;

        $.each(data.devices, function(id, name){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-id="' + id + '" class="device-li">' + name + '</span></li>';

            first = false;
        });
        $('.devices-list').html(html);
    }
    assignEvents();
}
