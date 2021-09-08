let MIN_INPUT_TEXT_LENGHT = 3
let form = document.querySelector('.search-form')
let form_input = document.querySelector('.search-form__input')
let form_alert = document.querySelector('.search-form__alert');
let form_posts = document.querySelector('.search-form__founded')

form.addEventListener('submit', async (event) => {
    event.preventDefault()

    if (is_request_valid()) {
        let json_response = await send_request_find_posts();

        if (json_response.ok) {
            let json = await json_response.json()
            let posts = json['posts'];
            if (posts) {
                if (posts.length === 0) {
                    form_alert.innerHTML = 'Не найдено постов с указанным комментарием'
                } else {
                    for (var key in posts) {
                        let post_section = generate_post_section(posts[key])
                        form_posts.appendChild(post_section)
                    }
                }
            }
            if (json['message']) {
                form_alert.innerHTML = json['message']
            }
        } else {
            form_alert.innerHTML = 'Ошибка при отправке запроса'
        }
    } else {
        form_alert.innerHTML = `Для поиска нужно минимум ${MIN_INPUT_TEXT_LENGHT} символа`
    }
})

function generate_post_section(post) {
    let post_section = document.createElement('div')
    post_section.className = `search-form__post search-form__post_post-id-${post['postId']}`

    let post_title = document.createElement('h3')
    post_title.className = 'search-form__post-title';
    post_title.innerHTML = post['postTitle']

    let post_comments = document.createElement('div')
    post_comments.className = 'search-form__post-comments'

    post['comments'].forEach((comment) => {
        let post_comment = document.createElement('div');
        post_comment.className = 'search-form__post-comment'
        post_comment.innerHTML = comment

        post_comments.appendChild(post_comment)
    })

    post_section.appendChild(post_title)
    post_section.appendChild(post_comments)
    return post_section
}

function is_request_valid() {
    form_alert.innerHTML = ''
    if (form_input.value.length < MIN_INPUT_TEXT_LENGHT) {
        return false
    }
    return true
}


async function send_request_find_posts() {
    let searchHandlerUrl = '/php/find-post.php'
    let searchOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({'post-comment-contain-text': form_input.value})

    }

    let response = await fetch(searchHandlerUrl, searchOptions)
    return response
}
