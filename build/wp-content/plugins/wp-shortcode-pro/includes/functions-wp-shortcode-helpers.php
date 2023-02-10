<?php
/**
 * Helper Functions.
 *
 * This file contains functions which are needed during the plugin's activation.
 *
 * @since      1.0
 * @package    WP_Shortcode
 * @wsbpackage WP_Shortcode/includes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Check if the string begins with the given value
 *
 * @param  string	$needle   The wsb-string to search for
 * @param  string	$haystack The string to search
 *
 * @return bool
 */
function wp_shortcode_str_start_with( $needle, $haystack ) {
	return substr_compare( $haystack, $needle, 0, strlen( $needle ) ) === 0;
}

/**
 * Shortcode additional class
 */
function wps_specific_class( $atts ) {
	return ( $atts['class'] ) ? ' ' . trim( $atts['class'] ) : '';
}

/**
 * Get admin url
 */
function wps_get_admin_url( $page = '', $args = array() ) {

	$base = admin_url( 'admin.php' );
	$page = $page ? 'wp-shortcode-' . $page : 'wp-shortcode-pro';
	$args = wp_parse_args( $args, array( 'page' => $page ) );

	return add_query_arg( $args, $base );
}

/**
 * Shortcode prefix
 */
function wps_prefix() {
	$shortcode_options = get_option('wp-shortcode-options-general');
	$prefix = isset($shortcode_options['wps_prefix']) ? $shortcode_options['wps_prefix'] : '';
	return $prefix;
}

/**
 * Google Map Key
 */
function wps_gm_key() {
	$shortcode_options = get_option('wp-shortcode-options-general');
	$key = isset($shortcode_options['gm_api_key']) ? $shortcode_options['gm_api_key'] : '';
	return $key;
}

/**
 *  Resize image
 */
function wps_resize_image( $url, $width = '', $height = '', $crop = true, $retina = false ) {
	global $wpdb;
	if ( empty( $url ) )
		return new WP_Error( 'no_image_url', 'Image URL is empty.', $url );

	$width = ( $width ) ? $width : get_option( 'thumbnail_size_w' );
	$height = ( $height ) ? $height : get_option( 'thumbnail_size_h' );

	$retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

	$file_path = parse_url( $url );
	$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

	// Additional handling for multisite
	if ( is_multisite() ) {
		global $blog_id;
		$blog_details = get_blog_details( $blog_id );
		$file_path = str_replace( $blog_details->path . 'files/', '/wp-content/blogs.dir/' . $blog_id . '/files/', $file_path );
	}

	$dest_width = $width * $retina;
	$dest_height = $height * $retina;

	$suffix = "{$dest_width}x{$dest_height}";

	$info = pathinfo( $file_path );
	$dir = $info['dirname'];
	$ext = $info['extension'];
	$name = wp_basename( $file_path, ".$ext" );

	$suffix = "{$dest_width}x{$dest_height}";

	$dest_file_name = "{$dir}/{$name}-{$suffix}.{$ext}";
	if ( !file_exists( $dest_file_name ) ) {
		$query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
		$get_attachment = $wpdb->get_results( $query );
		if ( !$get_attachment )
			return array( 'url' => $url, 'width' => $width, 'height' => $height );

		$editor = wp_get_image_editor( $file_path );
		if ( is_wp_error( $editor ) )
			return array( 'url' => $url, 'width' => $width, 'height' => $height );

		$size = $editor->get_size();
		$orig_width = $size['width'];
		$orig_height = $size['height'];
		$src_x = $src_y = 0;
		$src_w = $orig_width;
		$src_h = $orig_height;
		if ( $crop ) {

			$cmp_x = $orig_width / $dest_width;
			$cmp_y = $orig_height / $dest_height;

			if ( $cmp_x > $cmp_y ) {
				$src_w = round( $orig_width / $cmp_x * $cmp_y );
				$src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
			}
			else if ( $cmp_y > $cmp_x ) {
					$src_h = round( $orig_height / $cmp_y * $cmp_x );
					$src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
				}
		}

		$editor->crop( $src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height );
		$saved = $editor->save( $dest_file_name );
		// Get resized image information
		$resized_url = str_replace( basename( $url ), basename( $saved['path'] ), $url );
		$resized_width = $saved['width'];
		$resized_height = $saved['height'];
		$resized_type = $saved['mime-type'];
		$metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
		if ( isset( $metadata['image_meta'] ) ) {
			$metadata['image_meta']['resized_images'][] = $resized_width . 'x' . $resized_height;
			wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
		}
		$image_array = array(
			'url' => $resized_url,
			'width' => $resized_width,
			'height' => $resized_height,
			'type' => $resized_type
		);
	} else {
		$image_array = array(
			'url' => str_replace( basename( $url ), basename( $dest_file_name ), $url ),
			'width' => $dest_width,
			'height' => $dest_height,
			'type' => $ext
		);
	}
	return $image_array;
}

/**
 * Function to shift a hex value by a specific amount factor
 */
function wps_hex_shift($hex, $method = 'lighter', $precent = 50) {
	$steps = ( $precent * 255 ) / 100;
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(-255, min(255, $steps));

	if($method == 'darker') {
		$steps = '-'.$steps;
	}
	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return = '#';

	foreach ($color_parts as $color) {
		$color = hexdec($color); // Convert to decimal
		$color = max(0,min(255,$color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}
/**
 *  Function to convert hex to rgb
 */
function wps_hex2rgb( $color, $delimiter = '-' ) {
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	$color = str_replace("#", "", $color);
	if ( strlen( $color ) == 6 ) {
		$r = hexdec(substr($color,0,2));
		$g = hexdec(substr($color,2,2));
		$b = hexdec(substr($color,4,2));
	} elseif ( strlen( $color ) == 3 ) {
		$r = hexdec(substr($color,0,1).substr($color,0,1));
		$g = hexdec(substr($color,1,1).substr($color,1,1));
		$b = hexdec(substr($color,2,1).substr($color,2,1));
	} else {
		return false;
	}
	return implode( $delimiter, array( $r, $g, $b ) );
}

/**
 * Function to map shortcode
 */
if( ! function_exists('wps_map') ) {
	function wps_map($new = array()) {
		WPS_Map::map( $new );
	}
}

/**
 * Font-Awesome icons
 */
function wps_icons() {
	$icons = apply_filters( 'wps_icons', array( 'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance', 'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk', 'automobile', 'backward', 'ban', 'bank', 'bar-chart-o', 'barcode', 'bars', 'beer', 'behance', 'behance-square', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bold', 'bolt', 'bomb', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc', 'bug', 'building', 'building-o', 'bullhorn', 'bullseye', 'cab', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'car', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'child', 'circle', 'circle-o', 'circle-o-notch', 'circle-thin', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'cny', 'code', 'code-fork', 'codepen', 'coffee', 'cog', 'cogs', 'columns', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy', 'credit-card', 'crop', 'crosshairs', 'css3', 'cube', 'cubes', 'cut', 'cutlery', 'dashboard', 'database', 'dedent', 'delicious', 'desktop', 'deviantart', 'digg', 'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'drupal', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'empire', 'envelope', 'envelope-o', 'envelope-square', 'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'fax', 'female', 'fighter-jet', 'file', 'file-archive-o', 'file-audio-o', 'file-code-o', 'file-excel-o', 'file-image-o', 'file-movie-o', 'file-o', 'file-pdf-o', 'file-photo-o', 'file-picture-o', 'file-powerpoint-o', 'file-sound-o', 'file-text', 'file-text-o', 'file-video-o', 'file-word-o', 'file-zip-o', 'files-o', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr', 'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward', 'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'ge', 'gear', 'gears', 'gift', 'git', 'git-square', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe', 'google', 'google-plus', 'google-plus-square', 'graduation-cap', 'group', 'h-square', 'hacker-news', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'header', 'headphones', 'heart', 'heart-o', 'history', 'home', 'hospital-o', 'html5', 'image', 'inbox', 'indent', 'info', 'info-circle', 'inr', 'instagram', 'institution', 'italic', 'joomla', 'jpy', 'jsfiddle', 'key', 'keyboard-o', 'krw', 'language', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'life-bouy', 'life-ring', 'life-saver', 'lightbulb-o', 'link', 'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn', 'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'mortar-board', 'music', 'navicon', 'openid', 'outdent', 'pagelines', 'paper-plane', 'paper-plane-o', 'paperclip', 'paragraph', 'paste', 'pause', 'paw', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'photo', 'picture-o', 'pied-piper', 'pied-piper-alt', 'pied-piper-square', 'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qq', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'ra', 'random', 'rebel', 'recycle', 'reddit', 'reddit-square', 'refresh', 'renren', 'reorder', 'repeat', 'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right', 'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search', 'search-minus', 'search-plus', 'send', 'send-o', 'share', 'share-alt', 'share-alt-square', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'skype', 'slack', 'sliders', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'soundcloud', 'space-shuttle', 'spinner', 'spoon', 'spotify', 'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'steam', 'steam-square', 'step-backward', 'step-forward', 'stethoscope', 'stop', 'strikethrough', 'stumbleupon', 'stumbleupon-circle', 'subscript', 'suitcase', 'sun-o', 'superscript', 'support', 'table', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'taxi', 'tencent-weibo', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'tree', 'trello', 'trophy', 'truck', 'try', 'tumblr', 'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo', 'university', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md', 'users', 'video-camera', 'vimeo-square', 'vine', 'vk', 'volume-down', 'volume-off', 'volume-up', 'warning', 'wechat', 'weibo', 'weixin', 'wheelchair', 'windows', 'won', 'wordpress', 'wrench', 'xing', 'xing-square', 'yahoo', 'yen', 'youtube', 'youtube-play', 'youtube-square' ) );
	return $icons;
}