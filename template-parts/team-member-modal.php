<?php
/**
 * Team member modal panels.
 *
 * @package Turnwell
 *
 * @var array $args {
 *     @type WP_Post[] $members Team members to render in the modal.
 * }
 */

$members = $args['members'] ?? [];

if ( empty( $members ) ) {
    return;
}
?>
    <div class="team-modal" id="team-member-modal" hidden aria-hidden="true">
      <div class="team-modal__backdrop" data-team-modal-close tabindex="-1" aria-hidden="true"></div>
      <div
        class="team-modal__dialog"
        role="dialog"
        aria-modal="true"
      >
        <button type="button" class="team-modal__close" data-team-modal-close aria-label="Close profile">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>

        <div class="team-modal__panels">
<?php foreach ( $members as $member ) : ?>
          <?php
          $slug      = $member->post_name;
          $name      = get_the_title( $member );
          $position  = get_field( 'position', $member->ID );
          $linkedin  = get_field( 'linkedin_url', $member->ID );
          $biography = apply_filters( 'the_content', $member->post_content );
          ?>
          <article
            class="team-modal__panel"
            id="team-modal-panel-<?php echo esc_attr( $slug ); ?>"
            data-team-modal-panel="<?php echo esc_attr( $slug ); ?>"
            hidden
          >
            <div class="team-modal__grid">
              <div class="team-modal__portrait">
                <div class="team-modal__portrait-card">
                  <?php
                  echo get_the_post_thumbnail(
                      $member,
                      'full',
                      [
                          'alt'     => '',
                          'loading' => 'eager',
                          'sizes'   => '(max-width: 768px) 14rem, 16rem',
                          'class'   => 'team-modal__portrait-image',
                      ]
                  );
                  ?>
                </div>
                <?php if ( ! empty( $linkedin ) ) : ?>
                <p class="team-modal__linkedin">
                  <a
                    href="<?php echo esc_url( $linkedin ); ?>"
                    class="team-modal__linkedin-link"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <svg class="team-modal__linkedin-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                      <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                  </a>
                </p>
                <?php endif; ?>
              </div>
              <div class="team-modal__body">
                <header class="team-modal__header">
                  <h2 id="team-modal-title-<?php echo esc_attr( $slug ); ?>" class="team-modal__name"><?php echo esc_html( $name ); ?></h2>
                  <?php if ( ! empty( $position ) ) : ?>
                  <p class="team-modal__role"><?php echo esc_html( $position ); ?></p>
                  <?php endif; ?>
                </header>
                <?php if ( ! empty( $biography ) ) : ?>
                <div id="team-modal-bio-<?php echo esc_attr( $slug ); ?>" class="team-modal__content prose type-body">
                  <?php echo wp_kses_post( $biography ); ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </article>
<?php endforeach; ?>
        </div>
      </div>
    </div>
