<?php

function imperial_project_cpt() {
    $labels = array(
        'name'               => _x( 'Projects', 'post type general name', 'imperial-core' ),
        'singular_name'      => _x( 'Project', 'post type singular name', 'imperial-core' ),
        'menu_name'          => _x( 'Projects', 'admin menu', 'imperial-core' ),
        'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'imperial-core' ),
        'add_new'            => _x( 'Add New', 'service', 'imperial-core' ),
        'add_new_item'       => __( 'Add New Project', 'imperial-core' ),
        'new_item'           => __( 'New Project', 'imperial-core' ),
        'edit_item'          => __( 'Edit Project', 'imperial-core' ),
        'view_item'          => __( 'View Project', 'imperial-core' ),
        'all_items'          => __( 'All Projects', 'imperial-core' ),
        'search_items'       => __( 'Search Projects', 'imperial-core' ),
        'parent_item_colon'  => __( 'Parent Project:', 'imperial-core' ),
        'not_found'          => __( 'No project found.', 'imperial-core' ),
        'not_found_in_trash' => __( 'No project found in Trash.', 'imperial-core' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'imperial-core' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'project' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-screenoptions',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
    );

    register_post_type( 'project', $args );
}
add_action( 'init', 'imperial_project_cpt' );

function imperial_project_taxonomy() {

    $labels = array(
        'name'              => _x( 'Project Types', 'taxonomy general name', 'imperial-core' ),
        'singular_name'     => _x( 'Project Type', 'taxonomy singular name', 'imperial-core' ),
        'search_items'      => __( 'Search Project Types', 'imperial-core' ),
        'all_items'         => __( 'All Project Types', 'imperial-core' ),
        'parent_item'       => __( 'Parent Project Type', 'imperial-core' ),
        'parent_item_colon' => __( 'Parent Project Type:', 'imperial-core' ),
        'edit_item'         => __( 'Edit Project Type', 'imperial-core' ),
        'update_item'       => __( 'Update Project Type', 'imperial-core' ),
        'add_new_item'      => __( 'Add New Project Type', 'imperial-core' ),
        'new_item_name'     => __( 'New Project Type Name', 'imperial-core' ),
        'menu_name'         => __( 'Project Type', 'imperial-core' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_nav_menus' => false,
        'rewrite'           => array( 'slug' => 'project-type' ),
    );

    register_taxonomy( 'project_type', array( 'project' ), $args );

}
add_action( 'init', 'imperial_project_taxonomy', 0 );
