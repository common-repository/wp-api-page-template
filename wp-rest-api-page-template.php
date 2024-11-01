<?php
/*
Plugin Name: WP API Page template
Description: Extends WordPress WP REST API page endpoints with page template tag.
Author: Oleg Kostin
Version: 1.0
Author URI: http://oleg2tor.github.io
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if WP REST API is active
 **/
if ( in_array( 'rest-api/plugin.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :

    if ( ! function_exists ( 'wp_rest_page_template_init' ) ) :

        function wp_rest_page_template_init() {
            register_rest_field(
                'page',
                'template',
                array(
                    'get_callback' => 'wp_rest_page_template_return',
                )
            );
        }

        /**
         * Handler for updating page data with page_template.
         *
         * @since 1.0.0
         *
         * @param array $object The object from the response
         * @param string $field_name Name of field
         * @param WP_REST_Request $request Current request
         *
         * @return string|null
         */
        function wp_rest_page_template_return( $object, $field_name, $request ) {
            $templates = wp_get_theme()->get_page_templates();
            $current_template = get_page_template_slug($object['id']);

            return $current_template ? $templates[$current_template] : null;
        }

        add_action( 'init', 'wp_rest_page_template_init' );

    endif;

endif;
