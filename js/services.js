/**
 * Created by slashman on 13.11.14.
 */
$(document).ready(function(){

    $('#save-problem-category').click(function(){
        var form = new FormData($('#problem-category-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/saveElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            $('.problem-categories-list .bg-info span').text($('#problem-category-input').val());
        });
    });
    $('#save-breakdown').click(function(){
        var form = new FormData($('#breakdown-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/saveElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            $('.breakdowns-list .bg-info span').text($('#breakdown-input').val());
        });
    });
    $('#save-problem').click(function(){
        var form = new FormData($('#problem-form')[0]);

        var request = $.ajax({
            url: Yii.app.createUrl('ajax/saveElement'),
            type: "POST",
            processData: false,
            cache: false,
            contentType: false,
            data: form
        });
        request.done(function(response) {
            $('.problems-list .bg-info span').text($('#problem-input').val());
        });
    });
    $('#delete-problem-category').click(function(){
        if (confirm('Удалить?')) {
            var id = $('.problem-categories-list .bg-info span').attr('problem-category-id');

            var data = {
                action: 'problemCategory',
                id: id
            };

            $.post( Yii.app.createUrl('ajax/deleteElement'),
                {
                    data: JSON.stringify(data)
                })
                .done(function(response){
                    response = JSON.parse(response);

                    if(response.result == 'OK')
                        $('.problem-categories-list .bg-info').remove();
                    if(response.result == 'ERROR')
                        alert('Ошибка');
                    if(response.result == 'NOT_EMPTY')
                        alert('Категория должна быть пустой');
                });
        } else {
            // Do nothing!
        }
    });
    $('#delete-breakdown').click(function(){
        if (confirm('Удалить?')) {
            var id = $('.breakdowns-list .bg-info span').attr('breakdown-id');

            var data = {
                action: 'breakdown',
                id: id
            };

            $.post( Yii.app.createUrl('ajax/deleteElement'),
                {
                    data: JSON.stringify(data)
                })
                .done(function(response){
                    response = JSON.parse(response);

                    if(response.result == 'OK')
                        $('.breakdown-list .bg-info').remove();
                    if(response.result == 'ERROR')
                        alert('Ошибка');
                });
        } else {
            // Do nothing!
        }
    });
    $('#delete-problem').click(function(){
        if (confirm('Удалить?')) {
            var id = $('.problems-list .bg-info span').attr('problem-id');

            var data = {
                action: 'problem',
                id: id
            };

            $.post( Yii.app.createUrl('ajax/deleteElement'),
                {
                    data: JSON.stringify(data)
                })
                .done(function(response){
                    response = JSON.parse(response);

                    if(response.result == 'OK')
                        $('.problems-list .bg-info').remove();
                    if(response.result == 'ERROR')
                        alert('Ошибка');
                });
        } else {
            // Do nothing!
        }
    });

    $('#add-problem-category').click(function(){
        var form = new FormData($('#problem-category-form')[0]);

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

            var html = '<li><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-category-id="' + response.id + '" class="problem-category-li">' + response.name + '</span></li>';
            if ($('.problem-categories-list li').length !== 0)
                $('.problem-categories-list li:last').after(html);
            else
                $('.problem-categories-list').html(html);
        });
    });

    $('#add-breakdown').click(function(){
        var form = new FormData($('#breakdown-form')[0]);

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

            var html = '<li><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span breakdown-id="' + response.id + '" class="breakdown-li">' + response.name + '</span></li>';
            if ($('.breakdowns-list li').length !== 0)
                $('.breakdowns-list li:last').after(html);
            else
                $('.breakdowns-list').html(html);
        });
    });
    $('#add-problem').click(function(){
        var form = new FormData($('#problem-form')[0]);

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

            var html = '<li><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-id="' + response.id + '" class="problem-li">' + response.name + '</span></li>';
            if ($('.problems-list li').length !== 0)
                $('.problems-list li:last').after(html);
            else
                $('.problems-list').html(html);
        });
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
    $(document).on('click', '.problem-category-li',  function(){

        $('input[name="problemCategoryId"]').val($(this).attr('problem-category-id'));
        $('#problemCategoryIdHidden').val($(this).attr('problem-category-id'));

        var deviceTypeId = $('.device-types-list .bg-info span').attr('device-type-id');
        var problemCategoryId = $(this).attr('problem-category-id');

        clearIconFile();
        getProblemCategoryIcon($(this).attr('problem-category-id'));

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
    });
    $(document).on('click', '.breakdown-li', function(){
        $('.breakdown-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('input#breakdownIdHidden').val($(this).attr('breakdown-id'));

        clearBreakdownImageFile();
        getBreakdownImage($(this).attr('breakdown-id'));

        $('#breakdown-input').val($(this).text());

        $.post( Yii.app.createUrl('ajax/getProblemDescription'),
            {
                id: $(this).attr('breakdown-id')
            })
            .done(function(response){
                response = JSON.parse(response);
                $('#breakdown-description-input').val(response.desc);
            });
    });
    $(document).on('click', '.problem-li', function(){
        $('.problem-li').parent().removeClass('bg-info');
        $(this).parent().addClass('bg-info');

        $('input#problemIdHidden').val($(this).attr('problem-id'));

        clearProblemImageFile();
        getProblemImage($(this).attr('problem-id'));

        $('#problem-input').val($(this).text());

        $.post( Yii.app.createUrl('ajax/getProblemDescription'),
            {
                id: $(this).attr('problem-id')
            })
            .done(function(response){
                response = JSON.parse(response);
                $('#problem-description-input').val(response.desc);
            });
    });
});

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

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-category-id="' + problemCategory.id + '" class="problem-category-li">' + problemCategory.name + '</span></li>';

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

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span breakdown-id="' + breakdown.id + '" class="breakdown-li">' + breakdown.name + '</span></li>';

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

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-id="' + problem.id + '" class="problem-li">' + problem.name + '</span></li>';

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

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span breakdown-id="' + breakdown.id + '" class="breakdown-li">' + breakdown.name + '</span></li>';

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

            html += '<i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-id="' + problem.id + '" class="problem-li">' + problem.name + '</span></li>';

            first = false;
        });
        $('.problems-list').html(html);
        resetProblems();
    }
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
function clearIconFile()
{
    var fileField = $('#problem-category-icon-file');
    fileField.replaceWith( fileField = fileField.clone( true ) );
    $('#problem-category-icon-file-preview').removeAttr('src').addClass('hidden');
}
function clearBreakdownImageFile()
{
    var fileField = $('#breakdown-image-file');
    fileField.replaceWith( fileField = fileField.clone( true ) );
    $('#breakdown-image-file-preview').removeAttr('src').addClass('hidden');
}
function clearProblemImageFile()
{
    var fileField = $('#problem-image-file');
    fileField.replaceWith( fileField = fileField.clone( true ) );
    $('#problem-image-file-preview').removeAttr('src').addClass('hidden');
}
function getProblemCategoryIcon(id)
{

    var data = {
        id: id,
        action: 'problemCategory'
    };

    $.post( Yii.app.createUrl('ajax/getImage'),
        {
            data: JSON.stringify(data)
        })
        .done(function(response){
            response = JSON.parse(response);
            if(typeof response.src !== 'undefined')
                $('#problem-category-icon-file-preview').attr('src', response.src).removeClass('hidden');
        });
}
function getBreakdownImage(id)
{

    var data = {
        id: id,
        action: 'breakdown'
    };

    $.post( Yii.app.createUrl('ajax/getImage'),
        {
            data: JSON.stringify(data)
        })
        .done(function(response){
            response = JSON.parse(response);
            if(typeof response.src !== 'undefined')
                $('#breakdown-image-file-preview').attr('src', response.src).removeClass('hidden');
        });
}
function getProblemImage(id)
{

    var data = {
        id: id,
        action: 'problem'
    };

    $.post( Yii.app.createUrl('ajax/getImage'),
        {
            data: JSON.stringify(data)
        })
        .done(function(response){
            response = JSON.parse(response);
            if(typeof response.src !== 'undefined')
                $('#problem-image-file-preview').attr('src', response.src).removeClass('hidden');
        });
}