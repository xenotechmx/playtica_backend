var limitAge = 13;

$(function() {

    $('#Visitor_type').val(2);
    
    $( "#Visitor_birthday_year, #Visitor_birthday_month, #Visitor_birthday_day" ).change(function() {        
        
        let day = $('#Visitor_birthday_day').val() > 9 ? $('#Visitor_birthday_day').val() : '0' + $('#Visitor_birthday_day').val();
        let month = $('#Visitor_birthday_month').val() > 9 ? $('#Visitor_birthday_month').val() : '0' + $('#Visitor_birthday_month').val();
        let year = $('#Visitor_birthday_year').val();

        let birthDay = String(day)+String(month)+String(year);

        age = moment().diff(moment(birthDay, 'DDMMYYYY'), 'years');

        if (age > limitAge)
            $('#Visitor_type').val(2);
        else
            $('#Visitor_type').val(1);

    });

});