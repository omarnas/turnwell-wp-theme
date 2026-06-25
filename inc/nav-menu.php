<?php
/**
 * Primary navigation menu helpers.
 *
 * @package Turnwell
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add nav-link and is-active classes to primary menu links.
 *
 * @param array<string, string> $atts Link attributes.
 * @param WP_Post               $item Menu item.
 * @param stdClass              $args Menu arguments.
 * @return array<string, string>
 */
function turnwell_primary_nav_link_attributes( $atts, $item, $args ) {
    if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $atts;
    }

    $classes   = isset( $atts['class'] ) ? $atts['class'] . ' ' : '';
    $classes  .= 'nav-link';
    $is_active = in_array( 'current-menu-item', $item->classes, true )
        || in_array( 'current-menu-ancestor', $item->classes, true );

    if ( $is_active ) {
        $classes .= ' is-active';
    }

    $atts['class'] = trim( $classes );

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'turnwell_primary_nav_link_attributes', 10, 3 );

/**
 * Mark the News page active on single news posts.
 *
 * @param array<int, string> $classes Menu item classes.
 * @param WP_Post            $item    Menu item.
 * @param stdClass           $args    Menu arguments.
 * @return array<int, string>
 */
function turnwell_primary_nav_item_classes( $classes, $item, $args ) {
    if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $classes;
    }

    if ( ! is_singular( 'post' ) || ! has_category( 'news' ) ) {
        return $classes;
    }

    if ( 'page' !== $item->object || 'post_type' !== $item->type ) {
        return $classes;
    }

    $news_page = get_page_by_path( 'news' );

    if ( $news_page && (int) $item->object_id === (int) $news_page->ID ) {
        $classes[] = 'current-menu-item';
    }

    return $classes;
}
add_filter( 'nav_menu_css_class', 'turnwell_primary_nav_item_classes', 10, 3 );

/**
 * Fallback markup when no primary menu is assigned.
 */
function turnwell_primary_menu_fallback() {
    $items = [
        [
            'url'    => home_url( '/' ),
            'label'  => 'Home',
            'active' => is_front_page(),
        ],
        [
            'url'    => home_url( '/our-team/' ),
            'label'  => 'Our Team',
            'active' => is_page( 'our-team' ),
        ],
        [
            'url'    => home_url( '/our-execution-model/' ),
            'label'  => 'Our Execution Model',
            'active' => is_page( [ 'our-execution-model', 'execution-model' ] ),
        ],
        [
            'url'    => home_url( '/our-services/' ),
            'label'  => 'Our Services',
            'active' => is_page( 'our-services' ),
        ],
        [
            'url'    => home_url( '/our-technology/' ),
            'label'  => 'Our Technology',
            'active' => is_page( 'our-technology' ),
        ],
        [
            'url'    => home_url( '/news/' ),
            'label'  => 'News & Media',
            'active' => is_page( 'news' ) || ( is_singular( 'post' ) && has_category( 'news' ) ),
        ],
        [
            'url'    => home_url( '/contact-us/' ),
            'label'  => 'Contact',
            'active' => is_page( [ 'contact-us', 'contact' ] ),
        ],
    ];

    echo '<ul class="nav-list">';

    foreach ( $items as $item ) {
        $class = 'nav-link' . ( ! empty( $item['active'] ) ? ' is-active' : '' );
        printf(
            '<li><a href="%1$s" class="%2$s">%3$s</a></li>',
            esc_url( $item['url'] ),
            esc_attr( $class ),
            esc_html( $item['label'] )
        );
    }

    echo '</ul>';
}

/**
 * Create and assign the default primary menu if none exists.
 */
function turnwell_seed_primary_menu() {
    if ( get_option( 'turnwell_primary_menu_seeded' ) ) {
        return;
    }

    $locations = get_nav_menu_locations();

    if ( ! empty( $locations['primary'] ) ) {
        update_option( 'turnwell_primary_menu_seeded', 1 );

        return;
    }

    $menu_name = 'Primary Menu';
    $menu      = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        if ( is_wp_error( $menu_id ) ) {
            return;
        }
    } else {
        $menu_id = (int) $menu->term_id;
    }

    $page_slugs = [
        'our-team',
        'our-execution-model',
        'our-services',
        'our-technology',
        'news',
        'contact-us',
    ];

    wp_update_nav_menu_item(
        $menu_id,
        0,
        [
            'menu-item-title'  => 'Home',
            'menu-item-url'    => home_url( '/' ),
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
        ]
    );

    foreach ( $page_slugs as $slug ) {
        $page = get_page_by_path( $slug );

        if ( ! $page instanceof WP_Post ) {
            continue;
        }

        wp_update_nav_menu_item(
            $menu_id,
            0,
            [
                'menu-item-title'     => $page->post_title,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page->ID,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]
        );
    }

    set_theme_mod( 'nav_menu_locations', array_merge( $locations, [ 'primary' => $menu_id ] ) );
    update_option( 'turnwell_primary_menu_seeded', 1 );
}
add_action( 'after_setup_theme', 'turnwell_seed_primary_menu', 20 );
