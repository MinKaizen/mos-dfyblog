<?php
/**
 * General Options Metabox
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_action( 'cmb2_init', 'cl_add_metabox_basic_options' );
function cl_add_metabox_basic_options() {

	$prefix = '_mts_cl_';
	$item   = cl_get_item_type( null );

	$default_header = $default_message = $themes = $theme_default = '';
	switch ( $item ) {
		case 'social-locker':
			$default_header  = esc_html__( 'This content is locked!', 'content-locker' );
			$default_message = esc_html__( 'Please support us, use one of the buttons below to unlock the content.', 'content-locker' );
			$theme_default   = 'flat';
			break;

		case 'signin-locker':
			$default_header  = esc_html__( 'Sign In To Unlock This Content', 'content-locker' );
			$default_message = esc_html__( 'Please sign in. It\'s free. Just click one of the buttons below to get instant access.', 'content-locker' );
			$theme_default   = 'great-attractor';
			break;
	}

	$cmb = new_cmb2_box( array(
		'id'           => 'cl-basic-options',
		'title'        => esc_html__( 'Basic Options', 'content-locker' ),
		'object_types' => array( 'content-locker' ),
		'context'      => 'normal',
		'priority'     => 'default',
		'classes'      => 'convert-to-tabs',
	));

	$cmb->add_field( array(
		'name'    => esc_html__( 'Locker Box Title', 'content-locker' ),
		'id'      => $prefix . 'header',
		'type'    => 'text',
		'desc'    => esc_html__( 'Add locker box title which attracts attention. You can leave this field empty.', 'content-locker' ),
		'default' => $default_header,
	));

	$cmb->add_field( array(
		'name'    => esc_html__( 'Locker Message', 'content-locker' ),
		'id'      => $prefix . 'message',
		'type'    => 'wysiwyg',
		'desc'    => wp_kses_post( __( 'Add message which will appear under the title.', 'content-locker' ) ), // <br />Shortcodes: [post_title], [post_url].
		'options' => array( 'textarea_rows' => '6' ),
		'default' => $default_message,
	));

	$cmb->add_field( array(
		'name'       => esc_html__( 'Theme', 'content-locker' ),
		'id'         => $prefix . 'theme',
		'type'       => 'select',
		'desc'       => esc_html__( 'Choose a theme for Locker Box.', 'content-locker' ),
		'options_cb' => 'cl_choices_locker_themes',
		'classes'    => 'cl-theme-preview',
		'default'    => $theme_default,
	));

	$cmb->add_field( array(
		'name'       => esc_html__( 'Button Layout', 'content-locker' ),
		'id'         => $prefix . 'layout',
		'type'       => 'radio_inline',
		'desc'       => esc_html__( 'Choose button layout from here.', 'content-locker' ),
		'options'    => array(
			'horizontal' => esc_html__( 'Horizontal', 'content-locker' ),
			'vertical'   => esc_html__( 'Vertical', 'content-locker' ),
		),
		'classes'    => 'no-border',
		'default'    => 'horizontal',
		'show_on_cb' => function() {
			return 'social-locker' == cl_get_item_type() ? true : false;
		},
	));

	$cmb->add_field( array(
		'name'    => esc_html__( 'Overlap Mode', 'content-locker' ),
		'id'      => $prefix . 'overlap_mode',
		'type'    => 'radio_inline',
		'desc'    => esc_html__( 'Choose the way how your locker should lock the content.', 'content-locker' ),
		'options' => array(
			'full'         => esc_html__( 'Full (classic)', 'content-locker' ),
			'transparency' => esc_html__( 'Transparency', 'content-locker' ),
			'blurring'     => esc_html__( 'Blurring', 'content-locker' ),
		),
		'classes' => 'no-border',
		'default' => 'full',
	));

	$cmb->add_field( array(
		'id'      => $prefix . 'overlap_position',
		'type'    => 'select',
		'options' => array(
			'middle' => esc_html__( 'Middle', 'content-locker' ),
			'top'    => esc_html__( 'Top', 'content-locker' ),
			'scroll' => esc_html__( 'Scrolling', 'content-locker' ),
		),
		'classes' => 'overlap-mode-changer hidden no-border',
		'default' => 'middle',
	));

	$cmb->add_field( array(
		'id'         => $prefix . 'item_type',
		'type'       => 'hidden',
		'default'    => $item,
		'column'     => array(
			'position' => 2,
			'name'     => esc_html__( 'Shortcode', 'content-locker' ),
		),
		'display_cb' => 'cl_display_locker_shortcode',
	));
}

/**
 * Render the shortcode field for the locker in thelist view
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 * @return void
 */
function cl_display_locker_shortcode( $field_args, $field ) {

	if ( '' === $field->escaped_value() ) {
		return;
	}

	$shortcode = str_replace( '-', '', $field->escaped_value() );
	printf( '<input class="mts-cl-shortcode code regular-text" readonly="readonly" type="text" value=\'[%1$s id="%2$d"][/%1$s]\'>', $shortcode, $field->object_id );
	printf( '<button type="button" class="button copy-list-shortcode-field dashicons-before dashicons-clipboard"></button>' );
}

/**
 * Display different options basedon locker type
 *
 * @param  object $field      Current field object
 * @return array              Array of field options
 */
function cl_choices_locker_themes( $field ) {

	$item = cl_get_item_type( null );

	if ( 'signin-locker' === $item ) {
		return array(
			'great-attractor' => esc_html__( 'Great Attractor', 'content-locker' ),
			'big-emboss'      => esc_html__( 'Big Emboss', 'content-locker' ),
			'big-icon'        => esc_html__( 'Big Icon', 'content-locker' ),
			'dark-force'      => esc_html__( 'Dark Force', 'content-locker' ),
			'signin-flat'     => esc_html__( 'Flat', 'content-locker' ),
			'friendly-giant'  => esc_html__( 'Friendly Giant', 'content-locker' ),
			'grey-emboss'     => esc_html__( 'Grey Emboss', 'content-locker' ),
			'mast'            => esc_html__( 'Mast', 'content-locker' ),
		);
	}

	// Social Locker
	return array(
		'flat'       => esc_html__( 'Flat', 'content-locker' ),
		'circular'   => esc_html__( 'Circular', 'content-locker' ),
		'drawer'     => esc_html__( 'Drawer', 'content-locker' ),
		'glass'      => esc_html__( 'Glass', 'content-locker' ),
		'old-school' => esc_html__( 'Old School', 'content-locker' ),
		'slide-me'   => esc_html__( 'Slide Me', 'content-locker' ),
		'square'     => esc_html__( 'Square', 'content-locker' ),
		'starter'    => esc_html__( 'Starter', 'content-locker' ),
	);
}
