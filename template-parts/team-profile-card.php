<?php
/**
 * Team profile card.
 *
 * @package Turnwell
 *
 * @var array $args {
 *     @type WP_Post $member    Team member post.
 *     @type bool    $executive Whether this is an executive card.
 *     @type bool    $clickable Whether the card opens the team modal.
 *     @type int     $delay     AOS delay in milliseconds.
 * }
 */

$member    = $args['member'] ?? null;
$executive = ! empty( $args['executive'] );
$clickable = ! isset( $args['clickable'] ) || $args['clickable'];
$delay     = isset( $args['delay'] ) ? (int) $args['delay'] : 0;

if ( ! $member instanceof WP_Post ) {
    return;
}

$slug     = $member->post_name;
$name     = get_the_title( $member );
$position = get_field( 'position', $member->ID );
$linkedin = get_field( 'linkedin_url', $member->ID );
$short_bio = get_field( 'short_bio', $member->ID );

if ( $executive ) :
    $card_class = ' team-profile-card--executive';
    ?>
          <article
            class="team-profile-card<?php echo $clickable ? ' team-profile-card--interactive' : ''; ?><?php echo esc_attr( $card_class ); ?>"
            data-aos="fade-up"
            data-aos-delay="<?php echo esc_attr( $delay ); ?>"
          >
            <?php if ( $clickable ) : ?>
            <button
              type="button"
              class="team-profile-card__trigger"
              data-team-modal="<?php echo esc_attr( $slug ); ?>"
              aria-haspopup="dialog"
              aria-controls="team-member-modal"
              aria-label="<?php echo esc_attr( sprintf( 'Read bio for %s', $name ) ); ?>"
            ></button>
            <?php endif; ?>
            <div class="team-profile-card__media">
              <?php
              echo get_the_post_thumbnail(
                  $member,
                  'full',
                  [
                      'alt'     => '',
                      'width'   => 480,
                      'height'  => 600,
                      'loading' => 'lazy',
                      'sizes'   => '(max-width: 768px) 100vw, 480px',
                  ]
              );
              ?>
              <?php if ( $clickable ) : ?>
              <span class="team-profile-card__hint" aria-hidden="true">
                <span class="team-profile-card__hint-text">Read bio</span>
              </span>
              <?php endif; ?>
            </div>
            <h3 class="team-profile-card__name"><?php echo esc_html( $name ); ?></h3>
            <?php if ( ! empty( $position ) ) : ?>
            <p class="team-profile-card__role"><?php echo esc_html( $position ); ?></p>
            <?php endif; ?>
            <div class="team-profile-card__social">
              <?php if ( ! empty( $linkedin ) ) : ?>
              <a
                class="team-profile-card__linkedin"
                href="<?php echo esc_url( $linkedin ); ?>"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="<?php echo esc_attr( $name . ' on LinkedIn' ); ?>"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
              <?php endif; ?>
            </div>
          </article>
    <?php
else :
    $card_class = ' team-profile-card--leadership';
    ?>
          <article class="team-profile-card<?php echo esc_attr( $card_class ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
            <div class="team-profile-card__avatar">
              <?php
              echo get_the_post_thumbnail(
                  $member,
                  'full',
                  [
                      'alt'     => '',
                      'width'   => 152,
                      'height'  => 152,
                      'loading' => 'lazy',
                      'sizes'   => '152px',
                  ]
              );
              ?>
            </div>
            <h3 class="team-profile-card__name"><?php echo esc_html( $name ); ?></h3>
            <?php if ( ! empty( $position ) ) : ?>
            <p class="team-profile-card__role"><?php echo esc_html( $position ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $short_bio ) ) : ?>
            <p class="team-profile-card__bio"><?php echo esc_html( $short_bio ); ?></p>
            <?php endif; ?>
            <div class="team-profile-card__social">
              <?php if ( ! empty( $linkedin ) ) : ?>
              <a
                class="team-profile-card__linkedin"
                href="<?php echo esc_url( $linkedin ); ?>"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="<?php echo esc_attr( $name . ' on LinkedIn' ); ?>"
              >
              <?php else : ?>
              <span class="team-profile-card__linkedin team-profile-card__linkedin--unlinked" aria-hidden="true">
              <?php endif; ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              <?php if ( ! empty( $linkedin ) ) : ?>
              </a>
              <?php else : ?>
              </span>
              <?php endif; ?>
            </div>
          </article>
    <?php
endif;
