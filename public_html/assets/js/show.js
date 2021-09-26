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
