<?php
/**
 * File contains all the subscription services forms
 */

/**
 * ActiveCampaign Settings
 *
 * @param CMB2   $cmb             The CMB2 object
 * @param string $group_field_id  The group field id for repeater type
 * @return void
 */
function cl_subscription_option_activecampaign( $cmb, $group_field_id ) {

	$prefix = 'activecampaign_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'activecampaign',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Key', 'content-locker' ),
			'id'         => $prefix . 'api_key',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Key of your ActiveCampaign account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API',
				'data-api-id'  => 'api_key',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Url', 'content-locker' ),
			'id'         => $prefix . 'api_url',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Url of your ActiveCampaign account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API',
				'data-api-id'  => 'api_url',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'activecampaign' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'activecampaign',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Acumbamail Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_acumbamail( $cmb, $group_field_id ) {

	$prefix = 'acumbamail_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'acumbamail',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Customer ID', 'content-locker' ),
			'id'         => $prefix . 'customer_id',
			'type'       => 'text',
			'desc'       => esc_html__( 'The customer ID of your Acumbamail account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://acumbamail.com/apidoc/',
				'data-api-id'  => 'customer_id',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Token', 'content-locker' ),
			'id'         => $prefix . 'api_token',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API token of your Acumbamail account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'api_token',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'acumbamail' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'acumbamail',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc'       => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id'         => $prefix . 'double_optin',
			'type'       => 'checkbox',
			'classes'    => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Aweber Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_aweber( $cmb, $group_field_id ) {

	$prefix = 'aweber_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'aweber',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'help',
		'type'          => 'view',
		'file'          => 'hint-aweber-service',
		'render_row_cb' => 'cl_cmb_alert',
	));

	$aweber_option = get_option( '_mts_cl_aweber_access_key', array() );
	if ( empty( $aweber_option ) ) :
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Authorization Code', 'content-locker' ),
			'id'         => $prefix . 'api_key',
			'type'       => 'textarea_small',
			'desc'       => esc_html__( 'You will see after log in to your Aweber account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'api_key',
			),
		));
	else :
		$cmb->add_group_field( $group_field_id, array(
			'id'      => $prefix . 'api_key',
			'type'    => 'textarea_small',
			'classes' => 'no-border service-api-key hidden',
		));
	endif;

	$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'aweber' );
	$cmb->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'List', 'content-locker' ),
		'id'         => $prefix . 'list',
		'type'       => 'select',
		'options'    => $list,
		'classes'    => 'no-border service-lists',
		'attributes' => array(
			'data-service' => 'aweber',
		),
	));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Becnkmarkmail Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_benchmark( $cmb, $group_field_id ) {

	$prefix = 'benchmark_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'benchmark',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Key', 'content-locker' ),
			'id'         => $prefix . 'apikey',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Key of your Benchmark Email account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://ui.benchmarkemail.com/Integrate#API',
				'data-api-id'  => 'apikey',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'benchmark' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'benchmark',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc'       => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id'         => $prefix . 'double_optin',
			'type'       => 'checkbox',
			'classes'    => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Contant Contact Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_constantcontact( $cmb, $group_field_id ) {

	$prefix = 'constantcontact_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'constantcontact',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Key', 'content-locker' ),
			'id'         => $prefix . 'api_key',
			'type'       => 'text',
			'desc'       => esc_html__( 'The api key of your Contant Contact account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://constantcontact.com/apidoc/',
				'data-api-id'  => 'api_key',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Access Token', 'content-locker' ),
			'id'         => $prefix . 'access_token',
			'type'       => 'text',
			'desc'       => esc_html__( 'The access token of your Contant Contact account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'access_token',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'constantcontact' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'constantcontact',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc'       => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id'         => $prefix . 'double_optin',
			'type'       => 'checkbox',
			'classes'    => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * Drip Settings
 *
 * @param CMB2   $cmb             The CMB2 object
 * @param string $group_field_id  The group field id for repeater type
 * @return void
 */
function cl_subscription_option_drip( $cmb, $group_field_id ) {

	$prefix = 'drip_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'drip',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'id'         => $prefix . 'account_id',
			'type'       => 'text',
			'name'       => esc_html__( 'Account ID', 'content-locker' ),
			'desc'       => esc_html__( 'The account id of your drip account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'account_id',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'id'         => $prefix . 'api_token',
			'type'       => 'text',
			'name'       => esc_html__( 'API token', 'content-locker' ),
			'desc'       => esc_html__( 'The API token of your drip account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'http://kb.getdrip.com/general/where-can-i-find-my-api-token/',
				'data-api-id'  => 'api_token',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'drip' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'drip',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc'       => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id'         => $prefix . 'double_optin',
			'type'       => 'checkbox',
			'classes'    => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
 * FreshMail Settings
 *
 * @param CMB2    $cmb             The CMB2 object
 * @param string  $group_field_id  The group field id for repeater type
 * @return void
 */
function cl_subscription_option_freshmail( $cmb, $group_field_id ) {

	$prefix = 'freshmail_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'freshmail',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Key', 'content-locker' ),
			'id'         => $prefix . 'api_key',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Key of your FreshMail account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://app.freshmail.com/en/settings/integration/',
				'data-api-id'  => 'api_key',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Secret', 'content-locker' ),
			'id'         => $prefix . 'api_secret',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Secret of your FreshMail account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'api_secret',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'freshmail' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'freshmail',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc'       => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id'         => $prefix . 'double_optin',
			'type'       => 'checkbox',
			'classes'    => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* GetResponse Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_getresponse( $cmb, $group_field_id ) {

	$prefix = 'getresponse_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'getresponse',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'API Key', 'content-locker' ),
			'id' => $prefix . 'api_key',
			'type' => 'text',
			'desc' => esc_html__( 'The API key of your GetResponse account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://support.getresponse.com/faq/where-i-find-api-key',
				'data-api-id' => 'api_key',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'getresponse' );
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'getresponse',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Knews Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_knews( $cmb, $group_field_id ) {

	$prefix = 'knews_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'knews',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

	if ( ! class_exists( 'KnewsPlugin' ) ) {

		$cmb->add_group_field( $group_field_id, array(
			'id' => $prefix . 'no_title',
			'type' => 'danger',
			'desc' => wp_kses_post( sprintf( __( '<a href="%s" target="_blank">KNews plugin</a> is not found on your website, please install it in order to use this service.', 'content-locker' ), 'https://wordpress.org/plugins/knews/' ) ),
			'render_row_cb' => 'cl_cmb_alert',
			'classes' => 'no-border',
		) );
	} else {
		global $Knews_plugin;

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + $Knews_plugin->tellMeLists();
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border',
			'attributes' => array(
				'data-service' => 'knews',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id' => $prefix . 'double_optin',
			'type' => 'checkbox',
			'classes' => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));
	}

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Madmimi Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_madmimi( $cmb, $group_field_id ) {

	$prefix = 'madmimi_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'madmimi',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Email', 'content-locker' ),
			'id' => $prefix . 'username',
			'type' => 'text',
			'desc' => esc_html__( 'The email of your Mad Mimi account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'username',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'API Key', 'content-locker' ),
			'id' => $prefix . 'api_key',
			'type' => 'text',
			'desc' => esc_html__( 'The API key of your Mad Mimi account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://help.madmimi.com/where-can-i-find-my-api-key/',
				'data-api-id' => 'api_key',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'madmimi' );
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'madmimi',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}


/**
* MailChimp Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_mailchimp( $cmb, $group_field_id ) {

	$prefix = 'mailchimp_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'mailchimp',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'API Key', 'content-locker' ),
			'id' => $prefix . 'api_key',
			'type' => 'text',
			'desc' => esc_html__( 'The API key of your MailChimp account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'http://kb.mailchimp.com/integrations/api-integrations/about-api-keys#Finding-or-generating-your-API-key',
				'data-api-id' => 'api_key',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'mailchimp' );
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'mailchimp',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id' => $prefix . 'double_optin',
			'type' => 'checkbox',
			'classes' => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* MailerLite Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_mailerlite( $cmb, $group_field_id ) {

	$prefix = 'mailerlite_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'mailerlite',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'API Key', 'content-locker' ),
			'id' => $prefix . 'api_key',
			'type' => 'text',
			'desc' => esc_html__( 'The API key of your MailerLite account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://kb.mailerlite.com/does-mailerlite-offer-an-api/',
				'data-api-id' => 'api_key',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'mailerlite' );
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'mailerlite',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id' => $prefix . 'double_optin',
			'type' => 'checkbox',
			'classes' => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* MailPoet Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_mailpoet( $cmb, $group_field_id ) {

	$prefix = 'mailpoet_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'mailpoet',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

	if ( ! defined( 'WYSIJA' ) ) {

		$cmb->add_group_field( $group_field_id, array(
			'id' => $prefix . 'no_title',
			'type' => 'danger',
			'desc' => wp_kses_post( sprintf( __( '<a href="%s" target="_blank">MailPoet plugin</a> is not found on your website, please install it in order to use this service.', 'content-locker' ), 'https://wordpress.org/plugins/wysija-newsletters/' ) ),
			'render_row_cb' => 'cl_cmb_alert',
			'classes' => 'no-border',
		) );
	} else {

		$lists = array();
		$model_list = WYSIJA::get( 'list', 'model' );

		foreach ( $model_list->getLists() as $item ) {
			$lists[ $item['list_id'] ] = $item['name'];
		}

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + $lists;
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border',
			'attributes' => array(
				'data-service' => 'mailpoet',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id' => $prefix . 'double_optin',
			'type' => 'checkbox',
			'classes' => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));
	}

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Mailrelay Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_mailrelay( $cmb, $group_field_id ) {

	$prefix = 'mailrelay_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'mailrelay',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'API Key', 'content-locker' ),
			'id' => $prefix . 'api_key',
			'type' => 'text',
			'desc' => esc_html__( 'The API key of your Mailrelay account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'api_key',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Host Address', 'content-locker' ),
			'id' => $prefix . 'host',
			'type' => 'text',
			'desc' => esc_html__( 'The host address of your Mailrelay account.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'host',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'mailrelay' );
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'mailrelay',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id' => $prefix . 'double_optin',
			'type' => 'checkbox',
			'classes' => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* MyMail Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_mymail( $cmb, $group_field_id ) {

	$prefix = 'mymail_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'mymail',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

	$error = false;
	if ( ! defined( 'MYMAIL_VERSION' ) ) {
		$error = wp_kses_post( sprintf( __( '<a href="%s" target="_blank">MyMail plugin</a> is not found on your website, please install it in order to use this service.', 'content-locker' ), 'https://goo.gl/KTmLjC' ) );
	} else {
		$path = MYMAIL_DIR . '/classes/lists.class.php';
		if ( ! file_exists( $path ) ) {
			$error = esc_html__( 'Unable to connect with the MyMail Lists Manager. Your version of MyMail plugin is not supported. Please contact OnePress support.', 'content-locker' );
		} else {
			require_once $path;

			if ( ! class_exists( 'mymail_lists' ) ) {
				$error = esc_html__( 'Unable to connect with the MyMail Lists Manager. Your version of MyMail plugin is not supported. Please contact OnePress support.', 'content-locker' );
			}
		}
	}

	if ( $error ) {

		$cmb->add_group_field( $group_field_id, array(
			'id' => $prefix . 'no_title',
			'type' => 'danger',
			'desc' => $error,
			'render_row_cb' => 'cl_cmb_alert',
			'classes' => 'no-border',
		) );
	} else {

		$lists = array();
		$model_list = mymail( 'lists' )->get();
		foreach ( $model_list as $item ) {
			$lists[ $item->ID ] = $item->name;
		}

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + $lists;
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border',
			'attributes' => array(
				'data-service' => 'mymail',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'Double Opt-in', 'content-locker' ),
			'desc' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			'id' => $prefix . 'double_optin',
			'type' => 'checkbox',
			'classes' => 'no-border',
			'attributes' => array(
				'data-api-id' => 'double_optin',
			),
		));
	}

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* SendGrid Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_sendgrid( $cmb, $group_field_id ) {

	$prefix = 'sendgrid_';

	$cmb->add_group_field( $group_field_id, array(
		'id' => 'sendgrid',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'API Key', 'content-locker' ),
			'id' => $prefix . 'api_key',
			'type' => 'text',
			'desc' => esc_html__( 'Your SendGrid API key. Grant Full Access for Mail Send and Marketing Campaigns in settings of your API key.', 'content-locker' ),
			'classes' => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://app.sendgrid.com/settings/api_keys',
				'data-api-id' => 'api_key',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'sendgrid' );
		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'List', 'content-locker' ),
			'id' => $prefix . 'list',
			'type' => 'select',
			'options' => $list,
			'classes' => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'sendgrid',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id' => $prefix . 'close',
		'type' => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* SendinBlue Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_sendinblue( $cmb, $group_field_id ) {

	$prefix = 'sendinblue_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'sendinblue',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Key', 'content-locker' ),
			'id'         => $prefix . 'api_key',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Key (version 2.0) of your Sendinblue account.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-url' => 'https://my.sendinblue.com/advanced/apikey',
				'data-api-id'  => 'api_key',
			),
		));

		$list = array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + cl_get_service_list( 'sendinblue' );
		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'select',
			'options'    => $list,
			'classes'    => 'no-border service-lists',
			'attributes' => array(
				'data-service' => 'sendinblue',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

/**
* Sendy Settings
*
* @param CMB2   $cmb             The CMB2 object
* @param string $group_field_id  The group field id for repeater type
* @return void
*/
function cl_subscription_option_sendy( $cmb, $group_field_id ) {

	$prefix = 'sendy_';

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'sendy',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'API Key', 'content-locker' ),
			'id'         => $prefix . 'api_key',
			'type'       => 'text',
			'desc'       => esc_html__( 'The API Key of your Sendy application, available in Settings.', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'api_key',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'Installation', 'content-locker' ),
			'id'         => $prefix . 'api_url',
			'type'       => 'text',
			'desc'       => esc_html__( 'An URL for your Sendy installation, http://your_sendy_installation', 'content-locker' ),
			'classes'    => 'no-border service-api-key',
			'attributes' => array(
				'data-api-id' => 'api_url',
			),
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'       => esc_html__( 'List', 'content-locker' ),
			'id'         => $prefix . 'list',
			'type'       => 'text',
			'desc'       => esc_html__( 'Specify the list ID to add subscribers.', 'content-locker' ),
			'classes'    => 'no-border',
			'attributes' => array(
				'data-service' => 'sendy',
			),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => $prefix . 'close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}
