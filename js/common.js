/**
 * Created by slashman on 28.10.14.
 */

var previousProblem = null;

$(document).ready(function(){
    $('i[data-toggle=tooltip]').tooltip();
    //$('i.details-arrow').click(function(){
    //    var problemId = $(this).attr('problem-id');
    //    if(previousProblem == problemId)
    //    {
    //        $('p.problem-details[problem-id=' + $(this).attr('problem-id') + ']').addClass('hidden',1000, "easeOutBounce");
    //        previousProblem = null;
    //    }
    //    else
    //    {
    //        previousProblem = problemId;
    //        $('p.problem').addClass('hidden');
    //        $('p.problem-details[problem-id=' + $(this).attr('problem-id') +']').removeClass('hidden',1000, "easeOutBounce");
    //
    //    }
    //});

    $('.problem-details').on('show.bs.collapse', function () {
        $('.problem-details.in').collapse('hide');
    });
    $('input[name=phone],input[name="LoginForm[phone]"],input[name="User[phone]"]').mask("(999) 999-99-99");
});