<?php
/**
 * Template Name: Our Technology
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-technology';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        return 'Intelligence Embedded Across the Well Construction Sequence';
    }
);

$theme_uri          = get_template_directory_uri();
$intro_heading      = get_field( 'intro_heading' );
$technology_intro   = get_field( 'technology_intro' );
$technology_areas   = is_array( $technology_intro ) ? ( $technology_intro['technology_areas'] ?? [] ) : [];
$button_label       = get_field( 'button_label' );
$button_link        = get_field( 'button_link' );

get_header();
?>

  <main id="main">
    <!-- Hero -->
    <section class="page-hero page-hero--premium" aria-labelledby="page-hero-heading">
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $theme_uri . '/assets/images/technology-hero.jpg' ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <?php if ( ! empty( $intro_heading ) || ! empty( $technology_areas ) ) : ?>
    <section class="tech-fmap section section--grey"<?php echo ! empty( $intro_heading ) ? ' aria-labelledby="tech-intro-heading"' : ''; ?>>
      <?php if ( ! empty( $intro_heading ) ) : ?>
      <div class="container">
        <header class="inner-section-header tech-fmap__header" data-aos="fade-up">
          <h2 id="tech-intro-heading" class="section-title type-section-title"><?php echo esc_html( $intro_heading ); ?></h2>
        </header>
      </div>
      <?php endif; ?>

      <?php if ( ! empty( $technology_areas ) ) : ?>
      <div class="container">
        <div class="tech-fmap__grid">
          <?php foreach ( $technology_areas as $index => $area ) : ?>
            <?php
            $area_title   = trim( (string) ( $area['title'] ?? '' ) );
            $area_summary = trim( (string) ( $area['card_summary'] ?? '' ) );
            $area_products = is_array( $area['products'] ?? null ) ? $area['products'] : [];
            $area_id      = $area_title !== '' ? sanitize_title( $area_title ) : 'technology-area-' . (int) $index;
            $technologies = [];

            foreach ( $area_products as $product ) {
                $product_name = trim( (string) ( $product['name'] ?? '' ) );

                if ( $product_name !== '' ) {
                    $technologies[] = $product_name;
                }
            }

            if ( $area_title === '' && $area_summary === '' && empty( $technologies ) ) {
                continue;
            }
            ?>
          <a
            href="#detail-<?php echo esc_attr( $area_id ); ?>"
            class="tech-fmap__card tech-fmap__nav"
            data-tech-nav="<?php echo esc_attr( $area_id ); ?>"
            data-aos="fade-up"
            data-aos-delay="<?php echo (int) ( $index * 80 ); ?>"
          >
            <?php if ( $area_title !== '' ) : ?>
            <h3 class="tech-fmap__card-title"><?php echo esc_html( $area_title ); ?></h3>
            <?php endif; ?>
            <?php if ( $area_summary !== '' ) : ?>
            <p class="tech-fmap__card-summary"><?php echo esc_html( $area_summary ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $technologies ) ) : ?>
            <ul class="tech-fmap__card-tech">
              <?php foreach ( $technologies as $tech ) : ?>
              <li><?php echo esc_html( $tech ); ?></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $technology_areas ) || ( ! empty( $button_label ) && ! empty( $button_link ) ) ) : ?>
    <section class="tech-showcase section"<?php echo ! empty( $intro_heading ) ? ' aria-labelledby="tech-intro-heading"' : ''; ?>>
      <div class="container">
        <?php foreach ( $technology_areas as $area_index => $area ) : ?>
          <?php
          $area_title    = trim( (string) ( $area['title'] ?? '' ) );
          $area_summary  = trim( (string) ( $area['card_summary'] ?? '' ) );
          $area_products = is_array( $area['products'] ?? null ) ? $area['products'] : [];
          $area_id       = $area_title !== '' ? sanitize_title( $area_title ) : 'technology-area-' . (int) $area_index;

          if ( $area_title === '' && $area_summary === '' && empty( $area_products ) ) {
              continue;
          }
          ?>
        <article
          class="tech-domain"
          id="detail-<?php echo esc_attr( $area_id ); ?>"
          data-tech-section="<?php echo esc_attr( $area_id ); ?>"
          aria-labelledby="detail-<?php echo esc_attr( $area_id ); ?>-heading"
        >
          <?php if ( $area_title !== '' || $area_summary !== '' ) : ?>
          <header class="tech-domain__header" data-aos="fade-up">
            <?php if ( $area_title !== '' ) : ?>
            <h3 id="detail-<?php echo esc_attr( $area_id ); ?>-heading" class="tech-domain__title"><?php echo esc_html( $area_title ); ?></h3>
            <?php endif; ?>
            <?php if ( $area_summary !== '' ) : ?>
            <p class="tech-domain__summary"><?php echo esc_html( $area_summary ); ?></p>
            <?php endif; ?>
          </header>
          <?php endif; ?>

          <?php if ( ! empty( $area_products ) ) : ?>
          <div class="tech-domain__products">
            <?php foreach ( $area_products as $index => $product ) : ?>
              <?php
              $product_name        = trim( (string) ( $product['name'] ?? '' ) );
              $product_description = trim( (string) ( $product['description'] ?? '' ) );
              $product_image       = trim( (string) ( $product['image'] ?? '' ) );

              if ( $product_name === '' && $product_description === '' && $product_image === '' ) {
                  continue;
              }
              ?>
            <div
              class="tech-product<?php echo 1 === $index % 2 ? ' tech-product--reverse' : ''; ?>"
              data-aos="fade-up"
              data-aos-delay="<?php echo (int) min( $index * 60, 180 ); ?>"
            >
              <?php if ( $product_image !== '' ) : ?>
              <div class="tech-product__visual" aria-hidden="true">
                <img
                  src="<?php echo esc_url( $product_image ); ?>"
                  alt=""
                  width="800"
                  height="600"
                  loading="lazy"
                >
              </div>
              <?php endif; ?>
              <div class="tech-product__content">
                <?php if ( $product_name !== '' ) : ?>
                <h4 class="tech-product__name"><?php echo esc_html( $product_name ); ?></h4>
                <?php endif; ?>
                <?php if ( $product_description !== '' ) : ?>
                <p class="tech-product__text"><?php echo esc_html( $product_description ); ?></p>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </article>
        <?php endforeach; ?>

        <?php if ( ! empty( $button_label ) && ! empty( $button_link ) ) : ?>
        <div class="section-cta" data-aos="fade-up">
          <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn--pill"><?php echo esc_html( $button_label ); ?></a>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>
  </main>

<?php
if ( ! empty( $technology_areas ) ) {
    add_filter(
        'turnwell_footer_scripts',
        static function ( $scripts ) {
            $scripts[] = 'js/tech-journey.js?v=1.1';

            return $scripts;
        }
    );
}

get_footer();
