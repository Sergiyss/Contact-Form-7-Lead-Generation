<?php 

/**
* Вносим информацию по форме
*/
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


?>