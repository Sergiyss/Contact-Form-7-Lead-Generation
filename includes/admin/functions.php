<?php 
/**
* Получаю информацию по форме cf7lg
* @param $id_form - это id wpcf7 контактной формы 
*/
function get_information_the_form_cf7lg($id_form, $json_data, $data_form){
    $pattern = "/\[(.*?)\]/";
    
    include_once(get_template_directory() . '/includes/database/database-cf7lg.php');
    
    $database = new DataBaseCf7lg();
    $data = $database->get_data_by_wpcf7_id($id_form);
    
    $data_array = array();
	$client = array();
	
    //Список форм которые заполнил клиент в плагине 
    foreach ($data as $key => $value) {
        $marge = $value;
        //Если форма не пустая
        if (!empty($value)) {
			
            if($key === "observers" ){
				$data_array[$key] = explode(', ', $value);
			}else if($key === "name" || $key === "country" || $key === "email" || $key === "phone" || $key === "client"){
				$client[$key] = $value;
			}else{
				foreach ($data_form as $key_form => $replacement) {
					$marge = str_replace("[$key_form]", $replacement, $marge);
				}
				
				if(!empty($client)){
					$data_array['client'] = $client;
				}
				$data_array[$key] = $marge;
			}
        }
    }

    $str = json_encode( $data_array, JSON_UNESCAPED_UNICODE );
    /**
     * Отправляю данные
     * */
    mail( "serhii.kr93@gmail.com", "Форма заявки ", $str );
    
}
	
?>
