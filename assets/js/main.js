const MAX_LENGHT_AMOUNT = 13;

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
	 var pattern = /^(\d{0,13}|\[amount-product\])$/;

	if (!pattern.test(input)) {
		return false;
	}
	return true;
}

/**
 * Проверка ввода
 * */
document.getElementById('expected_budget_cf7lg').addEventListener('input', function() {
	var input = this.value; // Получаем значение поля ввода
	var isValid = validateInput(input); // Проверяем его на валидность
	this.value = input.substring(0, MAX_LENGHT_AMOUNT - 1);
	// Если ввод не прошел валидацию
	if (!isValid && input != '') {
		// Выводим сообщение об ошибке
		displayToast('Пожалуйста, введите только числа или шаблон [amount-product].', 'Bottom Left', types[2]);
		// Очищаем поле ввода
		//this.value = '';
	}
});