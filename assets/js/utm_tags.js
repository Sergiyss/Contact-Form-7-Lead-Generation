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
        console.log("done");
    };

    setTimeout(function() {
        queryForm();
    }, 5000);
});