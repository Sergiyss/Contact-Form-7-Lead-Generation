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
    $data['title'] = isset($_POST['title']) ? $_POST['title'] : null;
    $data['responsible_id'] = isset($_POST['responsible']) ? intval($_POST['responsible']) : null;
    $data['participant_ids'] = isset($_POST['observers']) ? $_POST['observers'] : null;
    $data['expected_budget'] = isset($_POST['expected_budget']) ? intval($_POST['expected_budget']) : null;
    $data['currency_id'] = isset($_POST['deal_currency']) ? intval($_POST['deal_currency']) : null;
    $data['source'] = isset($_POST['source']) ? $_POST['source'] : null;
    $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : null;
    $data['service'] = isset($_POST['service']) ? $_POST['service'] : null;
    $data['description_lead'] = isset($_POST['description_lead']) ? $_POST['description_lead'] : null;
    $data['file'] = isset($_POST['file']) ? $_POST['file'] : null;
    $data['name'] = isset($_POST['name']) ? stripslashes($_POST['name']) : null;
    $data['country'] = isset($_POST['country']) ? $_POST['country'] : null;
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : null;
    $data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : null;
    $data['description'] = isset($_POST['description']) ? $_POST['description'] : null;
	
	$data['utm_tags_checked']  = isset($_POST['utm_tags_checked']) ? $_POST['utm_tags_checked'] : null;
	
	$data['utm_source'] = isset($_POST['utm_source']) ? $_POST['utm_source'] : '';
	$data['utm_medium'] = isset($_POST['utm_medium']) ? $_POST['utm_medium'] : '';
	$data['utm_campaign'] = isset($_POST['utm_campaign']) ? $_POST['utm_campaign'] : '';
	$data['utm_term'] = isset($_POST['utm_term']) ? $_POST['utm_term'] : '';
	$data['utm_content'] = isset($_POST['utm_content']) ? $_POST['utm_content'] : '';


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