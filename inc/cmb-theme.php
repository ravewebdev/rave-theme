<?php
/*
 * Page/post thumbnail display toggle
 *
 * Allows user to set usage of post thumbnail (banner, inline, fill inner container)
 */
add_action( 'cmb2_admin_init', 'cmb2_conditionals_init' );

function rave_toggle_thumbnail_display() {
	$prefix = 'rave_thumbnail_';

	// Initiate metabox
	$cmb = new_cmb2_box( array(
		'id' 			=> 'toggle_thumbnail',
		'title' 		=> __( 'Banner', 'cmb2' ),
		'object_types' 	=> array( 'post', 'page' ),
		'context'		=> 'side',
		'priority'		=> 'low',
		'show_names'	=> true
	) );

	// Display field to toggle banner type: slider, featured image, none
	$cmb->add_field( array(
		'name'				=> __( 'Display Banner' ),
		'desc'				=> __( 'Set type of full-width banner' ),
		'id'				=> $prefix . 'banner',
		'type'				=> 'select',
		'show_option_none'	=> false,
		'options'			=> array(
			'none'		=> esc_html__( 'None', 'cmb2' ),
			'image'		=> esc_html__( 'Featured Image Banner', 'cmb2' ),
			'slider'	=> esc_html__( 'Slider Banner', 'cmb2' )
		),
		'attributes'		=> array()
	) );

	// Get available slider categories
	$args = array(
		'taxonomy' 		=> 'slider_category',
		'hide_empty'	=> false
	);
	$cats = get_terms( $args );
	$cat_array = array();
	foreach ( $cats as $cat ) {
		$cat_array[$cat->term_id] = esc_html__( $cat->name );
	}

	// Display field to choose slider
	$cmb->add_field( array(
		'name'				=> __( 'Slider' ),
		'desc'				=> __( 'Set slider category to display in banner' ),
		'id'				=> $prefix . 'slider',
		'type'				=> 'select',
		'show_option_none'	=> true,
		'options'			=> $cat_array,
		'attributes' 		=> array(
			//'required'               	=> true,
			'data-conditional-id'    	=> $prefix . 'banner',
			'data-conditional-value' 	=> 'slider',
		),
	) );

	// Display field to toggle position of image relative to title
	$cmb->add_field( array(
		'name'				=> __( 'Image Location' ),
		'desc'				=> __( 'Set display location of featured image in relation to title' ),
		'id'				=> $prefix . 'location',
		'type'				=> 'select',
		'show_option_none'	=> false,
		'options'			=> array(
			'last'		=> esc_html__( 'Below title', 'cmb2' ),
			'first'		=> esc_html__( 'Above title', 'cmb2' )
		),
		'attributes' 		=> array(
			//'required'               	=> true,
			'data-conditional-id'    	=> $prefix . 'banner',
			'data-conditional-value' 	=> 'none',
		),
	) );
}
add_action( 'cmb2_admin_init', 'rave_toggle_thumbnail_display' );

/*
 * Display thumbnail / banner / header on frontend
 */
function rave_display_thumbnail( $btn_html = '' ) {
	global $post;

	$display = true; // Control if header displays after function called, or else in content container

	$header_html = '<header class="entry-header">'; // Open header
	$banner_html = ''; // Open Banner

	// Get thumbnail, title
	$thumbnail = '';
	if ( has_post_thumbnail() ) {
		$thumbnail = get_the_post_thumbnail();
	}
	$title = '<h1 class="entry-title">' . get_the_title() . '</h1>';

	// Determine type of banner
	$banner = get_post_meta( $post->ID, 'rave_thumbnail_banner', true );
	switch ( $banner ) {
		case 'image': // Full-width banner image
			$banner_html .= '<div class="banner-wrap">' . $thumbnail . '</div>';
			break;
		case 'slider': // Full-width banner slider
			$slider = get_post_meta( $post->ID, 'rave_thumbnail_slider', true );
			$slider = do_shortcode( "[slick_slider cat='{$slider}']" );
			$banner_html .= '<div class="banner-wrap">' . $slider . '</div>';
			break;
		default: // Standard featured image
			$display = false;
			$location = get_post_meta( $post->ID, 'rave_thumbnail_location', true );
			$location = isset( $location ) && $location != '' ? $location : 'first';
			//$html .= '<div class="container">';
			//$html .= '</div>';
			if ( $location == 'first' ) {
				$header_html = $thumbnail . $title;
			} else {
				$header_html = $title . $thumbnail;
			}
			break;
	}

	$btn_html = $btn_html != '' ? '<div class="container clearfix">' . $btn_html . '</div>' : ''; // Add container to btn
	$banner_html .= $btn_html;
	$header_html .= $display ? $title : '';
	$header_html .= '</header><!-- .entry-header -->'; // Close header

	return array( $header_html, $banner_html );
}