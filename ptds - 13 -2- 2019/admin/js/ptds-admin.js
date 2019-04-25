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
		
			$.post(ajax_url, data, function(response) {
				alert(response);
				location.reload(true);
			});
			
		});

	});

	$(document).ready(function() {
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('extend-dating-form');
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
			});
		}, false);
	});	


	$(document).ready(function() {

		$('form.extend-dating-form').on('submit', function(e) {
			e.preventDefault();

			var extenddatingdays = $(this).find('input[name=extenddatingdays]').val();
			var extenddatingid = $(this).find('input[name=extenddatingid]').val();
			if(extenddatingdays == ''){
					alert('please enter the form values');
			}else{
			var ptds_ajax_url = admin_ajax_object.ajaxurl; // so we access our ajax_url through the ajax_params object
			var data = {
				'action': 'ptds_dating_extend', 'ptdsdating_days': extenddatingdays, 'ptdsevent_id': extenddatingid
			};
		
			$.post(ptds_ajax_url, data, function(response) {
				alert(response);
				location.reload(true);
			});

			}

		});

	});


	$(document).ready(function(e) {

		$('.extend-dating').on('click', '.extend-dating-class', function(e) {
			e.preventDefault();
			if ( $(this).siblings("form.extend-dating-form").hasClass('pt-show')){
			
				
			}
			else{
				$("form.extend-dating-form").removeClass('pt-show');
				$("form.extend-dating-form").addClass('pt-hide');
				$("form.extend-dating-form").slideUp(1000);
			}
		});	
	});

	/*
	* extended dating form show close
	*/
	$(document).ready(function(e) {
		$('.extend-dating').on('click', '.extend-dating-class', function(e) {
			e.preventDefault();		
			//$(this).siblings("form.extend-dating-form").toggleClass('pt-show');
		// if ( $(this).find("form.extend-dating-form").hasClass('pt-show')){
		// 	$(this).find("form.extend-dating-form").show(500);
		// }
		 if ( $(this).siblings("form.extend-dating-form").hasClass('pt-show')){
			$(this).siblings("form.extend-dating-form").removeClass('pt-show');
			$(this).siblings("form.extend-dating-form").addClass('pt-hide');
			$(this).siblings("form.extend-dating-form").slideUp(1000);
								  
		 }else{
			 $(this).siblings("form.extend-dating-form").addClass('pt-show');
			$(this).siblings("form.extend-dating-form").slideDown(1000);
		 }
		});		



	});

		
	


})( jQuery );
