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
			var row_id = $(this).parent("div").parent("td").parent("tr");
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

				$.confirm({
					title: '',
					content: response,
					buttons: {
						confirm: {
							text: 'OK',
							action:function () {		
								location.reload(true);
							}
						},
					}
				});


				//$.alert(response);
				//$(row_id).remove();


				//window.setTimeout(function(){location.reload(true)}, 1000);
				//location.reload(true);
				//if($("#the-list tr").length < 1){
					//$("#the-list").html('<tr class="no-items"><td class="colspanchange" colspan="5">No items found.</td></tr>');
				//}


				//alert(response);
				//location.reload(true);
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
			var row_id = $(this).parent("div").parent("td").parent("tr");
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
				//alert(response);
				$.alert(response);
				$(row_id).remove();
					//window.setTimeout(function(){location.reload(true)}, 1000);
				//location.reload(true);
				if($("#the-list tr").length < 1){
					$("#the-list").html('<tr class="no-items"><td class="colspanchange" colspan="5">No items found.</td></tr>');
				}
				//location.reload(true);
			});

			}

		});

	});	
/*	$(document).ready(function() {
		$("#attandees_add_more_button").click(function(){
				var test = 	$(this).find(".figure").text( );
				var num = parseInt(test);
				alert(num);
				$("#attandees_add_more_button .figure").text(num+1);
			});
	});
		*/
	//add more attendees fields
	$(document).ready(function() {
			 
		$('#attandees_add_more_button').on('click', function(e) {
			e.preventDefault();	

				var counter_value = $(this).find(".figure").text( );
				var num = parseInt(counter_value);
				var inputValue = num+1;
				$("#attandees_add_more_button .figure").text(num+1);


			
			var from_group_html = '<div class="attandees_form_fields_group row mb-3"><div class="md-form mb-2 col-md-4  col-sm-12"><input type="email" id="attendees_reg_email_'+ inputValue +'" class="ptdsemail form-control validate" name="attendees_reg_email"><label data-error="wrong" data-success="right" for="attendees_reg_email_'+ inputValue +'">Your email</label></div><div class="md-form mb-2 col-md-3  col-sm-12"><input type="text" id="attendees_reg_first_name_'+ inputValue +'" class="form-control validate" name="attendees_reg_first_name"><label data-error="wrong" data-success="right" for="attendees_reg_first_name_'+ inputValue +'">First Name</label></div><div class="md-form mb-2 col-md-3  col-sm-12"><input type="text" id="attendees_reg_last_name_'+ inputValue +'" class="form-control validate" name="attendees_reg_last_name"><label data-error="wrong" data-success="right" for="attendees_reg_last_name_'+ inputValue +'">Last Name</label></div><div class=" mb-2 col-md-2 col-sm-12"><label class="font-weight-bold mb-4" for="">Select Gender:</label><div class="d-flex text-left"><div class="custom-control custom-radio mr-4"><input type="radio" class="custom-control-input" id="attendees_reg_male_'+ inputValue +'" name="attendees_reg_gender" value="male"><label class="custom-control-label" for="attendees_reg_male_'+ inputValue +'">Male</label></div><div class="custom-control custom-radio ml-4"><input type="radio" class="custom-control-input" id="attendees_reg_female_'+ inputValue +'" name="attendees_reg_gender" value="female"><label class="custom-control-label" for="attendees_reg_female_'+ inputValue +'">Female</label></div></div></div><div class=" close_button w-100 text-right pr-4"><a  class="attandees_remove_more_button btn btn-danger  flex-row-reverse ">Remove</a></div></div>';
	
			$('#attendees-container-form').append(from_group_html);
			inputValue += 1;
		});

	});	

		//add more attendees fields
	$(document).ready(function() {

		$('form#attendees_resgistration_form .attandees_remove_more_button').live( "click", function(e) {
			e.preventDefault();	
			$(this).parent('.close_button').parent('.attandees_form_fields_group').remove();
		});

		// jquery
		$(".ptdsemail").live('change', function() {
			var ptdsemail = $(this).val();
			var test = $(this).parent('.md-form').parent('.attandees_form_fields_group');
			//alert(test);
			var vartestr = test.find("input");
			var idfil1 = vartestr.get(1).id;
			var idfil2 = vartestr.get(2).id;
			var idfil3 = vartestr.get(3).id;
			var idfil4 = vartestr.get(4).id;
			/*alert(idfil1);
			alert(idfil2);
			alert(idfil3);
			alert(idfil4);*/

			//ajax request
			$.ajax({
				url: admin_ajax_object.ajaxurl,
				data: {
					'action': 'ptds_datingemailcheck', 'ptdsemail': ptdsemail
				},
				dataType: 'json',
				success: function(data) {
				
					alert(idfil1);

					if(data.result) {
						alert('Email exists!');
						$("input[id=" + idfil1 + "]").val(data.first_name);
						$("input[id=" + idfil2 + "]").val(data.last_name);
						if(data.gender == 'male')
						{
							$("input[id=" + idfil3 + "]").attr( 'checked', true );
							$("input[id=" + idfil4 + "]").attr( 'checked', false );
						}else{
							$("input[id=" + idfil3 + "]").attr( 'checked', false);
							$("input[id=" + idfil4 + "]").attr( 'checked', true );
						}
					}
					else {
						alert('Email doesnt!');
					}
				},
				error: function(data){
					//error
				}
			});
		});


	});	



	


})( jQuery );
