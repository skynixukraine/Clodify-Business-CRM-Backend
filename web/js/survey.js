var SurveyModule = (function() {

    var textFormSentSuccess = "Form has been sent successfully",
        textFormSentError = "Unfortunately, the server is temporarily unavailable. Please try again later.",
        progressBar = $(".loader");

    function showProgressBar() {
        progressBar.show();
    }

    function hideProgressBar() {
        progressBar.hide();
    }

    return {
        init: function() {

            var myHtml = $("html"),
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
                $(".survey-tooltip-over").mouseover(function() {
                    var tooltipLarge = $(this);
                    if (!tooltipLarge.hasClass("show")) {
                        tooltipLarge.nextAll(".survey-tooltip-text, .survey-tooltip-arrow").addClass("over");
                        tooltipLarge.addClass("show");
                        window.setTimeout(function() {
                            tooltipLarge.removeClass("show");
                            tooltipLarge.nextAll(".survey-tooltip-text, .survey-tooltip-arrow").removeClass('over');
                        }, 3000);
                    }
                })
            }

            if (myHtml.width() < 1170) {
                $(".survey-tooltip-over").click(function() {
                    var element = $(this);
                    if (element.nextAll(".survey-tooltip-text, .survey-tooltip-arrow").hasClass("over")) {
                        element.nextAll(".survey-tooltip-text, .survey-tooltip-arrow").removeClass('over');
                    } else {
                        element.nextAll(".survey-tooltip-text, .survey-tooltip-arrow").addClass("over");
                    }
                })
            }

            $('form').submit(function(e) {
                var surveySection = $('.survey-wrap'),
                    formSent = $('.form-sent'),
                    formSent = $('.form-sent');
                e.preventDefault();
                showProgressBar();
                var data = $('form').serializeArray();
                $.ajax({
                    type: "POST",
                    url: "",
                    data: data,
                    dataType: "json",
                    success: function() {
                        hideProgressBar();
                        surveySection.slideUp();
                        formSent.slideDown().children("p").text(textFormSentSuccess);
                    },
                    error: function() {
                        hideProgressBar();
                        formSent.fadeIn().children("p").text(textFormSentError);
                        window.setTimeout(function() {
                            formSent.fadeOut();
                        }, 5000)
                    }
                });
            });
        }
    }

}());
