$(document).ready(function(){

    $('#save-device-type').click(function(){
        var form = new FormData($('#device-type-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/saveElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            $('.device-types-list .bg-info span').text($('#device-type-input').val());
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
                $('.manufacturers-list .bg-info span').text($('#manufacturer-input').val());
            });
    });
    $('#save-device').click(function(){
        var form = new FormData($('#device-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/saveElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            $('.devices-list .bg-info span').text($('#device-input').val());
        });
    });
    $('#delete-device-type').click(function(){
        if (confirm('Удалить?')) {
            var id = $('.device-types-list .bg-info span').attr('device-type-id');

            var data = {
                action: 'deviceType',
                id: id
            };

            $.post( Yii.app.createUrl('ajax/deleteElement'),
                {
                    data: JSON.stringify(data)
                })
                .done(function(response){
                    response = JSON.parse(response);

                    if(response.result == 'OK')
                        $('.device-types-list .bg-info').remove();
                    if(response.result == 'ERROR')
                        alert('Ошибка');
                    if(response.result == 'NOT_EMPTY')
                        alert('Категория должна быть пустой');
                });
        } else {
            // Do nothing!
        }
    });
    $('#delete-manufacturer').click(function(){
        if (confirm('Удалить?')) {
            var id = $('.manufacturers-list .bg-info span').attr('manufacturer-id');

            var data = {
                action: 'manufacturer',
                id: id
            };

            $.post( Yii.app.createUrl('ajax/deleteElement'),
                {
                    data: JSON.stringify(data)
                })
                .done(function(response){
                    response = JSON.parse(response);

                    if(response.result == 'OK')
                        $('.manufacturers-list .bg-info').remove();
                    if(response.result == 'ERROR')
                        alert('Ошибка');
                    if(response.result == 'NOT_EMPTY')
                        alert('Категория должна быть пустой');
                });
        } else {
            // Do nothing!
        }
    });

    $('#delete-device').click(function(){
        if (confirm('Удалить?')) {
            var id = $('.devices-list .bg-info span').attr('device-id');

            var data = {
                action: 'device',
                id: id
            };

            $.post( Yii.app.createUrl('ajax/deleteElement'),
                {
                    data: JSON.stringify(data)
                })
                .done(function(response){
                    response = JSON.parse(response);

                    if(response.result == 'OK')
                        $('.devices-list .bg-info').remove();
                    if(response.result == 'ERROR')
                        alert('Ошибка');
                });
        } else {
            // Do nothing!
        }
    });

    $('#add-device-type').click(function(){
        var form = new FormData($('#device-type-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/addElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            response = JSON.parse(response);

            var html = '<li><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span device-type-id="' + response.id + '" class="device-type-li">' + response.name + '</span></li>';
            if ($('.device-types-list li').length !== 0)
                $('.device-types-list li:last').after(html);
            else
                $('.device-types-list').html(html);
        });
    });

    $('#add-manufacturer').click(function(){
        var value = $('#manufacturer-input').val();
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');

        $.post( Yii.app.createUrl('ajax/addElement'),
            {
                action: 'manufacturer',
                deviceTypeId: deviceTypeId,
                value: value
            })
            .done(function(response){
                response = JSON.parse(response);
                var html = '<li><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span manufacturer-id="' + response.id + '" class="manufacturer-li">' + response.name + '</span></li>';
                if($('.manufacturers-list li').length !== 0)
                    $('.manufacturers-list li:last').after(html);
                else
                    $('.manufacturers-list').html(html);
            });
    });
    $('#add-device').click(function(){
        var form = new FormData($('#device-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/addElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            response = JSON.parse(response);

            var html = '<li><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span device-id="' + response.id + '" class="device-li">' + response.name + '</span></li>';
            if ($('.devices-list li').length !== 0)
                $('.devices-list li:last').after(html);
            else
                $('.devices-list').html(html);
        });
    });

    $(document).on('click', '.device-type-li', function(){

        $('input[name="deviceTypeId"], #deviceTypeIdHidden').val($(this).attr('device-type-id'));

        var deviceTypeId = $(this).attr('device-type-id');

        $('.device-type-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('#device-type-input').val($(this).text());

        clearIconFile();
        getDeviceTypeImage(deviceTypeId);

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
    $(document).on('click', '.manufacturer-li',  function(){

        $('input[name="manufacturerId"]').val($(this).attr('manufacturer-id'));

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
    $(document).on('click', '.device-li', function(){
        $('.device-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('input#deviceIdHidden').val($(this).attr('device-id'));

        clearImageFile();
        getDeviceImage($(this).attr('device-id'));

        $('#device-input').val($(this).text());
    });
});

function updateDevices(data)
{
    data = JSON.parse(data);

    var html = '';
    var first = true;

    if(data.action == 'deviceType')
    {
        $('.manufacturers-list').html('');
        $('.devices-list').html('');

        $.each(data.manufacturers, function(id, manufacturer){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span manufacturer-id="' + manufacturer.id + '" class="manufacturer-li">' + manufacturer.name + '</span></li>';

            first = false;
        });
        $('.manufacturers-list').html(html);
        resetManufacturers();

        html = '';
        first = true;
        $.each(data.devices, function(id, device){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span image="' + device.image + '" device-id="' + device.id + '" class="device-li">' + device.name + '</span></li>';

            first = false;
        });
        $('.devices-list').html(html);
        resetDevices();
    }
    if(data.action == 'manufacturer')
    {
        html = '';
        first = true;

        $('.devices-list').html('');

        $.each(data.devices, function(id, device){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span image="' + device.image + '" device-id="' + device.id + '" class="device-li">' + device.name + '</span></li>';

            first = false;
        });
        $('.devices-list').html(html);
        resetDevices();
    }
}

function resetDevices()
{
    if($('.devices-list li.bg-info').length > 0)
    {
        $('#device-input').val($('.devices-list li.bg-info span').text());
    }
}
function resetManufacturers()
{
    if($('.manufacturers-list li.bg-info').length > 0)
    {
        $('#manufacturer-input').val($('.manufacturers-list li.bg-info span').text());
    }
}
function clearIconFile()
{
    var fileField = $('#device-type-icon-file');
    fileField.replaceWith( fileField = fileField.clone( true ) );
    $('#device-type-icon-file-preview').removeAttr('src').addClass('hidden');
}
function clearImageFile()
{
    var fileField = $('#device-image-file');
    fileField.replaceWith( fileField = fileField.clone( true ) );
    $('#device-image-file-preview').removeAttr('src').addClass('hidden');
}
function getDeviceTypeImage(id)
{

    var data = {
        id: id,
        action: 'deviceType'
    };

    $.post( Yii.app.createUrl('ajax/getImage'),
        {
            data: JSON.stringify(data)
        })
        .done(function(response){
            response = JSON.parse(response);
            if(typeof response.src !== 'undefined')
                $('#device-type-icon-file-preview').attr('src', response.src).removeClass('hidden');
        });
}
function getDeviceImage(id)
{

    var data = {
        id: id,
        action: 'device'
    };

    $.post( Yii.app.createUrl('ajax/getImage'),
        {
            data: JSON.stringify(data)
        })
        .done(function(response){
            response = JSON.parse(response);
            if(typeof response.src !== 'undefined')
                $('#device-image-file-preview').attr('src', response.src).removeClass('hidden');
        });
}