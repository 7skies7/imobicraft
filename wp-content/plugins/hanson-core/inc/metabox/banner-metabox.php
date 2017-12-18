<?php
add_action( 'cmb2_admin_init', 'imperial_banner_metabox' );

function imperial_banner_metabox() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_imperial_';

    $imperial_banner = new_cmb2_box( array(
        'id'            => 'banner_meta',
        'title'         => esc_html__( 'Banner', 'imperial-core' ),
        'object_types'  => array( 'page', 'post', 'project' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
    ) );

    $imperial_banner->add_field( array(
        'name' => esc_html__( 'Banner Image', 'imperial-core' ),
        'desc' => esc_html__( 'This will override the default banner', 'imperial-core' ),
        'id'   => 'banner_img',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
    ) );

}