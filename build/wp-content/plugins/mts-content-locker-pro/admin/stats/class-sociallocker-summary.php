<?php
/**
 * The Chart for Summary Screen
 */
class CL_Stats_SocialLocker_Summary_Chart extends CL_Stats_Chart {

	public function get_selectors() {
		return null;
	}

	public function get_fields() {

		return array(
			'aggregate_date' => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'unlock'         => array(
				'title' => esc_html__( 'Number of Unlocks', 'content-locker' ),
				'color' => '#0074a2',
			),
		);
	}
}

/**
 * The Table for Summary Screen
 */
class CL_Stats_SocialLocker_Summary_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'      => array(
				'title' => '',
			),
			'title'      => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'impress'    => array(
				'title'     => esc_html__( 'Impressions', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
			'unlock'     => array(
				'title'     => esc_html__( 'Number of Unlocks', 'content-locker' ),
				'hint'      => esc_html__( 'The number of unlocks made by visitors.', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'conversion' => array(
				'title'     => esc_html__( 'Conversion', 'content-locker' ),
				'hint'      => esc_html__( 'The ratio of the number of unlocks to impressions, in percentage.', 'content-locker' ),
				'css_class' => 'mts-cl-col-number',
			),
		);
	}
}
