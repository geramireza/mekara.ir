jQuery( document ).ready( function( $ ) {
    $.latin2Arabic = {
        _numerals: [
          {
            "arabic": "٠",
            "latin": "0",
            "html": "&#1632;"
          },
          {
            "arabic": "۱",
            "latin": "1",
            "html": "&#1633;"
          },
          {
            "arabic": "۲",
            "latin": "2",
            "html": "&#1634;"
          },
          {
            "arabic": "۳",
            "latin": "3",
            "html": "&#1635;"
          },
          {
            "arabic": "۴",
            "latin": "4",
            "html": "&#1636;"
          },
          {
            "arabic": "۵",
            "latin": "5",
            "html": "&#1637;"
          },
          {
            "arabic": "۶",
            "latin": "6",
            "html": "&#1638;"
          },
          {
            "arabic": "٧",
            "latin": "7",
            "html": "&#1639;"
          },
          {
            "arabic": "٨",
            "latin": "8",
            "html": "&#1640;"
          },
          {
            "arabic": "٩",
            "latin": "9",
            "html": "&#1641;"
          }
      ],
      // Convert Latin to Arabic
      toArabic: function(number) {
          $.each(this._numerals, function(i,v) {
              number = number.replace(new RegExp(v.latin, 'g'), v.arabic);
              //console.log(number);
          });

          return number;
      },
      // Convert Arabic to Latin
      toLatin: function(number) {
          $.each(this._numerals, function(i,v) {
              number = number.replace(new RegExp(v.arabic, 'g'), v.latin);
              //console.log(number);
          });

          return number;
      },
      // Convert Arabic to Html
      toHtml: function(number) {
          $.each(this._numerals, function(i,v) {
              number = number.replace(new RegExp(v.arabic, 'g'), v.html);
              //console.log(number);
          });

          return number;
      }
    }
});
