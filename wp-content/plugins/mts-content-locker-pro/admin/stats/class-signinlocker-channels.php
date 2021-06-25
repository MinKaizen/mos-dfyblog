<?php
/**
 * The Chart for Detailed Screen
 */
class CL_Stats_SigninLocker_Channels_Chart extends CL_Stats_Chart {

	public $type = 'line';

	public function get_fields() {

		return array(
			'aggregate_date'      => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'unlock-via-email'    => array(
				'title' => esc_html__( 'Via Opt-In Form', 'content-locker' ),
				'color' => '#31ccab',
			),
			'unlock-via-facebook' => array(
				'title' => esc_html__( 'Via Facebook', 'content-locker' ),
				'color' => '#7089be',
			),
			'unlock-via-twitter'  => array(
				'title' => esc_html__( 'Via Twitter', 'content-locker' ),
				'color' => '#3ab9e9',
			),
			'unlock-via-google'   => array(
				'title' => esc_html__( 'Via Google', 'content-locker' ),
				'color' => '#e26f61',
			),
			'unlock-via-linkedin' => array(
				'title' => esc_html__( 'Via LinkedIn', 'content-locker' ),
				'color' => '#006080',
			),
		);
	}
}

/**
 * The Table for Detailed Screen
 */
class CL_Stats_SigninLocker_Channels_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'               => array(
				'title' => '',
			),
			'title'               => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'unlock'              => array(
				'title'     => esc_html__( 'Number of Unlocks', 'content-locker' ),
				'hint'      => esc_html__( 'The number of unlocks made by visitors.', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'unlock-via-email'    => array(
				'title'     => esc_html__( 'Via Opt-In Form', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
			'unlock-via-facebook' => array(
				'title'     => esc_html__( 'Via Facebook', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
			'unlock-via-twitter'  => array(
				'title'     => esc_html__( 'Via Twitter', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
			'unlock-via-google'   => array(
				'title'     => esc_html__( 'Via Google', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
			'unlock-via-linkedin' => array(
				'title'     => esc_html__( 'Via LinkedIn', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
		);
	}
}
