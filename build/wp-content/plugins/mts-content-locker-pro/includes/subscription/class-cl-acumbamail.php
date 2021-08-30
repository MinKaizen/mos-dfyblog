<?php
/**
 * Acumbamail Subscription
 */
class CL_Subscription_Acumbamail extends CL_Subscription_Base {

	public function init( $customer_id, $auth_token ) {

		require_once 'libs/acumbamail.php';
		return new AcumbamailAPI( $customer_id, $auth_token );
	}

	public function get_lists( $customer_id, $auth_token ) {

		$api    = $this->init( $customer_id, $auth_token );
		$result = $api->getLists();

		$lists = array();
		foreach ( $result as $id => $list ) {
			$lists[ $id ] = $list['name'];
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$api = $this->init( $options['customer_id'], $options['api_token'] );

		$fields = $identity;
		if ( ! empty( $identity['name'] ) ) {
			$fields['nombre'] = $identity['name'];
			$fields['name']   = $identity['name'];
		}

		if ( ! empty( $identity['family'] ) ) {
			$fields['apellidos'] = $identity['family'];
			$fields['family']    = $identity['family'];
			$fields['lastname']  = $identity['family'];
			$fields['family']    = $identity['family'];
		}

		if ( empty( $identity['name'] ) && ! empty( $identity['display_name'] ) ) {
			$fields['nombre'] = $identity['display_name'];
			$fields['name']   = $identity['display_name'];
		}

		$double_optin = isset( $options['double_optin'] ) && $options['double_optin'] ? 1 : 0;
		$result       = $api->addSubscriber( $options['list'], $fields, $double_optin );

		if ( isset( $result['error'] ) ) {

			if ( false === strpos( $result['error'], 'already exists' ) ) {
				throw new Exception( $result['error'] );
			}
		}

		return array(
			'status' => 'subscribed',
		);
	}
}
