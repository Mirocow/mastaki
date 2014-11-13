function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + id).attr('src', e.target.result);
            $('#' + id).removeClass('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function(){
    $("#device-image-file, #device-type-icon-file, #problem-category-icon-file, #breakdown-image-file, #problem-image-file").change(function(){
        readURL(this, $(this).attr('id')+'-preview');
    });
});