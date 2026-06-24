<?php
/**
 * Custom post type registrations.
 *
 * @package Turnwell
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the execution_phase post type.
 */
function turnwell_register_execution_phase_post_type() {
    $labels = [
        'name'               => _x( 'Execution Phases', 'Post type general name', 'turnwell' ),
        'singular_name'      => _x( 'Execution Phase', 'Post type singular name', 'turnwell' ),
        'menu_name'          => _x( 'Execution Phases', 'Admin Menu text', 'turnwell' ),
        'name_admin_bar'     => _x( 'Execution Phase', 'Add New on Toolbar', 'turnwell' ),
        'add_new'            => _x( 'Add New', 'execution phase', 'turnwell' ),
        'add_new_item'       => __( 'Add New Execution Phase', 'turnwell' ),
        'new_item'           => __( 'New Execution Phase', 'turnwell' ),
        'edit_item'          => __( 'Edit Execution Phase', 'turnwell' ),
        'view_item'          => __( 'View Execution Phase', 'turnwell' ),
        'all_items'          => __( 'Execution Phases', 'turnwell' ),
        'search_items'       => __( 'Search Execution Phases', 'turnwell' ),
        'not_found'          => __( 'No execution phases found.', 'turnwell' ),
        'not_found_in_trash' => __( 'No execution phases found in Trash.', 'turnwell' ),
    ];

    register_post_type(
        'execution_phase',
        [
            'labels'              => $labels,
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'has_archive'         => false,
            'rewrite'             => false,
            'menu_icon'           => 'dashicons-list-view',
            'supports'            => [ 'title', 'editor', 'page-attributes' ],
            'capability_type'     => 'post',
        ]
    );
}
add_action( 'init', 'turnwell_register_execution_phase_post_type' );

/**
 * Get all execution phases ordered for frontend display.
 *
 * @return WP_Post[]
 */
function turnwell_get_execution_phases() {
    $query = new WP_Query(
        [
            'post_type'              => 'execution_phase',
            'post_status'            => 'publish',
            'posts_per_page'         => -1,
            'orderby'                => [
                'menu_order' => 'ASC',
                'date'       => 'ASC',
            ],
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]
    );

    return $query->posts;
}
