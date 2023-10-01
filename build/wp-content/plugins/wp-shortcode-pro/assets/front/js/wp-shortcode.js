/*
 * WP Shortcode Pro plugin by MyThemeShop
 * https://mythemeshop.com/plugins/wp-shortcode-pro/
 */
 
;(function( $ ) {

	'use strict';

	$(function() {
		
		var wpShortcode = {
			
			init: function() {
				
				var scripts = ['accordion', 'tabs', 'tooltip', 'expand', 'video', 'animation', 'slider', 'gallery', 'lightbox', 'separator', 'countup', 'countdown', 'faq', 'progress_bar', 'content_slider', 'splash_screen', 'flyout', 'google_charts', 'pie_chart', 'geo_chart', 'bar_chart', 'area_chart', 'combo_chart', 'org_chart', 'bubble_chart', 'clipboard', 'toc'];

				jQuery(scripts).each(function(key, value){
					if( $(document).find('.wps-'+value).length > 0 ) {
						wpShortcode[value]();
					}
				});
			},

			// Accordion JS
			accordion: function() {
				$(document).on('click', '.wps-panel-title', function(e) {
					e.preventDefault();
					$(this).parent().toggleClass('is-closed').toggleClass('is-open');
					return false;
				});
			},

			// Tabs JS
			tabs: function() {
				$(document).on('click', '.wps-tabs-list li', function(e) {
					e.preventDefault();
					var $this = $(this),
						data = $this.data(),
						index = $this.index(),
						is_disabled = $this.hasClass('wps-tabs-disabled'),
						$tabs = $this.parent('.wps-tabs-list').children('li'),
						$panes = $this.parents('.wps-tabs').find('.wps-tab-text');

					if (is_disabled) return false;

					$panes.hide().eq(index).show();

					$tabs.removeClass('wps-active').eq(index).addClass('wps-active');

					if (data.url !== '') {
						if (data.target === 'self')
							window.location = data.url;
						else
							window.open(data.url);
					}
				});
			},

			// Tooltip JS
			tooltip: function() {
				$(document).find('.wps-tooltip').each(function() {
					var $this = $(this),
						data = $this.data();
					var position = data.position;
					var behavior = data.behavior;
					if( behavior == 'always' ) behavior = 'manual';
					$this.tipsy({
						position: position,
						trigger: behavior,
						cls: data.classes+' '+position,
					});
					if( behavior == 'manual' ) {
						$this.tipsy("show");
					}
				});
			},

			//Expand JS
			expand: function() {

				$(document).on('click', '.wps-expand-link-more a', function(e){
					e.preventDefault();
					$(this).parents('.wps-expand').removeClass('wps-expand-collapsed').find('.wps-expand-content').css('height', 'auto');
					return false;
				});

				$(document).on('click', '.wps-expand-link-less a', function(e){
					e.preventDefault();
					var expand_height = $(this).parents('.wps-expand').attr('data-height');
					$(this).parents('.wps-expand').addClass('wps-expand-collapsed').find('.wps-expand-content').css('height', expand_height);
					return false;
				});
			},

			//Video JS
			video: function() {
				$(document).on('click', '.wps-play-icon', function(e){
					e.preventDefault();
					var video = $(this).parent().addClass('in').find('video')[0];
					video.play();
					return false;
				});
			},

			//Animation Js
			animation: function() {
				$('.wps-animation').each(function() {
					var $this = $(this),
						data = $this.data();
					window.setTimeout(function() {
						$this.addClass(data.animation);
						$this.addClass('animated');
						$this.css('visibility', 'visible');
					}, data.delay * 1000);
				});
			},

			//Slider JS
			slider: function() {

				var is_rtl = false;
				if(jQuery('body').hasClass('rtl')) is_rtl = true;

				$('.wps-slider').each(function() {

					var $this = $(this),
						slider_settings = $this.data('slider-settings'),
						autoplay = slider_settings.autoplay,
						speed = slider_settings.speed,
						gallery = slider_settings.gallery,
						controls = slider_settings.arrows,
						pager = slider_settings.pager;
					if(gallery) pager = true;
					if( autoplay == 0 ) autoplay = false;
					$this.lightSlider({
						thumbItem: 2,
						mode: 'slide',
						auto: autoplay,
						pause: 3000,
						speed: speed,
						pager: pager,
						controls: controls,
						prevHtml: '<i class="fa fa-chevron-left"></i>',
						nextHtml: '<i class="fa fa-chevron-right"></i>',
						addClass: 'wps-gallery',
						gallery: gallery,
						item: 1,
						autoWidth: false,
						loop: true,
						slideMargin: 0,
						galleryMargin: 10,
						thumbMargin: 10,
						enableDrag: false,
						currentPagerPosition: 'left',
						rtl: is_rtl,
						onSliderLoad: function (el) {
							if($this.hasClass('wps-show-lightbox')) {
								el.lightGallery({
									selector: $this.find('.lslide')
								});
							}
						}
					});
				});

			},

			//Gallery JS
			gallery: function() {
				if( $('.wps-lightbox-gallery').length > 0 ) {
					$('.wps-lightbox-gallery').lightGallery({
						selector: $('.wps-lightbox-gallery').find('.wps-custom-gallery-inner')
					});
				}
			},

			//Divider JS
			separator: function() {
				$(document).on('click', '.wps-separator', function(e) {
					e.preventDefault();
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
				});
			},

			// Lightbox JS
			lightbox: function() {
				$(document).on('click', '.wps-lightbox', function(e) {
					e.preventDefault();
					e.stopPropagation();
					var type = $(this).data('mfp-type');
					$(this).magnificPopup({
						type: type,
					}).magnificPopup('open');
				});
			},

			// CountUp JS
			countup: function() {
				jQuery('.wps-countup').each(function(){

					var data = $(this).find('.wps-countup-wrapper').data(),
						selector = $(this).find('.wps-countup-wrapper').attr('id'),
						count_start = data.count_start,
						count_end = data.count_end,
						decimal = data.decimal,
						prefix = data.prefix,
						suffix = data.suffix,
						duration = data.duration,
						separator = data.separator,

						options = {
							useEasing: true,
							useGrouping: true,
							separator: separator,
							decimal: decimal,
							prefix: prefix, 
							suffix: suffix 
						};

					if( decimal ) decimal = '2';
					var countup = new CountUp( selector, count_start, count_end, decimal, duration, options );
					if (!countup.error) {
						countup.start();
					} else {
						console.error(countup.error);
					}
				});
			},

			// CountDown JS
			countdown: function() {
				jQuery('.wps-countdown').each(function(){
					var countdown_wrapper = $(this).find('.wps-countdown-wrapper');
					if( ! countdown_wrapper.length ) {
						return true;
					}

					var date = $(countdown_wrapper).data('date');
					var time = $(countdown_wrapper).data('time');
					$(countdown_wrapper).countdown(date+" "+time).on('update.countdown', function(event){
						var days = event.strftime('%D');
						var hours = event.strftime('%H');
						var minutes = event.strftime('%M');
						var seconds = event.strftime('%S');
						$(this).find('.wps-day').text(days);
						$(this).find('.wps-hour').text(hours);
						$(this).find('.wps-min').text(minutes);
						$(this).find('.wps-sec').text(seconds);
					});
				});
			},

			//FAQ JS
			faq: function() {
				$('.wps-question-wrapper').on('click', function(){
					var $parent = $(this).parent();
					$parent.find('.wps-answer-wrapper').slideToggle('500', function(){
						$parent.toggleClass('active');	
					});
				});
			},

			//Progress Bar JS
			progress_bar: function() {

				$('.wps-progress_bar').each(function(){

					var	$this = $(this),
					$fill = $this.data('fill_color'),
					color = $this.data('bar_color'),
					text_color = $this.data('text_color'),
					$ptext = $this.find('.wps-text'),
					percent = $this.data('percent'),
					style = $this.data('style'),
					animation = 'easein',
					height = $this.data('height'),
					duration = $this.data('duration')*1000,
					delay = $this.data('delay')*1000;
					if( style == 'pie' ) {

						var container = $this.find('.wps-progress-pie').attr('id');
						container = $('#'+container)[0];
						var bar = new ProgressBar.Circle(container, {
								color: text_color,
								strokeWidth: height,
								trailWidth: height,
								easing: 'easeInOut',
								duration: duration,
								delay: delay,
								text: { autoStyleContainer: false },
								from: { color: $fill, width: height },
								to: { color: color, width: height},
								step: function(state, circle) {
									circle.path.setAttribute('stroke', state.color);
									circle.path.setAttribute('stroke-width', state.width);

									var value = Math.round(circle.value() * 100);
									if (value === 0) {
										circle.setText(value+'%');
									} else {
										var show_percent = $this.data('show_percent');
										var text = $this.data('text');
										var output_text = text+'<br />';
										if(show_percent == 'yes') {
											output_text += value+'%';
										}
										circle.setText(output_text);
									}
								}
							});

						  bar.animate(percent/100); 

					} else {
						setTimeout(function() {
							$this.find('.wps-inner-wrapper').animate({ 'width' : percent + '%'}, duration,
								function() {
									$ptext.animate({ 'margin-right' : '0px', 'opacity': 1  }, duration);
								}).addClass('wps-pb-animated');
						}, delay);
					}
				});
			},

			//Content Slider
			content_slider: function() {

				$('.wps-content_slider').each(function(){

					var $this = $(this).find('.owl-carousel'),
						pagination = $this.data('pagination'),
						nvaigation = $this.data('arrows'),
						animateIn = $this.data('animatein'),
						autoplay = $this.data('autoplay'),
						is_rtl = false,
						animateOut = $this.data('animateout');
						var nav_text = [
							"<i class='fa fa-angle-left'></i>",
							"<i class='fa fa-angle-right'></i>"
						];

					if($('body').hasClass('rtl')) {
						is_rtl = true;
						if($this.data('arrow_position') && $this.data('arrow_position') !== 'center') {
							var nav_text = [
								"<i class='fa fa-angle-right'></i>",
								"<i class='fa fa-angle-left'></i>"
							];
						}
					}

					$this.owlCarousel({
						autoplay: autoplay,
						animateOut: animateOut,
						animateIn: animateIn,
						nav: nvaigation,
						autoHeight: true,
						loop:true,
						rtl: is_rtl,
						navText: nav_text,
						dots: pagination,
						items: 1
					});
				});
			},

			// Splash Screen JS
			splash_screen: function() {

				$('.wps-splash_screen').each(function () {

					var $this = $(this),
					data = $this.data();
					$this.removeClass('wps-hidden');
					$this.find('p:empty').remove();
					window.setTimeout(function () {
						$.magnificPopup.open({
							closeBtnInside: true,
							showCloseBtn: data.close === 'yes',
							enableEscapeKey: data.esc === 'yes',
							callbacks: {
								beforeOpen: function () {
									$('body').addClass('wps-splash wps-mfg-open');
								},
								open: function () {
									$('.mfp-bg').css('opacity', (data.opacity/100));
									$('.mfp-bg').css('background', data.overlay_bg);
									$('body').on('mousedown.wps', function (e) {
										if (data.onclick === 'yes') $.magnificPopup.close();
									});
								},
								close: function () {
									$('.mfp-bg').attr('style', '');
									$('body').removeClass('wps-splash wps-mfg-open');
									$('body').unbind('mousedown.wps');
								}
							},
							items: {
								src: $this
							},
							type: 'inline'
						}, 0);
					}, parseInt(data.delay) * 1000 + 10);
				});
			},

			//Flyout Js
			flyout: function() {

				$('.wps-flyout').each(function() {
					var $this = $(this),
						data = $this.data();
						if(data.transitionin) {
							$this.addClass(data.transitionin);
							$this.addClass('animated');
						}
				});

				$(document).on('click', '.wps-flyout .wps-close', function(e){
					e.preventDefault();
					var $parent = $(this).parent();
					var data = $parent.data();
					if(data.transitionout) {
						$parent.removeClass(data.transitionin).addClass(data.transitionout);
						$parent.addClass('animated');
					}
					return false;
				});

			},

			//Google Charts
			google_charts: function() {
				google.charts.load('current', {packages:["corechart", "orgchart", "bar", "geochart"]});
			},

			//Pie Chart
			pie_chart: function() {

				$('.wps-pie_chart').each(function(){

					var $this = $(this),
						id = $this.attr('id'),
						data = $this.data(),
						columns = data.columns.split('|'),
						rows = data.rows.split('|'),
						rowsData = [];
					$.each(rows, function( key, value ) {
						var values = value.split(',');
						rowsData[key] = [values[0], parseInt(values[1]), values[2]];
					});

					google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var chart_data = new google.visualization.DataTable();
						chart_data.addColumn('string', columns[0]);
						chart_data.addColumn('number', columns[1]);
						chart_data.addColumn('string', columns[2]);
						chart_data.addRows(rowsData);
						var options = {
							'title': data.title,
							'width': data.width,
							'height':data.height,
							is3D: data.is3d
						};

						var chart = new google.visualization.PieChart(document.getElementById(id));
						chart.draw(chart_data, options);
					}

				});
			},

			// Geo chart
			geo_chart: function() {

				$('.wps-geo_chart').each(function(){
					var $this = $(this),
						id = $this.attr('id'),
						data = $this.data(),
						columns = data.columns.split('|'),
						rows = data.rows.split('|'),
						rowsData = [];

					rowsData.push(columns);
					$.each(rows, function( key, value ) {
						var values = value.split(',');
						rowsData.push([values[0], parseInt(values[1])]);
					});
					google.charts.setOnLoadCallback(drawRegionsMap);

					function drawRegionsMap() {
						var data = google.visualization.arrayToDataTable(rowsData);
						
						var options = {
							'title': data.title,
							'width': data.width,
							'height':data.height
						};

						var chart = new google.visualization.GeoChart(document.getElementById(id));
						chart.draw(data, options);
					}
				});
			},

			// Bar chart
			bar_chart: function() {

				$('.wps-bar_chart').each(function(){
					var $this = $(this),
						id = $this.attr('id'),
						data = $this.data(),
						columns = data.columns.split('|'),
						rows = data.rows.split('|'),
						rowsData = [];

					rowsData.push(columns);
					$.each(rows, function( key, value ) {
						var values = value.split(',');
						rowsData.push([values[0], values[1], values[2]]);
					});

					google.charts.setOnLoadCallback(drawStuff);

					function drawStuff() {
						var chart_data = new google.visualization.arrayToDataTable(rowsData);

						var options = {
							width: data.width,
							height: data.height,
							chart: {
								title: data.title
							},
							bars: 'horizontal', // Required for Material Bar Charts.
							series: {
								0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
								1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
							},
							axes: {
								x: {
									distance: {label: data.xaxis_bottom}, // Bottom x-axis.
									brightness: {side: 'top', label: data.xaxis_top} // Top x-axis.
								},
							},
						};

						var chart = new google.charts.Bar(document.getElementById(id));
						chart.draw(chart_data, options);
					};
				});
			},
			// Area chart
			area_chart: function() {

				$('.wps-area_chart').each(function(){
					var $this = $(this),
						id = $this.attr('id'),
						data = $this.data(),
						columns = data.columns.split('|'),
						rows = data.rows.split('|'),
						rowsData = [];
					rowsData.push(columns);
					$.each(rows, function( key, value ) {
						var values = value.split(',');
						rowsData.push([values[0], parseInt(values[1]), parseInt(values[2])]);
					});

					google.charts.setOnLoadCallback(drawArea);

					function drawArea() {
						var chart_data = google.visualization.arrayToDataTable(rowsData);

						var options = {
							title: data.title,
							width: data.width,
							height:data.height,
							hAxis: {title: data.haxis,
							titleTextStyle: {color: '#333'}},
							vAxis: {minValue: 0, title: data.vaxis}
						};

						var chart = new google.visualization.AreaChart(document.getElementById(id));
						chart.draw(chart_data, options);
					}
				});
			},
			// Combo chart
			combo_chart: function() {

				$('.wps-combo_chart').each(function(){
					var $this = $(this),
						id = $this.attr('id'),
						data = $this.data(),
						columns = data.columns.split('|'),
						rows = data.rows.split('|'),
						rowData = [],
						rowsData = [];
					rowsData.push(columns);
					$.each(rows, function( key, value ) {
						var values = value.split(',');

						for (var i = 0; i<values.length; i++) {
							if($.isNumeric( values[i] )) {
								values[i] = parseInt(values[i]);
							}
							rowData.push(values[i]);
						}
						rowsData.push(values);
					});

					google.charts.setOnLoadCallback(drawVisualization);

					function drawVisualization() {
						// Some raw data (not necessarily accurate)
						var chart_data = google.visualization.arrayToDataTable(rowsData);

						var options = {
							title: data.title,
							width: data.width,
							height:data.height,
							vAxis: {title: data.vaxis},
							hAxis: {title: data.haxis},
							seriesType: 'bars',
							series: {5: {type: 'line'}}
						};

						var chart = new google.visualization.ComboChart(document.getElementById(id));
						chart.draw(chart_data, options);
					}
				});
			},

			// Org Chart
			org_chart: function() {

				$('.wps-org_chart').each(function(){
					var $this = $(this),
						id = $this.attr('id'),
						data = $this.data(),
						columns = data.columns.split('|'),
						rows = data.rows.split('|'),
						rowData = [],
						rowsData = [];

						$.each(rows, function( key, value ) {
							value = value.replace('null', '');
							var values = value.split(',');

							for (var i = 0; i<values.length; i++) {
								values[i] = $.trim(values[i]);
								rowData.push(values[i]);
							}
							rowsData.push(values);
						});

						google.charts.setOnLoadCallback(drawOrg);

						function drawOrg() {
							var chart_data = new google.visualization.DataTable();
							$(columns).each(function(key, value){
								chart_data.addColumn('string', value);	
							});

							// For each orgchart box, provide the name, manager, and tooltip to show.
							chart_data.addRows(rowsData);
							chart_data.setTableProperty('style', 'border-collapse:inherit');
							// Create the chart.
							var chart = new google.visualization.OrgChart(document.getElementById(id));
							// Draw the chart, setting the allowHtml option to true for the tooltips.
							chart.draw(chart_data, {allowHtml:true});
							chart.draw(chart_data, {size:data.size});
						}

					});
				},

				bubble_chart: function() {

					$('.wps-bubble_chart').each(function(){
						var $this = $(this),
							id = $this.attr('id'),
							data = $this.data(),
							columns = data.columns.split('|'),
							rows = data.rows.split('|'),
							rowData = [],
							rowsData = [];
						rowsData.push(columns);
						$.each(rows, function( key, value ) {
							value = value.replace('null', '');
							var values = value.split(',');

							for (var i = 0; i<values.length; i++) {
								if($.isNumeric( values[i] )) {
									values[i] = parseInt(values[i]);
								}
								rowData.push(values[i]);
							}
							rowsData.push(values);
						});

						google.charts.setOnLoadCallback(drawBubble);
						function drawBubble() {
							var chart_data = google.visualization.arrayToDataTable(rowsData);

							var options = {
								title: data.title,
								vAxis: {title: data.vaxis},
								hAxis: {title: data.haxis},
								colorAxis: {colors: [data.primary_color, data.secondary_color]}
							};

							var chart = new google.visualization.BubbleChart(document.getElementById(id));
							chart.draw(chart_data, options);
						}

					});
				},

				clipboard: function() {
					$('.wps-clipboard').each(function(){
						var $this = $(this),
							$selector = $(this).find('.wps-copy-clipboard'),
							clipboard = new Clipboard($selector[0], {
							target: function(trigger) {
								return $this.find('pre')[0];
							},
						});
						clipboard.on('success', function(e){
							$selector.attr('title', 'Copied');
							$selector.tipsy({
								position: 'top-center',
								trigger: 'manual',
							});
							$selector.tipsy("show");
							setTimeout(function(){
								$selector.tipsy("hide");
								$selector.attr('title', '');
							}, 1000);
						});
					});
				},

				//Table of Contents JS
				toc: function() {

					if($('body').find('.wps-style-sticky').length > 0) {

						var r = 'currentPos',
						s = { propertyName: 'value' };

						function toc_elements(window, document) {
							this.element = window;
							this.showProgress = !0;
							this.settings = $.extend({}, s, document);
							this.settings.anchors = [];
							this.init();
						}

						$.extend(toc_elements.prototype, {

							init: function() {
								var headings = $(this.element).find(this.settings.heading);
								headings.each(function(key, value) {
									$(value).attr("id", "wps_toc-title-" + key);
									var startPos = $(value).offset().top,
											endPos = headings[key + 1] ? $(headings[key + 1]).offset().top : $(this.element).offset().top + $(this.element).height();
									this.settings.anchors.push({
										element: value,
										title: $(value).text(),
										position: {
											start: startPos,
											end: endPos
										}
									});
								}.bind(this));
								headings.length !== 0 && (
									this.render(),
									$(document).on("scroll", this.ScrollPos.bind(this)),
									$(document).on("click", ".wps-toc-item a", this.scrollTo.bind(this)),
									$(window).on("resize", this.TotalSections.bind(this))
								);
							},

							render: function() {
								var circle_svg = $('<svg x="0px" width="36px" height="36px" y="0px" viewBox="0 0 36 36"><circle fill="none" stroke="#0073aa" stroke-width="3" cx="18" cy="18" r="16" stroke-dasharray="100 100" stroke-dashoffset="100" transform="rotate(-90 18 18)"></circle></svg>'),
										anchors = this.settings.anchors;

								$('.wps-style-sticky .wps-toc-list > li').each( function(key) {
									var svg_clone = circle_svg.clone();
									$(this).addClass('wps-toc-item').prepend(svg_clone);
									var anchor = $(this).find('>a');
									anchor.attr('href', "#wps_toc-title-"+key).html('<span class="wps_toc_text-el">'+anchor.text()+'</span>');
									anchors[key].link = anchor;
									anchors[key].listItem = $(this);
									anchors[key].icon = svg_clone;
								});
							},

							scrollTo: function(e) {
								e.preventDefault(),
								this.TotalSections();
								var current = $(e.target).closest("a"),
										element = $(this.element).find(current.attr("href")).offset().top;
								this.showProgress = !1, $("html, body").animate({
									scrollTop: element
								}, 300, function() {
									this.showProgress = !0, this.ScrollPos();
								}.bind(this));
							},

							ScrollPos: function() {
								var pos = window.pageYOffset + 150;
								this.showProgress &&
								$.grep(this.settings.anchors, function(e) {
									if(pos > e.position.start && pos < e.position.end) {
								 		$(e.listItem).addClass("current");
								 		this.SetPos({
											start: e.position.start,
											end: e.position.end,
											current: pos,
											icon: e.icon
										});
									} else {
										$(e.listItem).removeClass("current");
									}
								}.bind(this));
							},

							SetPos: function(e) {
								var currentPos = (e.current - e.start) / (e.end - e.start) * 100;
								$(e.icon).find("circle").attr("stroke-dashoffset", 100 - currentPos);
							},

							TotalSections: function() {
								$.grep(this.settings.anchors, function(e, i) {
									e.position.start = $(e.element).offset().top,
									e.position.end = this.settings.anchors[i + 1] ? $(this.settings.anchors[i + 1].element).offset().top : $(this.element).offset().top + $(this.element).height();
								}.bind(this));
							}
						}), $.fn[r] = function(e) {
							return this.each(function() {
								$.data(this, "wps_toc" + r) || $.data(this, "wps_toc" + r, new toc_elements(this, e));
							});
						}
						$('.wps-toc.wps-style-sticky').parent().currentPos({
							heading: 'h1'
						});
					} else {
						var menu = $('.wps-toc-list'),
								menuItems = menu.find('a'),
								scrollItems = menuItems.map(function(){
									var item = $($(this).attr("href"));
									if (item.length) { return item; }
								});

						// On scroll make element active
						$(window).scroll(function(){
							var fromTop = $(this).scrollTop()+20;
							var cur = scrollItems.map(function(){
								if ($(this).offset().top < fromTop)
									return this;
							});
							cur = cur[cur.length-1];
							var id = cur && cur.length ? cur[0].id : "";
							menuItems.parent().removeClass("active").end().filter("[href='#"+id+"']").parents('li').addClass("active");
						});

						$(menuItems).on('click', function(e){
							e.preventDefault();
							$('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 500);
							$(this).parents('li').addClass('active');
							return false;
						});

						$(document).on('click', function(e){
							if(jQuery(e.target).parents('.wps-toc').length == 0) {
								if($('.wps-inner-wrapper').hasClass('in')) {
									$('.wps-toc-close').trigger('click');
								}
							}
						});
					}

					$('.toc-collapsible-button').on('click', function(e){
						e.preventDefault();
						$(this).prev('.wps-inner-wrapper').addClass('in');
						return false;
					});

					$('.wps-toc-close').on('click', function(e){
						e.preventDefault();
						$(this).parent('.wps-inner-wrapper').removeClass('in');
						return false;
					});
				}
			}

		wpShortcode.init();
	});



})( jQuery );