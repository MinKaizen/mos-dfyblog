<?php
/**
 * The Chart for Detailed Screen
 */
class CL_Stats_SocialLocker_Detailed_Chart extends CL_Stats_Chart {

	public $type = 'line';

	public function get_fields() {

		return array(
			'aggregate_date'               => array(
				'title' => esc_html__( 'Date', 'content-locker' ),
			),
			'unlock-via-facebook-like'     => array(
				'title' => esc_html__( 'FB Likes', 'content-locker' ),
				'color' => '#7089be',
			),
			'unlock-via-facebook-share'    => array(
				'title' => esc_html__( 'FB Shares', 'content-locker' ),
				'color' => '#566a93',
			),
			'unlock-via-twitter-tweet'     => array(
				'title' => esc_html__( 'Tweets', 'content-locker' ),
				'color' => '#3ab9e9',
			),
			'unlock-via-twitter-follow'    => array(
				'title' => esc_html__( 'Twitter Followers', 'content-locker' ),
				'color' => '#1c95c3',
			),
			'unlock-via-google-plus'       => array(
				'title' => esc_html__( 'Google +1s', 'content-locker' ),
				'color' => '#e26f61',
			),
			'unlock-via-google-share'      => array(
				'title' => esc_html__( 'Google Shares', 'content-locker' ),
				'color' => '#ba5145',
			),
			'unlock-via-youtube-subscribe' => array(
				'title' => esc_html__( 'YouTube', 'content-locker' ),
				'color' => '#8f352b',
			),
			'unlock-via-linkedin-share'    => array(
				'title' => esc_html__( 'LinkedIn Shares', 'content-locker' ),
				'color' => '#006080',
			),
		);
	}
}

/**
 * The Table for Detailed Screen
 */
class CL_Stats_SocialLocker_Detailed_Table extends CL_Stats_Table {

	public function get_columns() {

		return array(
			'index'    => array(
				'title' => '',
			),
			'title'    => array(
				'title' => esc_html__( 'Post Title', 'content-locker' ),
			),
			'unlock'   => array(
				'title'     => esc_html__( 'Total', 'content-locker' ),
				'hint'      => esc_html__( 'The total number of unlocks made by visitors.', 'content-locker' ),
				'highlight' => true,
				'css_class' => 'mts-cl-col-number',
			),
			'channels' => array(
				'title'     => esc_html__( 'Unlocks Via', 'content-locker' ),
				'css_class' => 'mts-cl-col-common',
				'columns'   => array(
					'unlock-via-facebook-like'     => array(
						'title'     => esc_html__( 'FB Like', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-facebook-share'    => array(
						'title'     => esc_html__( 'FB Share', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-twitter-tweet'     => array(
						'title'     => esc_html__( 'Twitter Tweet', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-twitter-follow'    => array(
						'title'     => esc_html__( 'Twitter Follow', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-google-plus'       => array(
						'title'     => esc_html__( 'Google +1s', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-google-share'      => array(
						'title'     => esc_html__( 'Google Share', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-youtube-subscribe' => array(
						'title'     => esc_html__( 'YouTube', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
					'unlock-via-linkedin-share'    => array(
						'title'     => esc_html__( 'LinkedIn Share', 'content-locker' ),
						'css_class' => 'mts-cl-col-number',
					),
				),
			),
		);
	}
}
