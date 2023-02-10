<?php
/**
 * Custom Shortcode Class
 *
 * @since		1.0
 * @package		WP_SHORTCODE
 * @subpackage	WP_SHORTCODE/includes
 * @author		MyThemeShop <admin@mythemeshop.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WPS_Create_Shortcode extends WP_Shortcode_Base {
	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Setup hooks.
	 * @return void
	 */
	private function hooks() {
		$this->add_action( 'init', 'register_post_type', 9 );
		$this->add_action( 'add_meta_boxes', 'add_events_metaboxes' );
		$this->add_action( 'wp_ajax_wps_add_field', 'wps_add_field_callback' );
		$this->add_action( 'save_post', 'wps_save_posts_callback', 10, 2 );

		// Add custom shortcode to the shortcode lists
		$this->add_filter( 'wp_shortcodes_lists', 'wps_add_created_shortcodes' );

		// Add Shortcode Key and Shortcode Columns
		$this->add_filter( 'manage_edit-wp_custom_shortcodes_columns', 'edit_wp_custom_shortcode_columns' );
		$this->add_action( 'manage_wp_custom_shortcodes_posts_custom_column', 'manage_wp_custom_shortcode_columns', 10, 2 );
	}

	function register_post_type() {
		$labels = array(
			'name'					=> _x( 'Custom Shortcodes', 'post type general name', 'wp-shortcode-pro' ),
			'singular_name'			=> _x( 'Custom Shortcode', 'post type singular name', 'wp-shortcode-pro' ),
			'menu_name'				=> _x( 'Custom Shortcodes', 'admin menu', 'wp-shortcode-pro' ),
			'name_admin_bar'		=> _x( 'Custom Shortcodes', 'add new on admin bar', 'wp-shortcode-pro' ),
			'add_new'				=> _x( 'Add New', 'shortcode', 'wp-shortcode-pro' ),
			'add_new_item'			=> __( 'Add New Shortcode', 'wp-shortcode-pro' ),
			'new_item'				=> __( 'New Shortcode', 'wp-shortcode-pro' ),
			'edit_item'				=> __( 'Edit Shortcode', 'wp-shortcode-pro' ),
			'view_item'				=> __( 'View Shortcode', 'wp-shortcode-pro' ),
			'all_items'				=> __( 'Custom Shortcodes', 'wp-shortcode-pro' ),
			'search_items'			=> __( 'Search Shortcodes', 'wp-shortcode-pro' ),
			'parent_item_colon'		=> __( 'Parent Shortcode:', 'wp-shortcode-pro' ),
			'not_found'				=> __( 'No shortcodes found.', 'wp-shortcode-pro' ),
			'not_found_in_trash'	=> __( 'No shortcodes found in Trash.', 'wp-shortcode-pro' )
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'menu_icon' => '',
			'menu_position' => null,
			'query_var' => false,
			'rewrite' => array('slug' => 'wp_custom_shortcodes', 'with_front' => false, 'feeds' => false),
			'capability_type' => 'page',
			'map_meta_cap' => true,
			'has_archive' => false,
			'hierarchical' => false,
			'supports' => array( '' )
		);
		register_post_type( 'wp_custom_shortcodes', $args );
	}

	function add_events_metaboxes() {
		add_meta_box( 'wps_new_shortcode_details', __( 'Shortcode Details', 'wp-shortcode-pro' ), array($this, 'wps_details'), 'wp_custom_shortcodes', 'normal', 'high' );
		add_meta_box( 'wps_fields', __('Fields', 'wp-shortcode-pro'), array($this, 'wps_fields'), 'wp_custom_shortcodes', 'side', 'low' );
		add_meta_box('wps_new_shortcode_fields', __( 'Shortcode Fields', 'wp-shortcode-pro' ), array($this, 'wps_new_shortcode_fields'), 'wp_custom_shortcodes', 'normal', 'default' );
		add_meta_box( 'wps_layout', __('Shortcode Layout', 'wp-shortcode-pro'), array($this, 'wps_layout'), 'wp_custom_shortcodes', 'normal', 'default' );
	}

	function edit_wp_custom_shortcode_columns($columns) {
		unset($columns['date']);
		$columns['key'] = __('Key', 'wp-shortcode-pro');
		$columns['shortcode'] = __('Shortcode', 'wp-shortcode-pro');

		return $columns;
	}

	function manage_wp_custom_shortcode_columns( $column, $post_id ) {
		global $post;

		switch( $column ) {
			case 'key' :
				echo $post->post_name;
				break;
			case 'shortcode' :
				$shortcode = '['.$post->post_name;
				$shortcode_type = $this->wps_get_field_value('type');
				$fields = $this->wps_get_field_value('fields');
				if( !empty($fields) ) {
					foreach( $fields as $key => $value ) {
						$shortcode .= ' '.$key.'="'.$value['default'].'"';
					}
				}
				$shortcode .= ']';
				if( $shortcode_type === 'wrap' ) {
					$shortcode .= '[/'.$post->post_name.']';
				}
				echo '<input type="text" readonly="readonly" class="widefat" value="'.esc_attr($shortcode).'" />';
				break;
			default :
				break;
		}
	}

	function wps_add_created_shortcodes($shortcodes) {

		$custom_shortcodes = $this->get_custom_shortcode_details();

		foreach($custom_shortcodes as $key => $shortcode) {
			$shortcodes[$key] = $shortcode;
		}

		return $shortcodes;
	}

	function get_custom_shortcode_details() {
		$created_shortcodes = get_posts(array(
			'post_type' => 'wp_custom_shortcodes',
			'post_status' => 'publish',
		));
		$custom_shortcodes = array();
		foreach($created_shortcodes as $shortcode) {
			$wps_details = get_post_meta( $shortcode->ID, '_wps_details', true );
			$wps_details['name'] = get_the_title($shortcode->ID);
			$custom_shortcodes[$shortcode->post_name] = $wps_details;
		}
		return $custom_shortcodes;
	}

	function wps_details() {
		global $post;
		ob_start();
		wp_nonce_field( 'wps_details', 'wps_details_field' );
		$title = get_the_title($post->ID);
		$title = ( $title !== 'Auto Draft' ) ? $title : '';
		?>
		<div id="wp-custom-shortcodes-wrapper" class="wps-fields">

			<div class="wps-form-field">
				<label for="post_name"><?php _e('Shortcode Key*', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper">
					<?php post_slug_meta_box($post); ?>
					<span class="description"><?php _e('Shortcode key is a required field and it must be unique.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>

			<div class="wps-form-field">
				<label for="wps-name"><?php _e('Shortcode Name', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper">
					<input type="text" name="post_title" id="wps-name" value="<?php echo $title; ?>" />
					<span class="description"><?php _e('Shortcode name which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>

			<div class="wps-form-field">
				<label for="wps-type"><?php _e('Shortcode Type', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper">
					<select name="wps-details[type]" id="wps-type">
						<option value="single" <?php selected( $this->wps_get_field_value('type'), 'single' ); ?>><?php _e('Single', 'wp-shortcode-pro'); ?></option>
						<option value="wrap" <?php selected( $this->wps_get_field_value('type'), 'wrap' ); ?>><?php _e('Wrap', 'wp-shortcode-pro'); ?></option>
					</select>
					<span class="description"><?php _e('Shortcode type.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>

			<?php
				$categories = wp_shortcode()->list->categories();
				if( !empty($categories) ) {
			?>
				<div class="wps-form-field">
					
					<label for="wps-category"><?php _e('Shortcode Category', 'wp-shortcode-pro'); ?></label>
					<div class="wps-input-wrapper">
						<select name="wps-details[category]" id="wps-category">
							<?php foreach( $categories as $key => $value ) {
								if($key !== 'all') { ?>
									<option value="<?php echo esc_attr($key); ?>" <?php selected( $this->wps_get_field_value('type'), $key ); ?>><?php echo esc_html($value); ?></option>
							<?php }
							} ?>
						</select>
						<span class="description"><?php _e('Shortcode category.', 'wp-shortcode-pro'); ?></span>
					</div>
				</div>
			<?php } ?>
			<div class="wps-form-field">
				<label for="wps-description"><?php _e('Shortcode Description', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper">
					<input type="text" name="wps-details[desc]" id="wps-description" value="<?php echo $this->wps_get_field_value('desc') ?>" />
					<span class="description"><?php _e('Shortcode description which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>
			<div class="wps-form-field">
				<label for="wps-icon"><?php _e('Shortcode Icon', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper wps-field-wrapper">
					<?php
					$icon_name = "wps-details[icon]";
					echo WPS_Fields::icon($icon_name, array('default' => $this->wps_get_field_value('icon')), false);
					?>
					<span class="description"><?php _e('Shortcode icon which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>
		</div>

		<?php
		echo ob_get_clean();
	}

	function wps_layout() {
		ob_start();
		$shortcode_layout = $this->wps_get_field_value('layout');
		$shortcode_css = $this->wps_get_field_value('css');
		wp_nonce_field( 'wps_details', 'wps_details_field' );
		?>
		<div id="wp-shortcode-layout" class="wps-fields">
			<p class="description wps-available-fields">
				<?php
				$fields = $this->wps_get_field_value('fields');

				if( !empty($fields) ) {
					_e('Available Fields:', 'wp-shortcode-pro');
					foreach( $fields as $field_key => $field ) {
						if($field_key) {
				?>
							<b class="wps-set-field">%<?php echo $field_key; ?>%</b>,
				<?php
						}
					}
				}
				if($this->wps_get_field_value('type') === 'wrap') {
					echo '<b class="wps-set-field">%content%</b>';
				}	
				?>
			</p>
			<div class="wps-form-field">
				<?php
				$html_settings = wp_enqueue_code_editor( array(
					'type' => 'text/html',
					'codemirror' => array(
						'indentUnit' => 2,
						'tabSize' => 2,
					),
				) );
				?>
				<label for="shortcode-layout"><?php _e('Layout', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper">
					<textarea name="wps-details[layout]" class="wps-editor" id="shortcode-layout" rows="15" data-editor='<?php echo wp_json_encode($html_settings); ?>'><?php echo $shortcode_layout; ?></textarea>
					<span class="description"><?php _e('Shortcode Structure.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>
			<div class="wps-form-field">
				<?php
				$css_settings = wp_enqueue_code_editor( array(
					'type' => 'text/css',
					'codemirror' => array(
						'indentUnit' => 2,
						'tabSize' => 2,
					),
				) );
				?>
				<label for="shortcode-layout"><?php _e('CSS', 'wp-shortcode-pro'); ?></label>
				<div class="wps-input-wrapper">
					<textarea name="wps-details[css]" class="wps-editor" id="shortcode-css" rows="15" data-editor='<?php echo wp_json_encode( $css_settings ); ?>'><?php echo $shortcode_css; ?></textarea>
					<span class="description"><?php _e('Shortcode CSS.', 'wp-shortcode-pro'); ?></span>
				</div>
			</div>
		</div>

		<?php

		wp_enqueue_script( 'code-editor' );
		echo ob_get_clean();
	}

	function wps_new_shortcode_fields() {

		$fields = $this->wps_get_field_value('fields');
		wp_nonce_field( 'wps_details', 'wps_details_field' );
		echo '<p class="wps-fields-header exists">'.__('Drag each item into the order you prefer. Click on the item to reveal additional configuration options.','wp-shortcode-pro').'</p>';
		echo '<ul class="wps-fields accordion" id="wps-fields-data" data-sortable>';
			echo '<p class="wps-fields-header empty">'.__('Add fields from the column on the right.','wp-shortcode-pro').'</p>';
			if( !empty($fields) ) {
				$i = 0;
				foreach($fields as $key => $field) {
					$this->wps_field_structure( $field['type'], $i, $key, $field );
					$i++;
				}
			}
		echo '</ul>';
	}

	// Ajax Callback
	function wps_add_field_callback() {
		$return = '';
		$type = $_POST['field'];
		$new_index = $_POST['new_index'];
		ob_start();

		if ( is_callable( array( 'WPS_Fields', $type ) ) ) {
			$this->wps_field_structure($type, $new_index);
		}

		echo ob_get_clean();
		die();
	}

	function wps_field_structure( $type = 'text', $number = 0, $key = '', $field = array() ) {
		ob_start();

		$field_id = isset($field['id']) ? esc_attr($field['id']) : '';
		$name = isset($field['name']) ? esc_attr($field['name']) : '';
		$default = isset($field['default']) ? esc_attr($field['default']) : '';
		$description = isset($field['desc']) ? esc_attr($field['desc']) : '';
		$field_desc = $field_id ? $field_id : $type;

	?>
		<li class="wps-attribute-wrapper wps-field" data-number="<?php echo esc_attr($number); ?>">
			<div class="wps-form-field">
				<div class="wps-field">
					<span class="wps-field-title"><?php echo $name . ' ('.$field_desc.')'; ?></span>
					<span class="alignright wps-field-type">
						<span class="wps-field-actions">
							<a href="javascript:;" class="wps-delete-field" title="<?php _e( 'Delete', 'wp-shortcode-pro' ); ?>">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</a>
							<a href="javascript:;" class="wps-duplicate-field" title="<?php _e( 'Duplicate', 'wp-shortcode-pro' ); ?>">
								<i class="fa fa-files-o" aria-hidden="true"></i>
							</a>
						</span>
					</span>
				</div>
				<div class="wps-field-options" style="display: none;">

					<div class="wps-field-holder" data-field="id">
						<label for="wps-field-id"><?php _e('Field Id', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<input type="text" name="wps-details[fields][<?php echo $number; ?>][id]" class="wps-field-id" id="wps-field-id" value="<?php echo $field_id; ?>" />
							<span class="description"><?php _e('Field ID.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>

					<div class="wps-field-holder" data-field="name">
						<label for="wps-field-name"><?php _e('Field Name', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<input type="text"  class="wps-field-name" name="wps-details[fields][<?php echo $number; ?>][name]" id="wps-field-name" value="<?php echo $name; ?>" />
							<span class="description"><?php _e('Field name which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>

					<?php
						if( $type === 'select' || $type === 'radio' || $type === 'checkbox' ) {
							if($type === 'select') {
								$is_multiple = isset($field['multiple']) ? esc_attr($field['multiple']) : '';
					?>
								<div class="wps-field-holder" data-field="multiple">
									<label for="wps-default-value"><?php _e('Is Multiple?', 'wp-shortcode-pro'); ?></label>
									<div class="wps-input-wrapper">
										<input type="checkbox" name="wps-details[fields][<?php echo $number; ?>][multiple]" value="true" <?php checked($is_multiple, 'true'); ?> />
										<span class="description"><?php _e('Enabled Multiple select.', 'wp-shortcode-pro'); ?></span>
									</div>
								</div>
						<?php } ?>
						<div class="wps-field-holder" data-field="values">
							<label for="wps-default-value"><?php _e('Options', 'wp-shortcode-pro'); ?></label>
							<div class="wps-input-wrapper">
								<div class="wps-select-options">
									<?php
									if(isset($field['values'])) {
										$i = 0;
										foreach($field['values'] as $option_key => $option_value) {
											echo $this->wps_get_options_wrapper($number, $i, $option_key, $option_value);
											$i++;
										}
									} else {
										echo $this->wps_get_options_wrapper($number);
									} ?>

									<button class="button-secondary wps-add-option">
										<?php _e( 'Add Option', 'wp-shortcode-pro' ); ?>
									</button>
								</div>
							</div>
						</div>
					<?php }

					if( $type === 'slider' || $type === 'number' ) { ?>
						<div class="wps-field-holder" data-field="min">
							<label for="wps-default-value"><?php _e('Min', 'wp-shortcode-pro'); ?></label>
							<div class="wps-input-wrapper">
								<input type="number" name="wps-details[fields][<?php echo $number; ?>][min]" id="wps-min" />
								<span class="description"><?php _e('Min.', 'wp-shortcode-pro'); ?></span>
							</div>
						</div>
						<div class="wps-field-holder" data-field="max">
							<label for="wps-default-value"><?php _e('Max', 'wp-shortcode-pro'); ?></label>
							<div class="wps-input-wrapper">
								<input type="number" name="wps-details[fields][<?php echo $number; ?>][max]" id="wps-max" />
								<span class="description"><?php _e('Max.', 'wp-shortcode-pro'); ?></span>
							</div>
						</div>
						<div class="wps-field-holder" data-field="step">
							<label for="wps-default-value"><?php _e('Step', 'wp-shortcode-pro'); ?></label>
							<div class="wps-input-wrapper">
								<input type="number" name="wps-details[fields][<?php echo $number; ?>][step]" id="wps-step" />
								<span class="description"><?php _e('Step.', 'wp-shortcode-pro'); ?></span>
							</div>
						</div>
					<?php } ?>

					<div class="wps-field-holder" data-field="default">
						<label for="wps-default-value"><?php _e('Default', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<?php
							if ( is_callable( array( 'WPS_Fields', $type ) ) && ! in_array($type, array('select', 'radio', 'checkbox', 'upload', 'icon', 'editor', 'slider')) ) {
								echo call_user_func( array( 'WPS_Fields', $type ), "wps-details[fields][$number][default]", $field );
							} else {
							?>
								<input type="text" name="wps-details[fields][<?php echo $number; ?>][default]" id="wps-default-value" value="<?php echo $default; ?>" />
							<?php } ?>
							<span class="description"><?php _e('Default value.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>

					<div class="wps-field-holder" data-field="desc">
						<label for="wps-field-description"><?php _e('Description', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<input type="text" name="wps-details[fields][<?php echo $number; ?>][desc]" id="wps-field-description" value="<?php echo $description; ?>" />
							<span class="description"><?php _e('Description.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>

					<div class="wps-field-holder" data-field="type">
						<input type="hidden" name="wps-details[fields][<?php echo $number; ?>][type]" value="<?php echo esc_attr($type); ?>" />
					</div>

				</div>
			</div>

		</li>
	<?php
		echo ob_get_clean();
	}

	function wps_get_options_wrapper($field_number, $index = 0, $key = '', $value = '') {
		ob_start();
		?>
		<div class="wps-inner-wrapper">
			<input type="text" class="option-value" name="wps-details[fields][<?php echo $field_number; ?>][values][<?php echo $index; ?>][value]" placeholder="<?php _e('Value', 'wp-shortcode-pro') ?>" value="<?php echo esc_attr($key); ?>" />
			<input type="text" class="option-name" name="wps-details[fields][<?php echo $field_number; ?>][values][<?php echo $index; ?>][name]" placeholder="<?php _e('Name', 'wp-shortcode-pro') ?>" value="<?php echo esc_attr($value); ?>" />
			<span class="wps-remove-option">
				<i class="fa fa-minus" aria-hidden="true"></i>
			</span>
		</div>
		<?php
		return ob_get_clean();
	}

	function wps_fields() {
		$fields = get_class_methods ( 'WPS_Fields' );
		echo '<div class="wps-field-selector">';
			foreach( $fields as $field ) {
				if( ! in_array( $field, array( '__construct', 'image_source', 'editor', 'table' ) ) ) {
					$field_name = str_replace('_', ' ', $field);
					echo '<button type="button" class="button-secondary" data-field="'.esc_attr($field).'">'.$field_name.'</button>';	
				}
			}
		echo '</div>';
		echo '<div class="wps-publishing-action" id="major-publishing-actions">
			<input type="hidden" name="post_status" id="post_status" value="publish">
			<input type="submit" id="publish" name="save_metabox" class="button button-primary button-large" value="'.__('Update', 'wp-shortcode-pro').'">
		</div>';
	}

	function wps_save_posts_callback( $post_id, $post ) {
		
		if ( wp_is_post_revision( $post_id ) || $post->post_type !== 'wp_custom_shortcodes' || ! isset($_POST['wps-details']) ) return;
		if ( ! isset( $_POST['wps_details_field'] )  || ! wp_verify_nonce( $_POST['wps_details_field'], 'wps_details' ) ) return;

		$field_details = array();
		$wps_details = $_POST['wps-details'];

		$fields = $wps_details['fields'];

		foreach( $fields as $field ) {
			if(isset($field['id'])) {
				$options = array();
				if(  isset($field['values']) && !empty($field['values'])) {
					foreach($field['values'] as $option) {
						$options[$option['value']] = $option['name'];
					}
					$field['values'] = $options;
				}
				$field_details[$field['id']] = $field;
			}
		}

		$wps_details['fields'] = $field_details;
		update_post_meta($post_id, '_wps_details', $wps_details);

	}

	function wps_get_field_value( $field_name ) {
		if( ! $field_name ) return;
		global $post;
		$wps_details = get_post_meta( $post->ID, '_wps_details', true );
		if( isset($wps_details[$field_name]) && !empty($wps_details[$field_name]) ) return $wps_details[$field_name];

		return '';
	}

}

// Init the create shortcode.
wp_shortcode()->create_shortcode = new WPS_Create_Shortcode;