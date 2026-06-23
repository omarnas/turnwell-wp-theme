<?php
/**
 * Front page template.
 *
 * @package Turnwell
 */

get_header();

$theme_uri = get_template_directory_uri();

$hero  = get_field( 'hero' );
$about = get_field( 'about_section' );

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

  </main>

<?php
get_footer();
