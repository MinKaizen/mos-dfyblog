<?php
/**
 * The Stats
 */
class CL_Stats extends CL_Base {

	private static $current_mysql_date = null;

	/**
	 * The Constructor
	 */
	public function __construct() {

		// AJAX
		$this->add_action( 'wp_ajax_mts_cl_stats', 'statistics' );
		$this->add_action( 'wp_ajax_nopriv_mts_cl_stats', 'statistics' );
	}

	/**
	 * Add the stats to db
	 * @return void
	 */
	public function statistics() {

		if ( ! $this->verify() ) {
			wp_send_json(array(
				'success' => false,
				'message' => esc_html__( 'Not permitted.', 'content-locker' ),
			));
		}

		$stats   = isset( $_POST['stats'] ) ? $_POST['stats'] : array();
		$context = isset( $_POST['context'] ) ? $_POST['context'] : array();

		// event
		$event_name = isset( $stats['name'] ) ? $stats['name'] : null;
		$event_type = isset( $stats['type'] ) ? $stats['type'] : null;

		// context
		$post_id   = isset( $context['post_id'] ) ? $context['post_id'] : null;
		$locker_id = isset( $context['locker_id'] ) ? $context['locker_id'] : null;

		if ( empty( $locker_id ) ) {
			wp_send_json(array(
				'success' => false,
				'message' => esc_html__( 'Locker ID is not specified.', 'content-locker' ),
			));
		}

		// Process it now.
		$this->process_event( $locker_id, $post_id, $event_name, $event_type );
		wp_send_json(array(
			'success' => true,
			'message' => esc_html__( 'Counted.', 'content-locker' ),
		));
	}

	/**
	 * Counts an event (unlock, impress, etc.)
	 * @method process_event
	 * @return void
	 */
	protected function process_event( $locker_id, $post_id, $event_name, $event_type ) {

		if ( 'unlock' == $event_type ) {
			self::count_metric( $locker_id, $post_id, 'unlock' );
			self::count_metric( $locker_id, $post_id, 'unlock-via-' . $event_name );
		} elseif ( 'skip' == $event_type ) {
			self::count_metric( $locker_id, $post_id, 'skip' );
			self::count_metric( $locker_id, $post_id, 'skip-via-' . $event_name );
		} else {
			self::count_metric( $locker_id, $post_id, $event_name );
		}

		// updates the summary stats for the item

		if ( 'unlock' === $event_type ) {

			$unlocks = intval( get_post_meta( $locker_id, '_mts_cl_unlocks', true ) );
			$unlocks++;
			update_post_meta( $locker_id, '_mts_cl_unlocks', $unlocks );

		} elseif ( 'impress' === $event_name ) {

			$imperessions = intval( get_post_meta( $locker_id, '_mts_cl_imperessions', true ) );
			$imperessions++;
			update_post_meta( $locker_id, '_mts_cl_imperessions', $imperessions );
		}
	}

	/**
	 * Update the count in db for the metric
	 * @param  int     $locker_id
	 * @param  int     $post_id
	 * @param  string  $metric
	 * @return void
	 */
	public static function count_metric( $locker_id, $post_id, $metric ) {

		global $wpdb;

		if ( empty( $locker_id ) || empty( $post_id ) ) {
			return;
		}

		$wpdb->query( $wpdb->prepare(
			"INSERT INTO {$wpdb->prefix}mts_locker_stats
			(aggregate_date,locker_id,post_id,metric_name,metric_value)
			VALUES (%s,%d,%d,%s,1)
			ON DUPLICATE KEY UPDATE metric_value = metric_value + 1",
			self::get_current_date(), $locker_id, $post_id, $metric
		) );
	}

	/**
	 * A helper method to return a current date in the MySQL format.
	 * @method get_current_date
	 * @return [type]           [description]
	 */
	public static function get_current_date() {

		if ( self::$current_mysql_date ) {
			return self::$current_mysql_date;
		}

		$hrs_offset = get_option( 'gmt_offset' );
		if ( strpos( $hrs_offset, '-' ) !== 0 ) {
			$hrs_offset = '+' . $hrs_offset;
		}

		$hrs_offset .= ' hours';
		$time = strtotime( $hrs_offset, time() );

		self::$current_mysql_date = date( 'Y-m-d', $time );
		return self::$current_mysql_date;
	}

	/**
	 * Verify the request using nonce
	 *
	 * @return boolean
	 */
	public function verify() {
		return check_admin_referer( 'mts_cl_security', 'security', false );
	}

	/**
	 * Returns data to show charts.
	 * Charts show the stats for a specified item and for all or a single posts.
	 *
	 * @param  array $options
	 * @return array
	 */
	public static function get_chart_data( $options ) {
		global $wpdb;

		$post_id = isset( $options['post_id'] ) ? $options['post_id'] : null;
		$item_id = isset( $options['item_id'] ) ? $options['item_id'] : null;

		$range_end   = isset( $options['range_end'] ) ? $options['range_end'] : null;
		$range_start = isset( $options['range_start'] ) ? $options['range_start'] : null;

		$range_end_str   = gmdate( 'Y-m-d', $range_end );
		$range_start_str = gmdate( 'Y-m-d', $range_start );

		// building and executeing a sql query
		$extra_where = '';
		if ( $post_id ) {
			$extra_where .= ' AND t.post_id=' . $post_id;
		}
		if ( $item_id ) {
			$extra_where .= ' AND t.locker_id=' . $item_id;
		}

		$raw_data = $wpdb->get_results( "SELECT
					t.aggregate_date AS aggregate_date,
					t.metric_name AS metric_name,
					SUM(t.metric_value) AS metric_value
				 FROM
					{$wpdb->prefix}mts_locker_stats AS t
				 WHERE
					(aggregate_date BETWEEN '$range_start_str' AND '$range_end_str')
					$extra_where
				 GROUP BY
					t.aggregate_date, t.metric_name", ARRAY_A );

		// extracting metric names stored in the database &
		// grouping the same metrics data per day

		$data         = array();
		$metric_names = array();

		foreach ( $raw_data as $row ) {
			$metric_name  = $row['metric_name'];
			$metric_value = $row['metric_value'];

			if ( ! in_array( $metric_name, $metric_names ) ) {
				$metric_names[] = $metric_name;
			}

			$timestamp                          = strtotime( $row['aggregate_date'] );
			$data[ $timestamp ][ $metric_name ] = $metric_value;
		}

		// normalizing data by adding zero value for skipped dates
		$result_data  = array();
		$current_date = $range_start;

		while ( $current_date <= $range_end ) {

			$phpdate                      = getdate( $current_date );
			$result_data[ $current_date ] = array();

			$result_data[ $current_date ]['day']       = $phpdate['mday'];
			$result_data[ $current_date ]['mon']       = $phpdate['mon'] - 1;
			$result_data[ $current_date ]['year']      = $phpdate['year'];
			$result_data[ $current_date ]['timestamp'] = $current_date;

			foreach ( $metric_names as $metric_name ) {

				if ( ! isset( $data[ $current_date ][ $metric_name ] ) ) {
					$result_data[ $current_date ][ $metric_name ] = 0;
				} else {
					$result_data[ $current_date ][ $metric_name ] = $data[ $current_date ][ $metric_name ];
				}
			}

			$current_date = strtotime( '+1 days', $current_date );
		}

		return $result_data;
	}

	/**
	 * Returns data to show in the data table.
	 *
	 * @param  array $options
	 * @return array
	 */
	public static function get_table_data( $options ) {

		global $wpdb;

		$post_id     = isset( $options['post_id'] ) ? $options['post_id'] : null;
		$item_id     = isset( $options['item_id'] ) ? $options['item_id'] : null;
		$range_end   = isset( $options['range_end'] ) ? $options['range_end'] : null;
		$range_start = isset( $options['range_start'] ) ? $options['range_start'] : null;

		$range_end_str   = gmdate( 'Y-m-d', $range_end );
		$range_start_str = gmdate( 'Y-m-d', $range_start );

		$per   = isset( $options['per'] ) ? $options['per'] : 50;
		$page  = isset( $options['page'] ) ? $options['page'] : 1;
		$total = isset( $options['total'] ) ? $options['total'] : true;
		$order = isset( $options['order'] ) ? $options['order'] : 'unlock';

		$start = ( $page - 1 ) * $per;

		// building and executeing a sql query
		$extra_where = '';
		if ( $post_id ) {
			$extra_where .= ' AND t.post_id=' . $post_id;
		}
		if ( $item_id ) {
			$extra_where .= ' AND t.locker_id=' . $item_id;
		}

		$count = ( $total ) ? $wpdb->get_var(
			"SELECT COUNT(Distinct t.post_id) FROM {$wpdb->prefix}mts_locker_stats AS t
			WHERE (aggregate_date BETWEEN '$range_start_str' AND '$range_end_str') $extra_where") : 0;

		$raw_data = $wpdb->get_results( "
			SELECT
				t.metric_name AS metric_name,
				SUM(t.metric_value) AS metric_value,
				t.post_id AS post_id,
				p.post_title AS post_title
			FROM
				{$wpdb->prefix}mts_locker_stats AS t
			LEFT JOIN
				{$wpdb->prefix}posts AS p ON p.ID = t.post_id
			WHERE
				(aggregate_date BETWEEN '$range_start_str' AND '$range_end_str') $extra_where
			GROUP BY t.post_id, t.metric_name", ARRAY_A );

		// extracting metric names stored in the database &
		// grouping the same metrics data per day

		$metric_names = array();
		$result_data  = array();

		foreach ( $raw_data as $row ) {
			$metric_name  = $row['metric_name'];
			$metric_value = $row['metric_value'];
			$post_id      = $row['post_id'];

			if ( ! in_array( $metric_name, $metric_names ) ) {
				$metric_names[] = $metric_name;
			}

			if ( ! isset( $result_data[ $post_id ] ) ) {

				$title = $row['post_title'];
				if ( empty( $title ) ) {
					$title = __( '(the post not found)', 'content-locker' );
				}

				$result_data[ $post_id ]['id']    = $post_id;
				$result_data[ $post_id ]['title'] = $title;
			}

			$result_data[ $post_id ][ $metric_name ] = $metric_value;
		}

		$return_data = array();
		foreach ( $result_data as $row ) {
			$return_data[] = $row;
		}

		return array(
			'data'  => $return_data,
			'count' => $count,
		);
	}
}
new CL_Stats;
