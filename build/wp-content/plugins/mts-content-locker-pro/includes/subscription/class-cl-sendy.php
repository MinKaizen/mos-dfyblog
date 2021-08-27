<?php
/**
* Sendy Subscription
*/

class CL_Subscription_Sendy extends CL_Subscription_Base {

	public function get_lists( $api_key ) {

		return array();
	}

	public function request( $method, $args = array(), $request_method = 'GET' ) {

		if ( empty( $this->api_key ) ) {
			throw new Exception( __( 'The Sendy API Key is not specified.', 'content-locker' ) );
		}

		if ( empty( $this->api_url ) ) {
			throw new Exception( __( 'The Sendy Installation is not specified.', 'content-locker' ) );
		}

		$this->api_url = trim( $this->api_url, '/' );
		if ( false === strpos( $this->api_url, 'http://' ) ) {
			$this->api_url = 'http://' . $this->api_url;
		}

		$url             = $this->api_url . $method;
		$args['api_key'] = $this->api_key;

		$result = wp_remote_post( $url, array(
			'timeout' => 30,
			'body'    => $args,
		));

		if ( is_wp_error( $result ) ) {
			throw new Exception( sprintf( __( 'Unexpected error occurred during connection to Sendy: %s', 'content-locker' ), $result->get_error_message() ) );
		}

		$code = isset( $result['response']['code'] ) ? intval( $result['response']['code'] ) : 0;
		if ( 200 !== $code ) {
			throw new Exception( sprintf( __( 'Unexpected error occurred during connection to Sendy: %s', 'content-locker' ), $result['response']['message'] ) );
		}

		if ( empty( $result['body'] ) ) {
			return false;
		}

		return $result['body'];
	}

	public function subscribe( $identity, $context, $options ) {

		$email   = $identity['email'];
		$list_id = $options['list'];

		$result = $this->request('/api/subscribers/subscription-status.php', array(
			'email'   => $email,
			'list_id' => $list_id,
		));

		// if not subscribed yet
		if ( strpos( $result, 'does not exist' ) > 0 ) {

			$data = array(
				'email'   => $identity['email'],
				'list'    => $list_id,
				'boolean' => true,
			);

			if ( ! empty( $identity['name'] ) ) {
				$data['name']      = $identity['name'];
				$data['firstname'] = $identity['name'];
			}

			if ( ! empty( $identity['family'] ) ) {
				$data['family']   = $identity['family'];
				$data['lastname'] = $identity['family'];
				$data['surname']  = $identity['family'];
			}

			if ( empty( $identity['name'] ) && empty( $identity['family'] ) && ! empty( $identity['display_name'] ) ) {
				$data['name']      = $identity['display_name'];
				$data['firstname'] = $identity['display_name'];
			}

			$result = $this->request( '/subscribe', $data );

			if ( 'true' === $result || strpos( $result, 'subscribed' ) || strpos( $result, 'confirmation email' ) ) {
				return array( 'status' => 'subscribed' );
			} else {
				throw new Exception( $result );
			}
		}

		// if already subscribed
		$success = array( 'subscribed', 'unsubscribed', 'bounced', 'soft bounced', 'unconfirmed', 'complained' );
		if ( ! in_array( strtolower( $result ), $success ) ) {
			throw new Exception( $result );
		}

		if ( 'subscribed' === strtolower( $result ) ) {
			return array( 'status' => 'subscribed' );
		} else {
			return array( 'status' => 'pending' );
		}

		throw new Exception( esc_html__( 'Unknown error.', 'content-locker' ) );
	}
}
