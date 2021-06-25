<?php

// Lockers
$lockers = cl_get_lockers( null, 'cmb' );

// current item
$item_id = isset( $_GET['item_id'] ) ? $_GET['item_id'] : null;
if ( empty( $item_id ) ) {
	$item_id = ! empty( $lockers ) ? key( $lockers ) : 0;
}
$item_type = cl_get_item_type( $item_id );

// current post
$post_id = isset( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : false;
$post    = $post_id ? get_post( $post_id ) : false;

// set date range
$hrs_offset = get_option( 'gmt_offset' );
if ( strpos( $hrs_offset, '-' ) !== 0 ) {
	$hrs_offset = '+' . $hrs_offset;
}
$hrs_offset .= ' hours';

// by default shows a 30 days' range
$date_end = isset( $_REQUEST['cl_date_end'] ) ? $_REQUEST['cl_date_end'] : false;
if ( empty( $date_end ) || false === ( $date_range_end = strtotime( $date_end ) ) ) {
	$phpdate        = getdate( strtotime( $hrs_offset, time() ) );
	$date_range_end = mktime( 0, 0, 0, $phpdate['mon'], $phpdate['mday'], $phpdate['year'] );
}

$date_start = isset( $_REQUEST['cl_date_start'] ) ? $_REQUEST['cl_date_start'] : false;
if ( empty( $date_start ) || false === ( $date_range_start = strtotime( $date_start ) ) ) {
	$date_range_start = strtotime( '-1 month', $date_range_end );
}

$date_start = date( 'm/d/Y', $date_range_start );
$date_end   = date( 'm/d/Y', $date_range_end );

// pagination
$page = isset( $_GET['cl_page'] ) ? intval( $_GET['cl_page'] ) : 1;
if ( $page <= 0 ) {
	$page = 1;
}

// screens
$screens           = cl_get_stats_screens( $item_type );
$current_screen_id = isset( $_REQUEST['cl_screen'] ) ? $_REQUEST['cl_screen'] : 'summary';
$current_screen    = $screens[ $current_screen_id ];
$screen_class      = isset( $current_screen['screen_class'] ) ? $current_screen['screen_class'] : 'CL_Stats_Screen';

$screen = new $screen_class( array(

	// Classes
	'chart_class' => $current_screen['chart_class'],
	'table_class' => $current_screen['table_class'],

	// Data for Chart and Table
	'item_id'     => $item_id,
	'post_id'     => $post_id,
	'range_start' => $date_range_start,
	'range_end'   => $date_range_end,

	// for Table Only
	'per'         => 50,
	'total'       => true,
	'page'        => $page,
));

// getting the chart data
$chart = $screen->get_chart();

// getting the table data
$table = $screen->get_table();

// the base urls
$url_base = add_query_arg( array(
	'post_type'     => 'content-locker',
	'page'          => 'cl-stats',
	'item_id'       => $item_id,
	'post_id'       => $post_id,
	'cl_screen'     => $current_screen_id,
	'cl_date_end'   => $date_end,
	'cl_date_start' => $date_start,
), admin_url( 'edit.php' ) );

// extra css classes
$table_css_class = $table->get_columns_count() > 8 ? ' mts-cl-concise-table' : ' mts-cl-free-table';
?>
<div class="wrap">

	<h2><?php esc_html_e( 'Stats & Reports', 'content-locker' ); ?></h2>

	<div class="mts-cl-stats-control-panel clearfix">
		<div class="alignleft">
			<?php esc_html_e( 'You are viewing reports for ', 'content-locker' ); ?>
			<a href="<?php echo admin_url( 'post.php?post=' . $item_id . '&action=edit' ); ?>"><strong><?php echo $lockers[ $item_id ]; ?></strong></a>
		</div>

		<form method="get" action="" class="alignright">
			<input type="hidden" name="post_type" value="content-locker">
			<input type="hidden" name="page" value="cl-stats">
			<input type="hidden" name="cl_date_end" value="<?php echo $date_end; ?>">
			<input type="hidden" name="cl_date_start" value="<?php echo $date_start; ?>">

			<?php esc_html_e( 'Select item to view: ', 'content-locker' ); ?>
			<select name="item_id" id="cl-locker-item-selector">
				<?php foreach ( $lockers as $id => $title ) : ?>
					<option value="<?php echo $id; ?>"<?php selected( $item_id, $id ); ?>><?php echo $title; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="submit" value="Select" class="hidden">
		</form>
	</div>

	<div class="mts-cl-stats-screen-wrapper">

		<div class="mts-cl-chart-description">
			<?php echo $current_screen['description']; ?>
		</div>

		<div class="mts-cl-chart-area">

			<form method="get" action="">

				<div class="mts-cl-settings-bar clearfix">

					<div class="mts-cl-screen-selection alignleft">
						<div class="btn-group">
							<?php foreach ( $screens as $screen_id => $screen ) {?><a href="<?php echo add_query_arg( 'cl_screen', $screen_id, $url_base ) ?>" class="button <?php echo ( $screen_id == $current_screen_id ) ? ' active' : '' ?> type-<?php echo $screen_id ?>" data-value="<?php echo $screen_id ?>"><?php echo $screen['title'] ?></a><?php } ?>
						</div>
					</div>

					<div class="mts-cl-date-selection alignright">

						<input type="hidden" name="post_type" value="content-locker">
						<input type="hidden" name="page" value="cl-stats">
						<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
						<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
						<input type="hidden" name="cl_screen" value="<?php echo $current_screen_id; ?>">

						<span class="mts-cl-range-label"><?php _e( 'Date range', 'content-locker' ); ?>:</span>
						<input type="text" id="mts-cl-date-start" name="cl_date_start" class="form-control" value="<?php echo $date_start; ?>" />
						<input type="text" id="mts-cl-date-end" name="cl_date_end" class="form-control" value="<?php echo $date_end; ?>" />

						<input type="submit" value="Apply" class="button">

					</div>

				</div>

			</form>

			<div class="mts-cl-chart-wrap">
				<div id="chart" style="width:100%; height: 195px;"></div>
			</div>

		</div>

		<div id="mts-cl-chart-selector">
			<?php
			if ( $chart->has_selectors() ) :
				foreach ( $chart->get_selectors() as $name => $field ) :
			?>
				<div class="mts-cl-selector-item mts-cl-selector-<?php echo $name ?>" data-selector="<?php echo $name; ?>">
					<span class="chart-color" style="background-color: <?php echo $field['color']; ?>"></span>
					<?php echo $field['title']; ?>
				</div>
			<?php
				endforeach;
			endif;
			?>
		</div>

		<?php if ( $post_id ) : ?>
		<div class="alert alert-warning">
			<?php printf( __( 'Data for the post: <strong>%1$s</strong> (<a href="%2$s">return back</a>)', 'content-locker' ), $post->post_title, add_query_arg( 'post_id', false, $url_base ) ); ?>
		</div>
		<?php else : ?>
		<p><?php esc_html_e( 'Top-50 posts and pages where you put the locker, ordered by their performance:', 'content-locker' ); ?></p>
		<?php endif; ?>

		<div class="mts-cl-table-wrap">

			<table class="mts-cl-data-table">

				<thead>

				<?php if ( $table->has_complex_columns() ) : ?>

					<tr>
						<?php foreach ( $table->get_header_columns() as $name => $column ) : ?>
							<th rowspan="<?php echo $column['rowspan'] ?>" colspan="<?php echo $column['colspan'] ?>" class="mts-cl-col-<?php echo $name ?> <?php echo isset( $column['css_class'] ) ? $column['css_class'] : '' ?> <?php if ( isset( $column['highlight'] ) ) { echo 'mts-cl-column-highlight'; } ?>">
								<?php echo $column['title'] ?>
								<?php if ( isset( $column['hint'] ) ) { ?>
								<i class="mts-cl-hint fa fa-question" data-title="<?php echo $column['hint']; ?>"></i>
								<?php } ?>
							</th>
						<?php endforeach; ?>
					</tr>
					<tr>
						<?php foreach ( $table->get_header_columns( 2 ) as $name => $column ) : ?>
							<th class="mts-cl-col-<?php echo $name ?> <?php echo isset( $column['css_class'] ) ? $column['css_class'] : '' ?> <?php if ( isset( $column['highlight'] ) ) { echo 'mts-cl-column-highlight'; } ?>">
								<?php echo $column['title'] ?>
								<?php if ( isset( $column['hint'] ) ) { ?>
								<i class="mts-cl-hint fa fa-question" data-title="<?php echo $column['hint']; ?>"></i>
								<?php } ?>
							</th>
						<?php endforeach; ?>
					</tr>

				<?php else : ?>

					<?php foreach ( $table->get_columns() as $name => $column ) : ?>
						<th class="mts-cl-column-<?php echo $name ?> <?php echo isset( $column['css_class'] ) ? $column['css_class'] : '' ?> <?php if ( isset( $column['highlight'] ) ) { echo 'mts-cl-column-highlight'; } ?>">
							<?php echo $column['title'] ?>
							<?php if ( isset( $column['hint'] ) ) { ?>
							<i class="mts-cl-hint fa fa-question" data-title="<?php echo $column['hint']; ?>"></i>
							<?php } ?>
						</th>
					<?php endforeach; ?>

				<?php endif; ?>

				</thead>

				<tbody>

					<?php for ( $i = 0; $i < $table->get_rows_count(); $i++ ) : if ( $i >= 50 ) { break; } ?>

						<tr>
							<?php foreach ( $table->get_data_columns() as $name => $column ) : ?>
								<td class="mts-cl-col-<?php echo $name ?> <?php echo isset( $column['css_class'] ) ? $column['css_class'] : '' ?> <?php if ( isset( $column['highlight'] ) ) { echo 'mts-cl-column-highlight'; } ?>">
									<?php $table->print_value( $i, $name, $column ) ?>
								</td>
							<?php endforeach; ?>
						</tr>

					<?php endfor; ?>

				</tbody>

			</table>

		</div>

	</div>

</div>

<!-- Load the AJAX API -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

	// Load the Visualization API and the piechart package.
	google.load( 'visualization', '1.0', {
		'packages': [ 'corechart' ]
	});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback( function() {
		window.CL_Statistics.draw_chart({
			'type': '<?php echo $chart->type ?>'
		});
	});

	window.cl_chart_selectors = [ <?php echo join( ',', $chart->get_selectors_names() ) ?> ];
	window.cl_chart_data = [
		<?php $chart->print_data() ?>
	];

</script>
