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
        var value = $('#device-type-input').val();

        var data = {
            action: 'deviceType',
            value: value
        };


        var form = new FormData($('#device-type-form')[0]);


        /*$.post( Yii.app.createUrl('ajax/addElement'),
            {
                data: JSON.stringify(data),
                file: form
            })
            .done(function(response){
                response = JSON.parse(response);
                var html = '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-type-id="' + response.id + '" class="device-type-li">' + response.name + '</span></li>';
                if($('.device-types-list li').length !== 0)
                    $('.device-types-list li:last').after(html);
                else
                    $('.device-types-list').html(html);
            });
         */

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

            document.getElementById('device-type-icon-file').innerHTML = document.getElementById('device-type-icon-file').innerHTML;

            var html = '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-type-id="' + response.id + '" class="device-type-li">' + response.name + '</span></li>';
            if ($('.device-types-list li').length !== 0)
                $('.device-types-list li:last').after(html);
            else
                $('.device-types-list').html(html);
        });
    });

    $('#add-manufacturer').click(function(){
        var value = $('#manufacturer-input').val();
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');

        var data = {
            action: 'manufacturer',
            deviceTypeId: deviceTypeId,
            value: value
        };

        $.post( Yii.app.createUrl('ajax/addElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                response = JSON.parse(response);
                var html = '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span manufacturer-id="' + response.id + '" class="manufacturer-li">' + response.name + '</span></li>';
                if($('.manufacturers-list li').length !== 0)
                    $('.manufacturers-list li:last').after(html);
                else
                    $('.manufacturers-list').html(html);
            });
    });
    $('#add-device').click(function(){
        var value = $('#device-input').val();
        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var manufacturerId = $('.manufacturers-list .bg-info span').attr('manufacturer-id');

        var data = {
            action: 'device',
            deviceTypeId: deviceTypeId,
            manufacturerId: manufacturerId,
            value: value
        };

        $.post( Yii.app.createUrl('ajax/addElement'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){
                response = JSON.parse(response);
                var html = '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-id="' + response.id + '" class="device-li">' + response.name + '</span></li>';
                if($('.devices-list li').length !== 0)
                    $('.devices-list li:last').after(html);
                else
                    $('.devices-list').html(html);
            });
    });

    $(document).on('click', '.device-type-li', function(){
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
    $(document).on('click', '.manufacturer-li',  function(){
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

        $('.devices-list').html('');

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
}
