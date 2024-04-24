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
		 'ifteam_apiKey',
		 'ApiKey',
		 'np_settings_apiKey_form',
		 'my_plugin_settings',
		 'my_plugin_general_settings_section'
    );

	register_setting(
		'my_plugin_settings',
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
function my_plugin_general_settings_section_callback() {
    echo 'Ключ для інтеграції з ifteam ви можете отримати за посиланням ....';
}

?>
