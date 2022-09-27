$(function() {
    if($('#new-PlayDate-form').length){
        $('#PlayDate_startsAt_hour').val(13);
        $('#PlayDate_endsAt_hour').val(14);

        $('#PlayDate_paymentStatus').val(1);

        //when starts changed
        $('#PlayDate_startsAt_hour').change(function(){
            $('#PlayDate_endsAt_hour').val(parseInt($('#PlayDate_startsAt_hour').val()) + 1);
            $('#PlayDate_endsAt_minute').val($('#PlayDate_startsAt_minute').val());
        });
    }
});