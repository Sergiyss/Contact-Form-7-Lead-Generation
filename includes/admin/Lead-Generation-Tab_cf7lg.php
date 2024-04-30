<?php  

include_once(WP_PLUGIN_DIR . '/Contact-Form-7-Lead-Generation/includes/database/database-cf7lg.php');


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
	$database = new DataBaseCf7lg();
	$result = $database->get_data_by_wpcf7_id($_GET['post']);
?>

<!-- Запрашиваю данные с ifteam -->
<?php
	$participants = leadsParticipants_(1);
	$statuses = leadsStatuses_(1);
	$services = leadsServices();
	$currencies = leadsСurrencies();
?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h3>
				<?= __('Specify the attributes that will be used for lead generation.', "cf7lg"); ?>
			</h3>
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo  __('Title', "cf7lg"); ?></span>
				<input type="text" id="title_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["title"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<label class="input-group-text" id="inputGroup-sizing-default" for="responsible_cf7lg"><?php echo __('Responsible', "cf7lg"); ?></label>
				<select class="form-select" id="responsible_cf7lg">
					<?php foreach($participants['data'] as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["responsible"])) echo "selected"; ?>><?php echo $item['name']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>      
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Observers', "cf7lg"); ?></span>
				<select id="observers_cf7lg" class="selectpicker" multiple aria-label="One" data-live-search="true">
					<?php
						// Ваши данные из базы данных, например:
						$selected_values = explode(', ', $result["observers"]);

						foreach ($participants['data'] as $option) {
							$selected = in_array($option['id'], $selected_values) ? 'selected' : '';
							echo '<option value="' . $option['id'] . '" ' . $selected . '>' . $option['name'] . '</option>';
						}
					?>
				</select>

			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Expected budget (amount)', "cf7lg"); ?></span>
				<input type="text" id="expected_budget_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["expected_budget"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
		
				
				<label class="input-group-text" id="inputGroup-sizing-default" for="deal_currency_cf7lg"><?php echo __('Deal currency', "cf7lg"); ?></label>
				<select class="form-select" id="deal_currency_cf7lg">
					<?php foreach($currencies['data'] as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["deal_currency"])) echo "selected"; ?>><?php echo $item['code']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Source', "cf7lg"); ?></span>
				<input type="text" id="source_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["source"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<label class="input-group-text" id="inputGroup-sizing-default" for="status_cf7lg"><?php echo __('Status', "cf7lg"); ?></label>
				<select class="form-select" id="status_cf7lg">
					<?php foreach($statuses['data'] as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["status"])) echo "selected"; ?>><?php echo $item['name']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">

				<label class="input-group-text" id="inputGroup-sizing-default" for="service_cf7lg"><?php echo __('Service', "cf7lg"); ?></label>
				<select class="form-select" id="service_cf7lg">
					<?php foreach($services['data'] as $item): ?>
						<option value="<?php echo $item['id']; ?>" <?php if(intval($item['id']) === intval($result["service"])) echo "selected"; ?>><?php echo $item['name']; ?></option>
					 <?php endforeach; ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Description', "cf7lg"); ?></span>
				<input type="text" id="description_lead_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["description_lead"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('File', "cf7lg"); ?></span>
				<input type="text" id="file_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["file"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12 d-none">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default">ID WPCF7 Form</span>
				<input type="text" id="cf7lg_id" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<? echo $_GET['post']; ?>">
			</div>    
		</div>

	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3>
				<?= __('Specify the attributes that will be used to create a client.', "cf7lg"); ?>
			</h3>

		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Name', "cf7lg"); ?></span>
				<input type="text" id="name_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["name"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Country', "cf7lg"); ?></span>
				<input type="text" id="country_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["country"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('E-mail', "cf7lg"); ?></span>
				<input type="text" id="email_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["email"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Phone', "cf7lg"); ?></span>
				<input type="text" id="phone_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["phone"]; ?>">
			</div>    
		</div>
		<div class="col-lg-12">
			<div class="input-group mb-3">
				<span class="input-group-text" id="inputGroup-sizing-default"><?php echo __('Description', "cf7lg"); ?></span>
				<input type="text" id="description_cf7lg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
					   value="<?php echo $result["description"]; ?>">
			</div>    
		</div>

	</div>

	<div class="col-lg-2 save_form">
		<button type='button' onclick="insetDataBase()" class="btn btn-primary btn-lg">
			<?= __('Save', "cf7lg"); ?>
		</button>
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