<?php
/**
 * Plugin Name: Contact Form 7 Lead Generation by if.team
 * Description: Плагін з інтреграцією з Contact Form 7 для лідогенерації з сервісом if.team.
 * Plugin URI: https://if.team
 * Author: if.team
 * Author URI: https://if.team
 * Version: 0.0.9
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Text Domain: if.team
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

function ap_action_init(){
// Локализация
    load_plugin_textdomain( 'cf7lg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	wp_enqueue_script('pw-script', plugin_dir_url( __FILE__ ) . '/assets/js/translations_cf7lg.js', array(), false);
	wp_localize_script('pw-script', 'cf7lgTranslate', array(
			'success' => __('Data saved successfully', 'cf7lg'),
			'error' => __('Failed to send data', 'cf7lg'),
			'failed' => __('Request failed', 'cf7lg'),
			'error_input_amount' => __('Please use numbers or the [amount-product] template.', 'cf7lg'),
	), false);	
}

// Add actions
add_action('init', 'ap_action_init');

include_once(plugin_dir_path(__FILE__) . '/includes/admin/cf7lg-page-settings.php');

if (isset($_GET['page']) && $_GET['page'] !== 'wpcf7-new'){
	include_once(plugin_dir_path(__FILE__) . '/includes/admin/Lead-Generation-Tab_cf7lg.php');
}
include_once(plugin_dir_path(__FILE__) . '/includes/database/database-log-cf7lg.php'); //база данных для логов
include_once(plugin_dir_path(__FILE__) . '/includes/database/database-cf7lg.php');
//Локальные стили
if ((isset($_GET['page']) && $_GET['page'] === 'wpcf7') || (isset($_GET['page']) &&  $_GET['page'] === 'cf7lg-plugin')) :
    wp_enqueue_script('bootstrap_script', '//cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js', array('jquery'), false);
    wp_enqueue_script('bootstrap_select_script', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js', array('jquery'));
    wp_enqueue_script('showdown_script', '//cdnjs.cloudflare.com/ajax/libs/showdown/1.8.6/showdown.min.js', array('jquery'), false);
    wp_enqueue_script('bulma_script', '//unpkg.com/bulma-toast', array('jquery'), false);
    // Регистрация и подключение стилей
    wp_enqueue_style('bootstrap_style', '//cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap_select_style', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css');
    wp_enqueue_style('bulma_style',     '//cdnjs.cloudflare.com/ajax/libs/bulma/0.9.1/css/bulma.min.css', array(), false);
    wp_enqueue_style('animate_style',   '//cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css', array(), false);
    wp_enqueue_style('main_style',      plugin_dir_url(__FILE__). 'assets/css/style.css', array(), false);
endif;
if (isset($_GET['page']) && $_GET['page'] === 'cf7lg-plugin'):
    wp_enqueue_style('main_style',      plugin_dir_url(__FILE__). 'assets/css/style.css', array(), false);
endif;
//Глобальные стили
wp_enqueue_script('main_script_cf7lg', plugin_dir_url( __FILE__ ) . '/assets/js/main.js', array('jquery'), '1.0', true);
wp_enqueue_script('insert_database', plugin_dir_url( __FILE__ ) . '/assets/js/insert_database.js', array('jquery'), '1.0', true);
wp_enqueue_script('utm_tags', plugin_dir_url( __FILE__ ) . '/assets/js/utm_tags.js', array('jquery'), '1.0', true);
wp_enqueue_script('repeat_request', plugin_dir_url( __FILE__ ) . '/assets/js/repeat_request.js', array('jquery'), '1.0', true);
wp_localize_script( 'js_aut', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
/**
 * Активация плагина
 * */
function  activate_pulugin(){
    $database    = new DataBaseCf7lg();
    // $database->dropTable();
    $database->createTable();
    
    $databaseLog = new DataBaseLogCf7lg();
	// $databaseLog->dropTable();
    $databaseLog->createTable();
}
register_activation_hook(__FILE__, 'activate_pulugin');

function cf7lg_plugin_menu() {
    add_submenu_page(
        'wpcf7',
        'CF7 Lead Generation',
        'CF7 Lead Generation',
        'manage_options',
        'cf7lg-plugin',
        'settings_page_html_form'
    );
}

add_action( 'admin_menu', 'cf7lg_plugin_menu' );
//перехватчик контактной формы
include_once(plugin_dir_path(__FILE__) . '/includes/Callback-contact-form.php');

include_once(plugin_dir_path(__FILE__) . '/includes/admin/ajax-scripts/update_wpcf7_form.php');
include_once(plugin_dir_path(__FILE__) . '/includes/admin/ajax-scripts/repeat_request.php');
include_once(plugin_dir_path(__FILE__) . '/includes/admin/functions.php');
include_once(plugin_dir_path(__FILE__) . '/includes/admin/Connects-wiht-ifteam.php');
?>
