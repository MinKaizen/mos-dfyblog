<?php
/**
 * The WP Shortcode Tools.
 *
 * @since      1.0
 * @package    WPS_Tools
 * @subpackage WP_SHORTCODE/includes
 */

class WPS_Tools {
	function __construct() {}

	public function select( $args ) {
		$args = wp_parse_args( $args, array(
				'id'		=> '',
				'name'		=> '',
				'class'		=> '',
				'multiple'	=> '',
				'size'		=> '',
				'disabled'	=> '',
				'selected'	=> '',
				'none'		=> '',
				'options'	=> array(),
				'style'		=> '',
				'format'	=> 'keyval',
				'noselect'	=> ''
			) );
		$options = array();
		if ( !is_array( $args['options'] ) )
			$args['options'] = array();

		if ( $args['id'] )
			$args['id'] = ' id="' . $args['id'] . '"';

		if ( $args['name'] )
			$args['name'] = ' name="' . $args['name'] . '"';

		if ( $args['class'] )
			$args['class'] = ' class="' . $args['class'] . '"';

		if ( $args['style'] )
			$args['style'] = ' style="' . esc_attr( $args['style'] ) . '"';

		if ( $args['multiple'] )
			$args['multiple'] = ' multiple="multiple"';

		if ( $args['disabled'] )
			$args['disabled'] = ' disabled="disabled"';

		if ( $args['size'] )
			$args['size'] = ' size="' . $args['size'] . '"';

		if ( $args['none'] && $args['format'] === 'keyval' )
			$args['options'][0] = $args['none'];
	
		if ( $args['none'] && $args['format'] === 'idtext' )
			array_unshift( $args['options'], array( 'id' => '0', 'text' => $args['none'] ) );

		if ( $args['format'] === 'keyval' ) foreach ( $args['options'] as $id => $text ) {
			$options[] = '<option value="' . (string) $id . '">' . (string) $text . '</option>';
		} elseif ( $args['format'] === 'idtext' ) {
			foreach ( $args['options'] as $option ) {
				if ( isset( $option['id'] ) && isset( $option['text'] ) )
					$options[] = '<option value="' . (string) $option['id'] . '">' . (string) $option['text'] . '</option>';
			}
		}
		$options = implode( '', $options );
		$options = str_replace( 'value="' . $args['selected'] . '"', 'value="' . $args['selected'] . '" selected="selected"', $options );
		return ( $args['noselect'] ) ? $options : '<select' . $args['id'] . $args['name'] . $args['class'] . $args['multiple'] . $args['size'] . $args['disabled'] . $args['style'] . '>' . $options . '</select>';
	}

	public function get_taxonomies() {
		$taxes = array();
		foreach ( (array) get_taxonomies( '', 'objects' ) as $tax ) {
			$taxes[$tax->name] = $tax->label;
		}
		return $taxes;
	}

	public function get_terms( $tax = 'category', $key = 'id' ) {
		$terms = array();
		$terms[''] = __( 'All', 'wp-shortcode-pro' );
		foreach ( (array) get_terms( $tax, array( 'hide_empty' => false ) ) as $term ) {
			if ( $key === 'id' ) {
				$terms[$term->term_id] = $term->name;
			} elseif ( $key === 'slug' ) {
				$terms[$term->slug] = $term->name;
			}
		}
		return $terms;
	}

	public function get_tab() {
		$shortcode = wp_shortcode()->list->shortcodes( sanitize_key( 'tab' ) );

		if ( isset( $shortcode['fields'] ) && count( $shortcode['fields'] ) ) {

			foreach ( $shortcode['fields'] as $attr_name => $attr_info ) {

				$default = (string) ( isset( $attr_info['default'] ) ) ? $attr_info['default'] : '';
				$attr_info['name'] = ( isset( $attr_info['name'] ) ) ? $attr_info['name'] : $attr_name;
				$return .= '<div class="wps-field-wrapper' . $skip . '" data-default="' . esc_attr( $default ) . '">';
				$return .= '<h5>' . $attr_info['name'] . '</h5>';

				if ( !isset( $attr_info['type'] ) && isset( $attr_info['values'] ) && is_array( $attr_info['values'] ) && count( $attr_info['values'] ) ) {
					$attr_info['type'] = 'select';
				} elseif ( !isset( $attr_info['type'] ) ) {
					$attr_info['type'] = 'text';
				}
				if ( is_callable( array( 'WPS_Fields', $attr_info['type'] ) ) ) {
					$return .= call_user_func( array( 'WPS_Fields', $attr_info['type'] ), $attr_name, $attr_info );
				}  elseif ( isset( $attr_info['callback'] ) && is_callable( $attr_info['callback'] ) ) {
					$return .= call_user_func( $attr_info['callback'], $attr_name, $attr_info );
				}
				if ( isset( $attr_info['desc'] ) ) {
					$return .= '<div class="wps-field-value-desc">' . str_replace( array( '<b%value>', '<b_>' ), '<b class="wps-set-value" title="' . __( 'Click to set this value', 'wp-shortcode-pro' ) . '">', $attr_info['desc'] ) . '</div>';
				}
				$return .= '</div>';
			}
		}

		$return .= '<input type="hidden" name="wp-shortcode-content" id="wp-shortcode-content" value="false" />';
		echo $return;
	}

	public function get_slides( $args ) {

		$args = wp_parse_args( $args, array(
				'source'	=> 'none',
				'limit'		=> 20,
				'gallery'	=> null,
				'type'		=> '',
				'link'		=> 'none'
			) );

		$slides = array();
		foreach ( array( 'media', 'posts', 'category', 'taxonomy' ) as $type ) {
			if ( strpos( trim( $args['source'] ), $type . '-' ) === 0 ) {
				$args['source'] = array(
					'type' => $type,
					'val'	=> (string) trim( str_replace( array( $type . '-', ' ' ), '', $args['source'] ), ',' )
				);
				break;
			} else if( strpos( trim( $args['source'] ), $type . ':' ) === 0 ) {
				$args['source'] = array(
					'type' => $type,
					'val'	=> (string) trim( str_replace( array( $type . ':', ' ' ), '', $args['source'] ), ',' )
				);
				break;
			}
		}

		if ( !is_array( $args['source'] ) )
			return $slides;

		$query = array( 'posts_per_page' => $args['limit'] );

		if ( $args['source']['type'] === 'media' ) {
			$query['post_type'] = 'attachment';
			$query['post_status'] = 'any';
			$query['post__in'] = (array) explode( ',', $args['source']['val'] );
			$query['orderby'] = 'post__in';
		}

		if ( $args['source']['type'] === 'posts' ) {
			if ( $args['source']['val'] !== 'recent' ) {
				$query['post__in'] = (array) explode( ',', $args['source']['val'] );
				$query['orderby'] = 'post__in';
				$query['post_type'] = 'any';
			}
		} elseif ( $args['source']['type'] === 'category' ) {
			$query['category__in'] = (array) explode( ',', $args['source']['val'] );
		} elseif ( $args['source']['type'] === 'taxonomy' ) {

			$args['source']['val'] = explode( '/', $args['source']['val'] );

			if ( !is_array( $args['source']['val'] ) || count( $args['source']['val'] ) !== 2 )
				return $slides;

			$query['tax_query'] = array(
				array(
					'taxonomy' => $args['source']['val'][0],
					'field' => 'id',
					'terms' => (array) explode( ',', $args['source']['val'][1] )
				)
			);
			$query['post_type'] = 'any';
		}

		$query = apply_filters( 'wps_slides_query', $query, $args );
		$query = new WP_Query( $query );

		if ( is_array( $query->posts ) ) foreach ( $query->posts as $post ) {

				$thumb = ( $args['source']['type'] === 'media' || $post->post_type === 'attachment' ) ? $post->ID : get_post_thumbnail_id( $post->ID );

				if ( !is_numeric( $thumb ) )
					continue;

				$slide = array(
					'image' => wp_get_attachment_url( $thumb ),
					'link'  => '',
					'title' => get_the_title( $post->ID )
				);
				if ( $args['link'] === 'image' || $args['link'] === 'lightbox' ) {
					$slide['link'] = $slide['image'];
				} elseif ( $args['link'] === 'post' ) {
					$slide['link'] = get_permalink( $post->ID );
				} elseif ( $args['link'] === 'attachment' ) {
					$slide['link'] = get_attachment_link( $thumb );
				}
				$slides[] = $slide;
			}

		return $slides;
	}

	public function icon( $src = 'file' ) {
		return ( strpos( $src, '/' ) !== false ) ? '<img src="' . $src . '" alt="" />' : '<i class="fa fa-' . $src . '"></i>';
	}

	public function get_icon( $args ) {
		$args = wp_parse_args( $args, array(
				'icon' => '',
				'size' => '',
				'color' => '',
				'style' => ''
			) );

		if ( !$args['icon'] ) return;

		if ( $args['style'] ) {
			$args['style'] = rtrim( $args['style'], ';' ) . ';';	
		}

		if ( in_array($args['icon'], wps_icons()) ) {

			if ( $args['size'] )
				$args['style'] .= 'font-size:' . $args['size'] . 'px;';

			if ( $args['color'] )
				$args['style'] .= 'color:' . $args['color'] . ';';

			wps_sortcode_script( 'css', 'wps-fontawesome' );

			return '<i class="fa fa-' . trim( str_replace( 'icon:', '', $args['icon'] ) ) . '" style="' . $args['style'] . '"></i>';
		} elseif ( strpos( $args['icon'], '/' ) !== false ) {

			if ( $args['size'] )
				$args['style'] .= 'width:' . $args['size'] . 'px;height:' . $args['size'] . 'px;';
			return '<img src="' . $args['icon'] . '" alt="" style="' . $args['style'] . '" />';
		}

		return false;
	}

	public function icons() {
		$icons = array();
		if ( !empty(wps_icons()) ) {
			foreach ( (array) wps_icons() as $icon ) {
				$icons[] = '<i class="fa fa-' . $icon . '" title="' . $icon . '"></i>';
			}
		}
		return implode( '', $icons );
	}

	public function error( $prefix = false, $message = false ) {
		if ( !$prefix && !$message ) return '';
		$alert_shortcode = wps_prefix().'alert';
		return do_shortcode('['.$alert_shortcode.' type="danger"]'.'<strong>' . $prefix . '</strong> '.$message.'[/'.$alert_shortcode.']');
	}

	public function range( $string = '' ) {
		$numbers = array();

		foreach ( explode( ',', $string ) as $range ) {

			if ( strpos( $range, '-' ) !== false ) {

				$range = explode( '-', $range );

				if ( !is_numeric( $range[0] ) )
					$range[0] = 0;
				if ( !is_numeric( $range[1] ) )
					$range[1] = 0;

				sort( $range );

				$range = range( $range[0], $range[1] );

				foreach ( $range as $value )
					$numbers[$value] = $value;
			} else {
				$numbers[$range] = $range;
			}
		}

		return $numbers;
	}
}

// Init the shortcode tools.
wp_shortcode()->tools = new WPS_Tools;