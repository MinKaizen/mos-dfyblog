<?php
/**
 * [$cmb->add_field description]
 * @var [type]
 */

$demo_page = get_option('wps_demo_page');
if($demo_page && get_post_status($demo_page) === 'publish') {
	$demo_content = '<a href="'.esc_url(get_permalink($demo_page)).'" target="_blank" class="button button-secondary">'.__('View Demo', 'wp-shortcode-pro').'</a>';
} else {
	$demo_content = '<a href="#" class="button button-secondary wps-import-demo">'.__('Import demo content', 'wp-shortcode-pro').'</a>';
}

$cmb->add_field( array(
	'id'			=> 'import_settings',
	'type'			=> 'textarea',
	'name'			=> __( 'Import Settings', 'wp-shortcode-pro' ),
	'classes'		=> 'wps-import-settings-field',
	'before_field'	=> '<div class="wps-import-settings wps-action-buttons"><button class="button button-secondary wps-upload-file">'.__('Upload file', 'wp-shortcode-pro').'</button><button class="button button-secondary wps-show-code">'.__('Import from code', 'wp-shortcode-pro').'</button>'.$demo_content.'</div>',
	'after_field'	=> '<input type="file" accept=".json" id="wps-file-import" name="wps-import-file" class=""><button id="wps-import-button" name="wps_import_data" value="import_code" class="button button-primary">'.__('Import', 'wp-shortcode-pro').'</button><input type="hidden" name="wps_import_type" id="wps_import_type" value="import_code" />'
) );

$settings = array();

$settings['presets'] = wp_shortcode()->settings->get_presets();
$settings['mapped_shortcodes'] = wp_shortcode()->settings->get_mapped_shortcodes();
$settings['custom_shortcodes'] = wp_shortcode()->create_shortcode->get_custom_shortcode_details();

if( !empty($settings) ) {
	$settings = wp_json_encode($settings);	
}
$cmb->add_field(array(
	'id' => '',
	'name'	=> __( 'Export Settings', 'wp-shortcode-pro' ),
	'type' => 'multicheck',
	'classes'	=> 'wps-export-settings-field',
	'select_all_button' => false,
	'default' => array('presets', 'shortcodes', 'mapped_shortcodes'),
	'options' => array(
		'presets' => __('Presets', 'wp-shortcode-pro'),
		'shortcodes' => __('Custom Shortcodes', 'wp-shortcode-pro'),
		'mapped_shortcodes' => __('Mapped Shortcodes', 'wp-shortcode-pro'),
	),
	'after_field' => '<div class="wps-export-settings wps-action-buttons"><a href="'.wp_nonce_url( add_query_arg( array( 'action' => 'wps_download_settings', 'export' => 'presets,shortcodes,mapped_shortcodes'), admin_url( 'admin-ajax.php' ) ), 'wps_export' ).'" id="wps-dl-settings" class="button" data-basehref="'.wp_nonce_url( add_query_arg( array( 'action' => 'wps_download_settings' ), admin_url( 'admin-ajax.php' ) ), 'wps_export' ).'">'.esc_html__( 'Download Exported Settings', 'wp-shortcode-pro' ).'</a> <button class="button button-secondary wps-show-code">'.__('Show Export Code', 'wp-shortcode-pro').'</button></div>',
	'after' => '<textarea class="widefat" id="export-wps-settings" rows="10">'.$settings.'</textarea>',
));