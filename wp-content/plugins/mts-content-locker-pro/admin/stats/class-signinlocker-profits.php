<?php
/**
 * The Chart for Detailed Screen
 */
class CL_Stats_SigninLocker_Profits_Chart extends CL_Stats_Chart {

	public $type = 'line';

	public function get_fields() {

		return array(
			'aggregate_date'         => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'account-registered'     => array(
				'title' => esc_html__( 'Accounts', 'content-locker' ),
				'color' => '#336699',
			),
			'got-twitter-follower'   => array(
				'title' => esc_html__( 'Twitter Tweets', 'content-locker' ),
				'color' => '#3bb4ea',
			),
			'tweet-posted'           => array(
				'title' => esc_html__( 'Twitter Followers', 'content-locker' ),
				'color' => '#1e92c9',
			),
			'got-youtube-subscriber' => array(
				'title' => esc_html__( 'Youtube Subscribers', 'content-locker' ),
				'color' => '#ba5145',
			),
			'got-linkedin-follower'  => array(
				'title' => esc_html__( 'LinkedIn Followers', 'content-locker' ),
				'color' => '#006080',
			),
		);
	}
}

/**
 * The Table for Detailed Screen
 */
class CL_Stats_SigninLocker_Profits_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'                  => array(
				'title' => '',
			),
			'title'                  => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'unlock'                 => array(
				'title'     => esc_html__( 'Total', 'content-locker' ),
				'hint'      => esc_html__( 'The total number of unlocks made by visitors.', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'emails'                 => array(
				'title'     => esc_html__( 'Emails', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new emails added to the database. If the email exists in the database, this email will not be counted.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
			'account-registered'     => array(
				'title'     => esc_html__( 'Accounts', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new accounts created for visitors.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
				'prefix'    => '+',
			),
			'got-twitter-follower'   => array(
				'title'     => esc_html__( 'Twitter Followers', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new followers attracted via the locker. If the user was a follower before, this user will not be counted.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
				'prefix'    => '+',
			),
			'tweet-posted'           => array(
				'title'     => esc_html__( 'Tweets', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new tweets posted via the locker.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
				'prefix'    => '+',
			),
			'got-youtube-subscriber' => array(
				'title'     => esc_html__( 'Youtube Subscribers', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new subscribers attracted via the locker. If the user was a subscribers before, this user will not be counted.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
				'prefix'    => '+',
			),
			'got-linkedin-follower'  => array(
				'title'     => esc_html__( 'LinkedIn Followers', 'content-locker' ),
				'hint'      => esc_html__( 'The number of new followers attracted via the locker. If the user was a follower before, this user will not be counted.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
				'prefix'    => '+',
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
