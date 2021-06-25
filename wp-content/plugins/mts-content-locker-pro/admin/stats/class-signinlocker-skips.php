<?php
/**
 * The Chart for Summary Screen
 */
class CL_Stats_SigninLocker_Skips_Chart extends CL_Stats_Chart {

	public $type = 'column';

	public function get_fields() {

		return array(
			'aggregate_date' => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'unlock'         => array(
				'title' => esc_html__( 'Number of Unlocks', 'content-locker' ),
				'color' => '#0074a2',
			),
			'skip-via-timer' => array(
				'title' => esc_html__( 'Skipped by Timer', 'content-locker' ),
				'color' => '#333333',

			),
			'skip-via-cross' => array(
				'title' => esc_html__( 'Skipped by Close Icon', 'content-locker' ),
				'color' => '#dddddd',
			),
		);
	}
}

/**
 * The Table for Summary Screen
 */
class CL_Stats_SigninLocker_Skips_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'          => array(
				'title' => '',
			),
			'title'          => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'unlock'         => array(
				'title'     => esc_html__( 'Number of Unlocks', 'content-locker' ),
				'hint'      => esc_html__( 'The number of unlocks made by visitors.', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'skip-via-timer' => array(
				'title'     => esc_html__( 'Skipped by Timer', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',

			),
			'skip-via-cross' => array(
				'title'     => esc_html__( 'Skipped by Close Icon', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
		);
	}
}
