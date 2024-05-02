const MAX_LENGHT_AMOUNT = 17;

window.addEventListener('beforeunload', function (event) {
	event.stopImmediatePropagation();
});

const types = [
	'is-primary',
	'is-link',
	'is-info',
	'is-success',
	'is-warning',
	'is-danger',
]

function displayToast(message, position, type) {
	bulmaToast.toast({
		message: message,
		type: type,
		position: position.toLowerCase().replace(' ', '-'),
		dismissible: true,
		duration: 4000,
		pauseOnHover: true,
		animate: { in: 'fadeIn', out: 'fadeOut' },
	})
}

/**
 * валидация для формы ввода суммы заказа
 * */
function validateInput(input) {
	// Регулярное выражение для проверки чисел и шаблона [amount-product]
	 //var pattern = /^(\d{0,13}|\[amount-product\])$/;
    var pattern = /^(\d{0,15}|\[amount-product\]|(\d{1,15}\.\d{0,2}))$/;

	if (!pattern.test(input)) {
		return false;
	}
	return true;
}

/**
 * Проверка ввода
 * */
var expectedBudgetInput = document.getElementById('expected_budget_cf7lg');
if (expectedBudgetInput) {
	const button = document.querySelector('.btn.btn-primary.btn-lg');
    // Если элемент существует, добавляем обработчик события input
    expectedBudgetInput.addEventListener('input', function() {
        var input = this.value; // Получаем значение поля ввода
        var isValid = validateInput(input); // Проверяем его на валидность
        this.value = input.substring(0, MAX_LENGHT_AMOUNT - 1);
        // Если ввод не прошел валидацию
        if (!isValid && input != '') {
            // Выводим сообщение об ошибке
            displayToast(cf7lgTranslate.error_input_amount, 'Bottom Left', types[4]);
            // Очищаем поле ввода
            //this.value = '';
            if(document.querySelector('.leads_form')){
				 button.setAttribute('disabled', true);
			}
        }else{
			if(document.querySelector('.leads_form')){
				 button.removeAttribute('disabled');
			}
		}
    });
}

//Слушатель события нажатия на настройку utms меток
var checkboxElement = document.getElementById('utm_active_custom_tags_cf7lg');
if (checkboxElement) {
    checkboxElement.addEventListener('change', function() {
         isActiveUtmInputs()
    });
} 

//is active utms input tags
function isActiveUtmInputs(){
	
	var isActiveInputs = !document.getElementById('utm_active_custom_tags_cf7lg').checked

	document.getElementById('utm_source_cf7lg').disabled = isActiveInputs;
	document.getElementById('utm_medium_cf7lg').disabled = isActiveInputs;
	document.getElementById('utm_campaign_cf7lg').disabled = isActiveInputs;
	document.getElementById('utm_term_cf7lg').disabled = isActiveInputs;
	document.getElementById('utm_content_cf7lg').disabled = isActiveInputs;
	
}

//is valid forms
if (document.querySelector('.leads_form')) {
    // Получаем ссылки на элементы формы
    const titleInput = document.getElementById('title_cf7lg');
    const selectInput = document.getElementById('responsible_cf7lg');
    const textInput = document.getElementById('name_cf7lg');
    const button = document.querySelector('.btn.btn-primary.btn-lg');

    // Функция для проверки заполненности всех обязательных полей
    function checkInputs() {
        // Проверяем заполненность полей
        const isTitleFilled = titleInput.value.trim() !== '';
        const isSelectFilled = selectInput.value.trim() !== '';
        const isTextFilled = textInput.value.trim() !== '';
		
		if (!isTitleFilled) {
    		titleInput.setAttribute('required', true);
		}else{
			titleInput.removeAttribute('required');
		}
		
		if (!isSelectFilled) {
    		selectInput.setAttribute('required', true);
		}else{
			selectInput.removeAttribute('required');
		}
		
		if (!isTextFilled) {
    		textInput.setAttribute('required', true);
		}else{
			textInput.removeAttribute('required');
		}
		

        // Включаем или отключаем кнопку в зависимости от состояния полей
        if (isTitleFilled && isSelectFilled && isTextFilled) {
            button.removeAttribute('disabled');
        } else {
            button.setAttribute('disabled', true);
        }
    }

	
    // Слушаем событие ввода для инпутов и селекта
    titleInput.addEventListener('input', checkInputs);
    selectInput.addEventListener('change', checkInputs);
    textInput.addEventListener('input', checkInputs);
}