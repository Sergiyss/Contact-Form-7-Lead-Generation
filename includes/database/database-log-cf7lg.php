<?php

class DataBaseLogCf7lg{
	//Для логов
	function getNameTableLog($wpdb){
		return $wpdb->prefix . 'database_log_cf7lg';
	}

	// Функция для создания таблицы данных
	function createTable(){
	    global $wpdb;

	    $table_name = $this->getNameTableLog($wpdb);

	    // Проверяем, существует ли таблица
	    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	        // Определяем структуру таблицы
	        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	            id mediumint(9) NOT NULL AUTO_INCREMENT,
	            status_code INT(3) NOT NULL,
	            date_created DATETIME NOT NULL,
	            request TEXT NOT NULL,
	            server_response TEXT NOT NULL,
	            PRIMARY KEY  (id)
	        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

	        // Создаем или обновляем таблицу
	        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	        dbDelta($sql);
	    }
	}

	// Функция для вставки данных в таблицу
	function insertData($status_code, $date_created, $request, $server_response) {
	    global $wpdb;
	    $table_name = $this->getNameTableLog($wpdb);

	    $wpdb->insert(
	        $table_name,
	        array(
	            'status_code' => $status_code,
	            'date_created' => $date_created,
	            'request' => $request,
	            'server_response' => $server_response
	        )
	    );

	    // Проверяем наличие ошибок при выполнении запроса
	    if ($wpdb->last_error) {
	        echo "Ошибка при вставке данных: " . $wpdb->last_error;
	    }
	}

    // Функция для получения всех данных из таблицы
    function getAllLogData() {
        global $wpdb;
        $table_name = $this->getNameTableLog($wpdb);

        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT 50", ARRAY_A);

        if ( empty($results) || !is_array($results) ) {
            return []; // безопасный возврат пустого массива
        }

        return $results;
    }

	function dropTable() {
		global $wpdb;
		$table_name = $this->getNameTableLog($wpdb);

		// Проверка на существование таблицы
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			// Удаление таблицы
			$wpdb->query("DROP TABLE IF EXISTS $table_name");
		}
	}

	// Функция для обновления данных в таблице по идентификатору
	function updateData($id, $status_code, $request, $server_response) {
	    global $wpdb;
	    $table_name = $this->getNameTableLog($wpdb);

	    // Данные для обновления
	    $data = array(
	        'status_code' => $status_code,
	        'request' => $request,
	        'server_response' => $server_response
	    );

	    // Условие для обновления по идентификатору
	    $where = array('id' => $id);

	    // Выполняем запрос на обновление данных
	    $result = $wpdb->update($table_name, $data, $where);
	}
}

?>