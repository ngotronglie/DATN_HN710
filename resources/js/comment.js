import './bootstrap'

let userOnline=document.querySelector("#userOnline")
window.Echo.join('comment' + chatId)
.here(users=>{
    let UI=''
    users.forEach(user=>{
        if (userSignIn != user.id) {
            UI += `<li class="list-group-item user-${user.id}">${user.name}</li>`
        }
    })
    userOnline.insertAdjacentHTML('beforebegin', UI)
})
.joining(user => {
    let UI = `<li class="list-group-item user-${user.id}">${user.name}</li>`;
    userOnline.insertAdjacentHTML('beforebegin', UI);
        const chatBox = document.querySelector('.contentBlock');
    chatBox.insertAdjacentHTML(
        'beforeend', 
        `<p style="text-align: center; font-size: 12px; color: gray;">${user.name} vừa vào phòng chat</p>`
    );
})
.leaving(user => {
    let userDom = document.querySelector(`.user-${user.id}`);
    if (userDom) {
        userDom.remove();
    }
    
    const chatBox = document.querySelector('.contentBlock');
    chatBox.insertAdjacentHTML(
        'beforeend', 
        `<p style="text-align: center; font-size: 12px; color: gray;">${user.name} vừa thoát phòng chat</p>`
    );
})


.listen('CommentEvent', function (event) {
    updateUiMessage(event);
})


let btnSendMessage = document.querySelector('#btnSendMessage')
let inputMessage = document.querySelector("#inputMessage")

btnSendMessage.addEventListener('click', function () {
    let message = inputMessage.value
    window.axios.post(routeMessage, { message })
        .then(function (response) {
            if (response.data.log == 'success') {
                inputMessage.value = ""
            }
        })
})

let contentBlock = document.querySelector('.contentBlock')
function updateUiMessage(event) {
    let classAuth = event.sender_id == userSignIn ? "text-end" : "";
    
    let imageUrl = event.sender_id !== userSignIn && event.image ? 
                   (event.image.startsWith('http') ? event.image : '/storage/' + event.image) : 
                   '';

    let UI = `
    <p class="${classAuth}" style="color: black;">
        ${imageUrl ? `<img src="${imageUrl}" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">` : ''}
        ${event.content}
    </p>
    `;

    contentBlock.insertAdjacentHTML('beforeend', UI);

    contentBlock.scrollTop = contentBlock.scrollHeight;
}
