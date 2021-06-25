<?php
/**
 * ConstantContact Subscription
 */
use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;

class CL_Subscription_ConstantContact extends CL_Subscription_Base {

	public function init( $api_key ) {

		require_once 'libs/constant-contact/autoload.php';
		return new ConstantContact( $api_key );
	}

	public function get_lists( $api_key, $token ) {

		$api    = $this->init( $api_key );
		$result = $api->listService->getLists( $token );

		$lists = array();
		foreach ( $result as $id => $list ) {
			$lists[ $list->id ] = $list->name;
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$api = $this->init( $options['api_key'] );

		$vars = array(
			'status'          => 'ACTIVE',
			'email_addresses' => array(
				array( 'email_address' => $identity['email'] ),
			),
			'lists'           => array(
				array( 'id' => $options['list'] ),
			),
		);

		if ( ! empty( $identity['name'] ) ) {
			$vars['first_name'] = $identity['name'];
		}

		try {

			$api->contactService->addContact( $options['access_token'], Contact::create( $vars ) );
		} catch ( Exception $e ) {

			if ( false === strpos( $e->getErrors()[0]->error_message, 'already exists' ) ) {
				throw new Exception( $e->getErrors()[0]->error_message );
			}
		}

		return array( 'status' => 'subscribed' );
	}
}
