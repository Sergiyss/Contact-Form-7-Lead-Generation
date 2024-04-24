<?php
/**
 * Plugin Name: Contact Form 7 Lead Generation by if.team
 * Description: A powerful & beautiful documentation, knowledge base builder plugin.
 * Plugin URI: https://if.team
 * Author: if.team
 * Author URI: https://if.team
 * Version: 0.0.1
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Text Domain: if.team
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

function cf7_lg_scripts() {
    wp_enqueue_script('main', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), '1.0', true);
    wp_localize_script( 'main', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
}

add_action('wp_enqueue_scripts', 'cf7_lg_scripts');



function cf7_lg_style() {
    wp_enqueue_style( 'my-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array(), '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'cf7_lg_style' );







?>