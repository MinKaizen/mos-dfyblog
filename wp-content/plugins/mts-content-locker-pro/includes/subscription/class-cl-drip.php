<?php
/**
 * Drip Subscription
 */
class CL_Subscription_Drip extends CL_Subscription_Base {

	public function init( $api_token ) {

		require_once 'libs/drip.php';
		return new Drip_Api( $api_token );
	}

	public function get_lists( $account_id, $api_token ) {

		$drip   = $this->init( $api_token );
		$result = $drip->get_campaigns( array( 'account_id' => $account_id ) );

		$lists = array();
		foreach ( $result as $list ) {
			$lists[ $list['id'] ] = $list['name'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$vars = array();
		if ( empty( $vars['name'] ) && ! empty( $identity['name'] ) ) {
			$vars['name'] = $this->get_fullname( $identity );
		}

		$drip   = $this->init( $options['api_token'] );
		$result = $drip->subscribe_subscriber( array(
			'account_id'    => $options['account_id'],
			'campaign_id'   => $options['list'],
			'email'         => $identity['email'],
			'custom_fields' => empty( $vars ) ? new stdClass : $vars,
			'double_optin'  => $options['double_optin'] ? true : false,
		));

		if ( false === $result && $drip->get_error_message() ) {

			if ( strpos( $drip->get_error_message(), 'subscribed' ) ) {
				return array( 'status' => 'subscribed' );
			}

			throw new Exception( $drip->get_error_message() );
		}

		return array( 'status' => 'subscribed' );
	}

	public function get_fields() {

		$fields = array(

			'drip_account_id'   => array(
				'id'    => 'drip_account_id',
				'name'  => 'drip_account_id',
				'type'  => 'text',
				'title' => esc_html__( 'Account ID', 'content-locker' ),
				'desc'  => esc_html__( 'The account id of your drip account.', 'content-locker' ),
			),

			'drip_api_token'    => array(
				'id'    => 'drip_api_token',
				'name'  => 'drip_api_token',
				'type'  => 'text',
				'title' => esc_html__( 'API token', 'content-locker' ),
				'desc'  => esc_html__( 'The API key of your drip account.', 'content-locker' ),
				'link'  => 'http://kb.getdrip.com/general/where-can-i-find-my-api-token/',
			),

			'drip_list_id'      => array(
				'id'      => 'drip_list_id',
				'name'    => 'drip_list_id',
				'type'    => 'select',
				'title'   => esc_html__( 'Drip Campaigns', 'content-locker' ),
				'options' => array( 'none' => esc_html__( 'Select List', 'content-locker' ) ) + wps_get_service_list( 'drip' ),
				'is_list' => true,
			),

			'drip_double_optin' => array(
				'id'    => 'drip_double_optin',
				'name'  => 'drip_double_optin',
				'type'  => 'checkbox',
				'title' => esc_html__( 'Send double opt-in notification', 'content-locker' ),
			),
		);

		return $fields;
	}
}
