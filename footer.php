<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bonne-Ambiance
 */

?>
</div><!-- .wrapper .row -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="wrapper">
		<div class="footer-menu">
			<?php 
			if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'container'      => '',
						) 
					);
			} 
			?>
		</div>
		<div class="site-info">
			<p>
				<?php echo esc_url( get_site_url() ) . ' '; ?> © <?php esc_html_e( 'All right reserved', 'Bonne-Ambiance' ); ?>
				<a href="https://github.com/nclslbrn/bonne-ambiance">
					<?php esc_html_e( 'Design : N.Lebrun', 'Bonne-Ambiance' ); ?>
				</a>
			</p>
		</div><!-- .site-info -->
	</div><!-- .wrapper -->
</footer><!-- #colophon -->

</div><!-- #content -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
