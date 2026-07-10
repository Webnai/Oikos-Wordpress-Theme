<?php
/**
 * Oikos block theme setup.
 *
 * @package Oikos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end styles and scripts.
 */
function oikos_enqueue_assets() {
	$theme = wp_get_theme();

	wp_enqueue_style(
		'oikos-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array(),
		$theme->get( 'Version' )
	);

	wp_enqueue_script(
		'oikos-animations',
		get_theme_file_uri( 'assets/js/animations.js' ),
		array(),
		$theme->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'oikos_enqueue_assets' );

/**
 * Enqueue editor-specific styles.
 */
function oikos_enqueue_editor_assets() {
	$theme = wp_get_theme();

	wp_enqueue_style(
		'oikos-editor-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array(),
		$theme->get( 'Version' )
	);
}
add_action( 'enqueue_block_editor_assets', 'oikos_enqueue_editor_assets' );

/**
 * Register block pattern categories.
 */
function oikos_register_pattern_categories() {
	register_block_pattern_category(
		'oikos-sections',
		array(
			'label' => __( 'Oikos Sections', 'oikos' ),
		)
	);
}
add_action( 'init', 'oikos_register_pattern_categories' );
