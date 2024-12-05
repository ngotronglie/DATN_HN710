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
    
    // Hiển thị thông báo khi vào phòng
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
    
    // Hiển thị thông báo khi rời phòng
    const chatBox = document.querySelector('.contentBlock');
    chatBox.insertAdjacentHTML(
        'beforeend', 
        `<p style="text-align: center; font-size: 12px; color: gray;">${user.name} vừa thoát phòng chat</p>`
    );
})


.listen('CommentEvent', function (event) {
console.log(event);
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
    let classAuth = event.sender_id == userSignIn ? "text-end" : ""
    let currentTime = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
    
    let UI = `
   
    <p class="${classAuth}">
       ${event.userName}: ${event.content}
        <span style="font-size: 10px; color: gray;">(${currentTime})</span>
    </p>
`;

contentBlock.insertAdjacentHTML('beforeend', UI);

// Cuộn xuống dưới cùng để xem tin nhắn mới nhất
contentBlock.scrollTop = contentBlock.scrollHeight;
}