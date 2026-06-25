<?php
/**
 * Theme header.
 *
 * @package Turnwell
 */

$theme_uri = get_template_directory_uri();

$page_description = apply_filters( 'turnwell_page_description', 'Turnwell Industries' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo esc_attr( $page_description ); ?>">
  <?php wp_head(); ?>
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css?v=0.1" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo esc_url( $theme_uri . '/assets/fav/favicon-96x96.png' ); ?>" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( $theme_uri . '/assets/fav/favicon.svg' ); ?>" />
  <link rel="shortcut icon" href="<?php echo esc_url( $theme_uri . '/assets/fav/favicon.ico' ); ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $theme_uri . '/assets/fav/apple-touch-icon.png' ); ?>" />
  <link rel="manifest" href="<?php echo esc_url( $theme_uri . '/assets/fav/site.webmanifest' ); ?>" />
</head>
<body <?php body_class( apply_filters( 'turnwell_body_class', '' ) ); ?>>
  <a class="skip-link" href="#main">Skip to content</a>

  <header class="site-header" id="site-header">
    <div class="header-inner container">
      <a class="logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Turnwell home">
        <img src="<?php echo esc_url( $theme_uri . '/assets/images/logos/turnwelllogo_1.svg' ); ?>" alt="Turnwell" width="200" height="35" class="logo-img">
      </a>

      <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu">
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
      </button>

      <nav class="primary-nav" id="primary-nav" aria-label="Primary">
        <?php
        wp_nav_menu(
            [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-list',
                'fallback_cb'    => 'turnwell_primary_menu_fallback',
                'depth'          => 1,
            ]
        );
        ?>
      </nav>
    </div>
  </header>
