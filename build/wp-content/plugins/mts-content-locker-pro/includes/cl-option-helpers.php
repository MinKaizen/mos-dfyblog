<?php
/**
 * Plugin options functions.
 */

/**
* Get subscription services
*
* @param string $type
* @return array
*/
function cl_get_subscription_services( $type = 'list' ) {

	$services = array(

		'database'        => array(
			'title'       => esc_html__( 'Database', 'content-locker' ),
			'description' => esc_html__( 'Emails of subscribers will be saved in the WP database.', 'content-locker' ),
			'class'       => 'CL_Subscription_Database',
		),

		'activecampaign'  => array(
			'title'       => esc_html__( 'ActiveCampaign', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your ActiveCampaign account.', 'content-locker' ),
			'class'       => 'CL_Subscription_ActiveCampaign',
		),

		'acumbamail'      => array(
			'title'       => esc_html__( 'Acumbamail', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your Acumbamail account.', 'content-locker' ),
			'class'       => 'CL_Subscription_Acumbamail',
		),

		'aweber'          => array(
			'title'       => esc_html__( 'Aweber', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your Aweber account.', 'content-locker' ),
			'class'       => 'CL_Subscription_Aweber',
		),

		'benchmark'       => array(
			'title'       => esc_html__( 'BenchmarkEmail', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your BenchmarkEmail account.', 'content-locker' ),
			'class'       => 'CL_Subscription_Benchmark',
		),

		'constantcontact' => array(
			'title'       => esc_html__( 'Constant Contact', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your Constant Contact account.', 'content-locker' ),
			'class'       => 'CL_Subscription_ConstantContact',
		),

		'drip'            => array(
			'title'       => esc_html__( 'Drip.co', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your Drip account.', 'content-locker' ),
			'class'       => 'CL_Subscription_Drip',
		),

		'freshmail'       => array(
			'title'       => esc_html__( 'FreshMail', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your FreshMail account.', 'content-locker' ),
			'class'       => 'CL_Subscription_Freshmail',
		),

		'getresponse'     => array(
			'title'       => esc_html__( 'GetResponse', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your GetResponse account.', 'content-locker' ),
			'class'       => 'CL_Subscription_GetResponse',
		),

		'knews'           => array(
			'title'       => esc_html__( 'K-news', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to the plugin K-news.', 'content-locker' ),
			'class'       => 'CL_Subscription_KNews',
		),

		'madmimi'         => array(
			'title'       => esc_html__( 'Mad Mimi', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your Mad Mimi account.', 'content-locker' ),
			'class'       => 'CL_Subscription_MadMimi',
		),

		'mailchimp'       => array(
			'title'       => esc_html__( 'MailChimp', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your MailChimp account.', 'content-locker' ),
			'class'       => 'CL_Subscription_MailChimp',
		),

		'mailerlite'      => array(
			'title'       => esc_html__( 'MailerLite', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your MailerLite account.', 'content-locker' ),
			'class'       => 'CL_Subscription_MailerLite',
		),

		'mailpoet'        => array(
			'title'       => esc_html__( 'MailPoet', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to the plugin MailPoet.', 'content-locker' ),
			'class'       => 'CL_Subscription_MailPoet',
		),

		'mailrelay'       => array(
			'title'       => esc_html__( 'MailRelay', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to the plugin MailRelay.', 'content-locker' ),
			'class'       => 'CL_Subscription_MailRelay',
		),

		'mymail'          => array(
			'title'       => esc_html__( 'MyMail', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to the plugin MyMail.', 'content-locker' ),
			'class'       => 'CL_Subscription_MyMail',
		),

		'sendgrid'        => array(
			'title'       => esc_html__( 'SendGrid', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your SendGrid account.', 'content-locker' ),
			'class'       => 'CL_Subscription_SendGrid',
		),

		'sendinblue'      => array(
			'title'       => esc_html__( 'SendInBlue', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your SendInBlue account.', 'content-locker' ),
			'class'       => 'CL_Subscription_Sendinblue',
		),

		'sendy'           => array(
			'title'       => esc_html__( 'Sendy', 'content-locker' ),
			'description' => esc_html__( 'Adds subscribers to your Sendy application.', 'content-locker' ),
			'class'       => 'CL_Subscription_Sendy',
		),
	);

	$services = apply_filters( 'mts_cl_subscription_services', $services );

	if ( 'list' === $type ) {
		$list = wp_list_pluck( $services, 'title' );
		unset( $list['database'] );

		return $list;
	}

	return $services;
}

/**
 * Get stat screens
 * @param  string $type
 * @return array
 */
function cl_get_stats_screens( $type ) {

	$screens = array();

	/**
	 * Social locker stats screen
	 */
	if ( 'social-locker' === $type ) {

		// The Summary Screen
		$screens['summary'] = array(
			'title'       => '<i class="fa fa-search"></i> ' . esc_html__( 'Summary', 'content-locker' ),
			'description' => esc_html__( 'The page shows the total number of unlocks for the current locker.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SocialLocker_Summary_Chart',
			'table_class' => 'CL_Stats_SocialLocker_Summary_Table',
		);

		// The Channels Screen
		$screens['channels'] = array(
			'title'       => '<i class="fa fa-search-plus"></i> ' . esc_html__( 'Detailed', 'content-locker' ),
			'description' => esc_html__( 'The page shows which ways visitors used to unlock the content.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SocialLocker_Detailed_Chart',
			'table_class' => 'CL_Stats_SocialLocker_Detailed_Table',
		);

		// The Skips Screen
		$screens['skips'] = array(
			'title'       => '<i class="fa fa-tint"></i> ' . esc_html__( 'Skips', 'content-locker' ),
			'description' => esc_html__( 'The chart shows how many users skipped the locker by using the Timer or Close Icon, comparing to the users who unlocked the content.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SocialLocker_Skips_Chart',
			'table_class' => 'CL_Stats_SocialLocker_Skips_Table',
		);
	}

	/**
	 * Signin locker stats screen
	 */
	if ( 'signin-locker' === $type ) {

		// The Summary Screen
		$screens['summary'] = array(
			'title'       => '<i class="fa fa-search"></i> ' . esc_html__( 'Summary', 'content-locker' ),
			'description' => esc_html__( 'The page shows the total number of unlocks for the current locker.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SigninLocker_Summary_Chart',
			'table_class' => 'CL_Stats_SigninLocker_Summary_Table',
		);

		// The Profits Screen
		$screens['profits'] = array(
			'title'       => '<i class="fa fa-usd"></i> ' . esc_html__( 'Benefits', 'content-locker' ),
			'description' => esc_html__( 'The page shows benefits the locker brought for your website.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SigninLocker_Profits_Chart',
			'table_class' => 'CL_Stats_SigninLocker_Profits_Table',
		);

		// The Channels Screen
		$screens['channels'] = array(
			'title'       => '<i class="fa fa-search-plus"></i> ' . esc_html__( 'Channels', 'content-locker' ),
			'description' => esc_html__( 'The page shows which ways visitors used to unlock the content.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SigninLocker_Channels_Chart',
			'table_class' => 'CL_Stats_SigninLocker_Channels_Table',
		);

		// The Subscription Screen
		$screens['subscription'] = array(
			'title'       => '<i class="fa fa-envelope"></i> ' . esc_html__( 'Subscription', 'content-locker' ),
			'description' => esc_html__( 'The page shows visitor subscriptions stats.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SigninLocker_Subscription_Chart',
			'table_class' => 'CL_Stats_SigninLocker_Subscription_Table',
		);

		// The Bounces Screen
		$screens['bounces'] = array(
			'title'       => '<i class="fa fa-search-plus"></i> ' . esc_html__( 'Bounces', 'content-locker' ),
			'description' => esc_html__( 'The page shows major weaknesses of the locker which lead to bounces. Hover your mouse pointer on [?] in the table, to know more about a particular metric.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SigninLocker_Bounces_Chart',
			'table_class' => 'CL_Stats_SigninLocker_Bounces_Table',
		);

		// The Skips Screen
		$screens['skips'] = array(
			'title'       => '<i class="fa fa-tint"></i> ' . esc_html__( 'Skips', 'content-locker' ),
			'description' => esc_html__( 'The chart shows how many users skipped the locker by using the Timer or Close Icon, comparing to the users who unlocked the content.', 'content-locker' ),
			'chart_class' => 'CL_Stats_SigninLocker_Skips_Chart',
			'table_class' => 'CL_Stats_SigninLocker_Skips_Table',
		);
	}

	return apply_filters( "mts_cl_{$type}_stats_screens", $screens );
}
