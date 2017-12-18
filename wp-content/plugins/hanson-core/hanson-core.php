<?php
/*
Plugin Name: Hanson Core
Plugin URI:  http://ithemeslab.com
Description: This plugin enables the core features to this theme. You must have to install this plugin to work with the theme.
Version:     1.0
Author:      iThemesLab
Author URI:  http://ithemeslab.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hanson-core
Domain Path: /languages
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

define( 'HUDSON_CORE_DIRECTORY_PATH', plugin_dir_path( __FILE__ ) );

load_plugin_textdomain('hanson-core', false, basename( dirname( __FILE__ ) ) . '/languages' );

require_once HUDSON_CORE_DIRECTORY_PATH . '/itl-helper/elementor-category-init.php';
require_once HUDSON_CORE_DIRECTORY_PATH . '/itl-helper/helper-functions.php';
require_once HUDSON_CORE_DIRECTORY_PATH . '/itl-helper/query-functions.php';

// import other files
$main_file_dir = HUDSON_CORE_DIRECTORY_PATH . '/inc/metabox/';
foreach ( glob( $main_file_dir . '*.php' ) as $main_files ) {
    require_once $main_files;
}

// import custom post types
$cpt_dir = HUDSON_CORE_DIRECTORY_PATH . '/inc/cpt/';
foreach ( glob( $cpt_dir . '*.php' ) as $cpt_files ) {
    require_once $cpt_files;
}

// import elementor widgets
function ithemeslab_register_elementor_widgets() {
	$elementor_widgets_dir = HUDSON_CORE_DIRECTORY_PATH . '/inc/elementor-widgets/';
	foreach ( glob( $elementor_widgets_dir . '*.php' ) as $elementor_addons_files ) {
		require_once $elementor_addons_files;
	}
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/clients.php';
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/post-grid.php';
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/portfolio.php';
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/pricing-table.php';
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/team.php';
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/testimonial.php';
	require_once HUDSON_CORE_DIRECTORY_PATH . '/inc/itl-widgets/pie-chart.php';
	if ( function_exists( 'wpcf7' ) ) {
		require_once HUDSON_CORE_DIRECTORY_PATH.'/inc/itl-widgets/contact-form-7.php';
	}
}

add_action( 'elementor/widgets/widgets_registered', 'ithemeslab_register_elementor_widgets' );

function load_itl_styles() {
	wp_enqueue_style( 'owl-carousel', plugins_url( '/assets/css/vendor/owl.carousel.min.css',  __FILE__ )  );
	wp_enqueue_style( 'owl-theme', plugins_url( '/assets/css/vendor/owl.theme.default.min.css',  __FILE__ )  );
	wp_enqueue_style( 'venobox', plugins_url( '/assets/css/vendor/venobox.css',  __FILE__ )  );
	wp_enqueue_style( 'plugin-styles', plugins_url( '/assets/css/style.css',  __FILE__ )  );
}
add_action( 'wp_enqueue_scripts', 'load_itl_styles' );

function load_itl_scripts() {
	wp_enqueue_script( 'owl-carousel-js', plugins_url( '/assets/js/vendor/owl.carousel.min.js',  __FILE__ ), array( 'jquery' )  );
	wp_enqueue_script( 'isotope-js', plugins_url( '/assets/js/vendor/isotope.pkgd.min.js',  __FILE__ ), array( 'jquery' )  );
	wp_enqueue_script( 'venobox-js', plugins_url( '/assets/js/vendor/venobox.min.js',  __FILE__ ), array( 'jquery' )  );
	wp_enqueue_script( 'waypoint-js', plugins_url( '/assets/js/vendor/jquery.waypoints.min.js',  __FILE__ ), array( 'jquery' )  );
	wp_enqueue_script( 'easy-piechart-js', plugins_url( '/assets/js/vendor/jquery.easypiechart.min.js',  __FILE__ ), array( 'jquery' )  );
	wp_enqueue_script( 'main-js', plugins_url( '/assets/js/itl-main.js',  __FILE__ ), array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'load_itl_scripts' );