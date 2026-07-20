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
	$css_version = filemtime( get_theme_file_path( 'assets/css/main.css' ) );
	$js_version  = filemtime( get_theme_file_path( 'assets/js/animations.js' ) );
	$accordion_js = filemtime( get_theme_file_path( 'assets/js/accordionFix.js' ) );

	wp_enqueue_style(
		'oikos-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array(),
		$css_version
	);

	wp_enqueue_script(
		'oikos-animations',
		get_theme_file_uri( 'assets/js/animations.js' ),
		array(),
		$js_version,
		true
	);

	wp_enqueue_script(
		'oikos-accordion-fix',
		get_theme_file_uri( 'assets/js/accordionFix.js' ),
		array(),
		$accordion_js,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'oikos_enqueue_assets' );

/**
 * Enqueue editor-specific styles.
 */
function oikos_enqueue_editor_assets() {
	$css_version = filemtime( get_theme_file_path( 'assets/css/main.css' ) );

	wp_enqueue_style(
		'oikos-editor-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array(),
		$css_version
	);
}
add_action( 'enqueue_block_editor_assets', 'oikos_enqueue_editor_assets' );

/**
 * Register button style variations.
 */
function oikos_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'primary-btn',
			'label' => __( 'Primary Button', 'oikos' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'secondary-btn',
			'label' => __( 'Secondary Button', 'oikos' ),
		)
	);
}
add_action( 'init', 'oikos_register_block_styles' );

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
