var myModule = (function() {

  var radioArr = $('input:radio[name=radio]');
  var labelArr = $('input:radio[name= radio]').parent();
  var surveySection =  $('.survey-wrap');
  var formSent = $('.form-sent');
  var textFormSentSuccess = "Form has been sent successfully";
  var textFormSentError = "Unfortunately, the server is temporarily unavailable. Please try again later."
  var progressBar = $(".loader");

  function showProgressBar() {
   progressBar.css("display", "block");
  }

  function hideProgressBar() {
   progressBar.css("display", "none");
  }

  
  return {

    tooltipLargeScreen : function() {
      $(".tooltip-over").hover(
        function() {
          var tooltipLarge = $(this);
          tooltipLarge.next(".tooltip-text").addClass("over");
        } ,
        function() {
          var link = $(this);
          window.setTimeout(function() {
            $(link).next(".tooltip-text").removeClass('over');
          }, 3000);
        });

    } ,

    tooltipSmallScreen : function() {
      $(".tooltip-over").click(function() {
        var element = $(this);
        if (element.next(".tooltip-text").hasClass("over")) {
          element.next(".tooltip-text").removeClass('over');
        } else {
          element.next(".tooltip-text").addClass("over");
        }
      })
    } ,

    //Function for tracking changes in the radio buttons
    changeFunction : function() {
      for (var i = 0; i < radioArr.length; i++) {
        radioArr[i].onchange = function() {
          for (var k = 0; k < labelArr.length; k++) {
            if (labelArr.hasClass("checked-radio")) {
              labelArr.removeClass("checked-radio");
            }
          }
          var thisLabel = $(this).parent();
          if (this.checked) {
            $("#submit").removeAttr("disabled");
            thisLabel.addClass("checked-radio");
          }

        }
      }
    } ,

    ajaxFormSubmit : function() {
      $('form').submit(function(e) {
        e.preventDefault();
        showProgressBar();
        var data = $('form').serializeArray();
        $.ajax({
          type: "POST" ,
          url: "send.php" ,
          data: data ,
          dataType: "json" ,
          success: function(){
            hideProgressBar();
            surveySection.slideUp();
            formSent.slideDown().children("p").text(textFormSentSuccess);
          } ,
          error: function(){
            hideProgressBar();
            formSent.fadeIn().children("p").text(textFormSentError);
            window.setTimeout(function(){
              formSent.fadeOut();
            } , 5000)
          }
        });
     });
    }
  }

}());




