<?php
/**
 * Options page
 *
 * @package WP_Review
 */

/**
 * Class WP_Review_Options
 */
class WP_Review_Options {

	/**
	 * Page hook.
	 *
	 * @var string
	 */
	protected $hook;


	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Registers admin menu.
	 */
	public function register_menu() {

		$hide = wp_review_network_option( 'hide_global_options_' );

		if ( ! $hide ) {
			if ( class_exists( 'mts_connection' ) && defined( 'MTS_CONNECT_ACTIVE' ) && MTS_CONNECT_ACTIVE ) {
				$this->hook = add_options_page(
					__( 'WP Review Pro', 'wp-review' ),
					__( 'WP Review Pro', 'wp-review' ),
					'wp_review_global_options',
					'wp-review-pro',
					array( $this, 'render' )
				);

				add_action( "load-{$this->hook}", array( $this, 'load' ) );
			} else {
				$this->hook = add_options_page(
					__( 'WP Review Pro', 'wp-review' ),
					__( 'WP Review Pro', 'wp-review' ),
					'wp_review_global_options',
					'wp-review-pro',
					array( $this, 'render_placeholder' )
				);
			}
		}

	}

	/**
	 * Runs some functions on page load.
	 */
	public function load() {
		add_filter( 'admin_body_class', array( $this, 'admin_body_classes' ) );
	}

	/**
	 * Adds classes to body tag.
	 *
	 * @param  array $classes Body classes.
	 * @return array
	 */
	public function admin_body_classes( $classes ) {
		$classes .= ' wp-review-admin-options';
		return $classes;
	}

	/**
	 * Registers settings.
	 */
	public function register_settings() {

		if ( isset( $_POST['wp_review_capabilities'] ) && ! empty( $_POST['wp_review_capabilities'] ) ) {

			$capabilities = $_POST['wp_review_capabilities'];
			$default_caps = wp_review_get_capabilities();

			foreach ( $capabilities as $role => $capability ) {
				$role = get_role( $role );

				$role_capabilities = $role->capabilities;
				foreach ( $default_caps as $key => $default_cap ) {

					if ( isset( $capability[ $key ] ) ) {
						$role->add_cap( $key );
					} else {
						$role->remove_cap( $key );
					}
				}
			}
		}
		register_setting( 'wpreview-settings-group', 'wp_review_options' );
		register_setting( 'wpreview-settings-group', 'wp_review_popup' );
		register_setting( 'wpreview-settings-group', 'wp_review_hello_bar' );
	}

	/**
	 * Gets options page tabs.
	 *
	 * @return array
	 */
	protected function get_tabs() {
		$tabs_content = array(
			'review'       => array(
				'title'             => __( 'Global', 'wp-review' ),
				'icon'              => 'cogs',
				'capability'        => 'wp_review_global_options',
				'multisite_enabled' => 'hide_global_options_',
			),
			'popup'        => array(
				'title'             => __( 'Popup', 'wp-review' ),
				'icon'              => 'sticky-note',
				'capability'        => 'wp_review_popup',
				'multisite_enabled' => 'hide_general_popup_',
			),
			'hello-bar'    => array(
				'title'             => __( 'Notification Bar', 'wp-review' ),
				'icon'              => 'warning',
				'capability'        => 'wp_review_notification_bar',
				'multisite_enabled' => 'hide_general_bar_',
			),
			'yelp'         => array(
				'title'             => __( 'Yelp Reviews', 'wp-review' ),
				'icon'              => 'yelp',
				'capability'        => 'wp_review_yelp_reviews',
				'multisite_enabled' => 'hide_yelp_reviews_',
			),
			'google'       => array(
				'title'             => __( 'Google Reviews', 'wp-review' ),
				'icon'              => 'google',
				'capability'        => 'wp_review_google_reviews',
				'multisite_enabled' => 'hide_google_reviews_',
			),
			'facebook'     => array(
				'title'             => __( 'Facebook Reviews', 'wp-review' ),
				'icon'              => 'facebook',
				'capability'        => 'wp_review_facebook_reviews',
				'multisite_enabled' => 'hide_facebook_reviews_',
			),
			'role-manager' => array(
				'title'             => __( 'Role Manager', 'wp-review' ),
				'icon'              => 'user',
				'capability'        => 'administrator',
				'multisite_enabled' => 'hide_role_manager_',
			),
			'import'       => array(
				'title'             => __( 'Import Reviews', 'wp-review' ),
				'icon'              => 'download',
				'capability'        => 'wp_review_import_reviews',
				'multisite_enabled' => 'hide_import_',
			),
			'convert-schema' => array(
				'title'             => __( 'Convert schema', 'wp-review' ),
				'icon'              => 'download',
				'capability'        => 'wp_review_convert_schema',
				'multisite_enabled' => 'hide_convert_schema_',
			),
		);

		$tabs = array();

		foreach ( $tabs_content as $key => $tab ) {
			$hide = wp_review_network_option( $tab['multisite_enabled'] );
			if ( current_user_can( $tab['capability'] ) && ! $hide ) {
				$tabs[] = array(
					'id'    => $key,
					'title' => $tab['title'],
					'icon'  => 'fa fa-' . $tab['icon'],
					'view'  => WP_REVIEW_ADMIN . 'options/' . $key . '.php',
				);
			}
		}

		if ( is_multisite() && is_main_site() && current_user_can( 'administrator' ) ) {
			$tabs[] = array(
				'id'    => 'multisite_settings',
				'title' => __( 'Multisite Settings', 'wp-review' ),
				'icon'  => 'fa fa-sitemap',
				'view'  => WP_REVIEW_ADMIN . 'options/multisite.php',
			);
		}
		return $tabs;
	}

	/**
	 * Renders page content.
	 */
	public function render() {
		$tabs = $this->get_tabs();
		?>
		<div class="wrap wp-review">
			<h1><?php esc_html_e( 'WP Review Pro Settings', 'wp-review' ); ?></h1>

			<form method="post" action="options.php">
				<?php settings_fields( 'wpreview-settings-group' ); ?>

				<div id="wpr-global-options" class="wpr-vertical-tabs" data-vertical-tabs>
					<ul class="wpr-vertical-tabs__titles">
						<?php foreach ( $tabs as $tab ) : ?>
							<li class="wpr-vertical-tabs__title"><a href="#<?php echo esc_attr( $tab['id'] ); ?>" data-tab-title><i class="<?php echo esc_html( $tab['icon'] ); ?>"></i> <?php echo esc_html( $tab['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>

					<div class="wpr-vertical-tabs__contents">
						<?php foreach ( $tabs as $tab ) : ?>
							<div id="<?php echo esc_attr( $tab['id'] ); ?>" class="wpr-vertical-tabs__content" data-tab-content>
								<h2><?php echo esc_html( $tab['title'] ); ?></h2>

								<?php include $tab['view']; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<?php submit_button(); ?>
				</div>
			</form>
		</div>

		<?php if ( ! empty( $_GET['tab'] ) ) : ?>
			<script>
				( function( $ ) {
				    "use strict";

				    $( document ).ready( function() {
					    setTimeout( function() {
                            $( '.wpr-vertical-tabs__title a[href="#<?php echo strip_tags( $_GET['tab'] ); ?>"]' ).click();
					    }, 500 );
				    });
				})( jQuery );
			</script>
		<?php endif; ?>

		<?php
	}


	/**
	 * Renders placeholder page content.
	 */
	public function render_placeholder() {
		$url    = 'https://mythemeshop.com/plugins/mythemeshop-theme-plugin-updater/';
		$target = '_blank';
		$plugin = 'mythemeshop-connect/mythemeshop-connect.php';
		if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
			$url    = wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=mythemeshop-connect/mythemeshop-connect.php&plugin_status=all&paged=1&s' ), 'activate-plugin_' . $plugin );
			$target = '';
		}
		?>
		<div class="wrap wp-review">
			<h1><?php esc_html_e( 'WP Review Pro Settings', 'wp-review' ); ?></h1>
			<p>
				<?php
				// translators: %1$s: open link tag, %2$s: close link tag.
				printf( __( 'Please install and activate %1$s the latest version of the MyThemeShop Updater plugin %2$s to edit the plugin settings.', 'wp-review' ), '<a href="' . $url . '" target="' . $target . '">', '</a>' );
				?>
			</p>
		</div>
		<?php

	}
}

$page = new WP_Review_Options();
$page->init();
