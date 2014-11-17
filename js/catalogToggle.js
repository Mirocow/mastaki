$(document).ready(function(){
    $(document).on('click', '.problem-categories-list .fa-toggle-on, .problem-categories-list .fa-toggle-off', function(){
        var toggler = $(this);
        var problemCategoryId = $(this).parent().find('span').attr('problem-category-id');
        var deviceId = $('.devices-list li.bg-info span').attr('device-id');
        var active = false;

        if($(this).hasClass('fa-toggle-on'))
            active = true;

        $.post( Yii.app.createUrl('ajax/toggle'),
            {
                problemCategoryId: problemCategoryId,
                deviceId: deviceId,
                action: 'problemCategory'
            })
            .done(function(response){
                if(active)
                {
                    $(toggler).removeClass('fa-toggle-on text-success');
                    $(toggler).addClass('fa-toggle-off text-mute');
                    $('.breakdowns-list .fa').removeClass('fa-toggle-on text-success');
                    $('.problems-list .fa').removeClass('fa-toggle-on text-success');
                    $('.breakdowns-list .fa').addClass('fa-toggle-off text-mute');
                    $('.problems-list .fa').addClass('fa-toggle-off text-mute');
                }
                else
                {
                    $(toggler).removeClass('fa-toggle-off text-mute');
                    $(toggler).addClass('fa-toggle-on text-success');
                }
            });
    });
    $(document).on('click', '.device-types-list .fa-toggle-on, .device-types-list .fa-toggle-off', function(){
        var toggler = $(this);
        var deviceTypeId = $(this).parent().find('span').attr('device-type-id');
        var active = false;

        if($(this).hasClass('fa-toggle-on'))
            active = true;

        $.post( Yii.app.createUrl('ajax/toggle'),
            {
                deviceTypeId: deviceTypeId,
                action: 'deviceType'
            })
            .done(function(response){
                if(active)
                {
                    $(toggler).removeClass('fa-toggle-on text-success');
                    $(toggler).addClass('fa-toggle-off text-mute');
                }
                else
                {
                    $(toggler).removeClass('fa-toggle-off text-mute');
                    $(toggler).addClass('fa-toggle-on text-success');
                }
            });
    });
    $(document).on('click', '.manufacturers-list .fa-toggle-on, .manufacturers-list .fa-toggle-off', function(){
        var toggler = $(this);
        var manufacturerId = $(this).parent().find('span').attr('manufacturer-id');
        var active = false;

        if($(this).hasClass('fa-toggle-on'))
            active = true;

        $.post( Yii.app.createUrl('ajax/toggle'),
            {
                manufacturerId: manufacturerId,
                action: 'manufacturer'
            })
            .done(function(response){
                if(active)
                {
                    $(toggler).removeClass('fa-toggle-on text-success');
                    $(toggler).addClass('fa-toggle-off text-mute');
                }
                else
                {
                    $(toggler).removeClass('fa-toggle-off text-mute');
                    $(toggler).addClass('fa-toggle-on text-success');
                }
            });
    });
    $(document).on('click', '.devices-list .fa-toggle-on, .devices-list .fa-toggle-off', function(){
        var toggler = $(this);
        var deviceId = $(this).parent().find('span').attr('device-id');
        var active = false;

        if($(this).hasClass('fa-toggle-on'))
            active = true;

        $.post( Yii.app.createUrl('ajax/toggle'),
            {
                deviceId: deviceId,
                action: 'device'
            })
            .done(function(response){
                if(active)
                {
                    $(toggler).removeClass('fa-toggle-on text-success');
                    $(toggler).addClass('fa-toggle-off text-mute');
                }
                else
                {
                    $(toggler).removeClass('fa-toggle-off text-mute');
                    $(toggler).addClass('fa-toggle-on text-success');
                }
            });
    });
    $(document).on('click', '.problems-list .fa-toggle-on, .problems-list .fa-toggle-off', function(){
        if($('.problem-categories-list li.bg-info i').hasClass('fa-toggle-on'))
        {
            var toggler = $(this);
            var deviceId = $('.devices-list li.bg-info span').attr('device-id');
            var problemId = $(this).parent().find('span').attr('problem-id');
            var active = false;

            if($(this).hasClass('fa-toggle-on'))
                active = true;

            $.post( Yii.app.createUrl('ajax/toggle'),
                {
                    deviceId: deviceId,
                    problemId: problemId,
                    action: 'problem'
                })
                .done(function(response){
                    if(active)
                    {
                        $(toggler).removeClass('fa-toggle-on text-success');
                        $(toggler).addClass('fa-toggle-off text-mute');
                    }
                    else
                    {
                        $(toggler).removeClass('fa-toggle-off text-mute');
                        $(toggler).addClass('fa-toggle-on text-success');
                    }
                });
        }
    });
    $(document).on('click', '.breakdowns-list .fa-toggle-on, .breakdowns-list .fa-toggle-off', function(){
        if($('.problem-categories-list li.bg-info i').hasClass('fa-toggle-on')) {
            var toggler = $(this);
            var deviceId = $('.devices-list li.bg-info span').attr('device-id');
            var problemId = $(this).parent().find('span').attr('breakdown-id');
            var active = false;

            if ($(this).hasClass('fa-toggle-on'))
                active = true;

            $.post(Yii.app.createUrl('ajax/toggle'),
                {
                    deviceId: deviceId,
                    problemId: problemId,
                    action: 'problem'
                })
                .done(function (response) {
                    if (active) {
                        $(toggler).removeClass('fa-toggle-on text-success');
                        $(toggler).addClass('fa-toggle-off text-mute');
                    }
                    else {
                        $(toggler).removeClass('fa-toggle-off text-mute');
                        $(toggler).addClass('fa-toggle-on text-success');
                    }
                });
        }
    });
});