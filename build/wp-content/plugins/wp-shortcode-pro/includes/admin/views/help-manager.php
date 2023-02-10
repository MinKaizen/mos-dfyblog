<?php
/**
 * Help Manager
 */
$tabs = wp_shortcode_filter( 'help_content', array(
	'getting-started' => array(
		'title' => esc_html__( 'Getting started', 'wp-shortcode-pro' ),
		'view'  => 'help/getting-started.php',
	),
	'advance-usage'   => array(
		'title' => esc_html__( 'Advanced Usage', 'wp-shortcode-pro' ),
		'view'  => 'help/advance-usage.php',
	),
	'support' => array(
		'title' => esc_html__( 'Support', 'wp-shortcode-pro' ),
		'view'  => 'help/support.php',
	),
));
?>
<div class="wrap wp-shortcode-wrap wp-shortcode-wrap-settings">

	<h1><?php esc_html_e( 'Help &amp; Support', 'wp-shortcode-pro' ); ?></h1>

	<div class="wp-shortcode-tab-wrapper wp-clearfix">
		<?php foreach ( $tabs as $id => $tab ) : ?>
		<a href="#help-panel-<?php echo $id; ?>"><?php echo $tab['title']; ?></a>
		<?php endforeach; ?>
	</div>

	<div class="wp-shortcode-help-content">
		<?php foreach ( $tabs as $id => $tab ) : ?>
		<div id="help-panel-<?php echo $id; ?>" class="wp-shortcode-setting-panel">
			<?php include $tab['view']; ?>
		</div>
		<?php endforeach; ?>
	</div>

</div>