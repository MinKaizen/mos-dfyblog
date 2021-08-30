<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_action( 'cmb2_init', 'cl_add_metabox_social_options' );
/**
 * Social locker options Metabox
 */
function cl_add_metabox_social_options() {

	$cmb = new_cmb2_box( array(
		'id'           => 'cl-social-options',
		'title'        => esc_html__( 'Social Options', 'content-locker' ),
		'object_types' => array( 'content-locker' ),
		'context'      => 'normal',
		'priority'     => 'default',
		'classes'      => 'convert-to-tabs',
		'show_on_cb'   => function() {
			return 'social-locker' == cl_get_item_type() ? true : false;
		},
	) );

	$cmb->add_field( array(
		'id'   => '_mts_cl_button_order',
		'type' => 'hidden',
	) );

	$cmb->add_field( array(
		'name'    => '<strong>' . esc_html__( 'Hint:', 'content-locker' ) . '</strong> ' . esc_html__( 'Drag and drop the tabs to change the order of the buttons.', 'content-locker' ),
		'id'      => '_mts_cl_show_counters',
		'type'    => 'radio_inline',
		'desc'    => esc_html__( 'Show counters', 'content-locker' ),
		'options' => array(
			'on'  => esc_html__( 'On', 'content-locker' ),
			'off' => esc_html__( 'Off', 'content-locker' ),
		),
		'default' => 'on',
		'classes' => 'no-border cmb-split50 cmb-th-left cmb-td-right',
	) );

	$cmb->add_field( array(
		'id'            => 'social-options-tabs',
		'type'          => 'tabs',
		'sortable'      => true,
		'order_id'      => '_mts_cl_button_order',
		'render_row_cb' => 'cl_cmb_tabs_open_tag',
	) );

	$order = array( 'facebook_like', 'twitter_tweet', 'google_plus', 'facebook_share', 'twitter_follow', 'google_share', 'youtube_subscribe', 'linkedin_share' );
	if ( $post_order = get_post_meta( $cmb->object_id, '_mts_cl_button_order', true ) ) {
		$post_order = explode( ',', str_replace( '-', '_', $post_order ) );
		$order      = array_unique( array_merge( $post_order, $order ) );
	}

	foreach ( $order as $func ) {
		$func = "cl_social_option_{$func}";

		if ( function_exists( $func ) ) {
			$func( $cmb );
		}
	}

	$cmb->add_field( array(
		'id'            => 'social-options-tabs-close',
		'type'          => 'tabs',
		'render_row_cb' => 'cl_cmb_tabs_close_tag',
	) );
}

/**
 * Facebook Like Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_facebook_like( $cmb ) {

	$prefix = '_mts_cl_facebook_like_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-facebook-square"></i>' . esc_html__( 'Like', 'content-locker' ),
		'id'            => 'facebook-like',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'facebook-like',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'on',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'URL to like', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => esc_html__( 'Optional, set an URL (a facebook page or website page link) which user has to like in order to unlock the content. Leave this field empty to use an URL of the page where the locker will be located.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional, a title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'like',
		) );

	$cmb->add_field( array(
		'id'            => 'fb_like_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Twitter Tweet Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_twitter_tweet( $cmb ) {

	$prefix = '_mts_cl_tweet_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-twitter-square"></i>' . esc_html__( 'Tweet', 'content-locker' ),
		'id'            => 'twitter-tweet',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'twitter-tweet',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'on',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'URL to tweet', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => esc_html__( 'Optional, set an URL which user has to tweet in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'Tweet', 'content-locker' ),
			'id'   => $prefix . 'text',
			'type' => 'textarea_small',
			'desc' => esc_html__( 'Optional, type a message to tweet. Leave this field empty to use default "Page title + URL". Also you can use the shortcode [post_title] in order to automatically insert a post title.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Double Check', 'content-locker' ),
			'id'      => $prefix . 'auth',
			'type'    => 'radio_inline',
			'desc'    => esc_html__( 'Optional. Checks whether the user actually has tweeted or not. Requires the user to authorize the MyThemeShop app.', 'content-locker' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default' => 'off',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'Via', 'content-locker' ),
			'id'   => $prefix . 'via',
			'type' => 'text',
			'desc' => esc_html__( 'Optional, Twitter user name to attribute the Tweet to (without @).', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional, a title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'tweet',
		) );

	$cmb->add_field( array(
		'id'            => 'tweet_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Google Plus Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_google_plus( $cmb ) {

	$prefix = '_mts_cl_google_plus_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-google-plus-square"></i>' . esc_html__( '+1', 'content-locker' ),
		'id'            => 'google-plus',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'google-plus',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'on',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'URL to +1', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => esc_html__( 'Optional, set an URL which user has to +1 in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional, title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => '+1 us',
		) );

	$cmb->add_field( array(
		'id'            => 'google_plus_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Facebook Share Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_facebook_share( $cmb ) {

	$prefix = '_mts_cl_facebook_share_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-facebook"></i>' . esc_html__( 'Share', 'content-locker' ),
		'id'            => 'facebook-share',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

	if ( $errors = cl_cmb_facebook_errors() ) {
		$url = cl_get_admin_url( 'settings#facebook_appid' );
		$cmb->add_field( array(
			'id'            => $prefix . 'warning',
			'type'          => 'warning',
			'desc'          => wp_kses_post( sprintf( __( 'Please make sure that you <a href="%s" target="_blank">set a facebook app id</a> for your domain, otherwise the button will not work. The Facebook Share button requires an app id registered for a domain where it\'s used.', 'content-locker' ), $url ) ),
			'render_row_cb' => 'cl_cmb_alert',
			'classes'       => 'mt0',
		) );
	}

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'facebook-share',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'off',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'URL to share', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => esc_html__( 'Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional. A title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'share',
		) );

		// Extra
		$cmb->add_field( array(
			'name'          => esc_html__( 'Show more options (5)', 'content-locker' ),
			'id'            => 'fbs_show_extra',
			'type'          => 'more',
			'render_row_cb' => 'cl_cmb_more_open_tag',
		) );

			$cmb->add_field( array(
				'name'          => esc_html__( 'Feed Dialog Or Share Dialog (Optional)', 'content-locker' ),
				'id'            => $prefix . 'hint',
				'type'          => 'hint',
				'desc'          => esc_html__( 'By default the plugin uses the Facebook Feed Dialog. But some users believe that posts published via the Facebook Share Dialog appear more often on the top of the news feeds and this way bring more traffic. Both the dialogue perform the same action (sharing) and look approximately equally.', 'content-locker' ),
				'render_row_cb' => 'cl_cmb_alert',
			) );

			$cmb->add_field( array(
				'name'       => esc_html__( 'Use Facebook Share Dialog', 'content-locker' ),
				'id'         => $prefix . 'dialog',
				'type'       => 'radio_inline',
				'desc'       => esc_html__( 'Optional. Set On to use the Facebook Share Dialog instead of the Facebook Feed Dialog. Use the Open Graph Meta Tags to specify the message to share for the Share Dialog.', 'content-locker' ),
				'options'    => array(
					'on'  => esc_html__( 'On', 'content-locker' ),
					'off' => esc_html__( 'Off', 'content-locker' ),
				),
				'default'    => 'on',
				'attributes' => array(
					'data-for' => 'section-fb-share-dialog',
				),
				'classes'    => 'service-checker',
			) );

			$cmb->add_field( array(
				'id'            => 'fb-share-dialog',
				'type'          => 'dependency',
				'render_row_cb' => 'cl_cmb_tab_open_tag',
				'classes'       => 'inverse',
			) );

				$cmb->add_field( array(
					'name'          => esc_html__( 'Message To Share', 'content-locker' ),
					'id'            => $prefix . 'hint2',
					'type'          => 'hint',
					'desc'          => esc_html__( 'By default the message is extracted from the page content (from the Open Graph Meta Tags). But for the Feed Dialog you can set an own message.', 'content-locker' ),
					'render_row_cb' => 'cl_cmb_alert',
				) );

				$cmb->add_field( array(
					'name' => esc_html__( 'Name Title', 'content-locker' ),
					'id'   => $prefix . 'message_name',
					'type' => 'text',
					'desc' => esc_html__( 'Optional. The name of the link attachment.', 'content-locker' ),
				) );

				$cmb->add_field( array(
					'name' => esc_html__( 'Caption', 'content-locker' ),
					'id'   => $prefix . 'message_caption',
					'type' => 'text',
					'desc' => esc_html__( 'Optional. The caption of the link (appears beneath the link name). If not specified, this field is automatically populated with the URL of the link.', 'content-locker' ),
				) );

				$cmb->add_field( array(
					'name' => esc_html__( 'Description', 'content-locker' ),
					'id'   => $prefix . 'message_description',
					'type' => 'text',
					'desc' => esc_html__( 'Optional. The description of the link (appears beneath the link caption). If not specified, this field is automatically populated by information scraped from the link, typically the title of the page.', 'content-locker' ),
				) );

				$cmb->add_field( array(
					'name' => esc_html__( 'Image', 'content-locker' ),
					'id'   => $prefix . 'message_image',
					'type' => 'file',
					'desc' => esc_html__( 'Optional. The URL of a picture attached to this post. The picture must be at least 50px by 50px (though minimum 200px by 200px is preferred) and have a maximum aspect ratio of 3:1.', 'content-locker' ),
				) );

			$cmb->add_field( array(
				'id'            => 'fb-share-dialog-close',
				'type'          => 'tab_end',
				'render_row_cb' => 'cl_cmb_tab_close_tag',
			) );

		$cmb->add_field( array(
			'id'            => 'fbs_show_extra_close',
			'type'          => 'tab_end',
			'render_row_cb' => 'cl_cmb_more_close_tag',
		) );

	$cmb->add_field( array(
		'id'            => 'facebook_share_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Twitter Follow Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_twitter_follow( $cmb ) {

	$prefix = '_mts_cl_twitter_follow_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-twitter"></i>' . esc_html__( 'Follow', 'content-locker' ),
		'id'            => 'twitter-follow',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'twitter-follow',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'off',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'User to Follow', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => sprintf( esc_html__( 'Set an URL of your Twitter profile (for example, %s).', 'content-locker' ), 'https://twitter.com/MyThemeShopTeam' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Hide Username', 'content-locker' ),
			'id'      => $prefix . 'hide_name',
			'type'    => 'radio_inline',
			'desc'    => esc_html__( 'Set On to hide your username on the button (makes the button shorter).', 'content-locker' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default' => 'on',
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional. A title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'follow us',
		) );

	$cmb->add_field( array(
		'id'            => 'twitter_follow_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Google Share Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_google_share( $cmb ) {

	$prefix = '_mts_cl_google_share_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-google-plus"></i>' . esc_html__( 'Share', 'content-locker' ),
		'id'            => 'google-share',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'google-share',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'off',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'URL to share', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => esc_html__( 'Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional. A title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'share',
		) );

	$cmb->add_field( array(
		'id'            => 'google_share_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Youtube Subscribe Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_youtube_subscribe( $cmb ) {

	$prefix = '_mts_cl_youtube_subscribe_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-youtube-play"></i>' . esc_html__( 'Youtube', 'content-locker' ),
		'id'            => 'youtube-subscribe',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

	if ( $errors = cl_cmb_google_errors() ) {
		$url = cl_get_admin_url( 'settings#google_client_id' );
		$cmb->add_field( array(
			'id'            => $prefix . 'warning',
			'type'          => 'warning',
			'desc'          => wp_kses_post( sprintf( __( 'The YouTube Button requires the Google Client ID linked to your domain. Before using the button, please set the <a href="%s" target="_blank">Client ID</a>.', 'content-locker' ), $url ) ),
			'render_row_cb' => 'cl_cmb_alert',
			'classes'       => 'mt0',
		) );
	}

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'youtube-subscribe',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'off',
		) );

		$url = 'https://www.youtube.com/account_advanced';
		$cmb->add_field( array(
			'name' => esc_html__( 'Channel ID', 'content-locker' ),
			'id'   => $prefix . 'channel_id',
			'type' => 'text',
			'desc' => wp_kses_post( sprintf( __( 'Set a channel ID to subscribe, to get your channel ID <a href="%s" target="_blank">click here</a>.', 'content-locker' ), $url ) ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional. A title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'Youtube',
		) );

	$cmb->add_field( array(
		'id'            => 'youtube_channel_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Linkedin Share Options
 * @param  CMB2 $cmb      The CMB2 object
 * @return void
 */
function cl_social_option_linkedin_share( $cmb ) {

	$prefix = '_mts_cl_linkedin_share_';

	$cmb->add_field( array(
		'name'          => '<i class="fa fa-linkedin"></i>' . esc_html__( 'Share', 'content-locker' ),
		'id'            => 'linkedin-share',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_field( array(
			'id'            => $prefix . 'warning',
			'type'          => 'warning',
			'desc'          => esc_html__( 'Warning: due to the technical bug on the LinkedIn side, the locked content may be accessible for visitors who close the share dialog without actual sharing.', 'content-locker' ),
			'render_row_cb' => 'cl_cmb_alert',
			'classes'       => 'mt0',
		) );

		$cmb->add_field( array(
			'name'       => esc_html__( 'Active', 'content-locker' ),
			'id'         => $prefix . 'active',
			'type'       => 'radio_inline',
			'desc'       => esc_html__( 'Set On, to activate the button.', 'content-locker' ),
			'classes'    => 'service-checker',
			'attributes' => array(
				'data-for' => 'linkedin-share',
			),
			'options'    => array(
				'on'  => esc_html__( 'On', 'content-locker' ),
				'off' => esc_html__( 'Off', 'content-locker' ),
			),
			'default'    => 'off',
		) );

		$cmb->add_field( array(
			'name' => esc_html__( 'URL to share', 'content-locker' ),
			'id'   => $prefix . 'url',
			'type' => 'text',
			'desc' => esc_html__( 'Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'content-locker' ),
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Button Title', 'content-locker' ),
			'id'      => $prefix . 'button_title',
			'type'    => 'text',
			'desc'    => esc_html__( 'Optional. A title of the button that is situated on the covers in some themes.', 'content-locker' ),
			'default' => 'share',
		) );

	$cmb->add_field( array(
		'id'            => 'linkedin_share_close',
		'type'          => 'tab_end',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}
