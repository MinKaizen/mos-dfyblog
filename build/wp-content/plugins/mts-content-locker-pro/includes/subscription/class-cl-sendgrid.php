<?php
/**
 * SendGrid Subscription
 */

class CL_Subscription_SendGrid extends CL_Subscription_Base {

	public function init( $api_key ) {

		require_once 'libs/sendgrid/SendGrid.php';
		return new \SendGrid( $api_key );
	}

	public function get_lists( $api_key ) {

		try {
			$api    = $this->init( $api_key );
			$result = $api->client->contactdb()->lists()->get();
			$result = $api->handle_response( $result );

			$lists = array();
			foreach ( $result->lists as $list ) {
				$lists[ $list->id ] = $list->name;
			}

			return $lists;
		} catch ( Exception $e ) {
			return array();
		}
	}

	public function subscribe( $identity, $context, $options ) {

		$vars    = array();
		$email   = $identity['email'];
		$list_id = $options['list'];

		if ( ! empty( $identity['name'] ) ) {
			$vars['first_name'] = $identity['name'];
		}
		if ( ! empty( $identity['family'] ) ) {
			$vars['last_name'] = $identity['family'];
		}
		if ( empty( $vars['first_name'] ) && ! empty( $identity['display_name'] ) ) {
			$vars['first_name'] = $identity['display_name'];
		}
		$vars['email'] = $email;

		$api = $this->init( $options['api_key'] );

		// Search for existance.
		$response = $api->client->contactdb()->recipients()->search()->get( null, array( 'email' => $email ) );
		$response = $api->handle_response( $response );

		// aleary exists
		if ( ! empty( $response->recipients ) ) {

			$subscriber_id = isset( $response->recipients[0]->id ) ? $response->recipients[0]->id : 0;

			// adding to a list
			if ( $subscriber_id ) {
				$response = $api->client->contactdb()->lists()->_( $list_id )->recipients()->_( $subscriber_id )->post();
				$response = $api->handle_response( $response, 201 );
			}

			return array( 'status' => 'subscribed' );
		}

		// adding a new contact
		$response = $api->client->contactdb()->recipients()->post( array( $vars ) );
		$response = $api->handle_response( $response, 201 );

		$subscriber_id = isset( $response->persisted_recipients[0] ) ? $response->persisted_recipients[0] : 0;
		if ( ! $subscriber_id ) {
			throw new Exception( __( 'Unable to add a new user. Please contact MyThemeShop support.', 'content-locker' ) );
		}

		// adding to a list
		$response = $api->client->contactdb()->lists()->_( $list_id )->recipients()->_( $subscriber_id )->post();
		$response = $api->handle_response( $response, 201 );

		return array( 'status' => 'subscribed' );
	}
}
