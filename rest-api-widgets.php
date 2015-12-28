<?php
/*
Plugin Name: Rest API Widgets
Version: 0.1-alpha
Description: Simple Useful Widgets Using WP REST API.
Author: hideokamoto
Author URI: YOUR SITE HERE
Plugin URI: PLUGIN SITE HERE
Text Domain: rest-api-widgets
Domain Path: /languages
*/
require_once( dirname( __FILE__ ).'/includes/comment-widget.php' );

add_action( 'wp_enqueue_scripts', 'rest_api_widgets_scripts' );
function rest_api_widgets_scripts() {
	wp_enqueue_script( 'script-name', plugin_dir_url( __FILE__ ).'/includes/comment-widget.js', array(), '1.0.0', true );
}
