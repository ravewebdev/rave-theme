<?php
/**
 * RAVE functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RAVE
 */

if ( ! function_exists( 'r_a_v_e_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function r_a_v_e_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on RAVE, use a find and replace
	 * to change 'r_a_v_e' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'r_a_v_e', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'r_a_v_e' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'r_a_v_e_custom_background_args', array(
		'default-color' 	=> 'ffffff',
		'default-image' 	=> '',
		'wp-head-callback'	=> 'rave_custom_header_callback'
	) ) );
}
endif;
add_action( 'after_setup_theme', 'r_a_v_e_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function r_a_v_e_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'r_a_v_e_content_width', 640 );
}
add_action( 'after_setup_theme', 'r_a_v_e_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rave_register_sidebar( $name, $id, $desc ) {
	register_sidebar( array(
		'name'          => esc_html__( $name, 'r_a_v_e' ),
		'id'            => $id,
		'description'   => esc_html__( $desc, 'r_a_v_e' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
function r_a_v_e_widgets_init() {
	rave_register_sidebar( 'Header Info', 'header-info', 'Widget area in top right area of header.' );	
	rave_register_sidebar( 'Homepage Sidebar', 'homepage-left', 'Widget area on left of homepage.' );	
	rave_register_sidebar( 'Sidebar', 'sidebar-posts', 'Sidebar for posts.' );
	rave_register_sidebar( 'Page Sidebar', 'sidebar-page', 'Sidebar for pages.' );
	rave_register_sidebar( 'Footer Left', 'footer-left', 'Widget area in left area of footer.' );	
	rave_register_sidebar( 'Footer Right', 'footer-right', 'Widget area in right area of footer.' );	
}
add_action( 'widgets_init', 'r_a_v_e_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function r_a_v_e_scripts() {
	wp_enqueue_style( 'r_a_v_e-style', get_stylesheet_uri() );

	wp_enqueue_style( 'fonts-droid', '//fonts.googleapis.com/css?family=Droid+Serif' );

	//wp_enqueue_script( 'r_a_v_e-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	//wp_enqueue_script( 'r_a_v_e-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'bootstrap-modules-js', get_template_directory_uri() . '/js/bootstrap-modules.js', array( 'jquery', 'bootstrap-js' ), '', true );

	wp_enqueue_script( 'font-awesome-js', 'https://use.fontawesome.com/dd40eaa6f3.js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'r_a_v_e_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * CMB2
 */
if ( file_exists( get_template_directory() . '/inc/cmb2/init.php' ) ) {
	require_once get_template_directory() . '/inc/cmb2/init.php';
} elseif ( file_exists( get_template_directory() . '/inc/CMB2/init.php' ) ) {
	require_once get_template_directory() . '/inc/CMB2/init.php';
}
if ( file_exists( get_template_directory() . '/inc/cmb2-conditionals/cmb2-conditionals.php' ) ) {
	require_once get_template_directory() . '/inc/cmb2/cmb2-conditionals.php';
} elseif ( file_exists( get_template_directory() . '/inc/CMB2-conditionals/cmb2-conditionals.php' ) ) {
	require get_template_directory() . '/inc/CMB2-conditionals/cmb2-conditionals.php';
}

/*
 * Load custom walker class
 */
if ( file_exists( get_template_directory() . '/inc/rave-walker.php' ) ) {
	require_once get_template_directory() . '/inc/rave-walker.php';
}

/*
 * Customize default page template display name
 */
add_filter( 'default_page_template_title', 'rave_default_page_template_title' );
function rave_default_page_template_title( $title ) {
	return __( 'Full Width Template' );
}

/*
 * Load CPTs, CMBs
 */
if ( file_exists( get_template_directory() . '/inc/cpt-slider.php' ) ) {
	require_once get_template_directory() . '/inc/cpt-slider.php';
}
if ( file_exists( get_template_directory() . '/inc/cmb-theme.php' ) ) {
	require_once get_template_directory() . '/inc/cmb-theme.php';
}

/*
 * Display social links
 */
function rave_display_social( $cl = '' ) {
	?>
	<div class="social-links <?php echo $cl; ?>">
		<?php
		$socials = array( 'facebook', 'twitter', 'tumblr', 'google-plus', 'pinterest', 'email' );
		foreach ( $socials as $social ) {
			$name = ucwords( str_replace( '-', ' ', $social ) );
			$soc = get_theme_mod( "rave_social_{$social}" );
			$link = $social == 'email' ? "mailto:{$soc}" : $soc;
			$icon = $social != 'email' ? $social : 'envelope';
			$icon .= $icon == 'pinterest' ? '-p' : '';
			echo isset( $soc ) && $soc != '' ? "<a href='{$link}' target='_blank' title='Check us out on {$name}'><span class='sr-only'>{$name}</span><i class='fa fa-{$icon}' aria-hidden='true'></i></a>" : ''; //FINISH
		}
		?>
	</div><!-- .social-links -->
	<?php
}

/*
 * Customize custom header output
 */
function rave_custom_header_callback() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment . 'background-size: contain';
	}
	if ( is_home() || is_front_page() ) {
		?>
		<style type="text/css" id="custom-background-css">
		.custom-background .site-content { <?php echo trim( $style ); ?> }
		</style>
		<?php
	}
}