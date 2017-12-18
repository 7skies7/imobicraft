<?php
add_action( 'cmb2_admin_init', 'imperial_project_metabox' );

function imperial_project_metabox() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_imperial_';

    $imperial_project = new_cmb2_box( array(
        'id'            => 'running_project_meta',
        'title'         => esc_html__( 'Project Meta info', 'imperial-core' ),
        'object_types'  => array( 'project' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
    ) );
    $imperial_project->add_field( array(
        'name' => esc_html__( 'Project In Progress', 'imperial-core' ),
        'desc' => esc_html__( 'Check the field if the project is work in progress', 'imperial-core' ),
        'id'      => 'project_wip',
        'type'    => 'radio_inline',
        'options' => array(
            'wip' => __( 'Work in progress', 'imperial-core' ),
            'complete'   => __( 'Completed project', 'imperial-core' ),
        ),
        'default' => 'wip',
    ) );
    $imperial_project->add_field( array(
        'name' => esc_html__( 'Client Name', 'imperial-core' ),
        'desc' => esc_html__( 'Enter client name here', 'imperial-core' ),
        'id'   => 'client_name',
        'type' => 'text',
    ) );
    $imperial_project->add_field( array(
        'name' => esc_html__( 'Location', 'imperial-core' ),
        'desc' => esc_html__( 'Enter location name here', 'imperial-core' ),
        'id'   => 'location',
        'type' => 'text',
    ) );
    $imperial_project->add_field( array(
        'name' => esc_html__( 'Project start date', 'imperial-core' ),
        'desc' => esc_html__( 'Click to enter start date', 'imperial-core' ),
        'id'   => 'project_start_date',
        'type' => 'text_date',
    ) );
    $imperial_project->add_field( array(
        'name' => esc_html__( 'Project completion date', 'imperial-core' ),
        'desc' => esc_html__( 'Click to enter completion date', 'imperial-core' ),
        'id'   => 'handover_date',
        'type' => 'text_date',
    ) );
}