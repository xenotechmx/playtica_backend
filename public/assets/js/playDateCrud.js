$(function() {
    if($('#new-PlayDate-form').length){

        $("#PlayDate_endsAt_hour, #PlayDate_endsAt_minute").prop( "disabled", true );
                     
        //default today
        $('#PlayDate_date').val(moment().format('YYYY-MM-DD'));
        
        clearAvailableHours();
        populateAvailableHours();
        
        //when branch or date changed
        $('#PlayDate_branch, #PlayDate_date').change(function(){
            clearAvailableHours();
            populateAvailableHours();
            calculateEndHour();
        });
        
        $('#PlayDate_paymentStatus').val(1);

        //when starts hour, starts minute or hours changed
        $('#PlayDate_startsAt_hour, #PlayDate_startsAt_minute, #PlayDate_hoursToPlayDate').change(function(){
            calculateEndHour()
        });
        
        //current default hour
        $('#PlayDate_startsAt_hour').val(moment().format('HH'));
        $('#PlayDate_startsAt_minute').val(moment().format('m'));
        $('#PlayDate_startsAt_hour').change();
        
        $('#new-PlayDate-form').submit(function(e){            
            $("#PlayDate_startsAt_hour, #PlayDate_startsAt_minute, #PlayDate_endsAt_hour, #PlayDate_endsAt_minute").prop( "disabled", false );            
        });

    }
});

function populateAvailableHours(){    
    let branch = $('#PlayDate_branch').val();
    let date = $('#PlayDate_date').val();

    $.ajax({
        url: "api/branch/schedule/" + branch + "/" + moment(date, 'YYYY-MM-DD').format('DDMMYYYY'),
        dataType: "json",
        method: 'get',
        headers: {
            'X-Auth-Token' : plt
       },
       async: false
    }).done(function(response){        
        $.each(response, function( index, schedule ) {
            if(schedule.type==9){ //is closed
                $('#PlayDate_date').val('');
                alert ("En esta fecha la sucursal está cerrada");
                return false;
            }
            if (schedule.type == 8) {
                //special schedule for this day
                return false;
            }
            let openTime = moment(schedule.openTime.date, 'YYYY-MM-DD HH:mm').format('H');
            let closeTime = moment(schedule.closeTime.date, 'YYYY-MM-DD HH:mm').format('H');
            
            while(openTime<closeTime){                
                $('#PlayDate_startsAt_hour').append('<option value="'+openTime+'">'+moment(openTime, 'H').format('h a')+'</option>');
                $('#PlayDate_endsAt_hour').append('<option value="'+openTime+'">'+moment(openTime, 'H').format('h a')+'</option>');
                openTime++;
            }
            $('#PlayDate_endsAt_hour').append('<option value="'+openTime+'">'+moment(openTime, 'H').format('h a')+'</option>');
        });
    });
}

function clearAvailableHours(){
    $('#PlayDate_startsAt_hour').find('option').remove();
    $('#PlayDate_endsAt_hour').find('option').remove();
}

function calculateEndHour(){
    let hoursToSum = $('#PlayDate_hoursToPlayDate').val();
    let start = $('#PlayDate_startsAt_hour').val();
    let end = parseInt(start) + parseInt(hoursToSum);

    if($('#PlayDate_startsAt_minute').val() == null){
        $('#PlayDate_startsAt_minute').val(moment().format('m'));
    }

    if(hoursToSum != 0){
        $('#PlayDate_endsAt_hour').val(end);
        $('#PlayDate_endsAt_minute').val($('#PlayDate_startsAt_minute').val());
        
        $("#PlayDate_startsAt_hour, #PlayDate_startsAt_minute").prop( "disabled", false );
    }

    if(hoursToSum == 0){ //all day playdate
        $("#PlayDate_startsAt_hour, #PlayDate_startsAt_minute, #PlayDate_endsAt_hour, #PlayDate_endsAt_minute").val('');
        $("#PlayDate_startsAt_hour, #PlayDate_startsAt_minute").prop( "disabled", true );
    }
}