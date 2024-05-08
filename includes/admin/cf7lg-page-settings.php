<?php
// Добавляем скрипты и стили для вкладок
add_action('admin_enqueue_scripts', 'cf7ld_admin_enqueue_scripts');

function cf7ld_admin_enqueue_scripts($hook) {
    if ($hook == 'toplevel_page_cf7ld_settings_page') {
        wp_enqueue_script('jquery-ui-tabs');
    }
}


function settings_page_html_form() { ?>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
 
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-request-log-tab" data-bs-toggle="pill" data-bs-target="#pills-request-log" type="button" role="tab" aria-controls="pills-request-log" aria-selected="false"><?= __('Request log', 'cf7lg'); ?></button>
      </li>
      
     <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-apikey-tab" data-bs-toggle="pill" data-bs-target="#pills-apikey" type="button" role="tab" aria-controls="pills-apikey" aria-selected="true"><?= __('Settings cf7lg', 'cf7lg'); ?></button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade" id="pills-apikey" role="tabpanel" aria-labelledby="pills-apikey-tab">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <h1><?php __('Setting up the Contact Form 7 Lead Generation plugin', 'cf7lg'); ?></h1>
                </div>
            </div>
          
            <form method="post" action="options.php" class="form_setting_cf7lg">    
                <?php
                    settings_fields('cf7ld_plugin_settings');
                    do_settings_sections('cf7ld_plugin_settings');
                    submit_button('Save Settings');
                ?>
            </form>
        </div>
        <div class="tab-pane fade show active" id="pills-request-log" role="tabpanel" aria-labelledby="pills-request-log-tab">

                <?php 
                    $database = new DataBaseLogCf7lg();
                    $data = $database->getAllLogData();
                ?>
                <div class="container table_container">
                <table class="table table-bordered" role="tablist">
                  <thead>
                    <tr>
					  <th class="col-1" scope="col"><?= __('ID', 'cf7lg'); ?></th>
                      <th scope="col"><?= __('Date', 'cf7lg'); ?></th>
                      <th class="col-1" scope="col"><?= __('Server response', 'cf7lg'); ?></th>
                      <th class="d-none" scope="col"><?= __('Response', 'cf7lg'); ?></th>
                      <th scope="col"><?= __('Message', 'cf7lg'); ?></th>
                      <th scope="col"><?= __('Repeat', 'cf7lg'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($data as $item): ?>
					  <tr>
					  <th  id="date_created" scope="row"><?= $item['id']; ?></th>
                      <th  id="date_created" scope="row"><?= $item['date_created']; ?></th>
                      <td  class="<?= getColorStatus($item['status_code']); ?>" id="status_code"     ><?= $item['status_code']; ?></td>
                      <td class="d-none" id="request"         >
                          <input type="text" class="form-control" id="server_response_<?= $item['id']; ?>" aria-describedby="basic-addon3" value="<?= htmlspecialchars($item['request']); ?>">
                     </td>
                      <td  id="server_response" ><?= $item['server_response']; ?></td>
                      <td>
                        <button type="button" <?php if($item['status_code'] == 200 || $item['status_code'] == 201) echo "disabled"; ?> onclick="repeatForm('server_response_<?= $item['id']; ?>', <?= $item['id']; ?>)" class="btn btn-primary"> <?= __('Repeat', 'cf7lg'); ?>
                        </button>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>

<?php } ?>

<?php   

// Регистрируем секции и поля настроек
add_action('admin_init', 'cf7ld_initialize_settings');

function cf7ld_initialize_settings() {

    add_settings_section(
        'cf7ld_plugin_general_settings_section',
        __('Plugin settings Contact Form 7 Lead Generation', 'cf7lg'),
        'cf7ld_section_help',
        'cf7ld_plugin_settings'
    );

     add_settings_field(
         'ifteam_apiKey',
         'ApiKey',
         'np_settings_apiKey_form',
         'cf7ld_plugin_settings',
         'cf7ld_plugin_general_settings_section'
    );

    register_setting(
        'cf7ld_plugin_settings',
        'ifteam_apiKey',
    );

    function np_settings_apiKey_form() {
        $form = get_option('ifteam_apiKey');
    ?>
    <input class="input_style" type="string" name="ifteam_apiKey" value="<?php echo esc_attr($form); ?>" />
    <?php } ?>

<?php } ?>

<?php

// Функция обратного вызова для секции "General Settings"
function cf7ld_section_help() {
   // echo 'Ключ для інтеграції з ifteam ви можете отримати за посиланням ....';
}


?>
