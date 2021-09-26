$(".me-input-phone").on("input",function () {
    var value = $(this).val();
    if(value.length == 11 && $.isNumeric(value) && value.startsWith("09"))
        $(".me-btn-phone").removeAttr("disabled","false");
    else
        $(".me-btn-phone").prop("disabled","true");
})
$("#input-report-phone").on("input",function () {
    var value = $(this).val();
    if( value == "" || (value.length == 11 && $.isNumeric(value) && value.startsWith("09"))) {
        $("#btn-report-confirm").removeAttr("disabled","false");
        $(this).removeClass("me-border-danger");
    }else{
        $("#btn-report-confirm").prop("disabled","true");
        $(this).addClass("me-border-danger");
    }

})

$(".me-input-password").on("input",function () {

    if($(this).val().length == 4 && $.isNumeric($(this).val()))
        $(".me-btn-password").removeAttr("disabled","false")
    else
        $(".me-btn-password").prop("disabled","true")
})

$(".me-btn-phone-send").click(function () {
    var phone = $(".me-input-phone").val();
    $.ajax({
        type:"post",
        url : "/password",
        dataType : "json",
        data : {phone : phone},
        headers :
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $(".me-loading").show();
        },
        complete: function() {
            $(".me-loading").hide();
        },
        success : function (data) {
            if (data) {
                $(".me-confirm-error").hide(300);
                $(".me-confirm-success").show(300);
                $("#div-input-login-remember").show(300);
                $("#div-input-login-phone").hide(300);
                $("#div-input-login-password").show(300);
                $("#div-btn-login-phone").hide(300);
                $("#div-btn-login-password").show(300);
                $(".me-server-error").hide(300);

            } else {
                $(".me-server-error").show(300);
            }
        }
    })
})

$(".me-btn-password-send").click(function () {
    var password = $(".me-input-password").val();
    var phone = $(".me-input-phone").val();
    var remember_me = $(".me-input-checkbox").is(":checked");
    $.ajax({
        type:"post",
        url : "/confirm",
        dataType : "json",
        beforeSend: function() {
            $(".me-loading").show();
        },
        complete: function() {
            $(".me-loading").hide();
        },
        data : {password : password,phone : phone,remember_me : remember_me},
        headers :
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function (data) {
            if(!data){
                $(".me-confirm-success").hide(300);
                $(".me-confirm-error").show(300);
            }
            else {
                window.location.replace('/my-kara/my-posts');
            }
        }
    })
})

$(".me-btn-bookmark-password-send,.me-alert-form-btn-password").click(function () {
    var password = $(".me-input-password").val();
    var phone = $(".me-input-phone").val();
    var remember_me = $(".me-input-checkbox").is(":checked");
    $.ajax({
        type:"post",
        url : "/confirm",
        dataType : "json",
        beforeSend: function() {
            $(".me-loading").show();
        },
        complete: function() {
            $(".me-loading").hide();
        },
        data : {password : password,phone : phone,remember_me : remember_me},
        headers :
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function (data) {
            if(!data){
                $(".me-confirm-error").show(300);
                $(".me-confirm-success").hide(300);
                $(".me-alert-form-resend-success ").hide(300);
            }
            else {
                location.reload();
            }
        }
    })
})

$(".me-alert-form-btn-resend-password").click(function () {
    var phone = $(".me-input-phone").val();
    $.ajax({
        type:"post",
        url : "/password",
        dataType : "json",
        data : {phone : phone},
        headers :
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $(".me-loading").show();
        },
        complete: function() {
            $(".me-loading").hide();
        },
        success : function (data) {
            setCounter();
            if(data)
            {
                $(".me-server-error").hide(300);
                $(".me-alert-form-card").find(".me-alert-form-send-success").hide(300);
                $(".me-alert-form-card").find(".me-alert-form-resend-success").show(300);
            }
            else
            {
                $(".me-server-error").show(300);
                $(".me-alert-form-card").find(".me-alert-form-send-success").hide(300);
                $(".me-alert-form-card").find(".me-alert-form-resend-success").hide(300);

            }
        }
    })
})

$(".me-alert-cancle,.me-alert-dark,.me-alert-close").click(function () {
    $(".me-alert-box").hide();
    $(".me-alert-dark").hide();
});

$("#btn-report-confirm").click(function () {
    var reportText = null;
    var phone = null;
    var postId = $("#report_post_id").val();
    if($("#input-report-phone").val())
        phone  = $("#input-report-phone").val();
    if($(".me-report-select option:last").is(":selected"))
        reportText = $("#textarea-report").val();
    else
        reportText = $(".me-report-select option:selected").text();
    $.ajax({
        type:"post",
        url : "/posts-reports",
        dataType : "json",
        beforeSend: function() {
            $("#loading").show();
        },
        complete: function() {
            $("#loading").hide();
        },
        data : {postId : postId,phone : phone,reportText : reportText},
        headers :
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function (data) {
            if(data)
            {
                location.reload();
            }else
            {
                $("#btn-report-error").show(300);
                $("#btn-report-success").hide(300);
            }
        }
    })

});

$(".me-report-select").on("change",function () {
    if($(".me-report-select option:last").is(":selected"))
        $("#div-textarea-report").show("slow");
    else
        $("#div-textarea-report").hide("slow");

})

function setCounter() {
    var counter = 60;
    $(".me-alert-form-btn-resend-password").prop("disabled",true);
    $(".me-alert-form-btn-resend-password").text("ارسال مجدد کد تایید"+" ( "+ 60 + " ) ");

    var myInterval = setInterval(function () {
        $(".me-alert-form-btn-resend-password").text("ارسال مجدد کد تایید"+" ( "+ --counter + " ) ");
        if(counter == 0)
        {
            $(".me-alert-form-btn-resend-password").removeAttr("disabled",false);
            clearInterval(myInterval);
            $(".me-alert-form-btn-resend-password").text("ارسال مجدد کد تایید");
        }

        else
            $(".me-alert-form-btn-resend-password").prop("disabled",true);

    }, 1000);

}
setCounter();

