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
    $data['responsible'] = isset($_POST['responsible']) ? $_POST['responsible'] : null;
    $data['observers'] = isset($_POST['observers']) ? $_POST['observers'] : null;
    $data['expected_budget'] = isset($_POST['expected_budget']) ? $_POST['expected_budget'] : null;
    $data['deal_currency'] = isset($_POST['deal_currency']) ? $_POST['deal_currency'] : null;
    $data['source'] = isset($_POST['source']) ? $_POST['source'] : null;
    $data['status'] = isset($_POST['status']) ? $_POST['status'] : null;
    $data['service'] = isset($_POST['service']) ? $_POST['service'] : null;
    $data['description_lead'] = isset($_POST['description_lead']) ? $_POST['description_lead'] : null;
    $data['file'] = isset($_POST['file']) ? $_POST['file'] : null;
    $data['name'] = isset($_POST['name']) ? stripslashes($_POST['name']) : null;
    $data['country'] = isset($_POST['country']) ? $_POST['country'] : null;
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : null;
    $data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : null;
    $data['description'] = isset($_POST['description']) ? $_POST['description'] : null;


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

$BASE_URL = "https://api.ifteam2.staj.bid/";

function leadsStatuses(){
	global $BASE_URL;
	$args = array(
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers' => array(
			'Content-Type' => 'application/json',
			'apikey' => 'a5f9b3c7-2e4d-11e8-b467-0ed5f89f718b',
		),
		'body'    => array(),
		'cookies' => array()
	);
	$response = wp_remote_get( $BASE_URL."integrations/leads/statuses", $args );
	echo $response;
}

add_action('wp_ajax_leadsStatuses', 'leadsStatuses');
add_action('wp_ajax_nopriv_leadsStatuses', 'leadsStatuses'); 
?>