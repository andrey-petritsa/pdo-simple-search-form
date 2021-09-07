let MIN_INPUT_TEXT_LENGHT = 3

let form = document.querySelector('.search-form')
form.addEventListener('submit', (event) => {
    event.preventDefault()
    let form_input = document.querySelector('.search-form__input')
    if (form_input.value.length < MIN_INPUT_TEXT_LENGHT) {
        let form_alert = document.querySelector('.search-form__alert');
        form_alert.innerHTML = `Для поиска нужно минимум ${MIN_INPUT_TEXT_LENGHT} символа`
    }
})
