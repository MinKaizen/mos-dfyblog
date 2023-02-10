<?php
/**
 * Shortcode List
 */
class WPS_List {

	/**
	 * Constructor
	 */
	function __construct() {}

	/**
	 * Shortcode categories
	 */
	public function categories() {
		return apply_filters( 'wps_categories', array(
			'all'		=>	__( 'All', 'wp-shortcode-pro' ),
			'content'	=>	__( 'Content', 'wp-shortcode-pro' ),
			'structure'	=>	__( 'Structure', 'wp-shortcode-pro' ),
			'media'		=>	__( 'Media', 'wp-shortcode-pro' ),
			'gallery'	=>	__( 'Gallery', 'wp-shortcode-pro' ),
			'data'		=>	__( 'Data', 'wp-shortcode-pro' ),
			'google'	=>	__( 'Google', 'wp-shortcode-pro' ),
			'other'		=>	__( 'Other', 'wp-shortcode-pro' )
		) );
	}

	/**
	 * Border styles
	 */
	public function borders() {
		return apply_filters( 'wps_borders', array(
			''		=> __( 'None', 'wp-shortcode-pro' ),
			'solid'		=> __( 'Solid', 'wp-shortcode-pro' ),
			'dotted'	=> __( 'Dotted', 'wp-shortcode-pro' ),
			'dashed'	=> __( 'Dashed', 'wp-shortcode-pro' ),
			'double'	=> __( 'Double', 'wp-shortcode-pro' ),
			'groove'	=> __( 'Groove', 'wp-shortcode-pro' ),
			'ridge'		=> __( 'Ridge', 'wp-shortcode-pro' ),
			'inset'		=> __( 'Inset', 'wp-shortcode-pro' ),
			'outset'	=> __( 'Outset', 'wp-shortcode-pro' ),
		) );
	}

	/**
	 * Animations
	 */
	public function animations() {
		return apply_filters( 'wps_animations', array( '', 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipOutX', 'flipInY', 'flipOutY', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutLeft', 'slideOutRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedIn', 'lightSpeedOut', 'hinge', 'rollIn', 'rollOut' ) );
	}

	/**
	 * Shortcodes
	 */
	public function shortcodes( $shortcode = false ) {

		$shortcodes = apply_filters( 'wp_shortcodes_lists', array(

				// alert
				'alert' => array(
					'name' => __( 'Alert', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'primary' => __( 'Primary', 'wp-shortcode-pro' ),
								'secondary' => __( 'Secondary', 'wp-shortcode-pro' ),
								'success' => __( 'Success', 'wp-shortcode-pro' ),
								'note' => __( 'Note', 'wp-shortcode-pro' ),
								'warning' => __( 'Warning', 'wp-shortcode-pro' ),
								'announce' => __( 'Announce', 'wp-shortcode-pro' ),
								'light' => __( 'Light', 'wp-shortcode-pro' ),
								'dark' => __( 'Dark', 'wp-shortcode-pro' ),
							),
							'default' => 'primary',
							'name' => __( 'Type', 'wp-shortcode-pro' ),
							'desc' => __( 'Alert Style.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'This is an alert—check it out!', 'wp-shortcode-pro' ),
					'desc' => __( 'Alert', 'wp-shortcode-pro' ),
					'icon' => 'exclamation-triangle',
				),
				// heading
				'heading' => array(
					'name' => __( 'Heading', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'left',
							'name' => __( 'Text Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Text align.', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 7,
							'max' => 48,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Font size.', 'wp-shortcode-pro' )
						),
						'font_weight' => array(
							'type' => 'select',
							'values' => array(
								'normal'	=> __( 'Normal', 'wp-shortcode-pro' ),
								'lighter'	=> __( 'Light', 'wp-shortcode-pro' ),
								'bold'		=> __( 'Bold', 'wp-shortcode-pro' ),
								'bolder'	=> __( 'Bolder', 'wp-shortcode-pro' )
							),
							'default' => 'normal',
							'name' => __( 'Font Weight', 'wp-shortcode-pro' ),
							'desc' => __( 'Font weight.', 'wp-shortcode-pro' )
						),
						'font_style' => array(
							'type' => 'select',
							'values' => array(
								'normal'	=> __( 'Normal', 'wp-shortcode-pro' ),
								'italic'	=> __( 'Italic', 'wp-shortcode-pro' )
							),
							'default' => 'normal',
							'name' => __( 'Font Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Font style.', 'wp-shortcode-pro' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 5,
							'default' => 20,
							'name' => __( 'Margin', 'wp-shortcode-pro' ),
							'desc' => __( 'Bottom margin (pixels)', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Custom Heading Text', 'wp-shortcode-pro' ),
					'desc' => __( 'Add custom heading', 'wp-shortcode-pro' ),
					'icon' => 'h-square',
				),
				// tabs
				'tabs' => array(
					'name' => __( 'Tabs', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'child' => 'tab',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'standard'  => __( 'Standard', 'wp-shortcode-pro' ),
								'classic' => __( 'Classic', 'wp-shortcode-pro' )
							),
							'default' => 'standard',
							'desc' => __( 'Tabs Style.', 'wp-shortcode-pro' ),
							'name' => __( 'Style', 'wp-shortcode-pro' ),
						),
						'active' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Active tab', 'wp-shortcode-pro' ),
							'desc' => __( 'Select which tab is open by default', 'wp-shortcode-pro' )
						),
						'vertical' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Vertical', 'wp-shortcode-pro' ),
							'desc' => __( 'Align tabs vertically', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
						'repeater_field' => array(
							'type' => 'wrap',
							'default' => '',
							'name' => __( 'Tabs', 'wp-shortcode-pro' ),
							'desc' => '<div class="wps-tab-inner-wrapper"></div><button class="button-primary" id="wps-add-field"  data-child="tab">'.__( 'Add tab', 'wp-shortcode-pro' ).'</button>'
						),
					),
					'content' => array(
						'class'	=> 'wps-hidden'
					),
					'desc' => __( 'Tabbed content', 'wp-shortcode-pro' ),
					'icon' => 'list-alt',
				),
				// tab
				'tab' => array(
					'name' => __( 'Tab', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'parent' => 'tabs',
					'notice' => __( 'This is a child shortcode of Tabs and it must be used inside Tabs shortcode only.', 'wp-shortcode-pro' ),
					'fields' => array(
						'title' => array(
							'default' => 'Tab name',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Tab title', 'wp-shortcode-pro' )
						),
						'disabled' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Disabled', 'wp-shortcode-pro' ),
							'desc' => __( 'Disable this tab', 'wp-shortcode-pro' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'wp-shortcode-pro' ),
							'desc' => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: use <b%value>Hello</b> and then navigate to url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default' => '',
							'name' => __( 'URL', 'wp-shortcode-pro' ),
							'desc' => __( 'Link tab to any webpage.', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self'  => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'wp-shortcode-pro' ),
							'desc' => __( 'Choose how to open the custom tab link', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Tab content', 'wp-shortcode-pro' ),
					'desc' => __( 'Single tab', 'wp-shortcode-pro' ),
					'icon' => 'list-alt',
				),
				// accordion
				'accordion' => array(
					'name' => __( 'Accordion', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'child' => 'accordion_item',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'standard'  => __( 'Standard', 'wp-shortcode-pro' ),
								'classic' => __( 'Classic', 'wp-shortcode-pro' )
							),
							'default' => 'standard',
							'desc' => __( 'Accordion Style.', 'wp-shortcode-pro' ),
							'name' => __( 'Style', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
						'repeater_field' => array(
							'type' => 'wrap',
							'default' => '',
							'name' => __( 'Items', 'wp-shortcode-pro' ),
							'desc' => '<div class="wps-tab-inner-wrapper"></div><button class="button-primary" id="wps-add-field" data-child="accordion_item">'.__( 'Add Item', 'wp-shortcode-pro' ).'</button>'
						),
					),
					'content' => array(
						'class'	=> 'wps-hidden'
					),
					'desc' => __( 'Collapsible content items', 'wp-shortcode-pro' ),
					'icon' => 'list',
				),
				// accordion_item
				'accordion_item' => array(
					'name' => __( 'Accordion Item', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'parent'=> 'accordion',
					'notice' => __( 'This is a child shortcode of Accordion and it must be used inside Accordion shortcode only.', 'wp-shortcode-pro' ),
					'fields' => array(
						'title' => array(
							'default'	=> 'Item title',
							'name'		=> __( 'Title', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Item title', 'wp-shortcode-pro' )
						),
						'open' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no'	=> __( 'No', 'wp-shortcode-pro' ),
								'yes'	=> __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Open', 'wp-shortcode-pro' ),
							'desc' => __( 'Open item by default', 'wp-shortcode-pro' )
						),
						'icon' => array(
							'type' => 'select',
							'values' => array(
								'plus'				=> __( 'Plus', 'wp-shortcode-pro' ),
								'plus-circle'		=> __( 'Plus circle', 'wp-shortcode-pro' ),
								'plus-square-1'		=> __( 'Plus square 1', 'wp-shortcode-pro' ),
								'plus-square-2'		=> __( 'Plus square 2', 'wp-shortcode-pro' ),
								'arrow'				=> __( 'Arrow', 'wp-shortcode-pro' ),
								'arrow-circle-1'	=> __( 'Arrow circle 1', 'wp-shortcode-pro' ),
								'arrow-circle-2'	=> __( 'Arrow circle 2', 'wp-shortcode-pro' ),
								'chevron'			=> __( 'Chevron', 'wp-shortcode-pro' ),
								'chevron-circle'	=> __( 'Chevron circle', 'wp-shortcode-pro' ),
								'caret'				=> __( 'Caret', 'wp-shortcode-pro' ),
								'caret-square'		=> __( 'Caret square', 'wp-shortcode-pro' ),
								'folder-1'			=> __( 'Folder 1', 'wp-shortcode-pro' ),
								'folder-2'			=> __( 'Folder 2', 'wp-shortcode-pro' )
							),
							'default' => 'caret',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'Item icon', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
					'desc' => __( 'Item with hidden content', 'wp-shortcode-pro' ),
					'icon' => 'list-ul',
				),
				// separator
				'separator' => array(
					'name' => __( 'Separator', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default'	=> __( 'Default', 'wp-shortcode-pro' ),
								'dotted'	=> __( 'Dotted', 'wp-shortcode-pro' ),
								'dashed'	=> __( 'Dashed', 'wp-shortcode-pro' ),
								'double'	=> __( 'Double', 'wp-shortcode-pro' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Separator style.', 'wp-shortcode-pro' )
						),
						'top' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show top link', 'wp-shortcode-pro' ),
							'desc' => __( 'Show link to top of the page.', 'wp-shortcode-pro' )
						),
						'text' => array(
							'default' => __( 'Top', 'wp-shortcode-pro' ),
							'name' => __( 'Link text', 'wp-shortcode-pro' ),
							'desc' => __( 'Text for the top link.', 'wp-shortcode-pro' )
						),
						'separator_color' => array(
							'type' => 'color',
							'default' => '#444',
							'name' => __( 'Separator color', 'wp-shortcode-pro' ),
							'desc' => __( 'Separator color.', 'wp-shortcode-pro' )
						),
						'link_color' => array(
							'type' => 'color',
							'default' => '#444',
							'name' => __( 'Link color', 'wp-shortcode-pro' ),
							'desc' => __( 'Top link color', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 30,
							'step' => 1,
							'default' => 2,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Height of the separator (pixels)', 'wp-shortcode-pro' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 5,
							'default' => 15,
							'name' => __( 'Margin', 'wp-shortcode-pro' ),
							'desc' => __( 'Top and bottom margins of the separator (pixels)', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Content separator with optional TOP link', 'wp-shortcode-pro' ),
					'icon' => 'ellipsis-h',
				),
				// spacer
				'spacer' => array(
					'name' => __( 'Empty Space', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content other',
					'fields' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 800,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Empty space height (pixels)', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Add spacer with custom height', 'wp-shortcode-pro' ),
					'icon' => 'arrows-v',
				),
				// highlight
				'highlight' => array(
					'name' => __( 'Highlight', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'background' => array(
							'type' => 'color',
							'default' => '#48ea50',
							'name' => __( 'Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Highlighted background color.', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#000000',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Text color.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Highlighted text', 'wp-shortcode-pro' ),
					'desc' => __( 'Highlighted text', 'wp-shortcode-pro' ),
					'icon' => 'pencil',
				),
				// quote
				'quote' => array(
					'name' => __( 'Quote', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'style-1' => __( 'Style 1', 'wp-shortcode-pro' ),
								'style-2' => __( 'Style 2', 'wp-shortcode-pro' ),
								'style-3' => __( 'Style 3', 'wp-shortcode-pro' ),
							),
							'default' => 'style-3',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Quote Style.', 'wp-shortcode-pro' )
						),
						'cite' => array(
							'default' => 'Cameron Moll',
							'name' => __( 'Cite', 'wp-shortcode-pro' ),
							'desc' => __( 'Author name', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'Cite url', 'wp-shortcode-pro' ),
							'desc' => __( 'Url of the quote author. Leave empty to disable link.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'What separates design from art is that design is meant to be… functional.',
					'desc' => __( 'Blockquote alternative', 'wp-shortcode-pro' ),
					'icon' => 'quote-right',
				),
				// pullquote
				'pullquote' => array(
					'name' => __( 'Pullquote', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'standard'  => __( 'Standard', 'wp-shortcode-pro' ),
								'classic' => __( 'Classic', 'wp-shortcode-pro' )
							),
							'default' => 'classic',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Pullquote Style.', 'wp-shortcode-pro' ),
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Align Pullquote.', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
					'desc' => __( 'Pullquote', 'wp-shortcode-pro' ),
					'icon' => 'quote-left',
				),
				// dropcap
				'dropcap' => array(
					'name' => __( 'Dropcap', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 5,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Dropcap size', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#ffffff',
							'name'		=> __( 'Dropcap Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Dropcap Color.', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#35ce8d',
							'name'		=> __( 'Background Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Dropcap Background Color.', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '0 none',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Dropcap Border.', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 100,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Drapcap Radius.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'D', 'wp-shortcode-pro' ),
					'desc' => __( 'Dropcap', 'wp-shortcode-pro' ),
					'icon' => 'bold',
				),
				// frame
				'frame' => array(
					'name' => __( 'Frame', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'style-1' => __( 'Style 1', 'wp-shortcode-pro' ),
								'style-2' => __( 'Style 2', 'wp-shortcode-pro' ),
								'style-3' => __( 'Style 3', 'wp-shortcode-pro' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Frame Style,', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Frame Align.', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#333333',
							'name'		=> __( 'Frame Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Frame Color.', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#fafafb',
							'name'		=> __( 'Background Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Frame Background Color.', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '6px solid #d6e5ff',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Frame border.', 'wp-shortcode-pro' )
						),
						'class' => array(
						'default' => '',
						'name' => __( 'Class', 'wp-shortcode-pro' ),
						'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
						)
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Styled image frame', 'wp-shortcode-pro' ),
					'icon' => 'image'
				),
				// row
				'row' => array(
					'name' => __( 'Row', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'child' => 'column',
					'fields' => array(
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
						'repeater_field' => array(
							'type' => 'wrap',
							'default' => '',
							'name' => __( 'Columns', 'wp-shortcode-pro' ),
							'desc' => '<div class="wps-tab-inner-wrapper"></div><button class="button-primary" id="wps-add-field" data-child="column">'.__( 'Add Column', 'wp-shortcode-pro' ).'</button>'
						),
					),
					'content' => array(
						'class' => 'wps-hidden'
					),
					'desc' => __( 'Row for flexible columns', 'wp-shortcode-pro' ),
					'icon' => 'columns',
				),
				// column
				'column' => array(
					'name' => __( 'Column', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'parent' => 'row',
					'fields' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'1-1' => __( 'Full width', 'wp-shortcode-pro' ),
								'1-2' => __( 'One half', 'wp-shortcode-pro' ),
								'1-3' => __( 'One third', 'wp-shortcode-pro' ),
								'2-3' => __( 'Two third', 'wp-shortcode-pro' ),
								'1-4' => __( 'One fourth', 'wp-shortcode-pro' ),
								'3-4' => __( 'Three fourth', 'wp-shortcode-pro' ),
								'1-5' => __( 'One fifth', 'wp-shortcode-pro' ),
								'2-5' => __( 'Two fifth', 'wp-shortcode-pro' ),
								'3-5' => __( 'Three fifth', 'wp-shortcode-pro' ),
								'4-5' => __( 'Four fifth', 'wp-shortcode-pro' ),
								'1-6' => __( 'One sixth', 'wp-shortcode-pro' ),
								'5-6' => __( 'Five sixth', 'wp-shortcode-pro' )
							),
							'default' => '1/2',
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Column width.', 'wp-shortcode-pro' )
						),
						'center' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Centered', 'wp-shortcode-pro' ),
							'desc' => __( 'Centered column', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.',
					'desc' => __( 'Flexible and responsive columns', 'wp-shortcode-pro' ),
					'icon' => 'columns',
				),
				// list
				'lists' => array(
					'name' => __( 'List', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => 'arrow-right',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'List icon', 'wp-shortcode-pro' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#444',
							'name' => __( 'Icon color', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon color', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( "<ul>\n<li>List item</li>\n<li>List item</li>\n<li>List item</li>\n</ul>", 'wp-shortcode-pro' ),
					'desc' => __( 'Styled unordered list', 'wp-shortcode-pro' ),
					'icon' => 'list-ol',
				),
				// button
				'button' => array(
					'name' => __( 'Button', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default'	=> __( 'Default', 'wp-shortcode-pro' ),
								'bordered'	=> __( 'Bordered', 'wp-shortcode-pro' ),
								'stroked'	=> __( 'Stroked', 'wp-shortcode-pro' ),
								'3d'		=> __( '3D', 'wp-shortcode-pro' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Button style.', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'URL', 'wp-shortcode-pro' ),
							'desc' => __( 'Button URL', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'wp-shortcode-pro' ),
							'desc' => __( 'Link target', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#2D89EF',
							'name' => __( 'Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Button background color.', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Button text color.', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 50,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Font size.', 'wp-shortcode-pro' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => 'heart-o',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'Button icon.', 'wp-shortcode-pro' )
						),
						'wide' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Wide', 'wp-shortcode-pro' ),
							'desc' => __( 'Make Button full width.', 'wp-shortcode-pro' )
						),
						'position' => array(
							'name' => __( 'Position', 'wp-shortcode-pro' ),
							'type' => 'select',
							'default' => 'left',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'desc' => __( 'Align button', 'wp-shortcode-pro' ),
						),
						'radius' => array(
							'type' => 'select',
							'values' => array(
								'0' => __( 'Square', 'wp-shortcode-pro' ),
								'auto' => __( 'Auto', 'wp-shortcode-pro' ),
								'round' => __( 'Round', 'wp-shortcode-pro' ),
								'5' => '5px',
								'10' => '10px',
								'20' => '20px'
							),
							'default' => 'auto',
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Button radius.', 'wp-shortcode-pro' )
						),
						'text_shadow' => array(
							'type' => 'shadow',
							'default' => '0px 1px 1px #000',
							'name' => __( 'Text shadow', 'wp-shortcode-pro' )
						),
						'rel' => array(
							'default' => 'nofollow',
							'name' => __( 'Rel attribute', 'wp-shortcode-pro' ),
							'desc' => __( 'Here you can add value for the rel attribute. Example values: <b%value>nofollow</b>, <b%value>lightbox</b>', 'wp-shortcode-pro' )
						),
						'title' => array(
							'default' => 'Default Button',
							'name' => __( 'Title attribute', 'wp-shortcode-pro' ),
							'desc' => __( 'Button title.', 'wp-shortcode-pro' )
						),
						'id' => array(
							'default' => 'default-button',
							'name' => __( 'Button ID', 'wp-shortcode-pro' ),
							'desc' => __( 'Button ID.', 'wp-shortcode-pro' )
						),
						'desc' => array(
							'default' => 'Button description',
							'name' => __( 'Button Description', 'wp-shortcode-pro' ),
							'desc' => __( 'Button description', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Button text', 'wp-shortcode-pro' ),
					'desc' => __( 'Eye catching button', 'wp-shortcode-pro' ),
					'icon' => 'heart',
				),
				// Double Button
				'double_button' => array(
					'name' => __( 'Double Button', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'left_btn_text' => array(
							'default' => 'Login',
							'name' => __( 'Left Button Text', 'wp-shortcode-pro' ),
							'desc' => __( 'Left Button Text.', 'wp-shortcode-pro' )
						),
						'left_desc' => array(
							'default' => 'Already a member?',
							'name' => __( 'Left Button Description', 'wp-shortcode-pro' ),
							'desc' => __( 'Left Button Description', 'wp-shortcode-pro' )
						),
						'left_url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'wp-shortcode-pro' ),
							'desc' => __( 'Left Button Link.', 'wp-shortcode-pro' )
						),
						'left_btn_target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'wp-shortcode-pro' ),
							'desc' => __( 'Left Button link target.', 'wp-shortcode-pro' )
						),
						'left_icon' => array(
							'type' => 'icon',
							'default' => 'user',
							'name' => __( 'Left Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'Left  Icon.', 'wp-shortcode-pro' )
						),
						'left_background' => array(
							'type' => 'color',
							'default' => '#2D89EF',
							'name' => __( 'Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Left Button background color', 'wp-shortcode-pro' )
						),
						'left_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Left Button text color', 'wp-shortcode-pro' )
						),
						'separator_text' => array(
							'default' => 'OR',
							'name' => __( 'Separator Text', 'wp-shortcode-pro' ),
							'desc' => __( 'Separator Text.', 'wp-shortcode-pro' )
						),
						'right_btn_text' => array(
							'default' => 'Register',
							'name' => __( 'Right Button Text', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Button Text.', 'wp-shortcode-pro' )
						),
						'right_desc' => array(
							'default' => 'Not a member yet?',
							'name' => __( 'Right Button Description', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Button Description.', 'wp-shortcode-pro' )
						),
						'right_url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Button Link.', 'wp-shortcode-pro' )
						),
						'right_btn_target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Button link target.', 'wp-shortcode-pro' )
						),
						'right_icon' => array(
							'type' => 'icon',
							'default' => 'user',
							'name' => __( 'Right Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Icon.', 'wp-shortcode-pro' )
						),
						'right_background' => array(
							'type' => 'color',
							'default' => '#2D89EF',
							'name' => __( 'Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Button background color.', 'wp-shortcode-pro' )
						),
						'right_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Right Button text color.', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 50,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Button Size.', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 100,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Button Radius.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Double Button', 'wp-shortcode-pro' ),
					'icon' => 'mars-double',
				),
				// service
				'service' => array(
					'name' => __( 'Service', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'title' => array(
							'default' => __( 'Service title', 'wp-shortcode-pro' ),
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Service name', 'wp-shortcode-pro' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => 'cog',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'You can use custom icon for this box.', 'wp-shortcode-pro' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon color.', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 128,
							'step' => 2,
							'default' => 32,
							'name' => __( 'Icon size', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon size (pixels)', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Service box with title', 'wp-shortcode-pro' ),
					'icon' => 'wrench',
				),
				// box
				'box' => array(
					'name' => __( 'Box', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'title' => array(
							'default' => 'Box Title',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Box title', 'wp-shortcode-pro' )
						),
						'title_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Title text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Box title color', 'wp-shortcode-pro' )
						),
						'box_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Box title and border color', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Box radius', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Colored box with caption', 'wp-shortcode-pro' ),
					'icon' => 'list-alt',
				),
				// note
				'note' => array(
					'name' => __( 'Note', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 50,
							'step' => 1,
							'default' => 17,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Font size', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#fae588',
							'name' => __( 'Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Background color', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Text color', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Note radius', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
					'desc' => __( 'Colored box', 'wp-shortcode-pro' ),
					'icon' => 'list-alt',
				),
				// expand
				'expand' => array(
					'name' => __( 'Expand', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'more_text' => array(
							'default' => __( 'Show more', 'wp-shortcode-pro' ),
							'name' => __( 'More text', 'wp-shortcode-pro' ),
							'desc' => __( 'More link text', 'wp-shortcode-pro' )
						),
						'less_text' => array(
							'default' => __( 'Show less', 'wp-shortcode-pro' ),
							'name' => __( 'Less text', 'wp-shortcode-pro' ),
							'desc' => __( 'Less link text', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 1000,
							'step' => 10,
							'default' => 100,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Collapsed height (pixels)', 'wp-shortcode-pro' )
						),
						'hide_less' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Hide less link', 'wp-shortcode-pro' ),
							'desc' => __( 'Hide less link', 'wp-shortcode-pro' )
						),
						'text_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Text color', 'wp-shortcode-pro' )
						),
						'link_color' => array(
							'type' => 'color',
							'default' => '#0088FF',
							'name' => __( 'Link color', 'wp-shortcode-pro' ),
							'desc' => __( 'Link color', 'wp-shortcode-pro' )
						),
						'link_style' => array(
							'type' => 'select',
							'values' => array(
								'default'    => __( 'Default', 'wp-shortcode-pro' ),
								'underlined' => __( 'Underlined', 'wp-shortcode-pro' ),
								'dotted'     => __( 'Dotted', 'wp-shortcode-pro' ),
								'dashed'     => __( 'Dashed', 'wp-shortcode-pro' ),
								'button'     => __( 'Button', 'wp-shortcode-pro' ),
							),
							'default' => 'default',
							'name' => __( 'Link style', 'wp-shortcode-pro' ),
							'desc' => __( 'Link style', 'wp-shortcode-pro' )
						),
						'link_align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'default' => 'left',
							'name' => __( 'Link align', 'wp-shortcode-pro' ),
							'desc' => __( 'Link alignment', 'wp-shortcode-pro' )
						),
						'more_icon' => array(
							'type' => 'icon',
							'default' => 'arrow-down',
							'name' => __( 'More icon', 'wp-shortcode-pro' ),
							'desc' => __( 'More link icon', 'wp-shortcode-pro' )
						),
						'less_icon' => array(
							'type' => 'icon',
							'default' => 'arrow-up',
							'name' => __( 'Less icon', 'wp-shortcode-pro' ),
							'desc' => __( 'Less link icon', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi.Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi.',
					'desc' => __( 'Expandable text block', 'wp-shortcode-pro' ),
					'icon' => 'sort-amount-asc',
				),
				// lightbox
				'lightbox' => array(
					'name' => __( 'Lightbox', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'gallery',
					'possible_sibling' => 'lightbox_content',
					'fields' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'iframe' => __( 'Iframe', 'wp-shortcode-pro' ),
								'image' => __( 'Image', 'wp-shortcode-pro' ),
								'inline' => __( 'Inline (html content)', 'wp-shortcode-pro' )
							),
							'default' => 'inline',
							'name' => __( 'Content type', 'wp-shortcode-pro' ),
							'desc' => __( 'Lightbox type', 'wp-shortcode-pro' )
						),
						'src' => array(
							'default' => '',
							'name' => __( 'Content source', 'wp-shortcode-pro' ),
							'desc' => __( 'Insert here URL or CSS selector.<br />Example values:<br /><b%value>http://www.youtube.com/watch?v=XXXXXXXXX</b> - YouTube video (iframe)<br /><b%value>http://example.com/wp-content/uploads/image.jpg</b> - uploaded image (image)<br /><b%value>http://example.com/</b> - any web page (iframe)<br /><b%value>#my-popup</b> - any HTML content (inline)', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Click here to open lightbox', 'wp-shortcode-pro' ),
					'desc' => __( 'Lightbox window with custom content', 'wp-shortcode-pro' ),
					'icon' => 'external-link',
				),
				// lightbox content
				'lightbox_content' => array(
					'name' => __( 'Lightbox content', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'gallery',
					'required_sibling' => 'lightbox',
					'fields' => array(
						'id' => array(
							'default' => 'my-popup',
							'name' => __( 'ID', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Enter here the ID from Content source field of Lightbox shortcode. %s Example value: %s', 'wp-shortcode-pro' ), '<br>', '<b%value>my-popup</b>' )
						),
						'width' => array(
							'default' => '50%',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>600px</b>', '<b%value>90%</b>' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 600,
							'step' => 5,
							'default' => 40,
							'name' => __( 'Margin', 'wp-shortcode-pro' ),
							'desc' => __( 'Content margin (pixels)', 'wp-shortcode-pro' )
						),
						'padding' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 600,
							'step' => 5,
							'default' => 40,
							'name' => __( 'Padding', 'wp-shortcode-pro' ),
							'desc' => __( 'Content padding (pixels)', 'wp-shortcode-pro' )
						),
						'text_align' => array(
							'type' => 'select',
							'values' => array(
								'left'   => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right'  => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'center',
							'name' => __( 'Text alignment', 'wp-shortcode-pro' ),
							'desc' => __( 'Text alignment', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Background color', 'wp-shortcode-pro' ),
							'desc' => __( 'Background color', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Text color', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'wp-shortcode-pro' ),
							'desc' => __( 'Text color', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type' => 'shadow',
							'default' => '0px 0px 15px #333333',
							'name' => __( 'Shadow', 'wp-shortcode-pro' ),
							'desc' => __( 'Content Box Shadow', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Inline content for lightbox', 'wp-shortcode-pro' ),
					'icon' => 'external-link',
				),
				// tooltip
				'tooltip' => array(
					'name' => __( 'Tooltip', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'fields' => array(
						'position' => array(
							'type' => 'select',
							'values' => array(
								'top-left' => __( 'Top left', 'wp-shortcode-pro' ),
								'top-center' => __( 'Top Center', 'wp-shortcode-pro' ),
								'top-right' => __( 'Top Right', 'wp-shortcode-pro' ),
								'bottom-left' => __( 'Bottom Left', 'wp-shortcode-pro' ),
								'bottom-center' => __( 'Bottom Center', 'wp-shortcode-pro' ),
								'bottom-right' => __( 'Bottom Right', 'wp-shortcode-pro' ),
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'default' => 'top-center',
							'name' => __( 'Position', 'wp-shortcode-pro' ),
							'desc' => __( 'Tooltip position', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 4,
							'max' => 20,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Font size', 'wp-shortcode-pro' ),
							'desc' => __( 'Tooltip font size', 'wp-shortcode-pro' )
						),
						'title' => array(
							'default' => 'Tooltip on top',
							'name' => __( 'Tooltip title', 'wp-shortcode-pro' ),
							'desc' => __( 'Tooltip title. Leave this field empty to hide the title', 'wp-shortcode-pro' )
						),
						'content' => array(
							'default' => 'Tooltip text',
							'name' => __( 'Tooltip content', 'wp-shortcode-pro' ),
							'desc' => __( 'Tooltip content', 'wp-shortcode-pro' )
						),
						'behavior' => array(
							'type' => 'select',
							'values' => array(
								'hover' => __( 'Show and hide on mouse hover', 'wp-shortcode-pro' ),
								'click' => __( 'Show and hide by mouse click', 'wp-shortcode-pro' ),
								'always' => __( 'Always visible', 'wp-shortcode-pro' )
							),
							'default' => 'hover',
							'name' => __( 'Behavior', 'wp-shortcode-pro' ),
							'desc' => __( 'Select tooltip behavior', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Hover me to open tooltip', 'wp-shortcode-pro' ),
					'desc' => __( 'Tooltip window with custom content', 'wp-shortcode-pro' ),
					'icon' => 'comment',
				),
				// youtube
				'youtube' => array(
					'name' => __( 'YouTube', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'url' => array(
							'default' => 'https://www.youtube.com/watch?v=ilk58Gfxcg0',
							'name' => __( 'Url', 'wp-shortcode-pro' ),
							'desc' => __( 'Youtube video url.', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Player width', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Player height', 'wp-shortcode-pro' )
						),
						'responsive' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Responsive', 'wp-shortcode-pro' ),
							'desc' => __( 'Make player responsive', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Autoplay', 'wp-shortcode-pro' ),
							'desc' => __( 'Autoplay video', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'YouTube video', 'wp-shortcode-pro' ),
					'icon' => 'youtube',
				),
				// youtube_advanced
				'youtube_advanced' => array(
					'name' => __( 'YouTube advanced', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'url' => array(
							'values' => array( ),
							'default' => 'https://www.youtube.com/watch?v=ilk58Gfxcg0',
							'name' => __( 'Url', 'wp-shortcode-pro' ),
							'desc' => __( 'Youtube video URL.', 'wp-shortcode-pro' )
						),
						'playlist' => array(
							'default' => '6fNqDL8Zfmk, nF4LjluBcA4, _p8YPNTOILY',
							'name' => __( 'Playlist', 'wp-shortcode-pro' ),
							'desc' => __( 'Comma-separated list of video IDs to play.', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Player width', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Player height', 'wp-shortcode-pro' )
						),
						'controls' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( 'Hide controls', 'wp-shortcode-pro' ),
								'yes' => __( 'Show controls', 'wp-shortcode-pro' ),
								'alt' => __( 'Show controls when playback is started', 'wp-shortcode-pro' )
							),
							'default' => 'yes',
							'name' => __( 'Controls', 'wp-shortcode-pro' ),
							'desc' => __( 'Show player contollers', 'wp-shortcode-pro' )
						),
						'autohide' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( 'Do not hide controls', 'wp-shortcode-pro' ),
								'yes' => __( 'Hide all controls on mouse out', 'wp-shortcode-pro' ),
								'alt' => __( 'Hide progress bar on mouse out', 'wp-shortcode-pro' )
							),
							'default' => 'alt',
							'name' => __( 'Autohide', 'wp-shortcode-pro' ),
							'desc' => __( 'Hide video controllers.', 'wp-shortcode-pro' )
						),
						'showinfo' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show title bar', 'wp-shortcode-pro' ),
							'desc' => __( 'If you set the parameter value to NO, then the player will not display information like the video title and uploader before the video starts playing.', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Autoplay', 'wp-shortcode-pro' ),
							'desc' => __( 'Autoplay video', 'wp-shortcode-pro' )
						),
						'loop' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Loop', 'wp-shortcode-pro' ),
							'desc' => __( 'Play video again and again', 'wp-shortcode-pro' )
						),
						'rel' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Related videos', 'wp-shortcode-pro' ),
							'desc' => __( 'Show related videos when playback of the initial video ends', 'wp-shortcode-pro' )
						),
						'fs' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show full-screen button', 'wp-shortcode-pro' ),
							'desc' => __( 'Show fullscreen button', 'wp-shortcode-pro' )
						),
						'modestbranding' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => 'Modestbranding',
							'desc' => __( 'Hide Youtube logo', 'wp-shortcode-pro' )
						),
						'responsive' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Responsive', 'wp-shortcode-pro' ),
							'desc' => __( 'Make player responsive', 'wp-shortcode-pro' )
						),
						'https' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name'	=> __( 'Force HTTPS', 'wp-shortcode-pro' ),
							'desc'	=> __( 'Use HTTPS in player iframe', 'wp-shortcode-pro' )
						),
						'wmode' => array(
							'default' => 'transparent',
							'name'	=> __( 'WMode', 'wp-shortcode-pro' ),
							'desc'	=> sprintf( __( 'Here you can specify wmode value for the embed URL. %s Example values: %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>transparent</b>', '<b%value>opaque</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'YouTube video player with advanced settings', 'wp-shortcode-pro' ),
					'icon' => 'youtube',
				),
				// vimeo
				'vimeo' => array(
					'name' => __( 'Vimeo', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'url' => array(
							'default' => 'https://vimeo.com/93848479',
							'name' => __( 'Url', 'wp-shortcode-pro' ),
							'desc' => __( 'Vimeo video URL', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Player width', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Player height', 'wp-shortcode-pro' )
						),
						'responsive' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Responsive', 'wp-shortcode-pro' ),
							'desc' => __( 'Make player responsive', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Autoplay', 'wp-shortcode-pro' ),
							'desc' => __( 'Autoplay video', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Vimeo video', 'wp-shortcode-pro' ),
					'icon' => 'vimeo',
				),
				// audio
				'audio' => array(
					'name' => __( 'Audio', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Audio URL', 'wp-shortcode-pro' ),
							'desc' => __( 'Audio file URL. Supported formats: mp3, ogg', 'wp-shortcode-pro' )
						),
						'width' => array(
							'default' => '100%',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Player width. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Autoplay', 'wp-shortcode-pro' ),
							'desc' => __( 'Autoplay audio', 'wp-shortcode-pro' )
						),
						'loop' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Loop', 'wp-shortcode-pro' ),
							'desc' => __( 'Repeat audio again and again', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Custom audio player', 'wp-shortcode-pro' ),
					'icon' => 'play-circle',
				),
				// video
				'video' => array(
					'name' => __( 'Video', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Video URL', 'wp-shortcode-pro' ),
							'desc' => __( 'Url to mp4/flv video-file', 'wp-shortcode-pro' )
						),
						'image' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Url to image, that will be shown before playback', 'wp-shortcode-pro' )
						),
						'title' => array(
							'default' => 'Player title',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Player title', 'wp-shortcode-pro' )
						),
						'width' => array(
							'default' => '100%',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Player width. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'wp-shortcode-pro' )
						),
						'height' => array(
							'default' => '',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Player height. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'wp-shortcode-pro' )
						),
						'controls' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Controls', 'wp-shortcode-pro' ),
							'desc' => __( 'Show player controllers', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Autoplay', 'wp-shortcode-pro' ),
							'desc' => __( 'Autoplay video', 'wp-shortcode-pro' )
						),
						'loop' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Loop', 'wp-shortcode-pro' ),
							'desc' => __( 'Repeat video again and again', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Custom video player', 'wp-shortcode-pro' ),
					'icon' => 'play-circle',
				),
				// calltoaction
				'calltoaction' => array(
					'name' => __( 'Call To Action', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'style-1' => __( 'Style 1', 'wp-shortcode-pro' ),
								'style-2' => __( 'Style 2', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'CTA Style', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'wp-shortcode-pro' ),
								'all' => __( 'All', 'wp-shortcode-pro' ),
								'top' => __( 'Top', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
								'bottom' => __( 'Bottom', 'wp-shortcode-pro' ),
								'left' => __( 'Left', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Border', 'wp-shortcode-pro' ),
							'desc' => __( 'CTA Border', 'wp-shortcode-pro' )
						),
						'title' => array(
							'default' => 'Call To Action Title',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Call To Action Title', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Align box', 'wp-shortcode-pro' )
						),
						'background_image' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Background Image', 'wp-shortcode-pro' ),
							'desc' => __( 'URL to image', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#f4f4f7',
							'name' => __( 'Background Color', 'wp-shortcode-pro' ),
							'desc' => __( 'CTA background color', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#535353',
							'name' => __( 'Color', 'wp-shortcode-pro' ),
							'desc' => __( 'CTA text color', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'CTA Radius', 'wp-shortcode-pro' )
						),
						'button_text' => array(
							'default'	=> 'Download',
							'name'		=> __( 'Button Text', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Button Text', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default'	=> get_option( 'home' ),
							'name'		=> __( 'Link', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Button link', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'wp-shortcode-pro' ),
							'desc' => __( 'Link target', 'wp-shortcode-pro' )
						),
						'button_background' => array(
							'type' => 'color',
							'default' => '#6aa2ff',
							'name' => __( 'Button Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Button Background color', 'wp-shortcode-pro' )
						),
						'button_color' => array(
							'type' => 'color',
							'default' => '#fff',
							'name' => __( 'Button Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Button color', 'wp-shortcode-pro' )
						),
						'button_radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Button Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Button Radius', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
					'desc' => __( 'Call To Action', 'wp-shortcode-pro' ),
					'icon' => 'tags',
				),
				// counter
				'counter' => array(
					'name' => __( 'Counter', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'width' => array(
							'default' => '250px',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Counter box width (in pixels, viewport-width or percents). %s Example values: %s, %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>100vw</b>', '<b%value>90%</b>', '<b%value>auto</b>' )
						),
						'height' => array(
							'default' => '150px',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Counter box height (in pixels, viewport-height or percents). %s Example values: %s, %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>100vh</b>', '<b%value>90%</b>', '<b%value>auto</b>' )
						),
						'count_start' => array(
							'type' => 'text',
							'default'	=> 0,
							'name'		=> __( 'Start', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Count Start', 'wp-shortcode-pro' )
						),
						'count_end' => array(
							'type' => 'text',
							'default'	=> 450000,
							'name'		=> __( 'End', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Count End', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'default'	=> 'center',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Align count', 'wp-shortcode-pro' )
						),
						'count_color' => array(
							'type' => 'color',
							'default' => '#23395b',
							'name' => __( 'Count Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Count Color', 'wp-shortcode-pro' )
						),
						'text_color' => array(
							'type'		=> 'color',
							'default'	=> '#00001f',
							'name'		=> __( 'Count Text Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Count Text Color', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#f4f4f7',
							'name'		=> __( 'Background Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Background Color', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '2px solid #e7eaed',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Counter border', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 5,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Count Radius', 'wp-shortcode-pro' )
						),
						'prefix' => array(
							'type'		=> 'text',
							'default'	=> '',
							'name'		=> __( 'Prefix', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Count prefix', 'wp-shortcode-pro' )
						),
						'suffix' => array(
							'type'		=> 'text',
							'default'	=> '',
							'name'		=> __( 'Suffix', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Count suffix', 'wp-shortcode-pro' )
						),
						'separator' => array(
							'type'		=> 'text',
							'default'	=> ',',
							'name'		=> __( 'Separator', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Thousand separator', 'wp-shortcode-pro' )
						),
						'decimal' => array(
							'type'		=> 'text',
							'default'	=> '',
							'name'		=> __( 'Decimal', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Decimal separator', 'wp-shortcode-pro' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0.1,
							'max' => 10,
							'step' => 0.1,
							'default' => 3,
							'name' => __( 'Duration', 'wp-shortcode-pro' ),
							'desc' => __( 'Counter duration', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array(
								'small' => __( 'Small', 'wp-shortcode-pro' ),
								'medium' => __( 'Medium', 'wp-shortcode-pro' ),
								'large' => __( 'Large', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Counter Size', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Price', 'wp-shortcode-pro' ),
					'desc' => __( 'Counter', 'wp-shortcode-pro' ),
					'icon' => 'sort-numeric-asc',
				),
				// CountDown
				'countdown' => array(
					'name' => __( 'CountDown', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'standard'  => __( 'Standard', 'wp-shortcode-pro' ),
								'classic' => __( 'Classic', 'wp-shortcode-pro' )
							),
							'default' => 'standard',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'CountDown Style', 'wp-shortcode-pro' )
						),
						'date' => array(
							'type'		=> 'date',
							'default'	=> '2018/7/13',
							'name'		=> __( 'Date', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Count Date', 'wp-shortcode-pro' )
						),
						'time' => array(
							'type' => 'time',
							'default'	=> '11:35:58',
							'name'		=> __( 'Time', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Count Time', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Align Content', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 20,
							'max' => 80,
							'step' => 1,
							'default' => 40,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Text Size', 'wp-shortcode-pro' )
						),
						'count_color' => array(
							'type' => 'color',
							'default' => '#000000',
							'name' => __( 'Count Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Count Color', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#eee',
							'name'		=> __( 'Background Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Background Color', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'CountDown border', 'wp-shortcode-pro' ),
						),
						'text_color' => array(
							'type' => 'color',
							'default' => '',
							'name' => __( 'Text Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Text Color', 'wp-shortcode-pro' ),
						),
						'text_bg' => array(
							'type'		=> 'color',
							'default'	=> '',
							'name'		=> __( 'Text Background Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Text Background Color', 'wp-shortcode-pro' ),
						),
						'padding' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 60,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Padding', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Countdown Box Padding', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'This offer has expired!', 'wp-shortcode-pro' ),
					'desc' => __( 'CountDown', 'wp-shortcode-pro' ),
					'icon' => 'sort-numeric-desc',
				),
				// testimonial
				'testimonial' => array(
					'name' => __( 'Testimonial', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'style-1' => __( 'Style 1', 'wp-shortcode-pro' ),
								'style-2' => __( 'Style 2', 'wp-shortcode-pro' ),
								'style-3' => __( 'Style 3', 'wp-shortcode-pro' ),
								'style-4' => __( 'Style 4', 'wp-shortcode-pro' ),
								'style-5' => __( 'Style 5', 'wp-shortcode-pro' ),
							),
							'default' => 'style-2',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Testimonial Style', 'wp-shortcode-pro' ),
						),
						'name' => array(
							'type' => 'text',
							'default'	=> 'John',
							'name'		=> __( 'Name', 'wp-shortcode-pro' ),
							'desc' => __( 'Testimonial Name', 'wp-shortcode-pro' ),
						),
						'designation' => array(
							'default'	=> 'Developer',
							'name'		=> __( 'Designation', 'wp-shortcode-pro' ),
							'desc' => __( 'Testimonial Designation', 'wp-shortcode-pro' ),
						),
						'company' => array(
							'default'	=> 'MyThemeShop Pte Ltd',
							'name'		=> __( 'Company', 'wp-shortcode-pro' ),
							'desc' => __( 'Testimonial Company Name', 'wp-shortcode-pro' ),
						),
						'url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'Url', 'wp-shortcode-pro' ),
							'desc' => __( 'Testimonial Website URL', 'wp-shortcode-pro' ),
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 5,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Border radius', 'wp-shortcode-pro' )
						),
						'image' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Testimonial Image', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
					'desc' => __( 'Testimonial', 'wp-shortcode-pro' ),
					'icon' => 'quote-left',
				),
				// progress-bar
				'progress_bar' => array(
					'name' => __( 'Progress Bar', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default'	=> __( 'Default', 'wp-shortcode-pro' ),
								'striped'	=> __( 'Striped', 'wp-shortcode-pro' ),
								'animated'	=> __( 'Animated', 'wp-shortcode-pro' ),
								'pie'		=> __( 'Pie', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Progress Bar style', 'wp-shortcode-pro' )
						),
						'percent' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 100,
							'step' => 0.1,
							'default' => 50,
							'name' => __( 'Percent', 'wp-shortcode-pro' )
						),
						'text' => array(
							'default' => 'WP Shortcode Pro',
							'name' => __( 'Text', 'wp-shortcode-pro' ),
							'desc' => __( 'Progress bar text.', 'wp-shortcode-pro' )
						),
						'text_position' => array(
							'type' => 'select',
							'default' => 'below',
							'values' => array(
								'over' => __( 'Over the bar', 'wp-shortcode-pro' ),
								'below' => __( 'Below the bar', 'wp-shortcode-pro' ),
								'above' => __( 'Above the bar', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Text position', 'wp-shortcode-pro' )
						),
						'show_percent' => array(
							'type' => 'select',
							'values' => array(
								'yes' => __( 'Yes', 'wp-shortcode-pro' ),
								'no' => __( 'No', 'wp-shortcode-pro' )
							),
							'default' => 'yes',
							'name' => __( 'Show Percent', 'wp-shortcode-pro' ),
							'desc' => __( 'Show Percent', 'wp-shortcode-pro' )
						),
						'fill_color' => array(
							'type'		=> 'color',
							'default'	=> '#f2f2f2',
							'name'		=> __( 'Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Fill Color', 'wp-shortcode-pro' )
						),
						'bar_color' => array(
							'type'		=> 'color',
							'default'	=> '#1ABC9C',
							'name'		=> __( 'Active Bar Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Progress Bar Active Color', 'wp-shortcode-pro' )
						),
						'text_color' => array(
							'type'		=> 'color',
							'default'	=> '#1ABC9C',
							'name'		=> __( 'Text Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Progress Bar Text Color', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type'	=> 'slider',
							'min'	=> 1,
							'max'	=> 30,
							'step'	=> 1,
							'default'=> 8,
							'name'	=> __( 'Height', 'wp-shortcode-pro' ),
							'desc'	=> __( 'Progress bar height', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 5,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Border Radius', 'wp-shortcode-pro' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 10,
							'step' => 0.1,
							'default' => 1.5,
							'name' => __( 'Duration', 'wp-shortcode-pro' ),
							'desc' => __( 'Animation Duration', 'wp-shortcode-pro' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 10,
							'step' => 0.1,
							'default' => 0.5,
							'name' => __( 'Delay', 'wp-shortcode-pro' ),
							'desc' => __( 'Animation Delay', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Progress Bar', 'wp-shortcode-pro' ),
					'desc' => __( 'Animated Progress Bar', 'wp-shortcode-pro' ),
					'icon' => 'bars',
				),
				// timeline
				'timeline' => array(
					'name' => __( 'Timeline', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'standard'	=> __( 'Standard', 'wp-shortcode-pro' ),
								'classic'		=> __( 'Classic', 'wp-shortcode-pro' )
							),
							'default' => 'standard',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Timeline Style', 'wp-shortcode-pro' ),
						),
						'category' => array(
							'type' => 'term',
							'name' => __( 'Category', 'wp-shortcode-pro' ),
							'desc' => __( 'Select category to show posts from', 'wp-shortcode-pro' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 10,
							'name' => __( 'Limit', 'wp-shortcode-pro' ),
							'desc' => __( 'Maximum number of posts', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'default' => 'left',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Align Timeline', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Timeline', 'wp-shortcode-pro' ),
					'icon' => 'timeline',
				),
				// modal
				'modal' => array(
					'name' => __( 'Modal', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'effect' => array(
							'type' => 'select',
							'values' => array( '', 'Fade in & Scale', 'Slide in (right)', 'Slide in (bottom)', 'Newspaper', 'Fall', 'Side Fall', 'Sticky Up', '3D Flip (horizontal)', '3D Flip (vertical)', '3D Sign', 'Super Scaled', 'Just Me', '3D Slit', '3D Rotate Bottom', '3D Rotate In Left', 'Blur', 'Let me in', 'Make way!', 'Slip from top' ),
							'default' => 1,
							'name' => __( 'Effect', 'wp-shortcode-pro' ),
							'desc' => __( 'Modal animation effect.', 'wp-shortcode-pro' )
						),
						'button_text' => array(
							'name' => __( 'Button Text', 'wp-shortcode-pro' ),
							'default' => __( 'Trigger Modal', 'wp-shortcode-pro' ),
							'desc' => __( 'Modal button text,', 'wp-shortcode-pro' ),
						),
						'close_button' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show Close Button', 'wp-shortcode-pro' ),
							'desc' => __( 'Show close button in modal?', 'wp-shortcode-pro' ),
						),
						'modal_title' => array(
							'default' => 'Modal Title',
							'name' => __( 'Modal Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Modal title.', 'wp-shortcode-pro' )
						),
						'title_color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Title Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Modal title color.', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Modal color.', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#1abc9c',
							'name'		=> __( 'Background Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Modal background color.', 'wp-shortcode-pro' )
						),
						'overlay_background' => array(
							'type'		=> 'color',
							'default'	=> 'rgba(0, 0, 0,0.3)',
							'name'		=> __( 'Overlay background', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Overlay background color.', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type'		=> 'shadow',
							'default'	=> '0px 0px 5px #8e8e8e',
							'name'		=> __( 'Shadow', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Modal box shadow.', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '1px solid #1abc9c',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Modal border.', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Modal corner radius.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Modal', 'wp-shortcode-pro' ),
					'icon' => 'square',
				),
				// social-share
				'social_share' => array(
					'name' => __( 'Social Share', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'services' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => array(
								'facebook' => __( 'Facebook', 'wp-shortcode-pro' ),
								'twitter' => __( 'Twitter', 'wp-shortcode-pro' ),
								'google-plus' => __( 'Google Plus', 'wp-shortcode-pro' ),
								'linkedin' => __( 'Linkedin', 'wp-shortcode-pro' ),
								'pinterest' => __( 'Pinterest', 'wp-shortcode-pro' ),
								'stumbleupon' => __( 'StumbleUpon', 'wp-shortcode-pro' ),
								'tumblr' => __( 'Tumbler', 'wp-shortcode-pro' ),
								'telegram' => __( 'Telegram', 'wp-shortcode-pro' )
							),
							'name' => __( 'Social Share', 'wp-shortcode-pro' ),
							'desc' => __( 'Select social share services.', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Social Share', 'wp-shortcode-pro' ),
					'icon' => 'share-nodes',
				),
				// Section
				'section' => array(
					'name' => __( 'Section', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'fields' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'full-boxed' => __( 'Full Boxed', 'wp-shortcode-pro' ),
								'full' => __( 'Full Width', 'wp-shortcode-pro' )
							),
							'default' => 'full-boxed',
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Section size.', 'wp-shortcode-pro' )
						),
						'height' => array(
							'default' => 'auto',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Section Height. You can specify height in percents and section will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>, <b%value>100vh</b>', 'wp-shortcode-pro' )
						),
						'background_color' => array(
							'type'		=> 'color',
							'default'	=> '#23afaf',
							'name'		=> __( 'Background Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Section background color.', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Background Image/Video', 'wp-shortcode-pro' ),
							'desc' => __( 'Section background image or video. Leave blank to use color.', 'wp-shortcode-pro' )
						),
						'background_size' => array(
							'type' => 'select',
							'values' => array(
								'cover' => __( 'Cover', 'wp-shortcode-pro' ),
								'contain' => __( 'Contain', 'wp-shortcode-pro' )
							),
							'default' => 'cover',
							'name' => __( 'Background Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Background image size if image is selected.', 'wp-shortcode-pro' )
						),
						'background_repeat' => array(
							'type' => 'select',
							'values' => array(
								'no-repeat' => __( 'No Repeat', 'wp-shortcode-pro' ),
								'repeat' => __( 'Repeat', 'wp-shortcode-pro' ),
								'repeat-x' => __( 'Repeat-X', 'wp-shortcode-pro' ),
								'repeat-y' => __( 'Repeat-Y', 'wp-shortcode-pro' )
							),
							'default' => 'no-repeat',
							'name' => __( 'Background Repeat', 'wp-shortcode-pro' ),
							'desc' => __( 'Repeat background image.', 'wp-shortcode-pro' )
						),
						'background_mode' => array(
							'type' => 'select',
							'values' => array(
								'fixed' => __( 'Fixed', 'wp-shortcode-pro' ),
								'parallax' => __( 'Parallax', 'wp-shortcode-pro' )
							),
							'default' => 'fixed',
							'name' => __( 'Background Mode', 'wp-shortcode-pro' ),
							'desc' => __( 'Select section mode.', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Section align.', 'wp-shortcode-pro' )
						),
						'align_content_vertical' => array(
							'type' => 'select',
							'values' => array(
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'top' => __( 'Top', 'wp-shortcode-pro' ),
								'bottom' => __( 'Bottom', 'wp-shortcode-pro' )
							),
							'default' => 'center',
							'name' => __( 'Vertical align', 'wp-shortcode-pro' ),
							'desc' => __( 'Vertical align section.', 'wp-shortcode-pro' )
						),
						'content_width' => array(
							'default' => '100%',
							'name' => __( 'Content Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Inner content width. You can specify width in percents and section will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'wp-shortcode-pro' )
						),
						'content_bg' => array(
							'type'		=> 'color',
							'default'	=> '#56afaf',
							'name'		=> __( 'Content Background', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Section content background. Leave blank to use section background.', 'wp-shortcode-pro' )
						),
						'content_color' => array(
							'type'		=> 'color',
							'default'	=> '#ededed',
							'name'		=> __( 'Content Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Section content color.', 'wp-shortcode-pro' )
						),
						'padding' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 1,
							'default' => 30,
							'name' => __( 'Padding', 'wp-shortcode-pro' ),
							'desc' => __( 'Thickness of a padding (pixels) b/w section and inner content', 'wp-shortcode-pro' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 100,
							'step' => 1,
							'default' => 15,
							'name' => __( 'Margin', 'wp-shortcode-pro' ),
							'desc' => __( 'Thickness of a margin', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'desc' => __( 'Section', 'wp-shortcode-pro' ),
					'icon' => 'newspaper',
				),
				// Photo Panel
				'photo_panel' => array(
					'name' => __( 'Photo Panel', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'media',
					'fields' => array(
						'photo' => array(
							'type' => 'upload',
							'default' => 'http://via.placeholder.com/600x300?text=demo',
							'name' => __( 'Photo', 'wp-shortcode-pro' ),
							'desc' => __( 'Panel image.', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#aeaeae',
							'name'		=> __( 'Background', 'wp-shortcode-pro' ),
							'desc' => __( 'Panel background.', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Panel text color.', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Align panel', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Panel radius.', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type' => 'shadow',
							'default' => '0px 0px 10px #aeaeae',
							'name' => __( 'Shadow', 'wp-shortcode-pro' ),
							'desc' => __( 'Panel shadow', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '1px solid #bababa',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Panel border', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'URL', 'wp-shortcode-pro' ),
							'desc' => __( 'Panel link', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __('Image Caption', 'wp-shortcode-pro'),
					'desc' => __( 'Photo Panel', 'wp-shortcode-pro' ),
					'icon' => 'image',
				),
				// Splash Screen
				'splash_screen' => array(
					'name' => __( 'Splash Screen', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'title' => array(
							'default' => 'Splash Screen Title',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Splash screen title', 'wp-shortcode-pro' )
						),
						'width' => array(
							'default' => '500px',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Splash screen width (in pixels, viewport-width or percents). %s Example values: %s, %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>100vw</b>', '<b%value>90%</b>', '<b%value>auto</b>' )
						),
						'height' => array(
							'default' => '500px',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Splash screen height (in pixels, viewport-height or percents). %s Example values: %s, %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>100vh</b>', '<b%value>90%</b>', '<b%value>auto</b>' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Splash screen radius', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type' => 'shadow',
							'default' => '0px 0px 15px #4e8abf',
							'name' => __( 'Shadow', 'wp-shortcode-pro' ),
							'desc' => __( 'Splash screen shadow', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '1px solid #4e8abf',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Splash screen border', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#2575ed',
							'name'		=> __( 'Popup Background', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Splash Screen background color', 'wp-shortcode-pro' )
						),
						'background_image' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Background Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Splash Screen background image', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Popup Color', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Splash Screen content color', 'wp-shortcode-pro' )
						),
						'overlay_bg' => array(
							'type'		=> 'color',
							'default'	=> '#7a7a7a',
							'name'		=> __( 'Overlay Background', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Overlay background color', 'wp-shortcode-pro' )
						),
						'opacity' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 100,
							'step' => 1,
							'default' => 40,
							'name' => __( 'Opacity', 'wp-shortcode-pro' ),
							'desc' => __( 'Overlay opacity', 'wp-shortcode-pro' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'wp-shortcode-pro' ),
							'desc' => __( 'Popup delay (seconds)', 'wp-shortcode-pro' )
						),
						'close' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Close', 'wp-shortcode-pro' ),
							'desc' => __( 'Show close button?', 'wp-shortcode-pro' ),
						),
						'esc' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Escape', 'wp-shortcode-pro' ),
							'desc' => __( 'Close when escape key is hit?', 'wp-shortcode-pro' )
						),
						'onclick' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'OnClick', 'wp-shortcode-pro' ),
							'desc' => __( 'Close on click?', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Splash Screen', 'wp-shortcode-pro' ),
					'icon' => 'bolt',
				),
				// Exit Popup
				'exit_popup' => array(
					'name' => __( 'Exit Popup', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'title' => array(
							'default' => 'Exit Popup Title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'width' => array(
							'default' => '500px',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels, viewport-width or percents). %s Example values: %s, %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>100vw</b>', '<b%value>90%</b>', '<b%value>auto</b>' )
						),
						'height' => array(
							'default' => '500px',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content height (in pixels, viewport-height or percents). %s Example values: %s, %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300px</b>', '<b%value>100vh</b>', '<b%value>90%</b>', '<b%value>auto</b>' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 0,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Exit Popup radius', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type' => 'shadow',
							'default' => '0px 0px 15px #333333',
							'name' => __( 'Shadow', 'wp-shortcode-pro' ),
							'desc' => __( 'Exit-popup shadow', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '1px solid #31c2d8',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Exit-popup border', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#31c2d8',
							'name'		=> __( 'Popup Background', 'wp-shortcode-pro' )
						),
						'background_image' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Background Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Popup Background Image', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Popup Color', 'wp-shortcode-pro' )
						),
						'overlay_bg' => array(
							'type'		=> 'color',
							'default'	=> '#aeaeae',
							'name'		=> __( 'Overlay Background', 'wp-shortcode-pro' )
						),
						'opacity' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 100,
							'step' => 1,
							'default' => 40,
							'name' => __( 'Opacity', 'wp-shortcode-pro' ),
							'desc' => __( 'Overlay Opacity', 'wp-shortcode-pro' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'wp-shortcode-pro' ),
							'desc' => __( 'Popup delay (seconds)', 'wp-shortcode-pro' )
						),
						'close' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Close', 'wp-shortcode-pro' ),
							'desc' => __( 'Show close button?', 'wp-shortcode-pro' ),
						),
						'esc' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Escape', 'wp-shortcode-pro' ),
							'desc' => __( 'Close when escape key is hit?', 'wp-shortcode-pro' )
						),
						'onclick' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'OnClick', 'wp-shortcode-pro' ),
							'desc' => __( 'Close on click?', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'Exit Popup', 'wp-shortcode-pro' ),
					'icon' => 'sign-out',
				),
				// Exit Bar
				'exit_bar' => array(
					'name' => __( 'Exit Bar', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'title' => array(
							'default' => 'Exit Bar Title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#31c2d8',
							'name'		=> __( 'Background', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Color', 'wp-shortcode-pro' )
						),
						'close' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Close', 'wp-shortcode-pro' ),
							'desc' => __( 'Show close button?', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et',
					'desc' => __( 'Exit Bar', 'wp-shortcode-pro' ),
					'icon' => 'sign-out',
				),
				// Image Compare
				'compare_image' => array(
					'name' => __( 'Compare Image', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'orientation' => array(
							'type' => 'select',
							'values' => array(
								'horizontal'	=> __( 'Horizontal', 'wp-shortcode-pro' ),
								'vertical'		=> __( 'Vertical', 'wp-shortcode-pro' )
							),
							'default' => 'horizontal',
							'name' => __( 'Orientation', 'wp-shortcode-pro' )
						),
						'before_label' => array(
							'default' => 'Before',
							'name' => __( 'Before Label', 'wp-shortcode-pro' )
						),
						'before_image' => array(
							'type' => 'upload',
							'default' => 'http://via.placeholder.com/400x200?text=Before',
							'name' => __( 'Before Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Before image URL', 'wp-shortcode-pro' )
						),
						'after_label' => array(
							'default' => 'After',
							'name' => __( 'After Label', 'wp-shortcode-pro' )
						),
						'after_image' => array(
							'type' => 'upload',
							'default' => 'http://via.placeholder.com/400x200?text=After',
							'name' => __( 'After Image', 'wp-shortcode-pro' ),
							'desc' => __( 'After image URL', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Compare Image', 'wp-shortcode-pro' ),
					'icon' => 'file-image',
				),
				// Icon
				'icon' => array(
					'name' => __( 'Icon', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => 'cube',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#49ea25',
							'name'		=> __( 'Icon Background', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Icon Color', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon size', 'wp-shortcode-pro' )
						),
						'padding' => array(
							'type' => 'slider',
							'min' => 5,
							'max' => 100,
							'step' => 1,
							'default' => 10,
							'name' => __( 'Padding', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon padding', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 100,
							'step' => 1,
							'default' => 5,
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon radius', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Icon', 'wp-shortcode-pro' ),
					'icon' => 'font-awesome',
				),
				// Icon List
				'icon_list' => array(
					'name' => __( 'Icon List', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => 'wechat',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
						),
						'title' => array(
							'default' => 'Lorem Ipsum Dolar',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'top-left' => __( 'Top Left', 'wp-shortcode-pro' ),
								'top-right' => __( 'Top Right', 'wp-shortcode-pro' ),
								'title' => __( 'Align to Title', 'wp-shortcode-pro' ),
							),
							'default' => 'top-left',
							'name' => __( 'Align', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '',
							'name'		=> __( 'Icon Background', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#35ce8d',
							'name'		=> __( 'Icon Color', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type'		=> 'shadow',
							'default'	=> '',
							'name'		=> __( 'Shadow', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Modal shadow', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'List border', 'wp-shortcode-pro' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 100,
							'step' => 1,
							'default' => '',
							'name' => __( 'Radius', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon radius', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'URL', 'wp-shortcode-pro' ),
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 100,
							'step' => 1,
							'default' => 50,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Icon size', 'wp-shortcode-pro' )
						),
						'animate' => array(
							'type' => 'select',
							'values' => array(
										'' => __('None', 'wp-shortcode-pro'),
										'fade' => __('Fade', 'wp-shortcode-pro'),
										'wobble' => __('Wobble', 'wp-shortcode-pro'),
										'push' => __('Push', 'wp-shortcode-pro'),
										'pop' => __('Pop', 'wp-shortcode-pro'),
										'buzzout' => __('BuzzOut', 'wp-shortcode-pro'),
										'spin' => __('Spin', 'wp-shortcode-pro'),
									),
							'default' => '',
							'name' => __( 'Animate In', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
					'desc' => __( 'Icon List', 'wp-shortcode-pro' ),
					'icon' => 'font-awesome',
				),
				// FlyOut
				'flyout' => array(
					'name' => __( 'Flyout', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'position' => array(
							'type' => 'select',
							'values' => array(
								'top-left' => __( 'Top Left', 'wp-shortcode-pro' ),
								'top-middle' => __( 'Top Middle', 'wp-shortcode-pro' ),
								'top-right' => __( 'Top Right', 'wp-shortcode-pro' ),
								'center-left' => __( 'Center Left', 'wp-shortcode-pro' ),
								'center-middle' => __( 'Center Middle', 'wp-shortcode-pro' ),
								'center-right' => __( 'Center Right', 'wp-shortcode-pro' ),
								'bottom-left' => __( 'Bottom Left', 'wp-shortcode-pro' ),
								'bottom-middle' => __( 'Bottom Middle', 'wp-shortcode-pro' ),
								'bottom-right' => __( 'Bottom Right', 'wp-shortcode-pro' ),
							),
							'default' => 'bottom-right',
							'name' => __( 'Ad Position', 'wp-shortcode-pro' )
						),
						'dimensions' => array(
							'default' => '250x250',
							'name' => __( 'Dimensions', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Ad Dimensions (pixels). %s Example values: %s, %s, %s, %s, %s', 'wp-shortcode-pro' ), ' ', '<b%value>234x60</b>', '<b%value>728x90</b>', '<b%value>120x600</b>', '<b%value>468x60</b>', '<b%value>88x31</b>' )
						),
						'transitionin' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'slideInLeft',
							'name' => __( 'Animate In', 'wp-shortcode-pro' )
						),
						'transitionout' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'slideOutRight',
							'name' => __( 'Animate Out', 'wp-shortcode-pro' )
						),
						'enable_close' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show Close Button', 'wp-shortcode-pro' )
						),
						'close_style' => array(
							'type' => 'select',
							'values' => array(
								'circle' => __( 'Circle', 'wp-shortcode-pro' ),
								'circle-text' => __( 'Circle with text', 'wp-shortcode-pro' ),
								'box' => __( 'Box', 'wp-shortcode-pro' ),
								'text' => __( 'Text', 'wp-shortcode-pro' ),
							),
							'default' => 'circle',
							'name' => __( 'Close Button Style', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#ddd',
							'name'		=> __( 'Background', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#444',
							'name'		=> __( 'Color', 'wp-shortcode-pro' )
						),
						'shadow' => array(
							'type'		=> 'shadow',
							'default'	=> '0 0 5px #ddd',
							'name'		=> __( 'Shadow', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Modal shadow', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '1px solid #ddd',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Modal border', 'wp-shortcode-pro' )
						),
						'url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'URL', 'wp-shortcode-pro' ),
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self'	=> __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank'	=> __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default'=> 'blank',
							'name'	=> __( 'Link target', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
						),
					),
					'content' => '<img src="http://via.placeholder.com/1100x1100&text=Adv%20image" />',
					'desc' => __( 'Flyout', 'wp-shortcode-pro' ),
					'icon' => 'adn',
				),
				// Slider
				'slider' => array(
					'name' => __( 'Slider', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'gallery',
					'fields' => array(
						'source' => array(
							'type'		=> 'image_source',
							'default'	=> 'none',
							'name'		=> __( 'Source', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'wp-shortcode-pro' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'wp-shortcode-pro' ),
							'desc' => __( 'Maximum number of images (for recent posts, category and custom taxonomy)', 'wp-shortcode-pro' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'			=> __( 'None', 'wp-shortcode-pro' ),
								'image'			=> __( 'Full-size image', 'wp-shortcode-pro' ),
								'lightbox'		=> __( 'Lightbox', 'wp-shortcode-pro' ),
								'post'			=> __( 'Post permalink', 'wp-shortcode-pro' ),
								'attachment'	=> __( 'Attachment link', 'wp-shortcode-pro' )
							),
							'default'	=> 'none',
							'name'		=> __( 'Link', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Image link', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'wp-shortcode-pro' ),
							'desc' => __( 'Links target', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Slider width (pixels)', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Slider height (pixels)', 'wp-shortcode-pro' )
						),
						'title' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show titles', 'wp-shortcode-pro' ),
							'desc' => __( 'Display slide titles', 'wp-shortcode-pro' )
						),
						'arrows' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Arrows', 'wp-shortcode-pro' ),
							'desc' => __( 'Show arrows', 'wp-shortcode-pro' )
						),
						'pager' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Pagination', 'wp-shortcode-pro' ),
							'desc' => __( 'Show pagination', 'wp-shortcode-pro' )
						),
						'gallery' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Gallery', 'wp-shortcode-pro' ),
							'desc' => __( 'Show image thumbnail as pagination', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'wp-shortcode-pro' ),
							'desc' => __( 'Slide interval. Set to 0 to disable autoplay', 'wp-shortcode-pro' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'wp-shortcode-pro' ),
							'desc' => __( 'Animation speed', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Customizable image slider', 'wp-shortcode-pro' ),
					'icon' => 'picture',
				),

				// Content-Slide
				'content_slide' => array(),
				'content_slider' => array(
					'name' => __( 'Content Slider', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'light' => __( 'Light', 'wp-shortcode-pro' ),
								'dark' => __( 'Dark', 'wp-shortcode-pro' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'wp-shortcode-pro' )
						),
						'animatein' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'slideInLeft',
							'name' => __( 'Animate In', 'wp-shortcode-pro' )
						),
						'animateout' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'slideOutRight',
							'name' => __( 'Animate Out', 'wp-shortcode-pro' )
						),
						'autoplay' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Autoplay', 'wp-shortcode-pro' )
						),
						'arrows' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Arrows', 'wp-shortcode-pro' )
						),
						'arrow_position' => array(
							'type' => 'select',
							'values' => array(
								'center'		=> __( 'Center', 'wp-shortcode-pro' ),
								'top-left'		=> __( 'Top Left', 'wp-shortcode-pro' ),
								'top-middle'	=> __( 'Top Center', 'wp-shortcode-pro' ),
								'top-right'		=> __( 'Top Right', 'wp-shortcode-pro' ),
								'bottom-left'	=> __( 'Bottom Left', 'wp-shortcode-pro' ),
								'bottom-middle'	=> __( 'Bottom Center', 'wp-shortcode-pro' ),
								'bottom-right'	=> __( 'Bottom Right', 'wp-shortcode-pro' )
							),
							'default' => 'center',
							'name' => __( 'Arrow Position', 'wp-shortcode-pro' )
						),
						'pagination' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Pagination', 'wp-shortcode-pro' )
						),
						'pagination_position' => array(
							'type' => 'select',
							'values' => array(
								'top-left'		=> __( 'Top Left', 'wp-shortcode-pro' ),
								'top-middle'	=> __( 'Top Center', 'wp-shortcode-pro' ),
								'top-right'		=> __( 'Top Right', 'wp-shortcode-pro' ),
								'bottom-left'	=> __( 'Bottom Left', 'wp-shortcode-pro' ),
								'bottom-middle'	=> __( 'Bottom Center', 'wp-shortcode-pro' ),
								'bottom-right'	=> __( 'Bottom Right', 'wp-shortcode-pro' )
							),
							'default' => 'bottom-middle',
							'name' => __( 'Pagination Position', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
						'content_slide_start' => array(
							'type'		=> 'text',
							'class'		=> 'wps-hidden wps-shortcode-start wps-child-shortcode-wrapper',
							'default'	=>	'content_slide',
							'name'		=> __( 'Content Slide', 'wp-shortcode-pro' )
						),
						'slide_content' => array(
							'type'		=> 'textarea',
							'class'		=> 'wps-child-content',
							'default'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
							'name'		=> __( 'Content', 'wp-shortcode-pro' )
						),
						'content_slide_end' => array(
							'type'		=> 'text',
							'class'		=> 'wps-hidden wps-shortcode-end wps-child-shortcode-wrapper',
							'default'	=>	'content_slide',
							'name'		=> __( 'Content Slide', 'wp-shortcode-pro' )
						),
					),
					'content' => array(
						'class'	=> 'wps-hidden'
					),
					'desc' => __( 'Content Slider', 'wp-shortcode-pro' ),
					'icon' => 'sliders',
				),

				// custom_gallery
				'custom_gallery' => array(
					'name' => __( 'Gallery', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'gallery',
					'fields' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'wp-shortcode-pro' ),
							'desc'    => __( 'Images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'wp-shortcode-pro' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'wp-shortcode-pro' ),
							'desc' => __( 'Maximum number of images (for recent posts, category and custom taxonomy)', 'wp-shortcode-pro' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'wp-shortcode-pro' ),
								'image'      => __( 'Full-size image', 'wp-shortcode-pro' ),
								'lightbox'   => __( 'Lightbox', 'wp-shortcode-pro' ),
								'attachment' => __( 'Attachment page', 'wp-shortcode-pro' ),
								'post'       => __( 'Post permalink', 'wp-shortcode-pro' )
							),
							'default' => 'none',
							'name' => __( 'Link', 'wp-shortcode-pro' ),
							'desc' => __( 'Image link', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Link target', 'wp-shortcode-pro' ),
							'desc' => __( 'Link target', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Single item width (pixels)', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Single item height (pixels)', 'wp-shortcode-pro' )
						),
						'title' => array(
							'type' => 'select',
							'values' => array(
								'never' => __( 'Never', 'wp-shortcode-pro' ),
								'hover' => __( 'On mouse over', 'wp-shortcode-pro' ),
								'always' => __( 'Always', 'wp-shortcode-pro' )
							),
							'default' => 'hover',
							'name' => __( 'Show titles', 'wp-shortcode-pro' ),
							'desc' => __( 'Title display mode', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Customizable image gallery', 'wp-shortcode-pro' ),
					'icon' => 'images',
				),

				// FlipBox
				'flip_front' => array(),
				'flip_back' => array(),
				'flip_box' => array(
					'name' => __( 'Flip Box', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'animation' => array(
							'type' => 'select',
							'values' => array(
								'basic'					=> __( 'Default', 'wp-shortcode-pro' ),
								'flip_left'				=> __( 'Left - Right', 'wp-shortcode-pro' ),
								'flip_right'			=> __( 'Right - Left', 'wp-shortcode-pro' ),
								'flip_top'				=> __( 'Top - Bottom', 'wp-shortcode-pro' ),
								'flip_bottom'			=> __( 'Bottom - Top', 'wp-shortcode-pro' ),
								'horizontal_flip_right'	=> __( 'Horizontal - Right', 'wp-shortcode-pro' ),
								'vertical_flip_bottom'	=> __( 'Vertical - Bottom', 'wp-shortcode-pro' ),
								'vertical_flip_top'		=> __( 'Vertical - Top', 'wp-shortcode-pro' )
							),
							'name' => __( 'Animation style', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'wp-shortcode-pro' )
						),
						'flip_front' => array(
							'type'		=> 'text',
							'class'		=> 'wps-hidden wps-shortcode-start wps-child-shortcode-wrapper',
							'default'	=>	'flip_front',
							'name'		=> __( 'Flip Front', 'wp-shortcode-pro' )
						),
						'ff_background' => array(
							'type'		=> 'color',
							'default'	=> '#1e73be',
							'name'		=> __( 'Flip Front Background', 'wp-shortcode-pro' )
						),
						'ff_color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Flip Front Color', 'wp-shortcode-pro' )
						),
						'ff_padding' => array(
							'default' => '20px',
							'name' => __( 'Flip Front Padding', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content Padding (in pixels, em or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>40px</b>', '<b%value>2em</b>', '<b%value>20%</b>' )
						),
						'ff_content' => array(
							'type'		=> 'textarea',
							'class'		=> 'wps-child-content',
							'default'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
							'name'		=> __( 'Flip Front Content', 'wp-shortcode-pro' )
						),
						'flip_front_end' => array(
							'type'		=> 'text',
							'class'		=> 'wps-hidden wps-shortcode-end wps-child-shortcode-wrapper',
							'default'	=>	'flip_front',
							'name'		=> __( 'Flip Front', 'wp-shortcode-pro' )
						),
						'flip_back' => array(
							'type'		=> 'text',
							'class'		=> 'wps-hidden wps-shortcode-start wps-child-shortcode-wrapper',
							'default'	=>	'flip_back',
							'name'		=> __( 'Flip Back', 'wp-shortcode-pro' )
						),
						'fb_background' => array(
							'type'		=> 'color',
							'default'	=> '#dd3333',
							'name'		=> __( 'Flip Back Background', 'wp-shortcode-pro' )
						),
						'fb_color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Flip Back Color', 'wp-shortcode-pro' )
						),
						'fb_padding' => array(
							'default' => '20px',
							'name' => __( 'Flip Back Padding', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content Padding (in pixels, em or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>40px</b>', '<b%value>2em</b>', '<b%value>20%</b>' )
						),
						'fb_content' => array(
							'type'		=> 'textarea',
							'class'		=> 'wps-child-content',
							'default'	=> 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
							'name'		=> __( 'Flip Back Content', 'wp-shortcode-pro' )
						),
						'flip_back_end' => array(
							'type'		=> 'text',
							'class'		=> 'wps-hidden wps-shortcode-end wps-child-shortcode-wrapper',
							'default'	=>	'flip_back',
							'name'		=> __( 'Flip Back', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => array(
						'class'	=> 'wps-hidden'
					),
					'desc' => __( 'Flip Box', 'wp-shortcode-pro' ),
					'icon' => 'rotate-left',
				),
				// Overlay
				'overlay' => array(
					'name' => __( 'Overlay', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'image' => array(
							'type' => 'upload',
							'default' => 'http://via.placeholder.com/400x200?text=Overlay',
							'name' => __( 'Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Url to image-file', 'wp-shortcode-pro' )
						),
						'style' => array(
							'type' => 'select',
							'default' => 'style-2',
							'values' => array(
								'style-1'	=> __( 'Style 1', 'wp-shortcode-pro' ),
								'style-2'	=> __( 'Style 2', 'wp-shortcode-pro' ),
								'style-3'	=> __( 'Style 3', 'wp-shortcode-pro' ),
								'style-4'	=> __( 'Style 4', 'wp-shortcode-pro' ),
								'style-5'	=> __( 'Style 5', 'wp-shortcode-pro' ),
								'style-6'	=> __( 'Style 6', 'wp-shortcode-pro' ),
								'style-7'	=> __( 'Style 7', 'wp-shortcode-pro' ),
								'style-8'	=> __( 'Style 8', 'wp-shortcode-pro' ),
								'style-9'	=> __( 'Style 9', 'wp-shortcode-pro' ),
								'style-10'	=> __( 'Style 10', 'wp-shortcode-pro' ),
								'style-11'	=> __( 'Style 11', 'wp-shortcode-pro' ),
								'style-12'	=> __( 'Style 12', 'wp-shortcode-pro' ),
								'style-13'	=> __( 'Style 13', 'wp-shortcode-pro' ),
								'style-14'	=> __( 'Style 14', 'wp-shortcode-pro' ),
								'style-15'	=> __( 'Style 15', 'wp-shortcode-pro' ),
								'style-16'	=> __( 'Style 16', 'wp-shortcode-pro' ),
								'style-17'	=> __( 'Style 17', 'wp-shortcode-pro' ),
								'style-18'	=> __( 'Style 18', 'wp-shortcode-pro' ),
								'style-19'	=> __( 'Style 19', 'wp-shortcode-pro' ),
								'style-20'	=> __( 'Style 20', 'wp-shortcode-pro' ),
								'style-21'	=> __( 'Style 21', 'wp-shortcode-pro' ),
								'style-22'	=> __( 'Style 22', 'wp-shortcode-pro' ),
								'style-23'	=> __( 'Style 23', 'wp-shortcode-pro' ),
								'style-24'	=> __( 'Style 24', 'wp-shortcode-pro' ),
								'style-25'	=> __( 'Style 25', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Overlay style', 'wp-shortcode-pro' )
						),
						'title' => array(
							'type'		=> 'text',
							'default'	=>	'Title',
							'name'		=> __( 'Title', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium',
					'desc' => __( 'Overlay', 'wp-shortcode-pro' ),
					'icon' => 'archive',
				),
				// Shadow
				'shadow' => array(
					'name' => __( 'Shadow', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default'		=> __( 'Default', 'wp-shortcode-pro' ),
								'horizontal'	=> __( 'Horizontal', 'wp-shortcode-pro' )
							),
							'name' => __( 'Shadow style', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
					'desc' => __( 'Shadow', 'wp-shortcode-pro' ),
					'icon' => 'archive',
				),
				// Pricing Table
				'pricing_table' => array(
					'name' => __( 'Pricing Table', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'child' => 'plan',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'style-1'	=> __( 'Style 1', 'wp-shortcode-pro' ),
								'style-2'	=> __( 'Style 2', 'wp-shortcode-pro' ),
								'style-3'	=> __( 'Style 3', 'wp-shortcode-pro' ),
								'style-4'	=> __( 'Style 4', 'wp-shortcode-pro' ),
							),
							'default' => 'style-1',
							'name' => __( 'Pricing Style', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
						'repeater_field' => array(
							'type' => 'wrap',
							'default' => '',
							'name' => __( 'Plan', 'wp-shortcode-pro' ),
							'desc' => '<div class="wps-tab-inner-wrapper"></div><button class="button-primary" id="wps-add-field"  data-child="plan">'.__( 'Add Plan', 'wp-shortcode-pro' ).'</button>'
						),
					),
					'content' => array(
						'class'	=> 'wps-hidden'
					),
					'desc' => __( 'Pricing Table', 'wp-shortcode-pro' ),
					'icon' => 'table',
				),
				// Plan
				'plan' => array(
					'name' => __( 'Plan', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'structure',
					'parent' => 'pricing-table',
					'notice' => __( 'This is a child shortcode of Pricing Table and it must be used inside Pricing Table shortcode only.', 'wp-shortcode-pro' ),
					'fields' => array(
						'title' => array(
							'default' => __( 'Basic', 'wp-shortcode-pro' ),
							'name' => __( 'Name', 'wp-shortcode-pro' ),
							'desc' => __( 'Plan Name', 'wp-shortcode-pro' )
						),
						'currency' => array(
							'default' => '$',
							'name' => __( 'Currency', 'wp-shortcode-pro' )
						),
						'price' => array(
							'default' => '99',
							'name' => __( 'Price', 'wp-shortcode-pro' ),
							'desc' => __( 'Plan Price', 'wp-shortcode-pro' )
						),
						'old_price' => array(
							'default' => '109',
							'name' => __( 'Old Price', 'wp-shortcode-pro' ),
							'desc' => __( 'Old Price', 'wp-shortcode-pro' )
						),
						'period' => array(
							'default' => __( '/month', 'wp-shortcode-pro' ),
							'name' => __( 'Period', 'wp-shortcode-pro' ),
							'desc' => __( 'Plan Period', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type'		=> 'color',
							'default'	=> '#dd3333',
							'name'		=> __( 'Background', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Color', 'wp-shortcode-pro' )
						),
						'featured' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'featured' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Featured', 'wp-shortcode-pro' ),
							'desc' => __( 'Make Plan Featured', 'wp-shortcode-pro' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => 'home',
							'name' => __( 'Icon', 'wp-shortcode-pro' ),
							'desc' => __( 'Select icon or upload custom icon', 'wp-shortcode-pro' )
						),
						'icon_color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Icon Color', 'wp-shortcode-pro' )
						),
						'button_text' => array(
							'default' => __( 'Sign Up Now', 'wp-shortcode-pro' ),
							'name' => __( 'Button Text', 'wp-shortcode-pro' )
						),
						'button_url' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'Button URL', 'wp-shortcode-pro' ),
							'desc' => __( 'Plan link', 'wp-shortcode-pro' )
						),
						'button_background' => array(
							'type'		=> 'color',
							'default'	=> '#dd8d8d',
							'name'		=> __( 'Button Background', 'wp-shortcode-pro' )
						),
						'button_color' => array(
							'type'		=> 'color',
							'default'	=> '#fff',
							'name'		=> __( 'Button Color', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self'  => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'wp-shortcode-pro' ),
							'desc' => __( 'Link target', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => '<ul><li><span>Vitae adipiscing turpis. Aenean ligula nibh, molestie id vivide.</span></li><li>Option-1</li><li>Option-2</li><li>Option-3</li><li>Option-4</li><li>Option-5</li></ul>',
					'desc' => __( 'Plan', 'wp-shortcode-pro' ),
					'icon' => 'cube',
				),
				// FAQ
				'faq' => array(
					'name' => __( 'FAQ', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'standard'  => __( 'Standard', 'wp-shortcode-pro' ),
								'classic' => __( 'Classic', 'wp-shortcode-pro' )
							),
							'default' => 'standard',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
						),
						'question' => array(
							'type' => 'text',
							'default'	=> 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque?',
							'name'		=> __('Question', 'wp-shortcode-pro')
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
					'desc' => __( 'FAQ', 'wp-shortcode-pro' ),
					'icon' => 'question',
				),
				// table
				'table' => array(
					'name' => __( 'Table', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'light'	=> __( 'Light', 'wp-shortcode-pro' ),
								'dark'	=> __( 'Dark', 'wp-shortcode-pro' ),
								'stripped' => __( 'Stripped', 'wp-shortcode-pro' ),
								'stripped-dark'	=> __( 'Stripped Dark', 'wp-shortcode-pro' ),
								'hover'	=> __( 'Hover', 'wp-shortcode-pro' ),
								'hover-dark' => __( 'Hover Dark', 'wp-shortcode-pro' )
							),
							'default' => 'style-1',
							'name' => __( 'Style', 'wp-shortcode-pro' )
						),
						'table_data' => array(
							'type' => 'table',
							'default' => '',
							'name' => __( 'Table Content', 'wp-shortcode-pro' ),
							'desc' => __( 'Add or Edit the table content.', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => array(
						'class'	=> 'wps-hidden'
					),
					'desc' => __( 'Styled table', 'wp-shortcode-pro' ),
					'icon' => 'table',
				),
				// private_note
				'private_note' => array(
					'name' => __( 'Private Note', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'notice' => __( 'You can use this shortcode to show private note to post author.', 'wp-shortcode-pro' ),
					'fields' => array(
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Private note text', 'wp-shortcode-pro' ),
					'desc' => __( 'Private note for post authors', 'wp-shortcode-pro' ),
					'icon' => 'lock',
				),
				// members
				'members' => array(
					'name' => __( 'Members', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'fields' => array(
						'message' => array(
							'default' => __( 'You need to %login% to view this content.', 'wp-shortcode-pro' ),
							'name' => __( 'Message', 'wp-shortcode-pro' ),
							'desc' => __( 'Message for not logged users', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#444',
							'name' => __( 'Color', 'wp-shortcode-pro' ),
							'desc' => __( 'Color', 'wp-shortcode-pro' )
						),
						'login_text' => array(
							'default' => __( 'login', 'wp-shortcode-pro' ),
							'name' => __( 'Login text', 'wp-shortcode-pro' ),
							'desc' => __( 'Login text', 'wp-shortcode-pro' )
						),
						'login_url' => array(
							'default' => wp_login_url(),
							'name' => __( 'Login url', 'wp-shortcode-pro' ),
							'desc' => __( 'Login url', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Content for logged members', 'wp-shortcode-pro' ),
					'desc' => __( 'Content for logged in members only', 'wp-shortcode-pro' ),
					'icon' => 'lock',
				),
				// guests
				'guests' => array(
					'name' => __( 'Guests', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'notice' => __( 'Preview will not show any content as this shortcode is use to show content only to non-logged in visitors.', 'wp-shortcode-pro' ),
					'fields' => array(
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'This content will be available only for non-logged visitors', 'wp-shortcode-pro' ),
					'desc' => __( 'Content for guests only', 'wp-shortcode-pro' ),
					'icon' => 'user',
				),
				// menu
				'menu' => array(
					'name' => __( 'Menu', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'other',
					'fields' => array(
						'name' => array(
							'default' => '',
							'type' => 'select',
							'values' => get_registered_nav_menus(),
							'name' => __( 'Menu Location', 'wp-shortcode-pro' ),
							'desc' => __( 'Custom menu Location. Ex: Main menu', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Custom menu by name', 'wp-shortcode-pro' ),
					'icon' => 'bars',
				),
				// subpages
				'subpages' => array(
					'name' => __( 'Sub pages', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'other',
					'fields' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ),
							'default' => 1,
							'name' => __( 'Depth', 'wp-shortcode-pro' ),
							'desc' => __( 'Max depth level of children pages', 'wp-shortcode-pro' )
						),
						'parent' => array(
							'default' => '',
							'name' => __( 'Parent ID', 'wp-shortcode-pro' ),
							'desc' => __( 'ID of the parent page. Leave blank to use current page', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'List of sub pages', 'wp-shortcode-pro' ),
					'icon' => 'bars',
				),
				// siblings
				'siblings' => array(
					'name' => __( 'Siblings', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'other',
					'fields' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3 ),
							'default' => 1,
							'name' => __( 'Depth', 'wp-shortcode-pro' ),
							'desc' => __( 'Max depth level', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'List of cureent page siblings', 'wp-shortcode-pro' ),
					'icon' => 'bars',
				),
				// document
				'document' => array(
					'name' => __( 'Document', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'media',
					'fields' => array(
						'url' => array(
							'type' => 'upload',
							'default' => 'https://docs.google.com/document/d/1W98GkzMbu3MhVX4bq981dyjifWLYr3Bat6ej-iE52Os/edit',
							'name' => __( 'Url', 'wp-shortcode-pro' ),
							'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Viewer width', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Viewer height', 'wp-shortcode-pro' )
						),
						'responsive' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Responsive', 'wp-shortcode-pro' ),
							'desc' => __( 'Make viewer responsive', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Document viewer by Google', 'wp-shortcode-pro' ),
					'icon' => 'file-text',
				),
				// animate
				'animate' => array(
					'name' => __( 'Animation', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'fields' => array(
						'type' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'bounceIn',
							'name' => __( 'Animation', 'wp-shortcode-pro' ),
							'desc' => __( 'Animation type', 'wp-shortcode-pro' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 1,
							'name' => __( 'Duration', 'wp-shortcode-pro' ),
							'desc' => __( 'Animation duration (seconds)', 'wp-shortcode-pro' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'wp-shortcode-pro' ),
							'desc' => __( 'Animation delay (seconds)', 'wp-shortcode-pro' )
						),
						'inline' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Inline', 'wp-shortcode-pro' ),
							'desc' => __( 'This parameter determines what HTML tag will be used for animation wrapper. Turn this option to YES and animated element will be wrapped in SPAN instead of DIV. Useful for inline animations, like buttons', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Animated content', 'wp-shortcode-pro' ),
					'desc' => __( 'Wrapper for animation. Any nested element will be animated', 'wp-shortcode-pro' ),
					'icon' => 'bolt',
				),
				//permalink
				'permalink' => array(
					'name' => __( 'Permalink', 'wp-shortcode-pro' ),
					'type' => 'mixed',
					'category' => 'content other',
					'fields' => array(
						'id' => array(
							'default' => 1,
							'name' => __( 'ID', 'wp-shortcode-pro' ),
							'desc' => __( 'Post or page ID', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'wp-shortcode-pro' ),
							'desc' => __( 'Link target', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet',
					'desc' => __( 'Permalink to specified post/page', 'wp-shortcode-pro' ),
					'icon' => 'link',
				),
				// meta
				'meta' => array(
					'name' => __( 'Post Meta', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'data',
					'fields' => array(
						'key' => array(
							'default' => '',
							'name' => __( 'Key', 'wp-shortcode-pro' ),
							'desc' => __( 'Meta key name', 'wp-shortcode-pro' )
						),
						'default' => array(
							'default' => '40',
							'name' => __( 'Default', 'wp-shortcode-pro' ),
							'desc' => __( 'This text will be shown if data is not found', 'wp-shortcode-pro' )
						),
						'before' => array(
							'default' => 'Price',
							'name' => __( 'Before', 'wp-shortcode-pro' ),
							'desc' => __( 'This content will be shown before the value', 'wp-shortcode-pro' )
						),
						'after' => array(
							'default' => '/year',
							'name' => __( 'After', 'wp-shortcode-pro' ),
							'desc' => __( 'This content will be shown after the value', 'wp-shortcode-pro' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'wp-shortcode-pro' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'wp-shortcode-pro' )
						),
					),
					'desc' => __( 'Post meta', 'wp-shortcode-pro' ),
					'icon' => 'info-circle',
				),
				// user
				'user' => array(
					'name' => __( 'User data', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'data',
					'fields' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'display_name'        => __( 'Display name', 'wp-shortcode-pro' ),
								'ID'                  => __( 'ID', 'wp-shortcode-pro' ),
								'user_login'          => __( 'Login', 'wp-shortcode-pro' ),
								'user_nicename'       => __( 'Nice name', 'wp-shortcode-pro' ),
								'user_email'          => __( 'Email', 'wp-shortcode-pro' ),
								'user_url'            => __( 'URL', 'wp-shortcode-pro' ),
								'user_registered'     => __( 'Registered', 'wp-shortcode-pro' ),
								'user_activation_key' => __( 'Activation key', 'wp-shortcode-pro' ),
								'user_status'         => __( 'Status', 'wp-shortcode-pro' )
							),
							'default' => 'display_name',
							'name' => __( 'Field', 'wp-shortcode-pro' ),
							'desc' => __( 'User data field name', 'wp-shortcode-pro' )
						),
						'default' => array(
							'default' => 'User does not exists.',
							'name' => __( 'Default', 'wp-shortcode-pro' ),
							'desc' => __( 'This text will be shown if data is not found', 'wp-shortcode-pro' )
						),
						'before' => array(
							'default' => 'Name:',
							'name' => __( 'Before', 'wp-shortcode-pro' ),
							'desc' => __( 'This content will be shown before the value', 'wp-shortcode-pro' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'wp-shortcode-pro' ),
							'desc' => __( 'This content will be shown after the value', 'wp-shortcode-pro' )
						),
						'user_id' => array(
							'default' => '',
							'type'	=> 'select',
							'values' => $this->wps_user_lists(),
							'name' => __( 'User', 'wp-shortcode-pro' ),
							'desc' => __( 'Select user.', 'wp-shortcode-pro' )
						)
					),
					'desc' => __( 'User data', 'wp-shortcode-pro' ),
					'icon' => 'info-circle',
				),
				// post
				'post' => array(
					'name' => __( 'Post data', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'data',
					'fields' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'ID'                    => __( 'Post ID', 'wp-shortcode-pro' ),
								'post_author'           => __( 'Post author', 'wp-shortcode-pro' ),
								'post_date'             => __( 'Post date', 'wp-shortcode-pro' ),
								'post_date_gmt'         => __( 'Post date', 'wp-shortcode-pro' ) . ' GMT',
								'post_content'          => __( 'Post content', 'wp-shortcode-pro' ),
								'post_title'            => __( 'Post title', 'wp-shortcode-pro' ),
								'post_excerpt'          => __( 'Post excerpt', 'wp-shortcode-pro' ),
								'post_status'           => __( 'Post status', 'wp-shortcode-pro' ),
								'comment_status'        => __( 'Comment status', 'wp-shortcode-pro' ),
								'ping_status'           => __( 'Ping status', 'wp-shortcode-pro' ),
								'post_name'             => __( 'Post name', 'wp-shortcode-pro' ),
								'post_modified'         => __( 'Post modified', 'wp-shortcode-pro' ),
								'post_modified_gmt'     => __( 'Post modified', 'wp-shortcode-pro' ) . ' GMT',
								'post_content_filtered' => __( 'Filtered post content', 'wp-shortcode-pro' ),
								'post_parent'           => __( 'Post parent', 'wp-shortcode-pro' ),
								'guid'                  => __( 'GUID', 'wp-shortcode-pro' ),
								'menu_order'            => __( 'Menu order', 'wp-shortcode-pro' ),
								'post_type'             => __( 'Post type', 'wp-shortcode-pro' ),
								'post_mime_type'        => __( 'Post mime type', 'wp-shortcode-pro' ),
								'comment_count'         => __( 'Comment count', 'wp-shortcode-pro' )
							),
							'default' => 'post_title',
							'name' => __( 'Field', 'wp-shortcode-pro' ),
							'desc' => __( 'Post data field name', 'wp-shortcode-pro' )
						),
						'default' => array(
							'default' => 'Post does not exits',
							'name' => __( 'Default', 'wp-shortcode-pro' ),
							'desc' => __( 'This text will be shown if data is not found', 'wp-shortcode-pro' )
						),
						'before' => array(
							'default' => 'Title:',
							'name' => __( 'Before', 'wp-shortcode-pro' ),
							'desc' => __( 'This content will be shown before the value', 'wp-shortcode-pro' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'wp-shortcode-pro' ),
							'desc' => __( 'This content will be shown after the value', 'wp-shortcode-pro' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'wp-shortcode-pro' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'wp-shortcode-pro' )
						),
					),
					'desc' => __( 'Post data', 'wp-shortcode-pro' ),
					'icon' => 'info-circle',
				),
				// posts_block
				'posts_block' => array(
					'name' => __( 'Posts Block', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'other',
					'fields' => array(
						'post_type' => array(
							'type' => 'post_type',
							'multiple' => true,
							'default' => 'post',
							'name' => __( 'Post types', 'wp-shortcode-pro' ),
							'desc' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'wp-shortcode-pro' )
						),
						'id' => array(
							'default' => '',
							'name' => __( 'Post ID\'s', 'wp-shortcode-pro' ),
							'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'wp-shortcode-pro' )
						),
						'taxonomy' => array(
							'type' => 'taxonomy',
							'default' => 'category',
							'name' => __( 'Taxonomy', 'wp-shortcode-pro' ),
							'desc' => __( 'Select taxonomy to show posts from', 'wp-shortcode-pro' )
						),
						'tax_term' => array(
							'type' => 'term',
							'multiple' => true,
							'default' => '',
							'name' => __( 'Terms', 'wp-shortcode-pro' ),
							'desc' => __( 'Select terms to show posts from', 'wp-shortcode-pro' )
						),
						'tax_operator' => array(
							'type' => 'select',
							'values' => array(
									'IN'     => __( 'IN - posts that have any of selected categories terms', 'wp-shortcode-pro' ),
									'NOT IN' => __( 'NOT IN - posts that is does not have any of selected terms', 'wp-shortcode-pro' ),
									'AND'    => __( 'AND - posts that have all selected terms', 'wp-shortcode-pro' ),
							),
							'default' => 'IN',
							'name' => __( 'Taxonomy term operator', 'wp-shortcode-pro' ),
							'desc' => __( 'Operator to test', 'wp-shortcode-pro' )
						),
						'author' => array(
							'default' => '',
							'name' => __( 'Authors', 'wp-shortcode-pro' ),
							'desc' => __( 'Enter here comma-separated list of author\'s IDs. Example: 1,7,18', 'wp-shortcode-pro' )
						),
						'meta_key' => array(
							'default' => '',
							'name' => __( 'Meta key', 'wp-shortcode-pro' ),
							'desc' => __( 'Enter meta key name to show posts that have this key', 'wp-shortcode-pro' )
						),
						'offset' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 1, 'default' => 0,
							'name' => __( 'Offset', 'wp-shortcode-pro' ),
							'desc' => __( 'Specify offset to start posts loop not from first post', 'wp-shortcode-pro' )
						),
						'post_parent' => array(
							'default' => '',
							'name' => __( 'Post parent', 'wp-shortcode-pro' ),
							'desc' => __( 'Show childrens of entered post (enter post ID)', 'wp-shortcode-pro' )
						),
						'post_status' => array(
							'type' => 'select',
							'values' => array(
								'publish' => __( 'Published', 'wp-shortcode-pro' ),
								'pending' => __( 'Pending', 'wp-shortcode-pro' ),
								'draft' => __( 'Draft', 'wp-shortcode-pro' ),
								'auto-draft' => __( 'Auto-draft', 'wp-shortcode-pro' ),
								'future' => __( 'Future post', 'wp-shortcode-pro' ),
								'private' => __( 'Private post', 'wp-shortcode-pro' ),
								'inherit' => __( 'Inherit', 'wp-shortcode-pro' ),
								'trash' => __( 'Trashed', 'wp-shortcode-pro' ),
								'any' => __( 'Any', 'wp-shortcode-pro' ),
							),
							'default' => 'publish',
							'name' => __( 'Post status', 'wp-shortcode-pro' ),
							'desc' => __( 'Show only posts with selected status', 'wp-shortcode-pro' )
						),
						'excerpt_length' => array(
							'type' => 'number',
							'multiple' => true,
							'min' => 20,
							'step' => 5,
							'default' => 30,
							'name' => __( 'Excerpt Length', 'wp-shortcode-pro' )
						),
						'view' => array(
							'type' => 'select',
							'values' => array(
								'list' => __( 'List', 'wp-shortcode-pro' ),
								'grid' => __( 'Grid', 'wp-shortcode-pro' )
							),
							'default' => 'list',
							'name' => __( 'Posts View', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type' => 'select',
							'values' => array(
								1 => __( '1 column', 'wp-shortcode-pro' ),
								2 => __( '2 columns', 'wp-shortcode-pro' ),
								3 => __( '3 columns', 'wp-shortcode-pro' ),
								4 => __( '4 columns', 'wp-shortcode-pro' )
							),
							'default' => 'columns',
							'name' => __( 'Columns', 'wp-shortcode-pro' ),
							'desc' => __( 'The number of columns to display, when viewing posts.', 'wp-shortcode-pro' )
						),
						'border' => array(
							'type'		=> 'border',
							'default'	=> '',
							'name'		=> __( 'Border', 'wp-shortcode-pro' ),
							'desc'		=> __( 'Column border', 'wp-shortcode-pro' )
						),
						'hide_items' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => array(
								'none' => __( 'None', 'wp-shortcode-pro' ),
								'title' => __( 'Title', 'wp-shortcode-pro' ),
								'date' => __( 'Date', 'wp-shortcode-pro' ),
								'author' => __( 'Author', 'wp-shortcode-pro' ),
								'excerpt' => __( 'Excerpt', 'wp-shortcode-pro' ),
								'meta' => __( 'Meta', 'wp-shortcode-pro' ),
								'thumbnail' => __( 'Thumbnail', 'wp-shortcode-pro' )
							),
							'default' => 'publish',
							'name' => __( 'Hide Items', 'wp-shortcode-pro' )
						),
						'ignore_sticky_posts' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Ignore sticky', 'wp-shortcode-pro' ),
							'desc' => __( 'Select Yes to ignore posts that is sticked', 'wp-shortcode-pro' )
						),
						'order' => array(
							'type' => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'wp-shortcode-pro' ),
								'asc' => __( 'Ascending', 'wp-shortcode-pro' )
							),
							'default' => 'DESC',
							'name' => __( 'Order', 'wp-shortcode-pro' ),
							'desc' => __( 'Posts order', 'wp-shortcode-pro' )
						),
						'orderby' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'wp-shortcode-pro' ),
								'id' => __( 'Post ID', 'wp-shortcode-pro' ),
								'author' => __( 'Post author', 'wp-shortcode-pro' ),
								'title' => __( 'Post title', 'wp-shortcode-pro' ),
								'name' => __( 'Post slug', 'wp-shortcode-pro' ),
								'date' => __( 'Date', 'wp-shortcode-pro' ),
								'modified' => __( 'Last modified date', 'wp-shortcode-pro' ),
								'parent' => __( 'Post parent', 'wp-shortcode-pro' ),
								'rand' => __( 'Random', 'wp-shortcode-pro' ),
								'comment_count' => __( 'Comments number', 'wp-shortcode-pro' ),
								'menu_order' => __( 'Menu order', 'wp-shortcode-pro' ),
								'meta_value' => __( 'Meta key values', 'wp-shortcode-pro' ),
							),
							'default' => 'date',
							'name' => __( 'Order by', 'wp-shortcode-pro' ),
							'desc' => __( 'Order posts by', 'wp-shortcode-pro' )
						),
						'posts_per_page' => array(
							'type' => 'number',
							'min' => -1,
							'max' => 10000,
							'step' => 1,
							'default' => get_option( 'posts_per_page' ),
							'name' => __( 'Posts per page', 'wp-shortcode-pro' ),
							'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'wp-shortcode-pro' )
						),
						'allow_pagination' => array(
							'type' => 'button_set',
							'default' => 'no',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Allow Pagination', 'wp-shortcode-pro' )
						),
					),
					'desc' => __( 'Posts Block', 'wp-shortcode-pro' ),
					'icon' => 'th-list',
				),
				// Google Map
				'google_map' => array(
					'name' => __( 'Google map', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Map width', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Map height', 'wp-shortcode-pro' )
						),
						'address' => array(
							'default' => 'Libertyville, Illinois, USA',
							'name' => __( 'Marker', 'wp-shortcode-pro' ),
							'desc' => __( 'Address for the marker. You can type it in any language', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Maps by Google', 'wp-shortcode-pro' ),
					'icon' => 'globe',
				),
				// Advanced Google Map
				'advanced_google_map' => array(
					'name' => __( 'Advanced Google Map', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'ultra-light' => __( 'Ultra Light', 'wp-shortcode-pro' ),
								'subtle-grayscale' => __( 'Subtle Grayscale', 'wp-shortcode-pro' ),
								'gray-shades' => __( 'Shades of Gray', 'wp-shortcode-pro' ),
								'light-gray' => __( 'Light Gray', 'wp-shortcode-pro' ),
								'no-label' => __( 'No Labels', 'wp-shortcode-pro' ),
								'uber-original' => __( 'Uber Original', 'wp-shortcode-pro' ),
								'uber-original' => __( 'Uber Original', 'wp-shortcode-pro' ),
								'pale-dawn' => __( 'Pale Dawn', 'wp-shortcode-pro' ),
							),
							'default' => 'self',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'Map Style', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Map width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Map height (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'zoom' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'default' => 12,
							'name' => __( 'Zoom', 'wp-shortcode-pro' ),
							'desc' => __( 'Map zoom', 'wp-shortcode-pro' )
						),
						'fit' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Fit Map', 'wp-shortcode-pro' ),
							'desc' => __( 'Set the map to contain the given bounds.', 'wp-shortcode-pro' )
						),
						'center' => array(
							'type'	=> 'geocomplete',
							'default' => 'Del Rio, TX, USA',
							'name' => __( 'Map Center', 'wp-shortcode-pro' ),
							'desc' => __( 'Map Center.', 'wp-shortcode-pro' )
						),
						'addresses' => array(
							'type'	=> 'geocomplete',
							'multiple' => true,
							'default' => '',
							'name' => __( 'Marker', 'wp-shortcode-pro' ),
							'desc' => __( 'Address for the marker.', 'wp-shortcode-pro' )
						),
						'marker_image' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Marker Image', 'wp-shortcode-pro' ),
							'desc' => __( 'Url to marker image', 'wp-shortcode-pro' )
						),
						'search' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show Search Box', 'wp-shortcode-pro' ),
						),
						'search_zoom' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'default' => 12,
							'name' => __( 'Search Zoom', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Advanced Map', 'wp-shortcode-pro' ),
					'icon' => 'globe',
				),
				// Google trends
				'google_trends' => array(
					'name' => __( 'Google trends', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'query' => array(
							'default' => 'wordpress,theme,plugin',
							'name' => __( 'Query', 'wp-shortcode-pro' )
						),
						'geo' => array(
							'default' => 'US',
							'name' => __( 'Geo', 'wp-shortcode-pro' )
						),
					),
					'desc' => __( 'Google Trends', 'wp-shortcode-pro' ),
					'icon' => 'signal',
				),

				// Pie chart
				'pie_chart' => array(
					'name' => __( 'Pie Chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'title' => array(
							'default' => 'Pie chart title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Task | Hours per Day",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Work, 11 | Sleep, 7 | Eat, 2 | Commute, 3",
							'name' => __( 'Row', 'wp-shortcode-pro' )
						),
						'is3d' => array(
							'type' => 'button_set',
							'default' => true,
							'values' => array(
								false => __( 'No', 'wp-shortcode-pro' ),
								true => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Enable 3D', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Pie Chart', 'wp-shortcode-pro' ),
					'icon' => 'pie-chart',
				),
				// Geo charts
				'geo_chart' => array(
					'name' => __( 'Geo chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'columns' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Country | Popularity",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Germany, 150 | US, 200 | UK, 250 | China, 100",
							'name' => __( 'Row', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Geo Chart', 'wp-shortcode-pro' ),
					'icon' => 'map',
				),
				// Bar chart
				'bar_chart' => array(
					'name' => __( 'Bar chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'title' => array(
							'default' => 'Bar chart title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Galaxy | Distance | Brightness",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Canis Major Dwarf, 8000, 23.3 | Sagittarius Dwarf, 24000, 4.5 | Ursa Major II Dwarf, 30000, 14.3 | Lg. Magellanic Cloud, 50000, 0.9",
							'name' => __( 'Row', 'wp-shortcode-pro' )
						),
						'xaxis_top' => array(
							'default' => __( 'apparent magnitude', 'wp-shortcode-pro' ),
							'name' => __( 'Xaxis Top', 'wp-shortcode-pro' )
						),
						'xaxis_bottom' => array(
							'default' => __( 'Amount', 'wp-shortcode-pro' ),
							'name' => __( 'Xaxis Bottom', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Bar Chart', 'wp-shortcode-pro' ),
					'icon' => 'bar-chart',
				),
				// Area chart
				'area_chart' => array(
					'name' => __( 'Area chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'title' => array(
							'default' => 'Area chart title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type'	=> 'textarea',
							'default' => "Year | Sales | Expenses",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'default' => "2013, 1000, 400 | 2014, 1170, 460 | 2015, 660, 1120 | 2016, 1030, 540",
							'name' => __( 'Row', 'wp-shortcode-pro' )
						),
						'vaxis' => array(
							'default' => __( 'Amount', 'wp-shortcode-pro' ),
							'name' => __( 'Vaxis', 'wp-shortcode-pro' )
						),
						'haxis' => array(
							'default' => __( 'Year', 'wp-shortcode-pro' ),
							'name' => __( 'Haxis', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Area Chart', 'wp-shortcode-pro' ),
					'icon' => 'area-chart',
				),
				// Combo chart
				'combo_chart' => array(
					'name' => __( 'Combo chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'title' => array(
							'default' => 'Combo chart title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "Month | Bolivia | Ecuador | Madagascar | Papua New Guinea | Rwanda | Average",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'values' => '',
							'default' => "2004/05, 165, 938, 522, 998, 450,614.6 | 2004/05, 135, 1120, 599, 1268, 288,682 | 2005/06, 157, 1167, 587, 807, 397,623 | 2006/07, 139, 1110, 615, 968, 215,609.4 | 2008/09, 136, 691, 629, 1026, 366,569.6",
							'name' => __( 'Row', 'wp-shortcode-pro' )
						),
						'vaxis' => array(
							'default' => __( 'Cups', 'wp-shortcode-pro' ),
							'name' => __( 'Vaxis', 'wp-shortcode-pro' )
						),
						'haxis' => array(
							'default' => __( 'Month', 'wp-shortcode-pro' ),
							'name' => __( 'Haxis', 'wp-shortcode-pro' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Combo Chart', 'wp-shortcode-pro' ),
					'icon' => 'bar-chart',
				),
				// Org chart
				'org_chart' => array(
					'name' => __( 'Org chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'small' => __( 'Small', 'wp-shortcode-pro' ),
								'medium' => __( 'Medium', 'wp-shortcode-pro' ),
								'large' => __( 'Large', 'wp-shortcode-pro' ),
							),
							'default' => 'medium',
							'name' => __( 'Size', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type'	=> 'textarea',
							'default' => "Name | Position | Tooltip",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'default' => "Mike,null,President | Jane, Mike, Vice President | Carol, Mike, Co-founder | Ron, Mike, Co-founder | Carol, Mike, Co-founder | Keith, Carol, Manager | Employee1, Keith, Emplyee | Employee2, Keith, Emplyee | Employee3, Keith, Emplyee",
							'name' => __( 'Rows', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Org Chart', 'wp-shortcode-pro' ),
					'icon' => 'sitemap',
				),
				// Bubble chart
				'bubble_chart' => array(
					'name' => __( 'Bubble chart', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'google',
					'fields' => array(
						'title' => array(
							'default' => 'Bubble chart title',
							'name' => __( 'Title', 'wp-shortcode-pro' )
						),
						'columns' => array(
							'type'	=> 'textarea',
							'default' => "ID | X | Y | Temperature",
							'name' => __( 'Columns', 'wp-shortcode-pro' )
						),
						'rows' => array(
							'type'	=> 'textarea',
							'default' => "null, 80, 167, 120 | null, 79, 136, 130 | null, 78, 184, 50 | null, 72, 278, 230 | null, 81, 200, 210 | null, 72, 170, 100 | null, 68, 477, 80",
							'name' => __( 'Rows', 'wp-shortcode-pro' )
						),
						'vaxis' => array(
							'default' => __( 'Cups', 'wp-shortcode-pro' ),
							'name' => __( 'Vaxis', 'wp-shortcode-pro' )
						),
						'haxis' => array(
							'default' => __( 'Month', 'wp-shortcode-pro' ),
							'name' => __( 'Haxis', 'wp-shortcode-pro' )
						),
						'primary_color' => array(
							'type' => 'color',
							'default' => '#999999',
							'name' => __( 'Primary color', 'wp-shortcode-pro' ),
						),
						'secondary_color' => array(
							'type' => 'color',
							'default' => '#999999',
							'name' => __( 'Secondary color', 'wp-shortcode-pro' ),
						),
						'width' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '500',
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 100,
							'default' => '300',
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'Content width (in pixels or percents). %s Example values: %s, %s, %s', 'wp-shortcode-pro' ), '<br>', '<b%value>300</b>', '<b%value>600</b>', '<b%value>900</b>' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Bubble Chart', 'wp-shortcode-pro' ),
					'icon' => 'line-chart',
				),
				// dummy_text
				'dummy_text' => array(
					'name' => __( 'Dummy text', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'what' => array(
							'type' => 'select',
							'values' => array(
								'paras' => __( 'Paragraphs', 'wp-shortcode-pro' ),
								'words' => __( 'Words', 'wp-shortcode-pro' ),
								'bytes' => __( 'Bytes', 'wp-shortcode-pro' ),
							),
							'default' => 'paras',
							'name' => __( 'What', 'wp-shortcode-pro' ),
							'desc' => __( 'Dummy text format', 'wp-shortcode-pro' )
						),
						'amount' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Amount', 'wp-shortcode-pro' ),
							'desc' => __( 'Dummy text amount', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Text placeholder', 'wp-shortcode-pro' ),
					'icon' => 'text-height',
				),
				// dummy_image
				'dummy_image' => array(
					'name' => __( 'Dummy image', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 500,
							'name' => __( 'Width', 'wp-shortcode-pro' ),
							'desc' => __( 'Image width', 'wp-shortcode-pro' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 300,
							'name' => __( 'Height', 'wp-shortcode-pro' ),
							'desc' => __( 'Image height', 'wp-shortcode-pro' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'any'       => __( 'Any', 'wp-shortcode-pro' ),
								'abstract'  => __( 'Abstract', 'wp-shortcode-pro' ),
								'animals'   => __( 'Animals', 'wp-shortcode-pro' ),
								'business'  => __( 'Business', 'wp-shortcode-pro' ),
								'cats'      => __( 'Cats', 'wp-shortcode-pro' ),
								'city'      => __( 'City', 'wp-shortcode-pro' ),
								'food'      => __( 'Food', 'wp-shortcode-pro' ),
								'nightlife' => __( 'Night life', 'wp-shortcode-pro' ),
								'fashion'   => __( 'Fashion', 'wp-shortcode-pro' ),
								'people'    => __( 'People', 'wp-shortcode-pro' ),
								'nature'    => __( 'Nature', 'wp-shortcode-pro' ),
								'sports'    => __( 'Sports', 'wp-shortcode-pro' ),
								'technics'  => __( 'Technics', 'wp-shortcode-pro' ),
								'transport' => __( 'Transport', 'wp-shortcode-pro' )
							),
							'default' => 'any',
							'name' => __( 'Theme', 'wp-shortcode-pro' ),
							'desc' => __( 'Image theme', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Image placeholder with random image', 'wp-shortcode-pro' ),
					'icon' => 'image',
				),
				// Responsive Utility
				'responsive_utility' => array(
					'name' => __( 'Responsive Utility', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'visible' => array(
							'type' => 'select',
							'values' => array(
								'extra-large'	=> __( 'Extra Large ( ≥1200px )', 'wp-shortcode-pro' ),
								'large'			=> __( 'Large ( ≥992px )', 'wp-shortcode-pro' ),
								'medium'		=> __( 'Medium ( ≥768px )', 'wp-shortcode-pro' ),
								'small'			=> __( 'Small ( ≥544px  )', 'wp-shortcode-pro' ),
								'extra-small'	=> __( 'Extra Small ( <544px )', 'wp-shortcode-pro' )
							),
							'name' => __( 'Visible On', 'wp-shortcode-pro' )
						),
						'hidden' => array(
							'type' => 'select',
							'values' => array(
								'extra-large'	=> __( 'Extra Large ( ≥1200px )', 'wp-shortcode-pro' ),
								'large'			=> __( 'Large ( ≥992px )', 'wp-shortcode-pro' ),
								'medium'		=> __( 'Medium ( ≥768px )', 'wp-shortcode-pro' ),
								'small'			=> __( 'Small ( ≥544px  )', 'wp-shortcode-pro' ),
								'extra-small'	=> __( 'Extra Small ( <544px )', 'wp-shortcode-pro' )
							),
							'name' => __( 'Hidden On', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
					'desc' => __( 'Responsive Utility', 'wp-shortcode-pro' ),
					'icon' => 'mobile',
				),
				// qrcode
				'qrcode' => array(
					'name' => __( 'QR code', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'data' => array(
							'default' => 'QR code data',
							'name' => __( 'Data', 'wp-shortcode-pro' ),
							'desc' => __( 'The text to store within the QR code. You can use here any text or even URL', 'wp-shortcode-pro' )
						),
						'title' => array(
							'default' => 'QR Title',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Enter here short description. This text will be used in alt attribute of QR code', 'wp-shortcode-pro' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1000,
							'step' => 10,
							'default' => 250,
							'name' => __( 'Size', 'wp-shortcode-pro' ),
							'desc' => __( 'Image width and height (pixels)', 'wp-shortcode-pro' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 50,
							'step' => 5,
							'default' => 20,
							'name' => __( 'Margin', 'wp-shortcode-pro' ),
							'desc' => __( 'Margin (pixels)', 'wp-shortcode-pro' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'wp-shortcode-pro' ),
								'left' => __( 'Left', 'wp-shortcode-pro' ),
								'center' => __( 'Center', 'wp-shortcode-pro' ),
								'right' => __( 'Right', 'wp-shortcode-pro' ),
							),
							'default' => 'none',
							'name' => __( 'Align', 'wp-shortcode-pro' ),
							'desc' => __( 'Image alignment', 'wp-shortcode-pro' )
						),
						'link' => array(
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'wp-shortcode-pro' ),
							'desc' => __( 'QR code URL', 'wp-shortcode-pro' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open in same tab', 'wp-shortcode-pro' ),
								'blank' => __( 'Open in new tab', 'wp-shortcode-pro' ),
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'wp-shortcode-pro' ),
							'desc' => __( 'Link target', 'wp-shortcode-pro' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#000000',
							'name' => __( 'Primary color', 'wp-shortcode-pro' ),
							'desc' => __( 'Primary color', 'wp-shortcode-pro' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#ffffff',
							'name' => __( 'Background color', 'wp-shortcode-pro' ),
							'desc' => __( 'Background color', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'QR code generator', 'wp-shortcode-pro' ),
					'icon' => 'qrcode',
				),
				// scheduler
				'scheduler' => array(
					'name' => __( 'Scheduler', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'other',
					'fields' => array(
						'time' => array(
							'default' => '',
							'name' => __( 'Time', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'In this field you can specify one or more time ranges. Every day at this time the content of shortcode will be visible. %s %s %s - show content from 9:00 to 18:00 %s - show content from 9:00 to 13:00 and from 14:00 to 18:00 %s - example with minutes (content will be visible each day, 45 minutes) %s - example with seconds', 'wp-shortcode-pro' ), '<br><br>', __( 'Examples (click to set)', 'wp-shortcode-pro' ), '<br><b%value>9-18</b>', '<br><b%value>9-13, 14-18</b>', '<br><b%value>9:30-10:15</b>', '<br><b%value>9:00:00-17:59:59</b>' )
						),
						'week' => array(
							'default' => '',
							'name' => __( 'Days of the week', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the week. Every week at these days the content of shortcode will be visible. %s 0 - Sunday %s 1 - Monday %s 2 - Tuesday %s 3 - Wednesday %s 4 - Thursday %s 5 - Friday %s 6 - Saturday %s %s %s - show content from Monday to Friday %s - show content only at Sunday %s - show content at Sunday and from Wednesday to Friday', 'wp-shortcode-pro' ), '<br><br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br><br>', __( 'Examples (click to set)', 'wp-shortcode-pro' ), '<br><b%value>1-5</b>', '<br><b%value>0</b>', '<br><b%value>0, 3-5</b>' )
						),
						'month' => array(
							'default' => '',
							'name' => __( 'Days of the month', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the month. Every month at these days the content of shortcode will be visible. %s %s %s - show content only at first day of month %s - show content from 1th to 5th %s - show content from 10th to 15th and from 20th to 25th', 'wp-shortcode-pro' ), '<br><br>', __( 'Examples (click to set)', 'wp-shortcode-pro' ), '<br><b%value>1</b>', '<br><b%value>1-5</b>', '<br><b%value>10-15, 20-25</b>' )
						),
						'months' => array(
							'default' => '',
							'name' => __( 'Months', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'In this field you can specify the month or months in which the content will be visible. %s %s %s - show content only in January %s - show content from February to June %s - show content in January, March and from May to July', 'wp-shortcode-pro' ), '<br><br>', __( 'Examples (click to set)', 'wp-shortcode-pro' ), '<br><b%value>1</b>', '<br><b%value>2-6</b>', '<br><b%value>1, 3, 5-7</b>' )
						),
						'years' => array(
							'default' => '',
							'name' => __( 'Years', 'wp-shortcode-pro' ),
							'desc' => sprintf( __( 'In this field you can specify the year or years in which the content will be visible. %s %s %s - show content only in 2014 %s - show content from 2014 to 2016 %s - show content in 2014, 2018 and from 2020 to 2022', 'wp-shortcode-pro' ), '<br><br>', __( 'Examples (click to set)', 'wp-shortcode-pro' ), '<br><b%value>2014</b>', '<br><b%value>2014-2016</b>', '<br><b%value>2014, 2018, 2020-2022</b>' )
						),
						'alt' => array(
							'default' => '',
							'name' => __( 'Alternative text', 'wp-shortcode-pro' ),
							'desc' => __( 'In this field you can type the text which will be shown if content is not visible at the current moment', 'wp-shortcode-pro' )
						)
					),
					'content' => __( 'Scheduled content', 'wp-shortcode-pro' ),
					'desc' => __( 'Allows to show the content only at the specified time period', 'wp-shortcode-pro' ),
					'icon' => 'clock',
				),
				// feed
				'feed' => array(
					'name' => __( 'RSS feed', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content other',
					'fields' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'wp-shortcode-pro' ),
							'desc' => __( 'Url to RSS-feed', 'wp-shortcode-pro' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Limit', 'wp-shortcode-pro' ),
							'desc' => __( 'Number of items to show', 'wp-shortcode-pro' )
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'Feed grabber', 'wp-shortcode-pro' ),
					'icon' => 'rss',
				),
				// Clipboard
				'clipboard' => array(
					'name' => __( 'Clipboard', 'wp-shortcode-pro' ),
					'type' => 'wrap',
					'category' => 'content',
					'fields' => array(
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'content' => __( 'Clipboard Text', 'wp-shortcode-pro' ),
					'desc' => __( 'Copy text to clipboard', 'wp-shortcode-pro' ),
					'icon' => 'clipboard',
				),

				// TOC
				'toc' => array(
					'name' => __( 'Table of Content', 'wp-shortcode-pro' ),
					'type' => 'single',
					'category' => 'content',
					'fields' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'wp-shortcode-pro' ),
								'floating' => __( 'Floating', 'wp-shortcode-pro' ),
								'sticky' => __( 'Sticky', 'wp-shortcode-pro' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'wp-shortcode-pro' ),
							'desc' => __( 'TOC style', 'wp-shortcode-pro' )
						),
						'title' => array(
							'default' => 'Table of Contents',
							'name' => __( 'Title', 'wp-shortcode-pro' ),
							'desc' => __( 'Table of Contents Title', 'wp-shortcode-pro' )
						),
						'heading_levels' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => array(
								'1' => __( 'Heading 1', 'wp-shortcode-pro' ),
								'2' => __( 'Heading 2', 'wp-shortcode-pro' ),
								'3' => __( 'Heading 3', 'wp-shortcode-pro' ),
								'4' => __( 'Heading 4', 'wp-shortcode-pro' ),
								'5' => __( 'Heading 5', 'wp-shortcode-pro' ),
								'6' => __( 'Heading 6', 'wp-shortcode-pro' ),
							),
							'name' => __( 'Heading Levels', 'wp-shortcode-pro' )
						),
						'exclude' => array(
							'default' => '',
							'type' => 'textarea',
							'name' => __( 'Exclude Headings', 'wp-shortcode-pro' ),
							'desc' => __( 'Specify headings to be excluded from appearing in the table of contents. Separate multiple headings with a pipe |. Use an asterisk * as a wildcard to match other text. Note that this is not case sensitive.', 'wp-shortcode-pro' )
						),
						'show_heirarchy' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Show Heirarchy', 'wp-shortcode-pro' )
						),
						'bullet_spacing' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Preserve Theme Bullets', 'wp-shortcode-pro' ),
							'desc' => __('If your theme includes background images for unordered list elements, enable this to support them', 'wp-shortcode-pro'),
						),
						'ordered_list' => array(
							'type' => 'button_set',
							'default' => 'yes',
							'values' => array(
								'no' => __( 'No', 'wp-shortcode-pro' ),
								'yes' => __( 'Yes', 'wp-shortcode-pro' )
							),
							'name' => __( 'Ordered List', 'wp-shortcode-pro' ),
						),
						'class' => array(
							'type' => 'extra_css_class',
							'name' => __( 'Extra CSS Class', 'wp-shortcode-pro' ),
							'desc' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wp-shortcode-pro' ),
							'default' => '',
						),
					),
					'desc' => __( 'TOC', 'wp-shortcode-pro' ),
					'icon' => 'table',
				),
			) );

		return ( is_string( $shortcode ) ) ? $shortcodes[sanitize_text_field( $shortcode )] : $shortcodes;
	}

	public function wps_user_lists() {
		$user_list = array();
		$users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );
		foreach( $users as $user ) {
			$user_list[$user->ID] = $user->display_name;
		}
		return $user_list;
	}
}

// Init the shortcode list.
wp_shortcode()->list = new WPS_List;
