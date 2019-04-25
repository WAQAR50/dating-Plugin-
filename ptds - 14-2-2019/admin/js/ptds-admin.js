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
			var row_id = $(this).parent("td").parent("tr");
			var event_id = this.id;	
			var ajax_url = admin_ajax_object.ajaxurl; // so we access our ajax_url through the ajax_params object
			var data = {
				'action': 'dating_syste_close', 'event_id': event_id
			};
			$.confirm({
				title: 'Dating Event Deactivated',
				content: 'Are you sure you would like to deactivated PNC dating event',
				buttons: {
					confirm: function () {
							
						
						$.post(ajax_url, data, function(response) {
							
							$.alert(response);
							$(row_id).remove();
								//window.setTimeout(function(){location.reload(true)}, 1000);
							//location.reload(true);
							if($("#the-list tr").length < 1){
								$("#the-list").html('<tr class="no-items"><td class="colspanchange" colspan="5">No items found.</td></tr>');
							}
							
						});
							
						
					},
					cancel: function () {
						
					},
				}
			});


		
		
			
		});

	});

/*	$(document).ready(function() {
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
*/

	$(document).ready(function() {

		$('form.extend-dating-form').on('submit', function(e) {
			e.preventDefault();
			
			var extenddatingdays = $(this).find('input[name=extenddatingdays]').val();
			var extenddatingid = $(this).find('input[name=extenddatingid]').val();
			if(extenddatingdays == '' || extenddatingid == ''){
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
				$("form.extend-dating-form").hide(500).addClass('pt-hide');
				
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
			$(this).siblings("form.extend-dating-form").hide(500).addClass('pt-hide');
			
								  
		 }else{
			 $(this).siblings("form.extend-dating-form").show(500).addClass('pt-show');
			
		 }
		});		
	});


	// Activate dating form show close
	$(document).ready(function(e) {

		$('.activate-dating').on('click', '.activate-dating-class', function(e) {
			e.preventDefault();
			if ( $(this).siblings("form.activate-dating-form").hasClass('pt-show')){
			
				
			}
			else{
				$("form.activate-dating-form").removeClass('pt-show');
				$("form.activate-dating-form").hide(500).addClass('pt-hide');
				
			}
		});	
	});

	/*
	* Activate dating form show close
	*/
	$(document).ready(function(e) {
		$('.activate-dating').on('click', '.activate-dating-class', function(e) {
			e.preventDefault();		
		 if ( $(this).siblings("form.activate-dating-form").hasClass('pt-show')){
			$(this).siblings("form.activate-dating-form").removeClass('pt-show');
			$(this).siblings("form.activate-dating-form").hide(500).addClass('pt-hide');
			
								  
		 }else{
			 $(this).siblings("form.activate-dating-form").show(500).addClass('pt-show');
			
		 }
		});		
	});

	$(document).ready(function() {

		$('form.activate-dating-form').on('submit', function(e) {
			e.preventDefault();

			var activatedatingdays = $(this).find('input[name=activatedatingdays]').val();
			var activatedatingid = $(this).find('input[name=activatedatingid]').val();
			var activatedatinggender = $(this).find('input[name=ptds_gender]:checked').val();
			//alert(activatedatingid);
			//alert(activatedatinggender);
			//alert(activatedatingdays);

			if(activatedatingdays == '' || activatedatingdays == '' || activatedatinggender == '') {
					alert('please enter the form values');
			}else{
			var ptds_ajax_url = admin_ajax_object.ajaxurl; // so we access our ajax_url through the ajax_params object
			var data = {
				'action': 'ptds_dating_activate', 'ptdsdating_activatedays': activatedatingdays, 'ptdseventactivate_id': activatedatingid, 'activatedatinggender': activatedatinggender,
			};
		
			$.post(ptds_ajax_url, data, function(response) {
				alert(response);
				location.reload(true);
			});

			}

		});

	});	



	


})( jQuery );
