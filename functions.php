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
	$contact_form = filemtime( get_theme_file_path( 'assets/js/contactForm.js' ) );

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

	wp_enqueue_script(
		'oikos-contact-form-fix',
		get_theme_file_uri( 'assets/js/contactForm.js' ),
		array(),
		$contact_form,
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

function oikos_register_event_cpt() {
	register_post_type('oikos_event', [
		'labels' => [
			'name' => 'Oikos Events',
			'singular_name' => 'Oikos Event',
			'add_new_item' => 'Add New Oikos Event'
		],
		'public' => true,
		'show_in_rest' => true,
		'supports' => ['title','editor','custom-fields'],
		'has_archive' => false,
		'menu_icon' => 'dashicons-calendar-alt',
		'register_meta_box_cb' => 'oikos_add_event_metaboxes'
	]);

	register_taxonomy('oikos_event_category','oikos_event',[
		'label' => 'Event Categories',
		'show_in_rest' => true,
		'hierarchical' => false,
	]);

	register_post_meta('oikos_event','start_datetime',[
		'show_in_rest'=>true,'single'=>true,'type'=>'string'
	]);

	register_post_meta('oikos_event','end_datetime', [
		'show_in_rest' => true,
		'single' => true,
		'type' => 'string',
	]);

	register_post_meta('oikos_event', 'location', [
		'show_in_rest' => true,
		'single' => true,
		'type' => 'string',
	]);

	register_post_meta('oikos_event', 'category_label', [
		'show_in_rest' => true,
		'single' => true,
		'type' => 'string',
	]);

	register_post_meta('oikos_event', 'description', [
		'show_in_rest' => true,
		'single' => true,
		'type' => 'string',
	]);
}
add_action('init', 'oikos_register_event_cpt');

/**
 * Register the meta box container in the dashboard admin screen
 */
function oikos_add_event_metaboxes() {
    add_meta_box(
        'oikos_event_details_box',
        'Oikos Event Details',
        'oikos_render_event_metabox',
        'oikos_event',
        'normal',
        'high'
    );
}

/**
 * Render the HTML input fields inside the dashboard meta box
 */
function oikos_render_event_metabox($post) {
    // Security nonce field to verify identity on save
    wp_nonce_field('oikos_save_event_meta', 'oikos_event_meta_nonce');

    // Fetch existing values from the database
    $start_datetime  = get_post_meta($post->ID, 'start_datetime', true);
    $end_datetime    = get_post_meta($post->ID, 'end_datetime', true);
    $location        = get_post_meta($post->ID, 'location', true);
    $category_label  = get_post_meta($post->ID, 'category_label', true);
    $description     = get_post_meta($post->ID, 'description', true);

    // CSS Styling block for quick dashboard layout alignment
    echo '<style>
        .oikos-meta-row { margin-bottom: 15px; }
        .oikos-meta-row label { display: block; font-weight: bold; margin-bottom: 5px; }
    </style>';

    // Input fields HTML markup
    echo '<div class="oikos-meta-row">';
    echo '<label for="oikos_start_datetime">Start Date & Time</label>';
    echo '<input type="datetime-local" id="oikos_start_datetime" name="start_datetime" value="' . esc_attr($start_datetime) . '" class="components-text-control__input" />';
    echo '</div>';

    echo '<div class="oikos-meta-row">';
    echo '<label for="oikos_end_datetime">End Date & Time</label>';
    echo '<input type="datetime-local" id="oikos_end_datetime" name="end_datetime" value="' . esc_attr($end_datetime) . '" class="components-text-control__input" />';
    echo '</div>';

    echo '<div class="oikos-meta-row">';
    echo '<label for="oikos_location">Location</label>';
    echo '<input type="text" id="oikos_location" name="location" value="' . esc_attr($location) . '" class="widefat" />';
    echo '</div>';

    echo '<div class="oikos-meta-row">';
    echo '<label for="oikos_category_label">Category Label</label>';
    echo '<input type="text" id="oikos_category_label" name="category_label" value="' . esc_attr($category_label) . '" class="widefat" />';
    echo '</div>';

    echo '<div class="oikos-meta-row">';
    echo '<label for="oikos_description">Short Event Description</label>';
    echo '<textarea id="oikos_description" name="description" rows="4" class="widefat">' . esc_textarea($description) . '</textarea>';
    echo '</div>';
}

/**
 * Hook function to handle and sanitize data updates when hitting "Publish" or "Update"
 */
function oikos_save_event_meta_data($post_id) {
    // 1. Verify safety nonce token exists
    if (!isset($_POST['oikos_event_meta_nonce'])) {
        return;
    }

    // 2. Validate nonce legitimacy 
    if (!wp_verify_nonce($_POST['oikos_event_meta_nonce'], 'oikos_save_event_meta')) {
        return;
    }

    // 3. Skip saving during background system autosaves
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // 4. Verify user has clearance permissions to edit posts
    if (isset($_POST['post_type']) && 'oikos_event' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // 5. Array containing keys mapping dashboard names to meta database fields
    $meta_fields = [
        'start_datetime' => 'sanitize_text_field',
        'end_datetime'   => 'sanitize_text_field',
        'location'       => 'sanitize_text_field',
        'category_label' => 'sanitize_text_field',
        'description'    => 'sanitize_textarea_field', // Use textarea specific cleanup
    ];

    // Loop through each field to clean input data and update database rows
    foreach ($meta_fields as $key => $sanitize_function) {
        if (isset($_POST[$key])) {
            $sanitized_value = call_user_func($sanitize_function, $_POST[$key]);
            update_post_meta($post_id, $key, $sanitized_value);
        }
    }
}
add_action('save_post', 'oikos_save_event_meta_data');
