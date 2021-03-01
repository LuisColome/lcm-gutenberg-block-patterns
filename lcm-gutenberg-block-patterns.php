<?php
/**
 * Plugin Name: LCM Gutenberg Block Patterns
 * Plugin URI: https://luiscolome.com/tutoriales/crear-plugin-de-patrones-gutenberg/
 * Author: Luis Colomé
 * Author URI: http://www.luiscolome.com
 * Description: A simple plugin to add Block Patterns and Block Pattern categories to Gutenberg.
 * Version: 1.0
 */

/**
 * Dont Update the Plugin
 * If there is a plugin in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.0.0
 * @author Jon Brown
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
function be_dont_update_core_func_plugin( $r, $url ) {
    if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) )
    return $r; // Not a plugin update request. Bail immediately.
    $plugins = json_decode( $r['body']['plugins'], true );
    unset( $plugins['plugins'][plugin_basename( __FILE__ )] );
    $r['body']['plugins'] = json_encode( $plugins );
    return $r;
}
add_filter( 'http_request_args', 'be_dont_update_core_func_plugin', 5, 2 );

/**
 * Register a pattern category
 * 
 */
function lcm_register_block_categories() {
	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {

		register_block_pattern_category(
			'custom',
			array( 'label' => _x( 'Custom Patterns', 'Block pattern category', 'lcm_block_patterns' ) )
		);

	}
}
add_action( 'init', 'lcm_register_block_categories' );


/**
 * Register block patterns
 * 
 */
function lcm_register_block_patterns()
{
    if (function_exists('register_block_pattern')) {
        
        // Intro paragraph with cover image and paragraphs
        register_block_pattern(
            'lcm-gutenberg-block-patterns/intro-cover-two-paragraphs',
            array(
                'title' => __('Intro paragraph with cover image and paragraphs', 'lcm_block_patterns'),
                'description' => _x( 'A two columns block with paragraphs lead with an intro and a cover image.', 'Block pattern description', 'lcm_block_patterns' ),
                'categories' => array( 'custom' ), // Our new category register above.
                'keywords' => array( 'text', 'column', 'columns', 'cover', 'image'),
                'content' => "<!-- wp:spacer -->\n<div style=\"height:40px\" aria-hidden=\"true\" class=\"wp-block-spacer\"></div>\n<!-- /wp:spacer -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column {\"width\":\"70%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:70%\"><!-- wp:paragraph {\"fontSize\":\"larger\"} -->\n<p class=\"has-large-font-size\">Sin duda alguna, la mejor hamburguesa vegana de Vienna. Hecha con ingredientes locales y alternativas según la temporada.</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:cover {\"url\":\"https://luiscolome.com/wp-content/uploads/vegan-burger.jpg\",\"id\":4733,\"dimRatio\":40,\"overlayColor\":\"medium-gray\",\"minHeight\":200,\"minHeightUnit\":\"px\"} -->\n<div class=\"wp-block-cover has-background-dim-40 has-medium-gray-background-color has-background-dim\" style=\"background-image:url(https://luiscolome.com/wp-content/uploads/vegan-burger.jpg);min-height:200px\"><div class=\"wp-block-cover__inner-container\"><!-- wp:paragraph {\"align\":\"center\",\"placeholder\":\"Write title…\",\"fontSize\":\"large\"} -->\n<p class=\"has-text-align-center has-large-font-size\"></p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:cover -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:paragraph -->\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel fermentum ex. Fusce in leo sit amet est elementum sollicitudin quis quis dui. Aliquam suscipit sollicitudin nibh vitae molestie. </p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:paragraph -->\n<p>Nulla sem metus, mollis viverra nulla sit amet, accumsan tempor nibh. Mauris pretium mauris sollicitudin tincidunt consequat. Nunc molestie convallis diam, porta posuere lacus ullamcorper vitae.</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->",
            )
        );
    }
}
add_action('init', 'lcm_register_block_patterns');