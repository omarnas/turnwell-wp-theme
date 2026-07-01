<?php
/**
 * Related news sidebar card.
 *
 * @package Turnwell
 *
 * @var array<string, WP_Post> $args Template arguments.
 */

$post = $args['post'] ?? null;

if ( ! $post instanceof WP_Post ) {
    return;
}

$post_link  = turnwell_resolve_news_post_link( $post );
$image_url  = get_the_post_thumbnail_url( $post, 'full' );
$date_label = get_the_date( 'F d, Y', $post );
$date_iso   = get_the_date( 'Y-m-d', $post );
?>
              <article class="news-sidebar-card">
                <a
                  href="<?php echo esc_url( $post_link['url'] ); ?>"
                  class="news-sidebar-card__media"
                  tabindex="-1"
                  aria-hidden="true"
                  <?php if ( $post_link['external'] ) : ?>
                  target="_blank"
                  rel="noopener noreferrer"
                  <?php endif; ?>
                >
                  <?php if ( $image_url ) : ?>
                  <div class="image-block image-block--ratio-16-9">
                    <img
                      src="<?php echo esc_url( $image_url ); ?>"
                      alt=""
                      class="news-sidebar-card__image"
                      width="480"
                      height="270"
                      loading="lazy"
                    >
                  </div>
                  <?php endif; ?>
                </a>
                <div class="news-sidebar-card__body">
                  <?php if ( $date_label ) : ?>
                  <time class="news-sidebar-card__date" datetime="<?php echo esc_attr( $date_iso ); ?>"><?php echo esc_html( $date_label ); ?></time>
                  <?php endif; ?>
                  <h3 class="news-sidebar-card__title">
                    <a
                      href="<?php echo esc_url( $post_link['url'] ); ?>"
                      <?php if ( $post_link['external'] ) : ?>
                      target="_blank"
                      rel="noopener noreferrer"
                      <?php endif; ?>
                    ><?php echo esc_html( get_the_title( $post ) ); ?></a>
                  </h3>
                  <p class="news-sidebar-card__action">
                    <a
                      href="<?php echo esc_url( $post_link['url'] ); ?>"
                      class="btn btn--pill"
                      <?php if ( $post_link['external'] ) : ?>
                      target="_blank"
                      rel="noopener noreferrer"
                      <?php endif; ?>
                    >Read More</a>
                  </p>
                </div>
              </article>
