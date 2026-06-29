<?php
/**
 * Template Name: Our Team
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-team';
    }
);

$hero_heading = get_field( 'hero_heading' );
$hero_image   = get_field( 'hero_image' );

$executive_members  = turnwell_get_executive_management_members();
$leadership_members = turnwell_get_leadership_team_members();

$executive_term  = get_term_by( 'slug', 'executive-management', 'team_category' );
$leadership_term = get_term_by( 'slug', 'leadership-team', 'team_category' );

get_header();
?>

  <main id="main">
    <?php if ( ! empty( $hero_heading ) || ! empty( $hero_image ) ) : ?>
    <!-- Hero -->
    <section class="page-hero page-hero--premium"<?php echo ! empty( $hero_heading ) ? ' aria-labelledby="page-hero-heading"' : ''; ?>>
      <?php if ( ! empty( $hero_image ) ) : ?>
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <?php endif; ?>

      <?php if ( ! empty( $hero_heading ) ) : ?>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html( $hero_heading ); ?></h1>
        </div>
      </div>
      <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $executive_members ) && $executive_term && ! is_wp_error( $executive_term ) ) : ?>
    <!-- Executive Management -->
    <section class="team-section section section--spacious" aria-labelledby="executive-heading">
      <div class="container">
        <header class="inner-section-header" data-aos="fade-up">
          <h2 id="executive-heading" class="section-title type-section-title"><?php echo esc_html( $executive_term->name ); ?></h2>
        </header>

        <div class="team-profile-grid team-profile-grid--executive">
          <?php foreach ( $executive_members as $index => $member ) : ?>
            <?php
            get_template_part(
                'template-parts/team-profile',
                'card',
                [
                    'member'    => $member,
                    'executive' => true,
                    'clickable' => true,
                    'delay'     => $index * 100,
                ]
            );
            ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $leadership_members ) && $leadership_term && ! is_wp_error( $leadership_term ) ) : ?>
    <!-- Leadership Team -->
    <section class="team-section team-section--alt section section--spacious" aria-labelledby="leadership-heading">
      <div class="container">
        <header class="inner-section-header" data-aos="fade-up">
          <h2 id="leadership-heading" class="section-title type-section-title"><?php echo esc_html( $leadership_term->name ); ?></h2>
        </header>

        <div class="team-profile-grid team-profile-grid--leadership">
          <?php foreach ( $leadership_members as $index => $member ) : ?>
            <?php
            get_template_part(
                'template-parts/team-profile',
                'card',
                [
                    'member'    => $member,
                    'executive' => false,
                    'clickable' => false,
                    'delay'     => $index * 100,
                ]
            );
            ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </main>

<?php
if ( ! empty( $executive_members ) ) {
    get_template_part(
        'template-parts/team-member',
        'modal',
        [
            'members' => $executive_members,
        ]
    );

}

get_footer();
