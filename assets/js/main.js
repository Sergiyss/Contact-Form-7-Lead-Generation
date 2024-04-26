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