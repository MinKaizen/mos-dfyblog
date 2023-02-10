<?php
/**
 * Class for managing plugin scripts
 */
class WPS_Scripts extends WP_Shortcode_Base {

	static $assets = array( 'css' => array(), 'js' => array() );

	function __construct() {
		// Register
		$this->add_action( 'wp_enqueue_scripts', 'register' );
		$this->add_action( 'admin_enqueue_scripts', 'register' );
		$this->add_action( 'wps_before_preview', 'register' );
		// Enqueue
		$this->add_action( 'wp_footer', 'enqueue' );
		$this->add_action( 'admin_footer', 'enqueue' );
		// Preview
		$this->add_action( 'wps_after_preview', 'preview_scripts' );
		// Custom CSS
		$this->add_action( 'wp_footer', 'custom_css', 99 );
		$this->add_action( 'wps_after_preview', 'custom_css', 99 );
	}

	/**
	 * Register assets
	 */
	public static function register() {

		//Styles
		$styles = array(
			'wp-shortcode-qtip' => 'css/tipsy.css',
			'wps-lightslider' => 'css/lightslider.css',
			'wps-modal'	=> 'css/wps-modal.css',
			'wps-magnific-popup' => 'css/wps-maginfic_popup.css',
			'wps-fontawesome' => 'css/font-awesome.min.css',
			'wps-owl-carousel' => 'css/owl.carousel.min.css',
			'wps-compare-image' => 'css/twentytwenty.css',
			'wp-shortcode-pro' => 'css/wp-shortcode.css',
			'wps-backward-compatible' => 'css/wp-shortcode-backward-compatible.css'
		);

		// Scripts
		$scripts = array(
			'wps-magnific-popup' => 'js/magnific-popup.js',
			'wp-shortcode-qtip' => 'js/tipsy.js',
			'wps-lightslider' => 'js/lightslider.js',
			'wps-countup' => 'js/countup.min.js',
			'wps-countdown' => 'js/countdown.min.js',
			'wps-progress-bar' => 'js/progress-bar.min.js',
			'wps-modal' => 'js/wp-shortcode-modal.js',
			'wps-owl-carousel' => 'js/owl.carousel.min.js',
			'wps-exit-popup' => 'js/stick-to-me.js',
			'wps-compare-image' => 'js/jquery.twentytwenty.js',
			'wps-google-chart' => 'https://www.gstatic.com/charts/loader.js',
			'wps-gm-lib' => 'http://maps.googleapis.com/maps/api/js?libraries=places&key='.wps_gm_key(),
			'wps-geocomplete' => 'js/jquery.geocomplete.min.js',
			'wps-google-map' => 'js/wps-google-map.js',
			'wps-clipboard' => 'js/clipboard.min.js',
			'wps-highlight' => 'js/highlight.min.js',
			'wp-shortcode-pro' => 'js/wp-shortcode.js',
			'wps-backward-compatible' => 'js/wp-shortcode-old.js'
		);

		$style_func = 'wp_register_style';
		$script_func = 'wp_register_script';

		if(function_exists('vc_enabled_frontend') && vc_enabled_frontend()) {
			$style_func = 'wp_enqueue_style';
			$script_func = 'wp_enqueue_script';
		}

		foreach($styles as $handle => $style) {
			$style_func($handle, wp_shortcode()->assets() . $style);
		}

		$ignore_assets_path = array('wps-google-chart', 'wps-gm-lib');
		foreach($scripts as $handle => $script) {
			if(!in_array($handle, $ignore_assets_path)) {
				$script = wp_shortcode()->assets() . $script;
			}
			$script_func($handle, $script, null, null, true);
		}

		// Hook to deregister assets or add custom
		do_action( 'wps_register_assets' );
	}

	/**
	 * Enqueue assets
	 */
	public static function enqueue() {

		$assets = self::assets();

		foreach ( $assets['css'] as $style ) {
			wp_enqueue_style( $style );
		}
		foreach ( $assets['js'] as $script ) {
			wp_enqueue_script( $script );
		}

		do_action( 'wps_enqueue_assets', $assets );
	}

	/**
	 * Print assets without enqueuing
	 */
	public static function preview_scripts() {
		$assets = self::assets();
		wp_print_styles( $assets['css'] );
		wp_print_scripts( $assets['js'] );
		do_action( 'wps_print_assets', $assets );
	}

	/**
	 * Print custom CSS
	 */
	public static function custom_css() {

		$wps_options = get_option('wp-shortcode-options-general');
		if( ! isset($wps_options['wps_css_code']) || empty($wps_options['wps_css_code']) ) return;

		$custom_css = apply_filters( 'wps_custom_css', $wps_options['wps_css_code'] );

		if ( empty( $custom_css ) ) return;

		do_action( 'wps_before_custom_css' );
		echo '<style>';
		echo strip_tags( $custom_css );
		echo '</style>';
		do_action( 'wps_after_custom_css' );

	}

	/**
	 * Add asset to the query
	 */
	public static function add( $type, $handle ) {

		if ( is_array( $handle ) ) {
			foreach ( $handle as $h ) {
				self::$assets[$type][$h] = $h;
			}
		} else {
			self::$assets[$type][$handle] = $handle;
		}
	}

	/**
	 * Get queried assets
	 */
	public static function assets() {
		$assets = self::$assets;
		$assets['css'] = array_unique( ( array ) apply_filters( 'wps_default_css', ( array ) array_unique( $assets['css'] ) ) );
		$assets['js'] = array_unique( ( array ) apply_filters( 'wps_default_js', ( array ) array_unique( $assets['js'] ) ) );
		return $assets;
	}
}

new WPS_Scripts;

/**
 * Function to add scripts by shortcode
 *
 * @param string  $type   Asset type (css|js)
 * @param mixed   $handle Asset handle
 */
function wps_sortcode_script( $type, $handle ) {
	WPS_Scripts::add( $type, $handle );
}