<?php
/**
 * Front page template.
 *
 * @package Turnwell
 */

get_header();

$theme_uri = get_template_directory_uri();

$hero      = get_field( 'hero' );
$about     = get_field( 'about_section' );
$execution  = get_field( 'execution_model_section' );
$partners   = get_field( 'our_partners' );
$technology = get_field( 'technology_grid' );

$hero_video  = ! empty( $hero['video'] ) ? $hero['video'] : $theme_uri . '/assets/Turnwell_Loop.mp4?2';
$about_video = ! empty( $about['about_video'] ) ? $about['about_video'] : $theme_uri . '/assets/aboutvideo.mp4?2';
?>

  <main id="main">

    <?php if ( ! empty( $hero ) ) : ?>
    <!-- 1. Turnwell Industries hero -->
    <section class="hero hero--fullbleed"<?php echo ! empty( $hero['hero_heading'] ) ? ' aria-labelledby="hero-heading"' : ''; ?>>
      <div class="hero-bg" aria-hidden="true">
        <video
          class="hero-bg-video"
          src="<?php echo esc_url( $hero_video ); ?>"
          autoplay
          muted
          playsinline
          loop
        ></video>
        <div class="hero-bg-overlay"></div>
      </div>

      <div class="container hero-inner">
        <div class="hero-content">
          <?php if ( ! empty( $hero['hero_eyebrow'] ) ) : ?>
          <p class="hero-eyebrow" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html( $hero['hero_eyebrow'] ); ?></p>
          <?php endif; ?>

          <?php if ( ! empty( $hero['hero_heading'] ) ) : ?>
          <h1 id="hero-heading" class="hero-title" data-aos="fade-up" data-aos-delay="200"><?php echo esc_html( $hero['hero_heading'] ); ?></h1>
          <?php endif; ?>

          <?php if ( ! empty( $hero['hero_lead'] ) ) : ?>
          <p class="hero-lead" data-aos="fade-up" data-aos-delay="300"><?php echo esc_html( $hero['hero_lead'] ); ?></p>
          <?php endif; ?>

          <?php if ( ! empty( $hero['button_text'] ) && ! empty( $hero['button_url'] ) ) : ?>
          <a href="<?php echo esc_url( $hero['button_url'] ); ?>" class="btn btn--pill" data-aos="fade-up" data-aos-delay="400"><?php echo esc_html( $hero['button_text'] ); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $about ) ) : ?>
    <!-- 2. About Turnwell -->
    <section class="home-about section section--grey" id="about-us"<?php echo ! empty( $about['about_heading'] ) ? ' aria-labelledby="about-heading"' : ''; ?>>
      <div class="container">
        <div class="home-about__stack">
          <?php if ( ! empty( $about['about_heading'] ) || ! empty( $about['eye_brow'] ) ) : ?>
          <header class="home-about__header about-header" data-aos="fade-up">
            <?php if ( ! empty( $about['about_heading'] ) ) : ?>
            <h2 id="about-heading" class="section-title"><?php echo esc_html( $about['about_heading'] ); ?></h2>
            <?php endif; ?>

            <?php if ( ! empty( $about['eye_brow'] ) ) : ?>
            <p class="section-eyebrow"><?php echo esc_html( $about['eye_brow'] ); ?></p>
            <?php endif; ?>
          </header>
          <?php endif; ?>

          <?php if ( ! empty( $about['about_statement'] ) ) : ?>
          <p class="home-about__statement" data-aos="fade-up" data-aos-delay="60"><?php echo esc_html( $about['about_statement'] ); ?></p>
          <?php endif; ?>

          <?php if ( ! empty( $about['about_kpis'] ) ) : ?>
          <ul class="home-about__kpis" aria-label="Program highlights" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ( $about['about_kpis'] as $kpi ) : ?>
              <?php if ( empty( $kpi['kpi_value'] ) && empty( $kpi['kpi_label'] ) ) : ?>
                <?php continue; ?>
              <?php endif; ?>
            <li class="home-about__kpi">
              <?php if ( ! empty( $kpi['kpi_value'] ) ) : ?>
              <span class="home-about__kpi-value"><?php echo esc_html( $kpi['kpi_value'] ); ?></span>
              <?php endif; ?>
              <?php if ( ! empty( $kpi['kpi_label'] ) ) : ?>
              <span class="home-about__kpi-label"><?php echo esc_html( $kpi['kpi_label'] ); ?></span>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>

          <?php
          $has_about_story = ! empty( $about['about_body'] )
              || ! empty( $about['about_video'] )
              || ! empty( $about['mission'] )
              || ! empty( $about['vision'] );
          ?>
          <?php if ( $has_about_story ) : ?>
          <div class="home-about__story" data-aos="fade-up" data-aos-delay="140">
            <?php if ( ! empty( $about['about_body'] ) || ! empty( $about['about_video'] ) ) : ?>
            <div class="home-about__main">
              <?php if ( ! empty( $about['about_body'] ) ) : ?>
              <div class="home-about__body prose">
                <?php echo wp_kses_post( wpautop( $about['about_body'] ) ); ?>
              </div>
              <?php endif; ?>

              <div class="home-about__media" data-aos="zoom-in" data-aos-delay="200">
                <video
                  class="home-about__video"
                  src="<?php echo esc_url( $about_video ); ?>"
                  autoplay
                  muted
                  playsinline
                  loop
                  aria-hidden="true"
                ></video>
              </div>
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $about['mission'] ) || ! empty( $about['vision'] ) ) : ?>
            <div class="home-about__mv" data-aos="fade-up" data-aos-delay="180">
              <?php if ( ! empty( $about['mission'] ) ) : ?>
              <article class="home-about__mv-item">
                <h3 class="home-about__mv-title">Mission</h3>
                <p class="home-about__mv-text"><?php echo esc_html( $about['mission'] ); ?></p>
              </article>
              <?php endif; ?>

              <?php if ( ! empty( $about['vision'] ) ) : ?>
              <article class="home-about__mv-item">
                <h3 class="home-about__mv-title">Vision</h3>
                <p class="home-about__mv-text"><?php echo esc_html( $about['vision'] ); ?></p>
              </article>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php
    $homepage_team = turnwell_get_executive_management_members();

    if ( ! empty( $homepage_team ) ) :
    ?>
    <!-- 3. Leadership Team -->
    <section class="team section" id="leadership-team" aria-labelledby="team-heading">
      <div class="container">
        <header class="section-header" data-aos="fade-up">
          <h2 id="team-heading" class="section-title">Leadership Team</h2>
        </header>

        <div class="team-grid">
          <?php foreach ( $homepage_team as $index => $member ) : ?>
            <?php
            $slug     = $member->post_name;
            $name     = get_the_title( $member );
            $position = get_field( 'position', $member->ID );
            ?>
          <article
            class="team-card team-card--interactive"
            data-aos="fade-up"
            data-aos-delay="<?php echo esc_attr( $index * 100 ); ?>"
            data-team-modal="<?php echo esc_attr( $slug ); ?>"
            role="button"
            tabindex="0"
            aria-haspopup="dialog"
            aria-controls="team-member-modal"
            aria-label="<?php echo esc_attr( sprintf( 'Read bio for %s', $name ) ); ?>"
          >
            <div class="team-card-media">
              <?php
              echo get_the_post_thumbnail(
                  $member,
                  'full',
                  [
                      'alt'     => '',
                      'width'   => 400,
                      'height'  => 500,
                      'loading' => 'lazy',
                  ]
              );
              ?>
              <span class="team-card-hint" aria-hidden="true">
                <span class="team-card-hint__text">Read bio</span>
              </span>
            </div>
            <h3 class="team-card-name"><?php echo esc_html( $name ); ?></h3>
            <?php if ( ! empty( $position ) ) : ?>
            <p class="team-card-role"><?php echo esc_html( $position ); ?></p>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>

        <div class="section-cta" data-aos="fade-up" data-aos-delay="100">
          <a href="<?php echo esc_url( home_url( '/our-team/' ) ); ?>" class="btn btn--pill">Meet our Leadership Team</a>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $execution ) ) : ?>
    <!-- 4. Operations tile grid -->
    <section class="execution section section--grey" id="execution-model"<?php echo ! empty( $execution['execution_heading'] ) ? ' aria-labelledby="execution-heading"' : ''; ?>>
      <div class="container container-wide">
        <?php if ( ! empty( $execution['execution_heading'] ) ) : ?>
        <header class="execution-header" data-aos="fade-up">
          <h2 id="execution-heading" class="section-title"><?php echo esc_html( $execution['execution_heading'] ); ?></h2>
        </header>
        <?php endif; ?>

        <?php
        $execution_cta_label = $execution['button_label'] ?? '';
        $execution_cta_url   = $execution['button_url'] ?? '';
        $has_execution_cta   = ! empty( $execution_cta_label ) && ! empty( $execution_cta_url );
        ?>

        <?php if ( ! empty( $execution['execution_pillars'] ) || $has_execution_cta ) : ?>
        <div class="execution-pillars" aria-label="Integrated execution model pillars">
          <?php foreach ( $execution['execution_pillars'] ?? [] as $index => $pillar ) : ?>
            <?php if ( empty( $pillar['pillar_title'] ) && empty( $pillar['pillar_text'] ) ) : ?>
              <?php continue; ?>
            <?php endif; ?>
            <?php $accent_class = 0 === $index % 2 ? 'execution-pillar--accent-blue' : 'execution-pillar--accent-yellow'; ?>
          <article class="execution-pillar <?php echo esc_attr( $accent_class ); ?>" data-aos="fade-up">
            <?php if ( ! empty( $pillar['pillar_title'] ) ) : ?>
            <h3 class="execution-pillar__title"><?php echo esc_html( $pillar['pillar_title'] ); ?></h3>
            <?php endif; ?>
            <?php if ( ! empty( $pillar['pillar_text'] ) ) : ?>
            <p class="execution-pillar__text"><?php echo esc_html( $pillar['pillar_text'] ); ?></p>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>

          <?php if ( $has_execution_cta ) : ?>
          <article class="execution-pillar execution-pillar--cta" data-aos="fade-up">
            <div class="execution-pillar-cta">
              <img
                src="<?php echo esc_url( $theme_uri . '/assets/images/execution-mid-fullbanner-small.jpg' ); ?>"
                alt=""
                class="execution-pillar-cta__image"
                width="640"
                height="400"
                loading="lazy"
              >
              <div class="execution-pillar-cta__overlay" aria-hidden="true"></div>
              <div class="execution-pillar-cta__content">
                <a href="<?php echo esc_url( $execution_cta_url ); ?>" class="btn btn--pill"><?php echo esc_html( $execution_cta_label ); ?></a>
              </div>
            </div>
          </article>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $partners ) ) : ?>
    <!-- 5. Our Partners -->
    <section class="partners section section--grey" id="partners" aria-labelledby="partners-heading">
      <div class="container">
        <header class="section-header" data-aos="fade-up">
          <h2 id="partners-heading" class="section-title">Our Partners</h2>
        </header>

        <div class="partners-grid">
          <?php foreach ( $partners as $index => $partner ) : ?>
            <?php
            if (
                empty( $partner['partner_name'] )
                && empty( $partner['partner_logo'] )
                && empty( $partner['partner_copy'] )
                && empty( $partner['partner_link'] )
            ) {
                continue;
            }

            $accent_class = 0 === $index % 2 ? 'partner-card--accent-blue' : 'partner-card--accent-yellow';
            ?>
          <article class="partner-card <?php echo esc_attr( $accent_class ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $index * 150 ); ?>">
            <?php if ( ! empty( $partner['partner_logo'] ) ) : ?>
            <div class="partner-logo-wrap">
              <img
                src="<?php echo esc_url( $partner['partner_logo'] ); ?>"
                alt="<?php echo esc_attr( $partner['partner_name'] ?? '' ); ?>"
                class="partner-logo"
                width="200"
                height="52"
              >
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $partner['partner_copy'] ) ) : ?>
            <div class="partner-copy prose">
              <p><?php echo esc_html( $partner['partner_copy'] ); ?></p>
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $partner['partner_link'] ) ) : ?>
            <a href="<?php echo esc_url( $partner['partner_link'] ); ?>" target="_blank" rel="noopener noreferrer" class="partner-link">Visit the website</a>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $technology ) ) : ?>
    <!-- 6. Technology Spotlights -->
    <section class="technology section section--grey" id="technology"<?php echo ! empty( $technology['technology_heading'] ) ? ' aria-labelledby="technology-heading"' : ''; ?>>
      <div class="container">
        <?php if ( ! empty( $technology['technology_heading'] ) ) : ?>
        <header class="technology-header" data-aos="fade-up">
          <h2 id="technology-heading" class="section-title"><?php echo esc_html( $technology['technology_heading'] ); ?></h2>
        </header>
        <?php endif; ?>

        <?php if ( ! empty( $technology['technology_cards'] ) ) : ?>
        <div class="technology-grid">
          <?php foreach ( $technology['technology_cards'] as $index => $card ) : ?>
            <?php
            if (
                empty( $card['card_image'] )
                && empty( $card['card_title'] )
                && empty( $card['card_product'] )
            ) {
                continue;
            }
            ?>
          <article class="tech-card" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $index * 100 ); ?>">
            <?php if ( ! empty( $card['card_image'] ) ) : ?>
            <div class="tech-card-media">
              <img
                src="<?php echo esc_url( $card['card_image'] ); ?>"
                alt=""
                class="tech-card-image"
                width="600"
                height="400"
              >
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $card['card_title'] ) || ! empty( $card['card_product'] ) ) : ?>
            <div class="tech-card-body">
              <?php if ( ! empty( $card['card_title'] ) ) : ?>
              <h3 class="tech-card-title"><?php echo esc_html( $card['card_title'] ); ?></h3>
              <?php endif; ?>
              <?php if ( ! empty( $card['card_product'] ) ) : ?>
              <p class="tech-card-product"><?php echo esc_html( $card['card_product'] ); ?></p>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $technology['button_label'] ) && ! empty( $technology['button_url'] ) ) : ?>
        <div class="section-cta" data-aos="fade-up">
          <a href="<?php echo esc_url( $technology['button_url'] ); ?>" class="btn btn--pill"><?php echo esc_html( $technology['button_label'] ); ?></a>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

  </main>

<?php
if ( ! empty( $homepage_team ) ) {
    get_template_part(
        'template-parts/team-member',
        'modal',
        [
            'members' => $homepage_team,
        ]
    );

    add_filter(
        'turnwell_footer_scripts',
        static function ( $scripts ) {
            $scripts[] = 'js/team-modal.js?v=1.3';

            return $scripts;
        }
    );
}

get_footer();
