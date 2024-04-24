<?php 


function settings_page_html_form() { ?>
    <div class="container">
        <!-- <div class="row">
            <div class="col-12 col-sm-12">
                <h1>Налаштування плагіна Contact Form 7 Lead Generation</h1>
            </div>
        </div> -->
      
        <form method="post" action="options.php">
            <?php
                settings_fields('cf7ld_plugin_settings');
                do_settings_sections('cf7ld_plugin_settings');
                submit_button('Save Settings');
            ?>
        </form>
    </div>

<?php } ?>

<?php   

// Регистрируем секции и поля настроек
add_action('admin_init', 'cf7ld_initialize_settings');

function cf7ld_initialize_settings() {

    add_settings_section(
        'cf7ld_plugin_general_settings_section',
        'Налаштування плагіна Contact Form 7 Lead Generation',
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
    <input type="string" name="ifteam_apiKey" value="<?php echo esc_attr($form); ?>" />
    <?php } ?>

<?php } ?>

<?php

// Функция обратного вызова для секции "General Settings"
function cf7ld_section_help() {
    echo 'Ключ для інтеграції з ifteam ви можете отримати за посиланням ....';
}

?>
