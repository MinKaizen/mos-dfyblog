<?php
/**
 * The option page functionality of the plugin.
 *
 * This class defines all code necessary to have setting pages and manager.
 *
 * @since      1.0
 * @package    WP_SHORTCODE
 * @subpackage WP_SHORTCODE/admin
 * @author     MyThemeShop <admin@mythemeshop.com>
 */
class WP_Shortcode_Admin_Options extends WP_Shortcode_Base {

	/**
	 * Page title.
	 * @var string
	 */
	public $title = 'Settings';

	/**
	 * Menu title.
	 * @var string
	 */
	public $menu_title = 'Settings';

	/**
	 * Hold tabs for page.
	 * @var array
	 */
	public $tabs = array();

	/**
	 * Hold folder name for tab files.
	 * @var string
	 */
	public $folder = '';

	/**
	 * Menu Position
	 * @var int
	 */
	public $position = 10;

	/**
	 * CMB2 option page id.
	 * @var string
	 */
	private $cmb_id = null;

	/**
	 * The Constructor
	 */
	public function __construct( $config ) {

		$this->config( $config );
		$this->cmb_id = $this->key . '_options';
		$this->add_action( 'cmb2_admin_init', 'register_option_metabox', -1 );

		if ( ! $this->is_current_page() ) {
			return;
		}

		$this->add_action( 'admin_enqueue_scripts', 'enqueue' );
		add_action( 'admin_enqueue_scripts', array( 'CMB2_hookup', 'enqueue_cmb_css' ), 25 );
	}

	/**
	 * Create option object and add settings
	 */
	function register_option_metabox() {

		$cmb = new_cmb2_box( array(
			'id'           => $this->cmb_id,
			'title'        => $this->title,
			'menu_title'   => $this->menu_title,
			'object_types' => array( 'options-page' ),
			'option_key'   => $this->key,
			'parent_slug'  => 'wp-shortcode-pro',
			'priority'     => 'low',
			'display_cb'   => array( $this, 'display' ),
			'classes'      => 'wps-options-wrapper',
		) );

		foreach ( $this->get_tabs() as $id => $tab ) {

			if ( isset( $tab['type'] ) && 'seprator' === $tab['type'] ) {
				continue;
			}

			$cmb->add_field( array(
				'name'          => esc_html__( 'Panel', 'wp-shortcode-pro' ),
				'id'            => 'setting-panel-' . $id,
				'type'          => 'tab_open',
				'render_row_cb' => array( $this, 'tab_open' ),
				'save_field'    => true,
			) );

			$cmb->add_field( array(
				'id'   => $id . '_section_title',
				'type' => 'title',
				'name' => $tab['title'],
				'desc' => $tab['desc'],
			) );

			if ( isset( $tab['file'] ) && ! empty( $tab['file'] ) ) {
				include $tab['file'];
			} else {
				include_once( wp_shortcode()->admin_dir() . "settings/{$this->folder}/{$id}.php" );
			}

			$cmb->add_field( array(
				'id'            => 'setting-panel-' . $id . '-close',
				'type'          => 'tab_close',
				'render_row_cb' => array( $this, 'tab_close' ),
				'save_field'    => true,
			) );
		}

		foreach ( $cmb->prop( 'fields' ) as $id => $field_args ) {
			$field = $cmb->get_field( $id );

			// Bind dependency
			if ( ! empty( $field_args['dep'] ) ) {
				$this->set_dependencies( $field, $field_args );
			}
		}
	}

	/**
	 * Enqueue styles and scripts.
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, null );
	}

	/**
	 * Display Setting on a page
	 */
	public function display( $machine ) {

		$cmb    = $machine->cmb;
		$active = ! empty( $_GET['wp-shortcode-tab'] ) ? $_GET['wp-shortcode-tab'] : 'general';
		?>
		<div class="wrap wp-shortcode-wrap wp-shortcode-wrap-settings">

			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<div class="wp-shortcode-tab-wrapper wp-clearfix">

				<?php foreach ( $this->get_tabs() as $id => $tab ) : ?>
					<?php if ( isset( $tab['type'] ) && 'seprator' === $tab['type'] ) : ?>
						<span><?php echo $tab['title']; ?></span>
					<?php else : ?>
						<a href="#setting-panel-<?php echo $id; ?>"<?php echo $id === $active ? 'class="active"' : ''; ?>><span class="<?php echo esc_attr( $tab['icon'] ); ?>"></span><?php echo $tab['title']; ?></a>
					<?php endif; ?>
				<?php endforeach; ?>

				<input type="submit" id="wp-shortcode-submit-cmb" value="<?php _e('Save Changes', 'wp-shortcode-pro'); ?>" class="button-primary">

			</div>

			<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
				<input type="hidden" name="action" value="<?php echo esc_attr( $machine->option_key ); ?>">
				<?php $machine->options_page_metabox(); ?>
				<?php submit_button( esc_attr( $cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb', false ); ?>
			</form>

		</div>

		<?php
	}

	/**
	 * [set_dependencies description]
	 * @param [type] $field [description]
	 * @param [type] $args  [description]
	 */
	private function set_dependencies( $field, $args ) {

		if ( ! isset( $args['dep'] ) || empty( $args['dep'] ) ) {
			return;
		}

		$dependency = '';
		$relation   = key( $args['dep'] );

		if ( 'relation' === $relation ) {
			$relation = current( $args['dep'] );
			unset( $args['dep']['relation'] );
		} else {
			$relation = 'OR';
		}
		foreach ( $args['dep'] as $dependence ) {
			$compasrison = isset( $dependence[2] ) ? $dependence[2] : '=';
			$dependency .= '<span class="hidden" data-field="' . $dependence[0] . '" data-comparison="' . $compasrison . '" data-value="' . $dependence[1] . '"></span>';
		}

		$field->args['after_field'] = '<div class="wp-shortcode-cmb-dependency hidden" data-relation="' . strtolower( $relation ) . '">' . $dependency . '</div>';
	}

	/**
	 * Get setting tabs
	 * @return array
	 */
	public function get_tabs() {

		$filter = 'admin_' . str_replace( '-', '_', str_replace( 'wp-shortcode-', '', $this->key ) ) . '_tabs';

		return wp_shortcode_filter( $filter, $this->tabs );
	}

	/**
	 * [tab_open description]
	 * @return [type] [description]
	 */
	public function tab_open( $field_args, $field ) {
		echo '<div id="' . $field->prop( 'id' ) . '" class="wp-shortcode-setting-panel">';
	}

	/**
	 * [tab_close description]
	 * @return [type] [description]
	 */
	public function tab_close( $field_args, $field ) {
		echo '</div><!-- /#' . $field->prop( 'id' ) . ' -->';
	}

	/**
	 * Is the page is currrent page
	 * @return boolean
	 */
	public function is_current_page() {

		$page   = isset( $_REQUEST['page'] ) && ! empty( $_REQUEST['page'] ) ? $_REQUEST['page'] : false;
		$action = isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) ? $_REQUEST['action'] : false;

		return $page === $this->key || $action === $this->key;
	}

}
