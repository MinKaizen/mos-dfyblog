<?php
/**
 * Plugin Name: WP Review Pro
 * Plugin URI: https://mythemeshop.com/plugins/wp-review-pro/
 * Description: Create reviews! Choose from Stars, Percentages, Circles, Points or Thumbs for review scores. Supports Retina Display, WPMU and Unlimited Color Schemes.
 * Version: 3.4.11
 * Author: MyThemeShop
 * Author URI: https://mythemeshop.com/
 * Text Domain: wp-review
 * Domain Path: /languages/
 *
 * @since     1.0
 * @copyright Copyright (c) 2013, MyThemesShop
 * @author    MyThemesShop
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @package   WP_Review
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin requires PHP 5.6 or later.
 */
if ( version_compare( phpversion(), '5.6', '<' ) ) {
	/**
	 * Adds a message for outdate PHP version.
	 */
	function wp_review_php_upgrade_notice() {
		// translators: PHP version.
		$message = sprintf( __( '<strong>WP Review Pro</strong> requires PHP version 5.6 or above. You are running version %s. Please update PHP to run this plugin.', 'wp-review' ), phpversion() );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	add_action( 'admin_notices', 'wp_review_php_upgrade_notice' );

	return;
}

/**
 * Make it load WP Review first, as old version doesn't check if it has been loaded before.
 */
function wp_review_plugin_first() {
	$this_plugin     = 'wp-review/wp-review.php';
	$active_plugins  = get_option( 'active_plugins' );
	$this_plugin_key = array_search( $this_plugin, $active_plugins );
	if ( $this_plugin_key ) { // if it's 0 it's the first plugin already, no need to continue.
		array_splice( $active_plugins, $this_plugin_key, 1 );
		array_unshift( $active_plugins, $this_plugin );
		update_option( 'active_plugins', $active_plugins );
	}
}
add_action( 'activated_plugin', 'wp_review_plugin_first' );

// WP Review activated?
if ( defined( 'MTS_WP_REVIEW_DB_TABLE' ) ) {

	/**
	 * Shows deactivate plugin notice.
	 */
	function wp_review_deactivate_plugin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'Please deactivate WP Review FREE plugin first to use the Premium features!', 'wp-review' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'wp_review_deactivate_plugin_notice' );
} else {

	/* Plugin version */
	define( 'WP_REVIEW_PLUGIN_VERSION', '3.4.11' );

	/* Sets the custom db table name. */
	define( 'MTS_WP_REVIEW_DB_TABLE', 'mts_wp_reviews' );

	/* When plugin is activated */
	register_activation_hook( __FILE__, 'wp_review_activation' );

	/* Defines constants used by the plugin. */
	add_action( 'plugins_loaded', 'wp_review_constants', 1 );

	/* Internationalize the text strings used. */
	add_action( 'plugins_loaded', 'wp_review_i18n', 2 );

	/* Loads libraries. */
	add_action( 'plugins_loaded', 'wp_review_includes_libraries', 3 );

	/**
	 * Defines constants.
	 *
	 * @since 1.0
	 */
	function wp_review_constants() {

		/* Sets the path to the plugin directory. */
		define( 'WP_REVIEW_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Sets the path to the plugin directory URI. */
		define( 'WP_REVIEW_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Sets the path to the `admin` directory. */
		define( 'WP_REVIEW_ADMIN', WP_REVIEW_DIR . trailingslashit( 'admin' ) );

		/* Sets the path to the `includes` directory. */
		define( 'WP_REVIEW_INCLUDES', WP_REVIEW_DIR . trailingslashit( 'includes' ) );

		/* Sets the path to the `assets` directory. */
		define( 'WP_REVIEW_ASSETS', WP_REVIEW_URI . 'public/' );

		/* Sets plugin base 'directory/file.php' */
		define( 'WP_REVIEW_PLUGIN_BASE', plugin_basename( __FILE__ ) );

		define( 'WP_REVIEW_COMMENT_TYPE_COMMENT', 'wp_review_comment' );
		define( 'WP_REVIEW_COMMENT_TYPE_VISITOR', 'wp_review_visitor' );

		define( 'WP_REVIEW_VISITOR_RATING_METAKEY', 'wp_review_visitor_rating' );
		define( 'WP_REVIEW_COMMENT_RATING_METAKEY', 'wp_review_comment_rating' );
		define( 'WP_REVIEW_COMMENT_TITLE_METAKEY', 'wp_review_comment_title' );

		define( 'WP_REVIEW_COMMENT_FEATURES_RATING_METAKEY', 'wp_review_features_rating' );

		/* Keys for user review permissions */
		define( 'WP_REVIEW_REVIEW_DISABLED', 0 );
		define( 'WP_REVIEW_REVIEW_VISITOR_ONLY', 2 );
		define( 'WP_REVIEW_REVIEW_COMMENT_ONLY', 3 );
		define( 'WP_REVIEW_REVIEW_ALLOW_BOTH', 4 );

		define( 'WP_REVIEW_GRAPH_API_VERSION', '3.3' );
	}

	/**
	 * Internationalize the text strings used.
	 *
	 * @since 1.0
	 */
	function wp_review_i18n() {
		load_plugin_textdomain( 'wp-review', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 1.0
	 */
	function wp_review_includes_libraries() {

		/* Loads the admin functions. */
		require_once WP_REVIEW_ADMIN . 'admin.php';

		/* Loads the meta boxes. */
		require_once WP_REVIEW_ADMIN . 'metaboxes.php';

		/* Loads the templates list. */
		require_once WP_REVIEW_DIR . 'template-list.php';

		/* Loads the front-end functions. */
		require_once WP_REVIEW_INCLUDES . 'functions.php';
		require_once WP_REVIEW_INCLUDES . 'yelp.php';
		require_once WP_REVIEW_INCLUDES . 'facebook.php';

		/* Loads ajax handles. */
		require_once WP_REVIEW_INCLUDES . 'ajax.php';

		/* Loads the widget. */
		require_once WP_REVIEW_INCLUDES . 'widget.php';

		/* Loads rate with comment functions. */
		require_once WP_REVIEW_INCLUDES . 'comments.php';

		/* Loads the enqueue functions. */
		require_once WP_REVIEW_INCLUDES . 'enqueue.php';

		/* Loads shortcodes */
		require_once WP_REVIEW_INCLUDES . 'shortcodes.php';

		/* Loads the settings page. */
		require_once WP_REVIEW_ADMIN . 'class-wp-review-options.php';

		/* Loads the form field class. */
		require_once WP_REVIEW_ADMIN . 'class-wp-review-form-field.php';

		/* Popup feature */
		require_once WP_REVIEW_INCLUDES . 'popup.php';

		/* Notification bar feature */
		require_once WP_REVIEW_INCLUDES . 'hello-bar.php';

		if ( class_exists( 'WooCommerce' ) && ! in_array( 'product', wp_review_get_excluded_post_types() ) ) {
			/* WooCommerce integrate */
			require_once WP_REVIEW_INCLUDES . 'woocommerce.php';
		}

		/* Loads the importer. */
		require_once WP_REVIEW_ADMIN . 'class-wp-review-importer.php';

		/* Loads the demo importer. */
		require_once WP_REVIEW_ADMIN . 'demo-importer.php';

		/* Loads the schema converter. */
		require_once WP_REVIEW_INCLUDES . 'class-wpr-schema-converter.php';
	}

	/**
	 * Plugin activation.
	 */
	function wp_review_activation() {
		require_once plugin_dir_path( __FILE__ ) . '/admin/activation.php';
	}

	/**
	 * Upgrades plugin.
	 *
	 * @since 3.3.6
	 */
	function wp_review_upgrade() {
		$old_version = get_option( 'wp_review_pro_version' );
		$new_version = WP_REVIEW_PLUGIN_VERSION;

		if ( ! $old_version ) { // v3.3.6.
			$query = new WP_Query(
				array(
					'post_type'   => 'any',
					'post_status' => 'any',
					'meta_key'    => 'wp_review_schema',
					'meta_value'  => 'Recipe',
				)
			);

			foreach ( $query->posts as $post ) {
				$options = get_post_meta( $post->ID, 'wp_review_schema_options', true );
				if ( ! empty( $options['Recipe']['name'] ) ) {
					$options['Recipe']['video_name'] = $options['Recipe']['name'];
				}
				if ( ! empty( $options['Recipe']['description'] ) ) {
					$options['Recipe']['video_description'] = $options['Recipe']['description'];
				}
				update_post_meta( $post->ID, 'wp_review_schema_options', $options );
			}
		}

		$caps = get_role( 'administrator' )->capabilities;
		if ( ! isset( $caps['wp_review_convert_schema'] ) ) {
			delete_option( 'wp_review_compatibility' );
		}

		update_option( 'wp_review_pro_version', $new_version );
	}
	add_action( 'init', 'wp_review_upgrade' );
}
