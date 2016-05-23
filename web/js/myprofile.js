var MyProfileModule = (function(){
	return{
		init: function(){
			var tabContentInput = $(".tab-content input, .tab-content textarea");
			var tabContentImg = $(".dropzone-previews img");
			console.log(tabContentImg);
			
			function inputChange(){
				tabContentInput.each(function(){
					thisInput = $(this);
					thisInput.change(function(){
						$(".btn.btn-primary").removeAttr("disabled");
       					$(".btn-primary").css("background", "green");	
					})
				})
			}

			function imgChange(){
				tabContentImg.each(function(){
					thisImg = $(this);
					thisImg.click(function(){
						$(".btn.btn-primary").removeAttr("disabled");
       					$(".btn-primary").css("background", "green");	
					})
				})
			}
			inputChange(); 
			imgChange();
		}
	}
})();


