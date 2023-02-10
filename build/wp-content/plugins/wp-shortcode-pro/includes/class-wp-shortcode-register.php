<?php
class WPS_Load extends WP_Shortcode_Base {

	public $default_toc_options = array();

	function __construct() {
		$this->add_action( 'init', 'register_shortcode' );
		$this->add_filter( 'the_content', 'the_content', 99999, 1 );	// run after shortcodes are interpretted (level 10)
	}

	/**
	 * Register shortcodes
	 */
	public static function register_shortcode() {
		$prefix = wps_prefix();

		foreach ( ( array ) wp_shortcode()->list->shortcodes() as $id => $data ) {
			if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) {
				$func = $data['function'];
			} elseif ( is_callable( array( 'WP_Shortcodes', $id ) ) ) {
				$func = array( 'WP_Shortcodes', $id );
			} elseif ( is_callable( array( 'WP_Shortcodes', 'wps_' . $id ) ) ) {
				$func = array( 'WP_Shortcodes', 'wps_' . $id );
			}  else
				continue;
			add_shortcode( $prefix . $id, $func );
		}

		$custom_shortcodes = get_posts(array(
			'post_type' => 'wp_custom_shortcodes',
			'post_status' => 'any',
		));

		if( !empty($custom_shortcodes) ) {
			foreach($custom_shortcodes as $shortcode) {
				add_shortcode( $prefix . $shortcode->post_name, array( 'WP_Shortcodes', 'wps_custom_shortcodes' ) );
			}
		}

		//Old Shortcodes
		$old_shortcodes = array(
			'button-brown'		=> 'mts_button_brown',
			'button-blue'		=> 'mts_button_blue',
			'button-green'		=> 'mts_button_green',
			'button-red'		=> 'mts_button_red',
			'button-white'		=> 'mts_button_white',
			'button-yellow'		=> 'mts_button_yellow',
			'alert-note'		=> 'mts_alert_note',
			'alert-announce'	=> 'mts_alert_announce',
			'alert-success'		=> 'mts_alert_success',
			'alert-warning'		=> 'mts_alert_warning',
			'one_third'			=> 'mts_one_third',
			'one_third_last'	=> 'mts_one_third_last',
			'two_third'			=> 'mts_two_third',
			'two_third_last'	=> 'mts_two_third_last',
			'one_half'			=> 'mts_one_half',
			'one_half_last'		=> 'mts_one_half_last',
			'one_fourth'		=> 'mts_one_fourth',
			'one_fourth_last'	=> 'mts_one_fourth_last',
			'three_fourth'		=> 'mts_three_fourth',
			'three_fourth_last'	=> 'mts_three_fourth_last',
			'one_fifth'			=> 'mts_one_fifth',
			'one_fifth_last'	=> 'mts_one_fifth_last',
			'two_fifth'			=> 'mts_two_fifth',
			'two_fifth_last'	=> 'mts_two_fifth_last',
			'three_fifth'		=> 'mts_three_fifth',
			'three_fifth_last'	=> 'mts_three_fifth_last',
			'four_fifth'		=> 'mts_four_fifth',
			'four_fifth_last'	=> 'mts_four_fifth_last',
			'one_sixth'			=> 'mts_one_sixth',
			'one_sixth_last'	=> 'mts_one_sixth_last',
			'five_sixth'		=> 'mts_five_sixth',
			'five_sixth_last'	=> 'mts_five_sixth_last',
			'youtube'			=> 'mts_youtube_video',
			'vimeo'				=> 'mts_vimeo_video',
			'googlemap'			=> 'mts_googleMaps',
			'tabs'				=> 'mts_tabs',
			'toggle'			=> 'mts_toggle',
			'clear'				=> 'mts_clear',
			'tooltip'			=> 'mts_tooltip',
			'divider'			=> 'mts_divider',
			'divider_top'		=> 'mts_divider_top',
		);
		foreach($old_shortcodes as $shortcode_key => $old_shortcode) {
			add_shortcode($shortcode_key, array( 'WP_Shortcodes', $old_shortcode ));
		}

		//SU COMPATIBLE
		add_shortcode( $prefix . 'private', array( 'WP_Shortcodes', 'private_note' ) );
		add_shortcode( $prefix . 'gmap', array( 'WP_Shortcodes', 'google_map' ) );
		add_shortcode( $prefix . 'list', array( 'WP_Shortcodes', 'lists' ) );
		add_shortcode( $prefix . 'divider', array( 'WP_Shortcodes', 'separator' ) );
		add_shortcode( $prefix . 'label', array( 'WP_Shortcodes', 'alert' ) );
		add_shortcode( $prefix . 'spoiler', array( 'WP_Shortcodes', 'accordion_item' ) );

	}

	function the_content( $content ) {
			global $post;
			$custom_toc_position = strpos($content, '<!--WPS_TOC-->');
			if($custom_toc_position !== false ) {
				$items = $css_classes = $anchor = '';
				$find = $replace = array();
				$this->default_toc_options = WP_Shortcodes::$default_toc_options;

				if ( $this->is_eligible($custom_toc_position) ) {

					$items = $this->extract_headings($find, $replace, $content);

					if ( $items ) {

							// bullets?
							if ( $this->default_toc_options['bullet_spacing'] == 'yes' )
								$css_classes .= ' have_bullets';
							else
								$css_classes .= ' no_bullets';

							if ( $this->default_toc_options['class'] ) $css_classes .= ' ' . $this->default_toc_options['class'];

							$css_classes = trim($css_classes);

							// an empty class="" is invalid markup!
							if ( !$css_classes ) $css_classes = ' ';
							$style = $this->default_toc_options['style'];
							// add container, toc title and list items
							$html = '<div id="wps-toc-wrapper" class="wps-shortcode-wrapper wps_toc wps-toc wps-style-'.$style.' '. $css_classes . '">';
							$html .= '<div class="wps-inner-wrapper">';
							if ( $this->default_toc_options['title'] ) {
								$html .= '<h2 class="wps-toc-title">' . esc_html($this->default_toc_options['title']) . '</h2>';
							}
							if($style == 'floating' || $style == 'sticky') {
								$html .= '<a href="#" class="wps-toc-close"><i class="fa fa-times" aria-hidden="true"></i></a>';
							}

							$html .= '<ul class="wps-toc-list">' . $items . '</ul></div>';

							$html .= '<a class="toc-collapsible-button" href="#" title="'.__('Click To Maximize The Table Of Contents', 'wp-shortcode-pro').'">'.apply_filters('wps_toc_collapsible_button', '<i class="fa fa-bars" aria-hidden="true"></i>').'</a>';
							$html .= '</div>';
							if ( $custom_toc_position !== false ) {
								$find[] = '<!--WPS_TOC-->';
								$replace[] = $html;
								$content = self::mb_find_replace($find, $replace, $content);
							} else {
								if ( count($find) > 0 ) {
									switch ( $this->default_toc_options['position'] ) {
										case 'top':
											$content = $html . self::mb_find_replace($find, $replace, $content);
											break;

										case 'bottom':
											$content = self::mb_find_replace($find, $replace, $content) . $html;
											break;

										case 'after_first_heading':
											$replace[0] = $replace[0] . $html;
											$content = self::mb_find_replace($find, $replace, $content);
											break;

										case 'before_first_heading':
										default:
											$replace[0] = $html . $replace[0];
											$content = self::mb_find_replace($find, $replace, $content);
									}
								}
							}
					}
				} else {
					// remove <!--WPS_TOC--> (inserted from shortcode) from content
					$content = str_replace('<!--WPS_TOC-->', '', $content);
				}
			}

			return $content;
		}

		/**
		 * Returns true if the table of contents is eligible to be printed, false otherwise.
		 */
		public function is_eligible( $shortcode_used = false ) {
			global $post;
			// do not trigger the TOC when displaying an XML/RSS feed
			if ( is_feed() ) return false;

			// if the shortcode was used, this bypasses many of the global options
			if ( $shortcode_used !== false ) {
					return true;
			} else {
				if ( !is_search() && !is_archive() && !is_front_page() ) {
					return true;
				} else return false;
			}
		}

		/**
		 * This function extracts headings from the html formatted $content.  It will pull out
		 * only the required headings as specified in the options.  For all qualifying headings,
		 * this function populates the $find and $replace arrays (both passed by reference)
		 * with what to search and replace with.
		 * 
		 * Returns a html formatted string of list items for each qualifying heading.  This 
		 * is everything between and NOT including <ul> and </ul>
		 */
		public function extract_headings( &$find, &$replace, $content = '' ) {
			$matches = array();
			$anchor = '';
			$items = false;
			
			if ( is_array($find) && is_array($replace) && $content ) {
				// get all headings
				// the html spec allows for a maximum of 6 heading depths
				if ( preg_match_all('/(<h([1-6]{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER) ) {
					// remove undesired headings (if any) as defined by heading_levels

					if ( is_array($this->default_toc_options['heading_levels']) && count($this->default_toc_options['heading_levels']) != 6 ) {
						$new_matches = array();
	
						for ($i = 0; $i < count($matches); $i++) {
							if ( in_array($matches[$i][2], $this->default_toc_options['heading_levels']) )
								$new_matches[] = $matches[$i];
						}
						$matches = $new_matches;
					}
					
					// remove specific headings if provided via the 'exclude' property
					if ( $this->default_toc_options['exclude'] ) {
						$excluded_headings = explode('|', $this->default_toc_options['exclude']);
						if ( count($excluded_headings) > 0 ) {
							for ($j = 0; $j < count($excluded_headings); $j++) {
								// escape some regular expression characters
								// others: http://www.php.net/manual/en/regexp.reference.meta.php
								$excluded_headings[$j] = str_replace(
									array('*'), 
									array('.*'), 
									trim($excluded_headings[$j])
								);
							}
	
							$new_matches = array();
							for ($i = 0; $i < count($matches); $i++) {
								$found = false;
								for ($j = 0; $j < count($excluded_headings); $j++) {
									if ( @preg_match('/^' . $excluded_headings[$j] . '$/imU', strip_tags($matches[$i][0])) ) {
										$found = true;
										break;
									}
								}
								if (!$found) $new_matches[] = $matches[$i];
							}
							if ( count($matches) != count($new_matches) )
								$matches = $new_matches;
						}
					}
					// remove empty headings
					$new_matches = array();
					for ($i = 0; $i < count($matches); $i++) {
						if ( trim( strip_tags($matches[$i][0]) ) != false )
							$new_matches[] = $matches[$i];
					}
					if ( count($matches) != count($new_matches) )
						$matches = $new_matches;


						for ($i = 0; $i < count($matches); $i++) {
							// get anchor and add to find and replace arrays
							$anchor = $this->url_anchor_target( $matches[$i][0] );
							$find[] = $matches[$i][0];
							$replace[] = str_replace(
								array(
									$matches[$i][1],				// start of heading
									'</h' . $matches[$i][2] . '>'	// end of heading
								),
								array(
									$matches[$i][1] . '<span id="' . $anchor . '">',
									'</span></h' . $matches[$i][2] . '>'
								),
								$matches[$i][0]
							);

							// assemble flat list
							if ( $this->default_toc_options['show_heirarchy'] == 'no' ) {
								$items .= '<li><a href="#' . $anchor . '">';
								if ( $this->default_toc_options['ordered_list'] == 'yes' ) $items .= count($replace) . ' ';
								$items .= strip_tags($matches[$i][0]) . '</a></li>';
							}
						}

						// build a hierarchical toc?
						// we could have tested for $items but that var can be quite large in some cases
						if ( $this->default_toc_options['show_heirarchy'] == 'yes' )
							$items = $this->build_hierarchy( $matches );
				}
			}

			return $items;
		}

		public function build_hierarchy( &$matches ) {
			$current_depth = 100;	// headings can't be larger than h6 but 100 as a default to be sure
			$html = '';
			$numbered_items = array();
			$numbered_items_min = null;

			// find the minimum heading to establish our baseline
			for ($i = 0; $i < count($matches); $i++) {
				if ( $current_depth > $matches[$i][2] )
					$current_depth = (int)$matches[$i][2];
			}

			$numbered_items[$current_depth] = 0;
			$numbered_items_min = $current_depth;

			for ($i = 0; $i < count($matches); $i++) {

				if ( $current_depth == (int)$matches[$i][2] )
					$html .= '<li>';
			
				// start lists
				if ( $current_depth != (int)$matches[$i][2] ) {
					for ($current_depth; $current_depth < (int)$matches[$i][2]; $current_depth++) {
						$numbered_items[$current_depth + 1] = 0;
						$html .= '<ul><li>';
					}
				}

				// list item
				if ( in_array($matches[$i][2], $this->default_toc_options['heading_levels']) ) {
					$html .= '<a href="#' . $this->url_anchor_target( $matches[$i][0] ) . '">';

					if ( $this->default_toc_options['ordered_list'] == 'yes' && $this->default_toc_options['style'] !== 'sticky' ) {
						// attach leading numbers when lower in hierarchy
						$html .= '<span class="toc_number toc_depth_' . ($current_depth - $numbered_items_min + 1) . '">';
						for ($j = $numbered_items_min; $j < $current_depth; $j++) {
							$number = ($numbered_items[$j]) ? $numbered_items[$j] : 0;
							$html .= $number . '.';
						}
						
						$html .= ($numbered_items[$current_depth] + 1) . '</span> ';
						$numbered_items[$current_depth]++;
					}
					$html .= strip_tags($matches[$i][0]) . '</a>';
				}
				// end lists
				if ( $i != count($matches) - 1 ) {
					if ( $current_depth > (int)$matches[$i + 1][2] ) {
						for ($current_depth; $current_depth > (int)$matches[$i + 1][2]; $current_depth--) {
							$html .= '</li></ul>';
							$numbered_items[$current_depth] = 0;
						}
					}

					if ( $current_depth == (int)@$matches[$i + 1][2] )
						$html .= '</li>';
				} else {
					// this is the last item, make sure we close off all tags
					for ($current_depth; $current_depth >= $numbered_items_min; $current_depth--) {
						$html .= '</li>';
						if ( $current_depth != $numbered_items_min ) $html .= '</ul>';
					}
				}
			}
			return $html;
		}

		/**
		 * Returns a clean url to be used as the destination anchor target
		 */
		public function url_anchor_target( $title ) {
			$return = false;
			if ( $title ) {
				$return = trim( strip_tags($title) );
				// convert accented characters to ASCII 
				$return = remove_accents( $return );
				// replace newlines with spaces (eg when headings are split over multiple lines)
				$return = str_replace( array("\r", "\n", "\n\r", "\r\n"), ' ', $return );
				// remove &amp;
				$return = str_replace( '&amp;', '', $return );
				// remove non alphanumeric chars
				$return = preg_replace( '/[^a-zA-Z0-9 \-_]*/', '', $return );
				// convert spaces to _
				$return = str_replace( array('  ', ' '), '_', $return );
				
				// remove trailing - and _
				$return = rtrim( $return, '-_' );

				// if blank, then prepend with the fragment prefix
				// blank anchors normally appear on sites that don't use the latin charset
				if ( !$return ) {
					// $return = ( $this->options['fragment_prefix'] ) ? $this->options['fragment_prefix'] : '_';
				}
			}
			return apply_filters( 'toc_url_anchor_target', $return );
		}

		/**
	 * Returns a string with all items from the $find array replaced with their matching
	 * items in the $replace array.  This does a one to one replacement (rather than
	 * globally).
	 *
	 * This function is multibyte safe.
	 *
	 * $find and $replace are arrays, $string is the haystack.  All variables are
	 * passed by reference.
	 */
	private function mb_find_replace( &$find = false, &$replace = false, &$string = '' ) {
		if ( is_array($find) && is_array($replace) && $string ) {
			// check if multibyte strings are supported
			if ( function_exists( 'mb_strpos' ) ) {
				for ($i = 0; $i < count($find); $i++) {
					$string = 
						mb_substr( $string, 0, mb_strpos($string, $find[$i]) ) .	// everything befor $find
						$replace[$i] .												// its replacement
						mb_substr( $string, mb_strpos($string, $find[$i]) + mb_strlen($find[$i]) )	// everything after $find
					;
				}
			} else {
				for ($i = 0; $i < count($find); $i++) {
					$string = substr_replace(
						$string,
						$replace[$i],
						strpos($string, $find[$i]),
						strlen($find[$i])
					);
				}
			}
		}

		return $string;
	}

}
new WPS_Load;