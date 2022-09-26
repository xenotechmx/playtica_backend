$(function() {

    if($('#new-Schedule-form').length){

        $('.dateClass').addClass('d-none');    
        $('.timeClass').addClass('d-none');

        $('#Schedule_openTime_date_day').val('1');
        $('#Schedule_openTime_date_month').val('1');
        $('#Schedule_openTime_date_year').val('2022');

        $('#Schedule_closeTime_date_day').val('1');
        $('#Schedule_closeTime_date_month').val('1');
        $('#Schedule_closeTime_date_year').val('2022');

        $('#Schedule_openTime_time_hour').val('9');
        $('#Schedule_closeTime_time_hour').val('20');

        $('#Schedule_openTime_time_minute').val('0');
        $('#Schedule_closeTime_time_minute').val('0');
    }


    $('#Schedule_type').change(function(){
        $('.dateClass').addClass('d-none');    
        $('.timeClass').addClass('d-none');

        let value = $(this).val();

        if(value >= 1 && value <=7){ //weekdays
            $('.timeClass').removeClass('d-none');
            $('.timeClass').find('.datetime-widget-date').addClass('d-none');
        }
        else if(value == 8){ //special schedule
            $('.dateClass').removeClass('d-none');
            $('.timeClass').removeClass('d-none');
            $('.timeClass').find('.datetime-widget-date').addClass('d-none');
        }
        else if(value == 9){ //closed day
            $('.dateClass').removeClass('d-none');
        }
    });
});