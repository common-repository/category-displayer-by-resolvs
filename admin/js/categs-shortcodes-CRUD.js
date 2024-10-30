(function( $ ) {
	'use strict';

	$(function() {

		/* Layout templates SLIDER */
			var slider = $(".templates-slideshow"),
			item_width = slider.parent().outerWidth()-30,
			timer = null;
			$( window ).on( "resize", adjust );
			$( window ).load(function() {
				adjust();
				var checked = slider.find('input[name="rscdForm[tpl_id]"]:checked');
				if(checked.length){
					if(!checked.closest('.layout-template').is( ":first-child" )){
						slider.children(".layout-template.active").prependTo( slider );
					}
				}
			});

			// Click handlers
			if ( slider.children(".layout-template ").length > 2 ) {
				// Add previous/next links
				slider.parent().append('<a href="#" id="btn-prev" class=""><i class="fa fa-angle-left"></i></a><a href="#" id="btn-next"><i class="fa fa-angle-right"></i></a>');

				slider.parent().on("click", "a#btn-prev", function(e){
					e.preventDefault();

					slider.children(".layout-template:last").prependTo( slider );
					slider.css("left", -item_width/2);

					slider.animate({
						left: 0
					}, 300, 'swing');
				});

				slider.parent().on("click", "a#btn-next", function(e){
					e.preventDefault();

					slider.animate({
						left: -item_width/2
					}, 300, 'swing', function(){
						slider.children(".layout-template:first").appendTo( slider );
						slider.css("left", 0);
					});
				});
			}

			function adjust(){
				item_width = slider.parent().outerWidth() -15;
				slider.children(".layout-template").width( item_width/2 ).parent().width( item_width/2 * slider.children(".layout-template").length );
			}
		/* END Layout templates SLIDER */

		

        var iteration = 0;
        var elem_id = '';
		var elements_number = 0;
		var finish_load = false;
		var populated_defaults, populated_values;

        function parseJson(json_content, parent, elem_id, populate_type){

            if($(parent).find('.children')){
                $(parent).find('.children').append('<div id="el-'+elem_id+'"></div>');
            } 
            if($(parent+'.children')){
                $(parent+'.children').append('<div id="el-'+elem_id+'"></div>');
            }
            var unique_id, unique_identifier;
            unique_identifier = Date.now()+'-'+iteration;
            if(json_content['id']){
                unique_id = json_content['id'];
            }
            else{
                unique_id =  json_content['elem']+'-'+unique_identifier;
			}
			
			var elementObject = {
				'action'        : 'categdisp_load_element',
				'security'		: categ_disp_obj.categdisp_load_element,
                'data': {
					'file_name'		: json_content['elem'],
					'data-cust'     : json_content['data-cust'],
					'type'          : json_content['type'],
					'name'          : json_content['name'],
					'has-hover'     : json_content['has-hover'],
					'tooltip'       : json_content['tooltip'],
					'values'        : json_content['values'],
					'label'         : json_content['label'],
					'id'            : json_content['id'],
					'class'         : json_content['class'],
					'target'        : json_content['target'],
					'target_tab'    : json_content['target_tab'],
					'title'         : json_content['title'],
					'data-target'   : json_content['data-target'],
					'has_slider'    : json_content['has_slider'],
					'slide_down'    : json_content['slide_down'],
					'unique_id'     : unique_id,
					'select_categs' : $("#categs_settings > select").val(),
					'taxonomy'      : $('#categdisp_taxonomy').val(),
					'enable_googlefonts' : categ_disp_obj.enable_googlefonts,
				}
			};

			
			var get_element_html = $.post(ajaxurl, 
				elementObject,
				function( html ) {
					var parseHtml = $(html);
					parseHtml.attr('id',unique_id);               
					
					switch(json_content['elem']) {
						
						case 'google-fonts':
								 $("#el-"+elem_id).replaceWith(parseHtml); 
								parseHtml.find('.fontfamily-sel2').select2({placeholder:'Choose from list'});              
							break;
						default:
							$("#el-"+elem_id).replaceWith(parseHtml);
					}
			});

            get_element_html.promise().done(function( arg1 ) {
                var get_children = json_content.children;
                if(get_children){
                    if(Array.isArray(get_children)){
                        $.each( get_children, function( key, json_child ) {
                            iteration++;                            
                            unique_identifier = Date.now()+'-'+iteration;
                            parseJson(json_child, '#'+unique_id, unique_identifier, populate_type);
                        })
                    }
                    else{
                        iteration++;
                        unique_identifier = Date.now()+'-'+iteration;
                        parseJson(get_children, '#'+unique_id, unique_identifier, populate_type);
                    }
                }
			}); 
			
			/* All elements have been added */
			// console.log(iteration, elements_number);
           if(iteration == elements_number){
				setTimeout(function(){
					create_hover_elements();

					/* Init tabs */
					$('.categdisp-tabs').tabs();
					/* Init Icon picker  */
					$('.icp').iconpicker();
					/* Init Color picker */
					$('.cpa-color-picker' ).wpColorPicker();
				
					/* Default values */
					var default_values = jQuery("input[name='rscdForm[tpl_id]']:checked").prev('.use-layout').attr('data-tpl_default');
					if(populate_type=='default'){ 
						/* Create shortcode page => populate values with default ones */
						var json_values = default_values;
					}
					else{
						/* Edit shortcode page => populate values with saved ones (from DB) */
						var json_values = $("#saved_settings").val();
					}
					populateSections_with_Values(json_values);
					populateSections_with_Defaults(default_values);

				}, 500);
           }
		}


        function populateSectionsHTML(tpl_settings, populate_type){
			populated_defaults = false;
			populated_values = false;
			$('.shortcodes-customisation').html('');

            $.each( tpl_settings, function( side, side_settings ) {
                $.each( side_settings, function( key, settings ) {
                    var elem_id = Date.now()+iteration;
    
                    $('.shortcodes-customisation.'+side+'-customisation').append('<div id="el-'+elem_id+'"></section>');
					var json_url = categ_disp_obj.tpl_conf_location+'partials/customisation/jsons/'+settings+'.json';
					
                    // $.getJSON(json_url, function( json_content ) {
                    //     // var temp = JSON.stringify(json_content) ;
                    //     // var count = (temp.match(/"elem"/g) || []).length;
                    //     // elements_number = elements_number + count;
    
                    //     // var parent =  '.shortcodes-customisation.'+side+'-customisation';
                    //     // parseJson(json_content, parent, elem_id, populate_type);
					// });
					
					$.ajax({
						url: json_url,
						beforeSend: function(xhr){
						  if (xhr.overrideMimeType)
						  {
							xhr.overrideMimeType("application/json");
						  }
						},
						dataType: 'json',
						data: null,
						success:  function(json_content, textStatus, request) {
							var temp = JSON.stringify(json_content) ;
							var count = (temp.match(/"elem"/g) || []).length;
							elements_number = elements_number + count;
		
							var parent =  '.shortcodes-customisation.'+side+'-customisation';
							parseJson(json_content, parent, elem_id, populate_type);
						}
					  }); 
					


                    iteration ++;
                })
            })
		}            
		



		
		function populateSections_with_Values(json_values){
			json_values = JSON.parse(json_values);	
			var count =Object.keys(json_values).length;
			if(count){
				$.each( json_values, function( key, value ) {					
					if(typeof(value) !=='object'){
						if(value!=''){
							var set_value = stripslashes(value);
						}
						else{
							var set_value = '';
						}
						// console.log(key, $( '[name="rscdForm['+key+']"]').length);
						if($( '[name="rscdForm['+key+']"]').length){
							var tag_name =$( '[name="rscdForm['+key+']"]').prop("tagName").toLowerCase();
							switch(tag_name){
								case 'select':
								case 'textarea':
									$( '[name="rscdForm['+key+']"]').val(set_value).trigger('change');
									break;
								case 'input':
									var input_type = $( '[name="rscdForm['+key+']"]').attr("type").toLowerCase();
									// console.log(input_type);
									switch(input_type){
										case 'text':
											$( '[name="rscdForm['+key+']"]').val(set_value);
											/* Copor picker - add color to label displayer */
											if($('[name="rscdForm['+key+']"]').hasClass('cpa-color-picker')){
												$('[name="rscdForm['+key+']"]').closest('.wp-picker-container').find('.wp-color-result').css('background-color',stripslashes(set_value));
											}
											break;

										case 'radio':
										case 'checkbox':
											var name = $( '[name="rscdForm['+key+']"]').attr('name');
                                           	// console.log($('[type='+input_type+']['+name+']"][value='+set_value+']'));
											if(set_value!=''){
												$('[type='+input_type+'][name="'+name+'"][value='+set_value+']').prop('checked',true);
												/* Box shadow */
												if($( 'input[name="rscdForm['+key+']"]').hasClass('box_shadow_switcher') ){
													$( 'input[name="rscdForm['+key+']"][value='+set_value+']').closest('.box_shadow_settings ').addClass('active');
												}
												/* Border Chain - add special class to inputs */
												if($( '[name="rscdForm['+key+']"]').hasClass('chain-border') && ($( '[name="rscdForm['+key+']"]').val()==set_value)){
													$('input[name="rscdForm['+key+']"]').closest('.rounded-corners-radius').find('input[type=text]').addClass('link_values');
												}
											}
											// $(this)[value='+set_value+']').prop( "checked", true );
											if( $('[name="rscdForm['+key+']"]').hasClass('settings_has_slidedown') && $('[name="rscdForm['+key+']"]').prop('checked') ){
												// console.log('hasclass and checked!!!');
												var open_el_class = $('[name="rscdForm['+key+']"]').attr('data-slidedown');
												jQuery('.'+open_el_class).slideDown({
													start: function () {
													$(this).css({
														display: "flex"
													})
													}
												});
											}
											// if( $('input.settings_has_slidedown').prop('checked') ) {
											// 	jQuery('.'+$(this).attr('data-slidedown')).slideDown({
											// 		start: function () {
											// 		$(this).css({
											// 			display: "flex"
											// 		})
											// 		}
											// 	});
											// }
											break;
										case 'hidden':
												$( '[name="rscdForm['+key+']"]').val(set_value);
												if($( '[name="rscdForm['+key+']"]').hasClass('categdisp_single_image') && $( '[name="rscdForm['+key+']"]').val()!='' ){
													var button = $('[name="rscdForm['+key+']"]').closest('div').find('.categdisp-upl');
													/* Retrieve correct image */
													$.ajax({
														url: ajaxurl,
														type: 'POST',
														data: {
															action    : 'categdisp_display_single_image',
															media_id  : $("input[name='rscdForm["+key+"]']").val(),
															security  : $("input[name=catdisp_security]").val(),
														},
														success: function(response, status, xhr) {
															button.closest('.input-group').addClass('d-block');
															button.html('<img src="' + response.url + '">').next().show();
														},
														error: function(xhr, status, error) {
															alert("Error occured !!" + xhr.status)
														},
													});
												}
										break;
										default:
									}
									break;
								default:
							}
						}
					}
					else{
						/* Checkbox multi select */
						$.each( value, function( key_single, single_value ) {
							$( 'input[name="rscdForm['+key+']"][type=checkbox][value='+single_value+']').prop( "checked", true );
						})
					}

					if (!--count){
						populateCategs_with_icons();
						populateCategs_with_images();
						populated_values = true;
					} 
				});		
			}
			else{
				populateCategs_with_icons();
						populateCategs_with_images();
						populated_values = true;
			}
		}

		function populateSections_with_Defaults(default_values){
			$(".shortcodes-customisation .form-control:not(li)").attr("data-default","");
			$(".shortcodes-customisation textarea").attr("data-default","");
			$(".shortcodes-customisation input[type=radio]").attr("data-default","");
			$(".shortcodes-customisation input[type=checkbox]").attr("data-default","");
			default_values = JSON.parse(default_values);
			var count =Object.keys(default_values).length;
			if(count){
				$.each( default_values, function( key, value) {
					if(value!=''){
						var default_value = stripslashes(value);
					}
					else{
						var default_value = '';
					}
					$( 'input[name="rscdForm['+key+']"]').attr("data-default",default_value);
					$( 'select[name="rscdForm['+key+']"]').attr("data-default",default_value);	
					// console.log(key,count);
					if (!--count) populated_defaults = true;
				})
			}
			else{
				populated_defaults = populated_values = true;
			}
			
			
		}

		/* Icons and Images per category */
		function populateCategs_with_icons(){
			// console.log('populate icons 0 ');
			if($("#categdisp_icon_selection").length){
				// console.log('populate icons 1');
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action           : 'categdisp_icon_selection',
						select_categs    : $("#categs_settings > select").val(),
						categ_icons      : $('#categ_icons').val(),
						taxonomy         : $('#categdisp_taxonomy').val(),
						security         : $("input[name=catdisp_security]").val(),
					},
					success: function(response, status, xhr) {
						$("#categdisp_icon_selection").html(response);
						$("#categdisp_icon_selection").find('.icp').iconpicker();  
					},
					error: function(xhr, status, error) {
						alert("Error occured !!" + xhr.status)
					},
					
				}); 
			}
		}
		function populateCategs_with_images(){
			if($("#categdisp_image_selection").length){
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action           : 'categdisp_image_selection',
						select_categs    : $("#categs_settings > select").val(),
						categ_imgs       : $('#categ_imgs').val(),
						taxonomy         : $('#categdisp_taxonomy').val(),
						security         : $("input[name=catdisp_security]").val(),
					},
					success: function(response, status, xhr) {
						$("#categdisp_image_selection").html(response);
					},
					error: function(xhr, status, error) {
						alert("Error occured !!" + xhr.status)
					},
				
				});
			}
		}

		/* END Icons and Images per category */
		if($("#is_error").length){
			var is_error = $("#is_error").val();
			if(is_error!=''){
				$("#validate-shortcode-submit").addClass('notice-error').html(is_error).show();
			}
		}
		

		/* Reset Style */

		function populate_defaults(){

			$(".shortcodes-customisation input[type=checkbox]").prop('checked',false);
			$(".shortcodes-customisation input[type=radio]").prop('checked',false);

			$(".box_shadow_settings ").removeClass('active')
			$(".categdisp-upl").html("Upload image").next().hide().closest('.input-group').removeClass("d-block");
			$(".input-group-addon").html('');
			var defaults = $('[data-default]');
			var count = defaults.length;
			if(count){
				$.each( defaults , function( key, form_control ) {
					var tag_name = $(this).prop("tagName").toLowerCase();
					switch(tag_name){
						case 'select':
						case 'textarea':
							$(this).val($(this).attr('data-default'));
							break;
						case 'input':
							var input_type = $(this).attr("type").toLowerCase();
							switch(input_type){
								case 'text':
								case 'hidden':
									$(this).val($(this).attr('data-default'));
									if($(this).hasClass('cpa-color-picker')){
										/* Reset color picker */
										$(this).closest('.wp-picker-container').find('.wp-color-result').css('background-color',$(this).attr('data-default'));
										$(this).closest('.wp-picker-container').find('.color-alpha').css('background-color',$(this).attr('data-default'));
									}
									break;
								case 'radio':
								case 'checkbox':
									var default_val = $(this).attr('data-default');
									var name = $(this).attr('name');
									if(default_val!=''){
										$('input[type='+input_type+'][name="'+name+'"][value='+default_val+']').prop('checked',true);
										/* Box shadow */
										if($(this).hasClass('box_shadow_switcher') && ($(this).val()==default_val)){
											$(this).closest('.box_shadow_settings ').addClass('active');
										}
										/* Border Chain - add special class to inputs */
										if($(this).hasClass('chain-border') && ($(this).val()==default_val)){
											$(this).closest('.rounded-corners-radius').find('input[type=text]').addClass('link_values');
										}
									}
									break;
								default:
							}
							break;
						
						default:
							
					}

					
					if (!--count){
						$('.shortcode-reset-style .catdisp-load').removeClass('animate-action-btn');
						populated_values = true;
					}
				})
			}
		}

		$(".shortcode-reset-style").on('click', function(){
			var confirmation = confirm("Are you sure you want to reset the layout style?");
			
			if(!confirmation) return;
			populated_values = false;
			$(this).find('.catdisp-load').addClass('animate-action-btn');

			var check_populated_boxes = setInterval(function(){ 
				// console.log(populated_defaults, populated_values);
				/* Check if "data-defaults" attributes have been added */
				if(populated_defaults){
					populate_defaults();
					clearInterval(check_populated_boxes);
				}
				
			}, 1000);
		});

		var is_showing_preview = false;
		$(document).on('click', '.shortcode-preview', function(e){
			if(is_showing_preview){
				return;
			}
			var tpl_chosen = jQuery("input[name='rscdForm[tpl_id]']:checked").val();
			if(!tpl_chosen){
				is_showing_preview = false;
				$("#validate-shortcode-submit").append('<p class="error text-red">Please choose a layout</p>');
				$("#validate-shortcode-submit").addClass('notice-error').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#validate-shortcode-submit").offset().top - 100
				}, 1000);
				return false;
			}

			$(this).find('.catdisp-load').addClass('animate-action-btn');
			var check_populated_boxes = setInterval(function(){ 
				// console.log(populated_defaults, populated_values);

				if(populated_defaults && populated_values){
					populate_popup();
					clearInterval(check_populated_boxes);
				}
				
			}, 1000);

		});



		function populate_popup(){

			$("#validate-shortcode-submit ").removeClass('notice-error notice-info').html('').hide();
			var error_found = false;
			var categdisp_form = $('#categdisp_shortcode');


			var tpl_id = $("input[name='rscdForm[tpl_id]']:checked").val();
			if(!tpl_id){
				$("#validate-shortcode-submit").append('<p class="error text-red">Please choose a layout</p>');
				error_found = true;
			}

			var select_categs = $("select[name^=select_categs]").val();
			if(!select_categs){
				$("#validate-shortcode-submit").append('<p class="error text-red">Please choose at least one category</p>');
				error_found = true;
			}
			$('.shortcode-preview .catdisp-load').removeClass('animate-action-btn');
			if(error_found){
				$("#validate-shortcode-submit").addClass('notice-error').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#validate-shortcode-submit").offset().top - 100
				}, 1000);
				is_showing_preview = false;
				return false;
			}

			is_showing_preview = true;
			$("#modal_preview_shortcode").html(categ_disp_obj.preview_modal);
			tb_show('Template Information', '#TB_inline?inlineId=modal_preview_shortcode&width=1000');
			var form = $(document).find('#categdisp_shortcode');
			var settings = jQuery($("#categdisp_shortcode")[0].elements).not("#layout_boxes").not("#saved_settings").serialize();
			
			let tpl_type = $(".layout-template:first").find('input[name="rscdForm[tpl_id]"]').prop('checked', true).data('tpl_type');
			let tplt_id = $(".layout-template:first").find('input[name="rscdForm[tpl_id]"]').prop('checked', true).val();
			if(tpl_type == "free") {
				let css_url = categ_disp_obj.catdisp_dir_path + 'templates/'+tplt_id+'/assets/css/'+tplt_id+'.css';
				$('head').append('<link rel="stylesheet" href="'+css_url+'" type="text/css" id="wpcd_template_custom_css" />');
			} else {
				let css_url = categ_disp_obj.catdisp_pro_dir_path+ 'templates/'+tplt_id+'/assets/css/'+tplt_id+'.css';
				$('head').append('<link rel="stylesheet" href="'+css_url+'" type="text/css" id="wpcd_template_custom_css" />');
			}

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action   : 'preview_shortcode', 
					settings : settings, 
					tpl_type : $(".layout-templates").find('input[name="rscdForm[tpl_id]"]:checked').attr('data-tpl_type'), 
					security : $(document).find("input[name=catdisp_security]").val(), 
				},
				success: function(response, status, xhr) {
					$("#shortcode-preview").html(response);
					
					is_showing_preview = false;
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
					is_showing_preview = false;
				},
			});
		}

		$(document).on('click', '.shortcode-preview-close', function(e){
			$('.preview-modal').removeClass('active');
		});

		$(document).on('click' , ".accordion-btn",  function(e) {
			$(this).parents('section').toggleClass('section-active');
			$(this).parents('section').find('.tpl-settings-wrap').slideToggle( "slow" );
		});
		//tib

		$(document).on('click' , ".sub-section-headline",  function(e) {
			$(this).parents('.sub-section').toggleClass('sub-section-active');
			$(this).parents('.sub-section').find('.sub-section-content').slideToggle( "slow" );
		});

		//
		$('.cpa-color-picker' ).wpColorPicker();

		
		/* Border Radius - link values */
			$(document).on('click', '.chain-border', function(e){
				var chain_rect = $(this).closest('.rounded-corners-radius').find('.chain-link-values');
				$(this).closest('.rounded-corners-radius').find('input[type=text]').toggleClass('link_values')
				if(chain_rect.hasClass('active')){
					chain_rect.removeClass('active');	
				}
				else{
					chain_rect.addClass('active');
					linkValues($(this).closest('.rounded-corners-radius').find('input[type=text]'));

				}
			});

			function linkValues(radio_inputs){
				$.each( radio_inputs, function( key, radio_input ) {
					
					if($.trim($(this).val()).length !=''){
						radio_inputs.val($(this).val());
						return;
					}
				})
			}

			$(document).on('keyup' , ".link_values",  function(e) {
				$(this).closest('.rounded-corners-radius').find('.link_values').val($(this).val());
			})
		/* END Border Radius - link values */


		/* Handle Media uploader */
			// on upload button click
			$('body').on( 'click', '.categdisp-upl', function(e){

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
					

					/* Split images for categories - ADD */
					var term_id = button.attr('data-term_id');
					if(term_id){
						// console.log('multiple');
						var categ_imgs = $("#categ_imgs").val();
						if(categ_imgs==''){
							var categ_imgs_object = {};
						}
						else{
							var categ_imgs_object = JSON.parse(categ_imgs);
						}
						categ_imgs_object[term_id] = attachment.id;
						// console.log(categ_imgs_object);
						$("#categ_imgs").val(JSON.stringify(categ_imgs_object));	
						var img_type =  button.attr('data-type');
						if(img_type=='per-term'){
							/* If the displayed image was the default one */
							var overwrite_settings = $('<div class="catdisp-overwrite_settings"><a href="#" class="categdisp-upl" data-type="per-shortcode" data-term_id="'+term_id+'" data-input_id="categ_imgs"><img src="'+attachment.url+'"></a><a href="#" class="categdisp-rmv" data-term_id="3" data-input_id="categ_imgs" data-upl_txt="Upload image" data-type="per-shortcode">Remove image</a> </div>');
							overwrite_settings.insertBefore(button.closest('.catdisp-defaults_settings'));
						}
						else{
							button.html('<img src="' + attachment.url + '">').next().show();
							button.next('.categdisp-rmv').show();
						}
					}
					else{
						button.html('<img src="' + attachment.url + '">').next().show();
						button.next('.categdisp-rmv').show();
						button.closest('.input-group').addClass('d-block');
						button.next().next().val(attachment.id);
					}
				}).open();
			});

			// on remove button click
			$('body').on('click', '.categdisp-rmv', function(e){
				e.preventDefault();
				var button = $(this);
				button.hide().prev().html('Upload image');

				/* Split images for categories - REMOVE */
				var term_id = button.attr('data-term_id');
					if(term_id){
						// console.log('multiple');
						
						var categ_imgs = $("#categ_imgs").val();
						var categ_imgs_object = JSON.parse(categ_imgs);

						delete categ_imgs_object[term_id];

						$("#categ_imgs").val(JSON.stringify(categ_imgs_object));
						/* Show  term default image if exists */
						var img_type = button.attr('data-type');

						if(img_type=='per-shortcode' && button.closest('li').find('.catdisp-defaults_settings').length){
							button.closest('.catdisp-overwrite_settings').remove();
						}
						
					}
					else{
						button.closest('.input-group').removeClass('d-block');
						// console.log('single');
						button.next().val('');
					}
			});
		/* END Handle Media uploader */

				
		$(document).on('iconpickerSelected', '.icp-categs', function(event){
			// console.log(event.iconpickerValue);
			var term_id = $(this).closest('li').attr('data-cat');
			// console.log(term_id);
			var categ_icons = $("#categ_icons").val();
			if(categ_icons==''){
				// console.log('empty');
				var categ_icons_object = {};
			}
			else{
				// console.log('not empty');
				var categ_icons_object = JSON.parse(categ_icons);
			}
			categ_icons_object[term_id] = event.iconpickerValue;
			$("#categ_icons").val(JSON.stringify(categ_icons_object));
		});
		



		/* Images and iconssettings */
		$(document).on('click', '.list_category_names li a', function(e){
			$(this).closest('ul').find('.active').removeClass('active');
			$(this).addClass('active');
			var cat_id = $(this).attr('data-cat');
			var show_elem = $(this).closest('ul').attr('data-show');

			$(this).closest('.flex-column').next('.flex-column').find('.'+show_elem+' li').addClass('hidden');
			$(this).closest('.flex-column').next('.flex-column').find('.'+show_elem+' li[data-cat='+cat_id+']').removeClass('hidden');
		})

		function settings_has_slidedown(the_class){

		}
		

		/* Box Shadow Settings */
		$(document).on('change', '.box_shadow_switcher', function(e){
				activateBoxShadow($(this));
				var settings_parent = $(this).closest('.sub-section-content');
				var box_shadow_settings = $(this).data('settings');
				$.each( box_shadow_settings, function( key, value ) {
					// console.log(key);
					settings_parent.find('input[name="rscdForm['+key+']"]').val(value);
					settings_parent.find('select[name="rscdForm['+key+']"]').val(value);
				})
			})
			function activateBoxShadow(box_shadow_input){
				box_shadow_input.closest('.box-shadow-rows').find('.box_shadow_settings').removeClass('active');
				box_shadow_input.closest('.box_shadow_settings').addClass('active');
			}
		/* END Box Shadow Settings */


		/* Toggle Inputs with dependency for other divs -> slidedown */
			if( $('input.settings_has_slidedown').prop('checked') ) {
				jQuery('.'+$(this).attr('data-slidedown')).slideDown({
					start: function () {
					$(this).css({
						display: "flex"
					})
					}
				});
			}
			$(document).on('change', 'input.settings_has_slidedown', function(e){
				if ($(this).prop('checked')) {
					jQuery('.'+$(this).attr('data-slidedown')).slideDown({
						start: function () {
						$(this).css({
							display: "flex"
						})
						}
					});
				}
				else{
					jQuery('.'+$(this).attr('data-slidedown')).slideUp();
				}
			});
		/* END Toggle Inputs with dependency for other divs -> slidedown */



		/* Hover Settings */
		
		$(document).on('click', '.categdisp_hover', function(e){
			var parent_input_group = $(this).closest('.input-group');
			// if( !$(this).hasClass('hover-active')){
			// 	parent_input_group.find('.form-control-normal').slideUp();
			// 	parent_input_group.find('.form-control-hover').slideDown();
			// }
			
			parent_input_group.toggleClass('hover-active');
			
		});

		function create_hover_elements(){
			// console.log('here');
			$( ".input-group.has-hover" ).each(function( index ) {
				var form_controls = $(this).find('.form-control');
				// console.log($(this).find('.form-control').children());
				jQuery.each( form_controls, function( i, val ) {
					$(this).addClass('form-control-normal');
					var tag_name = $(this).prop("tagName").toLowerCase();

					switch(tag_name){
						case 'li': /* Holds the styled radio/checkbox inputs : font style, text-align, border width, image-align, etc */
							var clone_settings = $(this).clone().addClass('form-control-hover').removeClass('form-control-normal');
							// console.log(clone_setting.find('input').attr('name'));
							var clone_name = $(this).find('input').data('fieldname');
							clone_settings.insertAfter($(this)).find('input').attr('name', 'rscdForm['+clone_name+'_hover]');
							break;
						// case 'div':
						// 	/* Toggl checkbox */
						// 	console.log($(this).find('.on-off-radio'));
						// 	break;
						default:
							if($(this).hasClass('on-off-radio')){
								var clone_settings = $(this).clone().addClass('form-control-hover').removeClass('form-control-normal');
								var clone_name = $(this).find('input').data('fieldname');
								clone_settings.find('input').attr('name', 'rscdForm['+clone_name+'_hover]');
								clone_settings.find('input').attr('id', $(this).find('input').attr('id')+'_hover');
								clone_settings.find('label').attr('for', $(this).find('label').attr('for')+'_hover');
								
								clone_settings.insertAfter($(this));
								return false;
							}
							if($(this).hasClass('rounded-corners-radius')){
								var $this = $(this);
								var clone_settings = $(this).clone().addClass('form-control-hover').removeClass('form-control-normal');
								// clone_settings.find('input').attr('name', $(this).find('input').attr('name')+'_hover');
								var find_inputs = clone_settings.find('input');
								$.each( find_inputs, function( find_input ) {
									// console.log(find_input);
									var normal_name = $(this).attr('name');
									var clone_name = $(this).data('fieldname');
									clone_settings.find('input[data-fieldname='+clone_name+']').attr('name', 'rscdForm['+clone_name+'_hover]');
									var normal_id = $(this).attr('id');
									if(normal_id){
										clone_settings.find('input[id='+normal_id+']').attr('id', normal_id+'_hover');
										clone_settings.find('label.catdisp-border-link').attr('for', normal_id+'_hover');
									}
								})

								var svg_clipPaths = clone_settings.find('svg').find('clipPath');
								$.each( svg_clipPaths, function( svg_clipPath ) {
									var normal_id = $(this).attr('id');
									clone_settings.find('svg').find('clipPath[id='+$(this).attr('id')+']').attr('id',normal_id+'_hover');
									clone_settings.find('svg').find('g[clip-path="url(#'+normal_id+')"]').attr('clip-path', 'url(#'+normal_id+'_hover)');
								});
								/* Border link  */
								// if(clone_settings.find('input[type=checkbox]').attr('id')){
								// 	var input_id = $this.find('input[type=checkbox]').attr('id')+'_hover';
								// 	clone_settings.find('input[type=checkbox]').attr('id', input_id);
								// 	clone_settings.find('label.catdisp-border-link').attr('for',input_id);
								// }
								
								clone_settings.insertAfter($(this));
								return false;
							}
							var clone_name = $(this).data('fieldname');
							var clone_setting = $(this).clone().attr('name','rscdForm['+clone_name+'_hover]').addClass('form-control-hover').removeClass('form-control-normal');
							clone_setting.insertAfter($(this));
					}
					// 
				})
				// $(this).find('.form-control').addClass('form-control-normal');
				// var clone_setting = $(this).find('.form-control').clone().attr('name',$(this).find('.form-control').attr('name')+'_hover').addClass('form-control-hover').removeClass('form-control-normal').insertAfter($(this).find('.form-control'));
				
				// clone_setting.promise().done(function( ) {
	
				// });
			});
		}


		$(document).on('click', '.categdisp_settings_tooltip', function(e){
			$(this).toggleClass('active');
			$(this).closest('.categdisp_hover_settings').next('.categdisp_hover_info').slideToggle( "slow" );
		})


		function stripslashes(str) {
			str = str.replace(/\\'/g, '\'');
			str = str.replace(/\\"/g, '"');
			str = str.replace(/\\0/g, '\0');
			str = str.replace(/\\\\/g, '\\');
			return str;
		}



		/* Function which creates a hover div inside sections*/
		function createHover(sec_id, transform_json){
			var clone_normal = transform_json.find('section#'+sec_id+' .tpl-normal-settings').clone().removeClass('tpl-normal-settings active').addClass('tpl-hover-settings');
			if(clone_normal){
				var find_inputs = clone_normal.find('input, select');
				$.each( find_inputs, function( key, input_found ) {
					$(this).attr('name', $(this).attr('name')+'_hover');
				});
				clone_normal.appendTo("section#"+sec_id + " .tpl-settings-wrap");
			}

		}

		/* Choose from taxonimy list */
		$('#split_taxonomies select').select2({placeholder:'Choose from list'});
		



		/* */
		$('#categs_settings select').select2({
			placeholder: 'Choose from list'
		});


		var is_showing_cats = false;

		$("input[name='rscdForm[categs_settings]'], #split_taxonomies select ").on("change", function(){
			if(is_showing_cats) return;

			$.each( $(".list_category_names"), function( key, box ) {
				/* Empty Category names list */
				$(this).html('');
				/* Empty Category settings from right (image/icon) */
				$('.'+$(this).attr('data-show')).html('');
			
			});
			
			var taxonomy = $("#categdisp_taxonomy").val();
			var categs_settings = $("input[name='rscdForm[categs_settings]']:checked").val();

			if(taxonomy && categs_settings){
				is_showing_cats = true;
				$("#categs_settings").html('');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action   : 'categories_selection',
						type     : categs_settings,
						taxonomy : taxonomy,
						security : $("input[name=catdisp_security]") .val(),
					},
					success: function(response, status, xhr) {
						$("#categs_settings").html(response);
						$("#categs_settings").find('select').select2({
							placeholder: 'Choose from list'
						});
						is_showing_cats = false
					},
					error: function(xhr, status, error) {
						alert("Error occured !!" + xhr.status)
					},
					complete: function() {
						is_showing_cats = false;
					},
				});

			}

			
		})

		$(document).on('select2:select','#categs_settings > select', function(e){
			var data = e.params.data;
			var term_id = data.id;
			var term_name = (data.text).trim();
			var boxes = {'categ_imgs':'image_select','categ_icons':'icon_select'};
			$.each( boxes, function( key, box ) {
				// console.log(key,box);
				var box_section = $('section[data-cust="'+box+'"]');
				
				if(box_section.length){
					
					/* Hide empty cal list */
					box_section.find('.empty_cat_list').hide();
					/* Add Category name from list */
					box_section.find('ul.list_category_names').append('<li><a class="cursor-pointer" data-cat="'+term_id+'">'+term_name+'</a></li>');

					/* Add image/icon from right  */
					var list_category_show = box_section.find('ul.list_category_names').attr('data-show');

					var settings_rightside = '';
					
					/* Create ajax request */
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {
							action   : 'categdisp_populate_list_category',
							type     : key,
							term_id  : term_id,
							taxonomy : $("#categdisp_taxonomy").val(),
							security : $("input[name=catdisp_security]") .val(),
						},
						success: function(response, status, xhr) {
							// console.log(response);
							// console.log(list_category_show);
							$('.'+list_category_show).append(response);
							/* If is icon => iconpicker init */
							if(response.indexOf('icp-categs') >-1 ){
								// console.log('icon');
								$(".list_category_icons").find('li[data-cat='+term_id+']').find('.icp-categs').iconpicker();
							}
							
						},
						error: function(xhr, status, error) {
							alert("Error occured !!" + xhr.status)
						},
						complete: function() {
						},
					});

					// if(key=='categ_imgs') {
					// 	settings_rightside += '<li class="hidden" data-cat="'+term_id+'">';
					// 	settings_rightside += '<a href="#" class="categdisp-upl" data-term_id="'+term_id+'" data-input_id="categ_imgs">Upload image</a>';
					// 	settings_rightside += '<a href="#" class="categdisp-rmv" data-term_id="'+term_id+'" data-input_id="categ_imgs" style="display: none;">Remove image</a>';
					// 	settings_rightside += '</li>';
					// 	$('.'+list_category_show).append(settings_rightside);
					// 	console.log('add image');
					// }
					// else if(key=='categ_icons'){
					// 	settings_rightside += '<li class="hidden" data-cat="'+term_id+'">';
					// 	settings_rightside += '<div class="iconpicker-container">';
					// 	settings_rightside += '<input data-placement="bottomRight" autocomplete="off" class="form-control icp icp-auto w-100 icp-categs" placeholder="Choose an icon" value="" type="text"  name="categdisp-icon-'+term_id+'"/>';
					// 	settings_rightside += '<span class="input-group-addon"></span>';
					// 	settings_rightside += '</div>';
					// 	settings_rightside += '</li>';
					// 	$('.'+list_category_show).append(settings_rightside);
					// 	$('.'+list_category_show).find('li[data-cat='+term_id+']').find('.icp').iconpicker();
					// 	console.log('add image');
					// }
					
				}
			
			})

		})
		
		$(document).on('select2:unselect','#categs_settings > select', function(e){
			var data = e.params.data;
			var term_id = data.id;
			var boxes = {'categ_imgs':'image_select','categ_icons':'icon_select'};
			$.each( boxes, function( key, box ) {
				var box_section = $('section[data-cust="'+box+'"]');
				
				if(box_section.length){
					/* Remove Category name from list */
					box_section.find('ul.list_category_names li a[data-cat='+term_id+']').closest('li').remove();
					/* Remove image/icon from right  */
					var list_category_show = box_section.find('ul.list_category_names').attr('data-show');
					$('.'+list_category_show).find('li[data-cat='+term_id+']').remove();
					if(! $('.'+list_category_show).children().length ){
						box_section.find('.empty_cat_list').show();
					}

					/* Remove value from corresponding input with id= key from each. */
					var categ_values = $("#"+key).val();
					if(categ_values==''){
						return;
					}
					else{
						var categ_values_object = JSON.parse(categ_values);
					}
					var categ_values_object = JSON.parse(categ_values);
					delete categ_values_object[term_id];
					$("#"+key).val(JSON.stringify(categ_values_object));

				}
			})
		});

		var shortcode_action = $("form#categdisp_shortcode").find('input[name=action]').val();
		if(shortcode_action){
			if(shortcode_action == 'add_shortcode'){
				 /* Add shortcode page? => Use default values */
				$(".layout-template:first").addClass('active');
				$(".layout-template:first").find('input[name="rscdForm[tpl_id]"]').prop('checked', true);
				var tpl_settings = $(".layout-template:first").find('.use-layout').attr('data-tpl_cust');
				var populate_type = 'default';
				
			}
			else{ 
				/* Edit shortcode page? => Use saved values (from DB)*/
				var tpl_settings = $("input[name='rscdForm[tpl_id]']:checked").prev('.use-layout').attr('data-tpl_cust');
				var populate_type = 'saved';
			}
			if(tpl_settings){
				populateSectionsHTML(JSON.parse(tpl_settings), populate_type);
			}
		}
		

		/* Change Customisation sections depending on layout */
		$(".use-layout").on("click", function(event, wasTriggered){
			var is_active = $(this).closest('.layout-template').hasClass('active');
			var confirmation = false;

			if(!is_active){
				confirmation = confirm("Are you sure you want to change the layout?");
			}
	
			if(!confirmation){
				return false;
			}

			/* return confirmation; ???? */
			else{
				$(".layout-template").removeClass('active');
				$(this).closest('.layout-template').addClass('active');
				$(this).next('input[name="rscdForm[tpl_id]"]').prop('checked', true);
			}

			var tpl_settings = $(this).attr('data-tpl_cust');
			populateSectionsHTML(JSON.parse(tpl_settings), 'default' );
		});


		
			var is_saving = false;
			$('form#categdisp_shortcode').on('submit', function (e) {

				e.preventDefault();

				$("#validate-shortcode-submit ").removeClass('notice-error notice-info').html('').hide();
				var error_found = false;
				var categdisp_form = $(this);
				categdisp_form.find('[type=submit]').find('.catdisp-load').addClass('animate-action-btn');

				if(is_saving) return false;
				is_saving = true;

				var sc_title = $("#categdisp_shortcode input[name='rscdForm[title]']").val();
				if(!sc_title){
					$("#validate-shortcode-submit").append('<p class="error text-red">Please add a title!</p>');
					error_found = true;
				}

				var tpl_id = $("input[name='rscdForm[tpl_id]']:checked").val();
				if(!tpl_id){
					$("#validate-shortcode-submit").append('<p class="error text-red">Please choose a layout!</p>');
					error_found = true;
				}

				var select_categs = $("select[name^=select_categs]").val();
//				var select_categs = $("select[name='rscdForm[select_categs[]]']").val();
				if(!select_categs){
					$("#validate-shortcode-submit").append('<p class="error text-red">Please choose at least one category!</p>');
					error_found = true;
				}
				 
				var categdisp_taxonomy = $("select[name='rscdForm[categdisp_taxonomy]']").val();
				if(!categdisp_taxonomy){
					$("#validate-shortcode-submit").append('<p class="error text-red">Please choose a taxonomy!</p>');
					error_found = true;
				}

				if(error_found){
					$("#validate-shortcode-submit").addClass('notice-error').show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#validate-shortcode-submit").offset().top - 100
					}, 1000);
					is_saving=false;
					categdisp_form.find('[type=submit]').find('.catdisp-load').removeClass('animate-action-btn');
					return false;
				}
				

				var save_type = categdisp_form.find("input[name=action]").val();
				
				// console.log('save = ' +populated_defaults, populated_values);

				var check_populated_boxes = setInterval(function(){ 
					// console.log(populated_defaults, populated_values);
	
					if(populated_defaults && populated_values){
						ajax_save_popup(categdisp_form, save_type );
						clearInterval(check_populated_boxes);
					}
					
				}, 1000);
			
			});

			function ajax_save_popup(categdisp_form, save_type ){
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: $(categdisp_form).serialize()+'&type='+$(".layout-templates").find('input[name="rscdForm[tpl_id]"]:checked').attr('data-tpl_type'), 
					success: function(response, status, xhr) {
						if(response.hasOwnProperty('error')){
							$("#validate-shortcode-submit").append(response.error);
						}
						else{
							/* If shortcode was just created => redirect to edit page */
							if(save_type=='add_shortcode'){
								window.location.href="admin.php?page=categs-shortcodes-view&action=edit&ID="+response.last_ins_id;
							}
							else{
								$("#validate-shortcode-submit").append('<p>Shortcode saved!</p>').show();
								$([document.documentElement, document.body]).animate({
									scrollTop: $("#validate-shortcode-submit").offset().top - 100
								}, 1000);
								categdisp_form.find('[type=submit]').find('.catdisp-load').removeClass('animate-action-btn');
							}
						}
						
						is_saving = false;
					},
					error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
					},
					complete: function() {
						is_saving = false;
					},
				});
			}

  
		  /* DELETE shortcode */
		  var is_delete = false;
		  $(document).on('click','#categs-shortcode-view .delete-shortcode', function(){
			if(is_delete) return;
			is_delete = true;

			var delete_sh = $(this);
			  
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action       : 'delete_shortcode',
					shortcode_id : delete_sh.data('sh_id'),
					security     : categ_disp_obj.catdisp_listtable_nonce
				},
				success: function(response, status, xhr) {
					if(response.hasOwnProperty('error')){
						alert(response.error);
					}
					else{
						delete_sh.closest('.column-actions .row-actions').hide();
						delete_sh.closest('.column-actions').append('<span class="shortcode-deleted">Shortcode deleted.</span>');
						
						setTimeout(function(){ 
							delete_sh.closest('tr').remove(); 
						}, 800);
					}
					is_delete = false;
				},
				error: function(xhr, status, error) {
					alert("Error occured !!" + xhr.status)
				},
				complete: function() {
				is_delete = false;
				},
			});
		  });


		   /* DUPLICATE shortcode */
		   var is_duplicate = false;
		   $(document).on('click','#categs-shortcode-view .duplicate-shortcode', function(){
			   var delete_sh = $(this);
 
			   if(is_duplicate) return;
			   is_duplicate = true;
   
			   $.ajax({
				   url: ajaxurl,
				   type: 'POST',
				   data: {
					   action       : 'duplicate_shortcode',
					   shortcode_id : delete_sh.data('sh_id'),
					   security     : categ_disp_obj.catdisp_listtable_nonce
				   },
				   success: function(response, status, xhr) {
					   if(response.hasOwnProperty('error')){
						   alert(response.error);
					   }
					   else{
							var closest_tr = delete_sh.closest('tr').clone();
							var inserted_tr = closest_tr.insertAfter(delete_sh.closest('tr'));
							inserted_tr.find(".column-title").text(response.title);
							inserted_tr.find(".actions .edit a").attr('href',response.edit_url);
							inserted_tr.find(".actions .duplicate-shortcode").attr('data-sh_id',response.last_ins_id);
							inserted_tr.find(".actions .delete-shortcode").attr('data-sh_id',response.last_ins_id);
							inserted_tr.find(".check-column input[type='checkbox'][name='bulk-delete[]']").val(response.last_ins_id);
					   }
					   is_duplicate = false;
				   },
				   error: function(xhr, status, error) {
					   alert("Error occured !!" + xhr.status)
				   },
				   complete: function() {
					is_duplicate = false;
				   },
			   });
		   })


		   /* Copy to clipboard -> shortcode input */
		   $("#copy-shortcode").on('click', function(){
			   /* Get the text field */
				var copyText = document.getElementById("categs-shortcode-value");
				/* Select the text field */
				copyText.select();
				copyText.setSelectionRange(0, 99999); /*For mobile devices*/
				/* Copy the text inside the text field */
				document.execCommand("copy");
		   })

			jQuery( 'body' ).on( 'thickbox:removed', function() {
				$("#wpcd_template_custom_css").remove();
				$("#shortcode-preview").html('');
			})


	})
})( jQuery );
