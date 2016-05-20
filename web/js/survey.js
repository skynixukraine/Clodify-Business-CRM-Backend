var SurveyModule = (function() {

  function showProgressBar() {
    $(".loader").css("display", "block");
  }

  function hideProgressBar() {
    $(".loader").css("display", "none");
  }
  

  return {
    init: function() {
        var myHtml = $("html"),
        xhr = new XMLHttpRequest(),
        radioArr = $('input:radio[name=radio]'),
        labelArr = $('input:radio[name= radio]').parent(),
        radioInput = $('input:radio');

      $('input:radio').click(function() {
        radioArr.each(function() {
          var thisRadio = $(this);
          thisRadio.change(function() {
            labelArr.each(function() {
              thisPoint = $(this);
              if (thisPoint.hasClass("checked-radio")) {
                thisPoint.removeClass("checked-radio");
              }
            })
            var thisLabel = thisRadio.parent();
            if (this.checked) {
              $("#submit").removeAttr("disabled");
              thisLabel.addClass("checked-radio");
            }

          })
        })
      })

      if (myHtml.width() > 1170) {
        $(".tooltip-over").hover(
          function() {
            var tooltipLarge = $(this);
            tooltipLarge.next(".tooltip-text").addClass("over");
          },
          function() {
            var link = $(this);
            window.setTimeout(function() {
              $(link).next(".tooltip-text").removeClass('over');
            }, 3000);
          });

      }


      if (myHtml.width() < 1170) {
        $(".tooltip-over").click(function() {
          var element = $(this);
          if (element.next(".tooltip-text").hasClass("over")) {
            element.next(".tooltip-text").removeClass('over');
          } else {
            element.next(".tooltip-text").addClass("over");
          }
        })
      }

      $('form').submit(function(e) {
        e.preventDefault();
        showProgressBar();
        var data = $('form').serializeArray();
        $.ajax({
          type: "POST",
          url: "send.php",
          data: data,
          dataType: "html",
          success: hideProgressBar()
        });

        $(':input', 'form')
          .not(':submit')
          .val('')
          .removeAttr('checked');
      });

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          hideProgressBar();
        }
      }

    }
  }

}());




