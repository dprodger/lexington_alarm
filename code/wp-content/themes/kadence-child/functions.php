<?php
/**
 * Kadence child theme — functions.php
 *
 * Enqueues parent and child stylesheets. Keep this file lean; custom logic
 * belongs in the la-custom plugin, not here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent and child theme stylesheets.
 */
function la_kadence_child_enqueue_styles() {
	// Parent theme (Kadence).
	wp_enqueue_style( 'kadence-parent-style', get_template_directory_uri() . '/style.css' );

	// Child theme overrides.
	wp_enqueue_style(
		'la-kadence-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'kadence-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'la_kadence_child_enqueue_styles' );
