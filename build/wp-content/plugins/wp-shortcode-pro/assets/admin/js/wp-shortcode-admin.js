/*!
* WP Shortcode Pro
*
* @version 1.0
* @author  MyThemeShop
*/
var autocomplete;
(function( $ ) {

	'use strict';

	$(function() {

		var accordionConfig = '';
		var wpShortcodeAdmin = {
			init: function() {
				this.initialize_library();
				this.tabs();
				this.add_tab();
				this.remove_tab();
				this.debugReport();
				this.import_settings();

				this.shortcode_selector();
				this.presets();
				this.add_preset();
				this.remove_preset();

				this.create_shortcode();

				this.map_shortcode();

			},

			//Initialize Library
			initialize_library: function() {
				var zindex = 99999;
				if($('body').hasClass('fl-builder')) {
					zindex = 999999;
				}
				$('#wp-shortcode-wrap').iziModal({
					title: '<span class="dashicons dashicons-editor-code"></span> WP Shortcode Pro',
					subtitle: '',
					width: 1000,
					height: 200,
					fullscreen: true,
					closeButton: true,
					overlayClose: false,
					zindex: zindex,
					transitionIn: 'fadeInUp',
					transitionOut: 'fadeOutDown',
					transitionInOverlay: 'fadeIn',
					transitionOutOverlay: 'fadeOut',
					rtl: $('body').hasClass('rtl'),
					onClosing: function(){
						$('.tipsy').hide();
					},
					onClosed: function() {
						$('#wp-shortcode-header').show();
						$('#wps-lists span').show();
						$('#wps-search').val('').focusout();
					},
				});
				$(document).find('.wps-color-picker').wpColorPicker({
					change: function(event, ui) {
						$(event.target).attr('value', ui.color.toString()).trigger('change');
					},
					clear: function (event) {
						$(event.target).attr('value', '').trigger('change');
					}
				});

				//Buttonset
				jQuery('.wps-buttonset-wrapper').buttonset();

				// Range Picker
				$(document).find('.wps-range-picker').each(function(index) {
					var $this = $(this),
						$val = $this.find('input'),
						min = parseFloat($val.attr('min')),
						max = parseFloat($val.attr('max')),
						step = parseFloat($val.attr('step'));

					$this.find('.wps-admin-slider').slider({
						min: min,
						max: max,
						value: $val.val(),
						step: step,
						animate: true,
						range: "min",
						slide: function( event, ui ) {
							$val.val( ui.value );
						},
						stop: function( event, ui ) {
							$val.trigger('change');
						}
					});
					$val.change(function(){
						$this.find('.wps-admin-slider').slider( 'value', $(this).val() );
					});
				});

				if( $(document).find('.wps-datepicker').length > 0 ) {
					$(document).find('.wps-datepicker').datepicker( { dateFormat: 'yy/m/dd' } );
				}

				// Init media buttons
				$('.wp-shortcode-upload-button').each(function() {
					var $button = $(this),
						$val = $(this).parents('.wps-field-wrapper').find('input:text'),
						file;
						$button.on('click', function(e) {
						e.preventDefault();
						e.stopPropagation();

						if (typeof(file) !== 'undefined') file.close();

						file = wp.media.frames.wps_media_frame_2 = wp.media({

							title: 'Choose file',
							button: {
								text: 'Insert'
							},
							multiple: false
						});
						file.on('select', function() {
							var attachment = file.state().get('selection').first().toJSON();
							$val.val(attachment.url).trigger('change');
						});
						file.open();
					});
				});

				// Init shadow pickers
				$('.wp-shortcode-shadow-picker').each(function(index) {
					var $this = $(this),
						$fields = $this.find('.wps-sp-field input'),
						$hoff = $this.find('.wps-shadow-horizontal'),
						$voff = $this.find('.wps-shadow-vertical'),
						$blur = $this.find('.wps-shadow-blur'),
						$color = $this.find('.wps-color-picker'),
						$val = $this.find('.wps-field-value');
					$fields.on('change blur keyup', function() {
						$val.val($hoff.val() + 'px ' + $voff.val() + 'px ' + $blur.val() + 'px ' + $color.val()).trigger('change');
					});
				});

				// Init border pickers
				$('.wp-shortcode-border-picker').each(function(index) {
					var $this = $(this),
						$fields = $this.find('.wps-bp-field input, .wps-bp-field select'),
						$width = $this.find('.wps-border-width'),
						$style = $this.find('.wps-border-style'),
						$color = $this.find('.wps-color-picker'),
						$val = $this.find('.wps-field-value');

					$fields.on('change blur keyup', function() {
						$val.val($width.val() + 'px ' + $style.val() + ' ' + $color.val()).trigger('change');
					});
				});

				//Icon Picker
				$(document).find('.wps-icon-picker-button').each(function() {
					var $button = $(this),
						$field = $(this).parents('.wps-field-wrapper'),
						$val = $field.find('.wps-field-value'),
						$picker = $field.find('.wps-icon-picker'),
						$filter = $picker.find('input:text');

						$button.click(function(e) {
							$picker.addClass('wps-icons-visible');
							$filter.val('').trigger('keyup');
							$.ajax({
								type: 'post',
								url: ajaxurl,
								data: {
									action: 'wps_get_icons'
								},
								dataType: 'html',
								beforeSend: function() {
									$picker.addClass('wps-loading');
									$picker.addClass('wps-icons-loaded');
								},
								success: function(data) {
									$picker.append(data);
									var $icons = $picker.children('i');
									$icons.click(function(e) {
										var sel_icon = $(this).attr('title');
										$val.val(sel_icon);
										$picker.removeClass('wps-icons-visible');
										$button.find('i').attr('class', 'fa fa-'+sel_icon);
										$val.trigger('change');
										e.preventDefault();
									});
									$filter.on({
										keyup: function() {
											var val = $(this).val(),
												regex = new RegExp(val, 'gi');
											$icons.hide();
											$icons.each(function() {
												var name = $(this).attr('title');
												if (name.match(regex) !== null) $(this).show();
											});
										},
										focus: function() {
											$(this).val('');
											$icons.show();
										}
									});
									$picker.removeClass('wps-loading');
								}
							});
						e.preventDefault();
					});
				});
			},

			//Settings - Debug Report
			debugReport: function() {
				if ( ! $( '.wps-support-copy' ).length ) {
					return false;
				}
				var clipboard = new Clipboard('.wps-support-copy', {
					target: function(trigger) {
						return $( '#wps-debug-data-field' )[0];
					},
				});

				$( '#wps-debug-data-field' ).click(function(event) {
					$( this ).select();
				});
			},

			// Settings Tabs
			tabs: function() {
				var settingTabWrapper = $( '.wp-shortcode-tab-wrapper' );

				if ( ! settingTabWrapper.length ) {
					return;
				}

				var nav = $( 'a', settingTabWrapper ),
					panels = $( '.wp-shortcode-setting-panel' );

				// Set min height
				$( '.cmb2-wrap', '.wp-shortcode-wrap-settings' ).css( 'min-height', settingTabWrapper.outerHeight() );

				// Click Event
				nav.on( 'click', function() {
					var $this = $( this ),
						target = $this.attr('href');

					nav.removeClass('active');
					panels.hide();

					$this.addClass( 'active' );
					$( target ).show();

					// Save in localStorage
					localStorage.setItem( 'wp-shortcode-active-tab', target );

					return false;
				});

				var target = localStorage.getItem( 'wp-shortcode-active-tab' );
				if ( null === target ) {
					nav.eq(0).trigger( 'click' );
				} else {
					target = $( 'a[href="' + target + '"]' );
					if ( target.length ) {
						target.trigger( 'click' );
					} else {
						nav.eq(0).trigger( 'click' );
					}
				}

				settingTabWrapper.on( 'click', '> .button-primary', function() {
					$( '.cmb-form > .button-primary' ).trigger( 'click' );
					return false;
				});
			},

			//Add Tab
			add_tab: function() {

				$(document).on('click', '#wps-add-field', function(e) {
					e.preventDefault();
					var query = $(this).data('child');
					$.ajax({
						type: 'post',
						url: ajaxurl,
						data: {
							action: 'wp_shortcode_settings',
							'shortcode': query,
							'is_child': true
						},
						dataType: 'html',
						beforeSend: function() {
							$('#wps-parent-wrapper').hide();
							$('#wps-settings').addClass('wps-loading').show();
						},
						success: function(data) {
							$('#wps-settings').removeClass('wps-loading');
							$('#wps-selector').find('#wps-child-wrapper').show().html(data);

							wpShortcodeAdmin.initialize_library();

							$('.wp-shortcode-add-section').on('click', function() {
								var total_dynamic_sections = $('#wps-parent-wrapper').find('.wps-tab-inner-wrapper .wps-child-inner').length;
								var $settings = $('#wps-settings #wps-child-wrapper .wps-field-wrapper .wps-field-value');

								var $prefix = $('#wps-prefix'),
									prefix = $prefix.val(),
									content = $('#wps-child-wrapper').find('#wp-shortcode-content').val(),
									result = new String('');
									result += '[' + prefix + query;

								$settings.each(function() {

									var $this = $(this),
										value = '';

									if ($this.is('select')) value = $this.find('option:selected').val();
									if ($this.is(':radio')) {
										if($this.is(':checked')) {
											value = $this.val();
										}
									} else
										value = $this.val();

									if(value == null) value = '';
									else if(typeof value === 'array')
										value = value.join(',');

									if (value !== '')
										result += " " + $(this).attr('name') + "='" + $(this).val().toString().replace(/"/gi, '"') + "'";
								});

								result += " ]";

								if (content != 'false')
									result += content + "[/" + prefix + query + "]";

								var prev_content = '';

								$(this).parents('#wps-settings').find('#wps-parent-wrapper').append('<input type="hidden" class="wps-tab-content tab-'+parseInt( total_dynamic_sections + 1 )+'" value="'+result+'" />');
								$(this).parents('#wps-settings').find('#wps-parent-wrapper .wps-tab-content').each(function(){
									prev_content = prev_content + $(this).val();
								});
								$(this).parents('#wps-settings').find('#wps-parent-wrapper #wp-shortcode-content').val(prev_content);

								var repeater_field_title = $(this).parents('#wps-settings').find('#wps-child-wrapper #wps-field-value-title').val();

								if(repeater_field_title === undefined) {
									repeater_field_title = $(this).parents('#wps-settings').find('#wps-child-wrapper #wps-field-value-size').val();
								}

								$(this).parents('#wps-settings').find('#wps-parent-wrapper').find('.wps-tab-inner-wrapper').append(
										'<div class="wps-child-inner"><span>'+repeater_field_title+'</span><span class="fa fa-times wps-remove" data-tab-number="'+ parseInt( total_dynamic_sections + 1 ) +'"></span></div>'
										);
								$(this).parents('#wps-settings').find('#wps-parent-wrapper').show();
								$(this).parents('#wps-settings').find('#wps-child-wrapper').html('').hide();
								wpShortcodeAdmin.update_preview();
							});
						}
					});

					return false;
				});
			},

			//Remove Tab
			remove_tab: function() {
				$(document).on('click', '.wps-child-inner .wps-remove', function(e){
					e.preventDefault();
					var tab_number = $(this).data('tab-number');
					$('.wps-tab-content.tab-'+tab_number).remove();
					var content = '';
					$('.wps-tab-content').each(function(){
						content += $(this).val();
					});
					$(this).parents('#wps-settings').find('#wps-parent-wrapper #wp-shortcode-content').val(content);
					$(this).parent().remove();
					wpShortcodeAdmin.update_preview();
					return false;
				});
			},

			// Select Shortcode
			shortcode_selector: function() {
				var $selector = $('#wps-selector'),
					$search = $('#wps-search'),
					$matched_shortcodes = $('.wps-matched-shortcodes'),
					$filter = $('#wps-filter'),
					$filters = $filter.children('a'),
					$shortcodes = $('#wps-lists'),
					$shortcode = $shortcodes.find('span'),
					$settings = $('#wps-settings'),
					$prefix = $('#wps-prefix'),
					$result = $('#wps-output'),
					$selected = $('#wps-selected'),
					$selected_shortcode = '',
					tinymce_selected_text = '';

				$(document).on('click', '.wp-shortcode-button', function(event) {
					event.preventDefault();
					$('#wp-shortcode-wrap').iziModal('open');
					tinymce_selected_text = (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor != null && tinyMCE.activeEditor.hasOwnProperty('selection')) ? tinyMCE.activeEditor.selection.getContent({
						format: "text"
					}) : '';
				});
				$filters.click(function(e) {
					e.preventDefault();
					var filter = $(this).data('filter');
					$filter.find('.active').removeClass('active');
					$filters.find('.active').removeClass('active');
					$(this).addClass('active');

					if (filter === 'all') {
						// $shortcode.css('opacity', '1').removeClass('wps-closest');
						$shortcode.show().removeClass('wps-closest');
					} else {
						var regex = new RegExp(filter, 'gi');

						// $shortcode.css('opacity', '0.2');
						$shortcode.hide();
						$shortcode.each(function() {
							var category = $(this).data('category');
							if (category.match(regex) !== null) {
								// $(this).css('opacity', '1').removeClass('wps-closest');
								$(this).show().removeClass('wps-closest');
							}
						});
					}
				});

				$selector.on('click', '.wps-main-page', function(e) {
					e.preventDefault();
					$search.val('');
					$settings.html('').hide();
					$filter.show();
					$shortcodes.show();
					$shortcode.show();
					tinymce_selected_text = '';
					$search.parents('#wp-shortcode-header').show();
					$search.focus();
					// $('#wp-shortcode-wrap').iziModal("setWidth",1000);
				});

				$selector.on('click', '.wp-parent-shortcode, .wps-back', function(e) {
					if( $('#wps-child-wrapper').length > 0 ) {
						$('#wps-parent-wrapper').show();
						$('#wps-child-wrapper').hide();
					} else {
						var parent = $(this).attr('title');
						$('#wps-lists').find('span[data-shortcode="'+parent+'"]').trigger('click');
					}
				});

				$('.wps-search-button').on('click', function(e){
					e.preventDefault();
					if($search.val() !== '') {
						var e = $.Event('keyup');
						e.keyCode= 13;
						$($search).trigger(e);
					}
					return false;
				});

				$search.on({
					focus: function() {
						$settings.html('').hide();
						$shortcodes.show();
						// $shortcode.css('opacity', '1').removeClass('wps-closest');
						$shortcode.show().removeClass('wps-closest');
						$filter.show();
						$filter.find('.active').removeClass('active');
						$filter.find('a[data-filter="all"]').addClass('active');
						// $('#wp-shortcode-wrap').iziModal("setWidth",1000);
						if($(this).val() === '') {
							$matched_shortcodes.html('');
						} else {
							$matched_shortcodes.show();
						}
					},
					keyup: function(e) {
						var $first = $('.wps-closest:first'),
							val = $(this).val(),
							regex = new RegExp(val, 'gi'),
							found = 0,
							best = 0;
						if (e.keyCode === 13 && $first.length > 0) {
							e.preventDefault();
							$(this).val('').blur();
							$first.trigger('click');
						}

						$shortcode.hide().removeClass('wps-closest');
						$matched_shortcodes.html('');
						$shortcode.each(function(event) {

							var $this = $(this),
								data = $(this).data(),
								id = data.shortcode,
								name = data.name,
								category = data.category,
								matches = ([id, name, category].join(' ')).match(regex);

							if (matches !== null) {
								$(this).show();
								$matched_shortcodes.append('<li><a class="matched-element" href="#" data-shortcode="'+id+'">'+$($this[0]).text()+'</a></li>').show();
								if (val === id) {
									$shortcode.removeClass('wps-closest');
									$(this).addClass('wps-closest');
									best = 999;
								} else if (matches.length > best) {
									$shortcode.removeClass('wps-closest');
									$(this).addClass('wps-closest');
									best = matches.length;
								}
								found++;
							}
						});
						if(found === 0) {
							if($shortcodes.find('.wps-not-found').length > 0) {
								$shortcodes.find('.wps-not-found').show().text('No Shortcode Found.');
							} else {
								$shortcodes.append('<h4 class="wps-not-found">No Shortcode Found.</h4>');
							}
							$matched_shortcodes.html('');
						} else {
							$shortcodes.find('.wps-not-found').hide();
						}
						if (val === '') {
							$matched_shortcodes.html('');
							$shortcode.show().removeClass('wps-closest');
						}

						$matched_shortcodes.on('focusout', function(){
							setTimeout(function(){
								if(! $(document.activeElement).hasClass('matched-element')) {
									$matched_shortcodes.hide();
								}
							}, 100);
						});

						$matched_shortcodes.find('a').on({
							focus: function() {
								var selected_val = $(this).text();
								$search.val(selected_val);
							},
							keydown: function(e) {
								if(e.keyCode === 40 ) {
									e.preventDefault();
									$(this).parent().next().find('a').focus();
								} else if(e.keyCode === 38) {
									e.preventDefault();
									if($(this).parent().prev().length > 0) {
										$(this).parent().prev().find('a').focus();
									} else {
										$search.focus();
										$search.val(val);
									}
								} else if(e.keyCode === 13 ) {
									e.preventDefault();
									var selected_shortcode = $(this).data('shortcode');
									$('#wps-lists').find('span[data-shortcode="'+selected_shortcode+'"]').trigger('click');
									return false;
								}
							},
							click: function(e) {
								e.preventDefault();
								var selected_shortcode = $(this).data('shortcode');
								$('#wps-lists').find('span[data-shortcode="'+selected_shortcode+'"]').trigger('click');
							}
						});
					},
					keydown: function(e) {
						if(e.keyCode === 40 ) {
							e.preventDefault();
							$matched_shortcodes.find('li:first-child a').focus();
						}
					},

					focusout: function(e) {
						setTimeout(function(){
							if(! $(document.activeElement).hasClass('matched-element')) {
								$matched_shortcodes.hide();
							}
						}, 100);
					}

				});

				$shortcode.on('click', function(e) {

					var shortcode = $(this).data('shortcode');
					$selected_shortcode = shortcode;
					$('input[name="wps-selected"]').val(shortcode);

					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'wp_shortcode_settings',
							shortcode: shortcode
						},
						beforeSend: function() {
							$shortcodes.hide();
							$settings.addClass('wps-loading').show();
							$search.parents('#wp-shortcode-header').hide();
							$filter.hide();
						},
						success: function(data) {

							$settings.removeClass('wps-loading');
							$settings.html(data);
							var $content = $('#wp-shortcode-content');

							if (typeof tinymce_selected_text !== 'undefined' && tinymce_selected_text !== '' && $content.attr('type') !== 'hidden') {
								$content.val(tinymce_selected_text);
							}
							wpShortcodeAdmin.initialize_library();
							wpShortcodeAdmin.update_preview();

							var typingTimer;
							$('#wps-settings').find('input, textarea, select, .wps-table-field td').on('change keyup', function() {
									clearTimeout(typingTimer);
  								typingTimer = setTimeout(function(){
  									wpShortcodeAdmin.update_preview();
  								}, 400);
							});
							//on keydown, clear the timer
							$('#wps-settings').find('input, textarea, .wps-table-field td').on('keydown', function() {
								clearTimeout(typingTimer);
							});

							if($settings.find('.wps-geocomplete').length > 0  && ! $settings.hasClass('initialized_geocode')) {
								$settings.addClass('initialized_geocode');
								wpShortcodeAdmin.geocomplete_code();
							} else if($settings.find('.wps-table-field').length > 0) {
								if(! $settings.hasClass('initialized_table')) {
									$settings.addClass('initialized_table');
									wpShortcodeAdmin.table_fields();
								}
								wpShortcodeAdmin.sortable();
							}
							$('.wps-images').each(function() {
								var $this = $(this),
									$sources = $this.find('.wps-images-sources'),
									$source = $this.find('.wps-images-source'),
									$add_media = $this.find('.wps-images-add-media'),
									$images = $this.find('.wps-images-images'),
									$cats = $this.find('.wps-images-categories'),
									$taxes = $this.find('.wps-images-taxonomies'),
									$terms = $('.wps-images-terms'),
									$val = $this.find('.wps-field-value'),
									frame;

								var update = function() {
									var val = 'none',
										ids = '',
										source = $sources.val();

									if (source === 'media') {
										var images = [];
										$images.find('span').each(function(i) {
											images[i] = $(this).data('id');
										});
										if (images.length > 0) ids = images.join(',');
									} else if (source === 'category') {
										var categories = $cats.val() || [];
										if (categories.length > 0) ids = categories.join(',');
									} else if (source === 'taxonomy') {
										var tax = $taxes.val() || '',
											terms = $terms.val() || [];
										if (tax !== '0' && terms.length > 0) {
											val = 'taxonomy- ' + tax + '/' + terms.join(',');
										}
									} else if (source === '0') {
										val = 'none';
									} else {
										val = source;
									}
									if (ids !== '') val = source + '- ' + ids;
									$val.val(val).trigger('change');
								}
								// Switch source
								$sources.on('change', function(e) {
									var source = $(this).val();
									e.preventDefault();
									$source.removeClass('wps-images-source-open');
									if (source.indexOf('-') === -1)
										$this.find('.wps-images-source-' + source).addClass('wps-images-source-open');
									update();
								});

								$images.on('click', 'span i', function() {
									$(this).parent('span').css('border-color', '#f03').fadeOut(300, function() {
										$(this).remove();
										update();
									});
								});

								$add_media.click(function(e) {
									e.preventDefault();

									if (typeof(frame) !== 'undefined')
										frame.close();

									frame = wp.media.frames.wps_media_frame_1 = wp.media({
										title: 'Select images',
										library: { type: 'image' },
										button: { text: 'Add selected images' },
										multiple: true
									});

									frame.on('select', function() {
										var files = frame.state().get('selection').toJSON();
										$images.find('em').remove();
										$.each(files, function(i) {
											$images.append('<span data-id="' + this.id + '" title="' + this.title + '"><img src="' + this.url + '" alt="" /><i class="fa fa-times"></i></span>');
										});
										update();
									}).open();
								});

								$images.sortable({
									revert: 200,
									containment: $this,
									tolerance: 'pointer',
									stop: function() {
										update();
									}
								});

								$cats.on('change', update);
								$terms.on('change', update);

								$taxes.on('change', function() {
									var $cont = $(this).parents('.wps-images-source'),
										tax = $(this).val();

									$terms.hide().find('option').remove();
									update();

									if (tax === '0')
										return;
									else {
										var ajax_term_select = $.ajax({
											url: ajaxurl,
											type: 'post',
											dataType: 'html',
											data: {
												'action': 'wps_get_terms',
												'tax': tax,
												'class': 'wps-images-terms',
												'multiple': true,
												'size': 10
											},
											beforeSend: function() {
												if (typeof ajax_term_select === 'object') ajax_term_select.abort();
												$terms.html('').attr('disabled', true).hide();
												$cont.addClass('wps-loading');
											},
											success: function(data) {
												$terms.html(data).attr('disabled', false).show();
												$cont.removeClass('wps-loading');
											}
										});
									}
								});
							});

							$('select#wps-field-value-taxonomy').on('change', function() {
								var $taxonomy = $(this),
									tax = $taxonomy.val(),
									$terms = $('select#wps-field-value-tax_term');

								window.wps_get_terms = $.ajax({
									type: 'POST',
									url: ajaxurl,
									data: {
										action: 'wps_get_terms',
										tax: tax,
										noselect: true
									},
									dataType: 'html',
									beforeSend: function() {

										if (typeof window.wps_get_terms === 'object')
											window.wps_get_terms.abort();

										$terms.parent().addClass('wps-loading');
									},
									success: function(data) {
										$terms.find('option').remove();
										$terms.append(data);
										$terms.parent().removeClass('wps-loading');
									}
								});
							});

							$('.wps-set-value').click(function(e) {
								$(this).parents('.wps-field-wrapper').find('input').val($(this).text()).trigger('change');
							});
							$selected.val(shortcode);
						},
						dataType: 'html'
					});
				});

				$selector.on('click', '.wp-shortcode-insert', function(e) {
					e.preventDefault();
					if($('.wps-table-field').length > 0) {
						wpShortcodeAdmin.table_fields_value();
					}
					var shortcode = wpShortcodeAdmin.parse();
					$('#wp-shortcode-wrap').iziModal('close');
					$result.text(shortcode);
					window.wp.media.editor.insert(shortcode);
					return false;
				});
			},

			presets: function() {

				$(document).on('click', '.wps-preset-button', function(e) {
					e.preventDefault();
					$(this).parent().find('.wps-preset-options').toggle();
					return false;
				});

				$(document).on('click', '.wps-preset-list span', function(e) {
					e.preventDefault();
					var shortcode = $(this).parents('.wps-presets').data('shortcode'),
						id = $(this).data('id'),
						$insert = $('.wps-generator-insert');

					$('.wps-preset-options').hide();
					$.ajax({
						type: 'GET',
						url: ajaxurl,
						dataType: 'json',
						data: {
							action: 'wps_get_preset',
							id: id,
							shortcode: shortcode
						},
						beforeSend: function() {
							$insert.addClass('button-primary-disabled').attr('disabled', true);
						},
						success: function(data) {
							$insert.removeClass('button-primary-disabled').attr('disabled', false);

							var $settings = $('#wps-settings .wps-field-value'),
								$content = $('#wp-shortcode-content');

							$settings.each(function() {
								var $this = $(this),
									name = $this.attr('name');

								if (data.hasOwnProperty(name)) {
									$this.val(data[name]);
									if($this.hasClass('wp-color-picker')) {
										$this.iris('color', data[name]);
									} else if($this.parent().hasClass('wps-range-picker')) {
										$this.parent().find('.wps-admin-slider').slider("option", "value", data[name]);
									}
								}
							});

							if (data.hasOwnProperty('content'))
								$content.val(data['content']);

							wpShortcodeAdmin.update_preview();
						},
					});
				});
			},

			remove_preset: function(id) {

				$(document).on('click', '.wps-preset-list i', function(e) {
					e.preventDefault();
					var $list = $(this).parents('.wps-preset-list'),
						$preset = $(this).parent('span'),
						id = $preset.data('id');

					$preset.remove();

					if($list.find('span').length < 1)
						$list.find('b').show();

					var shortcode = $('.wps-presets').data('shortcode');

					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'wps_remove_preset',
							id: id,
							shortcode: shortcode
						}
					});
					return false;
				});
			},

			add_preset: function(id, name) {

				$(document).on('click', '.wps-save-preset', function(e) {
					var $container = $(this).parents('.wps-presets'),
						$list = $('.wps-preset-list'),
						id = new Date().getTime();

					var name = prompt('Please enter a name for new preset', 'New preset');

					if (name !== '' && name !== null) {
						$list.find('b').hide();
						var preset_data = '<span data-id="' + id + '"><em>' + name + '</em><i class="fa fa-times"></i></span>';

						$list.append(preset_data);
						var shortcode = $(this).parents('.wps-presets').data('shortcode'),
							settings = wpShortcodeAdmin.get();

						$.ajax({
							type: 'POST',
							url: ajaxurl,
							data: {
								action: 'wps_add_preset',
								id: id,
								name: name,
								shortcode: shortcode,
								settings: settings
							}
						});
					}
				});
			},

			update_preview: function() {
				if($('#wps-settings').find('.wps-table-field').length > 0) {
					wpShortcodeAdmin.table_fields_value();
				}
				var update_preview_request,
					$preview = $('#wp-shortcode-preview'),
					shortcode = wpShortcodeAdmin.parse(),
					shortcode_key = $(document).find('#wps-selected').val();

					update_preview_request = $.ajax({
						type: 'POST',
						url: ajaxurl,
						cache: false,
						dataType: 'html',
						data: {
							action: 'wp_shortcode_preview',
							shortcode: shortcode,
							shortcode_key: shortcode_key
						},
						beforeSend: function() {
							if (typeof update_preview_request === 'object') update_preview_request.abort();
							$preview.addClass('wps-loading').html('');
						},
						success: function(data) {
							$preview.html(data).removeClass('wps-loading').show();
						},
					});
				$('#wps-output').text(shortcode);
			},

			get: function() {

				var query = $(document).find('#wps-selected').val(),
					$settings = $('#wps-settings .wps-field-value'),
					content = $('#wp-shortcode-content').val(),
					data = {};

				$settings.each(function(i) {
					var $this = $(this),
						value = '',
						name = $this.attr('name');

					if ($this.is('select'))
						value = $this.find('option:selected').val();
					else
						value = $this.val();

					if (value == null)
						value = '';

					data[name] = value;
				});
				data['content'] = content.toString();
				return data;
			},

			parse: function() {

				var $prefix = $('#wps-prefix'),
					$selected = $(document).find('#wps-selected'),
					query = $selected.val(),
					prefix = $prefix.val(),
					$settings = $('#wps-settings .wps-field-wrapper .wps-field-value'),
					content = $('#wp-shortcode-content').val(),
					child_data = '',
					child_content = '',
					flag = true,
					child_result = new String(''),
					result = new String(''),
					is_mapped = $(document).find('input[name="is_mapped"]').length;

				if(is_mapped) {
					prefix = '';
					$(document).find('input[name="is_mapped"]').val('');
				}

				result += '[' + prefix + query;

				$settings.each(function() {
					var skip = false,
						$this = $(this),
						name = '',
						value = '';

					if ($this.is('select')) {
						value = $this.find('option:selected').val();
					} if ($this.is(':radio')) {
						if($this.is(':checked')) {
							value = $this.val();
						}
					} else if($this.hasClass('wps_is_checkbox')) {
						value = [];
						$this.find('input:checked').each(function(){
							value.push($(this).val());
						});
						name = $(this).find('input').attr('name');
						value = value.join(',');
					} else {
						value = $this.val();
					}
					if (value == null)
						value = '';
					else if(typeof value === 'array')
						value = value.join(',');

					if( $this.parent().hasClass('wps-shortcode-start') ) {
						child_data += '['+prefix+value;
						flag = false;
						skip = true;
						child_content = child_result = '';
					}
					if(name == '') {
						name = $this.attr('name');
					}
					if(flag) {
						if (value !== '')
							result += ' ' + name + '="' + value.toString().replace(/"/gi, "'") + '"';
					} else {
						if( value !== '' && !$this.parent().hasClass('wps-child-shortcode-wrapper') ) {
							if($this.parent().hasClass('wps-child-content')) {
								child_content = $this.val();
							} else {
								child_result += ' ' + name + '="' + value.toString().replace(/"/gi, "'") + '"';
							}
						}
					}

					if( $this.parent().hasClass('wps-shortcode-end') ) {
						child_data += child_result+']'+child_content+'[/'+prefix+value+']';
						flag = true;
					}

				});
				result += ']';

				if( child_data ) {
					result += child_data;
					result += '[/' + prefix + query + ']';
				} else if (content != 'false') {
					result += content + '[/' + prefix + query + ']';
				}
				return result;
			},

			import_settings: function() {

				$('.wps-action-buttons .wps-show-code').on('click', function(e){
					e.preventDefault();
					$(this).parents('.cmb-row').removeClass('show-file').toggleClass('show-code');
					$('#wps_import_type').val('import_code');
					return false;
				});

				$('.wps-action-buttons .wps-upload-file').on('click', function(e){
					e.preventDefault();
					$(this).parents('.cmb-row').removeClass('show-code').toggleClass('show-file');
					$('#wps_import_type').val('import_file');
					return false;
				});

				$('.wps-action-buttons .wps-import-demo').on('click', function(e){
					e.preventDefault();
					$('#wps_import_type').val('import_demo');
					$('#wp-shortcode-submit-cmb').trigger('click');
					return false;
				});

				$('#wps-import-button').on('click', function(e){
					e.preventDefault();
					$('#wp-shortcode-submit-cmb').trigger('click');
					return false;
				});

				$('.wps-export-settings-field input').on('change', function(e){
					e.preventDefault();
					if($(this).parents('ul').find('input:checked').length > 0) {
						var checkedValues = [],
							codetextarea = $('textarea#export-wps-settings'),
							base_url = $('#wps-dl-settings').data('basehref'),
							include_vars = '';
						codetextarea.text('...');
						$(this).parents('ul').find('input:checked').each(function() {
							checkedValues.push($(this).val());
							include_vars += $(this).val() + ',';
						});
						if(include_vars) {
							base_url = base_url+'&export='+include_vars;
						}
						$('#wps-dl-settings').attr('href', base_url);

						$.ajax({
							type: 'post',
							url: ajaxurl,
							data: {
								action: 'wps_get_settings',
								selected: checkedValues
							},
							dataType: 'html',
							success: function(data) {
								codetextarea.text(data);
							}
						});
					}
					return false;
				});
			},

			geocomplete_code: function() {
				var autocomplete = [];
				function setupAutocomplete(autocomplete, inputs, i) {
					if(typeof google !== 'object') return;
					autocomplete.push(new google.maps.places.Autocomplete(inputs[i]));

					 var idx = autocomplete.length - 1;
					 google.maps.event.addListener(autocomplete[idx], 'place_changed', function() {
					 	var place = autocomplete[idx].getPlace(),
					 		location_details = place.geometry.location.lat()+'/'+place.geometry.location.lng(),
					 		geo_wrapper = $(inputs[i]).parents('.wps-addresses').find('.geo-details'),
					 		geo_details = geo_wrapper.val();

					 	if(geo_details === '') {
					 		geo_details = location_details;
					 	} else {
					 		geo_details = geo_details + ',' + location_details;
					 	}
					 	geo_wrapper.val(geo_details);
					 });
				}
				var inputs = document.getElementsByClassName("wps-geocomplete");
				for (var i = 0; i < inputs.length; i++) {
					 setupAutocomplete(autocomplete, inputs, i);
				}
				$(document).on('click', '#wps-add-address', function(e){
					e.preventDefault();
					var $parent = $(this).parent(),
						newInput = [],
						count = ($parent.find(".wps-inner-wrapper input").length + 1),
					input_address = $parent.find('.wps-inner-wrapper input:first-child').clone().val('').attr('id', 'wps-geocomplete-'+count);
					$parent.find(".wps-inner-wrapper").append(input_address);

					var newEl = document.getElementById('wps-geocomplete-' + count);
						newInput.push(newEl);
						setupAutocomplete(autocomplete, newInput, 0);
					return false;
				});

			},

			table_fields: function() {
				wpShortcodeAdmin.table_fields_value();
				$(document).find('.wps-add-row').on('click', function(e){
					e.preventDefault();
					var tbody = $(this).parents('table').find('tbody'),
						row_data = $(tbody).find('tr:first-child').clone(),
						row_length = $(tbody).find('tr').length;
					$(row_data).find('td:not(:last-child)').text('');
					$(row_data).find('td:first-child').text('Row '+(row_length+1));
					$(tbody).append(row_data);
					wpShortcodeAdmin.update_preview();
					return false;
				});

				$(document).on('click', '.wps-remove-row', function(e){
					e.preventDefault();
					var row_data = $(this).parents('tr').remove();
					$('.wps-table-field').find('tbody tr').each(function(key, value){
						$(this).find('td:first-child').text('Row '+(key+1));
					});
					wpShortcodeAdmin.update_preview();
					return false;
				});

				$(document).on('click', '.wps-add-column', function(e){
					e.preventDefault();
					e.stopPropagation();
					var pos = $(this).parent().index();
					$('<th><span contenteditable="true">Column '+pos+'</span> <a href="#" class="wps-remove-column" title="Remove column"><i class="fa fa-minus"></i></a></th>').insertBefore($(this).parent());
					$('<td contenteditable="true"></td>').insertAfter('.wps-table-field table tbody tr td:nth-child('+pos+')');
					wpShortcodeAdmin.update_preview();
					return false;
				});

				$(document).on('click', '.wps-remove-column', function(e){
					e.preventDefault();
					var pos = $(this).parent().index();
					$('.wps-table-field').find('table tr').find('td:eq('+pos+'), th:eq('+pos+')').remove();
					wpShortcodeAdmin.update_preview();
					return false;
				});
			},

			table_fields_value: function() {
				var table_data = $('.wps-table-field').clone();
				$(table_data).find('tbody tr td:first-child, .wps-table-action,a').remove();
				$(table_data).find('table, tbody').removeAttr('class').removeAttr('border');
				$(table_data).find('td, th, span').removeAttr('contenteditable');
				$('#wp-shortcode-content').val(table_data.html());
			},

			create_shortcode: function() {
				if($('body').hasClass('post-type-wp_custom_shortcodes')) {
					$('.menu-top.toplevel_page_wp-shortcode-pro.wp-not-current-submenu').removeClass('wp-not-current-submenu').addClass('wp-has-current-submenu wp-menu-open').find('>a.wp-not-current-submenu').removeClass('wp-not-current-submenu').addClass('wp-has-current-submenu wp-menu-open');
				}

				accordionConfig = {
					header: "li .wps-field",
					collapsible: true,
					active: false,
					heightStyle: "content"
				};
				if(jQuery( "#wps-fields-data" ).length > 0) {
					if($('#wps-fields-data li').length >= 1) {
						$('#wps-fields-data .wps-fields-header.empty').hide();
						$('#wps-fields-data .wps-fields-header.exists').show();
					} else {
						$('#wps-fields-data .wps-fields-header.exists').hide();
						$('#wps-fields-data .wps-fields-header.empty').show();
					}
					// Initialize Accordion
					jQuery( "#wps-fields-data" ).accordion(accordionConfig);

					wpShortcodeAdmin.add_field(); // Add Field
					wpShortcodeAdmin.remove_field(); // Remove Field
					if($(document).find('#wps_new_shortcode_fields').length > 0) {
						wpShortcodeAdmin.sortable(); // Sort Field
						wpShortcodeAdmin.duplicate_field(); // Duplicate Field
						wpShortcodeAdmin.add_editor(); // Initialize WP Editor
					}

				}
			},

			sortable: function() {
				jQuery( "[data-sortable]" ).sortable({
					handle: ".wps-field",
					update: function( event, ui ) {
						wpShortcodeAdmin.reset_fields();
					}
				});

				$(document).find( ".wps-table-field table tbody" ).sortable({
					handle: ".wps-sort-row",
					update: function() {
						$('.wps-table-field tbody tr').each(function(key,value){
							$(this).find('.wps-sort-row').text('Row '+(key+1));
						});
					}
				});
				var oldIndex;
				$('.wps-table-field table thead tr').sortable({
					containerSelector: 'tr',
					itemSelector: 'th.wps-sort-row',
					placeholder: '<th class="placeholder"/>',
					vertical: false,
					cancel : '.wps-table-action',
					items: '> th:not(.wps-table-action)',
					start: function (event, ui) {
						oldIndex = ui.item.index();
					},
					update: function  (event, ui) {
						var field,
						$item = ui.item,
						newIndex = $item.index();
						$item.closest('table').find('tbody tr').each(function (i, row) {
							row = $(row);
							if(newIndex < oldIndex) {
								row.children().eq(newIndex).before(row.children()[oldIndex]);
							} else if (newIndex > oldIndex) {
								row.children().eq(newIndex).after(row.children()[oldIndex]);
							}
						});
					}
				});

				$('.wps-table-field table thead th').on('click', function(e){
					if($(this).hasClass('ui-sortable-helper')) {
						return;
					}
					$(this).find('span').focus();
				});
			},

			add_field: function() {

				$('.wps-field-selector button').on('click', function(e){
					e.preventDefault();
					e.stopPropagation();
					var field = $(this).data('field');
					var new_index = $('#wps-fields-data li').length;
					$.ajax({
						type: 'post',
						url: ajaxurl,
						data: {
							action: 'wps_add_field',
							field: field,
							new_index: new_index
						},
						success: function(data) {
							$('#wps-fields-data').append(data);

							if($('#wps-fields-data li').length === 1) {
								$('#wps-fields-data .wps-fields-header.empty').hide();
								$('#wps-fields-data .wps-fields-header.exists').show();
							}

							accordionConfig.active = $('#wps-fields-data li').length - 1;

							$('#wps-fields-data').accordion('destroy').accordion(accordionConfig);
							$('html,body').animate({
								scrollTop: $('#wps-fields-data .wps-attribute-wrapper:last-child').offset().top},
							'slow');
							wpShortcodeAdmin.initialize_library();
						}
					});
					return false;
				});

				// Add select opion
				$(document).on('click', '.wps-add-option', function(e){
					e.preventDefault();
					var data = $(this).prev().clone(),
						field_number = $(this).parents('.wps-attribute-wrapper').data('number'),
						total_options = parseInt($(this).parents('.wps-select-options').find('.wps-inner-wrapper').length);

					$(data).find('input.option-value').attr('name', 'wps-details[fields]['+field_number+'][values]['+ total_options +'][value]').val('');
					$(data).find('input.option-name').attr('name', 'wps-details[fields]['+field_number+'][values]['+ total_options +'][name]').val('');
					$(this).before(data);
					return false;
				});

				// Remove select opion
				$(document).on('click', '.wps-remove-option i', function(){
					var $parent = $(this).parents('.wps-select-options'),
						$field_number = $(this).parents('.wps-attribute-wrapper').data('number');

					$(this).parents('.wps-inner-wrapper').remove();
					$parent.find('.wps-inner-wrapper').each(function(key, value){
						$(this).find('.option-value').attr('name', 'wps-details[fields]['+$field_number+'][values]['+key+'][value]');
						$(this).find('.option-name').attr('name', 'wps-details[fields]['+$field_number+'][values]['+key+'][name]');
					});
				});

				//Change field description text when title or id is changed
				$(document).on('keyup', '.wps-attribute-wrapper .wps-field-id, .wps-attribute-wrapper .wps-field-name', function(e) {

					var $parent = $(this).parents('.wps-attribute-wrapper'),
							field_id = $parent.find('#wps-field-id').val(),
							field_name = $parent.find('#wps-field-name').val(),
							field_text = '';
							if(field_id == '' && field_name == '') {
								field_text = $parent.find('input[type="hidden"]').val();
							} else {
								if(field_name == '') {
									field_text = '('+field_id+')';
								} else if(field_id == '') {
									field_text = field_name;
								} else {
									field_text = field_name+' ('+field_id+')';
								}
							}
							$parent.find('.wps-field-title').html(field_text);
				});

			},

			// Remove field
			remove_field: function() {
				$(document).on('click', '.wps-field-actions .wps-delete-field', function(e) {
					e.preventDefault();
					e.stopPropagation();
					$(this).parents('li.wps-attribute-wrapper').remove();
					if($('#wps-fields-data li').length < 1) {
						$('#wps-fields-data .wps-fields-header.exists').hide();
						$('#wps-fields-data .wps-fields-header.empty').show();
					}
					wpShortcodeAdmin.reset_fields(); // Reset Field names
				});
			},

			// Duplicate field
			duplicate_field: function() {
				$(document).on('click', '.wps-field-actions .wps-duplicate-field', function(e) {
					e.preventDefault();
					e.stopPropagation();
					$('#wps-fields-data').accordion('destroy');
					var data = $(this).parents('li.wps-attribute-wrapper').clone();
					$(data).find('.wps-field-options').css('height', 'auto');
					$(this).parents('ul#wps-fields-data').append(data);
					wpShortcodeAdmin.initialize_library();
					$('#wps-fields-data').accordion(accordionConfig);
					wpShortcodeAdmin.reset_fields();
				});
			},

			reset_fields: function() {
				$('#wps-fields-data > li.wps-attribute-wrapper').each(function(key, value){
					var number = $(this).attr('data-number');
					$(this).find('.wps-field-holder input, .wps-field-holder select').each(function(){
						var field_key = $(this).parents('.wps-field-holder').data('field'),
							field_name = $(this).attr('name');

						if(field_name !== undefined) {
							field_name = field_name.replace('wps-details[fields]['+number+']['+field_key+']', 'wps-details[fields]['+key+']['+field_key+']');
							$(this).attr('name', field_name);
						}
					});
					$(this).attr('data-number', key);
				});
			},

			add_editor: function() {
				$('textarea[data-editor]').each(function () {
					var textarea = $(this),
						settings = textarea.data('editor');
					wp.codeEditor.initialize(textarea, settings);
				});
			},

			map_shortcode: function() {

				// Initialize Accordion
				var mapaccordionConfig = {
					collapsible: true,
					active: false,
					heightStyle: "content"
				};
				$( "#wps-mapped-shortcodes" ).accordion(mapaccordionConfig);
				$('.wps-fields-data').accordion(accordionConfig);

				$('.wps-parse-button').on('click', function(e) {
					e.preventDefault();
					var $this = $(this),
						wrapper = $(this).parents('.wp-shortcode-wrap-settings'),
						shortcode = $('.wp-parse-shortcode-wrapper input').val();

					wrapper.find('#message').addClass('wps-hidden').find('p').html('');

					if(! shortcode) {
						wrapper.find('#message').removeClass('wps-hidden').find('p').html('Error: Please enter valid shortcode to parse!');
					} else {
						var string = shortcode.toString().trim(),
							name = string.split(' ')[0].replace(/\[/g, '').replace(/\]/g, '').trim();

						if (!(string.indexOf('['+name) === 0 && string.indexOf('[/'+name+']') === (string.length-3-name.length))) {
							if ( (string.indexOf('[') > -1 && (string.indexOf('[') > 0 || string.indexOf(']') === -1)) || (string.indexOf(']') > -1 && string.indexOf(']') < string.length-1) ) {
								wrapper.find('#message').removeClass('wps-hidden').find('p').html('Error: Invalid shortcode format.');
								return;
							}
						}

						var shortcode_type = "single";
						if (string.indexOf('[') === -1 && string.indexOf(']') === -1) {
							string = '['+string+']';
						}

						var shortcode_fields = parse_shortcode(string, name),
							shortcode_details = {};
						shortcode_details['key'] = name;
						if(shortcode_fields !== undefined) {
						 	shortcode_details['fields']= shortcode_fields;
						 	if(shortcode_fields['content'] !== undefined) {
						 		shortcode_details['content']= shortcode_fields['content'];
						 		shortcode_type = 'wrap';
						 	}
						}
						shortcode_details['type'] = shortcode_type;

						$.ajax({
							type: 'post',
							url: ajaxurl,
							data: {
								action: 'wps_map_shortcode',
								shortcode_details: shortcode_details
							},
							success: function(data) {
								$('.wp-parse-shortcode-wrapper input').val('');
								$('#wps-mapped-shortcodes').append(data);
								wpShortcodeAdmin.initialize_library();
								$('#wps-mapped-shortcodes').accordion('destroy').accordion(mapaccordionConfig);
								$('#wps-mapped-shortcodes .wps-fields-data').each(function() {
									$(this).accordion(accordionConfig);
								});
							}
						});
					}
					return false;
				});

				$(document).on('click', '#wps-mapped-shortcodes .wps-new-field', function(e) {
					e.preventDefault();
					$('.wps-fields-data').accordion('destroy');
					var data = $(this).prev('ul#wps-fields-data').find('li.wps-attribute-wrapper:first-child').clone();
					$(data).find('input').val('');
					$(this).prev('ul#wps-fields-data').append(data);
					$('.wps-fields-data').accordion(accordionConfig);
					return false;
				});

				$(document).on('change paste keyup', '#wps-mapped-shortcodes .wps-field-id', function() {

					var new_field_id = $(this).val();
					var shortcode = $(this).parents('li.wps-inner-wrapper').find('.wps-shortcode-key').val();

					$(this).parents('.wps-field-options').find('input, select, textarea').each(function(){
						var field_id = $(this).data('field');
						var name = 'wps_mapper['+shortcode+'][fields]['+new_field_id+']['+field_id+']';
						$(this).attr('name', name);
					});
				});

				$(document).on('change', '#wps-mapped-shortcodes .wps-field-type', function(){
					var value = $(this).val(),
						next_holder = $(this).parents('.wps-field-holder').next('.wps-field-holder');
					if(value === 'select' || value === 'radio' || value === 'checkbox') {
						next_holder.removeClass('wps-hidden');
					} else {
						next_holder.addClass('wps-hidden');
					}
				});

				$(document).on('change', '#wps-mapped-shortcodes .wps-type', function(){
					var value = $(this).val(),
						content_holder = $(this).parents('.wps-general-info').find('.wps-conent-holder');
					if(value === 'wrap') {
						content_holder.removeClass('wps-hidden');
					} else {
						content_holder.addClass('wps-hidden');
					}
				});

				function parse_shortcode(string, tag) {

					var regx = new RegExp ('\\[(\\[?)(' + tag + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)', 'g'),
						split_args = /([a-zA-Z0-9\-\_]+)="([^"]+)+"/gi,
						result, params, args = '';
					while (result = regx.exec(string)) {
						params = [];
						while (args = split_args.exec(result[3])) {
							params.push({
								id: args[1],
								name: args[1].replace(/\_/g, ' ').replace(/\-/g, ' '),
								default: args[2],
								content: result[5]
							});
						}
						params['content'] = result[5];
					}
					return params;
				}

				$(document).on('click', '.wps-field-actions .wps-delete-shortcode', function(e) {
					e.preventDefault();
					var delete_shortcode = confirm("Are you sure you want to delete this shortcode?");
					if(delete_shortcode === true) $(this).parents('li.wps-inner-wrapper').remove();
					return false;
				});
			},
		};

		wpShortcodeAdmin.init();
	});

})( jQuery );
