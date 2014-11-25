$(document).ready(function(){
    $(document).on('click', '.mastak-row', function(){
        $.post( Yii.app.createUrl('ajax/getMastak'),
            {
                id: $(this).attr('mastak-id')
            })
            .done(function(response){updateMastak(response)});
    });
    $(document).on('change', '.mastak-status-select', function(e){

        var dropdown = $(this);

        if(confirm('Уверены?'))
        {
            $.post( Yii.app.createUrl('ajax/setMastakStatus'),
                {
                    id: $(this).attr('mastak-id'),
                    status: $(this).val()
                })
                .done(function(response){$(dropdown).parent().parent().attr('old-status', $(dropdown).val());});
        }
        else
        {
            $(dropdown).val($(dropdown).parent().parent().attr('old-status'));
        }
    });
    $(document).on('click', '#mastak-add-review', function(){
        $.post( Yii.app.createUrl('ajax/addMastakReview'),
            {
                id: $('#mastak-reviews').attr('mastak-id'),
                content: $('#mastak-review-content').val()
            })
            .done(function(response){
                response = JSON.parse(response);

                if($('#mastak-reviews table tr').length > 0)
                    $('#mastak-reviews table tr:last').after('<tr><td>'+ response.date + '</td><td>'+ response.content + '</td></tr>');
                else
                    $('#mastak-reviews table').html('<tr><td>'+ response.date + '</td><td>'+ response.content + '</td></tr>');

                $('#mastak-review-content').val('');
            });
    });
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

    $('#mastak-reviews').html(response.reviews).attr('mastak-id', response.id);
}
