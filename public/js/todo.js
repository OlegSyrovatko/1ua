jQuery(document).ready(function($){

    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {
            title: jQuery('#title').val(),
            description: jQuery('#description').val(),
            nobl: jQuery('#nobl').val(),
        };

        $.ajax({
            type: 'POST',
            url: 'todo',
            data: formData,
            // dataType: 'json',
            cache: false,
            success:function(data){
                data = JSON.stringify(data);
                document.getElementById("msg").innerHTML=data;}
        });
    });

    $("#btn-load").click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            nobl: jQuery('#nobl').val(),
       };
        $.ajax({
            type: 'POST',
            url: 'tdd',
            data: formData,
            cache: false,
            success:function(data){
                data = JSON.stringify(data);
                document.getElementById("rayc").innerHTML=data;}
        });
    });
});
