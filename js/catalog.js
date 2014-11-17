$(document).ready(function(){
    $(document).on('click', '.device-type-li', function(){

        $('input[name="deviceTypeId"], #deviceTypeIdHidden').val($(this).attr('device-type-id'));

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
    $(document).on('click', '.device-type-li', function(){

        $('input[name="deviceTypeId"], #deviceTypeIdHidden').val($(this).attr('device-type-id'));

        var deviceTypeId = $(this).attr('device-type-id');

        $('.device-type-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        var data = {
            deviceTypeId: deviceTypeId,
            action: 'servicesDeviceType'
        };

        $.post( Yii.app.createUrl('ajax/getDevices'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){updateServices(response)});
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

        $('#device-input').val($(this).text());
        updatePrices();
    });
    $(document).on('click', '.problem-category-li',  function(){

        $('input[name="problemCategoryId"]').val($(this).attr('problem-category-id'));
        $('#problemCategoryIdHidden').val($(this).attr('problem-category-id'));

        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var problemCategoryId = $(this).attr('problem-category-id');

        $('.problem-category-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('#problem-category-input').val($(this).text());

        var data = {
            deviceTypeId: deviceTypeId,
            problemCategoryId: problemCategoryId,
            action: 'problemCategory'
        };

        $.post( Yii.app.createUrl('ajax/getDevices'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){updateServices(response)});

        updatePrices();
    });
    $(document).on('click', '.breakdown-li', function(){
        $('.breakdown-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('input#breakdownIdHidden').val($(this).attr('breakdown-id'));

        $('#breakdown-input').val($(this).text());

        $.post( Yii.app.createUrl('ajax/getProblemDescription'),
            {
                id: $(this).attr('breakdown-id')
            })
            .done(function(response){
                response = JSON.parse(response);
                $('#breakdown-description-input').val(response.desc);
            });
        updatePrices();
    });
    $(document).on('click', '.problem-li', function(){
        $('.problem-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('input#problemIdHidden').val($(this).attr('problem-id'));

        $('#problem-input').val($(this).text());

        $.post( Yii.app.createUrl('ajax/getProblemDescription'),
            {
                id: $(this).attr('problem-id')
            })
            .done(function(response){
                response = JSON.parse(response);
                $('#problem-description-input').val(response.desc);
            });
        updatePrices();
    });
    $('#breakdown-price-save').click(function(){
        var problemId = $('.breakdowns-list .bg-info span').attr('breakdown-id');
        var deviceId = $('.devices-list .bg-info span').attr('device-id');
        var partPrice = $('#breakdown-part-price').val();
        var price = $('#breakdown-work-price').val();

        var data = {
            problemId: problemId,
            deviceId: deviceId,
            partPrice: partPrice,
            price: price
        };

        $.post( Yii.app.createUrl('ajax/savePrice'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){});
    });
    $('#problem-price-save').click(function(){
        var problemId = $('.problems-list .bg-info span').attr('problem-id');
        var deviceId = $('.devices-list .bg-info span').attr('device-id');
        var partPrice = $('#problem-part-price').val();
        var price = $('#problem-work-price').val();

        var data = {
            problemId: problemId,
            deviceId: deviceId,
            partPrice: partPrice,
            price: price
        };

        $.post( Yii.app.createUrl('ajax/savePrice'),
            {
                data: JSON.stringify(data)
            })
            .done(function(response){});
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

            html += '<span manufacturer-id="' + manufacturer.id + '" class="manufacturer-li">' + manufacturer.name + '</span></li>';

            first = false;
        });
        $('.manufacturers-list').html(html);

        html = '';
        first = true;
        $.each(data.devices, function(id, device){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<span image="' + device.image + '" device-id="' + device.id + '" class="device-li">' + device.name + '</span></li>';

            first = false;
        });
        $('.devices-list').html(html);
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

            html += '<span image="' + device.image + '" device-id="' + device.id + '" class="device-li">' + device.name + '</span></li>';

            first = false;
        });
        $('.devices-list').html(html);
    }
    updatePrices();
}

function updateServices(data)
{
    data = JSON.parse(data);

    var html = '';
    var first = true;

    if(data.action == 'servicesDeviceType')
    {
        $('.problem-categories-list').html('');
        $('.breakdowns-list').html('');
        $('.problems-list').html('');

        $.each(data.problemCategories, function(id, problemCategory){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<span problem-category-id="' + problemCategory.id + '" class="problem-category-li">' + problemCategory.name + '</span></li>';

            first = false;
        });
        $('.problem-categories-list').html(html);
        resetProblemCategories();

        html = '';
        first = true;
        $.each(data.breakdowns, function(id, breakdown){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<span breakdown-id="' + breakdown.id + '" class="breakdown-li">' + breakdown.name + '</span></li>';

            first = false;
        });
        $('.breakdowns-list').html(html);
        resetBreakdowns();

        html = '';
        first = true;
        $.each(data.problems, function(id, problem){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<span problem-id="' + problem.id + '" class="problem-li">' + problem.name + '</span></li>';

            first = false;
        });
        $('.problems-list').html(html);
        resetProblems();
    }
    if(data.action == 'problemCategory')
    {
        html = '';
        first = true;
        $.each(data.breakdowns, function(id, breakdown){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<span breakdown-id="' + breakdown.id + '" class="breakdown-li">' + breakdown.name + '</span></li>';

            first = false;
        });
        $('.breakdowns-list').html(html);
        resetBreakdowns();

        html = '';
        first = true;
        $.each(data.problems, function(id, problem){
            if(first)
                html += '<li class="bg-info">';
            else
                html += '<li>';

            html += '<span problem-id="' + problem.id + '" class="problem-li">' + problem.name + '</span></li>';

            first = false;
        });
        $('.problems-list').html(html);
        resetProblems();
    }
    updatePrices();
}

function updatePrices()
{
    var deviceId = $('.devices-list .bg-info span').attr('device-id');
    var problemId = $('.problems-list .bg-info span').attr('problem-id');
    var breakdownId = $('.breakdowns-list .bg-info span').attr('breakdown-id');

    var data = {
        deviceId: deviceId,
        problemId: problemId,
        breakdownId: breakdownId
    };

    $.post( Yii.app.createUrl('ajax/getPrices'),
        {
            data: JSON.stringify(data)
        })
        .done(function(response){

            response = JSON.parse(response);

            $('#breakdown-part-price').val('');
            $('#problem-part-price').val('');
            $('#breakdown-work-price').val('');
            $('#problem-work-price').val('');

            if(typeof response.breakdown !== 'undefined')
            {
                $('#breakdown-part-price').val(response.breakdown.partPrice);
                $('#breakdown-work-price').val(response.breakdown.price);
            }
            if(typeof response.problem !== 'undefined')
            {
                $('#problem-part-price').val(response.problem.partPrice);
                $('#problem-work-price').val(response.problem.price);
            }

        });
}




function resetProblemCategories()
{
    if($('.problem-categories-list li.bg-info').length > 0)
    {
        $('#problem-category-input').val($('.problem-categories-list li.bg-info span').text());
    }
}
function resetBreakdowns()
{
    if($('.breakdowns-list li.bg-info').length > 0)
    {
        $('#breakdown-input').val($('.breakdowns-list li.bg-info span').text());
    }
}
function resetProblems()
{
    if($('.problems-list li.bg-info').length > 0)
    {
        $('#problem-input').val($('.problems-list li.bg-info span').text());
    }
}