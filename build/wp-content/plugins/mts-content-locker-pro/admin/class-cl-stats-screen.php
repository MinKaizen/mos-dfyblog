<?php
/**
 * The Stats Screen
 */
class CL_Stats_Screen {

	/**
	 * The Constructor
	 */
	public function __construct( $opts ) {

		$this->options = $opts;
	}

	/**
	 * Get Chart to display
	 * @return CL_Stats_Chart
	 */
	public function get_chart() {

		$data = CL_Stats::get_chart_data( $this->options );

		return new $this->options['chart_class']( $this, $data );
	}

	/**
	 * Get table to display
	 * @return CL_Stats_Table
	 */
	public function get_table() {

		$data = CL_Stats::get_table_data( $this->options );

		return new $this->options['table_class']( $this, $data );
	}
}

/**
 * The Stats Chart
 */
class CL_Stats_Chart {

	/**
	 * Chart type
	 * @var string
	 */
	public $type = 'area';

	/**
	 * The Constructor
	 * @param string $screen Scree Name to display
	 * @param mixed $data   Data for screen
	 */
	public function __construct( $screen, $data ) {

		$this->screen = $screen;
		$this->data   = $data;
	}

	/**
	 * Get Fields
	 * @return array
	 */
	public function get_fields() {
		return array();
	}

	/**
	 * Check if chart has selectors
	 * @return boolean
	 */
	public function has_selectors() {
		$selectors = $this->get_selectors();
		return ! empty( $selectors );
	}

	/**
	 * Get Selectors
	 * @return array
	 */
	public function get_selectors() {

		$fields = $this->get_fields();
		unset( $fields['aggregate_date'] );

		return $fields;
	}

	/**
	 * Get selectors name
	 * @return array
	 */
	public function get_selectors_names() {

		$selectors = $this->get_selectors();
		if ( empty( $selectors ) ) {
			return array();
		}

		$result = array();
		foreach ( $selectors as $key => $selector ) {
			$result[] = "'" . $key . "'";
		}

		return $result;
	}

	/**
	 * Display chart
	 * @return void
	 */
	public function print_data() {

		$output = '';
		$fields = $this->get_fields();

		foreach ( $this->data as $index => $row ) {

			$data = array();

			foreach ( $fields as $field => $field_data ) {

				if ( 'aggregate_date' == $field ) {

					$data['date'] = array( 'value' => 'new Date(' . $row['year'] . ',' . $row['mon'] . ',' . $row['day'] . ')' );

				} else {

					$data[ $field ] = array(
						'value' => $this->get_value( $index, $field ),
						'title' => isset( $field_data['title'] ) ? $field_data['title'] : '',
						'color' => isset( $field_data['color'] ) ? $field_data['color'] : null,
					);
				}
			}

			$row_data = '';
			foreach ( $data as $key => $data ) {

				if ( ! isset( $data['title'] ) ) {
					$data['title'] = '';
				}

				if ( ! isset( $data['color'] ) ) {
					$data['color'] = '';
				}

				$row_data .= "'$key': {'value': {$data['value']}, 'title': '{$data['title']}', 'color': '{$data['color']}'},";
			}

			$row_data = rtrim( $row_data, ',' );
			$output  .= '{' . $row_data . '},';
		}

		$output = rtrim( $output, ',' );
		echo $output;
	}

	/**
	 * Get values and filter them
	 * @param  int    $index
	 * @param  string $field
	 * @return mixed
	 */
	public function get_value( $index, $field ) {

		$camel_case = str_replace( '-', '_', $field );

		if ( method_exists( $this, 'field_' . $camel_case ) ) {
			return call_user_func( array( $this, 'field_' . $camel_case ), $this->data[ $index ], $index );
		} else {
			if ( isset( $this->data[ $index ][ $field ] ) ) {
				return $this->data[ $index ][ $field ];
			} else {
				return 0;
			}
		}
	}
}

/**
 * The Stats Table
 */
class CL_Stats_Table {

	/**
	 * Orderby
	 * @var string
	 */
	public $orderby = 'unlock';

	/**
	 * The Constructor
	 * @param string $screen Scree Name to display
	 * @param mixed $data   Data for screen
	 */
	public function __construct( $screen, $data ) {

		$this->screen = $screen;
		$this->data   = $data;

		usort( $data['data'], array( $this, '_usort' ) );
		$this->data['data'] = array_reverse( $data['data'] );
	}

	/**
	 * Custom sort function to sort the data according to field
	 * @param  mixed $a
	 * @param  mixed $b
	 * @return mixed
	 */
	public function _usort( $a, $b ) {

		$order_by = $this->orderby;

		if ( ! isset( $a[ $order_by ] ) && ! isset( $b[ $order_by ] ) ) {
			return 0;
		}
		if ( ! isset( $a[ $order_by ] ) ) {
			return -1;
		}
		if ( ! isset( $b[ $order_by ] ) ) {
			return 1;
		}
		if ( $a[ $order_by ] == $b[ $order_by ] ) {
			return 0;
		}

		return $a[ $order_by ] < $b[ $order_by ] ? -1 : 1;
	}

	/**
	 * Get coulmns
	 * @return array
	 */
	public function get_columns() {
		return array();
	}

	/**
	 * Get column names to display in table header
	 * @param  integer $level
	 * @return array
	 */
	public function get_header_columns( $level = 1 ) {

		$columns = $this->get_columns();

		if ( 2 === $level ) {

			$result = array();
			foreach ( $columns as $column ) {
				if ( ! isset( $column['columns'] ) ) {
					continue;
				}
				$result = array_merge( $result, $column['columns'] );
			}

			return $result;

		} else {

			foreach ( $columns as $n => $column ) {
				$columns[ $n ]['rowspan'] = isset( $column['columns'] ) ? 1 : 2;
				$columns[ $n ]['colspan'] = isset( $column['columns'] ) ? count( $column['columns'] ) : 1;
			}

			return $columns;
		}
	}

	/**
	 * If columns and child columns
	 * @return boolean
	 */
	public function has_complex_columns() {
		$columns = $this->get_header_columns( 2 );
		return ! empty( $columns );
	}

	/**
	 * Get column data
	 * @return [type] [description]
	 */
	public function get_data_columns() {
		$result = array();

		foreach ( $this->get_columns() as $name => $column ) {

			if ( isset( $column['columns'] ) ) {
				$result = array_merge( $result, $column['columns'] );
			} else {
				$result[ $name ] = $column;
			}
		}

		return $result;
	}

	/**
	 * Get number of columns
	 * @return int
	 */
	public function get_columns_count() {
		return count( $this->get_columns() );
	}

	/**
	 * Get number of rows
	 * @return int
	 */
	public function get_rows_count() {
		return count( $this->data['data'] );
	}

	/**
	 * Display the column value
	 * @param  int    $index
	 * @param  string $column_name
	 * @param  array  $column
	 * @return void
	 */
	public function print_value( $index, $column_name, $column ) {

		$camel_case = str_replace( '-', '_', $column_name );

		if ( method_exists( $this, 'column_' . $camel_case ) ) {
			call_user_func( array( $this, 'column_' . $camel_case ), $this->data['data'][ $index ], $index );
		} else {

			$value = isset( $this->data['data'][ $index ][ $column_name ] ) ? $this->data['data'][ $index ][ $column_name ] : 0;

			if ( isset( $column['prefix'] ) && 0 !== $value ) {
				echo $column['prefix'];
			}

			echo $value;
		}
	}

	/**
	 * Display column index
	 * @param  int $row
	 * @param  int $index
	 * @return void
	 */
	public function column_index( $row, $index ) {
		echo $index + 1;
	}

	/**
	 * Display column title
	 * @param  array $row
	 * @return void
	 */
	public function column_title( $row ) {
		$title = ! empty( $row['title'] ) ? $row['title'] : '<i>' . esc_html__( '(untitled post)', 'content-locker' ) . '</i>';

		if ( ! empty( $row['id'] ) ) {
			echo '<a href="' . get_permalink( $row['id'] ) . '" target="_blank">' . $title . ' </a>';
		} else {
			echo $title;
		}
	}

	/**
	 * Display c
	 * @param  [type] $row [description]
	 * @return [type]      [description]
	 */
	public function column_conversion( $row ) {

		if ( ! isset( $row['impress'] ) ) {
			$row['impress'] = 0;
		}

		if ( ! isset( $row['unlock'] ) ) {
			$row['unlock'] = 0;
		}

		if ( 0 == $row['impress'] ) {
			echo '0%';
			return;
		}

		if ( $row['unlock'] > $row['impress'] ) {
			echo '100%';
			return;
		}

		echo ( ceil( $row['unlock'] / $row['impress'] * 10000 ) / 100 ) . '%';
	}
}
