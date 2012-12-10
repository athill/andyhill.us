// JavaScript Document
(function($){
 $.fn.simpleSlideshow = function() {          
    var defaults = {                             ////set up default parameters
		currentPosition: 0,
		slideWidth: 560,
    };
    var options = $.extend(defaults, options);   ////options will be the parameter scope
    return this.each(function() {                ////loop through each matched element
		$(this).addClass('simpleSlideshow');
		var slides = $('.slide', this);
		var numberOfSlides = slides.length;
		////.slidesContainer is where the slides appear
		slides.wrapAll('<div class="slidesContainer"></div>')
		$('.slidesContainer', this).css('overflow', 'hidden');
	  
		//// Wrap all .slides with .slideInner div
		slides
		  .wrapAll('<div class="slideInner"></div>')
		  //// readjust .slides width
		  .css({
			'width' : options.slideWidth
		  });
	  
		//// Set .slideInner width equal to total width of all slides
		$('.slideInner', this).css('width', options.slideWidth * numberOfSlides);
	  
		//// Insert controls in the DOM
		$(this)
		  .prepend('<span class="control leftControl">Clicking moves left</span>')
		  .append('<span class="control rightControl">Clicking moves right</span>');
	  
		//// Hide left arrow control on first load
		manageControls(options.currentPosition, this);
	  
		//// Create event listeners for .controls clicks
		$('.control', this).bind('click', function() {
		  var slideshow = $(this).closest('.simpleSlideshow');
		  //// Determine new position
		  options.currentPosition = ($(this).hasClass('rightControl')) ? 
		  		options.currentPosition+1 : 
				options.currentPosition-1;
		  
		  //// Hide / show controls
		  manageControls(options.currentPosition, slideshow);
		  //// Move slideInner using margin-left
		  $('.slideInner', slideshow).animate({
			'marginLeft' : options.slideWidth*(-options.currentPosition)
		  });
		});
	  
		//// manageControls: Hides and Shows controls depending on currentPosition
		function manageControls(position, parent){
		  //// Hide left arrow if position is first slide
		  (position==0) ? $('.leftControl', parent).hide() :  $('.leftControl', parent).show();
		  //// Hide right arrow if position is last slide
		  (position==numberOfSlides-1) ? $('.rightControl', parent).hide() : $('.rightControl', parent).show();
		}	
    });
 };
})(jQuery);
