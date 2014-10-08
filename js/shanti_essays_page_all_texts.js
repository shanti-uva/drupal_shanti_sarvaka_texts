// shanti_essays_page_all_texts.js

(function($){

var state       = 'fat-list';
var stateTypes  = ['fat-list','thin-list','grid']; // Note: these are used in the states object and in classes in the template
var stateCookie = 'view_state';

Drupal.behaviors.shantiTextsAllTexts = {

  attach: function (context, settings) {

    if ($.cookie(stateCookie)) {
      state = $.cookie(stateCookie);
    } else {
      $.cookie(stateCookie,state);
    }
  
    // We define these here since we may want to do some calculations
    var states = {
      'fat-list': {
          '.views-row': {
            'float': 'left',
            'width': '100%',
            'height': '220px', // Get this from a setting ... Inspect the view for image style
            'background': 'white',
            'padding-bottom': '20px',
            'padding-right': '20px',
            'margin': '0 0 20px'
          },
          '.views-field-title h3': {
            'font-size': '24px',
            'margin-right': '10px',
            'margin-bottom': '5px',
            'margin-top': '20px'
          },
          '.views-field-field-general-featured-image img': {
            'float': 'left',
            'margin-right': '20px',
            'height': '220px',
            'width': '220px'
          },
          '.views-field-field-dc-creator-author-1': {
            'font-size': '14pt',
            'font-style': 'italic',
            'color': 'gray'        
          },
          '.views-field-field-dc-description': {
            'font-size': '14pt',
            'overflow': 'scroll'
          }
      },
      'thin-list': {
          '.views-row': {
            'float': 'left',
            'width': '100%',
            'height': '110px',
            'background': 'white',
            'padding-bottom': '10px',
            'padding-right': '20px',
            'margin': '0 0 10px'
          },
          '.views-field-title h3': {
            'font-size': '18px',
            'margin-right': '10px',
            'margin-bottom': '5px',
            'margin-top': '10px'
          },
          '.views-field-field-general-featured-image img': {
            'float': 'left',
            'margin-right': '10px',
            'height': '110px',
            'width': '110px' 
          },
          '.views-field-field-dc-creator-author-1': {
            'font-size': '12pt',
            'font-style': 'italic',
            'color': 'gray'        
          },
          '.views-field-field-dc-description': {
            'font-size': '12pt',
            'overflow': 'scroll'
          }
      },
      'grid': {  
          '.views-row': {
            'width': '48%',
            'height': '220px',
            'float': 'left',
            'overflow': 'hidden',
            'margin': '10px'
          },
          '.views-field-title h3': {
            'font-size': '20px',
            'margin-bottom': '5px',
            'margin-top': '10px'  
          },
          '.views-field-field-general-featured-image img': {
             'height': '220px',    
             'width': '220px'
          },
          '.views-field-field-dc-creator-author-1': {
            'font-size': '12pt',
            'font-style': 'italic',
            'color': 'gray'        
          },
          '.views-field-field-dc-description': {
            'font-size': '12pt',
          }
      },
    };
    
    //$('#block-system-main').hide();
    changeState(state); // Executed with this behavior is attached
    //$('#block-system-main').show();
    
    function changeState(mystate,speed) {
      speed = typeof speed !== 'undefined' ? speed : 'fast';
      for (var sel in states[mystate]) {
        $(sel).transition(states[mystate][sel],speed);
      }    
      for (var i in stateTypes) {
        if (stateTypes[i] == mystate) {
          $('#view-all-texts-switcher li.'+stateTypes[i]).addClass('on');
        } else {
          $('#view-all-texts-switcher li.'+stateTypes[i]).removeClass('on');        
        }
      }
      $.cookie(stateCookie,mystate);
      state = mystate;
    }

    // Event handlers for view switch buttons
    
    $('li .shanticon-list').click(function(){
      changeState('fat-list');
    });

    $('li .shanticon-list4').click(function(){
      changeState('thin-list');
    });

    $('li .shanticon-grid').click(function(){
      changeState('grid');  
    });
    
    
  },

  detach: function (context, settings) {
    $.removeCookie(stateCookie);
  },

};
  
})(jQuery);