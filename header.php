<?php
/**
 * Theme header.
 *
 * @package Turnwell
 */

$theme_uri = get_template_directory_uri();

$page_description = apply_filters( 'turnwell_page_description', 'Turnwell Industries' );

$active_nav = apply_filters( 'turnwell_active_nav', turnwell_resolve_active_nav() );

$nav_home      = $active_nav === 'home' ? ' is-active' : '';
$nav_team      = $active_nav === 'team' ? ' is-active' : '';
$nav_execution = $active_nav === 'execution' ? ' is-active' : '';
$nav_services  = $active_nav === 'services' ? ' is-active' : '';
$nav_technology = $active_nav === 'technology' ? ' is-active' : '';
$nav_news      = $active_nav === 'news' ? ' is-active' : '';
$nav_contact   = $active_nav === 'contact' ? ' is-active' : '';
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
        <ul class="nav-list">
          <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_home ); ?>">Home</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-team/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_team ); ?>">Our Team</a></li>
          <li><a href="<?php echo esc_url( home_url( '/execution-model/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_execution ); ?>">Our Execution Model</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-services/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_services ); ?>">Our Services</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-technology/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_technology ); ?>">Our Technology</a></li>
          <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_news ); ?>">News &amp; Media</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="nav-link<?php echo esc_attr( $nav_contact ); ?>">Contact</a></li>
        </ul>

      </nav>
    </div>
  </header>
