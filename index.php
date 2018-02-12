<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RAVE
 */

get_header(); ?>

<?php
// Get post banner, header html
list( $header_html, $banner_html ) = rave_display_thumbnail( '<p class="pull-left visible-xs">
			<button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Toggle Sidebar</button>
		</p>' );
echo $banner_html;
?>

<div class="container content">

	<div class="sidebar-wrap row row-offcanvas row-offcanvas-left">

		<?php get_sidebar( 'homepage-left' ); ?>

		<div id="primary" class="content-area col-sm-8 col-md-9">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .sidebar-wrap -->

</div><!-- .container -->

<?php
get_footer();
