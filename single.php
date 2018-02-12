<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package RAVE
 */

get_header(); ?>

<?php
// Determine position of sidebar
$sidebar_position = get_theme_mod( 'rave_posts_sidebar_position' );
$sidebar_position = $sidebar_position == '' ? 'right' : $sidebar_position;

// Get post banner, header html
list( $header_html, $banner_html ) = rave_display_thumbnail( '<p class="pull-' . $sidebar_position . ' visible-xs">
			<button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Toggle Sidebar</button>
		</p>' );
echo $banner_html;
?>

<div class="container content">

	<div class="sidebar-wrap row row-offcanvas row-offcanvas-<?php echo $sidebar_position; ?>">

		<?php $sidebar_position == 'left' ? get_sidebar( 'page-sidebar' ) : null; ?>

		<div id="primary" class="content-area col-sm-8 col-md-9">
			<main id="main" class="site-main" role="main">

				<?php echo $header_html; ?>

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', get_post_format() );

					the_post_navigation();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php $sidebar_position == 'right' ? get_sidebar( 'page-sidebar' ) : null; ?>

	</div><!-- .sidebar-wrap -->

</div><!-- .container -->

<?php
get_footer();
