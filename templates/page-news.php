<?php
/**
 * Template Name: News & Media
 *
 * @package Turnwell
 */

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-news';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        return 'Latest news and media updates from Turnwell Industries.';
    }
);

$theme_uri = get_template_directory_uri();

$news_query = new WP_Query(
    [
        'post_type'              => 'post',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'category_name'          => 'news',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]
);

$news_posts  = $news_query->posts;
$featured    = ! empty( $news_posts ) ? $news_posts[0] : null;
$more_posts  = $featured ? array_slice( $news_posts, 1 ) : $news_posts;

get_header();
?>

  <main id="main">
    <section class="page-hero page-hero--premium" aria-labelledby="page-hero-heading">
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $theme_uri . '/assets/images/news-banner.jpg' ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <h1 id="page-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <section class="news-room section" aria-label="News articles">
      <div class="container">
        <?php if ( $featured instanceof WP_Post ) : ?>
          <?php
          $featured_link     = turnwell_resolve_news_post_link( $featured );
          $featured_image    = get_the_post_thumbnail_url( $featured, 'full' );
          $featured_date     = get_the_date( 'F d, Y', $featured );
          $featured_date_iso = get_the_date( 'Y-m-d', $featured );
          $featured_short    = trim( (string) get_field( 'short_description', $featured->ID ) );
          $featured_excerpt  = $featured_short !== '' ? $featured_short : get_the_excerpt( $featured );
          ?>
        <article class="news-featured" aria-labelledby="news-featured-title" data-aos="fade-up">
          <div class="news-featured__grid">
            <a
              href="<?php echo esc_url( $featured_link['url'] ); ?>"
              class="news-featured__media"
              tabindex="-1"
              aria-hidden="true"
              <?php if ( $featured_link['external'] ) : ?>
              target="_blank"
              rel="noopener noreferrer"
              <?php endif; ?>
            >
              <?php if ( $featured_image ) : ?>
              <div class="image-block image-block--ratio-16-9">
                <img
                  src="<?php echo esc_url( $featured_image ); ?>"
                  alt=""
                  width="960"
                  height="540"
                  loading="eager"
                >
              </div>
              <?php endif; ?>
            </a>
            <div class="news-featured__body">
              <?php if ( $featured_date ) : ?>
              <time class="news-featured__date" datetime="<?php echo esc_attr( $featured_date_iso ); ?>"><?php echo esc_html( $featured_date ); ?></time>
              <?php endif; ?>
              <h2 id="news-featured-title" class="news-featured__title">
                <a
                  href="<?php echo esc_url( $featured_link['url'] ); ?>"
                  <?php if ( $featured_link['external'] ) : ?>
                  target="_blank"
                  rel="noopener noreferrer"
                  <?php endif; ?>
                ><?php echo esc_html( get_the_title( $featured ) ); ?></a>
              </h2>
              <?php if ( $featured_excerpt ) : ?>
              <p class="news-featured__excerpt"><?php echo esc_html( $featured_excerpt ); ?></p>
              <?php endif; ?>
              <p class="news-featured__action">
                <a
                  href="<?php echo esc_url( $featured_link['url'] ); ?>"
                  class="btn btn--pill"
                  <?php if ( $featured_link['external'] ) : ?>
                  target="_blank"
                  rel="noopener noreferrer"
                  <?php endif; ?>
                >Read More</a>
              </p>
            </div>
          </div>
        </article>
        <?php endif; ?>

        <?php if ( ! empty( $more_posts ) ) : ?>
        <div class="news-more" aria-labelledby="news-more-heading">
          <header class="news-more__header" data-aos="fade-up">
            <h2 id="news-more-heading" class="news-more__title type-section-title">More News</h2>
          </header>
          <div class="news-more__grid">
            <?php foreach ( $more_posts as $post ) : ?>
              <?php
              get_template_part(
                  'template-parts/news-article',
                  'card',
                  [
                      'post' => $post,
                  ]
              );
              ?>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

<?php
wp_reset_postdata();

get_footer();
