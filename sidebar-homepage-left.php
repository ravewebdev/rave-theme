<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RAVE
 */

if ( ! is_active_sidebar( 'homepage-left' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-sm-4 col-md-3 sidebar-offcanvas" role="complementary">
	<?php dynamic_sidebar( 'homepage-left' ); ?>
</aside><!-- #secondary -->
