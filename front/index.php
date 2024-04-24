<?php 


function custom_page_html_form() { ?>
	<div class="container">
        <div class="row">

            <div class="col-12 col-sm-12">
                <h2>Налаштування плагіна Contact Form 7 Lead Generation</h2>
            </div>


            <div class="col-12 col-sm-12">
                <form method="post" action="options.php">
                    <?php settings_fields('custom_plugin_options_group'); ?>
         
                    <table class="form-table">
                        <tr>
                            <th><label for="first_field_id">Введіть ключ:</label></th>
                            <td>
                                <input type = 'text' class="regular-text" id="first_field_id" name="key_ifteam" value="<?php echo get_option('key_ifteam'); ?>">
                            </td>
                        </tr>
                    </table>
                </form>
            <?php submit_button(); ?>
            </div>
        </div>
    </div>
<?php } ?>

