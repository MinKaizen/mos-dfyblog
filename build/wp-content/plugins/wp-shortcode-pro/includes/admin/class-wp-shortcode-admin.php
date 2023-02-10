<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Shortcode
 * @subpackage WP_Shortcode/admin
 * @author     MyThemeShop <admin@mythemeshop.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Shortcode_Admin extends WP_Shortcode_Base {

	/**
	 * The Constructor
	 */
	public function __construct() {

		$this->includes();
		$this->hooks();

		// For developers to hook
		wp_shortcode_action( 'admin_loaded' );
	}

	/**
	 * Include required files.
	 * @return void
	 */
	private function includes() {
		include_once wp_shortcode()->admin_dir() . 'class-wp-shortcode-fields.php';
		include_once wp_shortcode()->admin_dir() . 'class-wp-shortcode-presets.php';
		include_once wp_shortcode()->admin_dir() . 'class-wp-custom-shortcodes.php';
	}

	/**
	 * Setup hooks.
	 * @return void
	 */
	private function hooks() {

		$this->add_action( 'init', 'init', 1 );
		if (isset($_GET['fl_builder'])) {
			$this->add_action( 'wp_enqueue_scripts', 'enqueue', 99999 );
			$this->add_action( 'wp_footer',  'popup', 1 );
		}
		$this->add_action( 'admin_enqueue_scripts', 'enqueue' );
		$this->add_action( 'admin_footer',  'popup', 1 );
		$this->add_action( 'wp_ajax_wp_shortcode_settings', 'settings' );
		$this->add_action( 'wp_ajax_wps_get_icons', 'get_icons' );
		$this->add_action( 'wp_ajax_wps_get_terms', 'wps_get_terms' );
		$this->add_action( 'wp_ajax_wp_shortcode_get_taxonomies', 'wps_get_taxonomies' );
		$this->add_action( 'wp_ajax_wp_shortcode_preview',  'preview' );

		/*$this->add_action( 'elementor/init',  'popup', 99 );*/
		$this->add_action( 'elementor/editor/before_enqueue_scripts', 'enqueue', 99 );

		$this->add_filter( 'wp_shortcode_general_settings', 'check_updater', 11, 1 );
	}

	/**
	 * Initialize.
	 * @return void
	 */
	public function init() {
		$this->register_pages();
		$this->add_filter("mce_external_plugins",'wp_shortcode_add_buttons', 99999);
		$this->add_filter('mce_buttons', 'wp_shortcode_register_buttons', 99999);
	}

	function wp_shortcode_add_buttons($plugin_array)  {
        $plugin_array['custom-shortcode'] =  wp_shortcode()->admin_assets() . 'js/wp-shortcode-tinymce.js';
		return $plugin_array;
	}

	function wp_shortcode_register_buttons( $buttons ) {
		array_push( $buttons, 'custom-shortcode' );
		return $buttons;
	}

	/**
	 * Enqueue Styles and Scripts required by plugin
	 * @return void
	 */
	public function enqueue( $hook ) {
		$pages = array('wp-shortcode-pro', 'wp-shortcode-options-general', 'wp-shortcode-mapper');
		if($hook === 'post.php' || $hook === 'post-new.php' || ( isset($_GET['page']) && in_array($_GET['page'], $pages) ) || class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
			global $post;

			// Styles
			wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
			wp_enqueue_style( 'jquery-ui' );

			if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
				wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );

				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script(
					'iris',
					admin_url( 'js/iris.min.js' ),
					array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
					false,
					1
				);

				wp_enqueue_script( 'wp-color-picker-new', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );

				$colorpicker_l10n = array(
				'clear' => __( 'Clear' ),
				'defaultString' => __( 'Default' ),
				'pick' => __( 'Select Color' ),
				'current' => __( 'Current Color' ),
				);
				wp_localize_script( 'wp-color-picker-new', 'wpColorPickerL10n', $colorpicker_l10n );
			}

			wp_enqueue_style( 'wps-izimodal', wp_shortcode()->admin_assets() . 'css/iziModal.min.css', null, null );
			wp_enqueue_style( 'wp-shortcode-admin', wp_shortcode()->admin_assets() . 'css/wp-shortcode-admin.css', array( 'wp-color-picker' ), null );
			wps_sortcode_script( 'css', 'wps-fontawesome' );

			// Scripts
			if(wps_gm_key()) {
				wp_enqueue_script('wps-gm-lib', 'https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key='.wps_gm_key());
			}

			wps_sortcode_script( 'js', 'wps-clipboard' );
			wp_enqueue_script( 'wps-izimodal', wp_shortcode()->admin_assets() . 'js/iziModal.min.js', null, null, true );
			wp_enqueue_script( 'wp-shortcode-admin', wp_shortcode()->admin_assets() . 'js/wp-shortcode-admin.js', array( 'jquery-ui-slider', 'wp-color-picker', 'jquery-ui-button', 'jquery-ui-datepicker', 'jquery-ui-accordion' ), null, true );
		}

	}

	/**
	 * Register admin pages for plugin.
	 * @return void
	 */
	private function register_pages() {
		// WP Shortcode Pro Help & Support
		new WP_Shortcode_Admin_Page( 'wp-shortcode-pro', esc_html__( 'WP Shortcode Pro', 'wp-shortcode-pro' ), array(
			'position'	=> 80,
			'icon'		=> 'dashicons-editor-code',
			'render'	=> wp_shortcode()->admin_dir() . 'views/help-manager.php',
		));
	}

	/**
	 * Generator popup form
	 */
	public static function popup() {
		ob_start();
?>
		<button class="wp-shortcode-button" style="display: none;"></button>

		<div id="wp-shortcode-wrap" style="display:none" data-title="<?php _e('Select Shortcode', 'wp-shortcode-pro'); ?>" data-subtitle="<?php _e('Elegant, responsive, flexible and lightweight shortcodes.', 'wp-shortcode-pro'); ?>">
			<div id="wps-selector">
				<div id="wp-shortcode-header">
					<div class="wp-shortcode-description">
						<h3><?php _e('Add New Shortcode', 'wp-shortcode-pro'); ?></h3>
						<span class="sep">|</span>
						<span class="desc"><?php _e('Elegant, responsive, flexible and lightweight shortcodes.', 'wp-shortcode-pro'); ?></span>
					</div>
					<div class="wps-search-actions">
						<div id="wps-search-wrapper">
							<input type="text" name="wp_shortcode_search" id="wps-search" value="" placeholder="<?php _e( 'Search Shortcodes by Name', 'wp-shortcode-pro' ); ?>" autocomplete="off" />
							<button class="wps-search-button"><?php _e( 'Search for the Shortcode in realtime by typing', 'wp-shortcode-pro' ); ?></button>
							<ul class="wps-matched-shortcodes"></ul>
						</div>
						<div id="wps-filter">
							<strong><?php _e( 'Filter by Type', 'wp-shortcode-pro' ); ?></strong>
							<?php foreach ( (array) wp_shortcode()->list->categories() as $key => $category ) {
									$class = ($key == 'all') ? 'active' : '';
									echo '<a href="#" class="'.$class.'" data-filter="' . $key . '">' . $category . '</a>';
								}
							?>
						</div>
					</div>
					<div class="wps-lists-wrapper">
						<div id="wps-lists">
							<?php
								// Shorcode Lists
								foreach ( (array) wp_shortcode()->list->shortcodes() as $name => $shortcode ) {
									if( !empty($shortcode) ) {
										$icon = ( isset( $shortcode['icon'] ) ) ? $shortcode['icon'] : 'puzzle-piece';
										$shortcode['name'] = ( isset( $shortcode['name'] ) ) ? $shortcode['name'] : $name;
										echo '<span data-name="' . $shortcode['name'] . '" data-shortcode="' . $name . '" title="' . esc_attr( $shortcode['desc'] ) . '" data-category="' . $shortcode['category'] . '">'
											. '<i class="fa fa-' . $icon . '"></i>'
											. $shortcode['name'] .
											'</span>' . "\n";
									}
								}
							?>
						</div>
					</div>
				</div>
				<div id="wps-settings"></div>
				<input type="hidden" name="wps-selected" id="wps-selected" value="<?php echo  wp_shortcode()->admin_url(); ?>" />
				<input type="hidden" name="wp-shortcode-url" id="wp-shortcode-url" value="<?php echo  wp_shortcode()->admin_url(); ?>" />
				<input type="hidden" name="wps-prefix" id="wps-prefix" value="<?php echo wps_prefix(); ?>" />
				<div id="wps-output" style="display:none"></div>

			</div>
		</div>
	<?php
		$output = ob_get_contents();
		ob_end_flush();
		echo $output;
	}

	/**
	 * Process AJAX request
	 */
	public static function settings( $shortcode_name = '' ) {

		if( empty($shortcode_name) )
			$shortcode_name = $_REQUEST['shortcode'];

		// Param check
		if ( empty( $shortcode_name ) )
			wp_die( __( 'Shortcode does not exists', 'wp-shortcode-pro' ) );

		$is_child = false;
		if( isset($_REQUEST['is_child']) && $_REQUEST['is_child'] ) {
			$is_child = true;
		}

		$shortcode = wp_shortcode()->list->shortcodes( sanitize_key( $shortcode_name ) );

		$shortcode_actions = array();

		if( $is_child ) {
			$shortcode_actions['back'] = '<a href="javascript:void(0);" class="button button-large wps-back alignleft" data-shortcode="'.$shortcode['parent'].'"><i class="fa fa-chevron-left"></i> ' . __( 'Back', 'wp-shortcode-pro' ) . '</a>';
			$shortcode_actions['add-child'] = '<a href="javascript:void(0);" class="button button-primary button-large wp-shortcode-add-section" data-shortcode="'.$shortcode['parent'].'"><i class="fa fa-check"></i> ' . __( 'Add shortcode', 'wp-shortcode-pro' ) . '</a>';
		} else {
			$shortcode_actions['insert'] = '<a href="javascript:void(0);" class="button button-primary button-large wp-shortcode-insert alignright"><i class="fa fa-check"></i> ' . __( 'Insert shortcode', 'wp-shortcode-pro' ) . '</a>';
		}

		$actions = apply_filters( 'wps_generator_actions', $shortcode_actions);

		$return .= '<div id="wps-breadcrumbs">';
		if( isset($shortcode['parent']) && $shortcode['parent'] != '' && $is_child ) {
			$return .= apply_filters( 'wps_breadcrumbs',
					'<a href="javascript:void(0);" class="wps-main-page" title="' . __( 'Click to return to the shortcodes list', 'wp-shortcode-pro' ) . '">' . __( 'All Shortcodes', 'wp-shortcode-pro' ) . '</a> <span class="wps-separator"><i class="fa fa-angle-right" aria-hidden="true"></i></span>'
					. ' <a href="javascript:void(0);" class="wp-parent-shortcode wp-shortcode-'.$shortcode['parent'].'" title="' . $shortcode['parent'] . '">' .$shortcode['parent'] . '</a> <span class="wps-separator"><i class="fa fa-angle-right" aria-hidden="true"></i></span>'
					. ' <span>' . $shortcode['name'] . '</span><div class="wp-shortcode-clear"></div>' );
		} else {
			$return .= apply_filters( 'wps_breadcrumbs', '<a href="javascript:void(0);" class="wps-main-page" title="' . __( 'Click to return to the shortcodes list', 'wp-shortcode-pro' ) . '">' . __( 'All shortcodes', 'wp-shortcode-pro' ) . '</a> <span class="wps-separator"><i class="fa fa-angle-right" aria-hidden="true"></i></span> <span>' . $shortcode['name'] . '</span><div class="wp-shortcode-clear"></div>' );
		}
		$return .= '</div>';
		$return .= '<div class="wps-main-fields-wrapper">';
		if( isset( $shortcode['notice'] ) && $shortcode['notice'] !== '' ) {
			$return .= '<div class="wps-notice"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
			$return .= '<span>'.$shortcode['notice'].'</span>';
			$return .= '</div>';
		}

		if ( isset( $shortcode['fields'] ) && count( $shortcode['fields'] ) ) {
			foreach ( $shortcode['fields'] as $attr_name => $attr_info ) {

				if($attr_info['id'] !== '') {
					$default = (string) ( isset( $attr_info['default'] ) ) ? $attr_info['default'] : '';
					$attr_info['name'] = ( isset( $attr_info['name'] ) ) ? $attr_info['name'] : $attr_name;
					$attr_info['class'] = ( isset( $attr_info['class'] ) ) ? $attr_info['class'] : '';
					$return .= '<div class="wps-field-wrapper wps-type-'.$attr_info['type']. ' '. esc_attr($attr_info['class']) .'" data-default="' . esc_attr( $default ) . '">';
					$return .= '<h5>' . $attr_info['name'] . '</h5>';

					if ( !isset( $attr_info['type'] ) && isset( $attr_info['values'] ) && is_array( $attr_info['values'] ) && count( $attr_info['values'] ) ){
						$attr_info['type'] = 'select';
					} elseif ( !isset( $attr_info['type'] ) ){
						$attr_info['type'] = 'text';
					}

					if ( is_callable( array( 'WPS_Fields', $attr_info['type'] ) ) ){
						$return .= call_user_func( array( 'WPS_Fields', $attr_info['type'] ), $attr_name, $attr_info );
					} elseif ( isset( $attr_info['callback'] ) && is_callable( $attr_info['callback'] ) ){
						$return .= call_user_func( $attr_info['callback'], $attr_name, $attr_info );
					}

					if ( isset( $attr_info['desc'] ) ){
						$return .= '<div class="wps-field-value-desc">' . str_replace( array( '<b%value>', '<b_>' ), '<b class="wps-set-value" title="' . __( 'Click to set this value', 'wp-shortcode-pro' ) . '">', $attr_info['desc'] ) . '</div>';
					}
					$return .= '</div>';
				}
			}
		}

		if ( $shortcode['type'] == 'single' ) {
			$return .= '<input type="hidden" name="wp-shortcode-content" id="wp-shortcode-content" value="false" />';
		} else {

			if ( !isset( $shortcode['content'] ) ) {
				$shortcode['content'] = '';
				$content_class = '';
			}

			if ( is_array( $shortcode['content'] ) ) {
				$content_class = $shortcode['content']['class'];
				$shortcode['content'] = self::get_shortcode_code( $shortcode['content'] );
			}

			$return .= '<div class="wps-field-wrapper wps-content-field '. esc_attr($content_class) .'"><h5>' . __( 'Content', 'wp-shortcode-pro' ) . '</h5><textarea name="wp-shortcode-content" id="wp-shortcode-content" rows="5">' . esc_attr( str_replace( array( '%prefix_', '__' ), '', $shortcode['content'] ) ) . '</textarea></div>';
		}
		$return .= '</div>';
		if(!isset($shortcode['parent'])) {
			$return .= '<div id="wp-shortcode-preview"></div>';
		}
		$return .= '<div class="wp-shortcode-actions">' . implode( ' ', array_values( $actions ) ) . '</div>';

		if(!$is_child) {
			$return = '<div id="wps-parent-wrapper">'.$return.'</div>';
		}

		if( !empty( $shortcode['child'] ) ) {
			$return .= '<div id="wps-child-wrapper"></div>';
		}

		echo $return;
		exit;
	}

	/**
	 * Process AJAX request and generate preview HTML
	 */
	public static function preview() {
		$non_supported_shortcodes = array('google_trends', 'pie_chart', 'geo_chart', 'bar_chart', 'area_chart', 'combo_chart', 'org_chart', 'bubble_chart', 'splash_screen', 'toc', 'lightbox', 'lightbox_content', 'advanced_google_map');
		$shortcode_key = $_POST['shortcode_key'];
		if(in_array($shortcode_key, $non_supported_shortcodes))	{
			$alert_shortcode = wps_prefix().'alert';
			echo "<strong>".__('This shortcode does not support live preview. Sorry for that.', 'wp-shortcode-pro')."</strong>";
		} else {
			do_action( 'wps_before_preview' );
			echo '<h5>' . __( 'Preview', 'wp-shortcode-pro' ) . '</h5>';
			echo do_shortcode( stripslashes($_POST['shortcode']) );
			echo '<div style="clear:both"></div>';
			do_action( 'wps_after_preview' );
		}
		die();
	}

	public static function get_icons() {
		die( wp_shortcode()->tools->icons() );
	}

	public static function wps_get_terms() {
		$args = array();
		if ( isset( $_REQUEST['tax'] ) ) $args['options'] = (array) wp_shortcode()->tools->get_terms( sanitize_key( $_REQUEST['tax'] ) );
		if ( isset( $_REQUEST['class'] ) ) $args['class'] = (string) sanitize_key( $_REQUEST['class'] );
		if ( isset( $_REQUEST['multiple'] ) ) $args['multiple'] = (bool) sanitize_key( $_REQUEST['multiple'] );
		if ( isset( $_REQUEST['size'] ) ) $args['size'] = (int) sanitize_key( $_REQUEST['size'] );
		if ( isset( $_REQUEST['noselect'] ) ) $args['noselect'] = (bool) sanitize_key( $_REQUEST['noselect'] );
		die( wp_shortcode()->tools->select( $args ) );
	}

	public static function wps_get_taxonomies() {
		$args = array();
		$args['options'] = wp_shortcode()->tools->get_taxonomies();
		die( wp_shortcode()->tools->select( $args ) );
	}

	/**
	 * Helper function to create shortcode code with default settings.
	 *
	 * @param mixed   $args Array with settings
	 * @since  1.0
	 * @return string      Shortcode code
	 */
	public static function get_shortcode_code( $args ) {

		$defaults = array(
			'id'		=> '',
			'number'	=> 1,
			'nested'	=> false,
		);

		// Accept shortcode ID as a string
		if ( is_string( $args ) ) {
			$args = array( 'id' => $args );
		}

		$args = wp_parse_args( $args, $defaults );

		// Check shortcode ID
		if ( empty( $args['id'] ) ) {
			return '';
		}

		// Get shortcode data
		$shortcode = wp_shortcode()->list->shortcodes( $args['id'] );

		// Prepare shortcode prefix
		$prefix = wps_prefix();

		// Prepare attributes container
		$attributes = '';

		// Loop through attributes
		foreach ( $shortcode['fields'] as $attr_id => $attribute ) {
			// Skip hidden attributes
			if ( isset( $attribute['hidden'] ) && $attribute['hidden'] ) {
				continue;
			}
			// Add attribute
			$attributes .= sprintf( ' %s="%s"', esc_html( $attr_id ), esc_attr( $attribute['default'] ) );
		}

		// Create opening tag with attributes
		$output = "[{$prefix}{$args['id']}{$attributes}]";

		// Indent nested shortcodes
		if ( $args['nested'] ) {
			$output = "\t" . $output;
		}

		// Insert shortcode content
		if ( isset( $shortcode['content'] ) ) {
			if ( is_string( $shortcode['content'] ) ) {
				$output .= $shortcode['content'];
			} else if ( is_array( $shortcode['content'] ) && $args['id'] !== $shortcode['content']['id'] ) {
				$shortcode['content']['nested'] = true;
				$output .= $this->get_shortcode_code( $shortcode['content'] );
			}
		}

		// Add closing tag
		if ( isset( $shortcode['type'] ) && $shortcode['type'] === 'wrap' ) {
			$output .= "[/{$prefix}{$args['id']}]";
		}

		// Repeat shortcode
		if ( $args['number'] > 1 ) {
			$output = implode( "\n", array_fill( 0, $args['number'], $output ) );
		}

		// Add line breaks around nested shortcodes
		if ( $args['nested'] ) {
			$output = "\n{$output}\n";
		}
		return $output;
	}

	public function check_updater( $settings ) {
		if ( ! class_exists('mts_connection') || ! defined('MTS_CONNECT_ACTIVE') || ! MTS_CONNECT_ACTIVE ) {
			$settings = array(
				'connect'	=> array(
					'icon'	=> 'fa fa-cog',
					'title'	=> __( 'General Settings', 'wp-shortcode-pro' ),
					'desc'	=> '',
				),
			);
		}
		return $settings;
	}
}

// Init the plugin admin.
wp_shortcode()->admin = new WP_Shortcode_Admin;
