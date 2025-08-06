<?php
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
		
		// mail( "serhii.kr93@gmail.com", "Форма заявки ", $json_data ); //дебаг
        
        get_information_the_form_cf7lg($form_id, $json_data, $posted_data);
    } 
}