<?php 
//автоподгрузка данных для списка участников, если их больше чем 50 на страницу


// $BASE_URL = "https://api.demo.if.team/";

$BASE_URL = "https://api.ifteam2.staj.bid/";

//Получение статусов
function leadsStatuses_($page){
	global $BASE_URL;
	$args = array(
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers' => array(
			'Content-Type' => 'application/json',
			'apikey' => get_option('ifteam_apiKey'),
		),
		'body'    => array("page" => $page),
		'cookies' => array()
	);
	$response = wp_remote_get( $BASE_URL."integrations/leads/statuses", $args );
	
	// проверим правильный ли получили ответ
	if ( is_wp_error( $response ) ){
		echo $response->get_error_message();
	}
	elseif( wp_remote_retrieve_response_code( $response ) === 200 ){
		// Все OK, делаем что нибудь с данными $request['body']
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		return $data;
	}
}

//Список участников
function leadsParticipants_($page) {
    global $BASE_URL;
	
    // Переменная для хранения всех участников
    $allParticipants = array();

    do {
        $args = array(
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(
                'Content-Type' => 'application/json',
                'apikey'       => get_option('ifteam_apiKey'),
            ),
            'body'        => array("page" => $page, "limit" => 50),
            'cookies'     => array()
        );

        $response = wp_remote_get($BASE_URL . "integrations/leads/participants", $args);

        // Проверяем успешность запроса
        if (is_wp_error($response)) {
            echo $response->get_error_message();
        } elseif (wp_remote_retrieve_response_code($response) === 200) {
            // Все OK, делаем что-нибудь с данными $request['body']
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            // Добавляем текущих участников к общему массиву
            $allParticipants = array_merge($allParticipants, $data['data']);

            // Переходим на следующую страницу, если есть
            $page++;

        } else {
            // Если получен неуспешный статус, завершаем цикл
            break;
        }

    } while ($data['nextPage']);

    // Возвращаем все собранные участники
    return $allParticipants;
}	

//Список сервисов
function leadsServices(){
	global $BASE_URL;
	$args = array(
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers' => array(
			'Content-Type' => 'application/json',
			'apikey' => get_option('ifteam_apiKey'),
		),
		'body'    => array("page" => $page),
		'cookies' => array()
	);
	$response = wp_remote_get( $BASE_URL."integrations/leads/services", $args );
	
	// проверим правильный ли получили ответ
	if ( is_wp_error( $response ) ){
		echo $response->get_error_message();
	}
	elseif( wp_remote_retrieve_response_code( $response ) === 200 ){
		// Все OK, делаем что нибудь с данными $request['body']
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		return $data;
	}
}

//Список валют
function leadsСurrencies(){
	global $BASE_URL;
	$args = array(
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers' => array(
			'Content-Type' => 'application/json',
			'apikey' => get_option('ifteam_apiKey'),
		),
		'body'    => array("page" => $page),
		'cookies' => array()
	);
	$response = wp_remote_get( $BASE_URL."integrations/leads/currencies", $args );
	//var_dump($response);
	// проверим правильный ли получили ответ
	if ( is_wp_error( $response ) ){
		echo $response->get_error_message();
	}
	elseif( wp_remote_retrieve_response_code( $response ) === 200 ){
		// Все OK, делаем что нибудь с данными $request['body']
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		return $data;
	}elseif( wp_remote_retrieve_response_code( $response ) !== 200){
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		return $data;
	}
}


//Отправляю данные на сервер для создания лида.
function createLeads($data){
	global $BASE_URL;
	/**
	 * Подключаю базу данных для логов
	 * */
	$database = new DataBaseLogCf7lg();

	$args = array(
		'timeout'     => 5,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers' => array(
			'Content-Type' => 'application/json',
			'apikey' => get_option('ifteam_apiKey'),
		),
		'body'    => $data,
	);

	//$response = wp_remote_post( $BASE_URL."integrations/leads", $args);
	$response = wp_remote_get( $BASE_URL."error", $args);
	$code = wp_remote_retrieve_response_code( $response );
	// Получаем тело ответа
	$response = wp_remote_retrieve_response_message($response);


	

	$insert_result = $database->insertData($code, date('d-m-Y H:m'), $data, $response);


	return $response;
	
	// // проверим правильный ли получили ответ
	// if ( is_wp_error( $response ) ){
	// 	echo $response->get_error_message();
	// }
	// elseif( wp_remote_retrieve_response_code( $response ) === 200 ){
	// 	// Все OK, делаем что нибудь с данными $request['body']
	// 	$body = wp_remote_retrieve_body( $response );
	// 	$data = json_decode( $body, true );

	// 	return $data;
	// }
}

//Повторная отправка данных на сервер
function repeatCreateLeads($data, $id){
	global $BASE_URL;
	/**
	 * Подключаю базу данных для логов
	 * */
	$database = new DataBaseLogCf7lg();
 	$data_array = array();
	
	$args = array(
		'timeout'     => 5,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers' => array(
			'Content-Type' => 'application/json',
			'apikey' => get_option('ifteam_apiKey'),
		),
		'body'    => removeslashes($data),
	);

 	
	$response = wp_remote_post( $BASE_URL."integrations/leads", $args);
	$code = wp_remote_retrieve_response_code( $response );
	// Получаем тело ответа
	$response = wp_remote_retrieve_response_message($response);

	$database->updateData($id, $code, $data, $response);
}

// Функция для удаления обратных слешей только из значений
function removeslashes($string)
{
    $string =   stripslashes(trim($string));
    $string = urldecode(implode("", explode("\\", $string)));
    return urldecode(stripslashes(trim($string)));
}


//Получение списка стран
function leadsListCountries($page){
    global $BASE_URL;
    // Переменная для хранения всех участников
    $allCountries = array();

    // Получаем общее количество элементов
    $totalItems = 249; 
    $itemsPerPage = 50;
    

    do {
        $args = array(
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers' => array(
                'Content-Type' => 'application/json',
                'apikey' => get_option('ifteam_apiKey'),
            ),
            'body'    => array("lang" => getLocale(), 'page' => $page, 'limit'=> $itemsPerPage),
            'cookies' => array()
        );

        $response = wp_remote_get( $BASE_URL."integrations/leads/countries", $args );

        // проверим правильный ли получили ответ
        if ( is_wp_error( $response ) ){
            echo $response->get_error_message();
        }
        elseif( wp_remote_retrieve_response_code( $response ) === 200 ){
            // Все OK, делаем что нибудь с данными $request['body']
            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );
			
			$totalItems = $data['total'];
			$totalPages = ceil($totalItems / $itemsPerPage);
			
            // Добавляем текущих участников к общему массиву
            $allCountries = array_merge($allCountries, $data['data']);

            // Переходим на следующую страницу, если есть
            $page++;

        } else {
            // Если получен неуспешный статус, завершаем цикл
            break;
        }

    } while ($page <= $totalPages); // Перебираем страницы до тех пор, пока не достигнем общего количества страниц
    return $allCountries;
}


//Потому что 2 языка
function getLocale(){
	$locale = explode('_', get_locale())[0];
	if($locale != 'uk'){
		if($locale == 'ru'){
			return 'uk';
		}
		return 'en';
	}else{
		return $locale;
	}
}

?>