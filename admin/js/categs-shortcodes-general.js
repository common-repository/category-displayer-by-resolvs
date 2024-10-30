(function( $ ) {
	'use strict';

	$(function() {

		/* Handle Media uploader */
			// on upload button click
			$('body').on( 'click', '#categdisp_tax_media_button', function(e){
				e.preventDefault();
				var button = $(this),
				custom_uploader = wp.media({
					title: 'Insert image',
					library : {
						// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
						type : 'image'
					},
					button: {
						text: 'Use this image' // button label text
					},
					multiple: false
				}).on('select', function() { // it also has "open" and "close" events
					var attachment = custom_uploader.state().get('selection').first().toJSON();
                    // console.log(attachment.id);
                    $("#categdisp_img_id").val(attachment.id);
					$("#categdisp_image_wrapper").html('<img src="' + attachment.url + '" style="margin:0;padding:0;max-height:150px;float:none;" >').next().val(attachment.id).next().show();
                    button.hide();
                    button.next().show();
				}).open();
			});

			// on remove button click
			$('body').on('click', '#categdisp_tax_media_remove', function(e){
				e.preventDefault();
                var button = $(this);
                $("#categdisp_image_wrapper").html('');
                $("#categdisp_img_id").val(''); // emptying the hidden field
				button.hide().prev().html('Upload image').show();
			});
		/* END Handle Media uploader */

		/* Handle Icon picker */
		$(".icp-single_categs").iconpicker();
		/* END Handle  Icon picker */





		/* Catdisp Settings page -> save settings */
		var is_saving = false;
		$('form#categdisp_settings .formsubmit').on('click', function (e) {
			if(is_saving) return;
			is_saving = true;
			var btn = $(this);
			btn.addClass('animate-action-btn');
			var categdisp_form = $('form#categdisp_settings');
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: $(categdisp_form).serialize()+'&security='+categ_disp_obj.catdisp_nonce,
				success: function(response, status, xhr) {
					// console.log(response);
					is_saving = false;
					location.reload();
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
					is_saving = false;
					btn.removeClass('animate-action-btn');
				},
			});
		});





		/* Remove all files and database related to the plugin when plugin is being uninstalled. -> save settings */
		var is_saving2 = false;
		$('#catdisp_removefiles_ondelete').on('change', function (e) {
			if(is_saving2) return;
			is_saving2 = true;

			var categdisp_form = $('form#categdisp_settings');
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data:{
					action   : 'catdisp_removefiles_ondelete',
					security : categ_disp_obj.catdisp_nonce,
					delete   : $(this).is(':checked')
				},
				success: function(response, status, xhr) {
					// console.log(response);
					is_saving2 = false;
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
					is_saving2 = false;
				},
			});
		});


		var is_sending = false;
		$('#form-feedback #submit-feedback').on('click', function (e) {
			if(is_sending) return;
			is_sending = true;
			$("#validate-feedback-submit").removeClass('notice-error').html('').hide();
			var fdb_title = $("#fdb-title").val();
			var fdb_desc  = $("#fdb-desc").val();
			if(fdb_title=='' || fdb_desc ==''){
				$("#validate-feedback-submit").addClass('notice-error').append('<p class="text-red">Please fill in all fields!</p>').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#validate-feedback-submit").offset().top - 100
				}, 1000);
				is_sending = false;
				return false;
			}
			
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action       : 'catdisp_submit_feedback',
					fdb_title    : fdb_title,
					fdb_desc     : fdb_desc,
					security     : categ_disp_obj.catdisp_nonce
				},
				success: function(response, status, xhr) {
					// console.log(response);
					if(response.hasOwnProperty('error')){
						$("#validate-feedback-submit").addClass('notice-error').append('<p class="text-red">'+response.error+'</p>').show();
						$([document.documentElement, document.body]).animate({
							scrollTop: $("#validate-feedback-submit").offset().top - 100
						}, 1000);
					}
					else{
						$("#validate-feedback-submit").append('<p>'+response.msg+'</p>').show();
						$('#form-feedback').trigger("reset");
						$([document.documentElement, document.body]).animate({
							scrollTop: $("#validate-feedback-submit").offset().top - 100
						}, 1000);
					}
					is_sending = false;
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
					is_sending = false;
				},
			});
		 
			
		});

    })
})( jQuery );
