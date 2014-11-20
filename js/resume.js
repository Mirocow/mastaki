$(document).ready(function(){
    $(document).on('click', '.mastak-row', function(){
        $.post( Yii.app.createUrl('ajax/getMastak'),
            {
                id: $(this).attr('mastak-id')
            })
            .done(function(response){updateMastak(response)});
    });

    $('#search-btn').click(function(){
        $.post( Yii.app.createUrl('ajax/getMastaks'),
            {
                search: $('#search-input').val()
            })
            .done(function(response){updateMastaks(response)});
    });
});

function updateMastak(response)
{
    response = JSON.parse(response);

    $('#name-well').text(response.name);
    $('#address-well').text(response.address);
    $('#education-well').text(response.education);
    $('#experience-well').text(response.experience);
    $('#qualities-well').text(response.qualities);
    $('#skills-well').html(response.skills);
}

function updateMastaks(response)
{
    response = JSON.parse(response);

    var html = '<table class="table table-striped">';
    $(response).each(function(){
        var mastak = $(this)[0];

        html += '<tr class="mastak-row" mastak-id="' + mastak.id + '"><td>' + mastak.id + '</td><td>' + mastak.name + '</td><td>' + mastak.phone + '</td><td>' + mastak.skills + '</td><td>' + mastak.status + '</td></tr>';

        $('')

    });

    html += '</table>';

    $('.mastaki-table-container').html(html);
}