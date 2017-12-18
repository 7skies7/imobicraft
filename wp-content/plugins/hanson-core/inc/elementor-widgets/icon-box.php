<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_Ithemeslab_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'icon-box';
	}

	public function get_title() {
		return __( 'ITL - Icon Box', 'hanson-core' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'ithemeslab-widgets' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon Box', 'hanson-core' ),
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'hanson-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'hanson-core' ),
					'stacked' => __( 'Stacked', 'hanson-core' ),
					'framed' => __( 'Framed', 'hanson-core' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label' => __( 'Icon Type', 'itl-mae' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'fontawesome' => __( 'FontAwesome', 'hanson-core' ),
					'lineicon' => __( 'Line Icon', 'hanson-core' ),
				],
				'default' => 'fontawesome',
			]
		);

		$this->add_control(
			'line_icon',
			[
				'label'       => __( 'Line Icon', 'hanson-core' ),
				'type'        => Controls_Manager::SELECT,
				'options' => [
					'icon-mobile' => __( 'Mobile', 'hanson-core' ),
					'icon-laptop' => __( 'Laptop', 'hanson-core' ),
					'icon-desktop' => __( 'Desktop', 'hanson-core' ),
					'icon-tablet' => __( 'Tablet', 'hanson-core' ),
					'icon-phone' => __( 'Phone', 'hanson-core' ),
					'icon-document' => __( 'Document', 'hanson-core' ),
					'icon-documents' => __( 'Documents', 'hanson-core' ),
					'icon-search' => __( 'Search', 'hanson-core' ),
					'icon-clipboard' => __( 'Clipboard', 'hanson-core' ),
					'icon-newspaper' => __( 'Newspaper', 'hanson-core' ),
					'icon-notebook' => __( 'Notebook', 'hanson-core' ),
					'icon-book-open' => __( 'Book Open', 'hanson-core' ),
					'icon-browser' => __( 'Browser', 'hanson-core' ),
					'icon-calendar' => __( 'Calendar', 'hanson-core' ),
					'icon-presentation' => __( 'Presentation', 'hanson-core' ),
					'icon-picture' => __( 'Picture', 'hanson-core' ),
					'icon-pictures' => __( 'Pictures', 'hanson-core' ),
					'icon-video' => __( 'Video', 'hanson-core' ),
					'icon-camera' => __( 'Camera', 'hanson-core' ),
					'icon-printer' => __( 'Printer', 'hanson-core' ),
					'icon-toolbox' => __( 'Toolbox', 'hanson-core' ),
					'icon-briefcase' => __( 'Briefcase', 'hanson-core' ),
					'icon-wallet' => __( 'Wallet', 'hanson-core' ),
					'icon-gift' => __( 'Gift', 'hanson-core' ),
					'icon-bargraph' => __( 'Bargraph', 'hanson-core' ),
					'icon-grid' => __( 'Grid', 'hanson-core' ),
					'icon-expand' => __( 'Expand', 'hanson-core' ),
					'icon-focus' => __( 'Focus', 'hanson-core' ),
					'icon-edit' => __( 'Edit', 'hanson-core' ),
					'icon-adjustments' => __( 'Adjustements', 'hanson-core' ),
					'icon-ribbon' => __( 'Ribbon', 'hanson-core' ),
					'icon-hourglass' => __( 'Hourglass', 'hanson-core' ),
					'icon-lock' => __( 'Lock', 'hanson-core' ),
					'icon-megaphone' => __( 'Megaphone', 'hanson-core' ),
					'icon-shield' => __( 'Shield', 'hanson-core' ),
					'icon-trophy' => __( 'Trophy', 'hanson-core' ),
					'icon-flag' => __( 'Flag', 'hanson-core' ),
					'icon-map' => __( 'Map', 'hanson-core' ),
					'icon-puzzle' => __( 'Puzzle', 'hanson-core' ),
					'icon-basket' => __( 'Basket', 'hanson-core' ),
					'icon-envelope' => __( 'Envelope', 'hanson-core' ),
					'icon-streetsign' => __( 'Street Sign', 'hanson-core' ),
					'icon-telescope' => __( 'Telescope', 'hanson-core' ),
					'icon-gears' => __( 'Gears', 'hanson-core' ),
					'icon-key' => __( 'Key', 'hanson-core' ),
					'icon-paperclip' => __( 'Paper Clip', 'hanson-core' ),
					'icon-attachment' => __( 'Attachment', 'hanson-core' ),
					'icon-pricetags' => __( 'Pricetags', 'hanson-core' ),
					'icon-lightbulb' => __( 'Light Bulb', 'hanson-core' ),
					'icon-layers' => __( 'Layers', 'hanson-core' ),
					'icon-pencil' => __( 'Pencil', 'hanson-core' ),
					'icon-tools' => __( 'Tools', 'hanson-core' ),
					'icon-tools-2' => __( 'Tools 2', 'hanson-core' ),
					'icon-scissors' => __( 'Scissors', 'hanson-core' ),
					'icon-paintbrush' => __( 'Paintbrush', 'hanson-core' ),
					'icon-magnifying-glass' => __( 'Magnifying Glass', 'hanson-core' ),
					'icon-circle-compass' => __( 'Circle Compass', 'hanson-core' ),
					'icon-linegraph' => __( 'Linegraph', 'hanson-core' ),
					'icon-mic' => __( 'Mic', 'hanson-core' ),
					'icon-strategy' => __( 'Strategy', 'hanson-core' ),
					'icon-beaker' => __( 'Beaker', 'hanson-core' ),
					'icon-caution' => __( 'Caution', 'hanson-core' ),
					'icon-recycle' => __( 'Recycle', 'hanson-core' ),
					'icon-anchor' => __( 'Anchor', 'hanson-core' ),
					'icon-profile-male' => __( 'Profile Male', 'hanson-core' ),
					'icon-profile-female' => __( 'Profile Female', 'hanson-core' ),
					'icon-bike' => __( 'Bike', 'hanson-core' ),
					'icon-wine' => __( 'Wine', 'hanson-core' ),
					'icon-hotairballoon' => __( 'Baloon', 'hanson-core' ),
					'icon-globe' => __( 'Globe', 'hanson-core' ),
					'icon-genius' => __( 'Genius', 'hanson-core' ),
					'icon-map-pin' => __( 'Map Pin', 'hanson-core' ),
					'icon-dial' => __( 'Dial', 'hanson-core' ),
					'icon-chat' => __( 'Chat', 'hanson-core' ),
					'icon-heart' => __( 'Heart', 'hanson-core' ),
					'icon-cloud' => __( 'Cloud', 'hanson-core' ),
					'icon-upload' => __( 'Upload', 'hanson-core' ),
					'icon-download' => __( 'Download', 'hanson-core' ),
					'icon-target' => __( 'Target', 'hanson-core' ),
					'icon-hazardous' => __( 'Hazardous', 'hanson-core' ),
					'icon-piechart' => __( 'Piechart', 'hanson-core' ),
					'icon-speedometer' => __( 'Speedometer', 'hanson-core' ),
					'icon-global' => __( 'Global', 'hanson-core' ),
					'icon-compass' => __( 'Compass', 'hanson-core' ),
					'icon-lifesaver' => __( 'Life Saver', 'hanson-core' ),
					'icon-clock' => __( 'Clock', 'hanson-core' ),
					'icon-aperture' => __( 'Aperture', 'hanson-core' ),
					'icon-quote' => __( 'Quote', 'hanson-core' ),
					'icon-scope' => __( 'Scope', 'hanson-core' ),
					'icon-alarmclock' => __( 'Alarm Clock', 'hanson-core' ),
					'icon-refresh' => __( 'Refresh', 'hanson-core' ),
					'icon-happy' => __( 'Happy', 'hanson-core' ),
					'icon-sad' => __( 'Sad', 'hanson-core' ),
					'icon-facebook' => __( 'Facebook', 'hanson-core' ),
					'icon-twitter' => __( 'Twitter', 'hanson-core' ),
					'icon-googleplus' => __( 'Google Plus', 'hanson-core' ),
					'icon-rss' => __( 'Rss', 'hanson-core' ),
					'icon-tumblr' => __( 'Tumblr', 'hanson-core' ),
					'icon-linkedin' => __( 'Linked In', 'hanson-core' ),
					'icon-dribbble' => __( 'Dribbble', 'hanson-core' ),
				],
				'default'     => 'icon-layers',
				'condition' => [
					'icon_type' => 'lineicon'
				]
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Choose Icon', 'hanson-core' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-star',
				'condition' => [
					'icon_type' => 'fontawesome'
				]
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'hanson-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'hanson-core' ),
					'square' => __( 'Square', 'hanson-core' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title & Description', 'hanson-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'hanson-core' ),
				'placeholder' => __( 'Your Title', 'hanson-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => '',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'hanson-core' ),
				'placeholder' => __( 'Your Description', 'hanson-core' ),
				'title' => __( 'Input icon text here', 'hanson-core' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
			]
		);



		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'hanson-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'hanson-core' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Icon Position', 'hanson-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'hanson-core' ),
						'icon' => 'fa fa-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'hanson-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'hanson-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'toggle' => false,
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'hanson-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'hanson-core' ),
					'h2' => __( 'H2', 'hanson-core' ),
					'h3' => __( 'H3', 'hanson-core' ),
					'h4' => __( 'H4', 'hanson-core' ),
					'h5' => __( 'H5', 'hanson-core' ),
					'h6' => __( 'H6', 'hanson-core' ),
					'div' => __( 'div', 'hanson-core' ),
					'span' => __( 'span', 'hanson-core' ),
					'p' => __( 'p', 'hanson-core' ),
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1bbde8',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_space',
			[
				'label' => __( 'Spacing', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-position-right .elementor-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-left .elementor-icon-box-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-top .elementor-icon-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Size', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => __( 'Rotate', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'hanson-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'hanson-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_hover',
			[
				'label' => __( 'Icon Hover', 'hanson-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon, {{WRAPPER}}.elementor-view-default:hover .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animation', 'hanson-core' ),
				'type' => Controls_Manager::HOVER_ANIMATION,

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'hanson-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'hanson-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hanson-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'hanson-core' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'hanson-core' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_vertical_alignment',
			[
				'label' => __( 'Vertical Alignment', 'hanson-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => __( 'Top', 'hanson-core' ),
					'middle' => __( 'Middle', 'hanson-core' ),
					'bottom' => __( 'Bottom', 'hanson-core' ),
				],
				'default' => 'top',
				'prefix_class' => 'elementor-vertical-align-',
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'hanson-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => __( 'Spacing', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
				        'size' => 15,
                ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Description', 'hanson-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'icon', 'class', [ 'elementor-icon', 'elementor-animation-' . $settings['hover_animation'] ] );

		$icon_tag = 'span';

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'link', 'href', $settings['link']['url'] );
			$icon_tag = 'a';

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'link', 'rel', 'nofollow' );
			}
		}
		$icon_type = $settings['icon_type'];
        if( $icon_type == 'lineicon'){
	        $this->add_render_attribute( 'i', 'class', $settings['line_icon'] );
        } else {
	        $this->add_render_attribute( 'i', 'class', $settings['icon'] );
        }

		$icon_attributes = $this->get_render_attribute_string( 'icon' );
		$link_attributes = $this->get_render_attribute_string( 'link' );
		?>
		<div class="elementor-icon-box-wrapper">
            <div class="elementor-icon-box-icon">
				<<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
					<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
				</<?php echo $icon_tag; ?>>
			</div>
			<div class="elementor-icon-box-content">
				<<?php echo $settings['title_size']; ?> class="elementor-icon-box-title">
					<<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
				</<?php echo $settings['title_size']; ?>>
				<p class="elementor-icon-box-description"><?php echo $settings['description_text']; ?></p>
			</div>
		</div>
		<?php
	}

	protected function _content_template() {
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Ithemeslab_Icon_Box() );