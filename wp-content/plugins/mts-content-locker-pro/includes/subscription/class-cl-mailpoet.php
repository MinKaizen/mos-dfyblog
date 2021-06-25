<?php
/**
 * MailPoet Subscription
 */
class CL_Subscription_MailPoet extends CL_Subscription_Base {

	public function get_lists( $api_key ) {

		return array();
	}

	public function subscribe( $identity, $context, $options ) {

		if ( ! defined( 'WYSIJA' ) ) {
			throw new Exception( esc_html__( 'The MailPoet plugin is not found on your website.', 'content-locker' ) );
		}

		$user_model = WYSIJA::get( 'user', 'model' );
		$user_list  = WYSIJA::get( 'user_list', 'model' );
		$manager    = WYSIJA::get( 'user', 'helper' );
		$list_id    = $options['list'];
		$subscriber = $user_model->getOne( false, array( 'email' => $identity['email'] ) );

		$customs = array();
		if ( ! empty( $identity['name'] ) ) {
			$customs['firstname'] = $identity['name'];
		}
		if ( ! empty( $identity['family'] ) ) {
			$customs['lastname'] = $identity['family'];
		}
		if ( empty( $customs['name'] ) && ! empty( $identity['display_name'] ) ) {
			$customs['firstname'] = $identity['display_name'];
		}

		// if user exists.
		if ( ! empty( $subscriber ) ) {

			$subscriber_id = intval( $subscriber['user_id'] );

			// adding the user to the specified list if the user has not been yet added
			$lists = $user_list->get_lists( array( $subscriber_id ) );

			if ( ! isset( $lists[ $subscriber_id ] ) || ! in_array( $list_id, $lists[ $subscriber_id ] ) ) {
				$manager->addToList( $list_id, array( $subscriber_id ) );
			}

			if ( isset( $customs['firstname'] ) || isset( $customs['lastname'] ) ) {

				$model_user = WYSIJA::get( 'user', 'model' );

				if ( isset( $customs['firstname'] ) ) {
					$data['firstname'] = trim( $customs['firstname'] );
				}
				if ( isset( $customs['lastname'] ) ) {
					$data['lastname'] = trim( $customs['lastname'] );
				}

				if ( empty( $customs['firstname'] ) ) {
					$customs['firstname'] = $subscriber['firstname'];
				}
				if ( empty( $customs['lastname'] ) ) {
					$customs['lastname'] = $subscriber['lastname'];
				}

				$model_user->update( $customs, array( 'user_id' => $subscriber_id ) );
			}

			return array( 'status' => 'subscribed' );
		}

		// if new user
		$ip           = $manager->getIP();
		$double_optin = isset( $options['double_optin'] ) && $options['double_optin'] ? true : false;
		$user_data    = array(
			'email'      => $identity['email'],
			'status'     => $identity['social'] ? 1 : ( ! $double_optin ? 1 : 0 ),
			'ip'         => $ip,
			'created_at' => time(),
		);

		if ( ! empty( $identity['name'] ) ) {
			$user_data['firstname'] = $identity['name'];
		}

		if ( ! empty( $identity['family'] ) ) {
			$user_data['lastname'] = $identity['family'];
		}

		if ( empty( $identity['name'] ) && empty( $identity['family'] ) && ! empty( $identity['displayName'] ) ) {
			$user_data['firstname'] = $identity['displayName'];
		}

		$subscriber_id = $user_model->insert( $user_data );

		// adds custom fields
		WJ_FieldHandler::handle_all( $customs, $subscriber_id );

		if ( ! $subscriber_id ) {
			throw new Exception( '[subscribe]: Unable to add a subscriber.' );
		}

		// adds the user the the specified list
		$manager->addToList( $list_id, array( $subscriber_id ) );

		return array( 'status' => 'subscribed' );
	}
}
