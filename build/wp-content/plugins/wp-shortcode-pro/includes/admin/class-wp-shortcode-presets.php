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

class WPS_Presets extends WP_Shortcode_Base {

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->preset_prefix = 'wps_presets_';
		$this->hooks();
	}

	/**
	 * Setup hooks.
	 * @return void
	 */
	private function hooks() {
		$this->add_action( 'wps_generator_actions', 'wps_presets' );
		$this->add_action( 'wp_ajax_wps_add_preset', 'wps_add_preset' );
		$this->add_action( 'wp_ajax_wps_remove_preset', 'wps_remove_preset' );
		$this->add_action( 'wp_ajax_wps_get_preset', 'wps_get_preset' );
	}

	public function wps_presets( $actions ) {
		ob_start();
	?>
		<div class="wps-presets alignleft" data-shortcode="<?php echo sanitize_key( $_REQUEST['shortcode'] ); ?>">
			<a href="javascript:void(0);" class="button button-large wps-preset-button">
				<i class="fa fa-bars"></i>
				<?php _e( 'Presets', 'wp-shortcode-pro' ); ?>
			</a>
			<div class="wps-preset-options">
				<div class="wps-preset-list">
					<?php $this->presets_list(); ?>
				</div>
				<a href="javascript:void(0);" class="button button-small button-primary wps-save-preset">
					<?php _e( 'Save settings', 'wp-shortcode-pro' ); ?>
				</a>
			</div>
		</div>
		<?php
		$actions['presets'] = ob_get_contents();
		ob_end_clean();
		return $actions;
	}

	public function presets_list( $shortcode = false ) {

		if ( !$shortcode ) $shortcode = $_REQUEST['shortcode'];

		if ( !$shortcode ) return;

		$shortcode = sanitize_key( $shortcode );
		$presets = $this->get_saved_presets($shortcode);

		if ( is_array( $presets ) && count( $presets ) ) {
			foreach ( $presets as $preset ) {
				$data = '<span data-id="' . $preset['id'] . '"><em>' . stripslashes( $preset['name'] ) . '</em>';
				if(is_numeric($preset['id'])) {
					$data .= '<i class="fa fa-times"></i>';	
				}
				$data .= '</span>';
				echo $data;
			}
		}
		echo '<b>'.__( 'No Presets Added.', 'wp-shortcode-pro' ).'</b>';
	}

	public function wps_add_preset() {

		if ( empty( $_POST['id'] ) || empty( $_POST['name'] ) || empty( $_POST['settings'] ) || empty( $_POST['shortcode'] ) ) return;

		$id = sanitize_key( $_POST['id'] );
		$name = sanitize_text_field( $_POST['name'] );
		$settings = ( is_array( $_POST['settings'] ) ) ? stripslashes_deep( $_POST['settings'] ) : array();
		$shortcode = sanitize_key( $_POST['shortcode'] );

		$option = $this->preset_prefix . $shortcode;
		$current = $this->get_saved_presets($shortcode);
		$new = array(
			'id'				=> $id,
			'name'			=> $name,
			'settings'	=> $settings
		);

		if ( !is_array( $current ) )
			$current = array();

		$current[$id] = $new;
		update_option( $option, $current );
	}

	public function wps_remove_preset() {

		if ( empty( $_POST['id'] ) || empty( $_POST['shortcode'] ) ) return;

		$id = sanitize_key( $_POST['id'] );
		$shortcode = sanitize_key( $_POST['shortcode'] );
		$option = $this->preset_prefix . $shortcode;
		$current = $this->get_saved_presets($shortcode);

		if ( !is_array( $current ) || empty( $current[$id] ) ) return;

		unset( $current[$id] );
		update_option( $option, $current );
	}

	public function wps_get_preset() {

		if ( empty( $_GET['id'] ) || empty( $_GET['shortcode'] ) ) return;

		$id = sanitize_key( $_GET['id'] );
		$shortcode = sanitize_key( $_GET['shortcode'] );
		$presets = $this->get_saved_presets($shortcode);
		$data = array();
		if ( is_array( $presets ) && isset( $presets[$id]['settings'] ) )
			$data = $presets[$id]['settings'];

		die( json_encode( $data ) );
	}

	public function get_saved_presets($shortcode) {
		return get_option( $this->preset_prefix . $shortcode );
	}

}

wp_shortcode()->presets = new WPS_Presets;