document.addEventListener("DOMContentLoaded", function() {
    var queryForm = function(settings) {
        // STORE THE UTM IN SESSION STORAGE
        var reset = settings && settings.reset ? settings.reset : false;
        var url = window.location.href;
        var queryString = url.split("?")[1];

        if (queryString) {
            var params = queryString.split("&");

            for (var i = 0; i < params.length; i++) {
                var pair = params[i].split("=");
                var key = decodeURIComponent(pair[0]);
                var value = decodeURIComponent(pair[1]);

                if (reset || sessionStorage.getItem(key) === null) {
                    sessionStorage.setItem(key, value);
                }
            }
        }
        // STORE THE UTM IN SESSION STORAGE

        // READ THE UTM IN SESSION STORAGE INTO INPUT VALUES
        var utmParameters = document.querySelectorAll(".utm_parameters input");

        utmParameters.forEach(function(input) {
            var paramName = input.name.replace("utm_", "");
            var utmValue = sessionStorage.getItem(input.name);
            if (utmValue !== null) {
                input.value = utmValue;
            }
        });
        // READ THE UTM IN SESSION STORAGE INTO INPUT VALUES
        getUtmData()
        console.log("done");
    };

    setTimeout(function() {
        queryForm();
    }, 2500);
});

/**
 * Возвращаю метки
 * */
function getUtmData(){

    var utmData = {};
	var hiddenFields = [];
	
	var forms = document.querySelectorAll('form.wpcf7-form');
	
	 // Получаем значения utm-меток из sessionStorage и добавляем их в объект
    if (sessionStorage.getItem('utm_source')) {
		hiddenFields.push({ name: 'utm_source_cf7lg', value: sessionStorage.getItem('utm_source') });
    }
    if (sessionStorage.getItem('utm_medium')) {
		hiddenFields.push({ name: 'utm_medium_cf7lg', value: sessionStorage.getItem('utm_medium') });
    }
    if (sessionStorage.getItem('utm_campaign')) {
		hiddenFields.push({ name: 'utm_campaign_cf7lg', value: sessionStorage.getItem('utm_campaign') });
    }
    if (sessionStorage.getItem('utm_term')) {
		hiddenFields.push({ name: 'utm_term_cf7lg', value: sessionStorage.getItem('utm_term') });
    }
    if (sessionStorage.getItem('utm_content')) {
		hiddenFields.push({ name: 'utm_content_cf7lg', value: sessionStorage.getItem('utm_content') });
    }


	// Перебираем найденные формы
	forms.forEach(function(form) {
		// Добавляем скрытые поля в форму
		hiddenFields.forEach(function(field) {
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = field.name;
			input.value = field.value;
			form.appendChild(input);
		});
	});

  

}