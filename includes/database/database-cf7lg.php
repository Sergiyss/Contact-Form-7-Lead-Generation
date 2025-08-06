<?php

class DataBaseCf7lg{
	//Основная таблица данных
	function getNameTable($wpdb){
		return $wpdb->prefix . 'database_cf7lg';
	}

	/**
	 * Создания базы данных для историю генерации накладных
	 * 
	 * vscode.dev ))
	 * */
	function createTable(){

		global $wpdb;

		$table_name = $this->getNameTable($wpdb);
		//Проверка на существование базы данных
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			// Определение структуры таблицы
			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				wpcf7_id TEXT NOT NULL,
				attribytes_cf7lg TEXT NOT NULL,
				PRIMARY KEY  (id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

			// Создание или обновление таблицы
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
	

	/**
	 * Удаление базы данных
	 * */
	function dropTable() {
		global $wpdb;
		$table_name = $this->getNameTable($wpdb);

		// Проверка на существование таблицы
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			// Удаление таблицы
			$wpdb->query("DROP TABLE IF EXISTS $table_name");
		}
	}
	/**
	 * Вставка новых данных в базу данных
	 * 
	 * */
	function insert_data_base($id_form_wpcf7, $json_object){
		global $wpdb;

		$table_name = $this->getNameTable($wpdb);

		// Проверяем, существует ли запись с данным wpcf7_id
		$existing_record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE wpcf7_id = %s", $id_form_wpcf7));
		
		$json_object_utf8 = utf8_encode($json_object);
		
		// Если запись существует, обновляем attribytes_cf7lg
		if ($existing_record) {
			$wpdb->update(
				$table_name,
				array('attribytes_cf7lg' => $json_object_utf8),
				array('wpcf7_id' => $id_form_wpcf7)
			);
		} else {
			// Если запись не существует, добавляем новую запись
			$history_data = array(
				'wpcf7_id' => $id_form_wpcf7,
				'attribytes_cf7lg' => $json_object_utf8,
			);
			$wpdb->insert($table_name, $history_data);
		}
	}
	
	
	function get_data_by_wpcf7_id($wpcf7_id){
		global $wpdb;

		$table_name = $this->getNameTable($wpdb);

		// Получаем данные из таблицы по заданному wpcf7_id
		$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE wpcf7_id = %s", $wpcf7_id), ARRAY_A);
		
		$data_array = json_decode($result["attribytes_cf7lg"], true);

		// Выводим данные
		return $data_array;
		
	}
}