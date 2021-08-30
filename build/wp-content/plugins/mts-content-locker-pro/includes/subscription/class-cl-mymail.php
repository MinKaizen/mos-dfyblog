<?php
/**
 * MyMail Subscription
 */
class CL_Subscription_MyMail extends CL_Subscription_Base {

	public function get_lists( $api_key ) {

		return array();
	}

	public function init() {

		if ( ! defined( 'MYMAIL_VERSION' ) ) {
			throw new Exception( esc_html__( 'The MyMail plugin is not found on your website.', 'content-locker' ) );
		}

		$path = MYMAIL_DIR . '/classes/subscribers.class.php';
		if ( ! file_exists( $path ) ) {
			throw new Exception( esc_html__( 'Unable to connect with the MyMail Subscribers Manager. Your version of MyMail plugin is not supported. Please contact OnePress support.', 'content-locker' ) );
		}

		require_once $path;

		if ( ! class_exists( 'mymail_subscribers' ) ) {
			throw new Exception( esc_html__( 'Unable to connect with the MyMail Subscribers Manager. Your version of MyMail plugin is not supported. Please contact OnePress support.', 'content-locker' ) );
		}

		return mymail( 'subscribers' );
	}

	public function subscribe( $identity, $context, $options ) {

		$manager = $this->getSubscribersManager();
		$list_id = $options['list'];

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
		$subscriber = $manager->get_by_mail( $identity['email'] );
		if ( ! empty( $subscriber ) ) {

			$lists = $manager->get_lists( $subscriber->ID, true );
			if ( ! in_array( $list_id, $lists ) ) {
				$manager->assign_lists( $subscriber->ID, $list_id, false );
			}

			$manager->update( $customs );

			return array( 'status' => 'subscribed' );
		}

		// if it's a new subscriber
		$ip = mymail_option( 'track_users' ) ? mymail_get_ip() : null;

		$double_optin         = isset( $options['double_optin'] ) && $options['double_optin'] ? true : false;
		$customs['status']    = $identity['social'] ? 1 : ( ! $double_optin ? 1 : 0 );
		$customs['ip_signup'] = $ip;
		$customs['ip']        = $ip;
		$customs['referer']   = isset( $context['postUrl'] ) ? $context['postUrl'] : null;

		// the method 'add' sends the confirmation email if the status = 0,
		// we need to replace the original confirmation link with our own link,
		// then we turn on the constant MYMAIL_DO_BULKIMPORT to prevent sending the confirmation email
		// in the methid 'add'

		define( 'MYMAIL_DO_BULKIMPORT', true );

		$result = $manager->add( $customs, false );
		if ( is_wp_error( $result ) ) {
			throw new Exception( '[subscribe]: ' . $result->get_error_message() );
		}

		$manager->assign_lists( $result, $list_id, true );

		return array( 'status' => 'subscribed' );
	}
}
