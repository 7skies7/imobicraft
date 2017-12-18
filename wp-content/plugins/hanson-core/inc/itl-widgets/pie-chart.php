<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // If this file is called directly, abort.

class Widget_Itl_Pie_Chart extends Widget_Base {

	public function get_name() {
		return 'itl-pie-chart';
	}

	public function get_title() {
		return __( 'ITL - Pie Chart', 'hanson-core' );
	}

	public function get_icon() {
		return 'fa fa-pie-chart';
	}

	public function get_categories() {
		return [ 'ithemeslab-widgets' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
            'piechart_content_settings',
            [
                'label' => __( 'Pie Chart Settings', 'hanson-core' )
            ]
        );
		$this->add_control(
			'percentage',
			[
				'label'   => __( 'Percentage', 'hanson-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 75,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);
		$this->add_control(
			'bar_color',
			[
				'label' => __( 'Bar Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => "#11bde8",
			]
		);
		$this->add_control(
			'track_color',
			[
				'label' => __( 'Track Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => "#f7f7f7",
			]
		);
		$this->add_control(
			'line_width',
			[
				'label' => __( 'Line Width', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 40,
					],
				],
			]
		);
		$this->add_control(
			'piechart_size',
			[
				'label' => __( 'Size', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 180,
				],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 400,
					],
				],
			]
		);
		$this->add_control(
			'line_cap',
			[
				'label'       => __( 'Line Cap', 'hanson-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'round',
				'options' => [
					'round'  => __( 'Round', 'hanson-core' ),
					'square' => __( 'Square', 'hanson-core' ),
				],
			]
		);
		$this->add_control(
			'chart_animation',
			[
				'label' => __( 'Animation', 'hanson-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 3000,
				],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 8000,
						'step' => 100,
					],
				],
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'hanson-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => "#333333",
				'selectors' => [
					'{{WRAPPER}} .percent' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'your_addon_styles',
			[
				'label' => __( 'Style Section Title', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings        = $this->get_settings();
		$percent         = intval( $settings['percentage'] );
		$bar_color       = $settings['bar_color'];
		$track_color     = $settings['track_color'];
		$line_cap        = $settings['line_cap'];
		$line_width      = intval( $settings['line_width']['size'] );
		$chart_size      = intval( $settings['piechart_size']['size'] );
		$chart_animation = intval( $settings['chart_animation']['size'] );
		?>
		<div class="chart-addon">
			<div class="chart" data-percent="<?php echo esc_attr( $percent ) ?>" data-barcolor="<?php esc_attr_e( $bar_color ); ?>" data-trackcolor="<?php esc_attr_e( $track_color ); ?>" data-linecap="<?php esc_attr_e( $line_cap ); ?>" data-linewidth="<?php esc_attr_e( $line_width ); ?>" data-chartsize="<?php esc_attr_e( $chart_size ); ?>" data-chartanimation="<?php esc_attr_e( $chart_animation ); ?>" ><span class="percent" style="line-height: <?php echo $settings['piechart_size']['size'].$settings['piechart_size']['unit']; ?>;"></span></div>
		</div>
	<?php }

	protected function content_template() {
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Itl_Pie_Chart() );
