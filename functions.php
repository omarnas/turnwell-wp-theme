<?php

require get_template_directory() . '/inc/post-types.php';
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
        'our-team'            => 'team',
        'execution-model'     => 'execution',
        'our-execution-model' => 'execution',
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

/**
 * Whether the current user may upload SVG files.
 *
 * @return bool
 */
function turnwell_user_can_upload_svg() {
    return current_user_can( 'manage_options' );
}

/**
 * Allow SVG mime types for administrators.
 *
 * @param array<string, string> $mimes Allowed mime types.
 * @return array<string, string>
 */
function turnwell_allow_svg_mime_types( $mimes ) {
    if ( ! turnwell_user_can_upload_svg() ) {
        return $mimes;
    }

    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter( 'upload_mimes', 'turnwell_allow_svg_mime_types' );

/**
 * Fix WordPress SVG file type validation.
 *
 * @param array<string, string|false> $data     File data array.
 * @param string                      $file     Full path to the file.
 * @param string                      $filename File name.
 * @param array<string, string>       $mimes    Allowed mime types.
 * @return array<string, string|false>
 */
function turnwell_fix_svg_filetype( $data, $file, $filename, $mimes ) {
    if ( ! turnwell_user_can_upload_svg() ) {
        return $data;
    }

    $extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

    if ( 'svg' === $extension || 'svgz' === $extension ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'turnwell_fix_svg_filetype', 10, 4 );

/**
 * Block SVG uploads for non-administrators.
 *
 * @param array<string, mixed> $file Upload file data.
 * @return array<string, mixed>
 */
function turnwell_restrict_svg_uploads( $file ) {
    if ( turnwell_user_can_upload_svg() ) {
        return $file;
    }

    $extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

    if ( in_array( $extension, [ 'svg', 'svgz' ], true ) ) {
        $file['error'] = __( 'Sorry, you are not allowed to upload SVG files.', 'turnwell' );
    }

    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'turnwell_restrict_svg_uploads' );

/**
 * Read SVG width and height from file attributes or viewBox.
 *
 * @param string $svg_path Absolute path to an SVG file.
 * @return array{width: int, height: int}|null
 */
function turnwell_get_svg_dimensions( $svg_path ) {
    if ( ! is_readable( $svg_path ) ) {
        return null;
    }

    $svg = simplexml_load_file( $svg_path );

    if ( false === $svg ) {
        return null;
    }

    $attributes = $svg->attributes();
    $width      = isset( $attributes->width ) ? (float) $attributes->width : 0;
    $height     = isset( $attributes->height ) ? (float) $attributes->height : 0;

    if ( ( ! $width || ! $height ) && isset( $attributes->viewBox ) ) {
        $view_box = preg_split( '/[\s,]+/', trim( (string) $attributes->viewBox ) );

        if ( 4 === count( $view_box ) ) {
            $width  = (float) $view_box[2];
            $height = (float) $view_box[3];
        }
    }

    if ( ! $width || ! $height ) {
        return null;
    }

    return [
        'width'  => (int) round( $width ),
        'height' => (int) round( $height ),
    ];
}

/**
 * Store SVG dimensions in attachment metadata.
 *
 * @param array<string, mixed>|false $metadata      Attachment metadata.
 * @param int                        $attachment_id Attachment ID.
 * @return array<string, mixed>|false
 */
function turnwell_set_svg_attachment_metadata( $metadata, $attachment_id ) {
    if ( 'image/svg+xml' !== get_post_mime_type( $attachment_id ) ) {
        return $metadata;
    }

    $svg_path = get_attached_file( $attachment_id );

    if ( ! $svg_path ) {
        return $metadata;
    }

    $dimensions = turnwell_get_svg_dimensions( $svg_path );

    if ( ! $dimensions ) {
        return $metadata;
    }

    if ( ! is_array( $metadata ) ) {
        $metadata = [];
    }

    $metadata['width']  = $dimensions['width'];
    $metadata['height'] = $dimensions['height'];

    return $metadata;
}
add_filter( 'wp_generate_attachment_metadata', 'turnwell_set_svg_attachment_metadata', 10, 2 );

/**
 * Allow SVG files to be treated as displayable images.
 *
 * @param bool   $result Whether the file is displayable.
 * @param string $path   File path.
 * @return bool
 */
function turnwell_svg_is_displayable_image( $result, $path ) {
    if ( $result ) {
        return $result;
    }

    $extension = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );

    return in_array( $extension, [ 'svg', 'svgz' ], true );
}
add_filter( 'file_is_displayable_image', 'turnwell_svg_is_displayable_image', 10, 2 );

/**
 * Enable SVG previews in the Media Library.
 *
 * @param array<string, mixed> $response   Attachment JS data.
 * @param WP_Post              $attachment Attachment post object.
 * @param array<string, mixed> $meta       Attachment metadata.
 * @return array<string, mixed>
 */
function turnwell_prepare_svg_for_js( $response, $attachment, $meta ) {
    if ( empty( $response['mime'] ) || 'image/svg+xml' !== $response['mime'] ) {
        return $response;
    }

    $svg_url = $response['url'] ?? '';
    $width   = isset( $meta['width'] ) ? (int) $meta['width'] : 150;
    $height  = isset( $meta['height'] ) ? (int) $meta['height'] : 150;

    if ( ( ! $width || ! $height ) && ! empty( $attachment->ID ) ) {
        $svg_path = get_attached_file( $attachment->ID );

        if ( $svg_path ) {
            $dimensions = turnwell_get_svg_dimensions( $svg_path );

            if ( $dimensions ) {
                $width  = $dimensions['width'];
                $height = $dimensions['height'];
            }
        }
    }

    $size = [
        'url'         => $svg_url,
        'width'       => $width,
        'height'      => $height,
        'orientation' => $height >= $width ? 'portrait' : 'landscape',
    ];

    $response['type']    = 'image';
    $response['subtype'] = 'svg+xml';
    $response['icon']  = $svg_url;
    $response['sizes'] = [
        'full'      => $size,
        'thumbnail' => $size,
        'medium'    => $size,
        'large'     => $size,
    ];
    $response['image'] = [
        'src'    => $svg_url,
        'width'  => $width,
        'height' => $height,
    ];
    $response['thumb'] = [
        'src'    => $svg_url,
        'width'  => $width,
        'height' => $height,
    ];

    return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'turnwell_prepare_svg_for_js', 10, 3 );

/**
 * Improve SVG thumbnail rendering in the admin.
 */
function turnwell_svg_admin_styles() {
    ?>
    <style>
        .attachment .thumbnail img[src$=".svg"],
        .media-icon img[src$=".svg"] {
            width: 100%;
            height: auto;
        }
    </style>
    <?php
}
add_action( 'admin_head', 'turnwell_svg_admin_styles' );
