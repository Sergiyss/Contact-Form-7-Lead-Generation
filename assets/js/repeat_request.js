function repeatForm(argument, id) {
	
    let form_data = new FormData();
    form_data.append('action', 'repeat_request_form');
    form_data.append('request', encodeURIComponent(document.getElementById(argument).value));
    form_data.append('id', id);

    var xhr = new XMLHttpRequest();
        xhr.open('POST', '/wp-admin/admin-ajax.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const dataArray = JSON.parse(xhr.responseText);
                
                if(dataArray.status === "success"){
                    displayToast(cf7lgTranslate.success, 'Bottom Left', types[3]);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }else{}

            } else {
                displayToast(cf7lgTranslate.error, 'Bottom Left', types[5]);
            }
        };
        xhr.onerror = function() {
            displayToast(cf7lgTranslate.failed, 'Bottom Left', types[5])
        };
        xhr.send(form_data);
}