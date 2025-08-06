<?php
/**
* Вносим информацию по форме
*/
function repeat_request_form(){
   
    // Получаем данные из POST-запроса
    $data = isset($_POST['request']) ? $_POST['request'] : null;
    $id_table = isset($_POST['id']) ? $_POST['id'] : null;

    repeatCreateLeads($data, $id_table);

    echo json_encode(array('status' => 'success', 'data' => "cuccess"));

    wp_die();
}

add_action('wp_ajax_repeat_request_form', 'repeat_request_form');
add_action('wp_ajax_nopriv_repeat_request_form', 'repeat_request_form');