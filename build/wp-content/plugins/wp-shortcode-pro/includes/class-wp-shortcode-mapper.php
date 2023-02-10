<?php
/**
 * Shortcode Mapper Class
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

class WPS_Map extends WP_Shortcode_Base {

	private static $new_shortcodes = array();

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->hooks();
		$this->wps_mapper_menu();
	}

	function hooks() {
		$this->add_filter( 'wp_shortcodes_lists', 'wp_map_shortcodes' );
		$this->add_action( 'wp_ajax_wps_map_shortcode', 'wps_map_shortcode_callback' );
		$this->add_action( 'admin_init', 'wps_shortcode_mapper_settings' );
	}

	//Map shortcodes
	function wps_shortcode_mapper_settings() {
		if(isset($_POST['wps_mapper'])) {
			$mapper_data = $_POST['wps_mapper'];
			foreach($mapper_data as $key => $data) {
				if(isset($data['fields'])) {
					$_POST['wps_mapper'][$key]['fields'] = array_filter($data['fields'], function($value) { return isset($value['id']) && $value['id'] !== ''; });
				}
			}
		}
		register_setting( 'wps_map_options', 'wps_mapper' );
	}

	/**
	 * Shortcode Mapper Menu
	 */
	public function wps_mapper_menu() {
		new WP_Shortcode_Admin_Page( 'edit.php?post_type=wp_custom_shortcodes',
			esc_html__( 'Custom Shortcode', 'wp-shortcode-pro' ), array(
			'position'	=> 30,
			'parent'	=> 'wp-shortcode-pro'
		));
		new WP_Shortcode_Admin_Page( 'wp-shortcode-mapper', esc_html__( 'Shortcode Mapper', 'wp-shortcode-pro' ), array(
			'position'	=> 40,
			'parent'	=> 'wp-shortcode-pro',
			'render'	=> wp_shortcode()->admin_dir() . 'views/shortcode-mapper.php',
		));
	}

	//Display Error/Success Message
	public static function display_messages() {
		$message = false;
		$class = 'error wps-hidden';
		if ( isset( $_REQUEST['settings-updated'] ) && ( $msg = $_REQUEST['settings-updated'] ) ) {
			$message = esc_html__( 'Settings saved', 'wp-shortcode-pro' );
			$class = 'updated notice is-dismissible';
		} else if(isset( $_REQUEST['error'] )) {
			$message = __('Something went wrong.', 'wp-shortcode-pro');
		}
		?>
			<div id="message" class="<?php echo $class; ?>">
				<p><?php echo $message; ?></p>
			</div>
		<?php
	}

	//Add mapped shortcodes to Shortcode Selector Lists
	function wp_map_shortcodes($shortcodes) {
		$this->wps_mapped_shortcodes();
		$new_shortcodes = self::$new_shortcodes;
		if(!empty($new_shortcodes)) {
			foreach($new_shortcodes as $shortcode) {
				if(!empty($shortcode['fields'])) {
					foreach($shortcode['fields'] as $field_key => $field) {
						if($field['type'] === 'select' || $field['type'] === 'radio' || $field['type'] === 'checkbox') {
							if(!empty($field['values']) && !is_array($field['values'])) {
								$values = array();
								$options = explode(PHP_EOL, $field['values']);
								if(!empty($options)) {
									foreach($options as $option) {
										$extracted_options = explode(':', $option);
										$values[$extracted_options[0]] = $extracted_options[1];
									}
								}
								$shortcode['fields'][$field_key]['values'] = $values;	
							}
						}
					}
				}
				$shortcodes[$shortcode['key']] = $shortcode;	
				$shortcodes[$shortcode['key']]['fields']['is_mapped'] = array(
					'type'		=> 'hidden',
					'default'	=> 'true',
					'name'		=> 'mapped',
				);
			}
		}
		return $shortcodes;
	}

	// Map Shortcode Layout
	public static function shortcode_mapper_layout($shortcode_details = array()) {

		if( empty($shortcode_details) ) return;

		ob_start();

		$id = $shortcode_details['key'];
		$shortcode_name = isset($shortcode_details['name']) ? esc_html($shortcode_details['name']) : ucwords(str_replace('_', ' ', $shortcode_details['key']));
		$shortcode_type = isset($shortcode_details['type']) ? esc_html($shortcode_details['type']) : 'single';
		$shortcode_icon = isset($shortcode_details['icon']) ? esc_html($shortcode_details['icon']) : '';
		$shortcode_category = isset($shortcode_details['category']) ? esc_html($shortcode_details['category']) : 'other';
		$shortcode_description = isset($shortcode_details['desc']) ? esc_html($shortcode_details['desc']) : '';
		$shortcode_fields = isset($shortcode_details['fields']) ? $shortcode_details['fields'] : '';
		$shortcode_content = isset($shortcode_details['content']) ? esc_html($shortcode_details['content']) : '';
		$content_class = 'wps-hidden';

		$shortcode_preview = "[$id";
		if( !empty($shortcode_fields)) {
			foreach($shortcode_fields as $field) {
				$field_data = $field['id'].'="'.$field['default'].'"';
				$shortcode_preview .= " $field_data";
			}
		}
		$shortcode_preview .= "]";
		if($shortcode_type === 'wrap') {
			$shortcode_preview .= "$shortcode_content [/$id]";
			$content_class = '';
		}

		?>
		<li class="wps-inner-wrapper">
			<div>
				<?php echo esc_html($shortcode_name); ?>
				<span class="alignright wps-field-type wps-field-actions">
					<span class="wps-field-actions">
						<a href="javascript:;" class="wps-delete-shortcode" title="<?php _e('Delete', 'wp-shortcode-pro'); ?>">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</a>
					</span>
				</span>
			</div>
			<div class="wps-field">
				<div class="wps-mapper-header">
					<div class="wps-preview-text">
						<?php echo $shortcode_preview; ?>
					</div>
				</div>
				<div class="wps-general-info">
					<h4><?php _e('General Information', 'wp-shortcode-pro'); ?></h3>

					<div class="wps-form-field wps-hidden">
						<label><?php _e('Shortcode Key', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<input type="text" class="wps-shortcode-key" name="wps_mapper[<?php echo $id; ?>][key]" value="<?php echo esc_html( $id); ?>" />
							<span class="description"><?php _e('Shortcode key is a required field and it must be unique.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>

					<div class="wps-form-field">
						<label><?php _e('Shortcode Name', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<input type="text" name="wps_mapper[<?php echo $id; ?>][name]" value="<?php echo esc_html($shortcode_name); ?>" />
							<span class="description"><?php _e('Shortcode name which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>
					<div class="wps-form-field">
						<label><?php _e('Icon', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper wps-field-wrapper">
							<?php
							$icon_name = "wps_mapper[$id][icon]";
							echo WPS_Fields::icon($icon_name, array('default' => $shortcode_icon), false); ?>
							<span class="description"><?php _e('Shortcode icon which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>
					<div class="wps-form-field">
						<label><?php _e('Shortcode Type', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<select name="wps_mapper[<?php echo $id; ?>][type]" class="wps-type">
								<option value="single" <?php selected($shortcode_type, 'single'); ?>><?php _e('Single', 'wp-shortcode-pro'); ?></option>
								<option value="wrap" <?php selected($shortcode_type, 'wrap'); ?>><?php _e('Wrap', 'wp-shortcode-pro'); ?></option>
							</select>
							<span class="description"><?php _e('Shortcode type.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>

					<div class="wps-form-field">
						<label><?php _e('Category', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<select name="wps_mapper[<?php echo $id; ?>][category]" id="wps-category">
								<?php
								$categories = wp_shortcode()->list->categories();
								foreach( $categories as $key => $value ) {
									if($key !== 'all') { ?>
										<option value="<?php echo esc_attr($key); ?>" <?php selected($shortcode_category, $key); ?>><?php echo esc_html($value); ?></option>
								<?php }
								} ?>
							</select>
							<span class="description"><?php _e('Shortcode category.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>
					<div class="wps-form-field">
						<label><?php _e('Description', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<input type="text" name="wps_mapper[<?php echo $id; ?>][desc]" value="<?php echo $shortcode_description; ?>" />
							<span class="description"><?php _e('Shortcode description which will appear in shortcode selector box.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>
					<div class="wps-form-field wps-conent-holder <?php echo esc_attr($content_class); ?>">
						<label><?php _e('Content', 'wp-shortcode-pro'); ?></label>
						<div class="wps-input-wrapper">
							<textarea name="wps_mapper[<?php echo $id; ?>][content]" rows="4"><?php echo $shortcode_content; ?></textarea>
							<span class="description"><?php _e('Shortcode content.', 'wp-shortcode-pro'); ?></span>
						</div>
					</div>
				</div>
				<?php if(!empty($shortcode_fields)) { ?>
					<!-- Shortcode Fields -->
					<div class="wps-fields-wrapper">
						<h4><?php _e('Shortcode Fields', 'wp-shortcode-pro'); ?></h4>
						<ul class="wps-fields wps-fields-data" id="wps-fields-data">
							<?php
							foreach( $shortcode_details['fields'] as $key => $field ) {
								$field_id = isset($field['id']) ? esc_html($field['id']) : '';
								$name = isset($field['name']) ? esc_html($field['name']) : '';
								$default = isset($field['default']) ? esc_html($field['default']) : '';
								$type = isset($field['type']) ? esc_html($field['type']) : '';
								$description = isset($field['desc']) ? esc_html($field['desc']) : '';
								$values = isset($field['values']) ? esc_html($field['values']) : '';
								$option_class = '';
								if(!in_array($type, array('select', 'radio', 'checkbox'))) {
									$option_class = "wps-hidden";
								}
							?>
								<li class="wps-attribute-wrapper">
									<div class="wps-form-field">
										<div class="wps-field">
											<?php echo $field_id; ?>
											<span class="alignright wps-field-type">
												<span class="wps-field-actions">
													<a href="javascript:;" class="wps-delete-field" title="Delete">
														<i class="fa fa-trash-o" aria-hidden="true"></i>
													</a>
												</span>
											</span>
										</div>
										<div class="wps-field-options">
											<div class="wps-field-holder">
												<label><?php _e('Field ID', 'wp-shortcode-pro'); ?></label>
												<div class="wps-input-wrapper">
													<input type="text" name="wps_mapper[<?php echo $id; ?>][fields][<?php echo $field_id; ?>][id]" class="wps-field-id" value="<?php echo $field_id; ?>" data-field="id">
													<span class="description"><?php _e('Field ID', 'wp-shortcode-pro'); ?></span>
												</div>
											</div>

											<div class="wps-field-holder">
												<label><?php _e('Field Name', 'wp-shortcode-pro'); ?></label>
												<div class="wps-input-wrapper">
													<input type="text" name="wps_mapper[<?php echo $id; ?>][fields][<?php echo $field_id; ?>][name]" value="<?php echo $name; ?>" data-field="name">
													<span class="description"><?php _e('Field Name', 'wp-shortcode-pro'); ?></span>
												</div>
											</div>

											<div class="wps-field-holder">
												<label><?php _e('Field Type', 'wp-shortcode-pro'); ?></label>
												<div class="wps-input-wrapper">
													<select class="wps-field-type" name="wps_mapper[<?php echo $id; ?>][fields][<?php echo $field_id; ?>][type]" data-field="type">
														<option value="text" <?php selected($type, 'text'); ?>><?php _e('Textfield', 'wp-shortcode-pro') ?></option>
														<option value="select" <?php selected($type, 'select'); ?>><?php _e('Selectbox', 'wp-shortcode-pro') ?></option>
														<option value="radio" <?php selected($type, 'radio'); ?>><?php _e('Radio', 'wp-shortcode-pro') ?></option>
														<option value="checkbox" <?php selected($type, 'checkbox'); ?>><?php _e('Checkbox', 'wp-shortcode-pro') ?></option>
														<option value="color" <?php selected($type, 'color'); ?>><?php _e('Color', 'wp-shortcode-pro') ?></option>
														<option value="textarea" <?php selected($type, 'textarea'); ?>><?php _e('Textarea', 'wp-shortcode-pro') ?></option>
													</select>
													<span class="description"><?php _e('Field Type', 'wp-shortcode-pro'); ?></span>
												</div>
											</div>
											<div class="wps-field-holder <?php echo esc_attr($option_class); ?>">
												<label><?php _e('Options', 'wp-shortcode-pro'); ?></label>
												<div class="wps-input-wrapper">
													<textarea name="wps_mapper[<?php echo $id; ?>][fields][<?php echo $field_id; ?>][values]" data-field="values" rows="7"><?php echo $values; ?></textarea>
													<span class="description"><?php _e('Seperate options by new line in the following format key: value', 'wp-shortcode-pro'); ?></span>
												</div>
											</div>
											<div class="wps-field-holder">
												<label><?php _e('Default', 'wp-shortcode-pro'); ?></label>
												<div class="wps-input-wrapper">
													<input type="text" name="wps_mapper[<?php echo $id; ?>][fields][<?php echo $field_id; ?>][default]" value="<?php echo $default; ?>" data-field="default">
													<span class="description"><?php _e('Default', 'wp-shortcode-pro'); ?></span>
												</div>
											</div>
											<div class="wps-field-holder">
												<label><?php _e('Description', 'wp-shortcode-pro'); ?></label>
												<div class="wps-input-wrapper">
													<input type="text" name="wps_mapper[<?php echo $id; ?>][fields][<?php echo $field_id; ?>][desc]" value="<?php echo $description; ?>" data-field="description">
													<span class="description"><?php _e('Description', 'wp-shortcode-pro'); ?></span>
												</div>
											</div>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
						<a href="javascript;" class="button button-secondary wps-new-field"><?php _e('Add Field', 'wp-shortcode-pro') ?></a>
					</div>
				<?php } ?>
			</div>
		</li>
		<?php
		return ob_get_clean();
	}

	//Return Mapped shortcodes
	public function wps_mapped_shortcodes() {
		$mapped_shortcodes = get_option('wps_mapper');
		if(!empty($mapped_shortcodes)) {
			self::map($mapped_shortcodes);
		}
		return $mapped_shortcodes;
	}

	//Parse Shortcode AJAX
	function wps_map_shortcode_callback() {
		$shortcode_details = $_POST['shortcode_details'];
		echo self::shortcode_mapper_layout($shortcode_details);
		die;
	}

	//Map Shortcode
	public static function map($new_shortcode = array()) {
		self::$new_shortcodes = array_merge(self::$new_shortcodes,$new_shortcode);
	}

}

// Init the shortcode mapper.
wp_shortcode()->mapper = new WPS_Map;