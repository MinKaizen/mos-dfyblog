<?php
/**
 * Aweber Subscription
 */
class CL_Subscription_Aweber extends CL_Subscription_Base {

	public function init() {

		if ( ! class_exists( 'AWeberAPI' ) ) {
			require_once 'libs/aweber_api/aweber.php';
		}

		$this->connect();
		$credentials = $this->get_credentials();

		if ( empty( $credentials['consumer_key'] ) || empty( $credentials['consumer_secret'] ) ) {
			throw new Exception( 'Aweber is not connected.' );
		}

		if ( empty( $credentials['account_id'] ) ) {
			throw new Exception( 'The Aweber Account ID is not set.' );
		}

		return new AWeberAPI( $credentials['consumer_key'], $credentials['consumer_secret'] );
	}

	public function get_credentials() {

		if ( ! empty( $this->credentials ) ) {
			return $this->credentials;
		}

		$credentials = array(
			'consumer_key'    => get_option( '_mts_cl_aweber_consumer_key' ),
			'consumer_secret' => get_option( '_mts_cl_aweber_consumer_secret' ),
			'access_key'      => get_option( '_mts_cl_aweber_access_key' ),
			'access_secret'   => get_option( '_mts_cl_aweber_access_secret' ),
			'account_id'      => get_option( '_mts_cl_aweber_account_id' ),
		);

		$credentials = array_filter( $credentials );

		$this->credentials = empty( $credentials ) ? null : $credentials;

		return $this->credentials;
	}

	public function connect() {

		$credentials = $this->get_credentials();

		if ( ! empty( $credentials ) ) {
			return;
		}

		// if the auth code is empty, show the error
		if ( empty( $this->api_key ) ) {
			throw new Exception( esc_html__( 'Unable to connect to Aweber. The Authorization Code is empty.', 'content-locker' ) );
		}

		if ( ! class_exists( 'AWeberAPI' ) ) {
			require_once 'libs/aweber_api/aweber.php';
		}

		list( $consumer_key, $consumer_secret, $access_key, $access_secret ) = AWeberAPI::getDataFromAweberID( $this->api_key );

		if ( empty( $consumer_key ) || empty( $consumer_secret ) || empty( $access_key ) || empty( $access_secret ) ) {
			throw new Exception( esc_html__( 'Unable to connect your Aweber Account. The Authorization Code is incorrect.', 'content-locker' ) );
		}

		$aweber  = new AWeberAPI( $consumer_key, $consumer_secret );
		$account = $aweber->getAccount( $access_key, $access_secret );

		$credentials = array(
			'consumer_key'    => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'access_key'      => $access_key,
			'access_secret'   => $access_secret,
			'account_id'      => $account->id,
		);

		// saves the credential
		if ( $credentials && sizeof( $credentials ) ) {
			foreach ( $credentials as $key => $value ) {
				update_option( '_mts_cl_aweber_' . $key, $value );
			}
		}

		$this->credentials = $credentials;
	}

	public function get_account() {

		$aweber      = $this->init();
		$credentials = $this->get_credentials();

		if ( empty( $credentials['access_key'] ) || empty( $credentials['access_secret'] ) ) {
			throw new Exception( '[init]: Aweber is not connected.' );
		}

		return $aweber->getAccount( $credentials['access_key'], $credentials['access_secret'] );
	}

	public function get_lists( $api_key = '' ) {

		$this->api_key = $api_key;
		$account       = $this->get_account();

		$lists = array();
		foreach ( $account->lists->data['entries'] as $list ) {
			$lists[ $list['id'] ] = $list['name'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		try {
			$account     = $this->get_account();
			$credentials = $this->get_credentials();
			$list_url    = "/accounts/{$account->id}/lists/{$options['list']}/subscribers";
			$list        = $account->loadFromUrl( $list_url );

			$name   = $this->get_fullname( $identity );
			$params = array(
				'name'        => $name,
				'email'       => $identity['email'],
				'ip_address'  => $_SERVER['REMOTE_ADDR'],
				'ad_tracking' => 'mythemeshop',
			);

			$result = $list->create( $params );

			return array(
				'status' => 'subscribed',
			);
		} catch ( Exception $e ) {

			// already waiting confirmation:
			// "Subscriber already subscribed and has not confirmed."
			if ( strpos( $e->getMessage(), 'has not confirmed' ) ) {
				return array( 'status' => 'pending' );
			}

			// already waiting confirmation:
			// "Subscriber already subscribed."
			if ( strpos( $e->getMessage(), 'already subscribed' ) ) {
				return array( 'status' => 'pending' );
			}

			throw new Exception( '[subscribe]: ' . $e->getMessage() );
		}
	}
}
