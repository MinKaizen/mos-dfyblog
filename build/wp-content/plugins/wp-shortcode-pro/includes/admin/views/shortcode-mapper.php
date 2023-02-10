<?php
/**
 * Shortcode Mapper
 */
?>
<div class="wrap wp-shortcode-wrap wp-shortcode-wrap-settings">

	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<form method="post" action="options.php">
		<?php WPS_Map::display_messages(); ?>
		<div class="wp-shortcode-help-content wps-mapper-wrapper">
			<?php settings_fields('wps_map_options'); ?>

			<p class="description wps-description">
				<?php _e('WP Shortcode Mapper adds custom 3rd party vendors shortcodes to the list of WP Shortcodes menu (Note: to map shortcode it needs to be installed on site).', 'wp-shortcode-pro'); ?>
			</p>

			<div class="wps-fields">
				<div class="wps-form-field wp-parse-shortcode-wrapper">
					<div class="wps-input-wrapper">
						<input type="text" name="wps_parse" value="" />
						<span class="description">
						<?php _e('Enter valid shortcode (Example: my_shortcode or [my_shortcode first_param="first_param_value"]My shortcode content[/my_shortcode]).', 'wp-shortcode-pro'); ?>
					</span>
					</div>
					<a class="button button-primary wps-parse-button"><?php _e('Parse', 'wp-shortcode-pro') ?></a>
				</div>
			</div>

			<ul id="wps-mapped-shortcodes" class="wps-fields">
				<?php
				$mapped_shortcodes = wp_shortcode()->mapper->wps_mapped_shortcodes();
				if(!empty($mapped_shortcodes)) {
					foreach($mapped_shortcodes as $shortcode) {
						echo WPS_Map::shortcode_mapper_layout($shortcode);
					}
				}
				?>
			</ul>
		</div>
		<?php submit_button(); ?>
	</form>
</div>