<?php
/**
 * Theme footer.
 *
 * @package Turnwell
 */

$theme_uri = get_template_directory_uri();

$footer_logo_url    = get_field( 'footer_logo', 'option' );
$footer_tagline     = get_field( 'footer_tagline', 'option' );
$linkedin_url       = get_field( 'linkedin_url', 'option' );
$footer_columns     = turnwell_get_footer_menu_columns();
$footer_col_count   = count( $footer_columns );
$footer_grid_class  = 'container footer-grid';
$footer_grid_style  = '';

if ( $footer_col_count > 0 ) {
	$footer_grid_style = sprintf( '--footer-nav-cols: %d;', $footer_col_count );
} else {
	$footer_grid_class .= ' footer-grid--brand-only';
}

if ( empty( $footer_logo_url ) ) {
	$footer_logo_url = $theme_uri . '/assets/images/logos/turnwelllogo-white.svg';
}

$footer_scripts = apply_filters( 'turnwell_footer_scripts', [] );
?>
  <footer class="site-footer" id="contact">
    <div class="<?php echo esc_attr( $footer_grid_class ); ?>"<?php echo $footer_grid_style ? ' style="' . esc_attr( $footer_grid_style ) . '"' : ''; ?>>
      <div class="footer-brand">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link" aria-label="Turnwell home">
          <img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="Turnwell" width="180" height="32" class="footer-logo">
        </a>
        <?php if ( $footer_tagline ) : ?>
        <p class="footer-tagline"><?php echo esc_html( $footer_tagline ); ?></p>
        <?php endif; ?>
        <?php if ( $linkedin_url ) : ?>
        <div class="footer-social" aria-label="Social media">
          <a href="<?php echo esc_url( $linkedin_url ); ?>" class="footer-social-link" aria-label="Linkedin" target="_blank" rel="noopener noreferrer">in</a>
        </div>
        <?php endif; ?>
      </div>

      <?php turnwell_render_footer_menu(); ?>
    </div>

    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p class="footer-copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?> Turnwell Industries LLC OPC. All rights reserved.</p>
        <div class="footer-legal">
          <a href="<?php the_field('privacy_policy_link', 'option'); ?>">Privacy &amp; Policy</a>
          <!--<a href="#">Terms &amp; Condition</a>-->
        </div>
      </div>
    </div>
  </footer>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="<?php echo esc_url( $theme_uri . '/js/main.js' ); ?>?v=1.2"></script>
<?php
foreach ( $footer_scripts as $script ) :
    $script_src = strpos( $script, 'http' ) === 0 ? $script : $theme_uri . '/' . ltrim( $script, '/' );
    ?>
  <script src="<?php echo esc_url( $script_src ); ?>"></script>
<?php endforeach; ?>
<?php wp_footer(); ?>
</body>
</html>
