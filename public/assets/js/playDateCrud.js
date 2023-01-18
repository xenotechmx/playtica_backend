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
        $('#PlayDate_startsAt_hour, #PlayDate_startsAt_minute, #PlayDate_hours').change(function(){
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

$(document).on('keyup', '.visitorFirstName, .visitorLastName', function() {
    let index = $(this).attr('id');
    index = index.split('_');
    index = index[2];

    const firstName = $('#PlayDate_playDateVisitors_1_firstName').val();
    const lastName = $('#PlayDate_playDateVisitors_1_lastName').val();

    //
    showAutoCompleteInfant(firstName, lastName, index);
});


$(document).on('keyup', '.visitorMobilePhone', function() {
    const mobilePhone = $(this).val();
    let index = $(this).attr('id');
    index = index.split('_');
    index = index[2];
    showAutoCompleteAdult(mobilePhone, index);
});

$(document).on('change', '.visitorTypeSelect', function() {
    let index = $(this).attr('id');
    index = index.split('_');
    index = index[2];
    showHideVisitorFields(index);
});

function showAutoCompleteInfant(mobilePhone, index){
    // if(mobilePhone.length >= 5){
    //     $.ajax({
    //         url: "api/find_visitor_mobile",
    //         dataType: "json",
    //         method: 'post',
    //         data: {'mobilePhone': mobilePhone},
    //         headers: {
    //             'X-Auth-Token' : plt
    //        },
    //        async: false
    //     }).done(function(response){
    //         console.log(response, response.length, response[0]), index;
    //         if(response.length == 1){
    //             visitor = response[0];
    //             $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').val(visitor.mobilePhone);
    //             $('#PlayDate_playDateVisitors_'+index+'_firstName').val(visitor.firstName);
    //             $('#PlayDate_playDateVisitors_'+index+'_lastName').val(visitor.lastName);
    //             $('#PlayDate_playDateVisitors_'+index+'_birthday').val(moment(visitor.birthday.date).format("YYYY-MM-DD"));
    //             $('#PlayDate_playDateVisitors_'+index+'_gender').val(visitor.gender);
    //         }
    //     });
    // }
}

function showAutoCompleteAdult(mobilePhone, index){
    if(mobilePhone.length >= 5){
        $.ajax({
            url: "api/find_visitor_mobile",
            dataType: "json",
            method: 'post',
            data: {'mobilePhone': mobilePhone},
            headers: {
                'X-Auth-Token' : plt
           },
           async: false
        }).done(function(response){
            console.log(response, response.length, response[0]), index;
            if(response.length == 1){
                visitor = response[0];
                $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').val(visitor.mobilePhone);
                $('#PlayDate_playDateVisitors_'+index+'_firstName').val(visitor.firstName);
                $('#PlayDate_playDateVisitors_'+index+'_lastName').val(visitor.lastName);
                $('#PlayDate_playDateVisitors_'+index+'_birthday').val(moment(visitor.birthday.date).format("YYYY-MM-DD"));
                $('#PlayDate_playDateVisitors_'+index+'_gender').val(visitor.gender);
            }
        });
    }
}

function showHideVisitorFields(index){
    let type = $('#PlayDate_playDateVisitors_'+index+'_type').val();
    let visitorType = type == 1 ? 'infant' : 'adult';

    if (visitorType == 'infant'){
        $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').val(''); // mobile phone
        $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').parent().parent().hide(); // mobile phone
        $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').removeAttr('required'); // mobile phone

    } else if (visitorType == 'adult'){        
        $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').parent().parent().show(); // mobile phone
        $('#PlayDate_playDateVisitors_'+index+'_mobilePhone').attr('required','true'); // mobile phone
    }
}

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
    let hoursToSum = $('#PlayDate_hours').val();
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

function convertFormToJSON(form) {
    return $(form)
        .serializeArray()
        .reduce(function (json, { name, value }) {
        json[name] = value;
        return json;
    }, {});
}