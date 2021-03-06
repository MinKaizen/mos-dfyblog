<?php
/**
 * Shortcodes
 *
 * @package WP_Review
 * @since 3.0.0
 */

// Requires shortcode files.
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-comparison-table-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-yelp-search-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-yelp-business-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-yelp-business-reviews-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-google-place-reviews-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-google-place-average-rating-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-facebook-reviews-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-posts-shortcode.php';
require_once WP_REVIEW_INCLUDES . 'shortcodes/class-wp-review-badge-shortcode.php';

add_shortcode( 'wp-review', 'wp_review_shortcode' );
add_shortcode( 'wp-review-total', 'wp_review_total_shortcode' );
add_shortcode( 'wp-review-visitor-rating', 'wp_review_visitor_rating_shortcode' );
add_shortcode( 'wp-review-comments-rating', 'wp_review_comments_rating_shortcode' );

// Aliasess.
add_shortcode( 'wp_review', 'wp_review_shortcode' );
add_shortcode( 'wp_review_total', 'wp_review_total_shortcode' );
add_shortcode( 'wp_review_visitor_rating', 'wp_review_visitor_rating_shortcode' );
add_shortcode( 'wp_review_comments_rating', 'wp_review_comments_rating_shortcode' );


/**
 * Shortcode [wp-review] handler.
 *
 * @param  array $atts Shortcode attributes.
 * @return string      Shortcode output.
 */
function wp_review_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => null,
		),
		$atts,
		'wp-review'
	);

	// Make sure jquery appear is enqueued.
	wp_enqueue_script( 'wp_review-jquery-appear' );

	$output = wp_review_get_data( $atts['id'] );

	return apply_filters( 'wp_review_shortcode', $output, $atts );
}


/**
 * Shortcode [wp-review-total] handler.
 *
 * @param  array $atts Shortcode attributes.
 * @return string      Shortcode output.
 */
function wp_review_total_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'      => null,
			'class'   => 'review-total-only review-total-shortcode',
			'context' => '',
		),
		$atts,
		'wp-review-total'
	);

	$args = array(
		'shortcode'            => true,
		'circle_width'         => 100,
		'circle_height'        => 100,
		'circle_display_input' => true,
	);

	if ( 'product-rating' === $atts['context'] ) {
		$args = array(
			'color'          => '#fff',
			'inactive_color' => '#dedcdc',
			'context'        => 'product-rating',
		);
	}

	$output = wp_review_show_total( false, $atts['class'], $atts['id'], $args );

	return apply_filters( 'wp_review_total_shortcode', $output, $atts );
}


/**
 * Shortcode [wp-review-visitor-rating] handler.
 *
 * @param  array $atts Shortcode attributes.
 * @return string      Shortcode output.
 */
function wp_review_visitor_rating_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => get_the_ID(),
		),
		$atts,
		'wp-review-visitor-rating'
	);

	wp_enqueue_style( 'wp_review-style' );
	wp_enqueue_script( 'wp_review-jquery-appear' );
	wp_enqueue_script( 'wp_review-js' );

	ob_start();
	$post_reviews = mts_get_post_reviews( $atts['id'] );
	$value        = $post_reviews['rating'];
	$count        = $post_reviews['count'];
	?>
	<div class="user-review-area wp-review-<?php echo esc_attr( $atts['id'] ); ?> review-wrapper">
		<div class="visitor-rating-shortcode delay-animation">
			<?php echo wp_review_user_rating( $atts['id'] ); ?>
			<div class="user-total-wrapper">
				<span class="user-review-title"><?php esc_html_e( 'User Rating', 'wp-review' ); ?></span>
				<span class="review-total-box">
					<span class="wp-review-user-rating-total"><?php echo esc_html( $value ); ?></span>
					<small>
						<?php
						printf(
							// Translators: reviews count.
							esc_html__( '(%s vote)', 'wp-review' ),
							'<span class="wp-review-user-rating-counter">' . esc_html( $count ) . '</span>'
						);
						?>
					</small>
				</span>
			</div>
		</div>

	</div>
	<?php
	$text = ob_get_clean();
	return apply_filters( 'wp_review_visitor_rating_shortcode', $text, $atts );
}


/**
 * Shortcode [wp-review-comments-rating] handler.
 *
 * @param  array $atts Shortcode attributes.
 * @return string      Shortcode output.
 */
function wp_review_comments_rating_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => get_the_ID(),
		),
		$atts,
		'wp-review-comments-rating'
	);

	wp_enqueue_style( 'wp_review-style' );
	wp_enqueue_script( 'wp_review-jquery-appear' );
	wp_enqueue_script( 'wp_review-js' );

	ob_start();
	?>
	<div class="user-review-area comments-review-area wp-review-<?php echo esc_attr( $atts['id'] ); ?> review-wrapper">
		<div class="comments-rating-shortcode delay-animation">
			<?php echo wp_review_user_comments_rating( $atts['id'] ); ?>
		</div>
		<div class="user-total-wrapper">
			<span class="user-review-title"><?php esc_html_e( 'Comments Rating', 'wp-review' ); ?></span>
			<span class="review-total-box">
				<?php
				$comment_reviews       = mts_get_post_comments_reviews( $atts['id'] );
				$comments_review_total = $comment_reviews['rating'];
				$comments_review_count = $comment_reviews['count'];
				$commentstotal_text    = $comments_review_total;
				?>
				<span class="wp-review-user-rating-total"><?php echo esc_html( $commentstotal_text ); ?></span>
				<small>(<span class="wp-review-user-rating-counter"><?php echo esc_html( $comments_review_count ); ?></span> <?php echo _n( 'review', 'reviews', $comments_review_count, 'wp-review' ); ?>)</small>
			</span>
		</div>
	</div>
	<?php
	$text = ob_get_clean();
	return apply_filters( 'wp_review_comments_rating_shortcode', $text, $atts );
}
