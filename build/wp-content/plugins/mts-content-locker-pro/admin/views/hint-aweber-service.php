<?php
$aweber_key = get_option( '_mts_cl_aweber_access_key' );
if ( empty( $aweber_key ) ) : ?>
<div class="mb30">
	<p><?php esc_html_e( 'To connect your Aweber account:', 'content-locker' ); ?></p>
	<ul>
		<li><?php printf( wp_kses_post( __( '<span>1.</span> <a href="%s" class="button" target="_blank">Click here</a> <span>to open the authorization page and log in.</span>', 'content-locker' ) ), 'https://auth.aweber.com/1.0/oauth/authorize_app/34f6c18b' ); ?></li>
		<li><?php echo wp_kses_post( __( '<span>2.</span> Copy and paste the authorization code in the field below.', 'content-locker' ) ); ?></li>
	</ul>
</div>
<?php else : ?>
	<div class="alert alert-hint mb30">
		<p><strong><?php _e( 'Your Aweber Account is connected.', 'content-locker' ); ?></strong></p>
		<p>
			<?php printf( wp_kses_post( __( '<a href="%s" class="button">Click here</a> <span>to disconnect.</span>', 'content-locker' ) ), admin_url( 'edit.php?post_type=content-locker&page=cl-settings&cl_action=disconnect_aweber' ) ); ?>
		</p>
	</div>
<?php endif; ?>
