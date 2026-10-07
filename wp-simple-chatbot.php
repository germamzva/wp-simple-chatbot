<?php
/**
 * Plugin Name: WP Simple Chatbot
 * Description: A secure, maintainable chatbot shortcode for WordPress.
 * Version: 1.1.0
 * Author: WP Simple Chatbot
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WPSIMPLE_CHATBOT_PLUGIN_FILE', __FILE__);
define('WPSIMPLE_CHATBOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPSIMPLE_CHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once WPSIMPLE_CHATBOT_PLUGIN_DIR . 'includes/class-wp-simple-chatbot.php';
require_once WPSIMPLE_CHATBOT_PLUGIN_DIR . 'includes/class-wp-simple-chatbot-ajax.php';

function wp_simple_chatbot_bootstrap()
{
    new WP_Simple_Chatbot();
    new WP_Simple_Chatbot_Ajax();
}

add_action('plugins_loaded', 'wp_simple_chatbot_bootstrap');
