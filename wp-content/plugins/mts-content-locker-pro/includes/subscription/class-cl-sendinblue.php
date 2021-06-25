<?php
/**
 * Sendinblue Subscription
 */

class CL_Subscription_Sendinblue extends CL_Subscription_Base {

	public function init( $api_key ) {

		require_once 'libs/sendinblue.php';
		return new SendinBlue( $api_key );
	}

	public function get_lists( $api_key ) {

		$api    = $this->init( $api_key );
		$result = $api->get_lists();

		if ( isset( $result['code'] ) && 'failure' == $result['code'] ) {
			throw new Exception( $result['message'] );
		}

		$lists = array();
		foreach ( $result['data'] as $list ) {
			$lists[ $list['id'] ] = $list['name'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$email   = $identity['email'];
		$list_id = $options['list'];

		// get user
		$api    = $this->init( $options['api_key'] );
		$result = $api->get_user( array( 'email' => $email ) );

		// user exists already
		$lists = array();
		if ( isset( $result['code'] ) && 'success' == $result['code'] ) {

			if ( ! empty( $result['data']['listid'] ) ) {
				$lists = $result['data']['listid'];
			}

			if ( ! in_array( $list_id, $lists ) ) {
				$lists[] = $list_id;
			}
		} else {
			// user doesn't exist yet
			$lists[] = $list_id;
		}

		unset( $identity['email'] );

		$result = $api->create_update_user(array(
			'email'      => $email,
			'attributes' => array(
				'FIRSTNAME' => $identity['name'],
				'NAME'      => $identity['family'],
			),
			'listid'     => $lists,
		));

		if ( isset( $result['code'] ) && 'success' != $result['code'] ) {
			throw new Exception( $result['message'] );
		}

		return array( 'status' => 'subscribed' );
	}
}
