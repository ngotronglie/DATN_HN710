import './bootstrap'
window.Echo.join('comment' + chatId)
.joining(user => {
    const chatBox = document.querySelector('.contentBlock');
    chatBox.insertAdjacentHTML(
        'beforeend',
        `<p style="text-align: center; font-size: 12px; color: gray;">${user.name} vừa vào phòng chat</p>`
    );
})
.leaving(user => {
    const chatBox = document.querySelector('.contentBlock');
    chatBox.insertAdjacentHTML(
        'beforeend',
        `<p style="text-align: center; font-size: 12px; color: gray;">${user.name} vừa thoát phòng chat</p>`
    );
})
.listen('CommentEvent', function (event) {
    updateUiMessage(event);
});
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
    // Kiểm tra xem tin nhắn có phải của người dùng hiện tại không
    let classAuthStyle = event.sender_id == userSignIn 
        ? "text-align: right;" // Căn phải nếu là của người dùng hiện tại
        : "text-align: left;"; // Căn trái nếu là người khác

    let imageUrl = event.sender_id !== userSignIn && event.image ?
        (event.image.startsWith('http') ? event.image : '/storage/' + event.image) :
        '/theme/client/assets/images/logo/avata.jpg';
    let formattedTime = '';
    if (event.date) {
        let date = new Date(event.date); // Chuyển chuỗi date thành đối tượng Date
        let hours = String(date.getHours()).padStart(2, '0'); // Đảm bảo giờ có 2 chữ số
        let minutes = String(date.getMinutes()).padStart(2, '0'); // Đảm bảo phút có 2 chữ số
        formattedTime = `${hours}:${minutes}`;
    }
    let UI = `
    <p style="${classAuthStyle};">
        ${imageUrl ? `<img src="${imageUrl}" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;margin-right:5px">` : ''}
       <span style="display: inline-block; max-width: 80%; line-height: 1.4; font-size: 14px; background-color: #f4f4f4; padding: 5px 10px; border-radius: 10px;color:black">
        ${event.content}
    </span>
    <span style="font-size: 10px; color: gray; margin-top: 5px; align-self: flex-end;">
        ${formattedTime}
    </span>

    </p>
    `;
    
    
    contentBlock.insertAdjacentHTML('beforeend', UI);

    contentBlock.scrollTop = contentBlock.scrollHeight;
}
