<?php 

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
function leadsParticipants_($page){
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
	$response = wp_remote_get( $BASE_URL."integrations/leads/participants", $args );
	
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

?>