(function( $ ) {
	'use strict';

	$(function() {
	
		/* Template Library - Show template pop-up information */
		$(document).on('click','#template_library_boxes .show-template-library, #template_library_boxes .template-learn-more', function(){
		// $('#template_library_boxes .show-template-library, #template_library_boxes .template-learn-more').on('click', function(){
			var box_template = $(this).closest('.box-template');
			/* Add empty html on modal */
			$("#modal_template_library").html(categ_disp_obj.tpl_library);
			/* Add title */
			$("#modal_template_library h1").html(box_template.attr("data-tpl_title"));
			$("#modal_template_library .template-price").html(box_template.find('.template-price').text());
			/* Add tags*/
			$("#modal_template_library .modal-template-tags").html(box_template.find('.template-tags').clone());
			/* Add preview */
			$("#modal_template_library .left-column").prepend(box_template.find('.show-template-library').clone());
			$("#modal_template_library .template-description").html(box_template.attr("data-tpl_desc"));
			/* Add gallery */
			var image_galleries = box_template.attr("data-tpl_gallery");
			image_galleries = jQuery.parseJSON(image_galleries);
			$.each( image_galleries, function( key, value ) {
				$("#modal_template_library .template-gallery").append('<a href="'+image_galleries[key].full+'" data-lightbox="tpl_gallery" class="a"><img src="'+image_galleries[key].thumb+'"></a>');
			});
			/* Add btn text Import vs Purchase */
			$("#modal_template_library #btn_template").text(box_template.attr("data-tpl_btn_txt")).attr('data-tpl_id',box_template.attr('data-tpl_id'));
			/* Open tickbox */
			tb_show('Template Information', '#TB_inline?inlineId=modal_template_library&width=1000&height=600');
		});



		/* Search Filter */
		$("#categs_search-template").keyup(function() {
			var filter = $(this).val();
			// Loop through the comment list
			$('#template_library_boxes > div').each(function() {
			  // If the list item does not contain the text phrase fade it out
			  if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				$(this).hide(); 
			  } else {
				$(this).show(); 
			  }
			});
		  });

		/* Populate Categories Filter */
		function distinct(value, index, self) { 
			return self.indexOf(value) === index;
		}
		
		function popupate_filter_categories(){
			var filters = [];
			$.each($("#template_library_boxes .box-template"), function(i, item) {
				var tags_cats = $(this).attr('data-tags_cats');
				tags_cats = JSON.parse(tags_cats);
				filters = filters.concat(tags_cats);
			});
			filters = filters.filter( distinct );
			var filters_html = '';
			$.each($(filters), function(i, item) {
				filters_html += '<li class="text-black"><input id="category-'+item+'" type="checkbox" value="'+item+'" name="filter-categories"><label for="category-'+item+'">'+item+'</label></li>';
			});
			$("#cat_disp_filter_templates").html('').html(filters_html);
		};

		popupate_filter_categories();
		

		/* Checkbox filter - tags & categories */
		// $("input[name=filter-categories").change(function() {
		$(document).on('change', 'input[name=filter-categories]', function() {
			if ($('input[name=filter-categories]:checked').length > 0) {
				$('#template_library_boxes > div').hide();
			}
			else{
				$('#template_library_boxes > div').show();
			}
			$('input[name=filter-categories]:checked').each(function() {
				// console.log($(this).val());
				var filter_checkbox = $(this).val();

				$('#template_library_boxes > div').each(function() {
					if ($(this).find('.template-tag').text().search(new RegExp(filter_checkbox, "i")) >= 0) {
						$(this).show(); 
					  } 
				});
			});
		});


		/* Import template AJAX action */
		var is_importing = false;
		$(document).on('click','.modal-show-template-library #btn_template', function(){
			
			if(is_importing) return;
			is_importing = true;
			var import_btn = $(this);

			import_btn.addClass('animate-action-btn').next( ".ajax-response" ).html('');

			var box_template = $("#template_library_boxes").find('.box-template[data-tpl_id="'+$(this).attr('data-tpl_id')+'"]');

			jQuery.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action       : 'import_template',
					tpl_id       : import_btn.attr('data-tpl_id'),
					tpl_title    : box_template.attr('data-tpl_title'),
					tpl_desc     : box_template.attr('data-tpl_short_desc'),
					tpl_cust     : box_template.attr('data-tpl_customisation'),
					tpl_default  : box_template.attr('data-tpl_default'),
					security     : $("#catdisp_tmpl_nonce").val()
				},
				success: function(response, status, xhr) {
					// console.log(response)
					response = JSON.parse(response);
					if(!response.error){
						import_btn.next( ".ajax-response" ).html('<p class="response-msg p-0 font-weight-600">'+response.msg+'</p>');
						
						$('.box-template[data-tpl_id="'+import_btn.attr('data-tpl_id')+'"]').find('.ajax-response').html('');
						$('.box-template[data-tpl_id="'+import_btn.attr('data-tpl_id')+'"]').appendTo("#installed_templates_boxes");
						popupate_filter_categories();

						setTimeout(function(){ 
							tb_remove();
						}, 1000);
					}
					else{
						import_btn.next( ".ajax-response" ).html('<p class="error-msg text-red p-0">'+response.error+'</p>');
					}
					is_importing = false
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
					is_importing = false;
					import_btn.removeClass('animate-action-btn')
				},
			});
		});


		/* Uninstall template AJAX action */
		var is_uninstalling = false;
		$(document).on('click','#installed_templates_boxes .uninstall-template', function(){
			if(is_uninstalling) return;
			is_uninstalling = true;

			var btn_uninstall = $(this);
			btn_uninstall.addClass('animate-action-btn').find('.ajax-response').html('');
			var box_template = $(this).closest('.box-template');

			jQuery.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action   : 'uninstall_template',
					tpl_id   : box_template.attr('data-tpl_id'),
					security : $("#catdisp_tmpl_nonce").val()
				},
				success: function(response, status, xhr) {
					// console.log(response)
					response = JSON.parse(response);
					if(!response.error){
						box_template.find( ".ajax-response" ).html('<span class="response-msg text-black p-0 font-weight-400 w-100 d-inline-block">'+response.msg+'</span>').show();
						setTimeout(function(){ 
							/* Move template to uninstalled */
							box_template.appendTo("#template_library_boxes");

							/* re-arrange uninstalled templates  */
							var divList = $("#template_library_boxes .box-template");
							divList.sort(function(a, b){ return $(a).data("tpl_id")-$(b).data("tpl_id")});
							$("#template_library_boxes").html(divList);
							popupate_filter_categories();

						}, 1000);
						
						
					}
					else{
						box_template.find( ".ajax-response" ).html('<span class="error-msg text-red p-0 font-weight-400  w-100 d-inline-block">'+response.error+'</span>').show();
					}
					is_uninstalling = false
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
					is_uninstalling = false;
					btn_uninstall.removeClass('animate-action-btn');
				},
			})
		});



	})




})( jQuery );
