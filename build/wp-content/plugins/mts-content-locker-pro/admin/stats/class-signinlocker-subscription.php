<?php
/**
 * The Chart for Detailed Screen
 */
class CL_Stats_SigninLocker_Subscription_Chart extends CL_Stats_Chart {

	public $type = 'line';

	public function get_fields() {

		return array(
			'aggregate_date'  => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'email-received'  => array(
				'title' => esc_html__( 'Emails Collected', 'content-locker' ),
				'color' => '#FFCC66',
			),
			'email-confirmed' => array(
				'title' => esc_html__( 'Subscriptions Confirmed', 'content-locker' ),
				'color' => '#336699',
			),
		);
	}
}

/**
 * The Table for Detailed Screen
 */
class CL_Stats_SigninLocker_Subscription_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'  => array(
				'title' => '',
			),
			'title'  => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'unlock' => array(
				'title'     => esc_html__( 'Total', 'content-locker' ),
				'hint'      => esc_html__( 'The total number of unlocks made by visitors.', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'emails' => array(
				'title'     => esc_html__( 'Emails Collected', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new emails added to the database. If the email exists in the database, this email will not be counted.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
		);
	}

	public function column_emails( $row ) {

		if ( ! isset( $row['email-received'] ) ) {
			$row['email-received'] = 0;
		}

		if ( ! isset( $row['email-confirmed'] ) ) {
			$row['email-confirmed'] = 0;
		}

		if ( $row['email-received'] > 0 ) {
			echo '+';
		}

		echo $row['email-received'];
	}
}
