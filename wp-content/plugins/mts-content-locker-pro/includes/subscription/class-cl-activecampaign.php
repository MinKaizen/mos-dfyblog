<?php
/**
 * ActiveCampaign Subscription
 */

class CL_Subscription_ActiveCampaign extends CL_Subscription_Base {

	public function init( $api_key, $api_url ) {

		require_once 'libs/activecampaign/ActiveCampaign.class.php';
		return new ActiveCampaign( $api_url, $api_key );
	}

	public function get_lists( $api_key, $api_url ) {

		$api    = $this->init( $api_key, $api_url );
		$result = $api->api( 'list/list?ids=all' );

		$lists = array();
		if ( isset( $result->success ) ) {

			$result = $this->clean_output( $result );
			foreach ( $result as $list ) {

				$lists[ $list->id ] = $list->name;
			}
		}

		return $lists;
	}

	public function subscribe( $identity, $context, $options ) {

		$api = $this->init( $options['api_key'], $options['api_url'] );

		$first_name = $last_name = '';

		$email   = $identity['email'];
		$list_id = $options['list'];

		if ( ! empty( $identity['name'] ) ) {
			$first_name = $identity['name'];
		}
		if ( ! empty( $identity['family'] ) ) {
			$last_name = $identity['family'];
		}
		if ( empty( $first_name ) && ! empty( $identity['display_name'] ) ) {
			$first_name = $identity['display_name'];
		}

		$response = $api->api( 'contact/view?email=' . $email );
		$exists   = isset( $response->id );

		$data = array(
			'email' => $email,
			'ip4'   => $_SERVER['REMOTE_ADDR'],
		);

		if ( ! empty( $first_name ) ) {
			$data['first_name'] = $first_name;
		}
		if ( ! empty( $last_name ) ) {
			$data['last_name'] = $last_name;
		}
		$data[ 'status[' . $list_id . ']' ]            = 1;
		$data[ 'instantresponders[' . $list_id . ']' ] = 1;

		// already exits
		if ( $exists ) {

			$lists = explode( '-', $response->listslist );

			if ( ! in_array( '' . $list_id, $lists ) ) {

				$data['id'] = $response->id;

				$lists[] = $list_id;
				foreach ( $lists as $list_id ) {
					$data[ 'p[' . $list_id . ']' ] = $list_id;
				}

				$api->api( 'contact/edit', $data );
			}

			return array(
				'status' => 'subscribed',
			);
		}

		$data[ 'p[' . $list_id . ']' ] = $list_id;

		$result = $api->api( 'contact/add', $data );

		if ( isset( $result->error ) ) {
			throw new Exception( $result->error );
		}

		if ( isset( $result->success ) && isset( $result->subscriber_id ) ) {
			return array(
				'status' => 'subscribed',
			);
		}

		throw new Exception( esc_html__( 'Unknown error.', 'content-locker' ) );
	}

	private function clean_output( $result ) {

		unset( $result->result_code, $result->result_message, $result->result_output, $result->http_code, $result->success );

		return $result;
	}
}
