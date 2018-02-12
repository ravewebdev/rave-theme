<?php
/**
 * RAVE Theme Customizer.
 *
 * @package RAVE
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function r_a_v_e_customize_register( $wp_customize ) {
	/*
	 * Site Identity
	 */
	$wp_customize->add_panel( 'site_globals', array(
		'title' 			=> __( 'Global Settings', 'r_a_v_e' ),
		'priority'			=> 1,
		'theme_supports' 	=> '',
		'description'		=> 'Controls the global settings for the theme.'
	) );
	$wp_customize->add_section( 'social_links', array(
		'title' 	=> __( 'Social Media Links', 'r_a_v_e'  ),
		'panel'		=> 'site_globals',
		'priority'	=> 100
	) );
	$socials = array( 'facebook', 'twitter', 'tumblr', 'google-plus', 'pinterest', 'email' );
	foreach ( $socials as $social ) {
		$sanitize = $social == 'email' ? 'rave_sanitize_email' : 'rave_sanitize_url';
		$wp_customize->add_setting(
			"rave_social_{$social}",
			array(
				'default'			=> '',
				'sanitize_callback'	=> $sanitize
			)
		);
		$name = ucwords( str_replace( '-', ' ', $social ) );
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				"social_{$social}",
				array(
					'label'			=> __( $name, 'r_a_v_e' ),
					'section'		=> 'social_links',
					'settings'		=> "rave_social_{$social}",
					'type'			=> 'text'
				)
			)
		);
	}
	$wp_customize->get_section( 'title_tagline' )->panel 		= 'site_globals';
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->add_setting(
		'rave_color_scheme',
		array(
			'default'	=> 'dark'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_color_scheme',
			array(
				'label'			=> __( 'Color Scheme', 'r_a_v_e' ),
				'section'		=> 'title_tagline',
				'settings'		=> 'rave_color_scheme',
				'type'			=> 'select',
				'choices'		=> array(
					'dark'	=> 'Inverse (Light on Dark)',
					'light' => 'Original (Dark on Light)'
				)
			)
		)
	);

	/*
	 * Colors
	 */
	$wp_customize->get_control( 'header_textcolor' )->section = 'title_tagline';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/*
	 * Header Image
	 */

	/*
	 * Background Image
	 */
	$wp_customize->get_section( 'background_image')->title = __( 'Background', 'r_a_v_e' );
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

	/*
	 * Menus
	 */
	$wp_customize->add_setting(
		'rave_menu_position',
		array(
			'default'	=> 'static'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_menu_position',
			array(
				'label'				=> __( 'Primary Menu Position', 'r_a_v_e' ),
				'section'			=> 'menu_locations',
				'settings'			=> 'rave_menu_position',
				'type'				=> 'select',
				'choices'			=> array(
					'static'	=> 'Default (Top of Page)',
					'fixed' 	=> 'Fixed (Always Visible)'
				)
			)
		)
	);

	/*
	 * Widgets
	 */

	/*
	 * Static Front Page
	 */
	$wp_customize->get_section( 'static_front_page')->title = __( 'Homepage & Blog', 'r_a_v_e' );
	$wp_customize->get_control( 'show_on_front' )->label 	= __( 'Homepage Preference', 'r_a_v_e' );
	$wp_customize->get_control( 'page_on_front' )->label 	= __( 'Select Homepage', 'r_a_v_e' );
	$wp_customize->get_control( 'page_for_posts' )->label 	= __( 'Select Blog', 'r_a_v_e' );

	$wp_customize->add_setting(
		'rave_posts_sidebar_position',
		array(
			'default'	=> 'right'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_posts_sidebar_position',
			array(
				'label'			=> __( 'Blog Sidebar Position', 'r_a_v_e' ),
				'section'		=> 'static_front_page',
				'settings'		=> 'rave_posts_sidebar_position',
				'type'			=> 'select',
				'choices'		=> array(
					'right'	=> 'Right of Content',
					'left'	=> 'Left of Content'
				)
			)
		)
	);

	/*
	 * Footer
	 */
	$wp_customize->add_section( 'footer_text', array(
		'title' 	=> __( 'Footer', 'r_a_v_e'  ),
		'priority'	=> 1000
	) );
	$wp_customize->add_setting(
		'rave_footer_text',
		array(
			'default'			=> get_bloginfo( 'name' ),
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'rave_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_footer_text',
			array(
				'label'			=> __( 'Footer Copyright Info', 'r_a_v_e' ),
				'section'		=> 'footer_text',
				'settings'		=> 'rave_footer_text',
				'type'			=> 'text'
			)
		)
	);
}
add_action( 'customize_register', 'r_a_v_e_customize_register' );

function rave_sanitize_text( $text ) {
	return sanitize_text_field( $text );
}
function rave_sanitize_url( $url ) {
	return ( filter_var( $url, FILTER_VALIDATE_URL ) !== false ) ? esc_url_raw( $url ) : null;
}
function rave_sanitize_email( $email ) {
	return ( is_email( $email ) ) ? $email : null;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function r_a_v_e_customize_preview_js() {
	wp_enqueue_script( 'r_a_v_e_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'r_a_v_e_customize_preview_js' );
