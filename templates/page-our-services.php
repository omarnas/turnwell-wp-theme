<?php
/**
 * Template Name: Our Services
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-services';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        return 'Execution across every phase of the well — well planning, drilling, completions, stimulation, horizontal drilling and intervention.';
    }
);

$theme_uri = get_template_directory_uri();

$services_journey_header = get_field( 'services_journey_header' );
$services_journey        = get_field( 'services_journey' );
$feature_blocks          = get_field( 'feature_blocks' );
$operational_tempo_cards = get_field( 'operational_tempo_cards' );
$button_label            = get_field( 'button_label' );
$button_url              = get_field( 'button_url' );

$journey_header_lines = [];

if ( ! empty( $services_journey_header ) ) {
    $journey_header_lines = preg_split( '/\r\n|\r|\n/', (string) $services_journey_header );
    $journey_header_lines = array_values(
        array_filter(
            array_map(
                static function ( $line ) {
                    return trim( (string) $line );
                },
                $journey_header_lines
            ),
            static function ( $line ) {
                return $line !== '';
            }
        )
    );
}

get_header();
?>

  <main id="main">
    <!-- Hero -->
    <section class="page-hero page-hero--premium" aria-labelledby="page-hero-heading">
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $theme_uri . '/assets/images/services-banner.jpg' ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <?php if ( ! empty( $journey_header_lines ) || ! empty( $services_journey ) ) : ?>
    <!-- Operational service journey -->
    <section class="services-journey section section--spacious"<?php echo ! empty( $journey_header_lines ) ? ' aria-labelledby="services-journey-heading"' : ''; ?>>
      <div class="container services-journey__layout">
        <?php if ( ! empty( $journey_header_lines ) ) : ?>
        <header class="inner-section-header services-section-header services-journey__intro" data-aos="fade-up">
          <h2 id="services-journey-heading" class="section-title type-section-title services-journey__title">
            <?php foreach ( $journey_header_lines as $line ) : ?>
            <span class="services-journey__title-line"><?php echo esc_html( $line ); ?></span>
            <?php endforeach; ?>
          </h2>
        </header>
        <?php endif; ?>

        <?php if ( ! empty( $services_journey ) ) : ?>
        <ul class="services-journey__flow">
          <?php foreach ( $services_journey as $index => $service ) : ?>
            <?php
            $step_title     = trim( (string) ( $service['step_title'] ?? '' ) );
            $step_text      = trim( (string) ( $service['step_text'] ?? '' ) );
            $step_highlight = trim( (string) ( $service['step_highlight'] ?? '' ) );
            $step_id        = $step_title !== '' ? sanitize_title( $step_title ) : 'service-step-' . (int) $index;

            if ( $step_title === '' && $step_text === '' && $step_highlight === '' ) {
                continue;
            }
            ?>
          <li
            class="services-journey__step"
            id="<?php echo esc_attr( $step_id ); ?>"
            data-aos="fade-up"
            data-aos-delay="<?php echo (int) min( $index * 40, 200 ); ?>"
          >
            <div class="services-journey__step-aside" aria-hidden="true">
              <span class="services-journey__marker"></span>
            </div>
            <article class="services-journey__step-body">
              <?php if ( $step_title !== '' ) : ?>
              <h3 class="services-journey__step-title"><?php echo esc_html( $step_title ); ?></h3>
              <?php endif; ?>
              <?php if ( $step_text !== '' ) : ?>
              <p class="services-journey__step-text"><?php echo esc_html( $step_text ); ?></p>
              <?php endif; ?>
              <?php if ( $step_highlight !== '' ) : ?>
              <p class="services-journey__step-highlight"><?php echo esc_html( $step_highlight ); ?></p>
              <?php endif; ?>
            </article>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $feature_blocks ) ) : ?>
      <?php foreach ( $feature_blocks as $index => $block ) : ?>
        <?php
        $block_title       = trim( (string) ( $block['title'] ?? '' ) );
        $block_description = trim( (string) ( $block['description'] ?? '' ) );
        $block_image       = trim( (string) ( $block['image'] ?? '' ) );
        $is_procurement    = $index > 0;
        $heading_id        = $is_procurement ? 'procurement-heading' : 'hse-heading';

        if ( $block_title === '' && $block_description === '' && $block_image === '' ) {
            continue;
        }
        ?>
        <?php if ( $is_procurement ) : ?>
    <!-- Procurement -->
    <section class="services-procurement section section--grey section--spacious" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
      <div class="container">
        <div class="services-procurement__split services-procurement__split--reverse">
          <?php if ( $block_image !== '' ) : ?>
          <div class="services-procurement__media" data-aos="fade-left">
            <div class="services-procurement__image">
              <img
                src="<?php echo esc_url( $block_image ); ?>"
                alt=""
                width="900"
                height="1100"
                loading="lazy"
              >
            </div>
          </div>
          <?php endif; ?>
          <div class="services-procurement__body" data-aos="fade-right">
            <?php if ( $block_title !== '' ) : ?>
            <header class="inner-section-header services-section-header services-procurement__header">
              <h2 id="<?php echo esc_attr( $heading_id ); ?>" class="section-title type-section-title"><?php echo esc_html( $block_title ); ?></h2>
            </header>
            <?php endif; ?>
            <?php if ( $block_description !== '' ) : ?>
            <div class="prose type-body services-procurement__prose">
              <p><?php echo esc_html( $block_description ); ?></p>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
        <?php else : ?>
    <!-- Health, Safety and Environment -->
    <section class="services-hse section section--spacious" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
      <div class="container">
        <div class="services-hse__split">
          <?php if ( $block_image !== '' ) : ?>
          <div class="services-hse__media" data-aos="fade-right">
            <div class="services-hse__image">
              <img
                src="<?php echo esc_url( $block_image ); ?>"
                alt=""
                width="900"
                height="1100"
                loading="lazy"
              >
            </div>
          </div>
          <?php endif; ?>
          <div class="services-hse__body" data-aos="fade-left">
            <?php if ( $block_title !== '' ) : ?>
            <header class="inner-section-header services-section-header services-hse__header">
              <h2 id="<?php echo esc_attr( $heading_id ); ?>" class="section-title type-section-title"><?php echo esc_html( $block_title ); ?></h2>
            </header>
            <?php endif; ?>
            <?php if ( $block_description !== '' ) : ?>
            <div class="prose type-body services-hse__prose">
              <p><?php echo esc_html( $block_description ); ?></p>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if ( ! empty( $operational_tempo_cards ) || ( ! empty( $button_label ) && ! empty( $button_url ) ) ) : ?>
    <section class="services-framework section section--grey section--spacious">
      <div class="container container-wide">
        <?php if ( ! empty( $operational_tempo_cards ) ) : ?>
        <div class="services-framework__grid">
          <?php foreach ( $operational_tempo_cards as $index => $card ) : ?>
            <?php
            $card_title       = trim( (string) ( $card['title'] ?? '' ) );
            $card_description = trim( (string) ( $card['description'] ?? '' ) );
            $card_icon        = trim( (string) ( $card['icon'] ?? '' ) );

            if ( $card_title === '' && $card_description === '' && $card_icon === '' ) {
                continue;
            }
            ?>
          <article class="services-framework__card" data-aos="fade-up" data-aos-delay="<?php echo (int) ( ( $index % 3 ) * 60 ); ?>">
            <?php if ( $card_icon !== '' ) : ?>
            <span class="services-icon services-framework__icon" aria-hidden="true">
              <img src="<?php echo esc_url( $card_icon ); ?>" alt="" width="22" height="22">
            </span>
            <?php endif; ?>
            <?php if ( $card_title !== '' ) : ?>
            <h3 class="services-framework__card-title"><?php echo esc_html( $card_title ); ?></h3>
            <?php endif; ?>
            <?php if ( $card_description !== '' ) : ?>
            <p class="services-framework__card-text"><?php echo esc_html( $card_description ); ?></p>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $button_label ) && ! empty( $button_url ) ) : ?>
        <div class="section-cta" data-aos="fade-up">
          <a href="<?php echo esc_url( $button_url ); ?>" class="btn btn--pill"><?php echo esc_html( $button_label ); ?></a>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>
  </main>

<?php
get_footer();
