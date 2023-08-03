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
      'yellow-light-decorations' => __( 'Yellow Light Decor', 'frost' ),
			'blue-decorations' => __( 'Blue Decor', 'frost' ),
		),
		'core/list' => array(
			'no-disc' => __( 'No Disc', 'frost' ),
      'custom-order-list' => __( 'Custom Order List', 'frost' ),
			'custom-unorder-list' => __( 'Custom Unorder List', 'frost' ),
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
			'underline-blue' => __( 'Blue Underline', 'frost' ),
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

/**
 * Font Awesome CDN Setup Webfont
 *
 * This will load Font Awesome from the Font Awesome Free or Pro CDN.
 */
if (! function_exists('fa_custom_setup_cdn_webfont') ) {
  function fa_custom_setup_cdn_webfont($cdn_url = '', $integrity = null) {
    $matches = [];
    $match_result = preg_match('|/([^/]+?)\.css$|', $cdn_url, $matches);
    $resource_handle_uniqueness = ($match_result === 1) ? $matches[1] : md5($cdn_url);
    $resource_handle = "font-awesome-cdn-webfont-$resource_handle_uniqueness";

    foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
      add_action(
        $action,
        function () use ( $cdn_url, $resource_handle ) {
          wp_enqueue_style( $resource_handle, $cdn_url, [], null );
        }
      );
    }

    if($integrity) {
      add_filter(
        'style_loader_tag',
        function( $html, $handle ) use ( $resource_handle, $integrity ) {
          if ( in_array( $handle, [ $resource_handle ], true ) ) {
            return preg_replace(
              '/\/>$/',
              'integrity="' . $integrity .
              '" crossorigin="anonymous" />',
              $html,
              1
            );
          } else {
            return $html;
          }
        },
        10,
        2
      );
    }
  }
}
fa_custom_setup_cdn_webfont(
  'https://kit.fontawesome.com/06801edd47.css',
  ''
);

/**
 * Exclude the current post on single page
 *
 * 
 */
function exclude_current_post_shortcode( $atts ) {
    global $post;
    $current_post_id = $post->ID;

    $atts = shortcode_atts( array(
        'posts_per_page' => 5,
        'post_type'      => 'post',
    ), $atts, 'exclude_current_post' );

    $query_args = array(
        'post_type'      => $atts['post_type'],
        'posts_per_page' => absint( $atts['posts_per_page'] ),
        'post__not_in'   => array( $current_post_id ),
    );

    $query = new WP_Query( $query_args );

    if ( $query->have_posts() ) {
        ob_start();?>
<ul class="query-except-current-post">
       <?php while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <li class="custom-post-item">
                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="custom-post-thumbnail">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
										</figure>
                <?php endif; ?>

                <div class="custom-post-details">
                    <div class="custom-post-date">
                        <?php echo get_the_date('m.Y'); ?>
                    </div>
                    <h4 class="custom-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                </div>
								</li>
            <?php
        }?>
				</ul><?php

        wp_reset_postdata();

        return ob_get_clean();
    }
}
add_shortcode( 'exclude_current_post', 'exclude_current_post_shortcode' );

/**
 * Function to remove brackets from the end of the excerpt
 *
 * 
 */
function custom_trim_excerpt( $excerpt ) {
    // Find the last occurrence of the closing bracket "]"
    $last_bracket_pos = strrpos( $excerpt, ']' );

    // Find the first occurrence of the opening bracket "["
    $first_bracket_pos = strpos( $excerpt, '[' );

    // If both brackets are found, remove everything between them, including the brackets themselves
    if ( false !== $first_bracket_pos && false !== $last_bracket_pos ) {
        $excerpt = substr_replace( $excerpt, '', $first_bracket_pos, $last_bracket_pos - $first_bracket_pos + 1 );
    }

    return $excerpt;
}
add_filter( 'get_the_excerpt', 'custom_trim_excerpt' );

// Shortcode to display the video URL from ACF
function single_summit_video_shortcode() {
    // Get the video URL using the ACF function get_field()
    if (get_field('video')) {
        ob_start(); // Start output buffering

        ?>
        <div class="video-container">
            <?php

            // Load value.
            $iframe = get_field('video');

            // Use preg_match to find iframe src.
            preg_match('/src="(.+?)"/', $iframe, $matches);
            $src = $matches[1];

            // Add extra parameters to src and replace HTML.
            $params = array(
                'controls'  => 1,
                'hd'        => 1,
                'autohide'  => 1
            );
            $new_src = add_query_arg($params, $src);
            $iframe = str_replace($src, $new_src, $iframe);

            // Add extra attributes to iframe HTML.
            $attributes = 'frameborder="0"';
            $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

            if ($iframe) {
                ?>
                <div class="plyr__video-embed" id="player"><?php echo $iframe; ?></div>
                <?php
            } else {
                ?>
                <figure><?php echo get_the_post_thumbnail(); ?></figure>
                <?php
            }

            ?>
        </div>
        <?php

        // Get the buffered content and clean the buffer
        $output = ob_get_clean();

        return $output;
    }
}
add_shortcode('single_summit_video', 'single_summit_video_shortcode');