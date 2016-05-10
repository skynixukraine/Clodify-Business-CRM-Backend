var localStorageModule = (function () {

	var ourProjects = $('.portfolio a');
	var careerVacation = $('.career article .read-more'); 
	var contactName = $('#contactform-name');
	var contactEmail = $('#contactform-email');
	var contactSubject = $('#contactform-subject');
	
	return {
	
	// checkSupport: function () {
	// 		try {
	// 			return 'localStorage' in window && window['localStorage'] !== null;
	// 		} catch (e) {
	// 			return false;
	// 		}
	// 	}
	// } ,

	//Grab the project name and store it in the localStorage
	homePageProject: function () {
		var projectNameValue;
		for (var i = 0; i < ourProjects.length; i++){
			console.log(ourProjects[i]);
			ourProjects[i].onclick = function(){
				projectNameValue = ourProjects[i].children("h3"); 
					localStorage.setItem("projectName", projectNameValue);
					console.log(localStorage.getItem("projectName"));
			}
		}
	} ,

	//Grab a position title and store it in the localStorage
	careerPageVacation: function () {
		var vacationNameValue;
		for (var i = 0; i < careerVacation.length; i++){
			careerVacation[i].onclick = function(){
				vacationNameValue = careerVacation[i].parent("article>.txt>h3:first-child");
				localStorage.setItem("positionName", vacationNameValue);
			}
		}
	} ,

	//remember name and email and prefill the field
	inputFunction: function(){
		if(window.localStorage){
			var localInput = $('#contactform-name, #contactform-email');
			for(var i = 0; i < localInput.length; i++){
				(function(element){
					var element = $(element);
					var key = element.attr('name');
					element.val(localStorage.getItem(key)|| '');
					element.onkeyup = function(){
						localStorage.setItem(key, element.val());
						console.log(key);
					};
				})(localInput[i]);
			}
		}
	} ,


	//Prefill the subject fielf from localStorage
	subjectLocal: function(){
		if(localStorage.getItem("positionName")){
			contactSubject.val("I am interested in the project similar to " + localStorage.getItem("positionName"));
		}
		else if(localStorage.getItem("projectName")){
			contactSubject.val("Apply for the position " + localStorage.getItem("projectName"));
		}
	}

}

}());