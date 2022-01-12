$(document).ready(function(){

    // update basic user info
    // update profile data exept photo
    $("#update-form").submit(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = $("#update-form").serializeArray();
        // console.log(formData);
        var state = $('#btn-save').val();
        var type = "POST";
        var ajaxurl = 'profile';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                // display phone input error
                if( data.hasOwnProperty('phone')){
                    $("input[name=phone]").addClass("is-invalid");
                    $("input[name=phone]").removeClass("is-valid");
                    if($("input[name=phone]").next("span").length == 0){
                        $("input[name=phone]").after(
                            '<span class="text-danger">'+data.phone+'</span>'
                        );
                    }
                }else{
                    $("input[name=phone]").addClass("is-valid");
                    $("input[name=phone]").removeClass("is-invalid");
                    $("input[name=phone").next().remove();
                }
                // display first name error
                if( data.hasOwnProperty('first_name')){
                    $("input[name=first_name]").addClass("is-invalid");
                    $("input[name=first_name]").removeClass("is-valid");
                    if($("input[name=first_name]").next("span").length == 0){
                        $("input[name=first_name]").after(
                            '<span class="text-danger">'+data.first_name+'</span>'
                        );
                    }
                }else{
                    $("input[name=first_name]").addClass("is-valid");
                    $("input[name=first_name]").removeClass("is-invalid");
                    $("input[name=first_name").next().remove();
                }
                // disaply last name error
                if( data.hasOwnProperty('last_name')){
                    $("input[name=last_name]").addClass("is-invalid");
                    $("input[name=last_name]").removeClass("is-valid");
                    if($("input[name=last_name]").next("span").length == 0){
                        $("input[name=last_name]").after(
                            '<span class="text-danger">'+data.last_name+'</span>'
                        );
                    }
                }else{
                    $("input[name=last_name]").addClass("is-valid");
                    $("input[name=last_name]").removeClass("is-invalid");
                    $("input[name=last_name").next().remove();
                }
                // display line_1 error
                if( data.hasOwnProperty('line_1')){
                    $("input[name=line_1]").addClass("is-invalid");
                    $("input[name=line_1]").removeClass("is-valid");
                    if($("input[name=line_1]").next("span").length == 0){
                        $("input[name=line_1]").after(
                            '<span class="text-danger">'+data.line_1+'</span>'
                        );
                    }
                }else{
                    $("input[name=line_1]").addClass("is-valid");
                    $("input[name=line_1]").removeClass("is-invalid");
                    $("input[name=line_1").next().remove();
                }
                // display line2 error
                if( data.hasOwnProperty('line_2')){
                    $("input[name=line_2]").addClass("is-invalid");
                    $("input[name=line_2]").removeClass("is-valid");
                    if($("input[name=line_2]").next("span").length == 0){
                        $("input[name=line_2]").after(
                            '<span class="text-danger">'+data.line_2+'</span>'
                        );
                    }
                }else{
                    $("input[name=line_2]").addClass("is-valid");
                    $("input[name=line_2]").removeClass("is-invalid");
                    $("input[name=line_2").next().remove();
                }
                // display state error
                if( data.hasOwnProperty('state')){
                    $("input[name=state]").addClass("is-invalid");
                    $("input[name=state]").removeClass("is-valid");
                    if($("input[name=state]").next("span").length == 0){
                        $("input[name=state]").after(
                            '<span class="text-danger">'+data.state+'</span>'
                        );
                    }
                }else{
                    $("input[name=state]").addClass("is-valid");
                    $("input[name=state]").removeClass("is-invalid");
                    $("input[name=state").next().remove();
                }
                // display city error
                if( data.hasOwnProperty('city')){
                    $("input[name=city]").addClass("is-invalid");
                    $("input[name=city]").removeClass("is-valid");
                    if($("input[name=city]").next("span").length == 0){
                        $("input[name=city]").after(
                            '<span class="text-danger">'+data.city+'</span>'
                        );
                    }
                }else{
                    $("input[name=city]").addClass("is-valid");
                    $("input[name=city]").removeClass("is-invalid");
                    $("input[name=city").next().remove();
                }
                // check all success
                if(data==='success')
                {
                    $("input").removeClass("is-valid");
                    $("#success").html("<span class='alert alert-success p-3 text-center'>Profile Updated Successfully! </span>");
                    setTimeout(() => {
                        $("#success").children("span").remove();
                    }, 3000);
                }
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});