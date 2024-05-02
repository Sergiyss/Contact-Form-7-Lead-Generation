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
      
		//Если форма не пустая
        if (!empty($value)) {
			switch ($key) {
				case "title":
					$data_array['name'] = replaceString($value, $data_form);
					break;
				case "participant_ids":
					$data_array[$key] = array_map('intval', explode(', ',  $value));
					break;
				case "expected_budget":
					$data_array["amount"] = round(floatval($value), 2);
					break;
				case "responsible_id":
				case "currency_id":
					$data_array[$key] =$value;
					break;
				case "services":
					$data_array["service_ids"] = array_map('intval', explode(', ',  $value));;
					break;
				case "status":
					$data_array["status_id"] = intval($value);
					break;
				case "description_lead":
					$data_array["description"] = replaceString($value, $data_form);
				case "description":
					$client["comment"] = replaceString($value, $data_form);
				case "name":
				case "country":
				case "email":
				case "client":
					$client[$key] = replaceString($value, $data_form);
					break;
				case "phone":	
					$client[$key] = formatPhoneNumber(replaceString($value, $data_form));
					break;
				case "utm_source":
				case "utm_medium":
				case "utm_campaign":
				case "utm_term":
				case "utm_content":
					if ($data['utm_tags_checked'] === "true") {
						$data_array[$key] = replaceString($value, $data_form);
					}
					break;
				case "utm_tags_checked":
				case "file":
					// Пропускаем
					break;
				default:
					$data_array[$key] = replaceString($value, $data_form);
					break;
        	}
        }else{
			//для utm меток. Если utm_active_custom_tags === 0 то я использую
			//те метки, которые были сохранены в куки браузера
			if($data['utm_tags_checked'] === "false"){
				if(!empty($data_form['utm_source_cf7lg'])){
					$data_array['utm_source'] = $data_form['utm_source_cf7lg'];
				}
				if(!empty($data_form['utm_medium_cf7lg'])){
					$data_array['utm_medium'] = $data_form['utm_medium_cf7lg'];
				}
				if(!empty($data_form['utm_campaign_cf7lg'])){
					$data_array['utm_campaign'] = $data_form['utm_campaign_cf7lg'];
				}
				if(!empty($data_form['utm_term_cf7lg'])){
					$data_array['utm_term'] = $data_form['utm_term_cf7lg'];
				}
				if(!empty($data_form['utm_content_cf7lg'])){
					$data_array['utm_content'] = $data_form['utm_content_cf7lg'];
				}
			} 
		}
    }

	if(!empty($client)){
		$data_array['client'] = $client;
	}
	
	$data_array['date'] = date("Y-m-d");
	
	//$data_array[" <<  data_form"] = $data_form;
	$data_array[" <<  data_form"] =  createLeads(json_encode( $data_array, JSON_UNESCAPED_UNICODE ));
    $str = json_encode( $data_array, JSON_UNESCAPED_UNICODE );
	

	
    /**
     * Отправляю данные
     * */
    mail( "serhii.kr93@gmail.com", "Форма заявки ", $str );
    
}

/**
 * Замена в строке, если в форме есть ключи который совпадают с теми что пришли с базы данных.
 * 
 * Например. Пользваотель захотел описать форму как коструктор "Ім'я [your-name]", то [your-name]
 * нужно заменить на ключ из $data_form
 * */
function replaceString($value_original, $data_form){
	$marge = $value_original;
	foreach ($data_form as $key_form => $replacement) {
		$marge = str_replace("[$key_form]", $replacement, $marge);
	}
	return $marge;
}

/**
 * Функция замены номера, если номер попал в формате +38066... или 066. То нужно привести к одному формату
 * 066... потом добавляю +38
 * */
function formatPhoneNumber($phoneNumber) {
    // Удаление всех символов, кроме цифр
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
    // Проверка наличия кода страны
    if (strlen($phoneNumber) == 10) {
        // Добавление кода страны
        $phoneNumber = '38' . $phoneNumber;
    } elseif (strlen($phoneNumber) == 9) {
        // Добавление кода страны и "+" в начало
        $phoneNumber = '38' . $phoneNumber;
    }
    // Добавление "+" в начало номера
    $phoneNumber = '+' . $phoneNumber;
    return $phoneNumber;
}


?>
