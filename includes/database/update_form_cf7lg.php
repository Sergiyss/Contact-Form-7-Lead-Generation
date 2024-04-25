<?php

include_once(get_template_directory() . '/includes/database/database-cf7lg.php');


// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$database = new DataBaseCf7lg();

    // Создаем ассоциативный массив для хранения данных
    $data = array();

    // Получаем данные из POST-запроса
    $data['name_1'] = isset($_POST['name_1']) ? $_POST['name_1'] : null;
    $data['name_2'] = isset($_POST['name_2']) ? $_POST['name_2'] : null;
    $data['name_3'] = isset($_POST['name_3']) ? $_POST['name_3'] : null;
    $data['name_4'] = isset($_POST['name_4']) ? $_POST['name_4'] : null;
    $data['name_5'] = isset($_POST['name_5']) ? $_POST['name_5'] : null;
    $id_form_wpcf7 = isset($_POST['cf7lg_id']) ? $_POST['cf7lg_id'] : null;

    // Преобразуем массив в JSON
    $json_data = json_encode($data);

    //Вставляю данные в базу данных
    $database->insert_data_base(
    	$id_form_wpcf7,
    	$json_data,
    );
}
?>