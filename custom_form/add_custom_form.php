<?php
// Проверяем, была ли отправлена форма
if( isset( $_POST['discuss'] ) ) {

    $BASE_URL = "https://api.demo.if.team/";

    $arg = array();
    $client = array();

    // Получаем данные из формы
    $phone = sanitize_text_field( $_POST['phone'] );
    $email = sanitize_email( $_POST['email'] );
    $comment = sanitize_textarea_field( $_POST['comment'] );

    $client['phone'] = sanitize_text_field( $_POST['phone'] );
    $client['email'] = sanitize_text_field( $_POST['email'] );

   
    $args = array(
        'timeout'     => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers' => array(
            'Content-Type' => 'application/json',
            'apikey' => 'a5f9b3c7-2e4d-11e8-b467-0ed5f89f718b',
        ),
        'body'    =>  array(
            'client' => $client,
            'name' => "Форма обратной связи",
            'country_id' => 1,
            'description' => $comment,
        ),
        'cookies' => array()
    );
    $response = wp_remote_post( $BASE_URL."integrations/leads", $args);

    // Сохраняем данные в локальном хранилище 
    //$json_data = json_encode( $data_arr, JSON_UNESCAPED_UNICODE );


    $current_directory = __DIR__;

    // Путь к файлу, в который вы хотите записать данные
    $file_path = $current_directory . '/data_response.json';

    file_put_contents($file_path, $response);


    
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