$(".me-radio-fee").click(function () {

    var id = $(this).find("input").attr("id");
    if (id != 0){
        $("#me_fee_input").slideDown("slow");
        if(id == 1)
            $("#me_fee_input").find("input").attr("placeholder","میزان حقوق روزانه به تومان");
        else
            $("#me_fee_input").find("input").attr("placeholder","میزان حقوق ماهیانه به تومان");
    }
    else
        $("#me_fee_input").slideUp("slow");
})

$(".close").click(function () {
    var img = $(this).attr("id");
    var postId = $(this).parents("form").attr("id");
    var path = $(this);

    $.ajax({
        type : "post",
        url : "/admin/delete-img-post",
        dataType : "json",
        data : {img:img,postId:postId},
        headers :
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function (data) {
            if(data)
                $(path).parents(".me-col-img").remove()
        }
    })

})

