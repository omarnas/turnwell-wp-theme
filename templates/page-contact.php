<?php
/**
 * Template Name: Contact Us
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-contact';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        $intro = get_field( 'header_intro' );

        return is_string( $intro ) ? $intro : '';
    }
);

$theme_uri     = get_template_directory_uri();
$header_intro  = get_field( 'header_intro' );
$office_title  = get_field( 'office_title' );
$address_lines = get_field( 'lines' );
$map_embed     = get_field( 'map_embed' );
$map_link      = get_field( 'map_link' );
$quick_cards   = get_field( 'cards' );
$phone         = get_field( 'phone' );

$office_lines = [];

if ( ! empty( $address_lines ) ) {
    $office_lines = preg_split( '/\r\n|\r|\n/', (string) $address_lines );
    $office_lines = array_values(
        array_filter(
            array_map(
                static function ( $line ) {
                    return trim( (string) $line );
                },
                $office_lines
            ),
            static function ( $line ) {
                return $line !== '';
            }
        )
    );
}

$inquiry_types = [];

if ( ! empty( $quick_cards ) ) {
    foreach ( $quick_cards as $card ) {
        $inquiry_value = trim( (string) ( $card['inquiry'] ?? '' ) );
        $inquiry_label = trim( (string) ( $card['title'] ?? '' ) );

        if ( $inquiry_value !== '' && $inquiry_label !== '' ) {
            $inquiry_types[ $inquiry_value ] = $inquiry_label;
        }
    }
}

get_header();
?>

  <main id="main">
    <section class="page-hero page-hero--premium" aria-labelledby="page-hero-heading">
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $theme_uri . '/assets/images/contactus-banner.jpg' ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <?php if ( ! empty( $header_intro ) || ! empty( $quick_cards ) || ! empty( $office_title ) || ! empty( $office_lines ) || ! empty( $map_embed ) ) : ?>
    <section class="contact-main section section--spacious" aria-labelledby="contact-main-heading">
      <div class="contact-main__backdrop" aria-hidden="true"></div>
      <div class="container container-wide contact-main__inner">
        <header class="inner-section-header inner-section-header--center" data-aos="fade-up">
          <h2 id="contact-main-heading" class="section-title type-section-title">Get in Touch</h2>
          <?php if ( ! empty( $header_intro ) ) : ?>
          <p class="section-lead"><?php echo esc_html( $header_intro ); ?></p>
          <?php endif; ?>
        </header>

        <?php if ( ! empty( $quick_cards ) ) : ?>
        <div class="contact-main__block contact-main__block--quick" data-aos="fade-up" data-aos-delay="60">
          <div class="contact-quick" role="list">
            <?php foreach ( $quick_cards as $index => $card ) : ?>
              <?php
              $card_title       = trim( (string) ( $card['title'] ?? '' ) );
              $card_description = trim( (string) ( $card['description'] ?? '' ) );
              $card_inquiry     = trim( (string) ( $card['inquiry'] ?? '' ) );

              if ( $card_title === '' && $card_description === '' && $card_inquiry === '' ) {
                  continue;
              }
              ?>
            <button
              type="button"
              class="contact-quick__card"
              role="listitem"
              data-inquiry-target="<?php echo esc_attr( $card_inquiry ); ?>"
              aria-pressed="false"
              data-aos="fade-up"
              data-aos-delay="<?php echo (int) ( $index * 80 ); ?>"
            >
              <span class="contact-quick__icon" aria-hidden="true">
                <?php if ( $card_inquiry === 'partnership' ) : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                <?php elseif ( $card_inquiry === 'supplier' ) : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M9 15l2 2 4-4"/></svg>
                <?php else : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                <?php endif; ?>
              </span>
              <span class="contact-quick__content">
                <?php if ( $card_title !== '' ) : ?>
                <span class="contact-quick__title"><?php echo esc_html( $card_title ); ?></span>
                <?php endif; ?>
                <?php if ( $card_description !== '' ) : ?>
                <span class="contact-quick__text"><?php echo esc_html( $card_description ); ?></span>
                <?php endif; ?>
              </span>
            </button>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <div class="contact-main__block contact-main__block--experience" data-aos="fade-up" data-aos-delay="100">
          <div class="contact-experience">
            <?php if ( ! empty( $office_title ) || ! empty( $office_lines ) || ! empty( $map_embed ) || ! empty( $phone ) || ! empty( $map_link ) ) : ?>
            <aside class="contact-experience__aside" aria-labelledby="contact-office-heading">
              <article class="contact-panel">
                <?php if ( ! empty( $office_title ) ) : ?>
                <header class="contact-panel__header">
                  <p class="contact-panel__eyebrow">Office</p>
                  <h3 id="contact-office-heading" class="contact-panel__title"><?php echo esc_html( $office_title ); ?></h3>
                </header>
                <?php endif; ?>

                <?php if ( ! empty( $map_embed ) ) : ?>
                <div class="contact-panel__map">
                  <iframe
                    class="contact-panel__map-embed"
                    src="<?php echo esc_url( $map_embed ); ?>"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Turnwell office location map"
                  ></iframe>
                </div>
                <?php endif; ?>

                <div class="contact-panel__body">
                  <?php if ( ! empty( $office_lines ) ) : ?>
                  <div class="contact-panel__section">
                    <p class="contact-panel__company"><?php echo esc_html( $office_lines[0] ); ?></p>
                    <?php if ( count( $office_lines ) > 1 ) : ?>
                    <address class="contact-panel__address">
                      <?php foreach ( array_slice( $office_lines, 1 ) as $line ) : ?>
                      <span><?php echo esc_html( $line ); ?></span>
                      <?php endforeach; ?>
                    </address>
                    <?php endif; ?>
                  </div>
                  <?php endif; ?>

                  <?php if ( ! empty( $phone ) || ! empty( $map_link ) ) : ?>
                  <div class="contact-panel__channels" aria-label="Contact channels">
                    <?php if ( ! empty( $phone ) ) : ?>
                    <div class="contact-panel__channel">
                      <span class="contact-panel__channel-label">Telephone</span>
                      <p class="contact-panel__channel-value"><?php echo esc_html( $phone ); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $map_link ) ) : ?>
                    <a
                      class="contact-panel__map-link"
                      href="<?php echo esc_url( $map_link ); ?>"
                      target="_blank"
                      rel="noopener noreferrer"
                    >Open in Google Maps</a>
                    <?php endif; ?>
                  </div>
                  <?php endif; ?>
                </div>
              </article>
            </aside>
            <?php endif; ?>

            <div class="contact-experience__form" id="contact-form">
              <?php
              if ( function_exists( 'turnwell_contact_form' ) ) {
                  turnwell_contact_form( $inquiry_types );
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </main>

<?php
add_filter(
    'turnwell_footer_scripts',
    static function ( $scripts ) {
        $scripts[] = 'js/contact-page.js?v=1.1';

        return $scripts;
    }
);

get_footer();
