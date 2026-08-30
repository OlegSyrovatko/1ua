jQuery(document).ready(function($){

    //----- Open model CREATE -----//

    // CREATE
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            title: 777,
           // title: jQuery('#title').val(),
            description: jQuery('#description').val(),
        };
        var state = jQuery('#btn-save').val();
        var type = "POST";
        var todo_id = jQuery('#todo_id').val();
        var ajaxurl = 'todo';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                // var todo = '<tr id="todo' + data.id + '"><td>' + data.id + '</td><td>' + data.title + '</td><td>' + data.description + '</td>';
                // if (state == "add") {alert('success');
                 //    jQuery('#todo-list').append(todo);
                }
                // else {
                //    jQuery("#todo" + todo_id).replaceWith(todo);
                // }
               // jQuery('#myForm').trigger("reset");
               // jQuery('#formModal').modal('hide');
            },
            //error: function (data) {
            //     console.log(data);
            // }
        });
    });
});
