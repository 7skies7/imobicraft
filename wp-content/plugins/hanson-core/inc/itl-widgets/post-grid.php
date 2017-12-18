<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class Widget_Itl_Post_grid extends Widget_Base {

    public function get_name() {
        return 'itl-postgrid';
    }

    public function get_title() {
        return __('ITL - Post Grid', 'hanson-core');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
	    return [ 'ithemeslab-widgets' ];
    }

//    public function get_script_depends() {
//        return [
//            'itl-widgets-scripts',
//            'itl-frontend-scripts',
//            'isotope.pkgd',
//            'imagesloaded.pkgd'
//        ];
//    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Post Query', 'hanson-core'),
            ]
        );


        $this->add_control(
            'post_types',
            [
                'label' => __('Post Types', 'hanson-core'),
                'type' => Controls_Manager::SELECT2,
                'default' => 'post',
                'options' => itl_get_all_post_type_options(),
                'multiple' => true
            ]
        );

        $this->add_control(
            'tax_query',
            [
                'label' => __('Taxonomies', 'hanson-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => itl_get_all_taxonomy_options(),
                'multiple' => true,
                'label_block' => true
            ]
        );

        $this->add_control(
            'post_in',
            [
                'label' => __('Post In', 'hanson-core'),
                'description' => __('Provide a comma separated list of Post IDs to display in the grid.', 'hanson-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'hanson-core'),
                'description' => __( 'Select how many posts you want to display', 'hanson-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'hanson-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'hanson-core'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'none' => __('No order', 'hanson-core'),
                    'ID' => __('Post ID', 'hanson-core'),
                    'author' => __('Author', 'hanson-core'),
                    'title' => __('Title', 'hanson-core'),
                    'date' => __('Published date', 'hanson-core'),
                    'modified' => __('Modified date', 'hanson-core'),
                    'parent' => __('By parent', 'hanson-core'),
                    'rand' => __('Random order', 'hanson-core'),
                    'comment_count' => __('Comment count', 'hanson-core'),
                    'menu_order' => __('Menu order', 'hanson-core'),
                    'post__in' => __('By include order', 'hanson-core'),
                ),
                'default' => 'date',
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'hanson-core'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => __('Ascending', 'hanson-core'),
                    'DESC' => __('Descending', 'hanson-core'),
                ),
                'default' => 'DESC',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_post_content',
            [
                'label' => __('Post Content', 'hanson-core'),
            ]
        );

        /*$this->add_control(
            'display_title',
            [
                'label' => __('Display posts title below the post item?', 'hanson-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'hanson-core'),
                'label_off' => __('No', 'hanson-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );*/

        $this->add_control(
            'display_summary',
            [
                'label' => __('Display post excerpt/summary', 'hanson-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'hanson-core'),
                'label_off' => __('No', 'hanson-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

	    $this->add_control(
		    'post_word_count',
		    [
			    'label' => __('Word count', 'hanson-core'),
			    'description' => __( 'Select how many words you want to display in excerpt', 'hanson-core' ),
			    'type' => Controls_Manager::NUMBER,
			    'default' => 16,
			    'min' => 1,
			    'max' => 80,
			    'step' => 1,
		    ]
	    );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_post_meta',
            [
                'label' => __('Post Meta', 'hanson-core'),
            ]
        );
        $this->add_control(
            'display_post_date',
            [
                'label' => __('Display post date', 'hanson-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'hanson-core'),
                'label_off' => __('No', 'hanson-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
	    $this->add_control(
		    'display_author',
		    [
			    'label' => __('Display post author', 'hanson-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'label_on' => __('Yes', 'hanson-core'),
			    'label_off' => __('No', 'hanson-core'),
			    'return_value' => 'yes',
			    'default' => 'yes',
		    ]
	    );
	    $this->add_control(
		    'display_comment_count',
		    [
			    'label' => __('Display comments count', 'hanson-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'label_on' => __('Yes', 'hanson-core'),
			    'label_off' => __('No', 'hanson-core'),
			    'return_value' => 'yes',
			    'default' => 'yes',
		    ]
	    );
        $this->add_control(
            'display_taxonomy',
            [
                'label' => __('Display taxonomy', 'hanson-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => __('Choose the right taxonomy in Post Content section above', 'hanson-core'),
                'label_on' => __('Yes', 'hanson-core'),
                'label_off' => __('No', 'hanson-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

	    $this->add_control(
		    'taxonomy_filter',
		    [
			    'type' => Controls_Manager::SELECT,
			    'label' => __('Choose the taxonomy to display and filter on.', 'hanson-core'),
			    'label_block' => true,
			    'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no taxonomy filters are specified when building query.', 'hanson-core'),
			    'options' => itl_get_taxonomies_map(),
			    'default' => 'portfolio_category',
                'condition' => [
                        'display_taxonomy' => 'yes'
                ]
		    ]
	    );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Column Settings', 'hanson-core'),
            ]
        );

        /*$this->add_control(
            'image_linkable',
            [
                'label' => __('Link Images to Posts?', 'hanson-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'hanson-core'),
                'label_off' => __('No', 'hanson-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );*/

        $this->add_control(
            'per_line',
            [
                'label' => __('Columns per row', 'hanson-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 2,
                'max' => 5,
                'step' => 1,
                'default' => 3,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_responsive',
            [
                'label' => __('Column Gutter', 'hanson-core'),
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => __( 'Desktop', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'gutter',
            [
                'label' => __('Gutter', 'hanson-core'),
                'description' => __('Space between columns in the grid.', 'hanson-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'selectors' => [
                    '{{WRAPPER}} .itl-post-grid' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '{{WRAPPER}} .itl-post-grid .itl-post-grid-item' => 'padding: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => __( 'Tablet', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'tablet_gutter',
            [
                'label' => __('Gutter', 'hanson-core'),
                'description' => __('Space between columns.', 'hanson-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(tablet-){{WRAPPER}} .itl-post-grid' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(tablet-){{WRAPPER}} .itl-post-grid .itl-post-grid-item' => 'padding: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'tablet_width',
            [
                'label' => __('Tablet Resolution', 'hanson-core'),
                'description' => __('The resolution to treat as a tablet resolution.', 'hanson-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 800,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => __( 'Mobile Phone', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mobile_gutter',
            [
                'label' => __('Gutter', 'hanson-core'),
                'description' => __('Space between columns.', 'hanson-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(mobile-){{WRAPPER}} .itl-post-grid' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(mobile-){{WRAPPER}} .itl-post-grid .itl-post-grid-item' => 'padding: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'mobile_width',
            [
                'label' => __('Tablet Resolution', 'hanson-core'),
                'description' => __('The resolution to treat as a tablet resolution.', 'hanson-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 480,
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_heading_styling',
            [
                'label' => __('Grid Heading', 'hanson-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'heading_tag',
            [
                'label' => __( 'Heading HTML Tag', 'hanson-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __( 'H1', 'hanson-core' ),
                    'h2' => __( 'H2', 'hanson-core' ),
                    'h3' => __( 'H3', 'hanson-core' ),
                    'h4' => __( 'H4', 'hanson-core' ),
                    'h5' => __( 'H5', 'hanson-core' ),
                    'h6' => __( 'H6', 'hanson-core' ),
                    'div' => __( 'div', 'hanson-core' ),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __( 'Heading Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-heading',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_filters_styling',
            [
                'label' => __('Grid Filters', 'hanson-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'filter_color',
            [
                'label' => __( 'Filter Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-taxonomy-filter .itl-filter-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_hover_color',
            [
                'label' => __( 'Filter Hover Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-taxonomy-filter .itl-filter-item a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_active_border',
            [
                'label' => __( 'Active Filter Border Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-taxonomy-filter .itl-filter-item.itl-active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-taxonomy-filter .itl-filter-item a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_grid_thumbnail_styling',
            [
                'label' => __('Grid Thumbnail', 'hanson-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'thumbnail_hover_bg_color',
            [
                'label' => __( 'Thumbnail Hover Background Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_hover_opacity',
            [
                'label' => __( 'Thumbnail Hover Opacity (%)', 'hanson-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image:hover .itl-image-overlay' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_thumbnail_info',
            [
                'label' => __( 'Thumbnail Info Entry Title', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'title_tag',
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
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_border_color',
            [
                'label' => __( 'Title Hover Border Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-post-title a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-post-title',
            ]
        );

        $this->add_control(
            'heading_thumbnail_info_taxonomy',
            [
                'label' => __( 'Thumbnail Info Taxonomy Terms', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'thumbnail_info_tags_color',
            [
                'label' => __( 'Taxonomy Terms Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-terms, {{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-terms a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-terms, {{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-project-image .itl-image-info .itl-terms a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_title_styling',
            [
                'label' => __('Grid Item Entry Title', 'hanson-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_title_tag',
            [
                'label' => __( 'Entry Title HTML Tag', 'hanson-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __( 'H1', 'hanson-core' ),
                    'h2' => __( 'H2', 'hanson-core' ),
                    'h3' => __( 'H3', 'hanson-core' ),
                    'h4' => __( 'H4', 'hanson-core' ),
                    'h5' => __( 'H5', 'hanson-core' ),
                    'h6' => __( 'H6', 'hanson-core' ),
                    'div' => __( 'div', 'hanson-core' ),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'entry_title_color',
            [
                'label' => __( 'Entry Title Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_title_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .entry-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_summary_styling',
            [
                'label' => __('Grid Item Entry Summary', 'hanson-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_summary_color',
            [
                'label' => __( 'Entry Summary Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_summary_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .entry-summary',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_meta_styling',
            [
                'label' => __('Grid Item Entry Meta', 'hanson-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_entry_meta',
            [
                'label' => __( 'Entry Meta', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'entry_meta_color',
            [
                'label' => __( 'Entry Meta Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-entry-meta span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_meta_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-entry-meta span',
            ]
        );


        $this->add_control(
            'heading_entry_meta_link',
            [
                'label' => __( 'Entry Meta Link', 'hanson-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'entry_meta_link_color',
            [
                'label' => __( 'Entry Meta Link Color', 'hanson-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-entry-meta span a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_meta_link_typography',
                'selector' => '{{WRAPPER}} .itl-portfolio-wrap .itl-portfolio .itl-portfolio-item .itl-entry-meta span a',
            ]
        );

        $this->end_controls_section();

    }


    function posts_grid($loop, $settings) {
        $column_style = itl_get_column_class(intval($settings['per_line'])); ?>
        <?php $current_page = get_queried_object_id(); ?>
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <?php $post_id = get_the_ID(); ?>
            <?php
            if ($post_id === $current_page)
                continue; // skip current page since we can run into infinite loop when users choose All option in build query
            ?>

            <div class="itl-post-grid-item post-grid-column-<?php echo $settings['per_line'];?>">
                <div class="itl-post-item">
                    <div class="itl-post-grid-thumb">
                        <?php echo the_post_thumbnail( 'large' ); ?>
                        <?php if( $settings['display_post_date'] == 'yes') : ?>
                        <div class="date-wrap">
                            <span class="date"><?php echo get_the_date( 'd' ); ?></span>
                            <span class="month"><?php echo get_the_date( 'M' ); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="itl-post-grid-content">
                        <<?php echo $settings['entry_title_tag']; ?> class="post-grid-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $settings['entry_title_tag']; ?>>
                        <div class="itl-post-grid-meta">
                            <div class="meta-item">
                                <?php if($settings['display_author'] == 'yes') : ?>
                                <span><i class="icon-profile-male"></i> <?php echo get_the_author_meta( 'display_name' ); ?></span>
                                <?php endif; ?>
		                        <?php if($settings['display_comment_count'] == 'yes') : ?>
                                <span><i class="icon-chat"></i> <?php comments_number( 'no responses', 'one response', '% responses' ); ?></span>
		                        <?php endif; ?>
                            </div>
                        </div>
                        <?php if( $settings['display_summary'] == 'yes' ) : ?>
                            <p><?php echo wp_trim_words( get_the_content(), $settings['post_word_count'], ' ...' ); ?></p>
                        <?php endif; ?>
	                    <div class="itl-post-grid-readmore">
	                        <a href="<?php the_permalink(); ?>">Read more <i class="fa fa-long-arrow-right"></i></a>
	                    </div>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        <?php
    }

    protected function render() {

        $settings = $this->get_settings();
        // Use the processed post selector query to find posts.
        $query_args = itl_build_query_args($settings);
        $loop = new \WP_Query($query_args);
        // Loop through the posts and do something with them.
        if ($loop->have_posts()) : ?>
            <div class="itl-post-grid-wrap">
                <div id="itl-post-grid-<?php echo uniqid(); ?>" class="itl-post-grid">
                    <?php $this->posts_grid($loop, $settings); ?>
                </div>
            </div>
            <?php
        endif;
    }

    protected function content_template() {
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Itl_Post_grid() );