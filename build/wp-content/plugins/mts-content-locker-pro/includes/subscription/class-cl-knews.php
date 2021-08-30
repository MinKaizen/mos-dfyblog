<?php
/**
 * Knews Subscription
 */
class CL_Subscription_Knews extends CL_Subscription_Base {

	public function get_lists( $api_key ) {

		return array();
	}

	public function subscribe( $identity, $context, $options ) {

		if ( ! class_exists( 'KnewsPlugin' ) ) {
			throw new Exception( __( 'The Knews plugin is not found on your website.', 'content-locker' ) );
		}

		global $Knews_plugin;

		$customs = array();
		if ( ! empty( $identity['name'] ) ) {
			$customs['name'] = $identity['name'];
		}
		if ( ! empty( $identity['family'] ) ) {
			$customs['surname'] = $identity['family'];
		}
		if ( empty( $customs['name'] ) && ! empty( $identity['display_name'] ) ) {
			$customs['name'] = $identity['display_name'];
		}

		$double_optin = isset( $options['double_optin'] ) && $options['double_optin'] ? false : true;
		$result       = $Knews_plugin->add_user_db( 0, $identity['email'], $options['list'], 'en', 'en_US', $this->mapExtraFields( $customs ), $double_optin );

		if ( 4 == $result ) {
			throw new Exception( '[subscribe]: Unable to add a subscriber.' );
		}

		return array( 'status' => 'subscribed' );
	}

	protected function mapExtraFields( $custom_fields ) {
		global $wpdb;

		$rows = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'knewsextrafields' );

		$result = array();
		foreach ( $rows as $row ) {
			if ( ! isset( $custom_fields[ $row->name ] ) ) {
				continue;
			}
			$result[ $row->id ] = $custom_fields[ $row->name ];
		}

		return $result;
	}
}
