<?php
/*
Plugin Name: WP Shortcode Pro by MyThemeShop
Plugin URI: https://mythemeshop.com/plugins/wp-shortcode-pro/
Description: With the vast array of shortcodes, you can quickly and easily build content for your posts and pages and turbocharge your blogging experience.
Author: MyThemeShop
Version: 1.1.8
Author URI: http://mythemeshop.com/
Text Domain: wp-shortcode-pro
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Include Base Class.
 * From which all other classes are derived.
 */
include_once dirname( __FILE__ ) . '/includes/class-wp-shortcode-base.php';

final class WP_Shortcode extends WP_Shortcode_Base {

	/**
	 * WP_Shortcode version.
	 * @var string
	 */
	public $version = '1.1.8';

	/**
	 * WP_Shortcode database version.
	 * @return string
	 */
	public $db_version = '1';

	/**
	 * The single instance of the class.
	 * @var WP_Shortcode
	 */
	protected static $_instance = null;

	/**
	 * Possible error message.
	 * @var null|WP_Error
	 */
	protected $error = null;

	/**
	 * Halt plugin loading.
	 * @var boolean
	 */
	private $is_critical = false;

	/**
	 * Minimum version of WordPress required to run the plugin.
	 * @var string
	 */
	public $wordpress_version = '3.8';

	/**
	 * Minimum version of PHP required to run the plugin.
	 * @var string
	 */
	public $php_version = '5.6';

	/**
	 * Plugin url.
	 * @var string
	 */
	private $plugin_url = null;

	/**
	 * Plugin path.
	 * @var string
	 */
	private $plugin_dir = null;

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-shortcode-pro' ), $this->version );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-shortcode-pro' ), $this->version );
	}

	/**
	 * Main WP_Shortcode instance.
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return WP_Shortcode
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) && ! ( self::$_instance instanceof WP_Shortcode ) ) {
			self::$_instance = new WP_Shortcode();
			self::$_instance->setup();
		}

		return self::$_instance;
	}

	/**
	 * WP_Shortcode constructor.
	 */
	private function __construct() {}

	/**
	 * Instantiate the plugin.
	 * @return void
	 */
	private function setup() {

		// Make sure the WordPress version is recent enough
		$this->is_wp_enough();

		// Make sure the PHP version is recent enough
		$this->is_php_enough();

		// If we have any error
		if ( ! is_null( $this->error ) && $this->error instanceof WP_Error ) {
			add_action( 'admin_notices', array( $this, 'display_error' ), 10 );
		}

		// If we have critical issue don't load the plugin
		if ( $this->is_critical ) {
			return;
		}

		$this->autoloader();
		$this->includes();
		$this->hooks();

		// For developers to hook
		wp_shortcode_action( 'loaded' );
	}

	/**
	 * Register file autoloading mechanism.
	 * @return void
	 */
	private function autoloader() {

		if ( function_exists( '__autoload' ) ) {
			spl_autoload_register( '__autoload' );
		}

		spl_autoload_register( array( $this, 'autoload' ) );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 * @return void
	 */
	private function includes() {

		// Core
		include_once $this->includes_dir() . 'functions-wp-shortcode-helpers.php';
		include_once $this->includes_dir() . 'libs/cmb2/init.php';
		include_once $this->includes_dir() . 'class-wp-shortcode-settings.php';

		include_once $this->includes_dir() . 'class-wp-shortcode-tools.php';
		include_once $this->includes_dir() . 'class-wp-shortcode-list.php';
		include_once $this->includes_dir() . 'class-wp-shortcodes.php';
		include_once $this->includes_dir() . 'class-wp-shortcode-register.php';
		include_once $this->includes_dir() . 'class-wp-shortcode-mapper.php';
		include_once $this->includes_dir() . 'class-wp-shortcode-installer.php';

		// Admin Only
		if ( is_admin() ) {
			if ( ! defined( 'FL_BUILDER_VERSION' ) ) {
				include_once $this->includes_dir() . 'admin/class-wp-shortcode-admin.php';
			}
		}
		if ( defined( 'FL_BUILDER_VERSION' ) ) {
			include_once $this->includes_dir() . 'admin/class-wp-shortcode-admin.php';
		}
		include_once $this->plugin_dir() . 'includes/class-wp-shortcode-scripts.php';
	}

	/**
	 * Add hooks to begin.
	 * @return void
	 */
	private function hooks() {

		register_activation_hook( __FILE__, array( 'WPS_Installer', 'install' ) );

		$this->add_action( 'plugins_loaded', 'load_plugin_textdomain' );
		$this->add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'action_links' );

		if ( is_admin() ) {
			if ( true === boolval( get_option( 'wps_redirect_settings', false ) ) ) {
				$this->add_action( 'init', 'redirect_to_settings' );
			}
		}
	}

	public function redirect_to_settings() {
		delete_option( 'wps_redirect_settings' );
		wp_redirect( wps_get_admin_url() );
		exit;
	}

	/**
	 * Autoload Strategy
	 * @param  string $class
	 * @return void
	 */
	public function autoload( $class ) {

		if ( ! wp_shortcode_str_start_with( 'WP_Shortcode_', $class ) ) {
			return;
		}

		$path = $this->plugin_dir() . 'includes/';
		if ( wp_shortcode_str_start_with( 'WP_Shortcode_Admin', $class ) ) {
			$path = $this->admin_dir();
		}

		$class = strtolower( $class );
		$file = 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';

		// Load File
		$load = $path . $file;
		if ( $load && is_readable( $load ) ) {
			include_once $load;
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-shortcode-pro' );
		load_textdomain( 'wp-shortcode-pro', WP_LANG_DIR . '/wp-shortcode-pro/wp-shortcode-' . $locale . '.mo' );
		load_plugin_textdomain( 'wp-shortcode-pro', false, $this->plugin_dir() . '/languages/');
	}

	// Helpers

	/**
	 * Plugin action links.
	 * @param  mixed $links
	 * @return mixed
	 */
	public function action_links( $links ) {

		$plugin_links = array(
			'<a href="' . wps_get_admin_url( 'options-general' ) . '">' . esc_html__( 'Settings', 'wp-shortcode-pro' ) . '</a>',
		);

		return array_merge( $links, $plugin_links );
	}

	/**
	 * Check if WordPress version is enough to run this plugin.
	 * @return boolean
	 */
	public function is_wp_enough() {

		if ( version_compare( get_bloginfo( 'version' ), $this->wordpress_version, '<' ) ) {
			$this->add_error(
				sprintf( esc_html__( 'WP Shortcode Pro requires WordPress version %s or above. Please update WordPress to run this plugin.', 'wp-shortcode-pro' ), $this->wordpress_version )
			);
			$this->is_critical = true;
		}
	}

	/**
	 * Check if PHP version is enough to run this plugin.
	 * @return boolean
	 */
	public function is_php_enough() {

		if ( version_compare( phpversion(), $this->php_version, '<' ) ) {
			$this->add_error(
				sprintf( esc_html__( 'WP Shortcode Pro requires PHP version %s or above. Please update PHP to run this plugin.', 'wp-shortcode-pro' ), $this->php_version )
			);
			$this->is_critical = true;
		}
	}

	/**
	 * Add error.
	 *
	 * Add a new error to the WP_Error object
	 * and create object if it doesn't exists.
	 *
	 * @param string $message
	 * @param string $code
	 */
	public function add_error( $message, $code = 'error' ) {

		if ( is_null( $this->error ) && ! ( $this->error instanceof WP_Error ) ) {
			$this->error = new WP_Error();
		}

		$this->error->add( $code, $message );
	}

	/**
	 * Display error.
	 *
	 * Get all the error messages and display them in the admin notice.
	 * @return void
	 */
	public function display_error() {

		if ( is_null( $this->error ) || ! ( $this->error instanceof WP_Error ) ) {
			return;
		}

		$messages = $this->error->get_error_messages(); ?>

		<div class="error">
			<p>
				<?php
				if ( count( $messages ) > 1 ) {
					echo '<ul>';
					foreach ( $messages as $message ) {
						echo "<li>$message</li>";
					}
					echo '</li>';
				} else {
					echo $messages[0];
				}
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Get plugin directory.
	 * @return string
	 */
	public function plugin_dir() {

		if ( is_null( $this->plugin_dir ) ) {
			$this->plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/';
		}

		return $this->plugin_dir;
	}

	/**
	 * Get plugin uri.
	 * @return string
	 */
	public function plugin_url() {

		if ( is_null( $this->plugin_url ) ) {
			$this->plugin_url = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/';
		}

		return $this->plugin_url;
	}

	/**
	 * Get plugin admin directory.
	 * @return string
	 */
	public function admin_dir() {
		return $this->plugin_dir() . 'includes/admin/';
	}

	/**
	 * Get assets uri.
	 * @return string
	 */
	public function admin_assets() {
		return $this->plugin_url() . 'assets/admin/';
	}

	/**
	 * Get plugin admin uri.
	 * @return string
	 */
	public function admin_url() {
		return $this->plugin_url() . 'includes/admin/';
	}

	/**
	 * Get plugin public directory.
	 * @return string
	 */
	public function public_dir() {
		return $this->plugin_dir() . 'public/';
	}

	/**
	 * Get plugin public uri.
	 * @return string
	 */
	public function public_url() {
		return $this->plugin_url() . 'public/';
	}

	/**
	 * Get plugin includes directory.
	 * @return string
	 */
	public function includes_dir() {
		return $this->plugin_dir() . 'includes/';
	}

	/**
	 * Get assets uri.
	 * @return string
	 */
	public function assets() {
		return $this->plugin_url() . 'assets/front/';
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}
}

/**
 * Main instance of WP_Shortcode.
 *
 * Returns the main instance of WP_Shortcode to prevent the need to use globals.
 *
 * @return WP_Shortcode
 */
function wp_shortcode() {
	return WP_Shortcode::instance();
}

// Init the plugin.
wp_shortcode();
