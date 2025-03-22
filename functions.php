<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package falls-co
 * @since 1.0.0
 */

/**
 * The theme version.
 *
 * @since 1.0.0
 */
define( 'FALLS_CO_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'FALLS_CO_URL', get_template_directory_uri() );
define( 'FALLS_CO_PATH', get_theme_file_path() );

/**
 * Add theme support for block styles and editor style.
 *
 * @since 1.0.0
 *
 * @return void
 */
function falls_co_setup() {
	add_editor_style( './assets/css/style-shared.min.css' );
	add_editor_style( 'admin-style.css' );

	/*
	 * Load additional block styles.
	 * See details on how to add more styles in the readme.txt.
	 */
	$styled_blocks = array( 
    'button',
    'details',
    'navigation',
    'post-content',
    'quote', 
    'search',
    'table',
  );
	foreach ( $styled_blocks as $block_name ) {
		$args = array(
			'handle' => "falls-co-$block_name",
			'src'    => get_theme_file_uri( "assets/css/blocks/$block_name.min.css" ),
			'path'   => get_theme_file_path( "assets/css/blocks/$block_name.min.css" ),
		);
		// Replace the "core" prefix if you are styling blocks from plugins.
		wp_enqueue_block_style( "core/$block_name", $args );
	}

}
add_action( 'after_setup_theme', 'falls_co_setup' );

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function falls_co_styles() {

	wp_enqueue_style(
		'falls-co-style',
		get_template_directory_uri() . '/style.css',
		array(),
		FALLS_CO_VERSION
	);
	wp_enqueue_style(
		'falls-co-shared-styles',
		get_template_directory_uri() . '/assets/css/style-shared.min.css',
		array(),
		FALLS_CO_VERSION
	);
}

function falls_co_editor_styles() {
  wp_enqueue_style(
		'falls-co-admin-styles',
		get_template_directory_uri() . '/admin-style.css',
		array(),
		FALLS_CO_VERSION
	);
}

function falls_co_scripts() {
  wp_enqueue_script( 
    'slick', 
    get_template_directory_uri() . '/assets/js/dist/slick.min.js', 
    array('jquery'), 
    FALLS_CO_VERSION, 
    true 
  );
  wp_enqueue_script( 
    'slick-falls', 
    get_template_directory_uri() . '/assets/js/dist/slick-slider.min.js', 
    array('jquery', 'slick'), 
    FALLS_CO_VERSION, 
    true 
  );
  
}


add_action( 'admin_enqueue_scripts', 'falls_co_editor_styles' );
add_action( 'admin_enqueue_scripts', 'falls_co_scripts' );
add_action( 'wp_enqueue_scripts', 'falls_co_styles' );
add_action( 'wp_enqueue_scripts', 'falls_co_scripts' );

// Blocks
require_once get_theme_file_path( 'inc/register-blocks.php' );

// Filters.
require_once get_theme_file_path( 'inc/filters.php' );