<?php 

class DataBaseCf7lg{

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
	 * Вставка новых данных в базу данных
	 * 
	 * */
	function insert_data_base($id_form_wpcf7, $json_object){
		global $wpdb;
		
		$history_data = array(
			'wpcf7_id' => $id_form_wpcf7,
			'attribytes_cf7lg' => $json_object,
		);


		$table_name = $table_name = getNameTable($wpdb);

		$wpdb->insert($table_name, $history_data);
	}
}

?>