<?php  

include_once(WP_PLUGIN_DIR . '/Contact-Form-7-Lead-Generation/includes/database/database-cf7lg.php');


// Добавление раздела в редактор формы
function cf7lg_add_panel($panels) {
	$panels['custom-panel'] = array(
		'title' => __('Lead Generations', 'cf7lg'),
		'callback' => 'cf7lg_panel_content'
	);
	return $panels;
}
add_filter('wpcf7_editor_panels', 'cf7lg_add_panel');

// Содержимое раздела
function cf7lg_panel_content($post) {
	$database = new DataBaseCf7lg();
	$result = $database->get_data_by_wpcf7_id($_GET['post']);


    // Если данных нет, подставляем пустые значения
    if (!$result || !is_array($result)) {
        $result = [
            "title"            => "",
            "responsible_id"   => "",
            "participant_ids"  => "",
            "expected_budget"  => "",
            "currency_id"      => "",
            "source"           => "",
            "status"           => "",
            "services"         => "",
            "description_lead" => "",
            "file"             => "",
            "name"             => "",
            "country"          => "",
            "email"            => "",
            "phone"            => "",
            "description"      => "",
            "utm_tags_checked" => "",
            "utm_source"       => "",
            "utm_medium"       => "",
            "utm_campaign"     => "",
            "utm_term"         => "",
            "utm_content"      => ""
        ];
    }
?>

<!-- Запрашиваю данные с ifteam -->
<?php
	//Показываю если у пользователя есть ключ
	if(!empty(get_option('ifteam_apiKey'))){
		$participants = leadsParticipants_(1);
		$statuses = leadsStatuses_(1);
		$services = leadsServices();
		$currencies = leadsСurrencies();
		$countries = leadsListCountries(1);
	}
?>
<div class="container leads_form">
	<?php if(!empty($currencies['statusCode']) && $currencies['statusCode'] !== 200): ?>
		<p class="bd-callout bd-callout-danger"><?= $currencies['message']; ?></p>
	<?php endif; ?>
	
	<?php if(empty(get_option('ifteam_apiKey'))): ?>
	<div class="card border-warning mb-12" style="max-width: 38rem;">
		<div class="card-header"><?= __('ApiKey not found', 'cf7lg'); ?></div>
		<div class="card-body">
			<h5 class="card-title"><?= __('Please enter your apiKey', 'cf7lg'); ?></h5>
			<p class="card-text"><?= __('To use the plugin, you need to insert an ApiKey in the plugin settings, and if you don\'t have a key, you need to obtain it.', 'cf7lg'); ?></p>
		</div>
		<div class="card-body">
			<a href="/wp-admin/admin.php?page=cf7lg-plugin" class="btn btn-primary"><?= __('Add ApiKey', 'cf7lg'); ?></a>
			<a href="https://if.team" class="btn btn-primary" target="_blank"><?= __('Get ApiKey', 'cf7lg'); ?></a>
		</div>
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-lg-12">
			<h3 class="title_cf7lg">
				<?= __('Specify the attributes that will be used for lead generation.', 'cf7lg'); ?>
			</h3>
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo  __('Title', 'cf7lg'); ?> <span class="required"> * </span></span>
				<input type="text" id="title_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["title"]; ?>" aria-invalid="true">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<label class="input-group-text" id="inputGroup-sizing-default" for="responsible_cf7lg"><?php echo __('Responsible', 'cf7lg'); ?></label>
				<select class="form-select" id="responsible_cf7lg">
					<?php foreach($participants as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["responsible_id"])) echo "selected"; ?>><?php echo $item['name']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>      
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Observers', 'cf7lg'); ?></span>
				<select id="observers_cf7lg" class="selectpicker" multiple aria-label="One" data-live-search="true">
					<?php
						// Ваши данные из базы данных, например:
						$selected_values = array_map('intval', explode(', ',  $result["participant_ids"]));

						foreach ($participants as $option) {
							$selected = in_array($option['id'], $selected_values) ? 'selected' : '';
							echo '<option value="' . $option['id'] . '" ' . $selected . '>' . $option['name'] . '</option>';
						}
					?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
				<p class="bd-callout bd-callout-info">
					<?= __('The form <strong>Expected budget (amount)</strong> supports numeric input. You can also utilize a form template using the name <strong>amount-product</strong> in the form template. [amount-product]', 'cf7lg'); ?>
				</p>
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Expected budget (amount)', 'cf7lg'); ?></span>
				<input type="text" id="expected_budget_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["expected_budget"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">		
				<label class="input-group-text" id="inputGroup-sizing-default" for="deal_currency_cf7lg"><?php echo __('Deal currency', 'cf7lg'); ?> <span class="required"> * </span> </label>
				<select class="form-select" id="deal_currency_cf7lg">
					<?php foreach($currencies['data'] as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["currency_id"])) echo "selected"; ?>><?php echo $item['code']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Source', 'cf7lg'); ?></span>
				<input type="text" id="source_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["source"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<label class="input-group-text" id="inputGroup-sizing-default" for="status_cf7lg"><?php echo __('Status', 'cf7lg'); ?></label>
				<select class="form-select" id="status_cf7lg">
					<?php foreach($statuses['data'] as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["status"])) echo "selected"; ?>><?php echo $item['name']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Service', 'cf7lg'); ?></span>
				<select id="service_cf7lg" class="selectpicker" multiple aria-label="One" data-live-search="true">
					<?php
						// Ваши данные из базы данных, например:
						$selected_values = array_map('intval', explode(', ',  $result["services"]));

						foreach ($services['data'] as $option) {
							$selected = in_array($option['id'], $selected_values) ? 'selected' : '';
							echo '<option value="' . $option['id'] . '" ' . $selected . '>' . $option['name'] . '</option>';
						}
					?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Description', 'cf7lg'); ?></span>
				<input type="text" id="description_lead_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["description_lead"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('File', 'cf7lg'); ?></span>
				<input type="text" id="file_cf7lg" class="form-control" aria-label="Sizing example input" disabled aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["file"];?>" >
			</div>    
		</div>
		<div class="col-lg-12 d-none">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?= __('ID WPCF7 Form', 'cf7lg'); ?></span>
				<input type="text" id="cf7lg_id" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?= $_GET['post']; ?>">
			</div>    
		</div>

	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3 class="title_cf7lg">
				<?= __('Specify the attributes that will be used to create a client.', 'cf7lg'); ?>
			</h3>

		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Full Name', 'cf7lg'); ?> <span class="required"> * </span> </span>
				<input type="text" id="name_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["name"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">

				<label class="input-group-text" id="inputGroup-sizing-default" for="country_cf7lg"><?php echo __('Country', 'cf7lg'); ?></label>
				<select class="form-select" id="country_cf7lg">
					<?php foreach($countries as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["country"])) echo "selected"; ?>><?php echo $item['name']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('E-mail', 'cf7lg'); ?></span>
				<input type="text" id="email_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["email"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Phone', 'cf7lg'); ?></span>
				<input type="text" id="phone_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["phone"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Description', 'cf7lg'); ?></span>
				<input type="text" id="description_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["description"]; ?>">
			</div>    
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3 class="title_cf7lg">
				<?= __('UTM tag settings', 'cf7lg'); ?>
			</h3>
		</div>

		<div class="bd-callout bd-callout-info">
			<strong><?php echo esc_html(__('UTM tags can be used in two ways:', 'cf7lg')); ?></strong>
			<ul>
			    <li><strong>1.</strong> <?php echo esc_html(__('Use automatic insertion, which only works after navigating from a source that passes UTM tags in the GET parameters, then saves them in cookies.', 'cf7lg')); ?></li>
			    <li><strong>2.</strong> <?php echo esc_html(__('Use the manual option. You need to activate the checkbox and insert your template.', 'cf7lg')); ?></li>
			</ul>
		</div>

		<div class="col-lg-12 settings_utms_tag">
			<input class="form-check-input" type="checkbox" value="" id="utm_active_custom_tags_cf7lg" <?php if($result["utm_tags_checked"] === 'true') echo "checked"; ?>>
			<label class="form-check-label" for="utm_active_custom_tags_cf7lg">
				<?= __('Use customizable UTM tags', 'cf7lg'); ?>
			</label>
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('utm source', 'cf7lg'); ?></span>
				<input type="text" id="utm_source_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["utm_source"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('utm medium', 'cf7lg'); ?></span>
				<input type="text" id="utm_medium_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["utm_medium"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('utm campaign', 'cf7lg'); ?></span>
				<input type="text" id="utm_campaign_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["utm_campaign"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('utm term', 'cf7lg'); ?></span>
				<input type="text" id="utm_term_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["utm_term"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('utm content', 'cf7lg'); ?></span>
				<input type="text" id="utm_content_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["utm_content"]; ?>">
			</div>    
		</div>
	</div>

	<div class="col-lg-2 save_form">
		<button type='button' onclick="insetDataBase()" class="btn btn-primary btn-lg">
			<?= __('Save', 'cf7lg'); ?>
		</button>
	</div>
</div>
<?php } ?>

    <script>
        window.addEventListener("load", function() {
            isActiveUtmInputs();
        });
    </script>

<?php

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
function cf7lg_field_callback($args) {  } ?>