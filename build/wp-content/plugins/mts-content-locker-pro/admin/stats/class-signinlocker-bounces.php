<?php
/**
 * The Chart for Detailed Screen
 */
class CL_Stats_SigninLocker_Bounces_Chart extends CL_Stats_Chart {

	public $type = 'column';

	public function get_fields() {

		return array(
			'aggregate_date' => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'errors'         => array(
				'title' => esc_html__( 'Who Faced Errors', 'content-locker' ),
				'color' => '#F97D81',
			),
			'social-fails'   => array(
				'title' => esc_html__( 'Who Declined Social Apps', 'content-locker' ),
				'color' => '#29264E',
			),
		);
	}

	public function field_errors( $row ) {

		if ( ! isset( $row['error'] ) ) {
			$row['error'] = 0;
		}

		return $row['error'];
	}

	public function field_social_fails( $row ) {

		if ( ! isset( $row['social-app-declined'] ) ) {
			$row['social-app-declined'] = 0;
		}

		return $row['social-app-declined'];
	}
}

/**
 * The Table for Detailed Screen
 */
class CL_Stats_SigninLocker_Bounces_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'   => array(
				'title' => '',
			),
			'title'   => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'impress' => array(
				'title'     => esc_html__( 'Impressions', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'users'   => array(
				'title'     => esc_html__( 'Visitors Who', 'content-locker' ),
				'css_class' => 'mts-cl-col-common',
				'columns'   => array(
					'errors'       => array(
						'title'     => esc_html__( 'Faced Errors', 'content-locker' ),
						'hint'      => esc_html__( 'Visitors who faced with any errors and were not able to unlock the content. This value normally should be equal 0. If not, please check settings of your locker or contact OnePress support.', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'social-fails' => array(
						'title'     => esc_html__( 'Declined Social Apps', 'content-locker' ),
						'hint'      => esc_html__( 'Visitors who refused to authorize of your social apps. If you think this value is too large, try to set less social actions to be performed on signing in through social networks.', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
				),
			),
		);
	}

	public function column_errors( $row ) {

		if ( ! isset( $row['error'] ) ) {
			$row['error'] = 0;
		}

		echo $row['error'];
	}

	public function column_social_fails( $row ) {

		if ( ! isset( $row['social-app-declined'] ) ) {
			$row['social-app-declined'] = 0;
		}

		echo $row['social-app-declined'];
	}
}
