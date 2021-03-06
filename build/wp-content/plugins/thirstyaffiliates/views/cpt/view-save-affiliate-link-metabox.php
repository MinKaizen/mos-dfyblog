<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<input name="post_status" type="hidden" id="post_status" value="publish" />
<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_html_e( 'Save' , 'thirstyaffiliates' ); ?>" />
<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_html_e( 'Save Link' , 'thirstyaffiliates' ); ?>">

<?php if ( current_user_can( "delete_post" , $post->ID ) ) :

	if ( ! EMPTY_TRASH_DAYS )
		$delete_text = __( 'Delete Permanently' , 'thirstyaffiliates' );
	else
		$delete_text = __( 'Move to Trash' , 'thirstyaffiliates' ); ?>

	<a class="submitdelete deletion" href="<?php echo esc_url( get_delete_post_link( $post->ID ) ); ?>"><?php echo esc_html( $delete_text ); ?></a>
<?php endif; ?>
