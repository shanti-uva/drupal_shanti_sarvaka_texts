(function($){

Drupal.behaviors.shantiTextsMainView = {


  attach: function (context, settings) {
    var viewContent = $('.view-content');
    viewContent.addClass('view-mode-1');
    var viewModeButtons = viewContent.insert("<ul class='view-mode-buttons'></ul>");
    console.log(viewModeButtons);
    
    // Create buttons
    
    
    // Create handlers to reformat 
  },
  
  detach: function (context, settings) {
    console.log("HOO");
  }

};

})(jQuery);

