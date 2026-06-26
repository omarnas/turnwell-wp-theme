<?php
/**
 * Single news article template.
 *
 * @package Turnwell
 */

if ( ! have_posts() ) {
    return;
}

the_post();

if ( ! has_category( 'news' ) ) {
    add_filter(
        'turnwell_body_class',
        static function () {
            return 'page-inner';
        }
    );

    add_filter(
        'turnwell_page_description',
        static function () {
            $excerpt = get_the_excerpt();

            return $excerpt ? $excerpt : 'Turnwell Industries';
        }
    );

    get_header();
    get_template_part( 'template-parts/inner', 'page' );
    get_footer();
    return;
}

add_filter(
    'turnwell_body_class',
    static function () {
        return 'page-inner page-news page-news-single';
    }
);

add_filter(
    'turnwell_page_description',
    static function () {
        return get_the_excerpt();
    }
);

$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$date_label     = get_the_date( 'F d, Y' );
$date_iso       = get_the_date( 'Y-m-d' );
$news_page_url  = home_url( '/news/' );

$related_query = new WP_Query(
    [
        'post_type'              => 'post',
        'post_status'            => 'publish',
        'posts_per_page'         => 3,
        'category_name'          => 'news',
        'post__not_in'           => [ get_the_ID() ],
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]
);

$related_posts = $related_query->posts;

get_header();
?>

  <main id="main">
    <section class="page-hero page-hero--premium" aria-labelledby="article-hero-heading">
      <?php if ( $featured_image ) : ?>
      <div class="page-hero__bg" aria-hidden="true">
        <img src="<?php echo esc_url( $featured_image ); ?>" alt="" class="page-hero__bg-image">
        <div class="page-hero__overlay"></div>
      </div>
      <?php endif; ?>
      <div class="container page-hero__inner">
        <div class="page-hero__content">
          <?php if ( $date_label ) : ?>
          <time class="page-hero__eyebrow" datetime="<?php echo esc_attr( $date_iso ); ?>"><?php echo esc_html( $date_label ); ?></time>
          <?php endif; ?>
          <h1 id="article-hero-heading" class="type-page-title" data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>

    <section class="news-article section" aria-labelledby="article-content-heading">
      <div class="container container-wide">
        <h2 id="article-content-heading" class="visually-hidden">Article</h2>
        <div class="news-article__layout">
          <div class="news-article__main">
            <?php if ( $featured_image ) : ?>
            <div class="news-article__featured-image" data-aos="fade-up">
              <div class="image-block image-block--ratio-16-9">
                <img
                  src="<?php echo esc_url( $featured_image ); ?>"
                  alt=""
                  width="960"
                  height="540"
                  loading="eager"
                >
              </div>
            </div>
            <?php endif; ?>
            <div class="news-article__body prose type-body" data-aos="fade-up" data-aos-delay="80">
              <?php the_content(); ?>
            </div>
            <p class="news-article__back" data-aos="fade-up">
              <a href="<?php echo esc_url( $news_page_url ); ?>" class="btn btn--pill">Back to News &amp; Media</a>
            </p>
          </div>

          <?php if ( ! empty( $related_posts ) ) : ?>
          <aside class="news-article__sidebar" aria-labelledby="news-related-heading" data-aos="fade-up" data-aos-delay="120">
            <h2 id="news-related-heading" class="news-article__sidebar-title">Related Articles</h2>
            <div class="news-article__related-list">
              <?php foreach ( $related_posts as $post ) : ?>
                <?php
                get_template_part(
                    'template-parts/news-sidebar',
                    'card',
                    [
                        'post' => $post,
                    ]
                );
                ?>
              <?php endforeach; ?>
            </div>
          </aside>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

<?php
wp_reset_postdata();

get_footer();
