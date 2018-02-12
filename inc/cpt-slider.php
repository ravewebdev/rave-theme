<?php
// Enqueue js, css
function slick_styles() {
    if ( get_post_meta( get_the_ID(), 'rave_thumbnail_banner', true ) == 'slider' ) {
        wp_enqueue_style( 'slick-style', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css' );
        wp_enqueue_style( 'slick-theme-style', get_template_directory_uri() . '/css/slick-theme.css' );
        wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array( 'jquery' ) );
    }
}
add_action( 'wp_enqueue_scripts', 'slick_styles');

// Footer script to initialize slider
function slick_footer_script() {
    if ( get_post_meta( get_the_ID(), 'rave_thumbnail_banner', true ) == 'slider' ) {
    ?>
    <script type="text/javascript">
        if ( undefined !== window.jQuery ) {
            var $ = jQuery;
            $( document ).ready( function() {
               $( '.slick-slider' ).slick( {
                   autoplaySpeed: 36000,
                   speed: 600,
                   autoplay: true,
                   prevArrow: '<a class="left carousel-control" href="#previous-slide" role="button" data-slide="prev"><i class="fa fa-angle-left" aria-hidden="true"></i><span class="sr-only">Previous</span></a>',
                   nextArrow: '<a class="right carousel-control" href="#next-slide" role="button" data-slide="next"><i class="fa fa-angle-right" aria-hidden="true"></i><span class="sr-only">Next</span></a>'
               });
            });
        }
    </script>
    <?php
    }
}
add_action( 'wp_footer', 'slick_footer_script' );

// Slider CPT
function create_slider_cpt() {
	// Slider
	$labels = array(
		'name'            => __( 'Slider' ),
		'singular_name'   => __( 'Slide' )
	);
	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'has_archive'     => true,
		'capability_type' => 'post',
		'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		//'rewrite' => array( 'slug' => 'slider' )
	);
	register_post_type( 'rave_slider', $args );
}
add_action( 'init', 'create_slider_cpt' );

// Slider taxonomies
function create_slider_taxonomies() {
    register_taxonomy(
        'slider_category',
        'rave_slider',
        array(
            'hierarchical'  => true,
            'label'         => 'Slider Category'
        )
    );
}
add_action( 'init', 'create_slider_taxonomies' );

// Get slides to display
function get_slides( $att ) {
    $args = array(
        'post_type'     => 'rave_slider',
        'post_status'   => 'publish'
    );
    if ( isset( $att['cat'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'slider_category',
                'terms'     => $att['cat']
            )
        );
    }
    $slides = get_posts( $args );
    return $slides;
}

// Generate, display slider
function slick_shortcode( $atts ) {
    $att = shortcode_atts( array( 
		'cat'     => 'home'
	 ), $atts );
    $slides = get_slides( $att );
    //print_r($slides);exit;
	$html = "<div class='slick-slider'>";
    foreach ( $slides as $slide ) {
        //print_r($slide);
        $image = get_the_post_thumbnail( $slide->ID );
        $content = apply_filters( 'the_content', $slide->post_content );
        if ( $image ) {
            $html .= '<div>';
            $html .= $image . "<div class='slide-desc'>{$content}</div>";
            $html .= '</div>';
        }
    }
    $html .= "</div>";
	return $html;
}
add_shortcode( 'slick_slider', 'slick_shortcode' );