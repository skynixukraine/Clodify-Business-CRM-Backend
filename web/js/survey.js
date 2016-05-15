var myModule = (function() {

  var cfg = {
        submitUrl: null
  },
      radioArr,
      labelArr,
      surveySection,
      formSent,
      progressBar,
      textFormSentSuccess = "You vote has been successfully submitted",
      textFormSentError = "Unfortunately, the server is temporarily unavailable. Please try again later.";

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
    changeFunction : function( config ) {

      cfg = $.extend(cfg, config);

      radioArr      = $('input:radio[name=answer]');
      labelArr      = $('input:radio[name=answer]').parent();
      surveySection =  $('.survey-wrap');
      formSent      = $('.form-sent');
      progressBar   = $(".loader");

      console.log( radioArr );

      for (var i = 0; i < radioArr.length; i++) {
        radioArr[i].onchange = function() {
          console.log("changed");
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

      var $form = $('#survey-voice');
      console.log('ajaxFormSubmit: ' + $form.length );

      $form.submit(function(e) {

        console.log('ajaxFormSubmit - SUBMITTED');
        e.preventDefault();
        showProgressBar();
        var data = $('form').serializeArray();
        $.ajax({
          type: "POST" ,
          url: cfg.submitUrl,
          data: data ,
          dataType: "json" ,
          success: function( response ){
            hideProgressBar();
            if ( response.success ) {

              surveySection.slideUp();
              formSent.slideDown().children("p").text( response.message );

            } else {

              formSent.fadeIn().children("p").text(response.message);
              window.setTimeout(function(){
                formSent.fadeOut();
              } , 5000);

            }
          } ,
          error: function(){
            hideProgressBar();
            formSent.fadeIn().children("p").text(textFormSentError);
            window.setTimeout(function(){
              formSent.fadeOut();
            } , 5000);
          }
        });
        return false;

     });
    }
  }

}());




