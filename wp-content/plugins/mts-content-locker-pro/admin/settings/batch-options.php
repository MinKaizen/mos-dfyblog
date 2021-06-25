<?php
/**
 * The file contains batch locking settings for the plugin.
 */
$cmb->add_field( array(
	'name'          => '<i class="fa fa-braille"></i>' . esc_html__( 'Batch Locking', 'content-locker' ),
	'id'            => 'settings-batch-tab',
	'type'          => 'section',
	'render_row_cb' => 'cl_cmb_tab_open_tag',
) );

$cmb->add_field( array(
	'id'            => 'settings-batch-hint',
	'desc'          => esc_html__( 'Batch Locking allows to apply the single locker to the posts automatically.', 'content-locker' ),
	'type'          => 'title',
	'render_row_cb' => 'cl_cmb_alert',
) );

$first       = false;
$posts_types = cl_cmb_post_types();
$lockers     = array( '' => esc_html__( 'Select a Locker', 'content-locker' ) ) + cl_get_lockers( null, 'cmb' );

foreach ( $posts_types as $id => $label ) {

	$group_field_id = $cmb->add_field( array(
		'id'         => $id,
		'type'       => 'group',
		'repeatable' => false,
		'classes'    => 'accordion',
		'options'    => array(
			'group_title' => $label,
			'closed'      => $first,
		),
	) );

	$first      = true;
	$taxonomies = get_object_taxonomies( $id, 'objects' );

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'batch-locker',
		'type'          => 'radio-tabs',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

	$cmb->add_group_field( $group_field_id, array(
		'name'    => esc_html__( 'Locker', 'content-locker' ),
		'id'      => 'locker',
		'type'    => 'select',
		'desc'    => sprintf( esc_html__( 'Apply Batch Locking to your %s automatically.', 'content-locker' ), strtolower( $label ) ),
		'options' => $lockers,
		'classes' => 'no-border cmb-half',
	));

	$cmb->add_group_field( $group_field_id, array(
		'id'      => 'bl_way',
		'type'    => 'radio_inline',
		'options' => array(
			'skip-lock'    => '<i class="fa fa-sort-amount-desc"></i> ' . esc_html__( 'Skip &amp; Lock', 'content-locker' ),
			'more-tag'     => '<i class="fa fa-scissors"></i> ' . esc_html__( 'More Tag', 'content-locker' ),
			'css-selector' => '<i class="fa fa-hand-o-up"></i> ' . esc_html__( 'CSS Selector', 'content-locker' ),
		),
		'classes' => 'cl-radio-tabs no-border cmb-split100 cmb-half cmb-td-right',
		'default' => 'skip-lock',
	));

	if ( ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $tax_id => $taxonomy ) {

			if ( in_array( $tax_id, array( 'post_format' ) ) ) {
				continue;
			}

			$cmb->add_group_field( $group_field_id, array(
				'name'           => esc_html__( 'Exclude ', 'content-locker' ) . $taxonomy->label,
				'id'             => $tax_id,
				'type'           => 'multicheck',
				'options_cb'     => 'cl_cmb_get_term_options',
				'get_terms_args' => array(
					'taxonomy'   => $tax_id,
					'hide_empty' => false,
				),
				'desc'           => sprintf( esc_html__( '(Optional) Exclude posts with these %s.', 'content-locker' ), strtolower( $taxonomy->label ) ),
				'classes'        => 'cmb-split100 cmb-half no-border mlr0',
			));
		}
	}

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'skip-lock',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'id'            => 'sl_title',
			'type'          => 'info',
			'desc'          => wp_kses_post( __( 'Enter the number of paragraphs which will be visible for users at the beginning of your posts and which will be free from locking.<br />The remaining paragraphs will be locked.', 'content-locker' ) ),
			'render_row_cb' => 'cl_cmb_alert',
		));

		$cmb->add_group_field( $group_field_id, array(
			'name'    => esc_html__( 'The number of paragraphs to skip', 'content-locker' ),
			'id'      => 'skip_number',
			'type'    => 'text',
			'default' => 1,
			'desc'    => wp_kses_post( __( 'For example, If you enter 2, two first paragraphs will be visible,<br />others will be locked.', 'content-locker' ) ),
			'classes' => 'no-border cmb-half cmb-split100',
		));

		$cmb->add_group_field( $group_field_id, array(
			'id'            => 'sl_help',
			'type'          => 'view',
			'file'          => 'hint-para-lock',
			'render_row_cb' => 'cl_cmb_alert',
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'skip-lock-close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'more-tag',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'id'            => 'mt_title',
			'type'          => 'info',
			'desc'          => esc_html__( 'All content after the More Tag will be locked in all your posts. If a post doesn\'t have the More Tag, the post will be shown without locking.', 'content-locker' ),
			'render_row_cb' => 'cl_cmb_alert',
		));

		$cmb->add_group_field( $group_field_id, array(
			'id'            => 'mt_help',
			'type'          => 'view',
			'file'          => 'hint-more-tag',
			'render_row_cb' => 'cl_cmb_alert',
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'more-tag-close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'css-selector',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_open_tag',
	) );

		$cmb->add_group_field( $group_field_id, array(
			'id'            => 'cs_title',
			'type'          => 'info',
			'desc'          => esc_html__( 'CSS selectors allow accurately choose which content will be locked by usign CSS classes or IDs of elements placed on pages. If you don\'t know what is it, please don\'t use it.', 'content-locker' ),
			'render_row_cb' => 'cl_cmb_alert',
		));

		$cmb->add_group_field( $group_field_id, array(
			'name' => esc_html__( 'CSS Selector', 'content-locker' ),
			'id'   => 'css_selector',
			'type' => 'text',
			'desc' => esc_html__( 'For example, "#somecontent .my-class, .my-another-class"', 'content-locker' ),
		));

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'css-selector-close',
		'type'          => 'section',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );

	$cmb->add_group_field( $group_field_id, array(
		'id'            => 'batch-locker-close',
		'type'          => 'radio-tabs',
		'render_row_cb' => 'cl_cmb_tab_close_tag',
	) );
}

$cmb->add_field( array(
	'id'            => 'settings-batch-tab-close',
	'type'          => 'section_end',
	'render_row_cb' => 'cl_cmb_tab_close_tag',
) );
