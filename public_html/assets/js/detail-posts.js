$(".btn-report-post").click(function () {
    $(".me-alert-report-box").show(500);
    $(".me-alert-report-dark").show(500);
    $("html, body").animate({ scrollTop: 0 }, "slow");
});

$(".me-btn-bookmark").click(function () {
    var postId = $(".me-input-bookmark").val();
    if(!$(this).hasClass("basic"))
    {
        $.ajax({
            type:"post",
            url : "/posts/bookmark",
            dataType : "json",
            data : {postId : postId},
            headers :
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (data) {
                if(data.text == "Marked"){
                    $(".me-btn-bookmark").removeClass("me-btn-outline-book");
                    $(".me-btn-bookmark").html("<i class=\"fas fa-bookmark ml-1 mt-1\"></i>نشان شده")
                    $(".me-btn-bookmark").addClass("me-btn-outline-booked");
                }else if(data.text == "UnMarked" ) {
                    $(".me-btn-bookmark").removeClass("me-btn-outline-booked");
                    $(".me-btn-bookmark").html("<i class=\"fas fa-bookmark ml-1 mt-1\"></i>نشان کردن")
                    $(".me-btn-bookmark").addClass("me-btn-outline-book");

                }
            }
        })
    }
    else {
        $(".me-alert-bookmark-box").show(500);
        $(".me-alert-bookmark-dark").show(500);
    }

})

$(".me-btn-bookmark").hover(function () {

        var booked = $(this).hasClass("me-btn-outline-booked");
        if(booked)
            $(this).html(" <i class=\"fas fa-bookmark ml-1 mt-1\"></i>حذف نشان");

    },function () {
        var booked = $(this).hasClass("me-btn-outline-booked");
        if(booked)
            $(this).html(" <i class=\"fas fa-bookmark ml-1 mt-1\"></i>نشان شده");
    }
)


$("#btn-show-phone").click(function () {
    $("#div-show-phone").slideToggle("fast","swing")
})

$(".me-list-carousel-photo").click(function () {
    $(".me-list-carousel-photo").removeClass("me-active");
    $(this).addClass("me-active");
})

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).html()).select();
    document.execCommand("copy");
    $temp.remove();
}

$('[data-toggle="tooltip"]').tooltip();

$('[data-toggle="tooltip"]').on('click', function() {
    $(this).attr('data-original-title', '<span class="IranBold14 fw-400">کپی شد</span>')
    $(this).tooltip('show')
});

$('[data-toggle="tooltip"]').hover(function() {
    $(this).attr('data-original-title', '<span class="IranBold14 fw-400">کپی لینک</span>')
    $(this).tooltip('show')
},function () {
    $(this).tooltip('hide');
});


$(".toggle_button").click(function () {
    var postToken = $(this).parents(".card_parent").find(".post_show_title").attr("id");
    var checked  = $(this).is(":checked");
    if(checked)
        $(this).parents("button").find(".me-span-text").text("غیرفعال بشه");
    else
        $(this).parents("button").find(".me-span-text").text("منتشر بشه");

    $.ajax({
        type : "post",
        dataType : "json",
        url : "/admin/enable-post",
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        data : {checked : checked,postToken : postToken}
    })

})
