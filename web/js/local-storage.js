var localStorageModule = (function () {

	var ourProjects = $('.mask');
	var careerVacation = $('button.read-more'); 
	var contactName = $('#contactform-name');
	var contactEmail = $('#contactform-email');
	var contactSubject = $('#contactform-subject');
	
	return {
	
	//Grab the project name and store it in the localStorage
	homePageProject: function () {
		
		var projectNameValue;
		$.each(ourProjects, function(i) {
			ourProjects[i].onclick = function() {
				projectNameValue = $(this).next().text(); 
				localStorage.setItem("projectName", projectNameValue);
			}
		})
		
	} ,

	//Grab a position title and store it in the localStorage
	careerPageVacation: function () {
		var vacationNameValue;
		$.each(careerVacation, function(i) {
			careerVacation[i].onclick = function(){
				vacationNameValue = $(this).parent().find(".txt h3:first-child").text();
				localStorage.setItem("positionName", vacationNameValue);
			}
		})
	} ,

	//remember name and email and prefill the field
	inputFunction: function(){
		if(window.localStorage){
			var localInput = $('#contactform-name, #contactform-email');
			$.each(localInput, function(i){
				(function(element){
					var element = $(element);
					var key = element.attr('name');
					element.val(localStorage.getItem(key)|| '');
					element.keyup(function(){
						localStorage.setItem(key, element.val());
					});
				})(localInput[i]);
			})
		}
	} ,



	//Prefill the subject fielf from localStorage
	subjectLocal: function(){
		if(localStorage.getItem("positionName")){
			contactSubject.val("I am interested in the project similar to: \" " + localStorage.getItem("projectName") + "\"");
		}
		else if(localStorage.getItem("projectName")){
			contactSubject.val("Apply for the position " + localStorage.getItem("positionName"));
		}
	}

}

}());

