var localStorageModule = (function () {

	//function for check pages, where functions will work
	function getLocation(page){
		var splitEl;
		if(page == "company"){
			splitEl = ".";
		}
		else{
			splitEl = "/";
		}
		var locationString = $(location).attr('href').split(splitEl).splice(-1,1).join();
		if(locationString != page){
			return false;
		}
		return true;
	}
	
	return {

		storageFunction: function () {
			//Grab the project name and store it in the localStorage
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

			//Grab a position title and store it in the localStorage
			else if(getLocation("career")){
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
			
			else if(getLocation("contact")){
			//Prefill the subject field from localStorage	
				var contactSubject = $('#contactform-subject');
			if(localStorage.getItem("projectName")){
				contactSubject.val("I am interested in the project similar to: \" " + localStorage.getItem("projectName") + "\"");
				}
			else if(localStorage.getItem("positionName")){
				contactSubject.val("Apply for the position: \"" + localStorage.getItem("positionName") + "\"");
			}

			//remember name and email and prefill the field
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
	}
	} 


}());