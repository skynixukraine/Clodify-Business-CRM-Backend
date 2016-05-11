var localStorageModule = (function () {

	//function for check pages, where functions will work
	function getLocation(page){
		var loc = $(location).attr('href').split('/').splice(-1,1);
		if(loc!= page){
			return false;
		}
		return true;
	}
	
	return {
	//Grab the project name and store it in the localStorage
	homePageProject: function () {
			if (getLocation("company")){
			var ourProjects = $('.mask');
					var projectNameValue;
					ourProjects.each(function() {
					var project = $(this);
					project.click(function() {
						projectNameValue = $(this).next().text(); 
						localStorage.setItem("projectName", projectNameValue);
					});
				})
			}
		
	} ,

	//Grab a position title and store it in the localStorage
	careerPageVacation: function () {
		if(getLocation("career")){
			var careerVacation = $('button.read-more'); 
			var vacationNameValue;
			careerVacation.each(function() {
			var vacation = $(this);
			vacation.click(function(){
				vacationNameValue = $(this).parent().find(".txt h3:first-child").text();
				localStorage.setItem("positionName", vacationNameValue);
			});
		})
		}
	
	} ,

	//remember name and email and prefill the field
	inputFunction: function(){
		if(getLocation("contact")){
			if(window.localStorage){
			var localInput = $('#contactform-name, #contactform-email');
			localInput.each(function(){
				var element = $(this);
				(function(element){
					var element = $(element);
					var key = element.attr('name');
					element.val(localStorage.getItem(key)|| '');
					element.keyup(function(){
						localStorage.setItem(key, element.val());
					});
				})(element);
			})
		}
		}
			
	} ,



	//Prefill the subject fielf from localStorage
	subjectLocal: function(){
		if(getLocation("contact")){
			var contactSubject = $('#contactform-subject');
		if(localStorage.getItem("projectName")){
			contactSubject.val("I am interested in the project similar to: \" " + localStorage.getItem("projectName") + "\"");
		}
		else if(localStorage.getItem("positionName")){
			contactSubject.val("Apply for the position: \"" + localStorage.getItem("positionName") + "\"");
		}
		}
	}
		

}

}());