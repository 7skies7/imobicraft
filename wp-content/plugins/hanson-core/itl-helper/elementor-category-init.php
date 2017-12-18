<?php
namespace Elementor;

function ithemeslab_elementor_category_init(){
    Plugin::instance()->elements_manager->add_category(
        'ithemeslab-widgets',
        [
            'title'  => 'HUDSON Elements',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','Elementor\ithemeslab_elementor_category_init');



