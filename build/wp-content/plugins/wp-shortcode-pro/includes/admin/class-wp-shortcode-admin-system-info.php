<?php
/**
 * The class responsible for generating system info.
 *
 * @since      1.0
 * @package    WP_SHORTCODE
 * @subpackage WP_SHORTCODE/admin
 * @author     MyThemeShop <admin@mythemeshop.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Shortcode_Admin_System_Info extends WP_Shortcode_Base {

	/**
	 * Hold system info.
	 * @var array
	 */
	private $data = array();

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->gather_data();
	}

	/**
	 * Display system info in tables.
	 * @return void
	 */
	public function display_content() {
	?>
		<p>
			If you are facing any issue with the plugin, please check the below tutorial first before opening a support ticket:<br />
			<a href="https://community.mythemeshop.com/tutorials/article/52-confirming-a-plugin-conflict/" target="_blank">https://community.mythemeshop.com/tutorials/article/52-confirming-a-plugin-conflict/</a>
		</p>
		<p>
			The above tutorial should help you know if any of your other plugins is causing an issue with WP Shortcode Pro’s working.
		</p>
		<p>
			In case you are still facing any issues, <a href="https://community.mythemeshop.com/forum/12-plugin-support/?do=add" target="_blank">open a support ticket here</a>. Please copy and paste the following information in your ticket when contacting support: 
		</p>

		<textarea class="large-text" id="wps-debug-data-field" rows="16" readonly="readonly"><?php echo esc_textarea( $this->textarea_content() ); ?></textarea>

		<div class="wps-help-buttons">
			<button type="button" class="button wps-support-copy">
				<?php esc_html_e( 'Copy Data for Support Request', 'wp-shortcode-pro' ); ?>
			</button>
			<a href="https://community.mythemeshop.com/forum/12-plugin-support/?do=add" target="_blank" class="button button-primary wps-support-link">
				<?php esc_html_e( 'Open Support Forum', 'wp-shortcode-pro' ); ?>
			</a>
		</div>
	<?php
	}

	/**
	 * Print system info in textarea.
	 * @return void
	 */
	private function textarea_content() {
		foreach ( $this->get_sections() as $id => $label ) :
			$data = $this->data[ $id ];
			echo "\n### " . $label . " ###\n\n";
			foreach ( $data as $item ) {
				echo $item['title'] . ': ' . $item['value'] . "\n";
			}
		endforeach;
	}

	/**
	 * Get Sections
	 * @return array
	 */
	private function get_sections() {
		return array(
			'wordpress'	=> esc_html__( 'WordPress Enviornment', 'wp-shortcode-pro' ),
			'server'	=> esc_html__( 'Server Enviornment', 'wp-shortcode-pro' ),
			'theme'	=> esc_html__( 'Theme Information', 'wp-shortcode-pro' ),
			'plugins'	=> esc_html__( 'Installed Plugins', 'wp-shortcode-pro' ),
		);
	}

	/**
	 * Gather system data according to sections.
	 * @return void
	 */
	private function gather_data() {
		foreach ( $this->get_sections() as $id => $label ) {
			$method = "get_{$id}_data";
			if ( method_exists( $this, $method ) ) {
				$this->data[ $id ] = $this->$method();
			}
		}
	}

	private function get_tooltip( $item ) {

		if ( ! isset( $item['tooltip'] ) ) {
			return;
		}
		?>
		<span class="wp-shortcode-table-tooltip"><em class="dashicons-before dashicons-editor-help"></em><span><?php echo $item['tooltip']; ?></span></span>
		<?php
	}

	/**
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @param string $size The size.
	 * @return int
	 */
	private function let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}

	// Get System Info Functions

	/**
	 * Gather WordPress Data
	 * @return array
	 */
	private function get_wordpress_data() {
		$data = array();

		// Home URL
		$data[] = array(
			'title'	=> esc_html__( 'Home URL', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The URL of your site\'s homepage', 'wp-shortcode-pro' ),
			'value'	=> esc_url( home_url() ),
		);

		// Site URL
		$data[] = array(
			'title'	=> esc_html__( 'Site URL', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The root URL of your site', 'wp-shortcode-pro' ),
			'value'	=> esc_url( site_url() ),
		);

		// WP Version
		$data[] = array(
			'title'	=> esc_html__( 'WP Version', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The version of WordPress installed on your site', 'wp-shortcode-pro' ),
			'value'	=> get_bloginfo( 'version' ),
		);

		// Multisite
		$data[] = array(
			'title'	=> esc_html__( 'WP Multisite', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'Whether or not you have WordPress Multisite enabled', 'wp-shortcode-pro' ),
			'value'	=> is_multisite() ? esc_html__( 'Yes', 'wp-shortcode-pro' ) : esc_html__( 'No', 'wp-shortcode-pro' ),
		);

		// WP Memory Limit
		$data[] = array(
			'title'	=> esc_html__( 'WP Memory Limit', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The maximum amount of memory (RAM) that your site can use at one time', 'wp-shortcode-pro' ),
			'value'	=> size_format( $this->let_to_num( WP_MEMORY_LIMIT ) ),
		);

		// WP Debug
		$data[] = array(
			'title'	=> esc_html__( 'WP Debug Mode', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'Displays whether or not WordPress is in Debug Mode', 'wp-shortcode-pro' ),
			'value'	=> defined( 'WP_DEBUG' ) && WP_DEBUG ? esc_html__( 'Enabled', 'wp-shortcode-pro' ) : esc_html__( 'Disabled', 'wp-shortcode-pro' ),
		);

		// WP Lang
		$data[] = array(
			'title'	=> esc_html__( 'WP Language', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The current language used by WordPress. Default = English', 'wp-shortcode-pro' ),
			'value'	=> get_locale(),
		);

		// WP Uploads Directory
		$wp_up  = wp_upload_dir();
		$data[] = array(
			'title'	=> esc_html__( 'WP Uploads Directory', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'Check the upload directory is writable', 'wp-shortcode-pro' ),
			'value'	=> is_writable( $wp_up['basedir'] ) ? esc_html__( 'Writable', 'wp-shortcode-pro' ) : esc_html__( 'Readable', 'wp-shortcode-pro' ),
		);

		// Memory Usage
		$limit	= absint( ini_get( 'memory_limit' ) );
		$usage	= function_exists( 'memory_get_usage' ) ? round( memory_get_usage() / 1024 / 1024, 2 ) : 0;
		$data[]	= array(
			'title'	=> esc_html__( 'Memory Usage', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'Current system memory usage status', 'wp-shortcode-pro' ),
			/* translators: 1. memory usage, 2. memory limit */
			'value'	=> sprintf( esc_html__( '%1$s MB OF %2$s MB', 'wp-shortcode-pro' ), $usage, $limit ),
		);

		return $data;
	}

	/**
	 * Gather Server Data
	 * @return array
	 */
	private function get_server_data() {
		global $wpdb;

		$data = array();

		// Server Info
		$data[] = array(
			'title'	=> esc_html__( 'Server Info', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'Information about the web server that is currently hosting your site', 'wp-shortcode-pro' ),
			'value'	=> esc_html( $_SERVER['SERVER_SOFTWARE'] ),
		);

		// PHP Version
		$data[] = array(
			'title'	=> esc_html__( 'PHP Version', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The version of PHP installed on your hosting server', 'wp-shortcode-pro' ),
			'value'	=> function_exists( 'phpversion' ) ? esc_html( phpversion() ) : esc_html__( 'Not sure', 'wp-shortcode-pro' ),
		);

		// MYSQL Version
		$data[] = array(
			'title'	=> esc_html__( 'MYSQL Version', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The version of MySQL installed on your hosting server', 'wp-shortcode-pro' ),
			'value'	=> $wpdb->db_version(),
		);

		// PHP Post Max Size
		$data[] = array(
			'title'	=> esc_html__( 'PHP Post Max Size', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The largest file size that can be contained in one post', 'wp-shortcode-pro' ),
			'value'	=> size_format( $this->let_to_num( ini_get( 'post_max_size' ) ) ),
		);

		// PHP Max Execution Time
		$data[] = array(
			'title'	=> esc_html__( 'PHP Max Execution Time', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'wp-shortcode-pro' ),
			'value'	=> ini_get( 'max_execution_time' ),
		);

		// PHP Max Input Vars
		$data[] = array(
			'title'	=> esc_html__( 'PHP Max Input Vars', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads', 'wp-shortcode-pro' ),
			'value'	=> ini_get( 'max_input_vars' ),
		);

		// ZipArchive
		$data[] = array(
			'title'	=> esc_html__( 'ZipArchive', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'ZipArchive is required for importing', 'wp-shortcode-pro' ),
			'value'	=> class_exists( 'ZipArchive' ) ? esc_html__( 'Enabled', 'wp-shortcode-pro' ) : esc_html__( 'Disabled', 'wp-shortcode-pro' ),
		);

		// Max Upload Size
		$data[] = array(
			'title'	=> esc_html__( 'Max Upload Size', 'wp-shortcode-pro' ),
			'tooltip'	=> esc_html__( 'The largest file size that can be uploaded to your WordPress installation', 'wp-shortcode-pro' ),
			'value'	=> size_format( $this->let_to_num( ini_get( 'upload_max_filesize' ) ) ),
		);

		// Default Time Zone
		$time_zone = '';
		if ( date_default_timezone_get() ) {
			$time_zone = date_default_timezone_get();
		}
		if ( ini_get( 'date.timezone' ) ) {
			$time_zone .= ' ' . ini_get( 'date.timezone' );
		}
		$data[] = array(
			'title'	=> esc_html__( 'Default Time Zone', 'wp-shortcode-pro' ),
			'value'	=> $time_zone,
		);

		// cURL
		$data[] = array(
			'title'	=> esc_html__( 'cURL', 'wp-shortcode-pro' ),
			'value'	=> function_exists( 'curl_version' ) ? curl_version()['version'] : esc_html__( 'Not Enabled', 'wp-shortcode-pro' ),
		);

		// SimpleXML
		$data[] = array(
			'title'	=> esc_html__( 'SimpleXML', 'wp-shortcode-pro' ),
			'value'	=> extension_loaded( 'simplexml' ) ? esc_html__( 'All good, extension is installed', 'wp-shortcode-pro' ) : esc_html__( 'Oops! extension not installed, Icon Manager will not work', 'wp-shortcode-pro' ),
		);

		return $data;
	}

	/**
	 * Gather Theme Data
	 * @return array
	 */
	private function get_theme_data() {

		$data	= array();
		$theme = wp_get_theme();

		$data[] = array(
			'title' => esc_html__( 'Name', 'wp-shortcode-pro' ),
			'value' => $theme->name,
		);

		$data[] = array(
			'title' => esc_html__( 'Version', 'wp-shortcode-pro' ),
			'value' => $theme->version,
		);

		$data[] = array(
			'title' => esc_html__( 'Author', 'wp-shortcode-pro' ),
			'value' => '<a href="' . esc_url( $theme->themeuri ) . '">' . $theme->author . '</a>',
		);

		return $data;
	}

	/**
	 * Gather Plugins Data
	 * @return array
	 */
	private function get_plugins_data() {

		$data = array();

		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		foreach ( $active_plugins as $plugin ) {

			$plugin_data    = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$dirname        = dirname( $plugin );
			$version_string = '';
			$network_string = '';

			if ( ! empty( $plugin_data['Name'] ) ) {

				$data[] = array(
					'title' => esc_html( $plugin_data['Name'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string,
					/* translators: author link */
					'value' => sprintf( _x( 'by %s', 'by author', 'wp-shortcode-pro' ), $plugin_data['Author'] ),
				);
			}
		}

		return $data;
	}
}