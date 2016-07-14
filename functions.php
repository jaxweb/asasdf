<?php
/**
 * JWD.
 * This file adds functions to the Genesis Child JWD Theme.
 * @package JWD
 * @author  Jacksonville Website Design
 * @license GPL-2.0+
 * @link    https://jacksonvillewebsitedesign.com/
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'jwd', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'jwd' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'JWD' );
define( 'CHILD_THEME_URL', 'https://jacksonvillewebsitedesign.com/' );
define( 'CHILD_THEME_VERSION', '2.2.4' );

//*adds child style.css
add_action( 'wp_enqueue_scripts', 'my_child_theme_scripts' );
function my_child_theme_scripts() {
    wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
}
//* loads child stylesheet priority over parent
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 15 );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'genesis_jwd_enqueue_scripts_styles' );
function genesis_jwd_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-jwd-fonts', '//fonts.googleapis.com/css?family=Material+Icons|Open+Sans', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'genesis-jwd-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'genesis-jwd' ),
		'subMenu'  => __( 'Menu', 'genesis-jwd' ),
	);
	wp_localize_script( 'genesis-jwd-responsive-menu', 'genesisSampleL10n', $output );
}

//* removes copyright and credit at footer 
remove_action( 'genesis_footer', 'genesis_do_footer' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//*Removes superfish scripts
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

//*disable emoji unnecessary scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//* DISABLES ALL EMBEDDED SCRIPTS USED TO AUTO EMBED MEDIA FROM EXTERNAL SITES
function disable_embeds_init() {
    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');
    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'disable_embeds_init', 9999);

// REMOVES COMMENTING SCRIPT FOR BLOGS THAT DO NOT HAVE COMMENTS ENABLED
// Remove comment-reply.min.js from footer
function crunchify_clean_header_hook(){
	wp_deregister_script( 'comment-reply' );
         }
add_action('init','crunchify_clean_header_hook');

//REMOVES VERSION NUMBERS AT THE END OF SCRIPT FILE URLS
function wpex_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'wpex_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'wpex_remove_script_version', 15, 1 );


//Add in new Widget areas in Footer
function genesischild_extra_widgets() {
	genesis_register_sidebar( array(
	'id'          => 'footerleft',
	'name'        => __( 'Footer Left', 'jwd' ),
	'description' => __( 'This is the footer left area', 'jwd' ),
	'before_widget' => '',
    'after_widget' => '',
	) );
	genesis_register_sidebar( array(
	'id'          => 'footerright',
	'name'        => __( 'Footer Right', 'jwd' ),
	'description' => __( 'This is the footer right area', 'jwd' ),
	'before_widget' => '',
    'after_widget' => '',
	) );
}
add_action('widgets_init', 'genesischild_extra_widgets');
//Remove The Old Footer
function genesischild_oldfooter() {
remove_action('genesis_footer', 'genesis_do_footer');
}
add_action('genesis_setup','genesischild_oldfooter');
//Add the New Footer
function genesischild_newfooter() {
    genesis_widget_area ('footerleft',array(
        'before' => '<div class="first one-half">',
        'after' => '</div>',));
    genesis_widget_area ('footerright',	array(
        'before' => '<div class="one-half">',
        'after' => '</div>',));
}
add_action('genesis_footer','genesischild_newfooter');
