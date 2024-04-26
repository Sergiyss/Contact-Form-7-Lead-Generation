function insetDataBase() {

    var name1 = document.getElementById('name_1').value;
    var name2 = document.getElementById('name_2').value;
    var name3 = document.getElementById('name_3').value;
    var name4 = document.getElementById('name_4').value;
    var name5 = document.getElementById('name_5').value;
    var cf7lgId = document.getElementById('cf7lg_id').value;



    let form_data = new FormData();
    form_data.append('action', 'update_wpcf7_form');
    form_data.append('params1', name1);
    form_data.append('params2', name2);
    form_data.append('params3', name3);
    form_data.append('params4', name4);
    form_data.append('params5', name5);
    form_data.append('formId', cf7lgId);
    


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