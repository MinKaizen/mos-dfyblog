<?php
/**
 * Ajax handles
 *
 * @package WP_Review
 * @since 3.0.0
 */

add_action( 'wp_ajax_wp_review_rate', 'wp_review_ajax_rate' );
add_action( 'wp_ajax_nopriv_wp_review_rate', 'wp_review_ajax_rate' );

add_action( 'wp_ajax_mts_review_feedback', 'mts_review_feedback' );
add_action( 'wp_ajax_nopriv_mts_review_feedback', 'mts_review_feedback' );

add_action( 'wp_ajax_wp_review_migrate_ratings', 'wp_review_ajax_migrate_ratings' );

add_action( 'wp_ajax_wp-review-load-reviews', 'wp_review_ajax_load_reviews' );
add_action( 'wp_ajax_nopriv_wp-review-load-reviews', 'wp_review_ajax_load_reviews' );

add_action( 'wp_ajax_wp-review-generate-fb-page-token', 'wp_review_ajax_generate_fb_page_token' );

add_action( 'wp_ajax_wpr-visitor-features-rating', 'wp_review_ajax_visitor_features_rating' );
add_action( 'wp_ajax_nopriv_wpr-visitor-features-rating', 'wp_review_ajax_visitor_features_rating' );

add_action( 'wp_ajax_wpr-purge-ratings', 'wp_review_ajax_purge_ratings' );

add_action( 'wp_ajax_wpr-upload-comment-image', 'wp_review_upload_comment_image' );
add_action( 'wp_ajax_nopriv_wpr-upload-comment-image', 'wp_review_upload_comment_image' );

add_action( 'wp_ajax_wp_review_convert_schema', 'wp_review_ajax_convert_schema' );

/**
 * Uploads Comment Image with Ajax.
 */
function wp_review_upload_comment_image() {
	check_ajax_referer( 'wp_review_comment_image_upload' );
	$files         = array_filter( $_FILES['files'] );
	$attachment_id = '';
	if ( ! empty( $files ) ) {
		$file_data['name']     = $files['name'][0];
		$file_data['type']     = $files['type'][0];
		$file_data['tmp_name'] = $files['tmp_name'][0];
		$file_data['error']    = $files['error'][0];
		$file_data['size']     = $files['size'][0];

		// these files need to be included as dependencies when on the front end.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		$attachment_id = media_handle_sideload( $file_data, 0 );
		if ( is_wp_error( $attachment_id ) ) {
			$attachment_id = false;
		}
	}
	echo $attachment_id;
	die();
}

/**
 * Get review with Ajax.
 */
function mts_review_get_review() {
	// Security.
	check_ajax_referer( 'wp-review-security', 'nonce' );

	$post_id = intval( $_POST['post_id'] );
	$user_id = is_user_logged_in() ? get_current_user_id() : 0;
	$review  = round( abs( filter_input( INPUT_POST, 'review' ) ), 2 );

	$review_text = $review;

	$uip = wp_review_get_user_ip();

	if ( ! function_exists( 'wp_review_comment_duplicate_trigger' ) ) {
		/**
		 * Shows comment duplicate message.
		 */
		function wp_review_comment_duplicate_trigger() {
			echo 'MTS_REVIEW_DUP_ERROR';
			exit;
		}
	}
	add_action( 'comment_duplicate_trigger', 'wp_review_comment_duplicate_trigger' );

	if (
		$review > 0 &&
		! wp_review_has_reviewed( $post_id, $user_id, $uip, WP_REVIEW_COMMENT_TYPE_VISITOR ) &&
		( is_user_logged_in() || ! wp_review_option( 'registered_only' ) )
	) {
		$insert = wp_insert_comment(
			array(
				'user_id'           => $user_id,
				'comment_type'      => WP_REVIEW_COMMENT_TYPE_VISITOR,
				'comment_post_ID'   => $post_id,
				'comment_parent'    => 0,
				'comment_author_IP' => $uip,
				// translators: rating text.
				'comment_content'   => sprintf( __( 'Visitor Rating: %s', 'wp-review' ), $review_text ),
				'comment_agent'     => isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '',
				'comment_date'      => current_time( 'mysql' ),
				'comment_date_gmt'  => current_time( 'mysql', 1 ),
				'comment_approved'  => 1,
			)
		);

		if ( $insert ) {
			if ( update_comment_meta( $insert, WP_REVIEW_VISITOR_RATING_METAKEY, $review ) ) {
				$post_reviews = mts_get_post_reviews( $post_id, true );

				echo $post_reviews['rating'] . '|' . $post_reviews['count'];
				exit;
			} else {
				wp_delete_comment( $insert );
			}
		}
	}

	echo 'MTS_REVIEW_DB_ERROR';
	exit;
}


/**
 * AJAX User review rating
 * Replaces mts_review_get_review().
 */
function wp_review_ajax_rate() {
	check_ajax_referer( 'wp-review-security', 'nonce' );
	$post_id     = intval( $_POST['post_id'] );
	$review      = filter_input( INPUT_POST, 'review' );
	$review      = round( $review, 2 );
	$review_data = array(
		'total' => $review,
	);
	wp_review_visitor_rate( $post_id, $review_data );
	exit;
}

/**
 * Handles feedback.
 */
function mts_review_feedback() {
	$is_helpful = filter_input( INPUT_POST, 'isHelpful' );
	$comment_id = absint( filter_input( INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT ) );
	$comment    = get_comment( $comment_id );
	$error_msg  = __( 'Invalid comment ID.', 'wp-review' );
	if ( $comment > 0 && wp_review_allow_comment_feedback( $comment->comment_post_ID ) ) {
		$user_ip = wp_review_get_user_ip();

		if ( 'yes' === $is_helpful ) {
			$key   = 'wp_review_comment_helpful';
			$group = 'wp_review_voted_h';
		} else {
			$key   = 'wp_review_comment_unhelpful';
			$group = 'wp_review_voted_uh';
		}

		if ( ! in_array( $user_ip, get_comment_meta( $comment_id, 'wp_review_voted_h' ) ) && ! in_array( $user_ip, get_comment_meta( $comment_id, 'wp_review_voted_uh' ) ) ) {
			$val = absint( get_comment_meta( $comment_id, $key, true ) );
			update_comment_meta( $comment_id, $key, ++$val );
			add_comment_meta( $comment_id, $group, $user_ip );
			wp_die( $val );
		}
		$error_msg = __( 'You already gave feedback.', 'wp-review' );
	}
	header( 'Bad Request', true, 400 );
	wp_die( $error_msg );
}


/**
 * Migrates ratings.
 */
function wp_review_ajax_migrate_ratings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'wp_review_has_migrated', false ) ) {
		return;
	}

	global $wpdb;

	$start           = isset( $_POST['start'] ) ? intval( $_POST['start'] ) : 0;
	$limit           = 100;
	$current_blog_id = get_current_blog_id();

	$query = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}mts_wp_reviews WHERE blog_id = {$current_blog_id} LIMIT {$limit} OFFSET {$start}" ); // WPCS: unprepared SQL ok.

	foreach ( $query as $review ) {

		if ( 0 == $review->rate ) {
			continue; // Skip 0-star ratings.
		}

		$insert = wp_insert_comment(
			array(
				'user_id'           => $review->user_id,
				'comment_type'      => WP_REVIEW_COMMENT_TYPE_VISITOR,
				'comment_post_ID'   => $review->post_id,
				'comment_parent'    => 0,
				'comment_content'   => sprintf(
					// translators: rating text.
					__( 'Visitor Rating: %s', 'wp-review' ),
					// translators: rating value.
					sprintf( __( '%s Stars', 'wp-review' ), $review->rate )
				),
				'comment_author_IP' => $review->user_ip,
				'comment_date'      => gmdate( 'Y-m-d H:i:s', ( strtotime( $review->date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) ),
				'comment_date_gmt'  => gmdate( 'Y-m-d H:i:s', strtotime( $review->date ) ),
				'comment_approved'  => 1,
			)
		);

		if ( $insert ) {
			if ( update_comment_meta( $insert, WP_REVIEW_VISITOR_RATING_METAKEY, $review->rate ) ) {
				// Purge cache.
				mts_get_post_reviews( $review->post_id, true );
			} else {
				wp_delete_comment( $insert );
			}
		}
	}

	$end = $start + count( $query );
	update_option( 'wp_review_migrated_rows', $end );

	$total_rows         = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->base_prefix}mts_wp_reviews WHERE blog_id = {$current_blog_id}" ); // WPCS: unprepared SQL ok.
	$migration_finished = 0;
	if ( $total_rows == $end ) {
		update_option( 'wp_review_has_migrated', 1 );
		$migration_finished = 1;
	}

	echo wp_json_encode(
		array(
			'start'    => $start,
			'lastrow'  => $end,
			'rowsleft' => $total_rows - $end,
			'finished' => $migration_finished,
		)
	);

	die();
}


/**
 * Ajax handle for loading reviews.
 */
function wp_review_ajax_load_reviews() {
	$options = $_POST; // WPCS: csrf ok.

	// Options are same as widgets args to keep compatibility.
	$options = wp_parse_args(
		$options,
		array(
			'post_num'       => 5,
			'page'           => 1,
			'review_type'    => '',
			'thumb_size'     => 'small',
			'cat'            => '',
			'number_of_days' => '',
		)
	);

	$type = ! empty( $options['_type'] ) ? $options['_type'] : 'recent';

	$query = wp_review_get_reviews_query( $type, $options );

	if ( ! $query->have_posts() ) {
		wp_send_json_success( '' );
	}

	$page      = ! empty( $options['page'] ) ? intval( $options['page'] ) : 1;
	$last_page = $query->max_num_pages;
	$in_widget = ! empty( $options['widget_id'] );

	$thumb_size = $options['thumb_size'];
	if ( 'small' !== $thumb_size && 'large' !== $thumb_size ) {
		$thumb_size = 'small'; // default.
	}

	$GLOBALS['in_widget'] = $in_widget;

	ob_start();
	echo '<ul>';
	while ( $query->have_posts() ) {
		$query->the_post();
		wp_review_load_template( 'global/review-item-widget.php', compact( 'options' ) );
	}
	echo '</ul><!-- End Reviews -->';
	wp_reset_postdata();

	if ( intval( $options['allow_pagination'] ) && -1 != $options['post_num'] ) {
		wp_review_ajax_pagination( $page, $last_page );
	}
	$output = ob_get_clean();
	unset( $GLOBALS['in_widget'] );

	wp_send_json_success( $output );
}


/**
 * Shows review extra information like post date, reviews count.
 *
 * @since 3.0.8
 *
 * @param int   $post_id    Post ID.
 * @param int   $extra_info Extra info. 1 for date, 2 for reviews count, 0 for none.
 * @param array $args       Custom args.
 */
function wp_review_extra_info( $post_id, $extra_info, array $args = array() ) {
	if ( ! $extra_info ) {
		return;
	}

	$args = wp_parse_args(
		$args,
		array(
			'class'       => 'postmeta',
			'date_format' => get_option( 'date_format' ),
		)
	);

	if ( 1 === $extra_info ) {
		?>
		<div class="<?php echo esc_attr( $args['class'] ); ?>">
			<?php the_time( $args['date_format'] ); // Hard coded to prevent styling issue. ?>
		</div> <!-- End .<?php echo esc_attr( $args['class'] ); ?>-->
		<?php
		return;
	}

	$post_reviews = mts_get_post_reviews( $post_id );
	?>
	<div class="<?php echo esc_attr( $args['class'] ); ?>">
		<?php
		if ( ! $post_reviews['count'] ) {
			// translators: review count.
			printf( __( '%s review', 'wp-review' ), 0 );
		} else {
			// translators: review count.
			printf( _n( '%s review', '%s reviews', $post_reviews['count'], 'wp-review' ), $post_reviews['count'] );
		}
		?>
	</div> <!-- End .<?php echo esc_attr( $args['class'] ); ?>-->
	<?php
}


/**
 * Ajax handler for generating FB page token.
 *
 * @since 3.0.0
 */
function wp_review_ajax_generate_fb_page_token() {
	check_ajax_referer( 'wp_review_generate_fb_page_token' );
	if ( empty( $_POST['page_id'] ) ) {
		wp_send_json_error( __( 'Empty page ID', 'wp-review' ) );
	}
	if ( empty( $_POST['user_token'] ) ) {
		wp_send_json_error( __( 'Empty user token', 'wp-review' ) );
	}

	$page_id    = sanitize_text_field( wp_unslash( $_POST['page_id'] ) );
	$user_token = sanitize_text_field( wp_unslash( $_POST['user_token'] ) );
	$fb_api     = new WP_Review_Facebook_API();
	$token      = $fb_api->generate_page_token( $page_id, $user_token );

	if ( is_wp_error( $token ) ) {
		wp_send_json_error( $token->get_error_message() );
	}

	set_transient( "wp_review_fb_page_token_{$page_id}", $token );
	wp_send_json_success( __( 'Generated token successfully', 'wp-review' ) );
}


/**
 * Ajax handler for visitor features rating.
 *
 * @since 3.0.0
 */
function wp_review_ajax_visitor_features_rating() {
	check_ajax_referer( 'wpr_user_features_rating', 'nonce' );
	if ( empty( $_POST['post_id'] ) ) {
		wp_send_json_error( __( 'Empty post ID', 'wp-review' ) );
	}
	if ( empty( $_POST['rating'] ) ) {
		wp_send_json_error( __( 'Empty rating data', 'wp-review' ) );
	}
	if ( empty( $_POST['type'] ) ) {
		wp_send_json_error( __( 'Empty type data', 'wp-review' ) );
	}
	$post_id = intval( $_POST['post_id'] );
	$rating  = $_POST['rating']; // WPCS: sanitization ok.
	$type    = wp_kses( wp_unslash( $_POST['type'] ), array() );

	$total = 0;
	$count = 0;
	foreach ( $rating as $value ) {
		$total += $value;
		$count++;
	}

	$review_data = array(
		'total'    => $total / $count,
		'type'     => $type,
		'features' => $rating,
	);
	wp_review_visitor_rate( $post_id, $review_data );
}


/**
 * Ajax handler for purging ratings.
 *
 * @since 3.0.0
 */
function wp_review_ajax_purge_ratings() {
	check_ajax_referer( 'wpr_purge_ratings', 'nonce' );
	$query_args = array();
	if ( ! empty( $_POST['type'] ) ) {
		$query_args['type'] = 'visitor' === $_POST['type'] ? WP_REVIEW_COMMENT_TYPE_VISITOR : WP_REVIEW_COMMENT_TYPE_COMMENT;
	} else {
		$query_args['type_in'] = array( WP_REVIEW_COMMENT_TYPE_VISITOR, WP_REVIEW_COMMENT_TYPE_COMMENT );
	}
	if ( ! empty( $_POST['postId'] ) ) {
		$query_args['post_id'] = intval( $_POST['postId'] );
	}
	$comments = get_comments( $query_args );
	if ( ! $comments ) {
		wp_send_json_success( esc_html__( 'Completed!', 'wp-review' ) );
	}

	$processed = array();
	foreach ( $comments as $comment ) {
		wp_delete_comment( $comment->comment_ID, false );
		if ( in_array( $comment->comment_post_ID, $processed ) ) {
			continue;
		}
		wp_review_clear_cached_reviews( $comment );
		$processed[] = $comment->comment_post_ID;
	}
	wp_send_json_success( esc_html__( 'Completed!', 'wp-review' ) );
}


function wp_review_ajax_convert_schema() {
	check_ajax_referer( 'wp_review_convert_schema' );

	$source = empty( $_POST['source'] ) ? '' : $_POST['source'];
	$dest   = empty( $_POST['dest'] ) ? '' : $_POST['dest'];
	$page   = empty( $_POST['page'] ) ? 1 : $_POST['page'];

	if ( empty( $source ) || empty( $dest ) ) {
		wp_send_json_error( new WP_Error( 'empty-source-or-dest', __( 'Empty source or destination type', 'wp-review' ) ) );
	}

	$converter = new WPR_Schema_Converter();
	$result    = $converter->convert( $source, $dest, $page );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( $result );
	}

	wp_send_json_success( $result );
}
