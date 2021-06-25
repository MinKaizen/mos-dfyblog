<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_action( 'cmb2_init', 'cl_add_metabox_post_locker' );
/**
 * Post locker for all post type
 */
function cl_add_metabox_post_locker() {

	$prefix  = '_mts_cl_';
	$lockers = array( '' => esc_html__( 'Select a Locker', 'content-locker' ) ) + cl_get_lockers( null, 'cmb' );

	$cmb = new_cmb2_box( array(
		'id'           => 'cl-content-locker',
		'title'        => esc_html__( 'Override Lockers', 'content-locker' ),
		'object_types' => array_keys( cl_cmb_post_types() ),
		'context'      => 'side',
		'priority'     => 'high',
	));

	$cmb->add_field( array(
		'name'    => sprintf(
			'<i class="fa fa-times-circle-o"></i>%s<p class="cmb2-metabox-description">%s</p>',
			esc_html__( 'Exclude', 'content-locker' ),
			esc_html__( 'Exclude this post from lockers.', 'content-locker' )
		),
		'id'      => $prefix . 'exclude',
		'type'    => 'radio_inline',
		'options' => array(
			'on'  => esc_html__( 'On', 'content-locker' ),
			'off' => esc_html__( 'Off', 'content-locker' ),
		),
		'classes' => 'cmb-split65',
		'default' => 'off',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Locker', 'content-locker' ),
		'id'      => $prefix . 'locker',
		'type'    => 'select',
		'desc'    => esc_html__( 'Override Global Batch Locker', 'content-locker' ),
		'options' => $lockers,
		'classes' => 'no-border',
	));
}
