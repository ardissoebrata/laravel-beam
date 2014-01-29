// IIFE - Immediately Invoked Function Expression
// http://stackoverflow.com/questions/18307078/jquery-best-practises-in-case-of-document-ready
(function($, window, document) {

	// The $ is now locally scoped 

	// Listen for the jQuery ready event on the document
	$(function() {

		// The DOM is ready!
		$('.selectpicker').selectpicker();

	});

	// The rest of the code goes here!

}(window.jQuery, window, document));
// The global jQuery object is passed as a parameter