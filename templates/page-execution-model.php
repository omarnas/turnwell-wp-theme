<?php
/**
 * Template Name: Execution Model
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-execution';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        return 'Integrated well delivery across seven phases — one authority from well design through intervention.';
    }
);

$theme_uri = get_template_directory_uri();

$intro_title            = get_field( 'intro_title' );
$intro_lead             = get_field( 'intro_lead' );
$intro_subtitle         = get_field( 'intro_subtitle' );
$technology_disclaimer  = get_field( 'technology_disclaimer' );
$phases                 = turnwell_get_execution_phases();
$first_phase            = ! empty( $phases ) ? $phases[0] : null;
$first_sticky_label     = $first_phase ? (string) get_field( 'phase_number', $first_phase->ID ) : '';

get_header();
?>

  <main id="main">
    <!-- Hero -->
    <section class="page-hero page-hero--premium" aria-labelledby="page-hero-heading">
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $theme_uri . '/assets/images/execution-mid-fullbanner.png' ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <?php if ( ! empty( $phases ) || ! empty( $intro_title ) || ! empty( $intro_lead ) || ! empty( $intro_subtitle ) || ! empty( $technology_disclaimer ) ) : ?>
    <!-- Integrated well delivery — sticky scroll -->
    <section class="execution-ops section section--spacious"<?php echo ! empty( $intro_title ) ? ' aria-labelledby="execution-page-title"' : ''; ?>>
      <div class="container container-wide">
        <?php if ( ! empty( $intro_title ) || ! empty( $intro_lead ) || ! empty( $intro_subtitle ) ) : ?>
        <header class="execution-ops__intro inner-section-header inner-section-header--center" data-aos="fade-up">
          <?php if ( ! empty( $intro_title ) ) : ?>
          <h2 id="execution-page-title" class="section-title type-section-title"><?php echo esc_html( $intro_title ); ?></h2>
          <?php endif; ?>
          <?php if ( ! empty( $intro_lead ) ) : ?>
          <p class="section-lead"><?php echo esc_html( $intro_lead ); ?></p>
          <?php endif; ?>
          <?php if ( ! empty( $intro_subtitle ) ) : ?>
          <p class="execution-story__subtitle"><?php echo esc_html( $intro_subtitle ); ?></p>
          <?php endif; ?>
        </header>
        <?php endif; ?>

        <?php if ( ! empty( $phases ) ) : ?>
        <div class="execution-story" data-execution-story>
          <div class="execution-story__layout">
            <div class="execution-story__progress" aria-hidden="true">
              <div class="execution-story__progress-track">
                <span class="execution-story__progress-fill" data-story-progress></span>
              </div>
              <ol class="execution-story__progress-markers">
                <?php foreach ( $phases as $index => $phase ) : ?>
                <li class="execution-story__progress-marker<?php echo 0 === $index ? ' is-active' : ''; ?>" data-story-marker="<?php echo (int) $index; ?>"></li>
                <?php endforeach; ?>
              </ol>
            </div>

            <aside class="execution-story__rail" aria-hidden="true">
              <div class="execution-story__rail-pin">
                <div class="execution-story__col execution-story__col--num">
                  <span class="execution-story__num" data-story-num><?php echo esc_html( $first_sticky_label ); ?></span>
                </div>
                <div class="execution-story__col execution-story__col--title">
                  <p class="execution-story__title" data-story-title><?php echo esc_html( get_the_title( $first_phase ) ); ?></p>
                </div>
              </div>
            </aside>

            <div class="execution-story__content">
              <?php foreach ( $phases as $index => $phase ) : ?>
                <?php
                $phase_id        = $phase->ID;
                $phase_label     = (string) get_field( 'phase_number', $phase_id );
                $phase_title     = get_the_title( $phase_id );
                $phase_content   = get_post_field( 'post_content', $phase_id );
                $phase_technology = (string) get_field( 'technology', $phase_id );
                $phase_metrics   = get_field( 'metrics', $phase_id );
                ?>
              <article
                class="execution-story__phase<?php echo 0 === $index ? ' is-active' : ''; ?>"
                data-story-phase
                data-story-num="<?php echo esc_attr( $phase_label ); ?>"
                data-story-title="<?php echo esc_attr( $phase_title ); ?>"
                aria-labelledby="story-phase-<?php echo (int) $index; ?>"
              >
                <h3 id="story-phase-<?php echo (int) $index; ?>" class="visually-hidden"><?php echo esc_html( $phase_title ); ?></h3>
                <header class="execution-story__phase-header execution-story__phase-header--mobile">
                  <?php if ( $phase_label !== '' ) : ?>
                  <p class="execution-story__phase-label"><?php echo esc_html( $phase_label ); ?></p>
                  <?php endif; ?>
                  <p class="execution-story__phase-title"><?php echo esc_html( $phase_title ); ?></p>
                </header>
                <div class="execution-story__phase-body">
                  <?php if ( $phase_content !== '' ) : ?>
                  <p class="execution-story__phase-text"><?php echo esc_html( $phase_content ); ?></p>
                  <?php endif; ?>
                  <?php if ( ! empty( $phase_metrics ) ) : ?>
                  <div class="execution-story__metrics-wrap">
                  <table class="execution-story__metrics">
                    <thead>
                      <tr>
                        <th scope="col">Metric</th>
                        <th scope="col">Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ( $phase_metrics as $metric ) : ?>
                        <?php
                        $metric_label = trim( (string) ( $metric['metric_label'] ?? '' ) );
                        $metric_value = trim( (string) ( $metric['metric_value'] ?? '' ) );

                        if ( $metric_label === '' && $metric_value === '' ) {
                            continue;
                        }
                        ?>
                      <tr>
                        <th scope="row"><?php echo esc_html( $metric_label ); ?></th>
                        <td><?php echo esc_html( $metric_value ); ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  </div>
                  <?php endif; ?>
                  <?php if ( $phase_technology !== '' ) : ?>
                  <div class="execution-story__tech-wrap">
                  <p class="execution-story__phase-tech"><span class="execution-story__phase-tech-label">Technology:</span> <?php echo esc_html( $phase_technology ); ?></p>
                  </div>
                  <?php endif; ?>
                </div>
              </article>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $technology_disclaimer ) ) : ?>
        <div class="execution-disclaimer-wrap">
          <p class="execution-disclaimer" role="note"><?php echo esc_html( $technology_disclaimer ); ?></p>
        </div>
        <?php endif; ?>

        <div class="section-cta" data-aos="fade-up">
          <a href="<?php echo esc_url( home_url( '/our-technology/' ) ); ?>" class="btn btn--pill">Learn About Our Technology</a>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </main>

<?php
if ( ! empty( $phases ) ) {
    add_filter(
        'turnwell_footer_scripts',
        static function ( $scripts ) {
            $scripts[] = 'js/execution-story.js?v=1.5';

            return $scripts;
        }
    );
}

get_footer();
