// Enter Button to Submit;

function _enter( btnId ){
    $( 'body' ).on('keyup change',function(event){
        if(event.keyCode == 13){
            event.preventDefault();
            $('#'+btnId).click();
            return false;
            $('form').submit(false);
        }
    });
}


// Off Defalt behabiour
$('button').click(function(e){
    e.preventDefault();
});

// Redirect function

function _redirect(path, time){
    setTimeout(function(){
        window.location.href = path;
    }, 1000 * time);
}

// Off Defalt behabiour
$(':button').click(function(e){
    e.preventDefault();
});

// Disabled
function _enableBtn(button){
    $("#"+button).prop('disabled', false);
}


function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Reload
function _reload(time){

    setTimeout(function(){
        location.reload();
    }, 1000 * time);
}

$(document).on("keydown", "form", function(event) {
    return event.key != "Enter";
});

function toast(type, message){
    let bg = "linear-gradient(to right, #00b09b, #96c93d)";
    if(type == 'success'){
        bg = "linear-gradient(to right, #00b09b, #96c93d)";
    }else if(type == 'error'){
        bg = "linear-gradient(to right, #ff5f6d, #ffc371)";
    }else if(type == 'info'){
        bg = "linear-gradient(to right, #c2e59c, #64b3f4);";
    }
    Toastify({
        text: message,
        duration: 5000,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        backgroundColor: bg,
        stopOnFocus: true,
    }).showToast();
}

$('input').keyup(function(){
    _self = $(this);
    _self.next('.error-msg').hide();
    _self.css("border-color","rgba(226,232,240)");
});



