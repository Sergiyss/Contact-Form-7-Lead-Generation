<?php 
/**
* Получаю информацию по форме cf7lg
* @param $id_form - это id wpcf7 контактной формы 
*/
function get_information_the_form_cf7lg($id_form){
    include_once(get_template_directory() . '/includes/database/database-cf7lg.php');
    $database = new DataBaseCf7lg();
    $result = $database->get_data_by_wpcf7_id($id_form);

    /**
     * Отправляю данные
     * */
    mail( "serhii.kr93@gmail.com", "Test".$id_form, "id_form ".$result['params1'].' par2 '.$result['params2'].' par3 '.$result['params3'] );
}

?>