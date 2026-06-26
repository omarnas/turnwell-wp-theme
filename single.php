<?php
/**
 * Single post fallback template.
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        $post_id = get_queried_object_id();
        $excerpt = $post_id ? (string) get_post_field( 'post_excerpt', $post_id ) : '';

        return $excerpt ? $excerpt : 'Turnwell Industries';
    }
);

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/inner', 'page' );
    }
}

get_footer();
