<?php
/**
 * The WP Shortcodes.
 *
 * @since      1.0
 * @package    WP_SHORTCODE
 * @subpackage WP_SHORTCODE/includes
 */

class WP_Shortcodes {
	static $tabs = array();
	static $tab_count = 0;
	static $default_toc_options = array();

	function __construct() {}

	public static function get_wps_icon($icon, $default = '') {
		if (filter_var($icon, FILTER_VALIDATE_URL) !== FALSE) {
			$icon = '<img src="' . esc_url($icon) . '" />';
		} else {
			if( strpos( trim( $icon ), 'icon: ' ) === 0 ) {
				$icon = (string) trim(str_replace( 'icon: ', '', $icon ));
			}
			if ( ! in_array($icon, wps_icons()) ) {
				$icon = $default;
			}
			if($icon) {
				$icon = '<i class="fa fa-' . trim( $icon ) . '"></i>';
				wps_sortcode_script( 'css', 'wps-fontawesome' );
			} else {
				$icon = '';
			}
		}
		return $icon;
	}

	public static function alert( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'type'	=> 'primary',
				'class'	=> ''
			), $atts, 'alert' );

		switch($atts['type']) {
			case 'default':
				$atts['type'] = 'secondary';
			break;
			case 'important':
				$atts['type'] = 'note';
			break;
			case 'black':
				$atts['type'] = 'dark';
			break;
			case 'info':
				$atts['type'] = 'announce';
			break;
		}

		do_action('wps_before_alert', $atts);
		$data = '<div class="wps-shortcode-wrapper wps-alert wps-alert-' . $atts['type'] . wps_specific_class( $atts ) . '" id="wps-alert">' . do_shortcode( $content ) . '</div>';
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		do_action('wps_after_alert', $atts);
		return $data;
	}

	public static function heading( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'			=> 13,
				'align'			=> 'center',
				'font_weight'	=> 'normal',
				'font_style'	=> 'normal',
				'margin'		=> '20',
				'class'			=> ''
			), $atts, 'heading' );
		ob_start();
		do_action( 'wps_before_heading', $atts );
		?>
		<div class="wps-shortcode-wrapper wps-heading wps-align-<?php echo $atts['align']; ?> <?php echo wps_specific_class( $atts ); ?>" id="wps-heading" style="font-size:<?php echo intval( $atts['size'] ); ?>px; margin-bottom:<?php echo $atts['margin']; ?>px; font-weight:<?php echo $atts['font_weight']; ?>; font-style:<?php echo $atts['font_style']; ?>;">
			<div class="wps-heading-inner"><?php echo do_shortcode( $content ); ?></div>
		</div>
		<?php
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		do_action( 'wps_after_heading', $atts );
		return ob_get_clean();
	}

	public static function tabs( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'standard',
				'active'	=> 1,
				'vertical'	=> 'no',
				'class'		=> ''
			), $atts, 'tabs' );

		//Get Tab data
		do_shortcode( $content );
		$tabs = $tab_content = array();

		if( !is_array( self::$tabs ) || empty( self::$tabs ) ) return;

		$atts['vertical'] = ( $atts['vertical'] === 'yes' ) ? ' wps-tabs-vertical' : ' wps-tabs-horizontal';

		if ( self::$tab_count < $atts['active'] ) {
			$atts['active'] = self::$tab_count;
		}
		foreach ( self::$tabs as $key => $tab ) {
			$class = ( $atts['active'] == ( $key + 1 ) ) ? ' wps-active' : '';
			$tabs[] = '<li class="' . wps_specific_class( $tab ) . $tab['disabled'] . $class . '"' . $tab['anchor'] . $tab['url'] . $tab['target'] . '>' . esc_html( $tab['title'] ) . '</li>';
			$tab_content[] = '<div class="wps-tab-text' . wps_specific_class( $tab ) . ' ' . $class . '">' . $tab['content'] . '</div>';
		}
		ob_start();
		do_action( 'wps_before_tabs', $atts );
		?>
		<div class="wps-shortcode-wrapper wps-tabs wps-tabs-<?php echo esc_attr($atts['style']); ?> <?php echo $atts['vertical'].' '. wps_specific_class( $atts ) ?>" id="wps-tabs">
			<ul class="wps-tabs-list">
				<?php echo implode( '', $tabs ); ?>
			</ul>
			<div class="wps-tabs-content">
				<?php echo implode( "\n", $tab_content ); ?>
			</div>
		</div>
		<?php
		self::$tabs = array();
		self::$tab_count = 0;
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		do_action( 'wps_after_tabs', $atts );
		return ob_get_clean();
	}

	public static function tab( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'		=> __( 'Tab', 'wp-shortcode-pro' ),
				'disabled'	=> 'no',
				'anchor'	=> '',
				'url'		=> '',
				'target'	=> 'blank',
				'class'		=> ''
			), $atts, 'tab' );
		$count = self::$tab_count;
		self::$tabs[$count] = array(
			'title'		=> $atts['title'],
			'content'	=> do_shortcode( $content ),
			'disabled'	=> ( $atts['disabled'] === 'yes' ) ? ' wps-tabs-disabled' : '',
			'anchor'	=> ( $atts['anchor'] ) ? ' data-anchor="' . str_replace( array( ' ', '#' ), '', sanitize_text_field( $atts['anchor'] ) ) . '"' : '',
			'url'		=> ' data-url="' . $atts['url'] . '"',
			'target'	=> ' data-target="' . $atts['target'] . '"',
			'class'		=> $atts['class']
		);
		self::$tab_count++;
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
	}

	public static function pricing_table( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'	=>'style-1',
				'class'	=> ''
			), $atts, 'pricing_table' );

		ob_start();
			do_action( 'wps_before_pricing_table', $atts );
		?>
			<div class="wps-shortcode-wrapper wps-pricing-table wps-<?php echo esc_attr($atts['style']); ?> <?php wps_specific_class( $atts ) ?>" id="wps-pricing-table">
				<?php echo do_shortcode(stripslashes($content)); ?>
			</div>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action( 'wps_after_pricing_table', $atts );
		return ob_get_clean();
	}

	public static function plan( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'	=> '',
				'currency' => '$',
				'price'	=> '',
				'old_price'	=> '',
				'period'	=> '',
				'background'	=> '',
				'color'	=> '',
				'icon'	=> '',
				'icon_color'	=> 'inherit',
				'button_text'	=> '',
				'button_url'	=> '#',
				'button_background'	=> '',
				'button_color'	=> '',
				'target' => 'blank',
				'featured'	=> '',
				'class'	=> ''
			), $atts, 'plan' );

		$style = '';
		if( $atts['background'] ) {
			$style = 'style="background-color:'.$atts['background'].'; color:'.$atts['color'].';"';
		}
		$button_style = 'style="background:'.$atts['button_background'].'; color:'.$atts['button_color'].';"';
		ob_start();
			do_action( 'wps_before_plan', $atts );
		?>
			<div class="wps-plan wps-plan-<?php echo esc_attr($atts['featured']); ?>  <?php wps_specific_class( $atts ) ?>" <?php echo $style; ?>>
				<div class="wps-plan-head">
					<?php if($atts['featured'] == 'featured') { ?>
						<div class="wps-plan-badge"><?php _e('MOST POPULAR', 'wp-shortcode-pro'); ?></div>
					<?php } ?>
					<div class="wps-plan-name"><?php echo esc_html($atts['title']); ?></div>
					<div class="wps-plan-price">
						<span class="wps-plan-price-before"><?php echo esc_html($atts['currency']); ?></span><span class="wps-plan-price-value"><?php echo esc_html($atts['price']); ?></span>
					</div>
					<?php if( $atts['old_price'] ) { ?>
						<div class="wps-plan-old-price">
							<span class="wps-plan-price-before"><?php echo esc_html($atts['currency']); ?></span><span class="wps-plan-price-value"><?php echo esc_html($atts['old_price']); ?></span>
						</div>
					<?php } ?>
					<div class="wps-plan-period"><?php echo esc_html($atts['period']); ?></div>
					<div class="wps-plan-icon" style="color: <?php echo esc_attr($atts['icon_color']); ?>">
						<?php echo self::get_wps_icon($atts['icon']); ?>
					</div>
				</div>
				<div class="wps-plan-content">
					<?php echo $content; ?>
				</div>
				<?php if( $atts['button_text'] ) { ?>
				<div class="wps-plan-footer">
					<a href="<?php echo esc_url($atts['button_url']); ?>" class="wps-plan-button" target="_<?php echo esc_attr($atts['target']); ?>" <?php echo $button_style; ?>><?php echo esc_attr($atts['button_text']); ?></a>
				</div>
				<?php } ?>
			</div>
		<?php
			do_action( 'wps_after_plan', $atts );
		return ob_get_clean();
	}

	public static function accordion( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'style' => 'standard',
			'class' => ''
		), $atts, 'accordion' );
		ob_start();
			do_action( 'wps_before_accordion', $atts );
		?>
			<div class="wps-shortcode-wrapper wps-accordion wps-accordion-<?php echo esc_attr($atts['style']); ?> <?php echo wps_specific_class( $atts ); ?>" id="wps-accordion">
				<?php echo do_shortcode( $content ); ?>
			</div>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			wps_sortcode_script( 'css', 'wps-fontawesome' );
			do_action( 'wps_after_accordion', $atts );
		return ob_get_clean();
	}

	public static function accordion_item( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'	=> __( 'Accordion Item', 'wp-shortcode-pro' ),
				'open'	=> 'no',
				'style'	=> 'default',
				'icon'	=> 'caret',
				'class'	=> ''
			), $atts, 'accordion_item' );

		$atts['style'] = str_replace( array( '1', '2' ), array( 'default', 'fancy' ), $atts['style'] );
		if ( $atts['open'] !== 'yes' ) $atts['class'] .= ' is-closed'; else $atts['class'] .= ' is-open';;
		ob_start();
			do_action( 'wps_before_accordion_item', $atts );
		?>
			<div class="wps-panel wps-panel-icon-<?php echo $atts['icon'].' '.wps_specific_class( $atts ); ?>">
				<div class="wps-panel-title">
					<span class="wps-panel-icon"></span>
					<?php echo esc_html( $atts['title'] ); ?>
				</div>
				<div class="wps-panel-content">
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
			do_action( 'wps_after_accordion_item', $atts );
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function separator( $atts = null, $content = null ) {
		if(isset($atts['divider_color'])) $atts['separator_color'] = $atts['divider_color'];
		$atts = shortcode_atts( array(
				'top'				=> 'yes',
				'text'				=> __( 'Top', 'wp-shortcode-pro' ),
				'style'				=> 'default',
				'separator_color'	=> '#444',
				'link_color'		=> '#444',
				'size'				=> '2',
				'margin'			=> '20',
				'class'				=> ''
			), $atts, 'separator' );

		$atts['style'] = ( $atts['style'] == 'default' ) ? 'solid' : $atts['style'];
		$top = ( $atts['top'] == 'yes' ) ? '<a href="#" style="color:' . $atts['link_color'] . '; text-decoration: none;">' . esc_html( $atts['text'] ) . '</a>' : '';
		$style = 'style="text-align: right; clear: both; margin: '.$atts['margin'].'px 0; border-width: '.$atts['size'].'px; border-color: '.$atts['separator_color'].'; border-bottom-style: '.$atts['style'].';"';
		ob_start();
			do_action( 'wps_before_separator', $atts );
		?>
			<div class="wps-shortcode-wrapper wps-separator <?php echo wps_specific_class( $atts ); ?>" id="wps-separator" <?php echo $style; ?>>
				<?php echo $top; ?>
			</div>
		<?php
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			do_action( 'wps_after_separator', $atts );
		return ob_get_clean();
	}

	public static function spacer( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'  => '20',
				'class' => ''
			), $atts, 'spacer' );
		return '<div class="wps-shortcode-wrapper wps-spacer' . wps_specific_class( $atts ) . '" style="height:' . $atts['size'] . 'px; clear: both;"></div>';
	}

	public static function highlight( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'background'	=> '',
				'color'			=> '#000',
				'class'			=> ''
			), $atts, 'highlight' );
		$style = 'style="background:' . $atts['background'] . ';color:' . $atts['color'] . '"';
		ob_start();
		do_action('wps_before_highlight', $atts);
		?>
		<span class="wps-shortcode-wrapper wps-highlight <?php echo wps_specific_class( $atts ); ?>" id="wps-highlight" <?php echo $style; ?>>
			<?php echo do_shortcode( $content ); ?>
		</span>
		<?php
		do_action('wps_after_highlight', $atts);
		return ob_get_clean();
	}

	public static function quote( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'default',
				'cite'	=> '',
				'url'	=> '',
				'class'	=> ''
			), $atts, 'quote' );
		$cite_link = ( $atts['url'] && $atts['cite'] ) ? '<a href="' . $atts['url'] . '" target="_blank">' . $atts['cite'] . '</a>'
		: $atts['cite'];
		$cite = ( $atts['cite'] ) ? '<span class="wps-quote-cite">' . $cite_link . '</span>' : '';
		ob_start();
			do_action( 'wps_before_quote', $atts );
		?>
			<div class="wps-shortcode-wrapper wps-quote wps-<?php echo esc_attr($atts['style']); ?> <?php echo wps_specific_class( $atts ); ?>" id="wps-quote">
				<div class="wps-quote-inner">
					<?php
						echo '<p>'.do_shortcode($content).'</p>';
						if($atts['cite']) {
							$cite_link = $atts['url'] ? '<a href="' . $atts['url'] . '" target="_blank">' . $atts['cite'] . '</a>' : $atts['cite'];
							echo '<span class="wps-quote-cite">'.$cite_link.'</span>';
						}
					?>
				</div>
			</div>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action( 'wps_after_quote', $atts );
		return ob_get_clean();
	}

	public static function pullquote( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'	=> 'standard',
				'align'	=> 'left',
				'class'	=> ''
			), $atts, 'pullquote' );
		ob_start();
			do_action( 'wps_before_pullquote', $atts );
		?>
			<div class="wps-shortcode-wrapper wps-pullquote wps-pullquote-<?php echo esc_attr($atts['style']); ?> wps-pullquote-align-<?php echo $atts['align'] .' '.wps_specific_class( $atts ); ?>" id="wps-pullquote">
				<?php echo do_shortcode( $content ); ?>
			</div>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action( 'wps_after_pullquote', $atts );
		return ob_get_clean();
	}

	public static function dropcap( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'color'	=> '',
				'background'	=> '',
				'border'	=> '',
				'radius'	=> '',
				'size'	=> 3,
				'class'	=> ''
			), $atts, 'dropcap' );

		$dropcap_style = 'font-size:'.$atts['size'].'em;';
		if($atts['color']) {
			$dropcap_style .= 'color:'.$atts['color'].';';
		}
		if($atts['background']) {
			$dropcap_style .= 'background:'.$atts['background'].';';
		}
		if($atts['border']) {
			$dropcap_style .= 'border:'.$atts['border'].';';

		}
		if($atts['radius']) {
			$dropcap_style .= 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;';
		}

		if($atts['background'] || (trim($atts['border']) != '0px' && $atts['border'] != '')) {
			$atts['class'] = $atts['class'].' '.'wh-exists';
		}
		ob_start();
			do_action( 'wps_before_dropcap', $atts );
		?>
			<span class="wps-shortcode-wrapper wps-dropcap <?php echo wps_specific_class( $atts ); ?>" id="wps-dropcap" style="<?php echo $dropcap_style; ?>">
				<?php echo do_shortcode( $content ); ?>
			</span>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action( 'wps_after_dropcap', $atts );
		return ob_get_clean();
	}

	public static function frame( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'	=> 'default',
				'border' => '',
				'background' => '',
				'color' => '',
				'align'	=> 'left',
				'class'	=> ''
			), $atts, 'frame' );
		ob_start();
		do_action('wps_before_frame', $atts);
		$frame_style = '';
		if($atts['border']) {
			$frame_style .= 'border:'. $atts['border'].';';
		}
		if($atts['background']) {
			$frame_style .= 'background:'. $atts['background'].';';
		}
		if($atts['color']) {
			$frame_style .= 'color:'. $atts['color'].';';
		}
		?>
			<span class="wps-shortcode-wrapper wps-<?php echo esc_attr($atts['style']); ?> wps-frame wps-frame-align-<?php echo $atts['align'].' '.wps_specific_class( $atts ); ?>" id="wps-frame" style="<?php echo $frame_style; ?>">
				<span class="wps-frame-inner"><?php echo do_shortcode( $content ); ?></span>
			</span>
		<?php
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		do_action('wps_after_frame', $atts);
		return ob_get_clean();
	}

	public static function row( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'class' => ''
		), $atts );
		ob_start();
			do_action('wps_before_row', $atts);
			?>
			<div class="wps-shortcode-wrapper wps-row clear <?php echo wps_specific_class( $atts ); ?>" id="wps-row">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action('wps_after_row', $atts);
		return ob_get_clean();
	}

	public static function column( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'		=> '1-2',
				'center'	=> 'no',
				'class'		=> ''
			), $atts, 'column' );

		$atts['size'] = trim(str_replace( '/', '-', $atts['size'] ));
		$atts['class'] .= ( $atts['center'] === 'yes' ) ? ' centered' : $atts['class'];
		ob_start();
			do_action('wps_before_column', $atts);
		?>
			<div class="wps-column wps-shortcode-wrapper wps-column-size-<?php echo $atts['size'].' '.wps_specific_class( $atts ) ?>">
				<div class="wps-column-inner"><?php echo do_shortcode( $content ); ?></div>
			</div>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action('wps_after_column', $atts);
		return ob_get_clean();
	}

	public static function lists( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'icon'			=> 'check',
				'icon_color'	=> '#444',
				'class'			=> ''
			), $atts, 'lists' );
		ob_start();
			do_action('wps_before_lists', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-list <?php echo wps_specific_class( $atts ); ?>" id="wps-list">
				<?php echo str_replace( '<li>', '<li><span style="color: '.$atts['icon_color'].'">' . self::get_wps_icon($atts['icon'], 'check') . '</span> ', do_shortcode( $content ) ); ?>
			</div>
		<?php
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			do_action('wps_after_lists', $atts);
		return ob_get_clean();
	}

	public static function button( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'style'			=> 'default',
			'desc'			=> '',
			'url'			=> '',
			'target'		=> 'self',
			'background'	=> '#2D89EF',
			'color'			=> '#ffffff',
			'size'			=> 13,
			'icon'			=> '',
			'wide'			=> 'no',
			'position'		=> 'left',
			'radius'		=> 'auto',
			'text_shadow'	=> 'none',
			'rel'			=> '',
			'title'			=> '',
			'id'			=> '',
			'class'			=> ''
		), $atts, 'button' );

		$btn_css = array();
		$inner_css = array();
		$size = $atts['size'];
		if ( $atts['radius'] == 'auto' ) {
			$radius = round( $atts['size'] + 2 ) . 'px';
		} elseif ( $atts['radius'] == 'round' ){
			$radius = round( ( ( $size * 2 ) + 2 ) * 2 + $size ) . 'px';
		} elseif ( is_numeric( $atts['radius'] ) ) {
			$radius = intval( $atts['radius'] ) . 'px';
		} else {
			$radius = '0px';
		}

		$btn_rules = array(
			'color'					=> $atts['color'],
			'background-color'		=> $atts['background'],
			'border-color'			=> wps_hex_shift( $atts['background'], 'darker', 20 ),
			'border-radius'			=> $radius,
			'-moz-border-radius'	=> $radius,
			'-webkit-border-radius'	=> $radius
		);

		$inner_rules = array(
			'color'					=> $atts['color'],
			'padding'				=> '13px ' . round( $size * 2 + 10 ) . 'px',
			'font-size'				=> $size . 'px',
			'border-color'			=> wps_hex_shift( $atts['background'], 'lighter', 30 ),
			'border-radius'			=> $radius,
			'-moz-border-radius'	=> $radius,
			'-webkit-border-radius'	=> $radius,
			'text-shadow'			=> $atts['text_shadow'],
		);

		if($atts['style'] == 'bordered') {
			$inner_rules['border-color'] = $inner_rules['color'] = $btn_rules['background-color'];
			$btn_rules['background-color'] = 'transparent';
		} else if($atts['style'] == 'stroked') {
			$inner_rules['border-color'] = $inner_rules['color'];
		} else if($atts['style'] == '3d') {
			$btn_rules['box-shadow'] = "0 4px 0 ".wps_hex_shift( $atts['background'], 'darker', 30 );
		}

		foreach ( $btn_rules as $btn_rule => $btn_value ) {
			$btn_css[] = $btn_rule . ':' . $btn_value;
		}
		foreach ( $inner_rules as $inner_rule => $inner_value ){
			$inner_css[] = $inner_rule . ':' . $inner_value;
		}

		$is_wide = ( $atts['wide'] === 'yes' ) ? 'wps-button-wide' : '';
		$atts['rel'] = ( $atts['rel'] ) ? ' rel="' . $atts['rel'] . '"' : '';
		$atts['title'] = ( $atts['title'] ) ? ' title="' . $atts['title'] . '"' : '';
		$atts['id'] = ! empty( $atts['id'] ) ? sprintf( ' id="%s"', esc_attr( $atts['id'] ) ) : '';
		$atts['desc'] = $atts['desc'] ? '<small>'.$atts['desc'].'</small>' : '';

		ob_start();
			do_action('wps_before_button', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-button wps-button-<?php echo $atts['position']; ?> wps-style-<?php echo $atts['style'].' '. $is_wide ?>" id="wps-button">
				<a href="<?php echo esc_url( $atts['url'] ); ?>" class="<?php echo $atts['class']; ?>" style="<?php echo ! empty( $btn_css ) && is_array( $btn_css ) ? implode( ';', $btn_css ) : ''; ?>" target="_<?php echo $atts['target']; ?>"<?php echo $atts['rel'] . ' '. $atts['title'] . ' ' . $atts['id'] ?>>
					<span style="<?php echo implode( ';', $inner_css ); ?>">
						<?php echo self::get_wps_icon($atts['icon'], '') . do_shortcode($content). $atts['desc']; ?>
					</span>
				</a>
			</div>
		<?php
			do_action('wps_after_button', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function double_button( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'style'	=> 'standard',
			'left_btn_text'		=> '',
			'left_desc'			=> '',
			'left_url'			=> '',
			'left_btn_target'	=> 'self',
			'left_icon'			=> '',
			'left_background'	=> '',
			'left_color'		=> '',
			'separator_text'	=> '',
			'right_btn_text'	=> '',
			'right_desc'		=> '',
			'right_url'			=> '',
			'right_btn_target'	=> 'self',
			'right_icon'		=> '',
			'right_background'	=> '',
			'right_color'		=> '',
			'size'				=> '',
			'radius'			=> '',
			'class'				=> ''
		), $atts, 'double_button' );

		$box_style = 'style="font-size: '.$atts['size'].'px; border-radius: '.$atts['radius'].'px;"';
		$left_btn_style = 'style="background-color:'.$atts['left_background'].'; color:'.$atts['left_color'].'"';
		$right_btn_style = 'style="background-color:'.$atts['right_background'].'; color:'.$atts['right_color'].'"';
		$custom_class = '';
		if( $atts['left_desc'] || $atts['right_desc'] ) {
			$atts['left_desc'] = $atts['left_desc'] ? '<small>'.$atts['left_desc'].'</small>' : '';
			$atts['right_desc'] = $atts['right_desc'] ? '<small>'.$atts['right_desc'].'</small>' : '';
			$custom_class = 'wps-description-exists';
		}

		ob_start();
		do_action('wps_before_double_button', $atts);
		?>
			<div class="wps-double-btn <?php echo wps_specific_class( $atts ); ?> <?php echo $custom_class; ?>" <?php echo $box_style; ?> id="wps-double-btn">
				<a class="wps-btn wps-btn-left" href="<?php echo esc_url($atts['left_url']); ?>" target="_<?php echo esc_attr($atts['left_btn_target']); ?>" <?php echo $left_btn_style; ?>>
					<span class="wps-text-wrapper">
						<?php echo self::get_wps_icon($atts['left_icon']); ?> <?php echo esc_html($atts['left_btn_text']); ?>
						<?php echo $atts['left_desc']; ?>
					</span>
				</a>
				<?php if( $atts['separator_text'] ) {
					echo '<span>'.esc_html($atts['separator_text']).'</span>';
				} ?>
				<a class="wps-btn wps-btn-right" href="<?php echo esc_url($atts['right_url']); ?>" target="_<?php echo esc_attr($atts['right_btn_target']); ?>"  <?php echo $right_btn_style; ?>>
					<span class="wps-text-wrapper">
						<?php echo esc_html($atts['right_btn_text']); ?> <?php echo self::get_wps_icon($atts['right_icon']); ?>
						<?php echo $atts['right_desc']; ?>
					</span>
				</a>
			</div>
		<?php
			do_action('wps_after_double_button', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function service( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'			=> '',
				'icon'			=> '',
				'icon_color'	=> '#444',
				'size'			=> 20,
				'class'			=> ''
			), $atts, 'service' );
		$style = '';
		if($atts['icon']) {
			$padding_left = $atts['size'] + 15;
			if(is_rtl()) {
				$style = 'style="padding-right: '.$padding_left.'px"';
			} else {
				$style = 'style="padding-left: '.$padding_left.'px"';
			}
		}

		ob_start();
			do_action('wps_before_service', $atts);
		?>
				<div class="wps-shortcode-wrapper wps-service <?php echo wps_specific_class( $atts ); ?>" id="wps-service">
					<div class="wps-service-title" <?php echo $style; ?>>
						<span style="font-size:<?php echo round( $atts['size']) ?>px; color: <?php echo $atts['icon_color']; ?>"><?php echo self::get_wps_icon($atts['icon'], '') ?></span>
						<?php echo esc_html( $atts['title'] ); ?>
					</div>
					<div class="wps-service-content" style="padding-left:<?php echo $padding_left; ?>px">
						<?php echo do_shortcode( $content ); ?>
					</div>
				</div>
		<?php
			do_action('wps_after_service', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function box( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'			=> '',
				'style'			=> 'default',
				'box_color'		=> '#333333',
				'title_color'	=> '#FFFFFF',
				'color'			=> '',
				'radius'		=> '0',
				'class'			=> ''
			), $atts, 'box' );

		$radius = ( $atts['radius'] != '0' ) ? 'border-top-left-radius:' . $atts['radius'] . 'px;border-top-right-radius:' . $atts['radius'] . 'px;' : '';
		$title_radius = ( $atts['radius'] != '0' ) ? $atts['radius'] - 1 : '';
		$title_radius = ( $title_radius ) ? 'border-top-left-radius:' . $title_radius . 'px;border-top-right-radius:' . $title_radius . 'px;' : '';
		ob_start();
			do_action('wps_before_box', $atts);
			?>
			<div class="wps-shortcode-wrapper wps-box <?php echo wps_specific_class( $atts ); ?>" id="wps-box" style="border-color: <?php echo wps_hex_shift( $atts['box_color'], 'darker', 20 ) . ';' . $radius; ?>">
				<div class="wps-box-title" style="background-color:<?php echo $atts['box_color'].'; color: '.$atts['title_color'].'; '.$title_radius ?>">
					<?php echo $atts['title']; ?>
				</div>
				<div class="wps-box-content">
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
			<?php
			do_action('wps_after_box', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function calltoaction( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'				=> '',
				'border'			=> '',
				'title'				=> '',
				'align'				=> 'left',
				'background_image'	=> '',
				'background'		=> '#3498db',
				'color'				=> '#FFFFFF',
				'radius'			=> '',
				'button_text'		=> '',
				'url'				=> get_option( 'home' ),
				'button_background'	=> '#217EBB',
				'button_color'		=> '#9FCFEF',
				'button_radius'		=> '',
				'target'			=> 'self',
				'class'				=> ''
			), $atts, 'calltoaction' );


		$radius = $button_radius = '';
		if( $atts['radius'] ) {
			$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		}
		if( $atts['button_radius'] ) {
			$button_radius = ( $atts['button_radius'] != '0' ) ? 'border-radius:' . $atts['button_radius'] . 'px;-moz-border-radius:' . $atts['button_radius'] . 'px;-webkit-border-radius:' . $atts['button_radius'] . 'px;' : '';
		}
		$button_style = 'style="background-color:' . $atts['button_background'] . '; color:' . $atts['button_color'] . ';' . $button_radius . '"';

		$background_image = ( $atts['background_image'] != '' ) ? 'background-image:url(' . $atts['background_image'] .');': '';

		$box_style = 'style="border-color: '.$atts['button_background'].'; background-color:'.$atts['background'].';'.$radius.';'.$background_image.'"';
		ob_start();
			do_action('wps_before_calltoaction');
		?>
			<div class="wps-shortcode-wrapper wps-calltoaction wps-border-<?php echo esc_attr($atts['border']); ?> wps-<?php echo $atts['style']; ?> wps-align-<?php echo $atts['align'].' '. wps_specific_class( $atts ); ?>" id="wps-calltoaction" <?php echo $box_style; ?>>
				<div class="inner-wrapper">
					<div class="wps-inner-content" style="color:<?php echo $atts['color']; ?>">
						<h3 style="color:inherit;"><?php echo esc_html( $atts['title'] ); ?></h3>
						<?php echo do_shortcode( $content ); ?>
					</div>
					<?php if($atts['button_text']) { ?>
					<a href="<?php echo esc_url( $atts['url'] ); ?>" target="_<?php echo $atts['target']; ?>" <?php echo $button_style; ?>>
						<?php echo esc_html( $atts['button_text'] ); ?>
					</a>
					<?php } ?>
				</div>
			</div>
		<?php
			do_action('wps_after_calltoaction');
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function counter( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'align'			=> 'center',
				'width'	=> '300px',
				'height'		=> 'auto',
				'count_start'	=> 0,
				'count_end'		=> 9999,
				'prefix'		=> '',
				'suffix'		=> '',
				'count_color'	=> '#23395b',
				'text_color'	=> '#00001f',
				'background'	=> '',
				'border'	=> '',
				'radius'	=> '',
				'separator'		=> '',
				'decimal'		=> '',
				'duration'		=> 3,
				'size'			=> 'medium',
				'class'			=> ''
			), $atts, 'counter' );

		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		$radius = '';
		if( $atts['radius'] ) {
			$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		}
		$style = 'style="width: '.$atts['width'].'; height:'.$atts['height'].';background-color:'.$atts['background'].'; border:'.$atts['border'].';'.$radius.'"';
		// $style = "background-color:$atts['background']; border: $atts['border'];$radius";
		$countup_data = '<div class="wps-shortcode-wrapper wps-countup wps-align-'.$atts['align'].' '. wps_specific_class( $atts ) . '" id="wps-countup" '.$style.'>'
					. '<div class="wps-inner-content">'
						. '<div class="wps-countup-wrapper wps-size-'. $atts['size'] .'" id="'.uniqid('wps_').'" style="color: '. $atts['count_color'] .'" '. $attributes .'></div>'
						. '<div class="wps-countup-text" style="color: '. $atts['text_color'] .'">'
							. do_shortcode( $content )
						. '</div>'
					. '</div>'
				. '</div>';

		ob_start();
			do_action('wps_before_countup');
			echo $countup_data;
			do_action('wps_after_countup');
			wps_sortcode_script( 'js', 'wps-countup' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function countdown( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'			=> 'standard',
				'align'			=> 'left',
				'date'			=> '',
				'time'			=> '',
				'size'			=> 48,
				'suffix'		=> '',
				'border'	=> '',
				'count_color'	=> '#000',
				'background'	=> '#eee',
				'text_color'	=> '',
				'text_bg'	=> '',
				'padding'		=> 20,
				'class'			=> ''
			), $atts, 'counter' );

		if( empty($atts['date']) && empty( $atts['time'] ) ) return;

		$countdown_time  = strtotime($atts['date']. ' '. $atts['time']);
		$countdown_data = '';
		$content_class = '';
		$style = '';

		if( $countdown_time > time() ) {
			$content_class = 'wps-hidden';
			$counter_style = 'font-size:'.esc_attr($atts['size']).'px; color: '.esc_attr($atts['count_color']).';';

			$text_color = $atts['text_color'] ? $atts['text_color'] : wps_hex_shift( $atts['count_color'], 'lighter', 20 );

			$counter_text_style = 'color: '.$text_color.';';
			if($atts['text_bg']) {
				$counter_text_style .= ' background-color: '.$atts['text_bg'].';';
			}

			$counter_text_style = 'style="'. $counter_text_style .'"';
			$style = 'style="background-color: '. $atts['background'] .'; padding: '. esc_attr($atts['padding']) .'px;"';

			$inner_style = '';
			$border = $atts['border'] ? 'border:'.$atts['border'].';' : '';
			if($atts['style'] == 'classic') {
				$inner_style = 'style="background-color: '.$atts['background'].';'. $border .'"';
				$counter_style .= 'padding: '.$atts['padding'].'px';
				$style = '';
			}
			$counter_style = 'style="'.$counter_style.'"';
			$countdown_data = '<div class="wps-countdown-wrapper" id="'.uniqid('wps_').'" data-date="'.esc_attr($atts['date']).'" data-time="'.esc_attr($atts['time']).'" >'
								. '<span class="inner-wrapper" '.$inner_style.'>'
									. '<strong class="wps-day" '. $counter_style .'></strong>'
									. '<span '. $counter_text_style .'>'.__( 'Days', 'wp-shortcode-pro' ).'</span>'
								. '</span>'
								. '<span class="inner-wrapper" '.$inner_style.'>'
									. '<strong class="wps-hour" '. $counter_style .'></strong>'
									. '<span '. $counter_text_style .'>'.__( 'Hours', 'wp-shortcode-pro' ).'</span>'
								. '</span>'
								. '<span class="inner-wrapper" '.$inner_style.'>'
									. '<strong class="wps-min" '. $counter_style .'></strong>'
									. '<span '. $counter_text_style .'>'.__( 'Min', 'wp-shortcode-pro' ).'</span>'
								. '</span>'
								. '<span class="inner-wrapper" '.$inner_style.'>'
									. '<strong class="wps-sec" '. $counter_style .'></strong>'
									. '<span '. $counter_text_style .'>'.__( 'Sec', 'wp-shortcode-pro' ).'</span>'
								. '</span>'
							. '</div>';

			wps_sortcode_script( 'js', 'wps-countdown' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );

		}

		$countdown_data = '<div class="wps-shortcode-wrapper wps-countdown wps-style-'.esc_attr($atts['style']).' wps-align-'.$atts['align'].' '. wps_specific_class( $atts ) . '" '.$style.' >'
								. $countdown_data
								. '<div class="wps-countdown-text '. $content_class .'">'
									. do_shortcode( $content )
								. '</div>'
							. '</div>';
		ob_start();
			do_action('wps_before_countdown', $atts);
			echo $countdown_data;
			do_action('wps_after_countdown', $atts);
		return ob_get_clean();
	}

	public static function testimonial( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'			=> 'default',
				'name'			=> '',
				'designation'	=> '',
				'company'		=> '',
				'url'			=> '',
				'radius'		=> 0,
				'image'			=> '',
				'class'			=> ''
			), $atts, 'testimonial' );

		if( ! $content ) return;

		$radius = '';
		if( $atts['radius'] != null ) {
			$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		}
		$testimonial_style = $atts['style'];
		ob_start();
			do_action('wps_before_testimonial', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-testimonial wps-<?php echo $testimonial_style.' '.wps_specific_class( $atts ) ?>" id="wps-testimonial">
				<div class="wps-testimonial-text" style="<?php echo $radius; ?>">
					<p><?php echo do_shortcode( $content ); ?></p>
				</div>

				<div class="wps-testimonial-details">
					<?php if( $atts['image'] ) { ?>
						<div class="wps-testimonial-photo">
							<img src="<?php echo esc_url($atts['image']); ?>" />
						</div>
					<?php } ?>
					<div class="wps-testimonial-cite">
						<span class="wps-testimonial-name">
							<?php echo esc_html( $atts['name'] ); ?>
						</span>
						<span class="wps-testimonial-designation">
							<?php echo esc_html( $atts['designation'] ); ?>
						</span>
						<span class="wps-testimonial-company">
							<a href="<?php echo esc_url( $atts['url'] ); ?>" target="_blank">
								<?php echo esc_html( $atts['company'] ); ?>
							</a>
						</span>
					</div>
				</div>

			</div>

		<?php
			do_action('wps_after_testimonial', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wps-fontawesome' );
		return ob_get_clean();
	}

	public static function social_share( $atts = null ) {
		$atts = shortcode_atts( array(
				'services'	=> '',
				'class'			=> ''
			), $atts, 'social_share' );

		if( empty($atts['services']) ) return;

		ob_start();
		do_action('wps_before_social_share', $atts);
		$permalink = urlencode(get_permalink());
		$title = get_the_title();
		$social_share_data = array(
			'facebook' => array( 'name' => 'Facebook', 'url' => '//www.facebook.com/sharer/sharer.php?u={url}' ),
			'twitter' => array( 'name' => 'Twitter', 'url' => '//twitter.com/intent/tweet?url={url}&text={title}' ),
			'google-plus' => array( 'name' => 'Google Plus', 'url' => '//plus.google.com/share?url={url}' ),
			'linkedin' => array( 'name' => 'Linkedin', 'url' => '//www.linkedin.com/shareArticle?mini=true&url={url}&title={title}&source=url' ),
			'pinterest' => array( 'name' => 'Pinterest', 'url' => '//pinterest.com/pin/create/button/?url={url}' ),
			'tumblr' => array( 'name' => 'Tumbler', 'url' => '//www.tumblr.com/widgets/share/tool?canonicalUrl={url}&title={title}' ),
			'stumbleupon' => array( 'name' => 'StumbleUpon', 'url' => '//www.stumbleupon.com/submit?url={url}&title={title}' ),
			'telegram' => array( 'name' => 'Telegram', 'url' => '//telegram.me/share/url?url={url}' ),
		);
		$services = explode(',', $atts['services']);

		?>
			<div class="wps-shortcode-wrapper wps-social-share <?php echo wps_specific_class( $atts ); ?>" id="wps-social-share">
				<ul>
					<?php foreach( $services as $service ) {
						$url = str_replace('{url}', $permalink, $social_share_data[$service]['url']);
						$url = str_replace('{title}', $title, $url);
					?>
						<li class="wps-<?php echo esc_attr($service); ?>">
							<a href="<?php echo esc_url($url); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
								<i class="fa fa-<?php echo esc_attr($service); ?>"></i>
								<?php echo esc_html( $social_share_data[$service]['name'] ); ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php
			do_action('wps_after_social_share', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wps-fontawesome' );
		return ob_get_clean();
	}

	public static function progress_bar( $atts = null ) {
		$atts = shortcode_atts( array(
				'percent'		=> 0,
				'text'			=> '',
				'style'			=> 'default',
				'show_percent'	=> 'yes',
				'bar_color'		=> '',
				'text_color'	=> '',
				'text_position'	=> 'over',
				'fill_color'	=> '',
				'height'		=> 4,
				'radius'		=> 0,
				'delay'			=> 0,
				'duration'		=> 3,
				'class'			=> ''
			), $atts, 'progress_bar' );

		ob_start();
		do_action('wps_before_progress_bar', $atts);
		$id = uniqid( 'wps_progress_bar_' );
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}

		$box_style = '';
		if( $atts['style'] != 'pie' ) {
			$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
			$box_style = 'style="'. $radius .'; height: '. esc_attr($atts['height']).'px; background-color: '.esc_attr( $atts['fill_color'] ).'"';
		}
		?>

			<div class="wps-shortcode-wrapper wps-progress_bar <?php echo wps_specific_class( $atts ) ?>" id="wps-progress_bar"
				<?php echo $attributes; ?>
				<?php echo $box_style; ?>
			>
				<?php if($atts['style'] === 'pie') { ?>
					<div class='wps-progress-pie' id="<?php echo esc_attr($id); ?>"></div>
				<?php
					wps_sortcode_script( 'js', 'wps-progress-bar' );
				} else { ?>
					<div class="wps-inner-wrapper wps-style-<?php echo esc_attr( $atts['style'] ); ?> wps-position-<?php echo esc_attr( $atts['text_position'] ); ?>" id="<?php echo esc_attr($id); ?>" style="<?php echo $radius; ?> background-color: <?php echo $atts['bar_color']; ?>; color: <?php echo $atts['text_color'] ?>">
						<span class=""><?php echo esc_html( $atts['text'] ); ?></span>
						<?php if( $atts['show_percent'] == 'yes' ) { ?>
							<span class="wps-percent"><?php echo esc_html( $atts['percent'] ); ?>%</span>
						<?php } ?>
					</div>
				<?php } ?>
			</div>

		<?php
		do_action('wps_after_progress_bar', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function modal( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'effect'				=> 1,
				'button_text'		=> '',
				'close_button'	=> 'yes',
				'modal_title'		=> '',
				'title_color'		=> '#000',
				'background'		=> '#fff',
				'color'					=> '#000',
				'overlay_background'	=> 'rgba(0,0,0,0.5)',
				'shadow'				=> '',
				'border'				=> '',
				'radius'				=> '',
				'class'					=> '',
			), $atts, 'modal' );

		$content_style = "background-color: ".$atts['background']."; color:".$atts['color'].";";

		if( $atts['shadow'] ) {
			$content_style .= " box-shadow:".esc_attr($atts['shadow']).";";
		}
		if( $atts['border'] ) {
			$content_style .= " border:".esc_attr($atts['border']).";";
		}
		if( $atts['radius'] ) {
			$content_style .= 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;';
		}

		ob_start();
		do_action('wps_before_modal', $atts);
		$id = uniqid( 'wps_modal_' );
		?>
			<div class="wps-shortcode-wrapper wps-modal <?php echo wps_specific_class( $atts ) ?>" id="wps-modal">
				<div class="wps-modal-wrapper wps-effect-<?php echo esc_attr( $atts['effect'] ); ?>" id="<?php echo esc_attr($id); ?>">
					<div class="wps-modal-content" style="<?php echo $content_style; ?>">
						<?php if($atts['modal_title']) { ?>
							<h3 style="color: <?php echo esc_attr( $atts['title_color'] ); ?>; border-color: <?php echo esc_attr( $atts['title_color'] ); ?>">
								<?php echo esc_html($atts['modal_title']); ?>
							</h3>
						<?php } ?>
						<div class="wps-modal-content-wrapper">
							<?php echo $content; ?>
							<?php if($atts['close_button'] == 'yes') { ?>
								<a href="javascript:;" class="wps-close">&times;</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<a href="javascript:;" class="wps-trigger" data-modal="<?php echo esc_attr($id); ?>">
					<?php echo esc_html($atts['button_text']); ?>
				</a>
				<div class="wps-overlay" style="background-color: <?php echo esc_attr( $atts['overlay_background'] ); ?>"></div>
			</div>

		<?php
		do_action('wps_after_modal', $atts);
		wps_sortcode_script( 'css', 'wps-modal' );
		wps_sortcode_script( 'js', 'wps-modal' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function section( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'						=> 'full-boxed',
				'height'					=> 'auto',
				'background_color'			=> '',
				'background'				=> '',
				'background_size'			=> 'cover',
				'background_repeat'			=> 'no-repeat',
				'background_mode'			=> 'fixed',
				'align_content_vertical'	=> 'center',
				'align'						=> 'center',
				'content_width'				=> 'auto',
				'content_bg'				=> '',
				'content_color'				=> '',
				'padding'					=> '',
				'margin'					=> '',
				'class'						=> '',
			), $atts, 'section' );

		$section_style = 'height: '. $atts['height']. ';';

		if( $atts['background_color'] ) {
			$section_style .= "background-color: ".$atts['background_color'].";";
		}
		$video = '';
		if( $atts['background'] ) {
			$is_image = getimagesize($atts['background']);
			if( ! empty($is_image) ) {
				$section_style .= "background-image: url(".$atts['background']."); background-repeat: ". $atts['background_repeat'] . "; background-position: center; background-size: ".$atts['background_size'].";";
				if( $atts['background_mode'] == 'parallax' ) {
					$section_style .= "background-attachment: fixed;";
				}
			} else {
				$video = '<video autoplay="" loop="">
							<source src="'. $atts['background'] .'" type="video/mp4">
							<source src="'. $atts['background'] .'" type="video/ogv">
							<source src="'. $atts['background'] .'" type="video/webm">
						</video>';
			}

		}

		if( $atts['padding'] ) {
			$section_style .= "padding: ".$atts['padding']."px;";
		}

		if( $atts['margin'] ) {
			$section_style .= "margin-bottom: ".$atts['margin']."px;";
		}

		ob_start();
		do_action('wps_before_section');
		?>
			<div class="wps-shortcode-wrapper wps-section wps-size-<?php echo esc_attr( $atts['size'] ); ?> wps-background-<?php echo esc_attr($atts['background_mode']); ?> wps-vertical-<?php echo esc_attr($atts['align_content_vertical']); ?> wps-align-<?php echo esc_attr( $atts['align'] ); ?> <?php echo wps_specific_class( $atts ) ?>" id="wps-section" style="<?php echo $section_style; ?>">
				<?php echo $video; ?>
				<div class="wps-content-wrapper" style="background-color:<?php echo $atts['content_bg'] ?>; color: <?php echo $atts['content_color']; ?>; width: <?php echo esc_attr( $atts['content_width'] ); ?>;">
					<?php echo do_shortcode($content); ?>
				</div>
			</div>
		<?php
		do_action('wps_after_section');
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function icon( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'icon'			=> '',
				'background'	=> '#f5f5f5',
				'color'			=> '#444',
				'size'			=> '20',
				'padding'		=> '10',
				'radius'		=> '',
				'class'			=> '',
			), $atts, 'icon' );

		if( ! $atts['icon'] ) return;

		$section_style = "display: inline-block; background-color: ".$atts['background']."; padding: ".$atts['padding']."px; font-size: ".$atts['size']."px; color: ".$atts['color']."; min-width: 1em; min-height: 1em; text-align: center;";

		if( $atts['radius'] ) {
			$section_style .= 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;';
		}

		ob_start();
		do_action('wps_before_icon', $atts);
		?>
			<span class="wps-shortcode-wrapper wps-icon <?php echo wps_specific_class( $atts ); ?>" id="wps-icon" style="<?php echo $section_style; ?>">
				<?php echo self::get_wps_icon($atts['icon']); ?>
			</span>
		<?php
		do_action('wps_after_icon', $atts);
		return ob_get_clean();
	}

	public static function icon_list( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'icon'			=> '',
				'title'			=> '',
				'align'			=> '',
				'background'	=> '',
				'color'			=> '',
				'shadow'		=> '',
				'border'		=> '',
				'radius'		=> '',
				'url'			=> '',
				'size'			=> '',
				'animate'		=>	'',
				'class'			=> '',
			), $atts, 'icon_list' );

		if( ! $atts['icon'] ) return;

		$section_style = "background-color: ".$atts['background']."; font-size: ".$atts['size']."px; color: ".$atts['color'].";";

		if( $atts['radius'] ) {
			$section_style .= 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;';
		}
		if( $atts['background'] || trim($atts['border']) != '0px' ) {
			$section_style .= 'padding: 20px;';
		}
		if( $atts['shadow'] ) {
			$section_style .= " box-shadow:".esc_attr($atts['shadow']).";";
		}
		if( $atts['border'] != 'none' && $atts['border'] != '0px' ) {
			$section_style .= " border:".esc_attr($atts['border']).";";
		}

		ob_start();
		do_action('wps_before_icon_list', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-icon-list <?php echo wps_specific_class( $atts ); ?> wps-animation-<?php echo esc_attr($atts['animate']); ?> wps-icon-align-<?php echo esc_attr($atts['align']); ?>" id="wps-icon-list">
				<div class="wps-inner-wrapper">
					<div class="wps-icon-wrapper ">
						<div class="wps-list-icon"  style="<?php echo $section_style; ?>">
							<?php if($atts['url']) { ?>
								<a href="<?php echo esc_url($atts['url']); ?>">
									<?php echo self::get_wps_icon($atts['icon']); ?>
								</a>
							<?php } else {
								echo self::get_wps_icon($atts['icon']);
							} ?>
						</div>
					</div>
					<div class="wps-icon-description">
						<h3 class="wps-icon-title"><?php echo esc_html($atts['title']); ?></h3>
						<div class="wps-icon-description_text"><?php echo do_shortcode($content); ?></div>
					</div>
				</div>
			</div>
		<?php
		do_action('wps_after_icon_list', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function flyout( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'position'		=> 'center-left',
				'dimensions'	=> '250x250',
				'transitionin'	=> '',
				'transitionout'	=> '',
				'enable_close'	=> 'yes',
				'close_style'	=> 'circle',
				'background'	=> '',
				'color'			=> '',
				'shadow'		=> '',
				'border'		=> '',
				'url'			=> '',
				'target'		=> 'blank',
				'class'			=> '',
			), $atts, 'flyout' );

		$dimensions = explode('x', $atts['dimensions']);

		$section_style = "width: ". $dimensions[0] ."px; height:".$dimensions[1] ."px; background-color: ".$atts['background']."; color: ".$atts['color'].";";

		if( $atts['shadow'] ) {
			$section_style .= " box-shadow:".esc_attr($atts['shadow']).";";
		}
		if( $atts['border'] ) {
			$section_style .= " border:".esc_attr($atts['border']).";";
		}
		if( $atts['position'] == 'bottom-middle' || $atts['position'] == 'center-middle' || $atts['position'] == 'top-middle' ) {
			$section_style .= " left:calc( 50% - ".($dimensions[0]/2).'px'.");";
		}
		if( $atts['position'] == 'center-middle' || $atts['position'] == 'center-left' || $atts['position'] == 'center-right' ) {
			$section_style .= " top:calc( 50% - ".($dimensions[1]/2).'px'.");";
		}

		$close_button = '&times';
		if( $atts['close_style'] === 'box' ) {
			$close_button = __( 'Close', 'wp-shortcode-pro' );
		} else if( $atts['close_style'] === 'text' ) {
			$close_button = __( 'Close Window', 'wp-shortcode-pro' );
		} else if( $atts['close_style'] === 'circle-text' ) {
			$close_button = __( 'Close', 'wp-shortcode-pro' ).' <span>&times</span>';
		}

		ob_start();

		do_action('wps_before_flyout', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-flyout wps-align-<?php echo esc_attr($atts['position']) ." ".wps_specific_class( $atts ); ?>" id="wps-flyout" style="<?php echo $section_style; ?>" data-transitionin="<?php echo esc_attr($atts['transitionin']) ?>" data-transitionout="<?php echo esc_attr($atts['transitionout']) ?>">
				<?php if($atts['enable_close']) { ?>
					<a href="javascript:;" class="wps-close wps-close-<?php echo esc_attr( $atts['close_style'] ); ?>"><?php echo $close_button; ?></a>
				<?php } ?>
				<div class="wps-content-wrapper">
					<?php if($atts['url']) { ?>
						<a href="<?php echo esc_url($atts['url']); ?>" target="_<?php echo esc_attr($atts['target']); ?>">
							<?php echo $content; ?>
						</a>
					<?php } else {
						echo $content;
					} ?>
				</div>
			</div>
		<?php
		do_action('wps_after_flyout', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function responsive_utility( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'visible'	=> '',
				'hidden'	=> '',
				'class'		=> '',
			), $atts, 'responsive_utility' );

		ob_start();
		do_action('wps_before_responsive_utility', $atts);
		?>
			<span class="wps-shortcode-wrapper wps-responsive_utility wps-visible-<?php echo esc_attr( $atts['visible'] ); ?> wps-hidden-<?php echo esc_attr( $atts['hidden'] ).wps_specific_class( $atts ); ?>" id="wps-responsive_utility">
				<?php echo do_shortcode( $content ); ?>
			</span>
		<?php
		do_action('wps_after_responsive_utility', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function photo_panel( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'background'	=> '',
				'color'			=>	'',
				'photo'			=>	'',
				'radius'		=> '',
				'shadow'		=> '',
				'border'		=> '',
				'url'			=> '',
				'align'			=> 'left',
				'class'			=> ''
			), $atts, 'photo_panel' );

		if( !( $atts['photo'] ) ) return;

		$img_radius = $radius = '';

		$background = ( $atts['background'] != '' ) ? 'background:' . $atts['background'] .';' : '';
		$color = ( $atts['color'] != '' ) ? 'color:' . $atts['color'] .';': '';
		$border = ( $atts['border'] != '' ) ? 'border:' . $atts['border'] .';': '';

		$shadow = ( $atts['shadow'] != '' ) ? 'box-shadow:' . $atts['shadow'] . ';-moz-box-shadow:' . $atts['shadow'] . ';-webkit-box-shadow:' . $atts['shadow'] . ';' : '';
		$align = ( $atts['align'] != '' ) ? 'text-align:' . $atts['align'] .';': '';

		if($atts['radius']) {
			$radius = 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;';
			$img_radius = 'border-top-right-radius:' . $atts['radius'] . 'px;-moz-border-top-right-radius:' . $atts['radius'] . 'px;-webkit-border-top-right-radius:' . $atts['radius'] . 'px;border-top-left-radius:' . $atts['radius'] . 'px;-moz-border-top-left-radius:' . $atts['radius'] . 'px;-webkit-border-top-left-radius:' . $atts['radius'] . 'px;';
		}
		ob_start();
		do_action('wps_before_photo_panel', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-photo_panel <?php wps_specific_class( $atts ); ?>" id="wps-photo-panel" style="<?php echo $background .$color . $border . $radius . $shadow . $align; ?>">
			<?php if($atts['url']) { echo '<a href="'. esc_url($atts['url']) .'">'; } ?>
				<div class="wps-panel-image-wrapper">
					<img src="<?php echo esc_url($atts['photo']); ?>" style=<?php echo $img_radius; ?> />
				</div>
				<div class="wps-panel-content">
					<?php echo $content; ?>
				</div>
			<?php if($atts['url']) { echo '</a>'; } ?>
		</div>
		<?php
		do_action('wps_after_photo_panel', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function splash_screen( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'				=> '',
				'width'				=> '500px',
				'height'			=> '500px',
				'radius'			=> '',
				'shadow'			=> '',
				'border'			=> '',
				'background'		=> '',
				'background_image'	=> '',
				'color'				=> '',
				'overlay_bg'		=> '',
				'opacity'			=> '',
				'close'				=> '',
				'esc'				=> '',
				'onclick'			=> '',
				'delay'				=> '',
				'class'				=> ''
			), $atts, 'splash_screen' );

		$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		$background = ( $atts['background'] != '' ) ? 'background:' . $atts['background'] .';' : '';
		$color = ( $atts['color'] != '' ) ? 'color:' . $atts['color'] .';': '';
		$border = ( $atts['border'] != '' ) ? 'border:' . $atts['border'] .';': '';
		$shadow = ( $atts['shadow'] != '' ) ? 'box-shadow:' . $atts['shadow'] . ';-moz-box-shadow:' . $atts['shadow'] . ';-webkit-box-shadow:' . $atts['shadow'] . ';' : '';
		$background_image = ( $atts['background_image'] != '' ) ? 'background-image:url(' . $atts['background_image'] .');': '';

		$box_style = 'style="width: '.$atts['width'].'; height: '.$atts['height'].'; '.$radius.$background.$color.$border.$shadow.$background_image.'"';

		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_splash_screen', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-hidden wps-splash_screen <?php wps_specific_class( $atts ); ?>" id="wps-splash-screen" <?php echo $attributes; ?> <?php echo $box_style; ?>>
			<div class="wps-popup-wrapper">
				<h3><?php echo esc_html($atts['title']); ?></h3>
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
		<?php
		do_action('wps_after_splash_screen', $atts);
		wps_sortcode_script( 'css', 'wps-magnific-popup' );
		wps_sortcode_script( 'js', 'wps-magnific-popup' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function exit_popup( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'				=> '',
				'width'				=> '500px',
				'height'			=> '500px',
				'radius'			=> '',
				'shadow'			=> '',
				'border'			=> '',
				'background'		=> '',
				'background_image'	=> '',
				'color'				=> '',
				'overlay_bg'		=> '',
				'opacity'			=> '',
				'close'				=> '',
				'esc'				=> '',
				'onclick'			=> '',
				'delay'				=> '',
				'class'				=> ''
			), $atts, 'exit_popup' );

		$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		$background = ( $atts['background'] != '' ) ? 'background:' . $atts['background'] .';' : '';
		$color = ( $atts['color'] != '' ) ? 'color:' . $atts['color'] .';': '';
		$border = ( $atts['border'] != '' ) ? 'border:' . $atts['border'] .';': '';
		$shadow = ( $atts['shadow'] != '' ) ? 'box-shadow:' . $atts['shadow'] . ';-moz-box-shadow:' . $atts['shadow'] . ';-webkit-box-shadow:' . $atts['shadow'] . ';' : '';
		$background_image = ( $atts['background_image'] != '' ) ? 'background-image:url(' . $atts['background_image'] .');': '';

		$box_style = 'style="width: '.$atts['width'].'; height: '.$atts['height'].'; '.$radius.$background.$color.$border.$shadow.$background_image.'"';

		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_exit_popup', $atts);
		?>
		<div class="wps-shortcode-wrapper mfp-hide wps-exit_popup <?php wps_specific_class( $atts ); ?>" id="wps-exit-popup" <?php echo $attributes; ?> <?php echo $box_style; ?>>
			<div class="wps-popup-wrapper">
				<h3><?php echo esc_html($atts['title']); ?></h3>
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
		<?php
		do_action('wps_after_exit_popup', $atts);
		wps_sortcode_script( 'js', 'wps-exit-popup' );
		wps_sortcode_script( 'js', 'wps-magnific-popup' );
		wps_sortcode_script( 'css', 'wps-magnific-popup' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function exit_bar( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'				=> '',
				'background'	=> '',
				'color'				=> '',
				'close'				=> 'yes',
				'class'				=> ''
			), $atts, 'exit_bar' );

		$background = ( $atts['background'] != '' ) ? 'background:' . $atts['background'] .';' : '';
		$color = ( $atts['color'] != '' ) ? 'color:' . $atts['color'] .';': '';
		$box_style = 'style="'.$background.$color.'"';

		ob_start();
		do_action('wps_before_exit_bar', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-exit_bar <?php wps_specific_class( $atts ); ?>" id="wps-exit-bar" <?php echo $box_style; ?>>
			<div class="wps-popup-wrapper">
				<h3><?php echo esc_html($atts['title']); ?></h3>
				<?php echo do_shortcode($content); ?>
				<?php if($atts['close'] === 'yes') { ?>
					<a href="#" class="wps-close">&times;</a>
				<?php } ?>
			</div>
		</div>
		<?php
		do_action('wps_after_exit_bar', $atts);
		wps_sortcode_script( 'js', 'wps-exit-popup' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function compare_image( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'orientation'		=> 'horizontal',
				'before_label'	=> '',
				'after_label'		=> '',
				'before_image'	=> '',
				'after_image'		=> '',
				'class'					=> ''
			), $atts, 'compare_image' );

		if( empty($atts['before_image']) || empty( $atts['after_image'] ) ) return;
		ob_start();
		do_action('wps_before_compare_image', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-compare_image <?php wps_specific_class( $atts ); ?>" id="wps-compare-image" data-orientation="<?php echo esc_attr($atts['orientation']) ?>" data-before_label="<?php echo esc_attr($atts['before_label']) ?>" data-after_label="<?php echo esc_attr($atts['after_label']) ?>">
			<img src="<?php echo esc_url($atts['before_image']); ?>" />
			<img src="<?php echo esc_url($atts['after_image']); ?>" />
		</div>
		<?php
		do_action('wps_after_compare_image', $atts);
		wps_sortcode_script( 'js', 'wps-compare-image' );
		wps_sortcode_script( 'css', 'wps-compare-image' );
		return ob_get_clean();
	}

	public static function content_slider( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'	=> 'light',
				'animatein'	=>	'fadeIn',
				'animateout'	=> 'fadeOut',
				'autoplay'	=> true,
				'arrows'	=> true,
				'arrow_position'	=> 'center',
				'pagination'	=> true,
				'pagination_position'	=> 'top-left',
				'class'	=> ''
			), $atts, 'content_slider' );

		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}

		ob_start();
		do_action('wps_before_content_slider', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-content_slider <?php wps_specific_class( $atts ); ?> wps-style-<?php echo esc_attr($atts['style']); ?>" id="wps-content-slider">
			<div class="owl-carousel owl-theme wps-style-<?php echo esc_attr($atts['style']); ?> wps-arrow-<?php echo esc_attr($atts['arrow_position']); ?> wps-pagination-<?php echo esc_attr($atts['pagination_position']); ?> wps-<?php echo esc_attr($atts['style']); ?>" <?php echo $attributes; ?>>
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
		<?php
		do_action('wps_after_content_slider', $atts);
		wps_sortcode_script( 'css', 'wps-fontawesome' );
		wps_sortcode_script( 'js', 'wps-owl-carousel' );
		wps_sortcode_script( 'css', 'wps-owl-carousel' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function content_slide( $atts = null, $content = null ) {
		return '<div class="item">'.do_shortcode($content).'</div>';
	}

	public static function flip_box( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'animation'	=> 'basic',
				'align'	=> 'center',
				'class'	=> ''
			), $atts, 'flip_box' );

		ob_start();
		do_action('wps_before_flip_box', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-flip-box wps-<?php echo esc_attr($atts['animation']); ?> wps-align-<?php echo esc_attr($atts['align']); ?> <?php wps_specific_class( $atts ); ?>" id="wps-flip-box">
			<?php echo do_shortcode($content); ?>
		</div>
		<?php
		do_action('wps_after_flip_box', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function flip_front( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'ff_background'	=> '',
				'ff_color'	=> '',
				'ff_padding'	=> ''
			), $atts, 'flip_front' );

		ob_start();
		?>
		<div class="wps-flip-front wps-flipper" style="background-color: <?php echo $atts['ff_background'] ?>; color: <?php echo $atts['ff_color'] ?>; padding: <?php echo esc_attr($atts['ff_padding']) ?>;">
			<?php echo do_shortcode($content); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	public static function flip_back( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'fb_background'	=> '',
				'fb_color'	=> '',
				'fb_padding'	=> ''
			), $atts, 'flip_back' );

		ob_start();
		?>
		<div class="wps-flip-back wps-flipper" style="background-color: <?php echo $atts['fb_background'] ?>; color: <?php echo $atts['fb_color'] ?>; padding: <?php echo esc_attr($atts['fb_padding']) ?>;">
			<?php echo do_shortcode($content); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	public static function overlay( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'image'	=> '',
				'style'	=> 'style-1',
				'title'	=> '',
				'class'	=> ''
			), $atts, 'overlay' );

		ob_start();
		do_action('wps_before_overlay', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-overlay wps-<?php echo esc_attr($atts['style']); wps_specific_class( $atts ); ?>" id="wps-overlay">
				<img src="<?php echo esc_url($atts['image']); ?>" />
				<div class="wps-description">
					<h3><?php echo $atts['title']; ?></h3>
					<div class="wps-content-box"><?php echo do_shortcode($content); ?></div>
				</div>
				<a href="#" class="wps-overlay-link"></a>
			</div>
		<?php
		do_action('wps_after_overlay', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function shadow( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'	=> 'default',
				'class'	=> ''
			), $atts, 'shadow' );

		ob_start();
		do_action('wps_before_shadow', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-shadow <?php echo wps_specific_class( $atts ); ?>" id="wps-shadow">
				<div class="inner-wrapper wps-<?php echo esc_attr($atts['style']); ?>">
					<?php echo do_shortcode($content); ?>
				</div>
			</div>
		<?php
		do_action('wps_after_shadow', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function timeline( $atts = null ) {
		$atts = shortcode_atts( array(
				'style'			=> 'standard',
				'category'	=> 'all',
				'align'			=> 'left',
				'limit'			=> 10,
				'class'			=> ''
			), $atts, 'timeline' );

		$args = array(
			'posts_per_page'	=>	$atts['limit'],
			'fields'	=>	'ids'
		);

		if( $atts['category'] !== 'all' ) {
			$args['category'] = $atts['category'];
		}

		$timeline_posts = get_posts($args);

		if( empty($timeline_posts) ) return;

		ob_start();
		do_action('wps_before_timeline', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-timeline wps-style-<?php echo esc_attr($atts['style']); ?> wps-align-<?php echo esc_attr($atts['align']); ?> <?php echo wps_specific_class( $atts ); ?>" id="wps-timeline">

			<?php foreach( $timeline_posts as $timeline_post ) { ?>

					<div class="wps-inner-wrapper">
						<h2 class="wps-post-title">
							<a href="<?php echo esc_url(get_permalink( $timeline_post )); ?>">
								<?php echo get_the_title($timeline_post); ?>
							</a>
						</h2>
						<p class="wps-post-date"><?php echo get_the_date( '', $timeline_post ); ?></p>

						<?php if(has_post_thumbnail($timeline_post) && $atts['style'] !== 'classic') { ?>
							<div class="wps-post-thumbnail">
								<?php echo get_the_post_thumbnail($timeline_post); ?>
							</div>
						<?php }
						if(has_excerpt($timeline_post)) { ?>
							<div class="wps-post-excerpt">
							<?php echo get_the_excerpt($timeline_post); ?>
							</div>
						<?php }

						if($atts['style'] == 'classic') { ?>
							<a class="wps-timeline-more" href="<?php echo esc_url(get_the_permalink($timeline_post)); ?>"><?php _e('Read More', 'wp-shortcode-pro') ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php
		do_action('wps_after_timeline', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function faq( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'standard',
				'question'	=> '',
				'class'	=> ''
			), $atts, 'faq' );

		if( ! $atts['question'] ) return;
		ob_start();
		do_action('wps_before_faq', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-style-<?php echo esc_attr($atts['style']) ?> wps-faq <?php echo wps_specific_class( $atts ) ?>" id="wps-faq">
				<div class="wps-question-wrapper">
					<?php echo esc_html( $atts['question'] ); ?>
				</div>
				<div class="wps-answer-wrapper">
					<?php echo esc_html( $content ); ?>
				</div>
			</div>
		<?php
		do_action('wps_after_faq', $atts);
		wps_sortcode_script( 'css', 'wps-fontawesome' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function note( $atts = null, $content = null ) {

		if(isset($atts['note_color'])) $atts['background'] = $atts['note_color'];
		if(isset($atts['text_color'])) $atts['color'] = $atts['text_color'];

		$atts = shortcode_atts( array(
				'size'	=> '14',
				'background'	=> '#e8dd63',
				'color'	=> '#444',
				'radius'	=> '3',
				'class'	=> ''
			), $atts, 'note' );

		$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		ob_start();
		do_action('wps_before_note', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-note <?php echo wps_specific_class( $atts ); ?>" id="wps-note" style="font-size:<?php echo $atts['size'] . 'px;'. $radius ?>">
			<div class="wps-note-inner" style="background-color:<?php echo $atts['background'] .';border-color:' . wps_hex_shift( $atts['background'], 'lighter', 80 ) . ';color:' . $atts['color'] . ';border-color:' . wps_hex_shift( $atts['background'], 'darker', 10 ) . ';'. $radius ?>">
			<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
		<?php
		do_action('wps_after_note', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function expand( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'more_text'	=> __( 'Show more', 'wp-shortcode-pro' ),
				'less_text'	=> __( 'Show less', 'wp-shortcode-pro' ),
				'height'	=> '100',
				'hide_less'	=> 'no',
				'text_color'	=> '#333333',
				'link_color'	=> '#0088FF',
				'link_style'	=> 'default',
				'link_align'	=> 'left',
				'more_icon'		=> '',
				'less_icon'		=> '',
				'class'	=> ''
			), $atts, 'expand' );

		$more_icon = self::get_wps_icon($atts['more_icon'], '');
		$less_icon = self::get_wps_icon($atts['less_icon'], '');

		if ( $more_icon || $less_icon ) wps_sortcode_script( 'css', 'wps-fontawesome' );

		$expand_style = 'style="color:' . $atts['text_color'] . ';height:' . intval( $atts['height'] ) . 'px;overflow:hidden";';
		ob_start();
		do_action('wps_before_expand', $atts);
			?>
			<div class="wps-shortcode-wrapper wps-expand wps-expand-collapsed wps-expand-link-style-<?php echo $atts['link_style'].' '.wps_specific_class( $atts ); ?>" id="wps-expand" data-height="<?php echo intval( $atts['height'] ); ?>">
				<div class="wps-expand-content" <?php echo $expand_style; ?>>
					<?php echo do_shortcode( $content ); ?>
				</div>
				<div class="wps-expand-link wps-expand-link-more" style="text-align:<?php echo $atts['link_align']; ?>">
					<a href="javascript:;" style="color:<?php echo $atts['link_color']; ?>;border-color:<?php echo $atts['link_color']; ?>">
						<span style="border-color:<?php echo $atts['link_color']; ?>">
							<?php echo $atts['more_text']; ?>
						</span>
						<?php echo $more_icon; ?>
					</a>
				</div>
				<?php if( $atts['hide_less'] !== 'yes' ) { ?>
					<div class="wps-expand-link wps-expand-link-less" style="text-align:<?php echo $atts['link_align']; ?>">
						<a href="javascript:;" style="color:<?php echo $atts['link_color'].'; border-color: '. $atts['link_color']; ?>">
							<span style="border-color:<?php echo $atts['link_color']; ?>">
								<?php echo $atts['less_text']; ?>
							</span>
							<?php echo $less_icon; ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php
			do_action('wps_after_expand', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function lightbox( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'src'	=> false,
				'type'	=> 'iframe',
				'class'	=> ''
			), $atts, 'lightbox' );

		if ( !$atts['src'] ) return ;
		ob_start();
			do_action('wps_before_lightbox', $atts);
		?>
			<span class="wps-shortcode-wrapper wps-lightbox <?php echo wps_specific_class( $atts ); ?>" id="wps-lightbox" data-mfp-src="<?php echo esc_url( $atts['src'] ); ?>" data-mfp-type="<?php echo $atts['type']; ?>" style="cursor: pointer;">
				<?php echo do_shortcode( $content ); ?>
			</span>
		<?php
			do_action('wps_after_lightbox', $atts);
			wps_sortcode_script( 'css', 'wps-magnific-popup' );
			wps_sortcode_script( 'js', 'wps-magnific-popup' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function lightbox_content( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'id'	=> '',
				'width'	=> '50%',
				'margin'	=> '40',
				'padding'	=> '40',
				'text_align'	=> 'center',
				'background'	=> '#FFFFFF',
				'color'	=> '#333333',
				'shadow'	=> '0px 0px 15px #333333',
				'class'	=> ''
			), $atts, 'lightbox_content' );

		if ( !$atts['id'] ) return;
		$style = 'style="display:none;width:' . $atts['width'] . ';margin-top:' . $atts['margin'] . 'px;margin-bottom:' . $atts['margin'] . 'px;padding:' . $atts['padding'] . 'px;background-color:' . $atts['background'] . ';color:' . $atts['color'] . ';box-shadow:' . $atts['shadow'] . ';text-align:' . $atts['text_align'] . '"';
		ob_start();
			do_action('wps_before_lightbox_content', $atts);
		?>
			<div class="wps-lightbox-content <?php echo wps_specific_class( $atts ); ?>" id="<?php echo trim( $atts['id'], '#' ); ?>" <?php echo $style; ?>>
				<?php echo do_shortcode( $content ); ?>
			</div>
		<?php
			do_action('wps_after_lightbox_content', $atts);
		return ob_get_clean();
	}

	public static function tooltip( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'position'	=> 'top-center',
				'size'	=> 14,
				'title'	=> '',
				'content'	=> '',
				'behavior'	=> 'hover',
				'class'	=> ''
			), $atts, 'tooltip' );
		ob_start();
		do_action('wps_before_tooltip', $atts);

		switch($atts['position']) {
			case 'north':
				$atts['position'] = 'top-center';
			break;
			case 'north':
				$atts['position'] = 'top-center';
			break;
			case 'east':
				$atts['position'] = 'right';
			break;
			case 'west':
				$atts['position'] = 'left';
			break;
		}
		?>
		<span class="wps-shortcode-wrapper wps-tooltip <?php echo wps_specific_class( $atts ); ?>" id="wps-tooltip"  data-behavior="<?php echo $atts['behavior']; ?>" data-position="<?php echo $atts['position']; ?>" title="<?php echo $atts['content']; ?>" data-classes="<?php echo 'wps-tt-size-' . $atts['size']; ?>">
			<?php echo do_shortcode( $content ); ?>
		</span>
		<?php
		do_action('wps_after_tooltip', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-qtip' );
		wps_sortcode_script( 'js', 'wp-shortcode-qtip' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function private_note( $atts = null, $content = null ) {
		global $post;
		$atts = shortcode_atts(array(
			'class'	=> ''
		), $atts, 'private_note' );
		if( $post->post_author != get_current_user_id() && ! wp_doing_ajax() ) return;
		ob_start();
		do_action('wps_before_private_note', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-private-note <?php wps_specific_class( $atts ); ?>">
			<?php echo do_shortcode( $content ); ?>
		</div>
		<?php
		do_action('wps_after_private_note', $atts);
		return ob_get_clean();
	}

	public static function media( $atts = null, $content = null ) {
		// Video
		if ( strpos( $atts['url'], 'youtu' ) !== false )
			return self::youtube( $atts );
		elseif ( strpos( $atts['url'], 'vimeo' ) !== false )
			return self::vimeo( $atts );
		else
			return '<img src="' . $atts['url'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" style="max-width:100%" />';
	}

	public static function youtube( $atts = null, $content = null ) {

		$return = array();
		$atts = shortcode_atts( array(
				'url'	=> false,
				'width'	=> 600,
				'height'	=> 400,
				'autoplay'	=> 'no',
				'responsive'	=> 'yes',
				'class'	=> ''
			), $atts, 'youtube' );

		if ( !$atts['url'] ) return;

		$atts['url'] = esc_url( $atts['url'] );
		$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;

		if ( !$id )
			return wp_shortcode()->tools->error( __FUNCTION__, __( 'please specify correct url', 'wp-shortcode-pro' ) );

		$autoplay = ( $atts['autoplay'] === 'yes' ) ? '?autoplay=1' : '';
		$embed_url = "https://www.youtube.com/embed/$id$autoplay";
		ob_start();
			do_action('wps_before_youtube', $atts);
			?>
				<div class="wps-shortcode-wrapper wps-youtube wps-video wps-responsive-media-<?php echo $atts['responsive'].' '.wps_specific_class( $atts ) ?>">
					<iframe width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" src="<?php echo $embed_url; ?>" frameborder="0" allowfullscreen="true"></iframe>
				</div>
			<?php
			do_action('wps_after_youtube', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function youtube_advanced( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'				=> '',
				'playlist'			=> '',
				'width'				=> 600,
				'height'			=> 400,
				'responsive'		=> 'yes',
				'controls'			=> 'yes',
				'autohide'			=> 'alt',
				'showinfo'			=> 'yes',
				'autoplay'			=> 'no',
				'loop'				=> 'no',
				'rel'				=> 'yes',
				'fs'				=> 'yes',
				'modestbranding'	=> 'no',
				'https'				=> 'no',
				'wmode'				=> '',
				'class'				=> ''
			), $atts, 'youtube_advanced' );

		if ( !$atts['url'] ) return;

		$atts['url'] = esc_url( $atts['url'] );
		$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;

		if ( !$id )
			return wp_shortcode()->tools->error( __FUNCTION__, __( 'please specify correct url', 'wp-shortcode-pro' ) );

		$params = array();
		foreach ( array( 'autohide', 'autoplay', 'controls', 'fs', 'loop', 'modestbranding', 'playlist', 'rel', 'showinfo', 'wmode' ) as $param ) {
			$params[$param] = str_replace( array( 'no', 'yes', 'alt' ), array( '0', '1', '2' ), $atts[$param] );
		}
		if ( $params['loop'] === '1' && $params['playlist'] === '' ) {
			$params['playlist'] = $id;
		}
		$protocol = ( $atts['https'] === 'yes' ) ? 'https' : 'http';
		$params = http_build_query( $params );
		ob_start();
			do_action('wps_before_youtube_advanced', $atts);
			?>
				<div class="wps-shortcode-wrapper wps-youtube wps-video wps-responsive-media-<?php echo $atts['responsive'] .' '. wps_specific_class( $atts ) ?>">
					<iframe width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" src="<?php echo $protocol.'://www.youtube.com/embed/'.$id.'?'.$params; ?>"  frameborder="0" allowfullscreen="true"></iframe>
				</div>
			<?php
			do_action('wps_after_youtube_advanced', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function vimeo( $atts = null, $content = null ) {

		$return = array();
		$atts = shortcode_atts( array(
				'url'        => false,
				'width'      => 600,
				'height'     => 400,
				'autoplay'   => 'no',
				'responsive' => 'yes',
				'class'      => ''
			), $atts, 'vimeo' );

		if ( !$atts['url'] ) return;

		$atts['url'] = esc_url( $atts['url'] );
		$id = ( preg_match( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $atts['url'], $match ) ) ? $match[1] : false;

		if ( !$id )
			return wp_shortcode()->tools->error( __FUNCTION__, __( 'please specify correct url', 'wp-shortcode-pro' ) );

		$autoplay = ( $atts['autoplay'] === 'yes' ) ? '&amp;autoplay=1' : '';
		ob_start();
		do_action('wps_before_vimeo', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-vimeo  wps-video wps-responsive-media-<?php echo $atts['responsive'].' '. wps_specific_class( $atts ) ?>">
			<iframe width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" src="//player.vimeo.com/video/<?php echo $id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff<?php echo $autoplay; ?>" frameborder="0" allowfullscreen="true"></iframe>
		</div>
		<?php
		do_action('wps_after_vimeo', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function audio( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'		=> '',
				'width'		=> 'auto',
				'autoplay'	=> 'no',
				'loop'		=> 'no',
				'class'		=> ''
			), $atts, 'audio' );

		if ( !$atts['url'] ) return;

		$width = ( $atts['width'] !== 'auto' ) ? 'max-width:' . $atts['width'] : '';
		$atts['loop'] = ($atts['loop'] == 'yes') ? 'loop' : '';
		$atts['autoplay'] = ($atts['autoplay'] == 'yes') ? 'autoplay' : '';
		ob_start();
		do_action('wps_before_audio', $atts);
		?>
		<div class="wps-shortcode-wrapper wps-audio <?php echo wps_specific_class( $atts ); ?>" id="wps-audio" style="<?php echo $width; ?>">
			<audio controls <?php echo $atts['loop'].' '. $atts['autoplay']; ?>>
				<source src="<?php echo esc_url($atts['url']); ?>" type="audio/ogg">
				<source src="<?php echo esc_url($atts['url']); ?>" type="audio/mpeg">
				<?php _e('Your browser does not support the audio tag.', 'wp-shortcode-pro'); ?>
			</audio>
		</div>
		<?php
		do_action('wps_after_audio', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function video( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'		=> '',
				'image'		=> '',
				'title'		=> '',
				'width'		=> 600,
				'height'	=> 300,
				'controls'	=> 'yes',
				'autoplay'	=> '',
				'loop'		=> '',
				'class'		=> ''
			), $atts, 'video' );

		if ( !$atts['url'] ) return;

		$atts['loop'] = ($atts['loop'] == 'yes') ? 'loop' : '';
		$atts['autoplay'] = ($atts['autoplay'] == 'yes') ? 'autoplay' : '';
		$atts['controls'] = ($atts['controls'] == 'yes') ? 'controls' : '';

		$style = 'style="width:' . $atts['width'] . '; height:' . $atts['height'] . ';"';
		ob_start();
			do_action('wps_before_video', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-video" id="wps-video" <?php echo $style; ?>>
				<?php if( $atts['autoplay'] == '' ) { ?>
					<a href="#" class="wps-play-icon"><i class="fa fa-play"></i></a>
					<div class="wps-video-inner">
						<?php if($atts['image'] ) { ?>
							<div class="wps-video-image">
								<img src="<?php echo esc_url($atts['image']); ?>" />
							</div>
						<?php } ?>
					</div>
				<?php } if($atts['title']) { ?>
					<div class="wps-video-title"><?php echo esc_html($atts['title']); ?></div>
				<?php } ?>
				<video <?php echo $atts['controls'].' '. $atts['autoplay'] . ' ' . $atts['loop']; ?>>
					<source src="<?php echo esc_url($atts['url']); ?>" type="video/mp4">
					<source src="<?php echo esc_url($atts['url']); ?>" type="video/ogg">
					<?php _e('Your browser does not support the video tag.', 'wp-shortcode-pro'); ?>
				</video>
			</div>
		<?php
			do_action('wps_after_video', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			wps_sortcode_script( 'css', 'wps-fontawesome' );
		return ob_get_clean();
	}

	public static function table( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'class' => '',
				'style' => 'default'
			), $atts, 'table' );
		ob_start();
			do_action('wps_before_table', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-table wps-style-<?php echo esc_attr($atts['style']); ?> <?php echo wps_specific_class( $atts ); ?>" id="wps-table">
				<?php echo do_shortcode( $content ); ?>
			</div>
		<?php
			do_action('wps_after_table', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function permalink( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'id' => 1,
				'target' => 'self',
				'class' => ''
			), $atts, 'permalink' );
		$text = $content ? $content : get_the_title( $atts['id'] );
		ob_start();
			do_action('wps_before_permalink');
		?>
			<a href="<?php echo get_permalink( $atts['id'] ); ?>" class="<?php echo wps_specific_class( $atts ); ?>" title="<?php echo esc_html($text); ?>" target="_<?php echo $atts['target']; ?>">
				<?php echo $text; ?>
			</a>
		<?php
			do_action('wps_after_permalink');
		return ob_get_clean();
	}

	public static function members( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'message'    => __( 'This content is for registered users only. Please %login%.', 'wp-shortcode-pro' ),
				'color'      => '#444',
				'login_text' => __( 'Login', 'wp-shortcode-pro' ),
				'login_url'  => wp_login_url(),
				'class'      => ''
			), $atts, 'members' );

		$login = '<a href="' . esc_attr( $atts['login_url'] ) . '">' . $atts['login_text'] . '</a>';
		ob_start();
		do_action('wps_before_members');
		if ( !is_user_logged_in() ) {
		?>
			<div class="wps-shortcode-wrapper wps-members <?php echo wps_specific_class( $atts ); ?>" id="wps-members" style="color:<?php echo $atts['color']; ?>">
				<?php echo str_replace( '%login%', $login, $atts['message'] ); ?>
			</div>
		<?php
		} else {
			echo do_shortcode($content)	;
		}
		do_action('wps_after_members');
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function guests( $atts = null, $content = null ) {

		$atts = shortcode_atts(array(
			'class' => ''
		), $atts, 'guests' );
		$return = '';
		if( is_user_logged_in() || is_null( $content ) ) return;
		ob_start();
		do_action('wps_before_guests', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-guests <?php echo wps_specific_class( $atts ); ?>" id="wps-guests">
				<?php echo do_shortcode( $content ); ?>
			</div>
		<?php
		do_action('wps_after_guests', $atts);
		return ob_get_clean();
	}

	public static function feed( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'url'   => get_bloginfo_rss( 'rss2_url' ),
				'limit' => 3,
				'class' => ''
			), $atts, 'feed' );

		if( !$atts['url'] )return;

		if ( !function_exists( 'wp_rss' ) )
			include_once ABSPATH . WPINC . '/rss.php';

		ob_start();
			do_action('wps_before_feed', $atts);
			?>
			<div class="wps-shortcode-wrapper wps-feed <?php echo wps_specific_class( $atts ); ?>">
				<?php echo wp_rss( $atts['url'], $atts['limit'] ); ?>
			</div>
			<?php
			do_action('wps_before_feed', $atts);
		return ob_get_clean();
	}

	public static function wps_subpages( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'depth' => 1,
				'parent'	=> '',
				'class' => ''
			), $atts, 'subpages' );

		$child_of = $atts['parent'] ? $atts['parent'] : get_the_ID();
		$pages = wp_list_pages( array(
				'title_li' => '',
				'echo' => 0,
				'child_of' => $child_of,
				'depth' => $atts['depth']
			) );
		;
		if(!$pages) return;
		ob_start();
		do_action('wps_before_subpages', $atts);
		?>
		<ul class="wps-subpages <?php echo wps_specific_class( $atts ); ?>">
			<?php echo $pages; ?>
		</ul>
		<?php
		do_action('wps_after_subpages', $atts);
		return ob_get_clean();
	}

	public static function siblings( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
			'depth' => 1,
			'class' => ''
		), $atts, 'siblings' );

		global $post;
		$siblings = wp_list_pages( array(
				'title_li' => '',
				'echo' => 0,
				'child_of' => $post->post_parent,
				'depth' => $atts['depth'],
				'exclude' => $post->ID )
				);
		if(!$siblings) return;
		ob_start();
			do_action('wps_before_siblings', $atts);
		?>
			<ul class="wps-siblings <?php echo wps_specific_class( $atts ); ?>">
				<?php echo $siblings; ?>
			</ul>
		<?php
			do_action('wps_after_siblings', $atts);
		return ob_get_clean();
	}

	public static function menu( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'name' => false,
				'class' => ''
			), $atts, 'menu' );

		$return = wp_nav_menu( array(
				'echo'				=> false,
				'theme_location'	=> $atts['name'],
				'container'			=> false,
				'fallback_cb'		=> array( __CLASS__, 'menu_fb' ),
				'items_wrap'		=> '<ul id="%1$s" class="%2$s' . wps_specific_class( $atts ) . '">%3$s</ul>'
			) );
		return ( $atts['name'] ) ? $return : false;
	}

	public static function menu_fb() {
		return __( "This menu doesn't exists, or has no elements", 'wp-shortcode-pro' );
	}

	public static function document( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'url'			=> '',
				'width'			=> 600,
				'height'		=> 400,
				'responsive'	=> 'yes',
				'class'      => ''
			), $atts, 'document' );

		if(!$atts['url']) return;
		ob_start();
			do_action('wps_before_document', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-document wps-responsive-media-<?php echo $atts['responsive'].' '.wps_specific_class( $atts ); ?>" id="wps-document">
				<iframe src="//docs.google.com/viewer?embedded=true&url=<?php echo $atts['url']; ?>" width="<?php echo esc_attr($atts['width']); ?>" height="<?php echo esc_attr($atts['height']); ?>" class="wps-document"></iframe>
			</div>
		<?php
			do_action('wps_after_document', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function advanced_google_map( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'style'			=> 'default',
				'width'			=> 600,
				'height'		=> 400,
				'zoom'			=> 12,
				'fit'			=> 'yes',
				'center'		=> '',
				'addresses'		=> '',
				'marker_image'	=> '',
				'search'		=> 'yes',
				'search_zoom'	=> 12,
				'class'			=> ''
			), $atts, 'advanced_google_map' );

		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_advanced_google_map', $atts);

		if(!wps_gm_key()) {
			return sprintf(__('%s MissingKeyMapError %s: Please add google map API key in Plugin Settings.', 'wp-shortcode-pro'), '<b>', '</b>');
		}
		?>
		<div class="wps-shortcode-wrapper wps-advanced_map <?php echo wps_specific_class( $atts ); ?>" id="" <?php echo $attributes; ?> style="width: 900px; height: 600px;">
			<div class="search-panel form-group">
				<input class="form-control search-input" id="wps-map-address" type="text" value="" placeholder="<?php _e('City, Street, Landmark...', 'listings-wp-maps'); ?>" />
				<input class="form-control button btn"  id="wps-map-submit" type="submit" value="" />
			</div>

			<ul class="map-controls list-unstyled">
				<li><a href="#" class="control zoom-in" id="wps-zoom-in">&#x254B;</a></li>
				<li><a href="#" class="control zoom-out" id="wps-zoom-out">&#9472;</a></li>
				<li><a href="#" class="control map-type" id="wps-map-type" onclick="return false;">
						&#x26F6;
						<ul class="list-unstyled">
							<li id="wps-map-type-roadmap" class="map-type"><?php _e('Roadmap', 'wp-real-estate'); ?></li>
							<li id="wps-map-type-satellite" class="map-type"><?php _e('Satellite', 'wp-real-estate'); ?></li>
							<li id="wps-map-type-hybrid" class="map-type"><?php _e('Hybrid', 'wp-real-estate'); ?></li>
							<li id="wps-map-type-terrain" class="map-type"><?php _e('Terrain', 'wp-real-estate'); ?></li>
						</ul>
					</a></li>
				<li><a href="#" id="wps-current-location" class="control"><?php _e('My Location', 'wp-real-estate'); ?></a></li>
			</ul>
			<div id="<?php echo uniqid('wps_'); ?>" class="wps-google-map">
				<div class="wps-loader-container">
					<div class="svg-loader"></div>
				</div>
			</div>
		</div>
		<?php
		do_action('wps_after_advanced_google_map', $atts);
		wps_sortcode_script( 'js', 'wps-gm-lib' );
		wps_sortcode_script( 'js', 'wps-geocomplete' );
		wps_sortcode_script( 'js', 'wps-google-map' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function google_map( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'width'      => 600,
				'height'     => 400,
				'address'    => '',
				'class'      => ''
			), $atts, 'google_map' );

		if(! $atts['address']) return;
		ob_start();
		do_action('wps_before_google_map', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-gmap <?php echo wps_specific_class( $atts ); ?>" id="wps-gmap" style="max-width:100%;">
				<iframe width="<?php echo esc_attr($atts['width']); ?>" height="<?php echo esc_attr($atts['height']); ?>" src="//maps.google.com/maps?q=<?php echo urlencode( $atts['address'] ); ?>&amp;output=embed"></iframe>
			</div>
		<?php
		do_action('wps_after_google_map', $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function slider( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'source'		=> 'none',
				'limit'			=> 20,
				'link'			=> 'none',
				'target'		=> 'self',
				'width'			=> 600,
				'height'		=> 300,
				'title'			=> 'yes',
				'arrows'		=> 'yes',
				'pager'			=> 'yes',
				'gallery'		=>	true,
				'autoplay'		=> 3000,
				'speed'			=> 600,
				'class'			=> ''
			), $atts, 'slider' );
		ob_start();
		do_action('wps_before_slider', $atts);

		$slides = (array) wp_shortcode()->tools->get_slides( $atts );

		if ( count( $slides ) ) {

			$slider_settings = array(
				'arrows'	=> boolval($atts['arrows']),
				'pager'		=> boolval($atts['pager']),
				'gallery'	=> boolval($atts['gallery']),
				'autoplay'	=> $atts['autoplay'],
				'speed'		=> $atts['speed'],
			);
			$classes = 'wps-slider wps-slider-pages-' . $atts['pager'] . wps_specific_class( $atts );
			if ( $atts['link'] === 'lightbox' ) {
				$classes .= ' wps-show-lightbox';
			}
			?>
				<ul class="<?php echo $classes; ?>" data-slider-settings="<?php echo htmlspecialchars(json_encode($slider_settings), ENT_QUOTES, 'UTF-8'); ?>">
					<?php
					foreach ( $slides as $slide ) {

						$image = wps_resize_image( $slide['image'], $atts['width'], $atts['height'] );
						if(!is_wp_error($image)) {
						$image_url = esc_url($image['url']);
						$title = ($atts['title'] == 'yes' && isset($slide['title'])) ? '<h3 class="wps-slide-title">'.$slide['title'].'</h3>' : '';
					?>
						<li class="wps-slider-slide" data-thumb="<?php echo $image_url; ?>" data-src="<?php echo $image_url; ?>">
							<?php if ( $slide['link'] ) { ?>
								<a href="<?php echo esc_url($slide['link']); ?>" target="_<?php echo esc_attr($atts['target']); ?>" title="<?php echo esc_attr( $slide['title'] ); ?>">
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>" />
									<?php echo $title; ?>
								</a>
							<?php } else { ?>
								<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($slide['title']); ?>" />
								<?php echo $title; ?>
							<?php } ?>
						</li>
					<?php
					}
					}
					?>
				</ul>
			<?php
			wps_sortcode_script( 'css', 'wps-fontawesome' );
			wps_sortcode_script( 'css', 'wps-lightslider' );
			wps_sortcode_script( 'js', 'wps-lightslider' );
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );

		} else {
			echo wp_shortcode()->tools->error( __FUNCTION__, __( 'images not found', 'wp-shortcode-pro' ) );
		}

		do_action('wps_after_slider', $atts);
		return ob_get_clean();
	}

	public static function custom_gallery( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'source'	=> 'none',
				'limit'		=> 10,
				'link'		=> 'none',
				'target'	=> 'self',
				'width'		=> 150,
				'height'	=> 150,
				'title'		=> 'hover',
				'class'		=> ''
			), $atts, 'custom_gallery' );
		$return = '';
		ob_start();
		do_action('wps_before_custom_gallery', $atts);
		$slides = (array) wp_shortcode()->tools->get_slides( $atts );

		if ( count( $slides ) ) {

			$atts['target'] = ( $atts['target'] === 'blank' ) ? ' target="_blank"' : '';
			if ( $atts['link'] === 'lightbox' )
				$atts['class'] .= ' wps-lightbox-gallery';

			$return = '<div class="wps-shortcode-wrapper wps-gallery wps-custom-gallery-title-' . $atts['title'] . wps_specific_class( $atts ) . '" id="wps-gallery">';

				foreach ( $slides as $slide ) {

					$image = wps_resize_image( $slide['image'], $atts['width'], $atts['height'] );

					$title = ( $slide['title'] ) ? '<span class="wps-custom-gallery-title">' . stripslashes( $slide['title'] ) . '</span>' : '';

					$return .= '<div class="wps-custom-gallery-inner" data-src="'.esc_url($slide['image']).'">';

						if ( $slide['link'] )
							$return .= '<a href="' . $slide['link'] . '"' . $atts['target'] . ' title="' . esc_attr( $slide['title'] ) . '"><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" />' . $title . '</a>';
						else
							$return .= '<a><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" />' . $title . '</a>';

					$return .= '</div>';
				}

			$return .= '</div>';

			if ( $atts['link'] === 'lightbox' ) {
				wps_sortcode_script( 'css', 'wps-fontawesome' );
				wps_sortcode_script( 'css', 'wps-lightslider' );
				wps_sortcode_script( 'js', 'wps-lightslider' );
				wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			}

			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		} else {
			$return = wp_shortcode()->tools->error( __FUNCTION__, __( 'images not found', 'wp-shortcode-pro' ) );
		}
		do_action('wps_after_custom_gallery', $atts);
		return $return;
	}

	public static function dummy_text( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
			'amount'	=> 1,
			'what'		=> 'paras',
			'class'		=> ''
		), $atts, 'dummy_text' );
		ob_start();
			do_action('wps_before_dummy_text', $atts);
			$xml = simplexml_load_file( 'http://www.lipsum.com/feed/xml?amount=' . $atts['amount'] . '&what=' . $atts['what'] . '&start=0' );
			echo '<div class="wps-shortcode-wrapper wps-dummy-text' . wps_specific_class( $atts ) . '">' . wpautop( str_replace( "\n", "\n\n", $xml->lipsum ) ) . '</div>';
			do_action('wps_after_dummy_text', $atts);
		return ob_get_clean();
	}

	public static function dummy_image( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'width'		=> 500,
				'height'	=> 300,
				'theme'		=> 'any',
				'class'		=> ''
			), $atts, 'dummy_image' );

		$url = 'https://placeimg.com/' . $atts['width'] . '/' . $atts['height'] . '/';
		if ( $atts['theme'] !== 'any' )
			$url .= $atts['theme'] . "/" . rand( 0, 10 ) . "/";
		ob_start();
			do_action('wps_before_dummy_image');
				echo '<img src="' . $url . '" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" class="wps-dummy-image' . wps_specific_class( $atts ) . '" />';
			do_action('wps_after_dummy_image');
		return ob_get_clean();
	}

	public static function animate( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'type'		=> 'bounceIn',
				'duration'	=> 1,
				'delay'		=> 0,
				'inline'	=> 'no',
				'class'		=> ''
			), $atts, 'animate' );

		$tag = ( $atts['inline'] === 'yes' ) ? 'span' : 'div';
		$time = '-webkit-animation-duration:' . $atts['duration'] . 's;-webkit-animation-delay:' . $atts['delay'] . 's;animation-duration:' . $atts['duration'] . 's;animation-delay:' . $atts['delay'] . 's;';
		ob_start();
			do_action('wps_before_animate', $atts);
				echo '<' . $tag . ' class="wps-animation' . wps_specific_class( $atts ) . '" style="visibility:hidden;' . $time . '" data-animation="' . $atts['type'] . '" data-duration="' . $atts['duration'] . '" data-delay="' . $atts['delay'] . '">' . do_shortcode( $content ) . '</' . $tag . '>';
			do_action('wps_after_animate', $atts);
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function meta( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'key'		=> '',
				'default'	=> '',
				'before'	=> '',
				'after'		=> '',
				'post_id'	=> '',
				'filter'	=> ''
			), $atts, 'meta' );

		$blogusers = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );

		if ( !$atts['post_id'] )
			$atts['post_id'] = get_the_ID();

		if ( !is_numeric( $atts['post_id'] ) || $atts['post_id'] < 1 )
			return sprintf( '<p class="wps-error">Meta: %s</p>', __( 'post ID is incorrect', 'wp-shortcode-pro' ) );

		if ( !$atts['key'] )
			return sprintf( '<p class="wps-error">Meta: %s</p>', __( 'please specify meta key name', 'wp-shortcode-pro' ) );

		$meta = get_post_meta( $atts['post_id'], $atts['key'], true );

		if ( !$meta ) $meta = $atts['default'];

		if ( $atts['filter'] && function_exists( $atts['filter'] ) ) {
			$meta = call_user_func( $atts['filter'], $meta );
		}
		return ( $meta ) ? $atts['before'] . $meta . $atts['after'] : '';
	}

	public static function user( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'field'		=> 'display_name',
				'default'	=> '',
				'before'	=> '',
				'after'		=> '',
				'user_id'	=> '',
				'filter'	=> ''
			), $atts, 'user' );

		if ( $atts['field'] === 'user_pass' )
			return sprintf( '<p class="wps-error">User: %s</p>', __( 'password field is not allowed', 'wp-shortcode-pro' ) );

		if ( !$atts['user_id'] )
			$atts['user_id'] = get_current_user_id();

		if ( !is_numeric( $atts['user_id'] ) || $atts['user_id'] < 0 )
			return sprintf( '<p class="wps-error">User: %s</p>', __( 'user ID is incorrect', 'wp-shortcode-pro' ) );

		$user = get_user_by( 'id', $atts['user_id'] );
		$user = ( $user && isset( $user->data->{$atts['field']} ) ) ? $user->data->{$atts['field']} : $atts['default'];

		if ( $atts['filter'] && function_exists( $atts['filter'] ) ) {
			$user = call_user_func( $atts['filter'], $user );
		}

		return ( $user ) ? $atts['before'] . $user . $atts['after'] : '';
	}

	public static function post( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'field'		=> 'post_title',
				'default'	=> '',
				'before'	=> '',
				'after'		=> '',
				'post_id'	=> '',
				'filter'	=> ''
			), $atts, 'post' );

		if ( !$atts['post_id'] )
			$atts['post_id'] = get_the_ID();

		if ( !is_numeric( $atts['post_id'] ) || $atts['post_id'] < 1 )
			return sprintf( '<p class="wps-error">Post: %s</p>', __( 'post ID is incorrect', 'wp-shortcode-pro' ) );

		$post = get_post( $atts['post_id'] );

		$post = ( empty( $post ) || empty( $post->{$atts['field']} ) ) ? $atts['default'] : $post->{$atts['field']};

		if ( $atts['filter'] && function_exists( $atts['filter'] ) ) {
			$post = call_user_func( $atts['filter'], $post );
		}

		return ( $post ) ? $atts['before'] . $post . $atts['after'] : '';
	}

	public static function qrcode( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'data'			=> '',
				'title'			=> '',
				'size'			=> 250,
				'margin'		=> 20,
				'align'			=> 'none',
				'link'			=> '',
				'target'		=> 'blank',
				'color'			=> '#444',
				'background'	=> '#fff',
				'class'			=> ''
			), $atts, 'qrcode' );

		if ( !$atts['data'] )
			return __( 'Please specify the data', 'wp-shortcode-pro' );

		$atts['title'] = esc_attr( $atts['title'] );
		$url = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode( $atts['data'] ) . '&size=' . $atts['size'] . 'x' . $atts['size'] . '&format=png&margin=' . $atts['margin'] . '&color=' . wps_hex2rgb( $atts['color'] ) . '&bgcolor=' . wps_hex2rgb( $atts['background'] );
		ob_start();
		do_action('wps_before_qrcode', $atts);
		?>
		<span class="wps-shortcode-wrapper wps-qrcode wps-qrcode-align-<?php echo $atts['align'].' '.wps_specific_class( $atts ); ?>">
			<a href="<?php echo esc_url($atts['link']); ?>" target="_<?php echo esc_attr($atts['target']); ?>" title="<?php echo esc_attr($atts['title']) ?>">
				<img src="<?php echo $url; ?>" alt="<?php echo esc_attr($atts['title']); ?>" />
			</a>
		</span>
		<?php
		do_action('wps_after_qrcode', $atts);
		return ob_get_clean();
	}

	public static function scheduler( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'time'		=> 'all',
				'week'		=> 'all',
				'month'		=> 'all',
				'months'	=> 'all',
				'years'		=> 'all',
				'alt'		=> '',
				'days_week' => false,
				'days_month' => false,
			), $atts, 'scheduler' );

		$atts['week'] = $atts['days_week'] ? $atts['days_week'] : $atts['week'];
		$atts['month'] = $atts['days_month'] ? $atts['days_month'] : $atts['month'];

		if ( $atts['time'] !== 'all' ) {

			$now = current_time( 'timestamp', 0 );

			$atts['time'] = preg_replace( "/[^0-9-,:]/", '', $atts['time'] );

			foreach( explode( ',', $atts['time'] ) as $range ) {

				if ( strpos( $range, '-' ) === false )
					return wp_shortcode()->tools->error( __FUNCTION__, sprintf( __( 'Incorrect time range (%s). Please use - (minus) symbol to specify time range. Example: 14:00 - 18:00', 'wp-shortcode-pro' ), $range ) );

				$time = explode( '-', $range );

				if ( strpos( $time[0], ':' ) === false )
					$time[0] .= ':00';
				if ( strpos( $time[1], ':' ) === false )
					$time[1] .= ':00';

				$time[0] = strtotime( $time[0] );
				$time[1] = strtotime( $time[1] );

				if ( $now < $time[0] || $now > $time[1] )
					return $atts['alt'];
			}
		}

		if ( $atts['week'] !== 'all' ) {
			$today = date( 'w', current_time( 'timestamp', 0 ) );
			$atts['week'] = preg_replace( "/[^0-9-,]/", '', $atts['week'] );
			$days = wp_shortcode()->tools->range( $atts['week'] );
			if ( !in_array( $today, $days ) )
				return $atts['alt'];
		}

		if ( $atts['month'] !== 'all' ) {

			$today = date( 'j', current_time( 'timestamp', 0 ) );
			$atts['month'] = preg_replace( "/[^0-9-,]/", '', $atts['month'] );
			$days = wp_shortcode()->tools->range( $atts['month'] );
			if ( !in_array( $today, $days ) )
				return $atts['alt'];
		}

		if ( $atts['months'] !== 'all' ) {

			$now = date( 'n', current_time( 'timestamp', 0 ) );
			$atts['months'] = preg_replace( "/[^0-9-,]/", '', $atts['months'] );
			$months = wp_shortcode()->tools->range( $atts['months'] );

			if ( !in_array( $now, $months ) )
				return $atts['alt'];
		}

		if ( $atts['years'] !== 'all' ) {

			$now = date( 'Y', current_time( 'timestamp', 0 ) );

			$atts['years'] = preg_replace( "/[^0-9-,]/", '', $atts['years'] );
			$years = wp_shortcode()->tools->range( $atts['years'] );
			if ( !in_array( $now, $years ) )
				return $atts['alt'];
		}

		return do_shortcode( $content );
	}

	public static function posts_block( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'post_type'				=> 'post',
				'id'					=> false,
				'taxonomy'				=> 'category',
				'tax_term'				=> false,
				'tax_operator'			=> 'IN',
				'author'				=> '',
				'meta_key'				=> '',
				'offset'				=> 0,
				'border'				=> '',
				'post_parent'			=> false,
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 'no',
				'order'					=> 'DESC',
				'orderby'				=> 'date',
				'posts_per_page' => get_option( 'posts_per_page' ),
				'excerpt_length'		=> 30,
				'hide_items'			=> 'none',
				'view'					=> 'list',
				'columns'				=> 1,
				'allow_pagination'		=> 'yes',
			), $atts, 'posts_block' );

		$org_atts = $atts;

		$author = sanitize_text_field( $atts['author'] );
		$id = $atts['id'];
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key = sanitize_text_field( $atts['meta_key'] );
		$offset = intval( $atts['offset'] );
		$order = sanitize_key( $atts['order'] );
		$orderby = sanitize_key( $atts['orderby'] );
		$post_parent = $atts['post_parent'];
		$post_status = $atts['post_status'];
		$post_type = sanitize_text_field( $atts['post_type'] );
		$posts_per_page = intval( $atts['posts_per_page'] );
		$tax_operator = $atts['tax_operator'];
		$tax_term = sanitize_text_field( $atts['tax_term'] );
		$taxonomy = sanitize_key( $atts['taxonomy'] );
		$hide_items = array();
		if( $atts['hide_items'] !== 'none' ) {
			$hide_items = explode(',', $atts['hide_items']);
		}
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			'order'				=> $order,
			'orderby'			=> $orderby,
			'post_type'			=> explode( ',', $post_type ),
			'posts_per_page'	=> $posts_per_page,
			'paged'				=> $paged,
		);

		if ( $ignore_sticky_posts )
			$args['ignore_sticky_posts'] = true;

		if ( !empty( $meta_key ) )
			$args['meta_key'] = $meta_key;

		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}

		if ( !empty( $author ) )
			$args['author'] = $author;

		if ( !empty( $offset ) )
			$args['offset'] = $offset;

		$post_status = explode( ', ', $post_status );
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) )
				$validated[] = $unvalidated;
		}

		if ( !empty( $validated ) )
			$args['post_status'] = $validated;

		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {

			$tax_term = explode( ',', $tax_term );
			$tax_operator = str_replace( array( 0, 1, 2 ), array( 'IN', 'NOT IN', 'AND' ), $tax_operator );

			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
				$tax_operator = 'IN';

			$tax_args = array(
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field' => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms' => $tax_term,
						'operator' => $tax_operator
					)
				) );

			$count = 2;
			$more_tax_queries = false;
			while ( isset( $org_atts['taxonomy_' . $count] ) && !empty( $org_atts['taxonomy_' . $count] ) &&
				isset( $org_atts['tax_' . $count . '_term'] ) &&
				!empty( $org_atts['tax_' . $count . '_term'] ) ) {

				$more_tax_queries = true;
				$taxonomy = sanitize_key( $org_atts['taxonomy_' . $count] );
				$terms = explode( ', ', sanitize_text_field( $org_atts['tax_' . $count . '_term'] ) );
				$tax_operator = isset( $org_atts['tax_' . $count . '_operator'] ) ? $org_atts[
				'tax_' . $count . '_operator'] : 'IN';
				$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms,
					'operator' => $tax_operator );
				$count++;
			}
			if ( $more_tax_queries ):
				$tax_relation = 'AND';
				if ( isset( $org_atts['tax_relation'] ) &&
					in_array( $org_atts['tax_relation'], array( 'AND', 'OR' ) )
				)
				$tax_relation = $org_atts['tax_relation'];
				$args['tax_query']['relation'] = $tax_relation;
			endif;

			$args = array_merge( $args, $tax_args );
		}

		if ( $post_parent ) {
			if ( 'current' == $post_parent ) {
				global $post;
				$post_parent = $post->ID;
			}
			$args['post_parent'] = intval( $post_parent );
		}

		$inner_wrapper_style = $atts['border'] ? 'style="border: '.$atts['border'].'; padding: 20px 15px;"' : '';

		$block_posts = new WP_Query( $args );
		$row_shortcode = wps_prefix().'row';
		$column_shortcode = wps_prefix().'column';
		ob_start();

		echo '<div class="wps-shortcode-wrapper wps-posts-block wps-'.esc_attr($atts['view']).'" id="wps-posts-block">
			['.$row_shortcode.']';

			if ( $block_posts->have_posts() ) {
					while ( $block_posts->have_posts() ) {
						$block_posts->the_post();
						$column_size="1-".$atts['columns'];
						$excerpt = get_the_excerpt();
						$excerpt = wp_trim_words( $excerpt, $atts['excerpt_length'], '...' );
					?>
						<?php echo "[$column_shortcode size= '$column_size' ]"; ?>
							<div class="wps-inner-wrapper" <?php echo $inner_wrapper_style; ?>>
								<?php if(has_post_thumbnail() && !in_array('thumbnail', $hide_items)) { ?>
									<div class="wps-thumbnail-wraper">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail(); ?>
										</a>
									</div>
								<?php } ?>
								<div class="wps-content-wrapper">
									<?php if(!in_array('title', $hide_items)) { ?>
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php } ?>
									<?php if(!in_array('meta', $hide_items)) { ?>
										<div class="wps-meta">
											<?php if(!in_array('author', $hide_items)) { ?>
												<span class="post-author">
													<?php echo __('By', 'wp-shortcode-pro').' '.get_the_author_link(); ?>
												</span>
											<?php } ?>
											<?php if(!in_array('date', $hide_items)) { ?>
												<span class="post-date"><?php the_date(); ?></span>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if($excerpt && !in_array('excerpt', $hide_items)) { ?>
										<div class="wps-excerpt-wrapper"> <?php echo $excerpt; ?> </div>
									<?php } ?>
									<a class="wps-read-more" href="<?php the_permalink(); ?>"><?php _e('Read More', 'wp-shortcode-pro'); ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
								</div>
							</div>
					<?php
						echo "[/$column_shortcode]";
					}
					if( $atts['allow_pagination'] === 'yes' && $block_posts->max_num_pages > 1) {
					?>
						<nav class="wps-pagination">
							<?php
							echo paginate_links( apply_filters( 'wps_pagination_args', array(
								'base'		=> add_query_arg('paged','%#%'),
								'format'	=> '?paged=%#%',
								'mid-size'	=> 1,
								'add_args'	=> false,
								'current'	=> $paged,
								'total'		=> $block_posts->max_num_pages,
								'prev_text'	=> '&laquo;',
								'next_text'	=> '&raquo;',
								'type'		=> 'list',
								'end_size'	=> 3,
							) ) );
							?>
						</nav>
					<?php
					}
				wp_reset_postdata();
			} else {
				echo __( 'No Posts Found.', 'wp-shortcode-pro' );
			}

		echo '</div>[/'.$row_shortcode.']';
		$output = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();

		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return do_shortcode($output);
	}

	public static function google_trends( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'query' => '',
				'geo'		=> 'US',
			), $atts, 'google_trends' );

		if( empty($atts['query']) ) return;

		$query = esc_attr($atts['query']);
		$geo = esc_attr($atts['geo']);
		ob_start();
		do_action('wps_before_google_trends', $atts);
		?>
		<script type="text/javascript" src="//www.google.com/trends/embed.js?hl=en-US&q=<?php echo $query;?>&geo=<?php echo $geo;?>&cmpt=q&content=1&cid=TIMESERIES_GRAPH_0&export=5"></script>
		<?php
		do_action('wps_after_google_trends', $atts);
		return ob_get_clean();
	}

	public static function pie_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'title'		=> '',
				'columns'	=> '',
				'rows'		=> '',
				'is3d'		=> true,
				'width'		=> '500',
				'height'	=> '300',
				'class'		=> '',
			), $atts, 'pie_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_pie_chart', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-google_charts wps-pie_chart <?php echo wps_specific_class( $atts ); ?>"  id="<?php echo uniqid('wps_'); ?>" style="width: <?php echo esc_attr($atts['width']) ?>px; height: <?php echo esc_attr($atts['height']) ?>px;" <?php echo $attributes; ?>></div>
		<?php
		do_action('wps_after_pie_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function geo_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'columns'	=> '',
				'rows'		=> '',
				'width'		=> '500',
				'height'	=> '300',
				'class'		=> '',
			), $atts, 'geo_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_geo_chart', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-google_charts wps-geo_chart <?php echo wps_specific_class( $atts ); ?>" id="<?php echo uniqid('wps_'); ?>" style="width: <?php echo esc_attr($atts['width']) ?>px; height: <?php echo esc_attr($atts['height']) ?>px;" <?php echo $attributes; ?>>
			</div>
		<?php
		do_action('wps_after_geo_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function bar_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'title'			=> '',
				'columns'		=> '',
				'rows'			=> '',
				'xaxis_top'		=> '',
				'xaxis_bottom'	=> '',
				'width'			=> '500',
				'height'		=> '300',
				'class'			=> '',
			), $atts, 'bar_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_bar_chart', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-google_charts wps-bar_chart <?php echo wps_specific_class( $atts ); ?>" id="<?php echo uniqid('wps_'); ?>" style="width: <?php echo esc_attr($atts['width']) ?>px; height: <?php echo esc_attr($atts['height']) ?>px;" <?php echo $attributes; ?>></div>
		<?php
		do_action('wps_after_bar_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function area_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'title'		=> '',
				'columns'	=> '',
				'rows'		=> '',
				'vaxis'		=> '',
				'haxis'		=> '',
				'width'		=> '500',
				'height'	=> '300',
				'class'		=> '',
			), $atts, 'area_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_area_chart', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-google_charts wps-area_chart <?php echo wps_specific_class( $atts ); ?>" id="<?php echo uniqid('wps_'); ?>" style="width: <?php echo esc_attr($atts['width']) ?>px; height: <?php echo esc_attr($atts['height']) ?>px;" <?php echo $attributes; ?>>
			</div>
		<?php
		do_action('wps_after_area_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function combo_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'title'		=> '',
				'columns'	=> '',
				'rows'		=> '',
				'vaxis'		=> '',
				'haxis'		=> '',
				'width'		=> '500',
				'height'	=> '300',
				'class'		=> '',
			), $atts, 'combo_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_combo_chart', $atts);
		?>
			<div class="wps-shortcode-wrapper wps-google_charts wps-combo_chart <?php echo wps_specific_class( $atts ); ?>" id="<?php echo uniqid('wps_'); ?>" style="width: <?php echo esc_attr($atts['width']) ?>px; height: <?php echo esc_attr($atts['height']) ?>px;" <?php echo $attributes; ?>></div>
		<?php
		do_action('wps_after_combo_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function org_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'size'		=> 'medium',
				'columns'	=> '',
				'rows'		=> '',
				'class'		=> ''
			), $atts, 'org_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_org_chart', $atts);
		?>
			<style type="text/css">
				.wps-org_chart table { border-collapse: inherit;  }
			</style>
			<div class="wps-shortcode-wrapper wps-google_charts wps-org_chart <?php echo wps_specific_class( $atts ); ?>" id="<?php echo uniqid('wps_'); ?>" <?php echo $attributes; ?>></div>
		<?php
		do_action('wps_after_org_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function bubble_chart( $atts = null, $content = null ) {

		$atts = shortcode_atts( array(
				'title'				=> '',
				'columns'			=> '',
				'rows'				=> '',
				'vaxis'				=> '',
				'haxis'				=> '',
				'primary_color'		=> '',
				'secondary_color'	=> '',
				'width'				=> '500',
				'height'			=> '300',
				'class'				=> ''
			), $atts, 'bubble_chart' );

		if( empty($atts['columns']) || empty($atts['rows']) ) return;
		$attributes = '';
		foreach($atts as $key => $value) {
			$attributes .= ' data-'.$key.'="'.$value.'"';
		}
		ob_start();
		do_action('wps_before_bubble_chart', $atts);
		?>
			<style type="text/css">
				.wps-org_chart table { border-collapse: inherit;  }
			</style>
			<div class="wps-shortcode-wrapper wps-google_charts wps-bubble_chart <?php echo wps_specific_class( $atts ); ?>" id="<?php echo uniqid('wps_'); ?>" <?php echo $attributes; ?>  style="width: <?php echo esc_attr($atts['width']) ?>px; height: <?php echo esc_attr($atts['height']) ?>px;">
			</div>
		<?php
		do_action('wps_after_bubble_chart', $atts);
		wps_sortcode_script( 'js', 'wps-google-chart' );
		wps_sortcode_script( 'js', 'wp-shortcode-pro' );
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
		return ob_get_clean();
	}

	public static function wps_custom_shortcodes( $atts = null, $content = null, $shortcode_name = null ) {
		$prefix = wps_prefix();
		if (substr($shortcode_name, 0, strlen($prefix)) == $prefix) {
			$shortcode_name = substr($shortcode_name, strlen($prefix));
		}

		$shortcode = get_page_by_path( $shortcode_name, ARRAY_A, 'wp_custom_shortcodes' );
		if( empty($shortcode) ) return;

		$wps_details = get_post_meta($shortcode['ID'], '_wps_details', true);
		if( ! isset($wps_details['layout']) || empty($wps_details['layout']) ) return;

		$shortcode_layout = apply_filters($shortcode_name.'_layout', $wps_details['layout'], $atts);
		$shortcode_css = $wps_details['css'];
		
		if ( ! empty( $atts ) && is_array( $atts ) ) {
			foreach( $atts as $name => $value ) {
				$shortcode_layout = str_replace("%$name%",$value,$shortcode_layout);
				$shortcode_css = str_replace("%$name%",$value,$shortcode_css);
			}
		}
		$shortcode_layout = str_replace("%content%",$content,$shortcode_layout);
		wps_sortcode_script( 'css', 'wp-shortcode-pro' );
	 	wp_add_inline_style( 'wp-shortcode-pro', $shortcode_css );
		return $shortcode_layout;
	}

	public static function clipboard( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'class'		=> ''
			), $atts, 'clipboard' );

		if(!$content) return;

		ob_start();
			do_action('wps_before_clipboard', $atts);

		?>
			<div class="wps-clipboard wps-shortcode-wrapper <?php echo wps_specific_class( $atts ); ?>">
				<?php $content = esc_html( preg_replace("/<br\W*?\/>/", "\n", $content) ); ?>
				<pre><code class="html hljs php"><?php echo $content; ?></code></pre>
				<button class="wps-copy-clipboard">
					<i class="fa fa-clipboard" aria-hidden="true"></i>
				</button>
			</div>
		<?php
			do_action('wps_after_clipboard', $atts);
			wps_sortcode_script( 'js', 'wps-clipboard' );
			wps_sortcode_script( 'js', 'wps-highlight' );
			wps_sortcode_script( 'js', 'wp-shortcode-pro' );
			wps_sortcode_script( 'css', 'wp-shortcode-pro' );
			wps_sortcode_script( 'css', 'wps-fontawesome' );
			wps_sortcode_script( 'css', 'wp-shortcode-qtip' );
			wps_sortcode_script( 'js', 'wp-shortcode-qtip' );
		return ob_get_clean();
	}

	//Backward compatibility shortcodes

	public static function mts_button_brown($atts = array(), $content = null) {
		extract(shortcode_atts(array(
			'url'		=> '#',
			'target'	=> '_self',
			'position'	=> 'left',
			'rel'		=> '',
		), $atts));
		$out = "<a href=\"" . esc_url( $url ) . "\" target=\"" . esc_attr( $target ) . "\" class=\"buttons btn_brown " .sanitize_html_class( $position ). "\"" .($rel? " rel=\"" . esc_attr( $rel ) . "\"" : "")."><span class=\"left\">".do_shortcode($content)."</span></a>";
		if ($position == 'center') {
		$out = '<div class="button-center">'.$out.'</div>';
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_button_blue( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'url'		=> '#',
			'target'	=> '_self',
			'position'	=> 'left',
			'rel'		=> '',
		), $atts));
		$out = "<a href=\"" . esc_url( $url ) . "\" target=\"" . esc_attr( $target ) . "\" class=\"buttons btn_blue " .sanitize_html_class( $position ). "\"" .($rel? " rel=\"" . esc_attr( $rel ) . "\"" : "")."><span class=\"left\">".do_shortcode($content)."</span></a>";
		if ($position == 'center') {
			$out = '<div class="button-center">'.$out.'</div>';
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_button_green( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'url'		=> '#',
		'target'	=> '_self',
		'position'	=> 'left',
		'rel'		=> '',
		), $atts));
		$out = "<a href=\"" . esc_url( $url ) . "\" target=\"" . esc_attr( $target ) . "\" class=\"buttons btn_green " .sanitize_html_class( $position ). "\"" .($rel? " rel=\"" . esc_attr( $rel ) . "\"" : "")."><span class=\"left\">".do_shortcode($content)."</span></a>";
		if ($position == 'center') {
			$out = '<div class="button-center">'.$out.'</div>';
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_button_red( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'url'		=> '#',
		'target'	=> '_self',
		'position'	=> 'left',
		'rel'		=> '',
		), $atts));
		$out = "<a href=\"" . esc_url( $url ) . "\" target=\"" . esc_attr( $target ) . "\" class=\"buttons btn_red " .sanitize_html_class( $position ). "\"" .($rel? " rel=\"" . esc_attr( $rel ) . "\"" : "")."><span class=\"left\">".do_shortcode($content)."</span></a>";
		if ($position == 'center') {
			$out = '<div class="button-center">'.$out.'</div>';
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_button_white( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'url'		=> '#',
			'target'	=> '_self',
			'position'	=> 'left',
			'rel'		=> '',
		), $atts));
		$out = "<a href=\"" . esc_url( $url ) . "\" target=\"" . esc_attr( $target ) . "\" class=\"buttons btn_white " .sanitize_html_class( $position ). "\"" .($rel? " rel=\"" . esc_attr( $rel ) . "\"" : "")."><span class=\"left\">".do_shortcode($content)."</span></a>";
		if ($position == 'center') {
			$out = '<div class="button-center">'.$out.'</div>';
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_button_yellow( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'url'		=> '#',
		'target'	=> '_self',
		'position'	=> 'left',
		'rel'		=> '',
		), $atts));
		$out = "<a href=\"" . esc_url( $url ) . "\" target=\"" . esc_attr( $target ) . "\" class=\"buttons btn_yellow " .sanitize_html_class( $position ). "\"" .($rel? " rel=\"" . esc_attr( $rel ) . "\"" : "")."><span class=\"left\">".do_shortcode($content)."</span></a>";
		if ($position == 'center') {
			$out = '<div class="button-center">'.$out.'</div>';
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_alert_note( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'	=> 'note'
		), $atts));
		$out = "<div class=\"message_box note\"><p>".do_shortcode($content)."</p></div>";
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_alert_announce( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'	=> 'announce'
		), $atts));
		$out = "<div class=\"message_box announce\"><p>".do_shortcode($content)."</p></div>";
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_alert_success( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'	=> 'success'
		), $atts));
		$out = "<div class=\"message_box success\"><p>".do_shortcode($content)."</p></div>";
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_alert_warning( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'	=> 'warning'
		), $atts));
		$out = "<div class=\"message_box warning\"><p>".do_shortcode($content)."</p></div>";
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_one_third( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_third">' . do_shortcode($content) . '</div>';
	}

	public static function mts_one_third_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_third column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_two_third( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="two_third">' . do_shortcode($content) . '</div>';
	}

	public static function mts_two_third_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="two_third column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_one_half( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_half">' . do_shortcode($content) . '</div>';
	}

	public static function mts_one_half_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_half column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_one_fourth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_one_fourth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_fourth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_three_fourth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_three_fourth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="three_fourth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_one_fifth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_one_fifth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_two_fifth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_two_fifth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="two_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_three_fifth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_three_fifth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="three_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_four_fifth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_four_fifth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="four_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_one_sixth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_one_sixth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="one_sixth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_five_sixth( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
	}

	public static function mts_five_sixth_last( $atts, $content = null ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="five_sixth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}

	public static function mts_youtube_video( $atts, $content = null ) {
		extract(shortcode_atts( array(
		'id'		=> '',
		'width'		=> '600',
		'height'	=> '340',
		'position'	=> 'left'
		), $atts));
		$out = "<div class=\"youtube-video " .sanitize_html_class( $position ) . "\"><iframe width=\"" .esc_attr( $width ) . "\" height=\"" .esc_attr( $height ) ."\" src=\"//www.youtube.com/embed/" . esc_attr( $id ) . "?rel=0\" frameborder=\"0\" allowfullscreen></iframe></div>";
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_vimeo_video( $atts, $content = null ) {
		extract(shortcode_atts( array(
		'id'		=> '',
		'width'		=> '600',
		'height'	=> '340',
		'position'	=> 'left'
		), $atts));
		$out = "<div class=\"vimeo-video " . sanitize_html_class( $position ) . "\"><iframe width=\"" .esc_attr( $width ) . "\" height=\"" .esc_attr( $height ) ."\" src=\"//player.vimeo.com/video/" . esc_attr( $id ) . "?title=0&amp;byline=0&amp;portrait=0\" frameborder=\"0\" allowfullscreen></iframe></div>";
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_googleMaps($atts, $content = null) {
		extract(shortcode_atts(array(
			'width'		=> '640',
			'height'	=> '480',
			'address'	=> '',
			'src'		=> '',
			'position'	=> 'left'
		), $atts));
		if (!empty($src)) {
			$out = "<div class=\"googlemaps " .sanitize_html_class( $position ) . "\"><iframe width=\"".esc_attr( $width )."\" height=\"".esc_attr( $height )."\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"".esc_url( $src )."&output=embed\"></iframe></div>";
		} else {
			$out = "<div class=\"googlemaps " .sanitize_html_class( $position ) . "\"><iframe width=\"".esc_attr( $width )."\" height=\"".esc_attr( $height )."\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"//maps.google.com/maps?q=".urlencode( $address )."&output=embed\"></iframe></div>";
		}
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return $out;
	}

	public static function mts_tabs( $atts, $content = null ) {
		if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
			return do_shortcode($content);
		} else {
			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_atts(
					array('title' => __('Untitled', 'wp-shortcode-pro')),
					shortcode_parse_atts($matches[3][$i])
				);
				$tabid[$i] = 'tab-'.$i.'-'.str_replace('%','',strtolower(sanitize_title($matches[3][$i]['title'])));
			}
			$tabnav = '<ul class="wps_tabs">';

				for($i = 0; $i < count($matches[0]); $i++) {
					$tabnav .= '<li><a href="#" data-tab="'.$tabid[$i].'">' . $matches[3][$i]['title'] . '</a></li>';
				}
			$tabnav .= '</ul>';

			$tabcontent = '<div class="tab_container">';
				for($i = 0; $i < count($matches[0]); $i++) {
					$tabcontent .= '<div id="'.$tabid[$i].'" class="tab_content clearfix">' . do_shortcode(trim($matches[5][$i])) . '</div>';
				}
			$tabcontent .= '</div>';

			wps_sortcode_script( 'css', 'wps-backward-compatible' );
			wps_sortcode_script( 'js', 'wps-backward-compatible' );
			return '<div class="tab_widget wp_shortcodes_tabs">' . $tabnav . $tabcontent . '</div><div class="clear"></div>';
		}
	}

	public static function mts_toggle( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title' => __('Toggle Title', 'wp-shortcode-pro')
		), $atts));

		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		wps_sortcode_script( 'js', 'wps-backward-compatible' );
		return '<div class="toggle clearfix wp_shortcodes_toggle"><div class="wps_togglet"><span>' . wp_kses_post( $title ) . '</span></div><div class="togglec clearfix">' . do_shortcode(trim($content)) . '</div></div><div class="clear"></div>';
	}

	public static function mts_divider( $atts ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="divider"></div>';
	}

	public static function mts_divider_top( $atts ) {
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		return '<div class="top-of-page"><a href="#top">'.__('Back to Top', 'wp-shortcode-pro').'</a></div>';
	}

	public static function mts_clear( $atts ) {
		return '<div class="clear"></div>';
	}

	public static function mts_tooltip( $atts = array(), $content = null ) {
		$atts = shortcode_atts(array(
		'content'	=> '',
		'gravity'	=> 'n',
		'fade'		=> '0'
		), $atts);
		wps_sortcode_script( 'css', 'wp-shortcode-qtip' );
		wps_sortcode_script( 'js', 'wp-shortcode-qtip' );
		wps_sortcode_script( 'css', 'wps-backward-compatible' );
		wps_sortcode_script( 'js', 'wps-backward-compatible' );
		return '<span class="wp_shortcodes_tooltip" title="'.esc_attr( $atts['content'] ).'" data-gravity="'.esc_attr( $atts['gravity'] ).'" data-fade="'.esc_attr( $atts['fade'] ).'">'.$content.'</span>';
	}

	public static function toc($atts) {
		extract( shortcode_atts( array(
				'style' => 'default',
				'title' => '',
				'wrapping' => 0,
				'heading_levels' => '1,2,3,4,5,6',
				'show_heirarchy' => 'no',
				'ordered_list' => 'yes',
				'exclude' => '',
				'bullet_spacing' => '',
				'collapse' => false,
				'class' => '',
				), $atts )
			);

			self::$default_toc_options = array(
				'style' => $style,
				'title' => $title,
				'heading_levels' => explode(',', $heading_levels),
				'exclude' => $exclude,
				'show_heirarchy' => $show_heirarchy,
				'ordered_list' => $ordered_list,
				'bullet_spacing' => $bullet_spacing,
				'class' => $class,
			);

			if ( !is_search() && !is_archive() && !is_feed() ) {
				wps_sortcode_script( 'css', 'wp-shortcode-pro' );
				wps_sortcode_script( 'css', 'wps-fontawesome' );
				wps_sortcode_script( 'js', 'wp-shortcode-pro' );
				return '<!--WPS_TOC-->';
			}
			else
				return;
	}
}
