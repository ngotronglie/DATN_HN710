import './bootstrap'
window.Echo.channel("notifications")
    .listen(".new-message", (event) => {
        const notificationArea = document.getElementById("notification-area");

        // Tạo nội dung thông báo
        const notification = document.createElement("p");
        

        // Nội dung thông báo
        notification.innerHTML = `
            <small>Bạn có tin nhắn mới:</small>
            <small>${event.userName}</small>
        `;

        // Thêm thông báo vào khu vực thông báo
        notificationArea.prepend(notification);
        setTimeout(() => {
            notification.remove();
        }, 5000);
      
        
    });
