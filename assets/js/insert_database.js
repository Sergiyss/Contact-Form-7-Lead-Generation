function insetDataBase() {

    let form_data = new FormData();
    form_data.append('action', 'update_wpcf7_form');
    form_data.append('title', document.getElementById('title_cf7lg').value);
    form_data.append('responsible', document.getElementById('responsible_cf7lg').value);
    form_data.append('observers', getSelectedValuesAsString('observers_cf7lg'));
    form_data.append('expected_budget', document.getElementById('expected_budget_cf7lg').value);
    form_data.append('deal_currency', document.getElementById('deal_currency_cf7lg').value);
    form_data.append('source', document.getElementById('source_cf7lg').value);
    form_data.append('status', document.getElementById('status_cf7lg').value);
    form_data.append('service', document.getElementById('service_cf7lg').value);
    form_data.append('description_lead', document.getElementById('description_lead_cf7lg').value);
    form_data.append('file', document.getElementById('file_cf7lg').value);
    form_data.append('name', document.getElementById('name_cf7lg').value);
    form_data.append('country', document.getElementById('country_cf7lg').value);
    form_data.append('email', document.getElementById('email_cf7lg').value);
    form_data.append('phone', document.getElementById('phone_cf7lg').value);
    form_data.append('description', document.getElementById('description_cf7lg').value);
	form_data.append('utm_tags_checked', document.getElementById('utm_active_custom_tags_cf7lg').checked);
	form_data.append('utm_source', document.getElementById('utm_source_cf7lg').value);
	form_data.append('utm_medium', document.getElementById('utm_medium_cf7lg').value);
	form_data.append('utm_campaign', document.getElementById('utm_campaign_cf7lg').value);
	form_data.append('utm_term', document.getElementById('utm_term_cf7lg').value);
	form_data.append('utm_content', document.getElementById('utm_content_cf7lg').value);
	
    form_data.append('formId', document.getElementById('cf7lg_id').value);
    


     var xhr = new XMLHttpRequest();
        xhr.open('POST', '/wp-admin/admin-ajax.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const dataArray = JSON.parse(xhr.responseText);
                
                if(dataArray.status === "success"){
                    displayToast('Дані успішно збережено', 'Bottom Left', types[3]);
                }else{}

            } else {
                displayToast('Не вдалося надіслати дані', 'Bottom Left', types[5]);
            }
        };
        xhr.onerror = function() {
            displayToast('Request failed', 'Bottom Left', types[5])
        };
        xhr.send(form_data);
}


function getSelectedValuesAsString(selectId) {
    var select = document.getElementById(selectId);
    var selectedValues = [];
    for (var i = 0; i < select.selectedOptions.length; i++) {
        selectedValues.push(select.selectedOptions[i].value);
    }
    return selectedValues.join(', ');
}