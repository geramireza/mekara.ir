function checkPrice() {
    var totalPrice = 0;
    $("#form-pay-post").find("input[type=radio],input[type=checkbox]").each(function (index,element) {
        var checked = $(element).is(":checked");
        var id = $(element).attr("id");
        if(checked){
            totalPrice += parseInt($(element).attr("id"));
        }
    })

    if(totalPrice == 0)
        $("#btn-pay-post").addClass("disabled");
    else
        $("#btn-pay-post").removeClass("disabled");

    $("#total-price").text(totalPrice);
}

$("#form-pay-post").find("input[type=radio],input[type=checkbox]").each(function (index,element) {

    $(element).click(function () {
        checkPrice();
    });

})

checkPrice();

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

// back button browser clicked
if(performance.navigation.type == 2) {
    location.reload();
}
