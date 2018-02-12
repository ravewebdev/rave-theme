<?php
/**
 * Template Name: Right Sidebar Template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RAVE
 */

get_header(); ?>

<?php
// Get post banner, header html
list( $header_html, $banner_html )  = rave_display_thumbnail( '<p class="pull-right visible-xs">
			<button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Toggle Sidebar</button>
		</p>' );
echo $banner_html;
?>

<div class="container content">

	<div class="sidebar-wrap row row-offcanvas row-offcanvas-right">

		<div id="primary" class="content-area col-sm-8 col-md-9">

			<main id="main" class="site-main" role="main">

				<?php echo $header_html; ?>

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar( 'page' ); ?>

	</div><!-- .sidebar-wrap -->

</div><!-- .container -->

<?php
get_footer();