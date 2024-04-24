<?php
/**
 * Plugin Name: Contact Form 7 Lead Generation by if.team
 * Description: Плагін з інтреграцією з Contact Form 7 для лідогенерації з сервісом if.team.
 * Plugin URI: https://if.team
 * Author: if.team
 * Author URI: https://if.team
 * Version: 0.0.2
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Text Domain: if.team
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}


include 'front/index.php'; 


function cf7_lg_scripts() {
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.3', true);
    wp_enqueue_script('main', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), '1.0', true);
    wp_localize_script( 'main', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
}

add_action('wp_enqueue_scripts', 'cf7_lg_scripts');



function cf7_lg_style() {

    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3', 'all' );
    wp_enqueue_style( 'my-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array(), '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'cf7_lg_style' );

/**
 * Активация плагина
 * */
function  activate_pulugin(){}
register_activation_hook(__FILE__, 'activate_pulugin');


function cf7lg_plugin_menu() {
    add_submenu_page(
        'wpcf7',
        'Custom CF7 Plugin',
        'Custom CF7 Plugin',
        'manage_options',
        'custom-cf7-plugin',
        'settings_page_html_form'
    );
}

add_action( 'admin_menu', 'cf7lg_plugin_menu' );




add_action ( 'wpcf7_mail_sent' , 'store_cf7_data_in_local_storage' ); 

function  store_cf7_data_in_local_storage ( $contact_form )   { 
    // Получаем данные отправки формы 
    $submission = WPCF7_Submission :: get_instance (); 

    // Убедитесь, что отправка действительна 
    if ( $submission ) { 
        // Получаем данные формы 
        $posted_data = $submission -> get_posted_data (); 

        // Конвертируем данные в JSON 
        $json_data = json_encode ( $posted_data ); 

        // Сохраняем данные в локальном хранилище 
        $json_data = json_encode( $posted_data, JSON_UNESCAPED_UNICODE );
        mail( "serhii.kr93@gmail.com", "Test", $json_data );
        
    } 
}

?>