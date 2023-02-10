<?php
/**
 * [$cmb->add_field description]
 * @var [type]
 */

$cmb->add_field( array(
	'id'      => 'wps_prefix',
	'type'    => 'text',
	'name'    => esc_html__( 'Shortcodes Prefix', 'wp-shortcode-pro' ),
	'desc'    => esc_html__( 'This prefix will be used in shortcode names. For example: set MY_ prefix and shortcodes will look like [MY_button]. Please note that this setting does not change shortcodes that have been inserted earlier. Change this setting very carefully.', 'wp-shortcode-pro' ),
	'default' => 'wps_',
	'classes' => 'wp-shortcode-prefix',
) );

$cmb->add_field( array(
	'id'      => 'gm_api_key',
	'type'    => 'text',
	'name'    => esc_html__( 'Google Map API Key', 'wp-shortcode-pro' ),
	'desc'    => esc_html__( 'A Google Maps API Key is required to be able to show the maps.', 'wp-shortcode-pro' ),
	'classes' => 'wp-shortcode-prefix',
) );

$cmb->add_field( array(
	'id'      => 'wps_css_code',
	'type'    => 'textarea',
	'name'    => esc_html__( 'Custom CSS Code', 'wp-shortcode-pro' ),
	'desc'    => esc_html__( 'In this field you can write your custom CSS code for shortcodes.', 'wp-shortcode-pro' ),
	'classes' => 'wp-shortcode-css',
) );