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

include 'front/index.php';
include_once(plugin_dir_path(__FILE__) . '/includes/admin/new_tab_cf7lg.php');
include_once(plugin_dir_path(__FILE__) . '/includes/database/database-cf7lg.php');

//Локальные стили
if (isset($_GET['page']) && $_GET['page'] === 'wpcf7'):

    wp_enqueue_script('bootstrap_script', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('showdown_script', '//cdnjs.cloudflare.com/ajax/libs/showdown/1.8.6/showdown.min.js', array(), false);;
    wp_enqueue_script('bulma_script', '//unpkg.com/bulma-toast', array(), false);

    // Регистрация и подключение стилей
    wp_enqueue_style('bootstrap_style', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('bulma_style', '//cdnjs.cloudflare.com/ajax/libs/bulma/0.9.1/css/bulma.min.css', array(), false);
    wp_enqueue_style('animate_style', '//cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css', array(), false);
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




add_action ( 'wpcf7_mail_sent' , 'store_cf7_data_in_local_storage' ); 

function  store_cf7_data_in_local_storage ( $contact_form )   { 
    $form_id = $contact_form->id();
    
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
        
        get_form($form_id);
    } 
}










function update_wpcf7_form(){
    include_once(get_template_directory() . '/includes/database/database-cf7lg.php');

    $database = new DataBaseCf7lg();

    // Создаем ассоциативный массив для хранения данных
    $data = array();

    // Получаем данные из POST-запроса
    $data['params1'] = isset($_POST['params1']) ? $_POST['params1'] : null;
    $data['params2'] = isset($_POST['params2']) ? $_POST['params2'] : null;
    $data['params3'] = isset($_POST['params3']) ? $_POST['params3'] : null;
    $data['params4'] = isset($_POST['params4']) ? $_POST['params4'] : null;
    $data['params5'] = isset($_POST['params5']) ? $_POST['params5'] : null;
    $id_form_wpcf7 = isset($_POST['formId']) ? $_POST['formId'] : null;

    // Преобразуем массив в JSON
    $json_data = json_encode($data);

    //Вставляю данные в базу данных
    $insert_response = $database->insert_data_base(
        $id_form_wpcf7,
        $json_data,
    );
    $response = json_encode($insert_response);

    echo json_encode(array('status' => 'success', 'data' => $json_data));

    wp_die();
}

add_action('wp_ajax_update_wpcf7_form', 'update_wpcf7_form');
add_action('wp_ajax_nopriv_update_wpcf7_form', 'update_wpcf7_form'); 



function get_form($id_form){
    include_once(get_template_directory() . '/includes/database/database-cf7lg.php');
    $database = new DataBaseCf7lg();
    $result = $database->get_data_by_wpcf7_id($id_form);


    mail( "serhii.kr93@gmail.com", "Test".$id_form, "id_form ".$result['params1'].' par2 '.$result['params2'].' par3 '.$result['params3'] );
}



?>