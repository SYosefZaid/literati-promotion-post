<?php
/*
Plugin Name: Literati Example
Plugin URI: https://github.com/literatibooks/literati-wp-example
Description:
Version: 1.0.0
Author: Literati
Author URI: https://literati.com/
Text Domain: literati-example
*/

use Literati\Example\Plugin;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit();
}

add_action(
    'plugins_loaded',
    function () {
        if (file_exists(__DIR__ . '/vendor/autoload.php')) {
            include __DIR__ . '/vendor/autoload.php';
        }

        LITERATI_EXAMPLE();
    },
);

/**
 * Returns the main instance of the plugin to prevent the need to use globals.
 */
function LITERATI_EXAMPLE()
{
    return Plugin::instance();
}

include_once 'includes/PromotionPostType.php';

function literati_plugin_activation()
{
    register_promotion_post_type();
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'literati_plugin_deactivation');

function literati_plugin_deactivation()
{
    flush_rewrite_rules();
}

function literati_enqueue_block_assets()
{
    wp_enqueue_script(
        'literati-promotion-carousel-block',
        plugins_url('/blocks/carousel/build/index.js', __FILE__),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . '/blocks/carousel/build/index.js')
    );

    wp_enqueue_style(
        'literati-promotion-carousel-style',
        plugins_url('/blocks/carousel/build/style-index.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . '/blocks/carousel/build/style-index.css')
    );
}
add_action('enqueue_block_assets', 'literati_enqueue_block_assets');