<?php
/**
 * GetResponse Subscription
 */

class CL_Subscription_GetResponse extends CL_Subscription_Base {

	public function init( $api_key ) {

		require_once 'libs/getresponse.php';
		return new GetResponse( $api_key );
	}

	public function get_lists( $api_key ) {

		$api    = $this->init( $api_key );
		$result = $api->getCampaigns();

		$lists = array();
		if ( empty( $result ) ) {
			return $lists;
		}
		foreach ( $result as $list ) {
			$lists[ $list->campaignId ] = $list->name;
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$data = array(
			'campaign'   => array( 'campaignId' => $options['list'] ),
			'email'      => $identity['email'],
			'dayOfCycle' => 0,
			'name'       => $this->get_fullname( $identity ),
		);

		$api    = $this->init( $options['api_key'] );
		$result = $api->addContact( $data );

		if ( isset( $result->uuid ) ) {

			return array( 'status' => 'subscribed' );
		}

		if ( 202 === intval( $api->http_status ) ) {
			return array( 'status' => 'subscribed' );
		}

		throw new Exception( esc_html__( 'Unknown error.', 'content-locker' ) );
	}
}
