<?php
/**
 * MailRelay Subscription
 */
class CL_Subscription_MailRelay extends CL_Subscription_Base {

	public function init( $api_key, $username ) {

		require_once 'libs/mailrelay.php';
		return new MailRelay( $api_key, $username );
	}

	public function get_lists( $api_key, $username ) {

		$api    = $this->init( $api_key, $username );
		$result = $api->getGroups();

		$lists = array();
		foreach ( $result['data'] as $list ) {
			$lists[ $list['id'] ] = $list['name'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$api = $this->init( $options['api_key'], $options['host'] );

		$fields = array(
			'email'  => $identity['email'],
			'groups' => array( $options['group_id'] ),
		);

		if ( ! empty( $identity['name'] ) ) {
			$fields['name'] = $identity['name'];
		}

		$result = $api->addSubscriber( $fields );

		if ( isset( $result['error'] ) ) {

			if ( false === strpos( $result['error'], 'ya existe' ) ) {
				throw new Exception( $result['error'] );
			}
		}

		return array( 'status' => 'subscribed' );
	}
}
