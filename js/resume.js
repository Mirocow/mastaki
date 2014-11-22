$(document).ready(function(){
    $(document).on('click', '.mastak-row', function(){
        $.post( Yii.app.createUrl('ajax/getMastak'),
            {
                id: $(this).attr('mastak-id')
            })
            .done(function(response){updateMastak(response)});
    });
    $(document).on('change', '.mastak-status-select', function(){
        $.post( Yii.app.createUrl('ajax/setMastakStatus'),
            {
                id: $(this).attr('mastak-id'),
                status: $(this).val()
            })
            .done(function(response){});
    })
    $(document).on('click', '.mastak-add-review', function(){
        $.post( Yii.app.createUrl('ajax/addMastakReview'),
            {
                id: $(this).attr('mastak-id'),
                status: $(this).val()
            })
            .done(function(response){});
    })

    $('#search-btn').click(function(){
        $.post( Yii.app.createUrl('ajax/getMastaks'),
            {
                search: $('#search-input').val()
            })
            .done(function(response){
                $('.mastaki-table-container').html(response);
            });
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
