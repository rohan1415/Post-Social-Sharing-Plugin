<?php
/*
Plugin Name: Simple Social Share
Plugin URI: http://example.com/simple-social-share
Description: A simple plugin to add social share buttons to your posts.
Version: 1.0
Author: Your Name
Author URI: http://example.com
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SSS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include necessary files
require_once SSS_PLUGIN_DIR . 'includes/admin-menu.php';
require_once SSS_PLUGIN_DIR . 'includes/setting.php';
require_once SSS_PLUGIN_DIR . 'includes/display.php';

/**
 * Enqueue Font Awesome for social share icons.
 */
function sss_enqueue_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'sss_enqueue_font_awesome' );
