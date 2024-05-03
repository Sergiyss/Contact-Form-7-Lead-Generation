<?php 
//автоподгрузка данных для списка участников, если их больше чем 50 на страницу


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


//Отправляю данные на сервер для создания лида.
function createLeads($data){
	global $BASE_URL;
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
	return $response = wp_remote_post( $BASE_URL."integrations/leads", $args);
	
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

//Получение списка стран
function leadsListCountries(){
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
		'body'    => array("lang" => getLocale(), 'limit'=> 50),
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

		return $data;
	}
	
	return $response;
}
//Потому что 2 языка
function getLocale(){
	$locale = explode('_', get_locale())[0];
	if($locale != 'uk'){
		return 'en';
	}else{
		return $locale;
	}
}

?>