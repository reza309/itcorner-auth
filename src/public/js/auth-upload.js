$(document).ready(function(){

    // update basic user info
    // update profile data exept photo
    $("#formFile").change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();

        // var formData = new FormData($('#profile-upload-form')[0]);
        // var file = $('input[type=file]')[0].files[0];
        // formData.append('file', file, file.name);
        var filedata=this.files[0];
        var imgtype=filedata.type;
        var postData=new FormData();
        postData.append('file',this.files[0]);
        console.log(postData);

        var type = "POST";
        var ajaxurl = 'profileUpload';
        $.ajax({
            type: type,
            url: ajaxurl,
            // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: postData,
            contentType: false,
            dataType: 'json',
            cache: false,
            processData:false,
            success: function (data) {
                console.log(data.target_file);
                $('#profile-upload-form').trigger("reset");
                $("#profile-upload-form").find('img').attr('src',data.target_file);
                $('#profile-upload-form').trigger("reset");
            },
            // error: function (data) {
            //     console.log(data);
            // }
        });
    });
});


// $(document).ready(function() {
//     $("#formFile").change(function(e) {
//         e.preventDefault();
//         let formData = new FormData($('#profile-upload-form')[0]);
//         let file = $('input[type=file]')[0].files[0];
//         formData.append('file', file, file.name);
//         $.ajax({
//             async:true,
//             url: 'profileUpload',
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//             type: 'POST',   
//             contentType: false,
//             processData: false,
//             dataType:'json',   
//             // cache: false,        
//             data: formData,
//             success: function(data) {
//                 console.log("success");
//             },
//             error: function(data) {
//                 console.log(data);
//             }
//         });
//     });
// })
