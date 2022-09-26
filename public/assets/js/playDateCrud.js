$(function() {

    if($('#new-PlayDate-form').length){

        var currentTime = new Date()

        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();

        $('#PlayDate_startAt_date_year').val(year);
        $('#PlayDate_endAt_date_year').val(year);

        $('#PlayDate_startAt_date_month').val(month);
        $('#PlayDate_endAt_date_month').val(month);

        $('#PlayDate_startAt_date_day').val(day);
        $('#PlayDate_endAt_date_day').val(day);

        $('#PlayDate_startAt_time_hour').val(13);
        $('#PlayDate_endAt_time_hour').val(13);

        $('#PlayDate_paymentStatus').val(1);

        //when starts changed
        $('#PlayDate_startAt_date_year, #PlayDate_startAt_date_month, #PlayDate_startAt_date_day, #PlayDate_startAt_time_hour, #PlayDate_startAt_time_minute').change(function(){
            $('#PlayDate_endAt_date_day').val($('#PlayDate_startAt_date_day').val());
            $('#PlayDate_endAt_date_month').val($('#PlayDate_startAt_date_month').val());
            $('#PlayDate_endAt_date_year').val($('#PlayDate_startAt_date_year').val());

            $('#PlayDate_endAt_time_hour').val(parseInt($('#PlayDate_startAt_time_hour').val()) + 1);
            $('#PlayDate_endAt_time_minute').val($('#PlayDate_startAt_time_minute').val());
        });

    }

});