<?php
/**
 * Comparison table shortcode
 *
 * @package WP_Review
 * @since 3.0.0
 */

/**
 * Class WP_Review_Comparison_Table_Shortcode
 */
class WP_Review_Comparison_Table_Shortcode {

	/**
	 * Shortcode name.
	 *
	 * @var string
	 */
	protected $name = 'wp-review-comparison-table';

	/**
	 * Shortcode alias.
	 *
	 * @var string
	 */
	protected $alias = 'wp_review_comparison_table';

	/**
	 * Class init.
	 */
	public function init() {
		add_shortcode( $this->name, array( $this, 'render' ) );
		add_shortcode( $this->alias, array( $this, 'render' ) );
	}

	/**
	 * Renders shortcode.
	 *
	 * @param  array $atts Shortcode attributes.
	 * @return string
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'ids' => '',
			),
			$atts,
			$this->name
		);

		$atts['ids'] = trim( $atts['ids'] );
		if ( ! $atts['ids'] ) {
			return '';
		}

		$query = $this->get_query( $atts );
		if ( ! $query->have_posts() ) {
			return '';
		}

		wp_enqueue_script( 'stacktable' );

		ob_start();
		wp_review_load_template( 'shortcodes/comparison-table.php', compact( 'query', 'atts' ) );
		return ob_get_clean();
	}

	/**
	 * Gets query from attributes.
	 *
	 * @param  array $atts Shortcode attributes.
	 * @return WP_Query
	 */
	protected function get_query( $atts ) {
		$post_ids = explode( ',', $atts['ids'] );
		$post_ids = array_map( 'absint', $post_ids );

		$query_args = array(
			'post__in'            => $post_ids,
			'orderby'             => 'post__in',
			'post_type'           => 'any',
			'nopaging'            => true,
			'ignore_sticky_posts' => true,
		);

		/**
		 * Allows changing comparison table query args.
		 *
		 * @since 3.3.5
		 *
		 * @param array $query_args Query args.
		 * @param array $atts       Shortcode atts.
		 */
		$query_args = apply_filters( 'wp_review_comparison_table_query_args', $query_args, $atts );

		return new WP_Query( $query_args );
	}
}

$shortcode = new WP_Review_Comparison_Table_Shortcode();
$shortcode->init();
