<?php
/**
 * Theme asset loading — parallel CSS/JS, deferred non-critical resources.
 *
 * @package Turnwell
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cache-busting version from file modification time.
 *
 * @param string $relative_path Path relative to the theme root.
 */
function turnwell_asset_version( $relative_path ) {
	$path = get_template_directory() . '/' . ltrim( $relative_path, '/' );

	return file_exists( $path ) ? (string) filemtime( $path ) : '1.0';
}

/**
 * Whether the current view uses AOS scroll animations.
 */
function turnwell_page_uses_aos() {
	return is_front_page() || is_page() || is_singular( 'post' );
}

/**
 * Enqueue theme styles and scripts.
 */
function turnwell_enqueue_assets() {
	$css_uri    = get_template_directory_uri() . '/css/';
	$js_uri     = get_template_directory_uri() . '/js/';
	$vendor_uri = get_template_directory_uri() . '/assets/vendor/aos/';

	wp_enqueue_style(
		'turnwell-fonts',
		$css_uri . 'fonts.css',
		[],
		turnwell_asset_version( 'css/fonts.css' )
	);
	wp_enqueue_style(
		'turnwell-variables',
		$css_uri . 'variables.css',
		[ 'turnwell-fonts' ],
		turnwell_asset_version( 'css/variables.css' )
	);
	wp_enqueue_style(
		'turnwell-base',
		$css_uri . 'base.css',
		[ 'turnwell-variables' ],
		turnwell_asset_version( 'css/base.css' )
	);
	wp_enqueue_style(
		'turnwell-components',
		$css_uri . 'components.css',
		[ 'turnwell-base' ],
		turnwell_asset_version( 'css/components.css' )
	);
	wp_enqueue_style(
		'turnwell-responsive',
		$css_uri . 'responsive.css',
		[ 'turnwell-components' ],
		turnwell_asset_version( 'css/responsive.css' )
	);

	if ( is_front_page() ) {
		wp_enqueue_style(
			'turnwell-sections',
			$css_uri . 'sections.css',
			[ 'turnwell-components' ],
			turnwell_asset_version( 'css/sections.css' )
		);
		wp_enqueue_style(
			'turnwell-animations',
			$css_uri . 'animations.css',
			[ 'turnwell-sections' ],
			turnwell_asset_version( 'css/animations.css' )
		);
	} else {
		wp_enqueue_style(
			'turnwell-inner-components',
			$css_uri . 'inner-components.css',
			[ 'turnwell-components' ],
			turnwell_asset_version( 'css/inner-components.css' )
		);
		wp_enqueue_style(
			'turnwell-inner-sections',
			$css_uri . 'inner-sections.css',
			[ 'turnwell-inner-components' ],
			turnwell_asset_version( 'css/inner-sections.css' )
		);
		wp_enqueue_style(
			'turnwell-inner-responsive',
			$css_uri . 'inner-responsive.css',
			[ 'turnwell-inner-sections' ],
			turnwell_asset_version( 'css/inner-responsive.css' )
		);

		$inner_styles = [
			'inner-execution.css',
			'inner-services.css',
			'inner-technology.css',
			'inner-news.css',
			'inner-contact.css',
			'inner-careers.css',
			'inner-about.css',
		];

		foreach ( $inner_styles as $file ) {
			$handle = 'turnwell-' . str_replace( '.css', '', $file );

			wp_enqueue_style(
				$handle,
				$css_uri . $file,
				[ 'turnwell-inner-sections' ],
				turnwell_asset_version( 'css/' . $file )
			);
		}
	}

	if ( is_front_page() || is_page_template( 'templates/page-our-team.php' ) ) {
		wp_enqueue_style(
			'turnwell-team-modal',
			$css_uri . 'team-modal.css',
			[ is_front_page() ? 'turnwell-sections' : 'turnwell-inner-sections' ],
			turnwell_asset_version( 'css/team-modal.css' )
		);
	}

	if ( turnwell_page_uses_aos() ) {
		wp_enqueue_style(
			'turnwell-aos',
			$vendor_uri . 'aos.css',
			[],
			turnwell_asset_version( 'assets/vendor/aos/aos.css' )
		);
		wp_enqueue_script(
			'turnwell-aos',
			$vendor_uri . 'aos.js',
			[],
			turnwell_asset_version( 'assets/vendor/aos/aos.js' ),
			true
		);
	}

	$main_deps = turnwell_page_uses_aos() ? [ 'turnwell-aos' ] : [];

	wp_enqueue_script(
		'turnwell-main',
		$js_uri . 'main.js',
		$main_deps,
		turnwell_asset_version( 'js/main.js' ),
		true
	);

	if ( is_page_template( 'templates/page-execution-model.php' ) ) {
		wp_enqueue_script(
			'turnwell-execution-story',
			$js_uri . 'execution-story.js',
			[ 'turnwell-main' ],
			turnwell_asset_version( 'js/execution-story.js' ),
			true
		);
	}

	if ( is_page_template( 'templates/page-our-technology.php' ) ) {
		wp_enqueue_script(
			'turnwell-tech-journey',
			$js_uri . 'tech-journey.js',
			[ 'turnwell-main' ],
			turnwell_asset_version( 'js/tech-journey.js' ),
			true
		);
	}

	if ( is_page_template( 'templates/page-contact.php' ) ) {
		wp_enqueue_script(
			'turnwell-contact-page',
			$js_uri . 'contact-page.js',
			[ 'turnwell-main' ],
			turnwell_asset_version( 'js/contact-page.js' ),
			true
		);
	}

	if ( is_front_page() || is_page_template( 'templates/page-our-team.php' ) ) {
		wp_enqueue_script(
			'turnwell-team-modal',
			$js_uri . 'team-modal.js',
			[ 'turnwell-main' ],
			turnwell_asset_version( 'js/team-modal.js' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'turnwell_enqueue_assets' );

/**
 * Load non-critical styles without blocking first paint.
 *
 * @param string $html   Link tag HTML.
 * @param string $handle Style handle.
 * @param string $href   Style URL.
 * @param string $media  Media attribute.
 */
function turnwell_async_style_loader_tag( $html, $handle, $href, $media ) {
	$async_handles = [ 'turnwell-animations', 'turnwell-team-modal', 'turnwell-aos' ];

	if ( ! in_array( $handle, $async_handles, true ) ) {
		return $html;
	}

	return sprintf(
		'<link rel="stylesheet" id="%1$s-css" href="%2$s" media="print" onload="this.media=\'all\'">%3$s',
		esc_attr( $handle ),
		esc_url( $href ),
		sprintf( '<noscript><link rel="stylesheet" href="%s"></noscript>', esc_url( $href ) )
	);
}
add_filter( 'style_loader_tag', 'turnwell_async_style_loader_tag', 10, 4 );

/**
 * Defer theme scripts.
 *
 * @param string $tag    Script tag HTML.
 * @param string $handle Script handle.
 * @param string $src    Script URL.
 */
function turnwell_defer_script_loader_tag( $tag, $handle, $src ) {
	$defer_handles = [
		'turnwell-main',
		'turnwell-aos',
		'turnwell-team-modal',
		'turnwell-execution-story',
		'turnwell-tech-journey',
		'turnwell-contact-page',
	];

	if ( in_array( $handle, $defer_handles, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'turnwell_defer_script_loader_tag', 10, 3 );

/**
 * Preload the primary heading font for faster LCP text render.
 */
function turnwell_preload_fonts() {
	$font_uri = get_template_directory_uri() . '/assets/fontsv2/Nekst-Bold.woff2';

	echo '<link rel="preload" href="' . esc_url( $font_uri ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}
add_action( 'wp_head', 'turnwell_preload_fonts', 1 );
