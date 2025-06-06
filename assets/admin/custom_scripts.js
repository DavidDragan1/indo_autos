// Empty JS for your own code to be here
var  $ = jQuery;
$(document).ready(function() {
    if ($(".select2").length > 0){
        $(".select2").select2();
    }

    // $('.carousel').carousel('pause');


});




function shortBy( shortBy ){
    var shortBy = shortBy;
    // alert( shortBy );
    alert ( 'Inprogress. ajax filtering for faster respond!' );
}


function admin_validateEmail(sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}jQuery/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
};

/*$(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
});*/


/*/!*On reply button click*!/
$(".reply_button").click(function(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById("mail_form"));
    var subject = $('[name=subject]').val();
    var sender_id = $('[name=sender_id]').val();
    var message = $('[name=message]').val();
    alert(subject);

    jQuery.ajax({
        type: "POST",
        url: "admin/mails/reply_mail",
        dataType: 'json',
        data: {
            sender_id : sender_id,
            subject : subject,
            message : message
        },
        success: function(jsonData) {

        }
    });
});*/







