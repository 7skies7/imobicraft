<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // If this file is called directly, abort.

class Widget_Itl_Pricing_Table extends Widget_Base {

	public function get_name() {
		return 'itl-pricing-table';
	}

	public function get_title() {
		return __( 'ITL - Pricing Table', 'hanson-core' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'ithemeslab-widgets' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
            'pricing_settings',
            [
                'label' => __( 'Pricing Header', 'hanson-core' )
            ]
        );

		$this->add_control(
			'pricing_title',
			[
				'label'       => __( 'Pricing Title', 'hanson-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Standard', 'hanson-core' ),
				'placeholder' => __( 'Basic, Standard, Premium', 'hanson-core' ),
			]
		);
		$this->add_control(
			'pricing_subtitle',
			[
				'label'       => __( 'Pricing Subtitle', 'hanson-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Subtitle text goes here', 'hanson-core' ),
				'placeholder' => __( 'Subtitle text goes here', 'hanson-core' ),
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'       => __( 'Currency Symbol', 'hanson-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '$', 'hanson-core' ),
				'placeholder' => __( '$', 'hanson-core' ),
			]
		);

		$this->add_control(
			'primary_number',
			[
				'label'       => __( 'Price', 'hanson-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '79', 'hanson-core' ),
				'placeholder' => __( '79', 'hanson-core' ),
			]
		);

		$this->add_control(
			'floating_number',
			[
				'label'       => __( 'Floating Number', 'hanson-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '.49', 'hanson-core' ),
				'placeholder' => __( '.49', 'hanson-core' ),
			]
		);

		$this->add_control(
			'price_period',
			[
				'label' => __( 'Price Period', 'hanson-core' ),
				'description' => __( 'Mo = Per Month & Yr = Per Year', 'hanson-core'  ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'month',
				'label_on' => __( 'Mo', 'hanson-core' ),
				'label_off' => __( 'Yr', 'hanson-core' ),
				'return_value' => 'month',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'pricing_list_settings',
			[
				'label' => __( 'Pricing List items', 'hanson-core' )
			]
		);

		$this->add_control(
			'pricing_list_items',
			[
				'label' => __( 'Pricing List Items', 'hanson-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'item_title' => __( '1 GB Disk Space', 'hanson-core' ),
					],
					[
						'item_title' => __( '20 GB Bandwidth', 'hanson-core' ),
					],
					[
						'item_title' => __( 'Customer Support', 'hanson-core' ),
					],
				],
				'fields' => [
					[
						'name' => 'item_title',
						'label' => __( 'Item Title', 'hanson-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => __( '1 GB Disk Space' , 'hanson-core' ),
						'label_block' => true,
					],
                    [
                        'name' => 'icon',
                        'label' => __( 'Choose Icon', 'hanson-core' ),
                        'type' => Controls_Manager::ICON,
                        'default' => 'fa fa-check',
                    ],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'hanson-core' ),
			]
		);

		$this->add_control(
			'btn-text',
			[
				'label' => __( 'Button Text', 'hanson-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Sign Up', 'hanson-core' ),
				'placeholder' => __( 'Sign Up', 'hanson-core' ),
			]
		);

		$this->add_control(
			'btn-link',
			[
				'label' => __( 'Link', 'hanson-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_alignment',
			[
				'label' => __( 'Alignment', 'hanson-core' ),
			]
		);
		$this->add_responsive_control(
			'pricing_table_align',
			[
				'label' => __( 'Alignment', 'hanson-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
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
				],
				'selectors' => [
					'{{WRAPPER}} .itl-pricing-table' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$this->add_render_attribute( 'wrapper', 'class', 'pricing-table-wrap' );
		$btn_link = $this->get_settings( 'btn-link' );
		$pricing_url = $btn_link['url'];
		$target = $btn_link['is_external'] ? 'target="_blank"' : '';
		$period = __( 'year', 'hanson-core' );
		if( 'month' == $settings['price_period'] ){
		    $period = $settings['price_period'];
        }
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="itl-pricing-table">
                <div class="pricing-head">
                    <div class="pricing-title">
                        <h3 class="title"><?php echo $settings['pricing_title'] ?></h3>
                        <p class="subtitle"><?php echo $settings['pricing_subtitle'] ?></p>
                    </div>
                    <h4 class="price-value">
                        <i><?php echo $settings['currency_symbol'] ?></i><?php echo $settings['primary_number'] ?><i><?php echo $settings['floating_number'] ?></i>
                        <span> <?php echo __( 'per ', 'hanson-core' ) .$period; ?> </span>
                    </h4>
                </div>
                <ul class="pricing-list">
                    <?php foreach ($settings['pricing_list_items'] as $list_item) { ?>
                    <li><span><i class=" <?php echo $list_item['icon']?>"></i> <?php echo $list_item['item_title']?></span></li>
                <?php } ?>
                </ul>
                <div class="pricing-footer">
                    <a href="<?php echo $pricing_url; ?>" class="btn pricing-btn" <?php echo $target; ?>>
                        <?php echo $settings['btn-text']; ?>
                    </a>
                </div>
            </div>
        </div>
        <?php

	}


}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Itl_Pricing_Table() );
?>