(function ($) {

	// targets click-hover on whole teaser box not just title text anchor
	Drupal.behaviors.shantiTextsTeaserTargetAll = {
		attach: function (context, settings) {
		  if(context == window.document) {

		    $(".view-all-texts .views-row").click(function() {
		      $(this).toggleClass("views-row-active");
		      window.location=$(this).find('a').attr('href');
		      return false;
		    });

		    $(".view-all-texts .views-row").hover(function() {
		    	$(this).toggleClass("views-row-hover");
		    });	

		  }
		} 
	};


}(jQuery));