<?php
/**
 * [$cmb->add_field description]
 * @var [type]
 */

$cmb->add_field( array(
	'id'      => 'wps_connect',
	'type'    => 'title',
	'name'    => esc_html__( 'Please Connect', 'wp-shortcode-pro' ),
	'desc'    => sprintf( __( 'Please install and activate %1$s the latest version of the MyThemeShop Updater plugin %2$s to edit the plugin settings.', 'wp-quiz-pro' ), '<a href="https://mythemeshop.com/plugins/mythemeshop-theme-plugin-updater/" target="_blank">', '</a>' ),
) );