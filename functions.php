<?php
/**
 * This file adds functions to the Frost WordPress theme.
 *
 * @package Frost
 * @author  WP Engine
 * @license GNU General Public License v2 or later
 * @link    https://frostwp.com/
 */

if ( ! function_exists( 'frost_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 0.8.0
	 *
	 * @return void
	 */
	function frost_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'frost', get_template_directory() . '/languages' );

		// Enqueue editor styles and fonts.
		add_editor_style(
			array(
				'./style.css',
			)
		);

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );

	}
}
add_action( 'after_setup_theme', 'frost_setup' );

// Enqueue style sheet.
add_action( 'wp_enqueue_scripts', 'frost_enqueue_style_sheet' );
function frost_enqueue_style_sheet() {

	wp_enqueue_style( 'frost', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	
	wp_enqueue_style( 'osi', get_template_directory_uri() . '/osi-custom.css', array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_script( 'osi-js', get_template_directory_uri() . '/osi-custom.js', array( 'jquery' ), '1.8.1', true );

}

/**
 * Register block styles.
 *
 * @since 0.9.2
 */
function frost_register_block_styles() {

	$block_styles = array(
		'core/columns' => array(
			'columns-reverse' => __( 'Reverse', 'frost' ),
			'border-rounded' => __( 'Border Rounded', 'frost' ),
		),
		'core/group' => array(
			'shadow-light' => __( 'Shadow', 'frost' ),
			'shadow-solid' => __( 'Solid', 'frost' ),
		),
		'core/image' => array(
			'shadow-light' => __( 'Shadow', 'frost' ),
			'shadow-solid' => __( 'Solid', 'frost' ),
			'image-girl-animated' => __( 'Girl Img Animated', 'frost' ),
			'yellow-decorations' => __( 'Yellow Decor', 'frost' ),
			'blue-decorations' => __( 'Blue Decor', 'frost' ),
		),
		'core/list' => array(
			'no-disc' => __( 'No Disc', 'frost' ),
		),
		'core/navigation-link' => array(
			'outline' => __( 'Outline', 'frost' ),
		),
		'core/quote' => array(
			'shadow-light' => __( 'Shadow', 'frost' ),
			'shadow-solid' => __( 'Solid', 'frost' ),
		),
		'core/social-links' => array(
			'outline' => __( 'Outline', 'frost' ),
		),
		'core/heading' => array(
			'underline-animated' => __( 'Orange Underline', 'frost' ),
			'double-underline-animated' => __( 'Yellow Double Underline', 'frost' ),
			'double-underline-blue' => __( 'Blue Double Underline', 'frost' ),
		),
		'core/button' => array(
			'color-outline' => __( 'Color Outline', 'frost' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'frost_register_block_styles' );

/**
 * Register block pattern categories.
 *
 * @since 1.0.4
 */
function frost_register_block_pattern_categories() {

	register_block_pattern_category(
		'page',
		array(
			'label'       => __( 'Page', 'frost' ),
			'description' => __( 'Create a full page with multiple patterns that are grouped together.', 'frost' ),
		)
	);
	register_block_pattern_category(
		'pricing',
		array(
			'label'       => __( 'Pricing', 'frost' ),
			'description' => __( 'Compare features for your digital products or service plans.', 'frost' ),
		)
	);

}

add_action( 'init', 'frost_register_block_pattern_categories' );


// Allow SVG file uploads
function custom_mime_types( $mimes ) {
    // Add SVG to the list of allowed file types
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    
    return $mimes;
}
add_filter( 'upload_mimes', 'custom_mime_types' );

// Enable SVG thumbnail preview
function custom_svg_thumb_size( $sizes ) {
    $sizes['svg'] = __( 'SVG Image' );
    
    return $sizes;
}
add_filter( 'image_size_names_choose', 'custom_svg_thumb_size' );
function enable_svg_upload( $upload_mimes ) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload', 10, 1 );


function custom_theme_customizer( $wp_customize ) {
    // Add a custom setting
    $wp_customize->add_setting( 'custom_setting', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Add a control for the custom setting
    $wp_customize->add_control( 'custom_setting', array(
        'label'    => __( 'Custom Setting', 'textdomain' ),
        'section'  => 'custom_section',
        'type'     => 'text',
    ) );
}
add_action( 'customize_register', 'custom_theme_customizer' );