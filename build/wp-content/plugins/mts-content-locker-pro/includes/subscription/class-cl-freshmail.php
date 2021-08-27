<?php
/**
 * Freshmail Subscription
 */
class CL_Subscription_Freshmail extends CL_Subscription_Base {

	public function init( $api_key, $api_secret ) {

		require_once 'libs/freshmail.php';
		return new FreshmailAPI( $api_key, $api_secret );
	}

	public function get_lists( $api_key, $api_secret ) {

		$api    = $this->init( $api_key, $api_secret );
		$result = $api->doRequest( 'subscribers_list/lists' );

		$lists = array();
		foreach ( $result['lists'] as $list ) {
			$lists[ $list['subscriberListHash'] ] = $list['name'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$double_optin = isset( $options['double_optin'] ) && $options['double_optin'] ? true : false;

		$data = array(
			'email'   => $identity['email'],
			'list'    => $options['list'],
			'confirm' => ( $identity['social'] || ! $double_optin ) ? 0 : 1,
			'state'   => ( $identity['social'] || ! $double_optin ) ? 1 : 2,
		);

		$api    = $this->init( $options['api_key'], $options['api_secret'] );
		$result = $api->doRequest( 'subscriber/add', $data );

		if ( isset( $result['errors'] ) ) {

			// 1304: the subscriber already exists
			if ( 1304 === $result['errors'][0]['code'] ) {
				return array( 'status' => 'subscribed' );
			} else {
				throw new Exception( $result['errors'][0]['message'] );
			}
		}

		if ( isset( $result['status'] ) && 'OK' === $result['status'] ) {
			return array( 'status' => 'subscribed' );
		}

		throw new Exception( esc_html__( 'Unknown error.', 'content-locker' ) );
	}
}
