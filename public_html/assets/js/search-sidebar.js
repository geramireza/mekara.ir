    $(".me-span-search-checkbox").click(function () {
        var data = "";
        $("#search_sidebar").find(".me-div-title-search-sidebar").each(function () {
            var label = $(this).attr("name");
            var path =  $(this).parents(".me-card-parent").find("input");
            var values = "";
            $(path).each(function (index2,element) {

                if($(element).is(":checked")){
                    if(values  == "")
                        values += $(element).attr("id") ;
                    else
                        values += "," + $(element).attr("id");
                }
            })

            if(values != "" && data == "")
                data += label + "=" + values;
            else if(values != "" && data != "")
                data += "&" + label + "=" + values;

        })

        window.location.replace('/search/'+data);
    })


    $(".search-sidebar-more-item").click(function () {
        var name = $(this).attr('name');
        if(name == "more")
        {
            var count = $(this).parents(".card-body").find(".me-item-count").length;
            $(this).parents(".card-body").css({
                transition :"height 1s linear",
                height : (count + 2 ) * 29 +"px"
            });
            $(this).text("- موارد کمتر");
            $(this).attr("name","less");
        }
        else {
            $(this).parents(".card-body").css({
                transition :"height 1s linear",
                height : "282px"
            });
            $(this).attr("name","more");
            $(this).text("+ موارد بیشتر");
        }
    })

    $(".me-search-sidebare-slide-header").click(function () {
        var path = $(this).parents(".me-search-sidebare-slide");
        var display =$(path).find(".card-body").css("display");

        if(display == "block")
        {
            $(path).find(".search-sidebar-more-item").hide(100);
            $(path).find(".card-body").slideUp("slow");
            $(path).find(".card-header").addClass("border-bottom-0");
            $(path).find(".me-chevron").css({
                transform : "rotate(0deg)",
                transition : "0.5s"
            });
        }
        else {
            $(path).find(".search-sidebar-more-item").show(100);
            $(path).find(".card-body").slideDown("slow");
            $(path).find(".card-header").removeClass("border-bottom-0");
            $(path).find(".me-chevron").css({
                transform : "rotate(180deg)",
                transition : "0.5s"
            });

        }
    })