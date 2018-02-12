<?php
/**
 * Custom walker class
 */
class Rave_Walker_Nav_Menu extends Walker_Nav_Menu {

	var $cur = 0;
	var $menu_id = 'primary-menu';
	var $menu_class = 'nav navbar-nav';

	/*
	 * Start list - add classes to sub-menus
	 * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$classes = array(
			'sub-menu',
		);
		$class_names = implode( ' ', $classes );
		$output .= "<ul class='{$class_names}'>";
	}

	/*
	 * Start element output - add main/sub classes to list items, links
	 * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
	function start_el( &$output, $item, $depth = 0, $args = array(), $int = 0 ) {
		global $wp_query;

		// determine halfway point, split menu if reached
		$items = wp_get_nav_menu_items( $args->menu->term_id );
		$num_items = $this->get_number_of_root_elements( $items );
		$split = '';
		if ( $this->cur >= ( $num_items / 2 ) ) {
			$split = "</ul><ul id='{$this->menu_id}-right' class='{$this->menu_class}'>";
			$this->cur = -1;
		}
		if ( $this->cur != -1 && $depth == 0 ) {
			$this->cur++;
		}

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// depth-dependent classes, html
		$depth_classes = array();
		//$submenu_toggle = in_array( 'menu-item-has-children', $classes ) ? true : false;
		$link_before = $args->link_before;
		if ( $depth > 0 ) {
			$link_before .= '<i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;';
		}
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// start HTML
		$output .= "{$split}<li id='menu-item-{$item->ID}' class='{$depth_class_names} {$class_names}'>";

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) . '"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) . '"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) . '"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

        // build, filter output
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}