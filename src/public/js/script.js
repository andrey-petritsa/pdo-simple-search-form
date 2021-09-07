let MIN_INPUT_TEXT_LENGHT = 3

let form = document.querySelector('.search-form')
let form_input = document.querySelector('.search-form__input')
let form_alert = document.querySelector('.search-form__alert');
form.addEventListener('submit', (event) => {
    event.preventDefault()
    form_alert.innerHTML = ''
    if (form_input.value.length < MIN_INPUT_TEXT_LENGHT) {
        form_alert.innerHTML = `Для поиска нужно минимум ${MIN_INPUT_TEXT_LENGHT} символа`
    }
})
