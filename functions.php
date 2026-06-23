<?php

require get_template_directory() . '/inc/post-types/team-members.php';


function turnwell_assets() {

    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    if ( is_front_page() ) {

        wp_enqueue_style(
            'turnwell-main',
            $theme_uri . '/css/main.css',
            [],
            filemtime( $theme_dir . '/css/main.css' )
        );

    } else {

        wp_enqueue_style(
            'turnwell-inner',
            $theme_uri . '/css/main-inner.css',
            [],
            filemtime( $theme_dir . '/css/main-inner.css' )
        );

    }

}
add_action( 'wp_enqueue_scripts', 'turnwell_assets' );

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

register_nav_menus(
    [
        'primary' => 'Primary Menu',
    ]
);

/**
 * Resolve the active primary nav item from the current page.
 *
 * @return string Nav key (home, team, execution, services, technology, news, contact) or empty string.
 */
function turnwell_resolve_active_nav() {
    $slug_map = [
        'our-team'        => 'team',
        'execution-model' => 'execution',
        'our-services'    => 'services',
        'our-technology'  => 'technology',
        'news'            => 'news',
        'contact'         => 'contact',
    ];

    if ( is_front_page() ) {
        return 'home';
    }

    if ( is_page() ) {
        $slug = get_post_field( 'post_name', get_queried_object_id() );

        return isset( $slug_map[ $slug ] ) ? $slug_map[ $slug ] : '';
    }

    return '';
}

add_filter(
    'acf/settings/save_json',
    function () {
        return get_stylesheet_directory() . '/acf-json';
    }
);

add_filter(
    'acf/settings/load_json',
    function ( $paths ) {
        $paths[] = get_stylesheet_directory() . '/acf-json';

        return $paths;
    }
);
