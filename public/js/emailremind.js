jQuery(document).ready(function($){


    $('#passsend').click(function (e) {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            email3: jQuery('#email3').val(),
        };

        $.ajax({
            type: 'POST',
            url: '../../emailremind',
             data: formData,
            cache: false,
            success:function(data){
                document.getElementById("emailremind").innerHTML=data;}
        });
    });


    $('#passset').click(function (e) {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            passw3: jQuery('#passw3').val(),
            passw32: jQuery('#passw32').val(),
            idbd: jQuery('#idbd').val(),
            my_key: jQuery('#my_key').val(),
        };

        $.ajax({
            type: 'POST',
            url: '../../../setpassw',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("setpassw").innerHTML=data;}
        });
    });
});
