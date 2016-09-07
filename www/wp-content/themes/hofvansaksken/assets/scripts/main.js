/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {


  var Hints = {

    maxlengthIndicator: function($target) {
        
        $target.keyup(function(){  
              //get the limit from maxlength attribute  
              var limit = parseInt($(this).attr('maxlength'));  
              //get the current text inside the textarea  
              var text = $(this).val();  
              //count the number of characters in the text  
              var chars = text.length;  
        
              //check if there are more characters then allowed  
              if(chars === limit){  
                  //and if there are use substr to get the text before the limit  
                  var new_text = text.substr(0, limit);  
                  //and change the current text with the new text  
                  $(this).val(new_text);  
                  Hints.addWarning($target);
              } else {
                
                 Hints.removeWarning($target);
              }  
          });
    },
    cloneInput: function($original, $target ) {
        
          $original.keyup(function( event ) {
          //cloen the text
          var input = "Hallo " + $original.val();
          $target.text( input );
          //console.log(input.length);
        });
    },
    checkEmail: function($target ) {

      $($target).blur( function(event){
        if( !Hints.validEmail($target.val()) ){
          Hints.isnotValid($target);
        } else {
          Hints.isValid($starget);
        } 
      });


    },
    validEmail: function(emailAddress ) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    },
    checkifValid: function($target, condition) {

      if(condition==='empty'){
        Hints.checkIfEmpty($target); 
        return true;       
      }

      if(condition==='email'){
        Hints.checkEmail($target);
        return true;
      }

    },

    checkIfEmpty: function($target) {
        $($target).blur( function(event){
            if( Hints.isEmpty($target)  ){
              //console.log($target); 
              Hints.isnotValid($target);
            } else {
              Hints.isValid($target);
            }
          }
        );

        $($target).focus( function(event){
          Hints.removeWarning($target);
        });


    },
    isEmpty: function($target) { 
        return (($target.val()) ? false : true);  
    },
    isnotValid: function($target) { 
      //change the attribute
      $target.attr('has-validated',"false");  
      //fire event
      $(document).trigger('has-validated-changed');
      Hints.addWarning($target);
    },
    isValid: function($target) { 

      $target.attr('has-validated',"true");  
      
      //fire event
      $(document).trigger('has-validated-changed');

      Hints.removeWarning($target);
      console.log($target);
    },
    addWarning: function($target) { 
       $target.addClass('warning'); 
       return true;
    },
    removeWarning: function($target) { 
      
      $target.removeClass('warning');
      return true;
    },
    //check to see if all has-validated attributes are set to true
    checkFormValid: function( $target  ) { 


      Hints.disable($target);

      //monitor the attribute chage
      $(document).on('has-validated-changed', function() {
        //var data = $('#contains-data').data('mydata');
        
        total_validations = $("input[has-validated='false']").length;
        
        if(total_validations===0){
           Hints.enabled($target); 
        } else{
          Hints.disable($target);
        } 
      });    

      //console.log($target);
      //console.log($("input[has-validated='false']").length);
      //var n = $( "div" ).length;

    },
    disable: function( $target  ) { 
        $target.removeClass('enabled');        
        $target.addClass('disabled');        
    },
    enabled: function( $target  ) { 
        $target.removeClass('disabled');        
        $target.addClass('ensabled');        
    }


  };

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
        
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired

      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // Home page
    'ontvanger': {
      init: function() {
        // JavaScript to be fired on the ontvanger page
      },
      finalize: function() {
        // JavaScript to be fired on the ontvanger page, after the init JS

        //page has inpput with maxlength
        Hints.maxlengthIndicator($("input#ontvanger"));
        //add clone funtionality
        Hints.cloneInput($("input#ontvanger"), $("label.ontvanger"));
        //add validation for input
        Hints.checkifValid($("input#ontvanger"),'empty');
        Hints.checkifValid($("input#email_ontvanger"),'empty');
        Hints.checkifValid($("input#email_ontvanger"),'email');
        //add email validation
        

        Hints.checkFormValid( $("button[type='submit']") );


      }
    },

    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
