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
require_once( dirname( __FILE__ ).'/includes/class/class.commentform.php' );


function register_rest_comment_widget() {
    register_widget( 'Rest_Comment_Form_Widget' );
}
add_action( 'widgets_init', 'register_rest_comment_widget' );

function rest_api_widgets_scripts() {
	wp_enqueue_script( 'rest-api-widgets', plugin_dir_url( __FILE__ ).'/includes/js/common.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'rest_api_widgets_scripts' );
