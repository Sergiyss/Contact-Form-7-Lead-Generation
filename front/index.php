<?php 

function settings_page_html_form() { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12">
                <h1>Налаштування плагіна Contact Form 7 Lead Generation</h1>
            </div>
        </div>
      
        <form method="post" action="options.php">
            <?php
                settings_fields('my_plugin_settings');
                do_settings_sections('my_plugin_settings');
                submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php } ?>

<?php   

// Регистрируем секции и поля настроек
add_action('admin_init', 'my_plugin_initialize_settings');

function my_plugin_initialize_settings() {

        add_settings_section(
            'my_plugin_general_settings_section',
            'Настройка отправителя',
            'my_plugin_general_settings_section_callback',
            'my_plugin_settings'
        );

        add_settings_field(
            'np_settings_apiKey',
            'ApiKey',
            'np_settings_apiKey_form',
            'my_plugin_settings',
            'my_plugin_general_settings_section'
        );
        
        register_setting(
            'my_plugin_settings',
            'np_settings_apiKey',
        );

        function np_settings_apiKey_form() {
            $form = get_option('np_settings_apiKey');
            ?>
            <input type="string" name="ifteam_apiKey" value="<?php echo esc_attr($form); ?>" />
        <?php } ?>

<?php } ?>
