<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // If this file is called directly, abort.

class Widget_Itl_Clients extends Widget_Base {

	public function get_name() {
		return 'itl-clients';
	}

	public function get_title() {
		return __( 'ITL - Clients', 'hanson-core' );
	}

	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'ithemeslab-widgets' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
            'client_settings',
            [
                'label' => __( 'Client Settings', 'hanson-core' )
            ]
        );

        $this->add_control(
			'clients',
			[
				'label' => __( 'Client Items', 'hanson-core' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'person_name' => __( 'Asif Islam', 'hanson-core' ),
					],
					[
						'person_name' => __( 'Iffat Tasnim', 'hanson-core' ),
					],
				],
				'fields' => [
					[
						'name' => 'Company_name',
						'label' => __( 'Company Name', 'hanson-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => __( 'Company' , 'hanson-core' ),
						'label_block' => true,
					],
					[
						'name' => 'client_image',
						'label' => __('Company Logo', 'hanson-core'),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'label_block' => true,
					],
				],
				'title_field' => '{{{ Company_name }}}',
			]
		);
		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'hanson-core' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => __( 'Carousel Options', 'hanson-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'item_count',
			[
				'label'   => __( 'Items', 'hanson-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1,
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'hanson-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'label_on' => __( 'Yes', 'hanson-core' ),
				'label_off' => __( 'No', 'hanson-core' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'hanson-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'label_on' => __( 'Yes', 'hanson-core' ),
				'label_off' => __( 'No', 'hanson-core' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'nav',
			[
				'label' => __( 'Nav', 'hanson-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'hanson-core' ),
				'label_off' => __( 'No', 'hanson-core' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'show_dots',
			[
				'label' => __( 'Show Dots', 'hanson-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'hanson-core' ),
				'label_off' => __( 'No', 'hanson-core' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'speed',
			[
				'label'   => __( 'Speed', 'hanson-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 250,
				'min'     => 250,
				'max'     => 6000,
				'step'    => 250,
			]
		);
		$this->add_control(
			'timeout',
			[
				'label'   => __( 'Timeout', 'hanson-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5000,
				'min'     => 500,
				'max'     => 10000,
				'step'    => 500,
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$count    = intval( $settings['item_count'] );
		$autoplay = $settings['autoplay'];
		$loop     = $settings['loop'];
		$nav      = $settings['nav'];
		$dots     = $settings['show_dots'];
		$speed    = intval( $settings['speed'] );
		$timeout  = intval( $settings['timeout'] );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div id="clients-carousel-<?php echo uniqid(); ?>" class="clients-carousel owl-carousel owl-theme" data-count="<?php esc_attr_e($count); ?>" data-autoplay="<?php esc_attr_e($autoplay); ?>" data-loop="<?php esc_attr_e($loop); ?>" data-nav="<?php esc_attr_e($nav); ?>" data-dots="<?php esc_attr_e($dots); ?>" data-speed="<?php esc_attr_e($speed); ?>" data-timeout="<?php esc_attr_e($timeout); ?>">
				<?php
				foreach ( $settings['clients'] as $client ) {
				$client_image = $client['client_image'];
					if ( ! empty( $client_image ) ) {
				?>
				<div class="client-item">
					<?php echo wp_get_attachment_image( $client_image['id'], 'thumbnail', false, array( 'class' => 'itl-client-image full' ) ); ?>
				</div>
					<?php }  }?>
			</div>
		</div>
<?php
	}
	protected function content_template() {
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Itl_Clients() );