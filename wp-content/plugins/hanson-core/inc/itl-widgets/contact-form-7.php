<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // If this file is called directly, abort.


class Widget_Itl_Contact_Form_7 extends Widget_Base {

	public function get_name() {
		return 'itl-contact-form';
	}

	public function get_title() {
		return esc_html__( 'ITL Contact Form 7', 'hanson-core' );
	}

	public function get_icon() {
		return 'fa fa-envelope-open';
	}

	public function get_categories() {
		return [ 'ithemeslab-widgets' ];
	}

	protected function _register_controls() {


		$this->start_controls_section(
			'itl_section_wpcf7_form',
			[
				'label' => esc_html__( 'Contact Form', 'hanson-core' )
			]
		);


		$this->add_control(
			'eael_wpcf7_form',
			[
				'label'       => esc_html__( 'Select your contact form 7', 'hanson-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => itl_select_contact_form(),
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'eael_section_contact_form_styles',
			[
				'label' => esc_html__( 'Form Container Styles', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'eael_contact_form_background',
			[
				'label'     => esc_html__( 'Form Background Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_alignment',
			[
				'label'        => esc_html__( 'Form Alignment', 'hanson-core' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => true,
				'options'      => [
					'default' => [
						'title' => __( 'Default', 'hanson-core' ),
						'icon'  => 'fa fa-ban',
					],
					'left'    => [
						'title' => esc_html__( 'Left', 'hanson-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'hanson-core' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'hanson-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'      => 'default',
				'prefix_class' => 'eael-contact-form-align-',
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_width',
			[
				'label'      => esc_html__( 'Form Width', 'hanson-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_max_width',
			[
				'label'      => esc_html__( 'Form Max Width', 'hanson-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'eael_contact_form_margin',
			[
				'label'      => esc_html__( 'Form Margin', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_padding',
			[
				'label'      => esc_html__( 'Form Padding', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'eael_contact_form_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'eael_contact_form_border',
				'selector' => '{{WRAPPER}} .eael-contact-form-container',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'eael_contact_form_box_shadow',
				'selector' => '{{WRAPPER}} .eael-contact-form-container',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'eael_section_contact_form_field_styles',
			[
				'label' => esc_html__( 'Form Fields Styles', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'eael_contact_form_input_background',
			[
				'label'     => esc_html__( 'Input Field Background', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea' => 'background: {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'eael_contact_form_input_width',
			[
				'label'      => esc_html__( 'Input Width', 'hanson-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-text' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_textarea_width',
			[
				'label'      => esc_html__( 'Textarea Width', 'hanson-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_input_padding',
			[
				'label'      => esc_html__( 'Fields Padding', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'eael_contact_form_input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'eael_contact_form_input_border',
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'eael_contact_form_input_box_shadow',
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea',
			]
		);

		$this->add_control(
			'eael_contact_form_focus_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Focus State Style', 'hanson-core' ),
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'eael_contact_form_input_focus_box_shadow',
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-text:focus, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea:focus',
			]
		);

		$this->add_control(
			'eael_contact_form_input_focus_border',
			[
				'label'     => esc_html__( 'Border Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'body {{WRAPPER}} .eael-contact-form-container input.wpcf7-text:focus, body {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea:focus' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'eael_section_contact_form_typography',
			[
				'label' => esc_html__( 'Color & Typography', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);


		$this->add_control(
			'eael_contact_form_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container, {{WRAPPER}} .eael-contact-form-container .wpcf7-form label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eael_contact_form_field_color',
			[
				'label'     => esc_html__( 'Field Font Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eael_contact_form_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Font Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eael-contact-form-container ::-moz-placeholder'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .eael-contact-form-container ::-ms-input-placeholder'     => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'eael_contact_form_label_heading',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Label Typography', 'hanson-core' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'eael_contact_form_label_typography',
				'selector' => '{{WRAPPER}} .eael-contact-form-container, {{WRAPPER}} .eael-contact-form-container .wpcf7-form label',
			]
		);


		$this->add_control(
			'eael_contact_form_heading_input_field',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Input Fields Typography', 'hanson-core' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'eael_contact_form_input_field_typography',
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-text, {{WRAPPER}} .eael-contact-form-container textarea.wpcf7-textarea',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'eael_section_contact_form_submit_button_styles',
			[
				'label' => esc_html__( 'Submit Button Styles', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_submit_btn_width',
			[
				'label'      => esc_html__( 'Button Width', 'hanson-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_submit_btn_alignment',
			[
				'label'        => esc_html__( 'Button Alignment', 'hanson-core' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => true,
				'options'      => [
					'default' => [
						'title' => __( 'Default', 'hanson-core' ),
						'icon'  => 'fa fa-ban',
					],
					'left'    => [
						'title' => esc_html__( 'Left', 'hanson-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'hanson-core' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'hanson-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'      => 'default',
				'prefix_class' => 'eael-contact-form-btn-align-',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'eael_contact_form_submit_btn_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit',
			]
		);

		$this->add_responsive_control(
			'eael_contact_form_submit_btn_margin',
			[
				'label'      => esc_html__( 'Margin', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'eael_contact_form_submit_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'hanson-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'eael_contact_form_submit_button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'hanson-core' ) ] );

		$this->add_control(
			'eael_contact_form_submit_btn_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'eael_contact_form_submit_btn_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'eael_contact_form_submit_btn_border',
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit',
			]
		);

		$this->add_control(
			'eael_contact_form_submit_btn_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'hanson-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit' => 'border-radius: {{SIZE}}px;',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab( 'eael_contact_form_submit_btn_hover', [ 'label' => esc_html__( 'Hover', 'hanson-core' ) ] );

		$this->add_control(
			'eael_contact_form_submit_btn_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eael_contact_form_submit_btn_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eael_contact_form_submit_btn_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'hanson-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'eael_contact_form_submit_btn_box_shadow',
				'selector' => '{{WRAPPER}} .eael-contact-form-container input.wpcf7-submit',
			]
		);


		$this->end_controls_section();


	}


	protected function render() {

		$settings = $this->get_settings();


		?>


		<?php if ( ! empty( $settings['eael_wpcf7_form'] ) ) : ?>
            <div class="eael-contact-form-container">
				<?php echo do_shortcode( '[contact-form-7 id="' . $settings['eael_wpcf7_form'] . '" ]' ); ?>
            </div>
		<?php endif; ?>

		<?php

	}

	protected function content_template() {
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Itl_Contact_Form_7() );