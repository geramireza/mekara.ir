
    $(".me-span-checkbox").click(function () {
        $(this).toggleClass("me-checked");
    });
    
    $(".me-span-radio").click(function () {
        $(this).parents(".me-parent-radio").find(".me-span-radio").each(function (index,element) {
           $(element).removeClass("me-checked")
        }) 
        $(this).addClass("me-checked");
    })
    
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

    $("#input-file").change(function(){

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-file').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#input1-file").change(function(){

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img1-file').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#input2-file").change(function(){

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img2-file').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#input3-file").change(function(){

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img3-file').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });


  f