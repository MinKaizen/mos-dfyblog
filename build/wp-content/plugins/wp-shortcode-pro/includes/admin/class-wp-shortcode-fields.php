<?php
/**
 * Shortcode Fields
 */
class WPS_Fields {

	function __construct() {}

	public static function text( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value" />';
		return $return;
	}

	public static function hidden( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value" />';
		return $return;
	}

	public static function date( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value widefat wps-datepicker" />';
		return $return;
	}

	public static function time( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="time" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value widefat" />';
		return $return;
	}

	public static function editor( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'rows'    => 3,
			'default' => ''
		) );
		ob_start();
		wp_editor(esc_textarea( $field['default'] ), 'wps-field-value-' . $id, array(
					'textarea_name'	=>	'wp-shortcode-content',
					'teeny'			=>	true,
					'textarea_rows'	=>	5,
					'wpautop'		=>	false,
					'media_buttons' =>	false,
					'quicktags'		=>	false,
					'tinymce'		=>	array (
							'theme_advanced_buttons1' => 'formatselect,|,bold,italic,|,' .
							'bullist,blockquote,|,justifyleft,justifycenter' .
							',justifyright,justifyfull,|,link,unlink,|' .
							',spellchecker,wp_fullscreen,wp_adv'
						)
					));
		return ob_get_clean();
	}

	public static function textarea( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'rows'	=> 3,
			'default' => ''
		) );
		$return = '<textarea name="' . $id . '" id="wps-field-value-' . $id . '" rows="' . $field['rows'] . '" class="wps-field-value">' . esc_textarea( $field['default'] ) . '</textarea>';
		return $return;
	}

	public static function select( $id, $field ) {
		$multiple = ( isset( $field['multiple'] ) ) ? ' multiple' : '';
		$return = '<select name="' . $id . '" id="wps-field-value-' . $id . '" class="wps-field-value"' . $multiple . '>';

		foreach ( $field['values'] as $option_value => $option_title ) {
			$selected = ( $field['default'] === $option_value ) ? ' selected="selected"' : '';
			$return .= '<option value="' . $option_value . '"' . $selected . '>' . $option_title . '</option>';
		}
		$return .= '</select>';
		return $return;
	}

	public static function radio( $id, $field ) {
		foreach ( $field['values'] as $option_value => $option_title ) {
			$checked = ( $field['default'] === $option_value ) ? ' checked="checked"' : '';
			$return .= '<label><input type="radio" class="wps-field-value" name="'.$id.'" value="'.$option_value.'" '.$checked.' />'.$option_title.'</label>';
		}
		return $return;
	}

	public static function checkbox( $id, $field ) {
		$return = '<div class="wps-field-value wps_is_checkbox">';
		foreach ( $field['values'] as $option_value => $option_title ) {
			$checked = ( $field['default'] === $option_value ) ? ' checked="checked"' : '';
			$return .= '<label><input type="checkbox" name="'.$id.'" value="'.$option_value.'" '.$checked.' />'.$option_title.'</label>';
		}
		$return .= '</div>';
		return $return;
	}

	public static function post_type( $id, $field ) {
		$types = get_post_types( array('public' => true, 'publicly_queryable' => true), 'objects', 'or' );
		$field['values'] = array();
		foreach( $types as $type ) {
			if($type->name !== 'attachment') {
				$field['values'][$type->name] = $type->label;
			}
		}
		return self::select( $id, $field );
	}

	public static function taxonomy( $id, $field ) {
		$taxonomies = get_taxonomies( array( 'public' => true, 'show_ui' => true ), 'objects', 'and' );
		$field['values'] = array();
		foreach( $taxonomies as $taxonomy ) {
			$field['values'][$taxonomy->name] = $taxonomy->label;
		}
		return self::select( $id, $field );
	}

	public static function term( $id, $field ) {
		$field['values'] = wp_shortcode()->tools->get_terms( 'category' );
		return self::select( $id, $field );
	}

	public static function button_set( $id, $field ) {
		$return = '';
		ob_start();
		$field['values'] = !empty($field['values']) ? $field['values'] : array('no', 'yes');
		$return .= '<div class="wps-buttonset-wrapper">';
			foreach( $field['values'] as $key => $field_value ) {
				$return .= '<input type="radio" id="'.esc_attr(strtolower($field['name']).'-'.$key).'" name="'.esc_attr(strtolower($id)).'" '. checked( $field['default'], $key, false ) .' value="'.esc_attr($key).'" class="wps-field-value" />'
						. '<label for="'.esc_attr(strtolower($field['name']).'-'.$key).'">'. esc_html($field_value) .'</label>';
			}
		$return .= '</div>';
		return $return;
	}

	public static function upload( $id, $field ) {
		$return = '<div class="wps-media-wrapper"><input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value wp-shortcode-upload-value" />'
				. '<div class="wp-shortcode-field-actions">'
					. '<a href="javascript:;" class="button wp-shortcode-upload-button" title="' . __( 'Media manager', 'wp-shortcode-pro' ) . '">'
						. '<span class="fa fa-camera"></span>'
					. '</a>'
				. '</div></div>';
		return $return;
	}

	public static function icon( $id, $field, $show_media = true ) {
		$media_text = $show_media ? '<a href="javascript:;" class="button wp-shortcode-upload-button wp-shortcode-field-action" title="' . __( 'Media manager', 'wp-shortcode-pro' ) . '"><i class="fa fa-camera"></i></a>' : '';
		$return = '<div class="wps-media-wrapper">
					<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value wps-icon-picker-value" />'
				. '<div class="wp-shortcode-field-actions">'
					. $media_text
					. '<a href="javascript:;" class="button wps-icon-picker-button wp-shortcode-field-action" title="' . __( 'Icon picker', 'wp-shortcode-pro' ) . '">'
						. '<i class="fa fa-font-awesome"></i>'
					. '</a>'
				. '</div>'
				. '<div class="wps-icon-picker">'
					. '<input type="text" class="widefat" placeholder="' . __( 'Filter icons', 'wp-shortcode-pro' ) . '" />'
				. '</div></div>';
		return $return;
	}

	public static function color( $id, $field ) {
		$return = '<span class="wp-shortcode-select-color">'
				. '<input type="text" name="' . $id . '" value="' . $field['default'] . '" id="wps-field-value-' . $id . '" class="wps-field-value wps-color-picker" />'
				. '</span>';
		return $return;
	}

	public static function number( $id, $field ) {
		$return = '<input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="wps-field-value" />';
		return $return;
	}

	public static function slider( $id, $field ) {
		$return = '<div class="wps-range-picker">'
				. '<div class="wps-admin-slider"></div>'
				. '<input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="wps-field-value" />'
				. '</div>';
		return $return;
	}

	public static function shadow( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? '' : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$return = '<div class="wp-shortcode-shadow-picker">'
				. '<span class="wps-sp-field">'
				. '<input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="wps-shadow-horizontal" />'
				. '<small>' . __( 'Horizontal offset', 'wp-shortcode-pro' ) . ' (px)</small>'
				. '</span>'
				. '<span class="wps-sp-field">'
				. '<input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="wps-shadow-vertical" />'
				. '<small>' . __( 'Vertical offset', 'wp-shortcode-pro' ) . ' (px)</small>'
				. '</span>'
				. '<span class="wps-sp-field">'
				. '<input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="wps-shadow-blur" />'
				. '<small>' . __( 'Blur', 'wp-shortcode-pro' ) . ' (px)</small>'
				. '</span>'
				. '<span class="wps-sp-field wp-shortcode-shadow-picker-color">'
				. '<span class="wp-shortcode-shadow-picker-color-wheel"></span>'
				. '<input type="text" value="' . $defaults[3] . '" class="wps-color-picker" />'
				. '<small>' . __( 'Color', 'wp-shortcode-pro' ) . '</small>'
				. '</span>'
				. '<input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value" />'
				. '</div>';
		return $return;
	}

	public static function border( $id, $field ) {
		$defaults = ( $field['default'] === '' ) ? array ( '0', 'solid', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$borders = wp_shortcode()->tools->select( array(
				'options' => wp_shortcode()->list->borders(),
				'class' => 'wps-border-style',
				'selected' => $defaults[1]
			) );
		$return = '<div class="wp-shortcode-border-picker">'
					. '<span class="wps-bp-field">'
						. '<input type="number" min="0" max="1000" step="1" value="' . $defaults[0] . '" class="wps-border-width" />'
						. '<small>' . __( 'Border width', 'wp-shortcode-pro' ) . ' (px)</small>'
					. '</span>'
					. '<span class="wps-bp-field">'
						. $borders
						. '<small>' . __( 'Border style', 'wp-shortcode-pro' ) . '</small>'
					. '</span>'
					. '<span class="wps-bp-field wp-shortcode-border-picker-color">'
						. '<input type="text" value="' . $defaults[2] . '" class="wps-color-picker" />'
						. '<small>' . __( 'Border color', 'wp-shortcode-pro' ) . '</small>'
					. '</span>'
					. '<input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value" />'
				. '</div>';
		return $return;
	}

	public static function image_source( $id, $field ) {
		$field = wp_parse_args( $field, array( 'default' => 'none' ) );
		$sources = wp_shortcode()->tools->select( array(
				'options'  => array(
					'media'			=> __( 'Media library', 'wp-shortcode-pro' ),
					'posts-recent'	=> __( 'Recent posts', 'wp-shortcode-pro' ),
					'category'		=> __( 'Category', 'wp-shortcode-pro' ),
					'taxonomy'		=> __( 'Taxonomy', 'wp-shortcode-pro' )
				),
				'selected'	=> '0',
				'none'		=> __( 'Select images source', 'wp-shortcode-pro' ) . '&hellip;',
				'class'		=> 'wps-images-sources'
			) );
		$categories = wp_shortcode()->tools->select( array(
				'options'	=> wp_shortcode()->tools->get_terms( 'category' ),
				'multiple'	=> true,
				'size'		=> 10,
				'class'		=> 'wps-images-categories'
			) );
		$taxonomies = wp_shortcode()->tools->select( array(
				'options'	=> wp_shortcode()->tools->get_taxonomies(),
				'none'		=> __( 'Select taxonomy', 'wp-shortcode-pro' ) . '&hellip;',
				'selected'	=> '0',
				'class'		=> 'wps-images-taxonomies'
			) );
		$terms = wp_shortcode()->tools->select( array(
				'class'		=> 'wps-images-terms',
				'multiple'	=> true,
				'size'		=> 10,
				'disabled'	=> true,
				'style'		=> 'display:none'
			) );
		$return = '<div class="wps-images">' . $sources . '<div class="wps-images-source wps-images-source-media"><div><a href="javascript:;" class="button button-primary wps-images-add-media"><i class="fa fa-plus"></i>&nbsp;&nbsp;' . __( 'Add images', 'wp-shortcode-pro' ) . '</a></div><div class="wps-images-images"><em class="description">' . __( 'Click the button above and select images.<br>You can select multimple images with Ctrl (Cmd) key', 'wp-shortcode-pro' ) . '</em></div></div><div class="wps-images-source wps-images-source-category"><em class="description">' . __( 'Select categories to retrieve posts from.<br>You can select multiple categories with Ctrl (Cmd) key', 'wp-shortcode-pro' ) . '</em>' . $categories . '</div><div class="wps-images-source wps-images-source-taxonomy"><em class="description">' . __( 'Select taxonomy and it\'s terms.<br>You can select multiple terms with Ctrl (Cmd) key', 'wp-shortcode-pro' ) . '</em>' . $taxonomies . $terms . '</div><input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="wps-field-value-' . $id . '" class="wps-field-value" /></div>';
		return $return;
	}

	public static function geocomplete( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => '',
			'multiple' => false
		) );
		ob_start();
		?>
		<div class="wps-addresses">
			<div class="wps-inner-wrapper">
				<input type="text" name="" value="<?php echo esc_attr( $field['default'] ) ?>" class="wps-geocomplete" placeholder="<?php _e('Enter Address', 'wp-shortcode-pro'); ?>" />
			</div>
			<?php if($field['multiple']) { ?>
				<button class="button-primary alignright" id="wps-add-address"><?php _e('Add', 'wp-shortcode-pro'); ?></button>
			<?php } ?>
			<input type="hidden" name="<?php echo esc_attr($id) ?>" class="wps-field-value geo-details" />
		</div>
		<?php
		return ob_get_clean();
	}

	public static function table( $id, $field ) {
		$field = wp_parse_args( $field, array( 'default' => '' ) );
		ob_start();
	?>
		<div class="wps-table-field">
			<table class="widefat" border="1">
				<thead>
					<tr>
						<th class="wps-table-action">
							<a href="#" class="wps-add-row" title="<?php _e('Add row', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-plus"></i>
							</a>
						</th>
						<th class="wps-sort-row"><span contenteditable="true">Column 1</span> <a href="#" class="wps-remove-column" title="<?php _e('Remove column', 'wp-shortcode-pro'); ?>"><i class="fa fa-minus"></i></a></th>
						<th class="wps-sort-row"><span contenteditable="true">Column 2</span> <a href="#" class="wps-remove-column" title="<?php _e('Remove column', 'wp-shortcode-pro'); ?>"><i class="fa fa-minus"></i></a></th>
						<th class="wps-sort-row"><span contenteditable="true">Column 3</span> <a href="#" class="wps-remove-column" title="<?php _e('Remove column', 'wp-shortcode-pro'); ?>"><i class="fa fa-minus"></i></a></th>
						<th class="wps-sort-row"><span contenteditable="true">Column 4</span> <a href="#" class="wps-remove-column" title="<?php _e('Remove column', 'wp-shortcode-pro'); ?>"><i class="fa fa-minus"></i></a></th>
						<th class="wps-table-action">
							<a href="#"  class="wps-add-column" title="<?php _e('Add column', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-plus"></i>
							</a>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="wps-sort-row">Row 1</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td class="wps-table-action">
							<a href="#" class="wps-remove-row" title="<?php _e('Remove row', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-minus"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td class="wps-sort-row">Row 2</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td class="wps-table-action">
							<a href="#" class="wps-remove-row" title="<?php _e('Remove row', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-minus"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td class="wps-sort-row">Row 3</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td class="wps-table-action">
							<a href="#" class="wps-remove-row" title="<?php _e('Remove row', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-minus"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td class="wps-sort-row">Row 4</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td class="wps-table-action">
							<a href="#" class="wps-remove-row" title="<?php _e('Remove row', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-minus"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td class="wps-sort-row">Row 5</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td contenteditable="true">Lorem ipsum</td>
						<td contenteditable="true">Cras sed</td>
						<td class="wps-table-action">
							<a href="#" class="wps-remove-row" title="<?php _e('Remove row', 'wp-shortcode-pro'); ?>">
								<i class="fa fa-minus"></i>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
		return ob_get_clean();
	}

	public static function extra_css_class( $id, $field ) {
		$field = wp_parse_args( $field, array( 'default' => '' ) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="wps-field-value-' . $id . '" class="wps-field-value" />';
		return $return;
	}
}