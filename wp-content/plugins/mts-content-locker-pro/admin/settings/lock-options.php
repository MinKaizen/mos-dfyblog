<?php
/**
 * The file contains common locking settings for the plugin.
 */
$cmb->add_field( array(
	'name' => '<i class="fa fa-lock"></i>' . esc_html__( 'Lock Options', 'content-locker' ),
	'id' => 'settings-lock-tab',
	'type' => 'section',
	'render_row_cb' => 'cl_cmb_tab_open_tag',
) );

$cmb->add_field( array(
	'id' => 'settings-lock-hint',
	'desc' => esc_html__( 'Options linked with the locking feature. Don\'t change the options here if you are not sure that you do.', 'content-locker' ),
	'type' => 'title',
	'render_row_cb' => 'cl_cmb_alert',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Debug', 'content-locker' ),
	'id' => 'debug',
	'type' => 'radio_inline',
	'desc' => esc_html__( 'If this option turned on, the plugin displays information about why the locker is not visible.', 'content-locker' ),
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Pass Code', 'content-locker' ),
	'id' => 'passcode',
	'type' => 'text',
	'desc' => esc_html__( 'Optional. When the pass code is contained in your website URL, the locked content gets automatically unlocked.', 'content-locker' ) . sprintf( '<strong class="passcode-example" data-url="%s"></strong>', home_url( '/' ) ),
	'classes' => 'no-border',
) );

$cmb->add_field( array(
	'name' => wp_kses_post( __( 'Permanent Unlock<br />For Pass Code', 'content-locker' ) ),
	'id' => 'permanent_passcode',
	'type' => 'radio_inline',
	'desc' => wp_kses_post( __( 'Optional. If On, your lockers will be revealed forever if the user once opened the page URL with the Pass Code.<br />Otherwise your lockers will be unlocked only when the page URL contains the Pass Code.', 'content-locker' ) ),
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => wp_kses_post( __( 'Session Duration<br />(in secs)', 'content-locker' ) ),
	'id' => 'session_duration',
	'type' => 'text_small',
	'desc' => esc_html__( 'Optional. The session duration used in the advanced Visiblity Options. The default value 900 seconds (15 minutes).', 'content-locker' ),
	'default' => '900',
	'classes' => 'no-border',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Session Freezing', 'content-locker' ),
	'id' => 'session_freezing',
	'type' => 'radio_inline',
	'desc' => esc_html__( 'Optional. If On, the length of users sessions is fixed, by default the sessions are prolonged automatically every time when a user visits your website for a specified value of the session duration.', 'content-locker' ),
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Interrelation', 'content-locker' ),
	'id' => 'interrelation',
	'type' => 'radio_inline',
	'desc' => wp_kses_post( __( 'Set On to make lockers interrelated. When one of the interrelated lockers are unlocked on your site, the others will be unlocked too.<br />Recommended to turn on, if you use the Batch Locking feature.', 'content-locker' ) ),
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => wp_kses_post( __( 'Locked content<br />is visible in RSS feeds', 'content-locker' ) ),
	'id' => 'rss',
	'type' => 'radio_inline',
	'desc' => esc_html__( 'Set On to make locked content visible in RSS feed.', 'content-locker' ),
	'classes' => 'no-border',
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Actual URLs by default', 'content-locker' ),
	'id' => 'actual_urls',
	'type' => 'radio_inline',
	'desc' => wp_kses_post( __( 'Optional. If you do not set explicitly URLs to like/share in the settings of social buttons, then by default the plugin will use an URL of the page where the locker is located.<br />Turn on this option to extract URLs to like/share from an address bar of the user browser, saving all query arguments. By default (when this option disabled) permalinks are used.', 'content-locker' ) ),
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Advanced Options', 'content-locker' ),
	'id' => 'settings-lock-advance-hint',
	'type' => 'hint',
	'desc' => esc_html__( 'Please don\'t change these options if everything works properly.', 'content-locker' ),
	'render_row_cb' => 'cl_cmb_alert',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'I use a dynamic theme', 'content-locker' ),
	'id' => 'dynamic_theme',
	'type' => 'radio_inline',
	'desc' => esc_html__( 'If your theme loads pages dynamically via ajax, set "On" to get the lockers working (if everything works properly, don\'t turn on this option).', 'content-locker' ),
	'classes' => 'no-border',
	'options' => array(
		'on' => esc_html__( 'On', 'content-locker' ),
		'off' => esc_html__( 'Off', 'content-locker' ),
	),
	'default' => 'off',
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Creater Trigger', 'content-locker' ),
	'id' => 'managed_hook',
	'type' => 'text_medium',
	'desc' => esc_html__( 'Optional. Set any jQuery trigger bound to the root document to create lockers. By default lockers are created on loading a page.', 'content-locker' ),
) );

$cmb->add_field( array(
	'name' => esc_html__( 'Alt Overlap Mode', 'content-locker' ),
	'id' => 'alt_overlap_mode',
	'type' => 'select',
	'desc' => esc_html__( 'This overlap mode will be applied for browsers which don\'t support the blurring effect.', 'content-locker' ),
	'classes' => 'no-border',
	'options' => array(
		'full' => esc_html__( 'Classic (full)', 'content-locker' ),
		'transparency' => esc_html__( 'Transparency', 'content-locker' ),
	),
	'default' => 'transparency',
) );

$cmb->add_field( array(
	'name' => wp_kses_post( __( 'Content Visibility<br />On Loading', 'content-locker' ) ),
	'id' => 'content_visibility',
	'type' => 'select',
	'desc' => esc_html__( 'By default if the blurring or transparent mode is used, the content may be visible during a short time before the locker appears. On other side, the classic mode is used, the locked content is hidden by default on loading. Change this option to manage content visibility when a page loads.', 'content-locker' ),
	'options' => array(
		'auto' => esc_html__( 'Auto', 'content-locker' ),
		'always_hidden' => esc_html__( 'Hidden On Loading', 'content-locker' ),
		'always_visible' => esc_html__( 'Visible On Loading', 'content-locker' ),
	),
	'default'   => 'auto',
) );

$cmb->add_field( array(
	'name' => wp_kses_post( __( 'Timeout of waiting<br />loading the locker (ms)', 'content-locker' ) ),
	'id' => 'timeout',
	'type' => 'text_small',
	'desc' => esc_html__( 'The use can have browser extensions which block loading scripts from social networks. If the social buttons have not been loaded within the specified timeout, the locker shows the error (in the red container) alerting about that a browser blocks loading of the social buttons.', 'content-locker' ),
	'default'   => '20000',
) );

$cmb->add_field( array(
	'id' => 'settings-lock-tab-close',
	'type' => 'section_end',
	'render_row_cb' => 'cl_cmb_tab_close_tag',
) );
