(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function($) {
		$('.ptds_dating_close').on('click', function(e) {	
			
			e.preventDefault();
			var event_id = this.id;	
			var ajax_url = admin_ajax_object.ajaxurl; // so we access our ajax_url through the ajax_params object
			var data = {
				'action': 'dating_syste_close', 'dating_meta': 'ptdsdatingclose', 'event_id': event_id
			};
		
			$.post(ajaxurl, data, function(response) {
				alert(response);
			});
			
		});
	});
})( jQuery );
