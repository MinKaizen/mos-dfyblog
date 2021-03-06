<?php
/**
 * Multisite options
 *
 * @package WP_Review
 */

?>
<?php $sites = get_sites(); ?>
<div class="wp-review-field wp-review-select-site">
	<div class="wp-review-field-label">
		<label for="wp_review_select_iste"><strong><?php esc_html_e( 'Site: ', 'wp-review' ); ?></strong></label>
	</div>

	<div class="wp-review-field-option">
		<select id="wp-review-select-site">
			<option value=""><?php _e( 'Select site', 'wp-review' ); ?></option>
			<?php
			if ( ! empty( $sites ) ) {
				foreach ( $sites as $site ) {
					if ( ! is_main_site( $site->blog_id ) ) {
						$blog_details = get_blog_details( $site->blog_id );
						?>
						<option value="<?php echo $site->blog_id; ?>"><?php echo $blog_details->blogname; ?></option>
						<?php
					}
				}
			}
			?>
		</select>
	</div>
</div>

<?php
foreach ( $sites as $site ) {
	if ( ! is_main_site( $site->blog_id ) ) {
		$hide_options = wp_review_option( 'hide_global_options_' . $site->blog_id );
		$hide_popup   = wp_review_option( 'hide_general_popup_' . $site->blog_id );
		$hide_bar     = wp_review_option( 'hide_general_bar_' . $site->blog_id );
		$hide_yelp    = wp_review_option( 'hide_yelp_reviews_' . $site->blog_id );
		$hide_fb      = wp_review_option( 'hide_facebook_reviews_' . $site->blog_id );
		$hide_google  = wp_review_option( 'hide_google_reviews_' . $site->blog_id );

		$hide_role_manager   = wp_review_option( 'hide_role_manager_' . $site->blog_id );
		$hide_import         = wp_review_option( 'hide_import_' . $site->blog_id );
		$hide_convert_schema = wp_review_option( 'hide_convert_schema_' . $site->blog_id );
		?>
		<div class="wp-review-subsite-wrapper" id="wp-review-site-<?php echo $site->blog_id; ?>-fields">
			<h3><?php _e( 'General Settings', 'wp-review' ); ?></h3>
			<div class="wp-review-field wp-review-multisite-general-settings">
				<div class="wp-review-field-label">
					<label><?php esc_html_e( 'Hide global options panel', 'wp-review' ); ?></label>
				</div>

				<div class="wp-review-field-option">
					<?php
					$form_field->render_switch(
						array(
							'id'    => 'wp_review_show_global_options_' . $site->blog_id,
							'name'  => 'wp_review_options[hide_global_options_' . $site->blog_id . ']',
							'value' => ! empty( $hide_options ),
						)
					);
					?>
				</div>
			</div>
			<?php $hide = $hide_options ? 'style="display: none;"' : ''; ?>
			<div class="wp-review-multisite-global-options" <?php echo $hide; ?>>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Popup', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_general_popup_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_general_popup_' . $site->blog_id . ']',
								'value' => ! empty( $hide_popup ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Notification Bar', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_general_bar_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_general_bar_' . $site->blog_id . ']',
								'value' => ! empty( $hide_bar ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Yelp Reviews', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_yelp_reviews_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_yelp_reviews_' . $site->blog_id . ']',
								'value' => ! empty( $hide_yelp ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Facebook Reviews', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_facebook_reviews_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_facebook_reviews_' . $site->blog_id . ']',
								'value' => ! empty( $hide_fb ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Google Reviews', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_google_reviews_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_google_reviews_' . $site->blog_id . ']',
								'value' => ! empty( $hide_google ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Role Manager', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_role_manager_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_role_manager_' . $site->blog_id . ']',
								'value' => ! empty( $hide_role_manager ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Import', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_import_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_import_' . $site->blog_id . ']',
								'value' => ! empty( $hide_import ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Convert Schema', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_convert_schema_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_convert_schema_' . $site->blog_id . ']',
								'value' => ! empty( $hide_convert_schema ),
							)
						);
						?>
					</div>
				</div>

			</div>
			<br />
			<h3><?php _e( 'Post Settings', 'wp-review' ); ?></h3>
			<?php
			$hide_in_posts = wp_review_option( 'hide_ratings_in_posts_' . $site->blog_id );

			$hide_popup = wp_review_option( 'hide_popup_box_' . $site->blog_id );
			$hide_bar   = wp_review_option( 'hide_notification_bar_' . $site->blog_id );

			$hide_review_links = wp_review_option( 'hide_review_links_' . $site->blog_id );
			$hide_review_desc  = wp_review_option( 'hide_review_description_' . $site->blog_id );
			$hide_user_reviews = wp_review_option( 'hide_user_reviews_' . $site->blog_id );
			$hide_features     = wp_review_option( 'hide_features_' . $site->blog_id );
			?>
			<div class="wp-review-multisite-posts-options">
				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide reviews in single editor', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_ratings_in_posts_' . $site->blog_id,
								'name'  => 'wp_review_options[hide_ratings_in_posts_' . $site->blog_id . ']',
								'value' => ! empty( $hide_in_posts ),
							)
						);
						?>
					</div>
				</div>
			</div>

			<?php $hide = $hide_in_posts ? 'style="display: none;"' : ''; ?>
			<div id="wp-review-multisite-posts-options" <?php echo $hide; ?>>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Popup Box', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_popup_box__' . $site->blog_id,
								'name'  => 'wp_review_options[hide_popup_box_' . $site->blog_id . ']',
								'value' => ! empty( $hide_popup ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Notification Bar', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_notification_bar__' . $site->blog_id,
								'name'  => 'wp_review_options[hide_notification_bar_' . $site->blog_id . ']',
								'value' => ! empty( $hide_bar ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Features', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_features__' . $site->blog_id,
								'name'  => 'wp_review_options[hide_features_' . $site->blog_id . ']',
								'value' => ! empty( $hide_features ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Review Links', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_review_links__' . $site->blog_id,
								'name'  => 'wp_review_options[hide_review_links_' . $site->blog_id . ']',
								'value' => ! empty( $hide_review_links ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide Review Description, Pros/Cons & Total Rating', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_review_description__' . $site->blog_id,
								'name'  => 'wp_review_options[hide_review_description_' . $site->blog_id . ']',
								'value' => ! empty( $hide_review_desc ),
							)
						);
						?>
					</div>
				</div>

				<div class="wp-review-field">
					<div class="wp-review-field-label">
						<label><?php esc_html_e( 'Hide User Reviews', 'wp-review' ); ?></label>
					</div>

					<div class="wp-review-field-option">
						<?php
						$form_field->render_switch(
							array(
								'id'    => 'wp_review_hide_user_reviews__' . $site->blog_id,
								'name'  => 'wp_review_options[hide_user_reviews_' . $site->blog_id . ']',
								'value' => ! empty( $hide_user_reviews ),
							)
						);
						?>
					</div>
				</div>

			</div>

		</div>
		<?php
	}
}
