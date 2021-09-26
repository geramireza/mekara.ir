$("#just-emergency,#just-today").click(function () {

        var data = "";
        var is_emergency = $("#just-emergency").is(":checked");
        var is_today = $("#just-today").is(":checked");
        var city = $("select[name=city] option:selected").val();
        var category_id = $("select[name=category_id] option:selected").val();
        var txtSearch = $("input[name=txtSearch]").val();

            if (city != "")
                data += "city=" + city;
            else 
                data += "city=all"
            if (is_emergency)
                data += "&is_emergency=1" ;
            if(is_today)
                data += "&is_today=1";
            if (category_id != "")
                data += "&category_id=" + category_id;
            if (txtSearch != "")
                data += "&txtSearch=" + txtSearch;

        window.location.replace('/posts/search/'+ data);


});