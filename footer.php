<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RAVE
 */

?>

	</div><!-- #content -->

	<!--div id="page-footer"></div-->

</div><!-- #page -->

<div id="superfooter">
	<div class="container content">
		<aside id="footer-left" class="widget-area col-sm-6" role="complementary">
			<?php dynamic_sidebar( 'footer-left' ); ?>
		</aside><!-- #footer-left -->
		<aside id="footer-right" class="widget-area col-sm-6" role="complementary">
			<?php dynamic_sidebar( 'footer-right' ); ?>
		</aside><!-- #footer-right -->
		</div><!-- .container -->
</div>

<footer id="footer" class="site-footer" role="contentinfo">
	<div class="site-info container content">
		<p>
			© <?php echo date( 'Y' ); ?>
			<span class="copyright"><?php echo get_theme_mod( 'rave_footer_text' ) !== false ? get_theme_mod( 'rave_footer_text' ) : get_bloginfo( 'name' ); ?></span>
		</p>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
