<?php  

// Добавление раздела в редактор формы
function cf7lg_add_panel($panels) {
    $panels['custom-panel'] = array(
        'title' => 'Ліди',
        'callback' => 'cf7lg_panel_content'
    );
    return $panels;
}
add_filter('wpcf7_editor_panels', 'cf7lg_add_panel');

// Содержимое раздела
function cf7lg_panel_content($post) {
    ?>
	<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Вкажіть атрибути які будуть використані для лідогенерації</h3>
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Имя</span>
                  <input type="text" id="name_1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>    
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Имя поля 2</span>
                  <input type="text" id="name_2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>    
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Имя поля 3</span>
                  <input type="text" id="name_3" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>    
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Имя поля 4</span>
                  <input type="text" id="name_4" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>    
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Имя поля 5</span>
                  <input type="text" id="name_5" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>    
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Имя поля 5</span>
                  <input type="text" id="cf7lg_id" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                         value="<? echo $_GET['post']; ?>">
                </div>    
            </div>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary btn-lg">Зберегти</button>
        </div>
    </div>
    <?php
}

// Добавление поля в раздел
function cf7lg_add_field_to_panel($panels) {
    $panels['custom-panel'][] = array(
        'title' => 'Custom Field',
        'callback' => 'cf7lg_field_callback'
    );
    return $panels;
}
add_filter('wpcf7_editor_panel_custom-panel', 'cf7lg_add_field_to_panel');

// Обратный вызов для поля
function cf7lg_field_callback($args) {
    ?>
    
    <?php
}

?>