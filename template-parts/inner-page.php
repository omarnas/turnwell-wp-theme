<?php
/**
 * Generic inner page layout — hero title and body content.
 *
 * @package Turnwell
 */

defined( 'ABSPATH' ) || exit;

$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
?>

  <main id="main">
    <section class="page-hero page-hero--premium" aria-labelledby="page-hero-heading">
      <?php if ( $featured_image ) : ?>
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $featured_image ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <?php endif; ?>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <section class="section section--spacious" aria-labelledby="page-content-heading">
      <div class="container container-wide">
        <h2 id="page-content-heading" class="visually-hidden"><?php the_title(); ?></h2>
        <div class="prose type-body" data-aos="fade-up" data-aos-delay="80">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
  </main>
