// ---------------------------------------------
//
// Advertise scripts
// for this theme
//
// 
// Available ad zones:
// 
// .ad-small-one
// .ad-small-two
// .ad-small-three
// .ad-small-four   -> all Zone 2
// 
// .ad-medium-one   -> Google Ad
// .ad-medium-two   -> Zone 1
// 
// .ad-leaderboard  -> Google Ad
// 
// ---------------------------------------------


//column-ads


// ---------------------------------------------
//
// OIO Code example
//
// 
// var width = screen.width;
// var rows = width < 500 ? 5 : 10;
// var cols = width < 500 ? 1 : 1;
// document.write('<scr'+'ipt src="/path/to/oiopub/js.php?zone=1&align=center&rows='+rows+'&cols='+cols+'"><\/scr'+'ipt>');
// 
// ---------------------------------------------

jQuery(document).ready(function($) {

  // Synchronous fix
  // http://stackoverflow.com/questions/28322636/synchronous-xmlhttprequest-warning-and-script
  // ---------------------------------
  $.ajaxPrefilter(function( options ) {
    options.async = true;
  });
  
  // Get base url
  // See functions.php
  // ---------------------------------
  var baseURL = URLData.siteurl;  

  // Function to display static ads
  // ---------------------------------
  function setAds() {

    $('.ad-small-two:not(.medium-up)').each(function(){
      var trigger = Math.random();
      $(this).html('');
      $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=2&markup_allow_style=false&repeats=false').appendTo($(this));         
    });
        
    $('.ad-medium-two').each(function(){      
      var trigger = Math.random();      
      $(this).html('');
      $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=1&rows=1&cols=2&markup_allow_style=false&repeats=false').appendTo($(this)); 
    });
  
    if (responsive_viewport < 739) {    
      
      // ad-small-two.medium-up von 2 auf 0
      $('.ad-small-two.medium-up').each(function(){
        var trigger = Math.random();        
        $(this).html('');
        $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=0&cols=0&markup_allow_style=false&repeats=false').appendTo($(this));
      });      
      
      
      // ad-small-three von 3 auf 1
      $('.ad-small-three').each(function(){
        if( $(this).find('li.oio-slot').length > 2 || $(this).find('li.oio-slot').length === 0 ) {
          var trigger = Math.random();
          $(this).html('');
          $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=1&markup_allow_style=false&repeats=false').appendTo($(this));        
        }
      }); 
      
      
      // ad-small-four von 4 auf 1    
      $('.ad-small-four').each(function(){
        var trigger = Math.random();
        $(this).html('');
        $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=1&markup_allow_style=false&repeats=false').appendTo($(this));
      }); 
             
      
      // ad-medium-one von 1 auf 0
      $('.ad-medium-one.medium-up').each(function(){        
        $(this).html('');
      }); 
    }
    
    
    if (responsive_viewport > 740) {
     
      // ad-small-two.medium-up von 0 auf 2
      $('.ad-small-two.medium-up').each(function(){        
        var trigger = Math.random();
        $(this).html('');
        $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=2&markup_allow_style=false&repeats=false').appendTo($(this));
      });   

      
      // ad-small-three von 1 auf 3
      $('.ad-small-three').each(function(){
        if( $(this).find('li.oio-slot').length < 3 || $(this).find('li.oio-slot').length === 0) {
        var trigger = Math.random();
          $(this).html('');
          $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=3&markup_allow_style=false&repeats=false').appendTo($(this));        
        }        
      }); 
      
     
      // ad-small-four von 1 auf 4    
      $('.ad-small-four').each(function(){
        var trigger = Math.random();
        $(this).html('');
        $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=4&markup_allow_style=false&repeats=false').appendTo($(this));
      }); 

     
      // ad-medium-one von 0 auf 1
      $('.ad-medium-one.medium-up').each(function(){        
        var trigger = Math.random();
        $(this).html('');
        $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=1&rows=1&cols=1&markup_allow_style=false&repeats=false').appendTo($(this));
      }); 
    }  
    

    if (responsive_viewport > 1023) {
      // ad-small-one von 0 auf 1
      $('.ad-small-one.large-only').each(function(){        
        var trigger = Math.random();
        $(this).html('');
        $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand='+trigger+'#type=banner&align=center&zone=2&rows=1&cols=1&markup_allow_style=false&repeats=false').appendTo($(this));
      });     
    }
  }
      
  var responsive_viewport = $(window).innerWidth()+15;
  setAds();
    
  // on resize - not supported by OIO yet
  // $(window).smartresize(function(){
  //   responsive_viewport = $(window).width()+15;
  //   dynamicAds();
  // });  
});