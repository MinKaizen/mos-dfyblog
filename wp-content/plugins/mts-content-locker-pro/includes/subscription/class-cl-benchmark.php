<?php
/**
 * BenchmarkEmail Subscription
 */
class CL_Subscription_Benchmark extends CL_Subscription_Base {

	public function init( $api_key ) {

		require_once 'libs/bmeapi.php';
		return new BMEAPI( $api_key );
	}

	public function get_lists( $apikey ) {
		$api = $this->init( $apikey );
		$this->apiToken = $api;
		$result = $api->listGet( '', 1, 50, '', '' );

		if ( isset($result['error']) ) {
			throw new Exception( $result['error'] );
		}
		$lists = array();
		foreach ( $result as $id => $list ) {
			$lists[ $list['id'] ] = $list['listname'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$api = $this->init( $options['apikey'] );

		$vars = array();
		$vars['email'] = $identity['email'];

		if ( ! empty( $identity['name'] ) ) {
			$vars['firstname'] = $identity['name'];
		}

		if ( ! empty( $identity['family'] ) ) {
			$fields['lastname'] = $identity['family'];
		}

		try {

			$double_optin = isset( $options['double_optin'] ) && $options['double_optin'] ? "1" : "0";
			$api->listAddContactsOptin( $options['list'], array( $vars ), $double_optin );
		} catch ( Exception $e ) {
			throw new Exception( $e->getMessage() );
		}

		return array( 'status' => 'subscribed' );
	}
}