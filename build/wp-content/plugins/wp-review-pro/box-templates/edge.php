<?php
/**
 * WP Review: Edge
 * Description: Edge Review Box template for WP Review
 * Version: 3.3.8
 * Author: MyThemesShop
 * Author URI: http://mythemeshop.com/
 *
 * @package   WP_Review
 * @since     3.0.0
 * @version   3.3.8
 * @copyright Copyright (c) 2017, MyThemesShop
 * @author    MyThemesShop
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @var array $review
 */

/**
 * Use print_r( $review ); to inspect the $review array.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$classes = implode( ' ', $review['css_classes'] );

$is_embed = wp_review_is_embed();

if ( ! empty( $review['fontfamily'] ) ) : ?>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
	<style type="text/css">
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper { font-family: 'Josefin Sans', sans-serif; }
	</style>
<?php endif; ?>

<div id="review" class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( empty( $review['heading'] ) ) : ?>
		<?php echo esc_html( apply_filters( 'wp_review_item_title_fallback', '' ) ); ?>
	<?php else : ?>
		<div class="review-heading">
			<h5 class="review-title">
				<?php echo esc_html( $review['heading'] ); ?>

				<?php if ( ! empty( $review['product_price'] ) ) : ?>
					<span class="review-price"><?php echo esc_html( $review['product_price'] ); ?></span>
				<?php endif; ?>
			</h5>
		</div>
	<?php endif; ?>

	<?php wp_review_load_template( 'global/partials/review-schema.php', compact( 'review' ) ); ?>

	<?php wp_review_load_template( 'global/partials/review-desc.php', compact( 'review' ) ); ?>

	<?php wp_review_load_template( 'global/partials/review-features.php', compact( 'review' ) ); ?>

	<?php if ( ! empty( $review['total'] && ! $review['hide_desc'] ) && 'thumbs' !== $review['user_review_type'] ) : ?>
		<div class="review-total-wrapper">
			<div class="review-total-box">
				<h5><?php esc_html_e( 'Overall', 'wp-review' ); ?></h5>
				<div><?php echo esc_html( wp_review_get_rating_text( $review['total'], $review['type'] ) ); ?></div>
			</div>
			<?php echo wp_review_rating( $review['total'], $review['post_id'], array( 'class' => 'review-total' ) ); ?>
		</div>
	<?php endif; ?>

	<?php if ( ! $is_embed && $review['user_review'] && ! $review['hide_visitors_rating'] ) : ?>
		<?php if ( ! wp_review_user_can_rate_features( $review['post_id'] ) ) : ?>
			<div class="user-review-area visitors-review-area">
				<?php echo wp_review_user_rating( $review['post_id'] ); ?>
				<div class="user-total-wrapper">
					<h5 class="user-review-title"><?php esc_html_e( 'User Review', 'wp-review' ); ?></h5>
					<span class="review-total-box">
						<span class="wp-review-user-rating-total"><?php echo esc_html( wp_review_get_rating_text( $review['user_review_total'], $review['user_review_type'] ) ); ?></span>
						<small>(<span class="wp-review-user-rating-counter"><?php echo esc_html( $review['user_review_count'] ); ?></span> <?php echo esc_html( _n( 'vote', 'votes', $review['user_review_count'], 'wp-review' ) ); ?>)</small>
					</span>
				</div>
			</div>
		<?php else : ?>
			<?php echo wp_review_visitor_feature_rating( $review['post_id'] ); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php wp_review_load_template( 'global/partials/review-comments-rating.php', compact( 'review' ) ); ?>

	<?php if ( ! $review['hide_desc'] ) : ?>
		<?php wp_review_load_template( 'global/partials/review-pros-cons.php', compact( 'review' ) ); ?>
	<?php endif; ?>

	<?php wp_review_load_template( 'global/partials/review-links.php', compact( 'review' ) ); ?>

	<?php wp_review_load_template( 'global/partials/review-embed.php', compact( 'review' ) ); ?>
</div>

<?php
$colors = $review['colors'];

ob_start();
// phpcs:disable
?>
<style type="text/css">
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper {
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
		width: <?php echo $review['width'] - 2; ?>%;
		float: <?php echo $review['align']; ?>;
		border: none;
		background: <?php echo $colors['bgcolor2']; ?>;
		margin: 0 1% 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-desc {
		clear: both;
		padding: 25px 30px 25px 30px;
		line-height: 26px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-desc .review-summary-title {
		text-transform: uppercase;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper,
	.wp-review-<?php echo $review['post_id']; ?> .review-title,
	.wp-review-<?php echo $review['post_id']; ?> .review-desc p,
	.wp-review-<?php echo $review['post_id']; ?> .reviewed-item p  {
		color: <?php echo $colors['fontcolor']; ?>;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-links a {
		background: <?php echo $colors['color']; ?>;
		padding: 10px 20px 8px 20px;
		box-shadow: none;
		border: none;
		color: #fff;
		border-radius: 50px;
		cursor: pointer;
		transition: all 0.25s linear;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-links a:hover {
		background: <?php echo $colors['bgcolor1']; ?>;
		color: #fff;
		box-shadow: none;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-list li {
		padding: 20px 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-list li:last-child {
		border-bottom: 0;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-circle-type .review-list li {
		padding: 19px 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-circle-type .review-list .review-circle .review-result-wrapper { height: 32px; }
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-circle-type .review-list .wp-review-user-rating .review-circle .review-result-wrapper {
	    height: 50px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-circle-type .wpr-user-features-rating .review-list li {
	    padding: 10px 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-point-type .review-list li,
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-percentage-type .review-list li {
		padding: 24px 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-point-type .review-list li > span,
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-percentage-type .review-list li > span {
		display: inline-block;
		position: absolute;
		z-index: 1;
		top: 32px;
		left: 45px;
		color: <?php echo $colors['bgcolor2']; ?>;
		font-size: 14px;
		line-height: 1;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
	    -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-point-type .wpr-user-features-rating .review-list li > span,
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-percentage-type .wpr-user-features-rating .review-list li > span {
	    color: inherit;
	    text-shadow: none;
	}
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-point-type .wpr-user-features-rating .review-list li .wp-review-input-set + span,
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-percentage-type .wpr-user-features-rating .review-list li .wp-review-input-set + span,
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-point-type .wpr-user-features-rating .review-list li .wp-review-user-rating:hover + span,
	.wp-review-<?php echo $review['post_id']; ?>.wp-review-percentage-type .wpr-user-features-rating .review-list li .wp-review-user-rating:hover + span {
	    color: #fff;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-list li:nth-child(even) {
		background: <?php echo $colors['bordercolor']; ?>;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-links {
		padding: 30px 30px 20px 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-result-wrapper i {
		font-size: 18px;
	}
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-pros-cons {
		clear: both;
		padding: 0;
		border-top: 1px solid <?php echo $colors['bordercolor']; ?>;
	}
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-pros-cons .review-pros,
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-pros-cons .review-cons {
		width: 100%;
		flex: none;
		padding: 0;
	}
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-pros-cons .review-pros {
		background: <?php echo $colors['bgcolor1']; ?>;
		padding: 30px 30px 10px 30px;
		color: #fff;
		box-sizing: border-box;
	}
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-pros-cons .review-cons {
		background: <?php echo $colors['color']; ?>;
		padding: 30px 30px 10px 30px;
		color: #fff;
		box-sizing: border-box;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .mb-5 {
		text-transform: uppercase;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .mb-5 + p {
		line-height: 26px;
	}
	.wp-review-<?php echo $review['post_id']; ?> .user-review-area {
		padding: 15px 30px;
		border-top: 1px solid;
	}
	.wp-review-<?php echo $review['post_id']; ?> .wp-review-user-rating .review-result-wrapper .review-result {
        letter-spacing: -2.35px;   
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-title {
		letter-spacing: 1px;
		font-weight: 700;
		padding: 15px 30px;
		background: transparent;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper {
		width: 40%;
		margin: 0;
		padding: 35px 0;
		color: #fff;
		background: <?php echo $colors['bgcolor2']; ?>;
		border-left: 1px solid;
		text-align: center;
		float: right;
		clear: none;
		border-top: 1px solid;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-list {
		clear: none;
		width: 60%;
		float: left;
		border-top: 1px solid;
	}
	<?php if ( $review['hide_desc'] ) { ?>
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-list { width: 100%; }
	<?php } ?>
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .wpr-user-features-rating,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .wpr-user-features-rating .review-list {
		width: 100%;
		clear: both;
		border-top: 1px solid <?php echo $colors['bordercolor']; ?>;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .review-total-wrapper {
		padding: 20px 0;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .review-total-wrapper .review-circle.review-total {
		margin: auto 0;
		padding-top: 10px;
		width: auto;
		height: 100%;
		clear: both;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .user-review-area {
		padding: 12px 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-thumbs-type .review-list {
		width: 100%;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-result-wrapper {
		border-radius: 25px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-percentage .review-result-wrapper,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-percentage .review-result,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-point .review-result-wrapper,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-point .review-result {
		height: 26px;
		margin-bottom: 0;
		background: <?php echo $colors['inactive_color']; ?>;
		border-radius: 25px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper li .review-point .review-result {
		background: <?php echo $colors['color']; ?>;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper li:nth-of-type(2n) .review-point .review-result {
		background: <?php echo $colors['bgcolor1']; ?>;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-total-wrapper .review-point.review-total,
	.wp-review-<?php echo $review['post_id']; ?> .review-total-wrapper .review-percentage.review-total {
		width: 70%;
		display: inline-block;
		margin: 20px auto 0 auto;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper .review-total-box {
		float: left;
		text-align: center;
		padding: 0;
		color: <?php echo $colors['fontcolor']; ?>;
		line-height: 1.5;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper .review-total-box h5 {
		margin-top: 10px;
		color: inherit;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-point-type .review-total-wrapper .review-total-box,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-percentage-type .review-total-wrapper .review-total-box {
		width: 100%;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-star.review-total {
		color: #fff;
		margin-top: 10px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .user-review-title {
		padding: 15px 30px 10px;
		margin: 0;
		color: inherit;
		background: <?php echo $colors['bordercolor']; ?>;
		border-top: 1px solid;
		border-bottom: 1px solid;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .user-total-wrapper .user-review-title {
		display: inline-block;
		color: <?php echo $colors['fontcolor']; ?>;
		text-transform: uppercase;
		letter-spacing: 1px;
		padding: 0;
		border: 0;
		background: transparent;
		margin-top: 3px;
	}
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .user-total-wrapper h5.user-review-title {
		margin-top: 12px;
	}
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .user-total-wrapper span.user-review-title {
		margin-top: 8px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .reviewed-item {
		padding: 30px;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .review-total-wrapper > .review-total-box {
		display: block;
	}
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper.wp-review-circle-type .review-total-wrapper > .review-total-box > div { display: none; }
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .user-review-area .review-percentage,
	#review.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .user-review-area .review-point {
		width: 20%;
		float: right;
		margin-bottom: 5px;
	}
	.wp-review-<?php echo $review['post_id']; ?> .review-embed-code { padding: 10px 30px; }
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper,
	.wp-review-<?php echo $review['post_id']; ?> .review-title,
	.wp-review-<?php echo $review['post_id']; ?> .review-list li,
	.wp-review-<?php echo $review['post_id']; ?> .review-list li:last-child,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-list,
	.wp-review-<?php echo $review['post_id']; ?> .user-review-area,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper,
	.wp-review-<?php echo $review['post_id']; ?> .reviewed-item,
	.wp-review-<?php echo $review['post_id']; ?> .review-links,
	.wp-review-<?php echo $review['post_id']; ?> .wpr-user-features-rating,
	.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .user-review-title {
		border-color: <?php echo $colors['bordercolor']; ?>;
	}
	.wp-review-<?php echo $review['post_id']; ?> .wpr-rating-accept-btn {
		background: <?php echo $colors['color']; ?>;
		margin: 10px 30px;
		width: -moz-calc(100% - 60px);
		width: -webkit-calc(100% - 60px);
		width: -o-calc(100% - 60px);
		width: calc(100% - 60px);
		border-radius: 50px;
	}
	@media screen and (max-width:480px) {
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-title,
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .reviewed-item,
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-list li,
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-desc,
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .user-review-area,
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-embed-code { padding: 15px; }
		.wp-review-<?php echo $review['post_id']; ?>.wp-review-circle-type .review-list li {
    		padding: 15px 15px 0px 15px;
    	}
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-pros-cons > div > div { padding: 15px; padding-top: 0; }
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .ui-tabs-nav { padding: 0 15px; }
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-links { padding: 15px 15px 5px; }
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-list,
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper { width: 100%; }
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper { padding: 10px 0; }
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper .review-total-box h5 { margin-top: 0; }
		.wp-review-<?php echo $review['post_id']; ?>.review-wrapper .review-total-wrapper .review-total-box div { line-height: 1; }
	}
</style>
<?php
$color_output = ob_get_clean();

// Apply legacy filter.
$color_output = apply_filters( 'wp_review_color_output', $color_output, $review['post_id'], $colors );

/**
 * Filters style output of edge template.
 *
 * @since 3.0.0
 *
 * @param string $style   Style output (include <style> tag).
 * @param int    $post_id Current post ID.
 * @param array  $colors  Color data.
 */
$color_output = apply_filters( 'wp_review_box_template_edge_style', $color_output, $review['post_id'], $colors );

echo $color_output;

// Schema json-dl.
echo wp_review_get_schema( $review );
// phpcs:enable
