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

$permalink  = get_permalink( $post );
$image_url  = get_the_post_thumbnail_url( $post, 'full' );
$date_label = get_the_date( 'F d, Y', $post );
$date_iso   = get_the_date( 'Y-m-d', $post );
?>
              <article class="news-sidebar-card">
                <a href="<?php echo esc_url( $permalink ); ?>" class="news-sidebar-card__media" tabindex="-1" aria-hidden="true">
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
                    <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
                  </h3>
                  <p class="news-sidebar-card__action">
                    <a href="<?php echo esc_url( $permalink ); ?>" class="btn btn--pill">Read More</a>
                  </p>
                </div>
              </article>
