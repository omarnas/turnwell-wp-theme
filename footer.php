<?php
/**
 * Theme footer.
 *
 * @package Turnwell
 */

$theme_uri = get_template_directory_uri();

$footer_scripts = apply_filters( 'turnwell_footer_scripts', [] );
?>
  <footer class="site-footer" id="contact">
    <div class="container footer-grid">
      <div class="footer-brand">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link" aria-label="Turnwell home">
          <img src="<?php echo esc_url( $theme_uri . '/assets/images/logos/turnwelllogo-white.svg' ); ?>" alt="Turnwell" width="180" height="32" class="footer-logo">
        </a>
        <p class="footer-tagline">Advanced Technologies Delivering Unparalleled Efficiency</p>
        <div class="footer-social" aria-label="Social media">

          <a href="https://www.linkedin.com/company/turnwell/?viewAsMember=true" class="footer-social-link" aria-label="Linkedin" target="_blank">in</a>
        </div>
      </div>

      <nav class="footer-col" aria-label="Company">
        <h3 class="footer-col-title">Company</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Turnwell</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-team/' ) ); ?>">Leadership Team</a></li>
          <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News &amp; Media</a></li>
        </ul>
      </nav>

      <nav class="footer-col" aria-label="Operations">
        <h3 class="footer-col-title">Operations</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( home_url( '/execution-model/' ) ); ?>">Execution Model</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-services/' ) ); ?>">Services</a></li>
          <li><a href="<?php echo esc_url( home_url( '/our-technology/' ) ); ?>">Technology</a></li>
        </ul>
      </nav>

      <nav class="footer-col" aria-label="Contact">
        <h3 class="footer-col-title">Contact</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
        </ul>
      </nav>
    </div>

    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p class="footer-copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?> Turnwell Industries LLC OPC. All rights reserved.</p>
        <div class="footer-legal">
          <a href="#">Privacy &amp; Policy</a>
          <a href="#">Terms &amp; Condition</a>
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
