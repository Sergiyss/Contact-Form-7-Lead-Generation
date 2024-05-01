<?php
/**
 * Plugin Name: Contact Form 7 Lead Generation by if.team
 * Description: Плагін з інтреграцією з Contact Form 7 для лідогенерації з сервісом if.team.
 * Plugin URI: https://if.team
 * Author: if.team
 * Author URI: https://if.team
 * Version: 0.0.3
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
    load_plugin_textdomain('cf7lg', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

// Add actions
add_action('init', 'ap_action_init');


include 'front/index.php';
include_once(plugin_dir_path(__FILE__) . '/includes/admin/Lead-Generation-Tab_cf7lg.php');
include_once(plugin_dir_path(__FILE__) . '/includes/database/database-cf7lg.php');

//Локальные стили
if (isset($_GET['page']) && $_GET['page'] === 'wpcf7'):

    wp_enqueue_script('bootstrap_script', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
 	wp_enqueue_script('bootstrap_select_script', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js');
    wp_enqueue_script('showdown_script', '//cdnjs.cloudflare.com/ajax/libs/showdown/1.8.6/showdown.min.js', array(), false);;
    wp_enqueue_script('bulma_script', '//unpkg.com/bulma-toast', array(), false);

    // Регистрация и подключение стилей
    wp_enqueue_style('bootstrap_style', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
  	wp_enqueue_style('bootstrap_select_style', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css');
    wp_enqueue_style('bulma_style',     '//cdnjs.cloudflare.com/ajax/libs/bulma/0.9.1/css/bulma.min.css', array(), false);
    wp_enqueue_style('animate_style',   '//cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css', array(), false);
    wp_enqueue_style('main_style',      plugin_dir_url(__FILE__). 'assets/css/style.css', array(), false);
endif;

if (isset($_GET['page']) && $_GET['page'] === 'wpcf7' && $_GET['active-tab'] === '4'):

?>

<style>
    .postbox-container p.submit input.button-primary {display: none !important;}
</style

<?php 

endif;

//Глобальные стили
wp_enqueue_script('main_script_cf7lg', plugin_dir_url( __FILE__ ) . '/assets/js/main.js', array('jquery'), '1.0', true);
wp_enqueue_script('insert_database', plugin_dir_url( __FILE__ ) . '/assets/js/insert_database.js', array('jquery'), '1.0', true);
wp_enqueue_script('utm_tags', plugin_dir_url( __FILE__ ) . '/assets/js/utm_tags.js', array('jquery'), '1.0', true);
wp_localize_script( 'js_aut', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));



/**
 * Активация плагина
 * */
function  activate_pulugin(){
    $database = new DataBaseCf7lg();

    $database->createTable();
}
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



	

//перехватчик контактной формы
include_once(plugin_dir_path(__FILE__) . '/includes/Callback-contact-form.php');


include_once(plugin_dir_path(__FILE__) . '/includes/admin/ajax-scripts/update_wpcf7_form.php');
include_once(plugin_dir_path(__FILE__) . '/includes/admin/functions.php');
include_once(plugin_dir_path(__FILE__) . '/includes/admin/Connects-wiht-ifteam.php');


?>