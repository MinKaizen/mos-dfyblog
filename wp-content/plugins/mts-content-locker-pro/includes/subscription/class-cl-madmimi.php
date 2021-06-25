<?php
/**
 * MadMimi Subscription
 */

class CL_Subscription_MadMimi extends CL_Subscription_Base {

	public function init( $username, $api_key ) {

		require_once 'libs/madmimi/MadMimi.class.php';
		return new MadMimi( $username, $api_key );
	}

	public function get_lists( $username, $api_key ) {

		$api    = $this->init( $username, $api_key );
		$result = simplexml_load_string( $api->Lists() );

		$lists = array();
		foreach ( $result as $list ) {
			$lists[ $list['id']->__toString() ] = $list['name']->__toString();
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$data = array();
		if ( ! empty( $identity['name'] ) ) {
			$data['first_name'] = $identity['name'];
		}

		if ( ! empty( $identity['family'] ) ) {
			$data['last_name'] = $identity['family'];
		}

		if ( empty( $identity['name'] ) && empty( $identity['family'] ) && ! empty( $identity['display_name'] ) ) {
			$data['first_name'] = $identity['display_name'];
		}

		$api    = $this->init( $options['username'], $options['api_key'] );
		$result = $api->AddMembership( $options['list'], $identity['email'], $data );

		if ( ! empty( $result ) ) {
			throw new Exception( $result );
		}

		return array( 'status' => 'subscribed' );
	}
}
