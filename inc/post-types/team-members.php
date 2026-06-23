<?php
/**
 * Team Members post type and taxonomy.
 *
 * @package Turnwell
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the team_member post type.
 */
function turnwell_register_team_member_post_type() {
    $labels = [
        'name'                  => _x( 'Team Members', 'Post type general name', 'turnwell' ),
        'singular_name'         => _x( 'Team Member', 'Post type singular name', 'turnwell' ),
        'menu_name'             => _x( 'Team Members', 'Admin Menu text', 'turnwell' ),
        'name_admin_bar'        => _x( 'Team Member', 'Add New on Toolbar', 'turnwell' ),
        'add_new'               => _x( 'Add New', 'team member', 'turnwell' ),
        'add_new_item'          => __( 'Add New Team Member', 'turnwell' ),
        'new_item'              => __( 'New Team Member', 'turnwell' ),
        'edit_item'             => __( 'Edit Team Member', 'turnwell' ),
        'view_item'             => __( 'View Team Member', 'turnwell' ),
        'all_items'             => __( 'Team Members', 'turnwell' ),
        'search_items'          => __( 'Search Team Members', 'turnwell' ),
        'not_found'             => __( 'No team members found.', 'turnwell' ),
        'not_found_in_trash'    => __( 'No team members found in Trash.', 'turnwell' ),
        'featured_image'        => __( 'Profile Photo', 'turnwell' ),
        'set_featured_image'    => __( 'Set profile photo', 'turnwell' ),
        'remove_featured_image' => __( 'Remove profile photo', 'turnwell' ),
        'use_featured_image'    => __( 'Use as profile photo', 'turnwell' ),
    ];

    register_post_type(
        'team_member',
        [
            'labels'       => $labels,
            'public'       => true,
            'show_ui'      => true,
            'show_in_rest' => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-groups',
            'supports'     => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
            'rewrite'      => [
                'slug' => 'team-member',
            ],
        ]
    );
}
add_action( 'init', 'turnwell_register_team_member_post_type' );

/**
 * Register the team_category taxonomy.
 */
function turnwell_register_team_category_taxonomy() {
    $labels = [
        'name'              => _x( 'Team Categories', 'Taxonomy general name', 'turnwell' ),
        'singular_name'     => _x( 'Team Category', 'Taxonomy singular name', 'turnwell' ),
        'search_items'      => __( 'Search Team Categories', 'turnwell' ),
        'all_items'         => __( 'All Team Categories', 'turnwell' ),
        'parent_item'       => __( 'Parent Team Category', 'turnwell' ),
        'parent_item_colon' => __( 'Parent Team Category:', 'turnwell' ),
        'edit_item'         => __( 'Edit Team Category', 'turnwell' ),
        'update_item'       => __( 'Update Team Category', 'turnwell' ),
        'add_new_item'      => __( 'Add New Team Category', 'turnwell' ),
        'new_item_name'     => __( 'New Team Category Name', 'turnwell' ),
        'menu_name'         => __( 'Team Categories', 'turnwell' ),
    ];

    register_taxonomy(
        'team_category',
        [ 'team_member' ],
        [
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => [
                'slug' => 'team-category',
            ],
        ]
    );
}
add_action( 'init', 'turnwell_register_team_category_taxonomy' );

/**
 * Create default team categories if they do not exist.
 */
function turnwell_register_default_team_categories() {
    $default_terms = [
        'executive-management' => 'Executive Management',
        'leadership-team'      => 'Leadership Team',
    ];

    foreach ( $default_terms as $slug => $name ) {
        if ( ! term_exists( $slug, 'team_category' ) ) {
            wp_insert_term(
                $name,
                'team_category',
                [
                    'slug' => $slug,
                ]
            );
        }
    }
}
add_action( 'init', 'turnwell_register_default_team_categories', 20 );

/**
 * Get team members for a category slug, ordered by menu order.
 *
 * Example:
 * $members = turnwell_get_team_members_by_category( 'executive-management' );
 * foreach ( $members as $member ) {
 *     echo esc_html( get_the_title( $member ) );
 *     echo esc_html( get_field( 'position', $member->ID ) );
 * }
 *
 * @param string $category_slug Team category slug.
 * @return WP_Post[]
 */
function turnwell_get_team_members_by_category( $category_slug ) {
    $query = new WP_Query(
        [
            'post_type'              => 'team_member',
            'posts_per_page'         => -1,
            'orderby'                => 'menu_order',
            'order'                  => 'ASC',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'tax_query'              => [
                [
                    'taxonomy' => 'team_category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ],
            ],
        ]
    );

    return $query->posts;
}

/**
 * Get Executive Management team members.
 *
 * @return WP_Post[]
 */
function turnwell_get_executive_management_members() {
    return turnwell_get_team_members_by_category( 'executive-management' );
}

/**
 * Get Leadership Team members.
 *
 * @return WP_Post[]
 */
function turnwell_get_leadership_team_members() {
    return turnwell_get_team_members_by_category( 'leadership-team' );
}
