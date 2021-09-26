$(document).ready(function () {
    $(".me-select2").select2({
        "language": {
            "noResults": function(){
                return "<span class='Iran13 fw-400'>نتیجه ای یافت نشد</span>";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    var first = true;
    $("#me-category-select2-container,#me-city-select2-container").click(function () {
        if(first){
            $(this).find(".me-chevron").css({
                transform : "rotate(180deg)",
                transition : "0.5s"
            })
            first = false;
        }
       else {
            $(this).find(".me-chevron").css({
                transform : "rotate(0deg)",
                transition : "0.5s"
            })
            first = true;
        }
        $(".select2-search__field").attr("placeholder","جستجو...")
        $(".select2-search__field").css("font-size","12px");
        $(".select2-search__field").css("height","34px");
        $(".select2-search__field").css("font-family","Iran");
    })
})
