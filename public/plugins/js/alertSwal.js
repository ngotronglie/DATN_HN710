function swalSuccess(mes) {
    Swal.fire({
        html: `<h1 style='font-size: 1.3rem;'>${mes}</h1>`,
        icon: "success",
        confirmButtonText: "Đóng",
    });
}

function swalError(mes) {
    Swal.fire({
        html: `<h1 style='font-size: 1.3rem;'>${mes}</h1>`,
        icon: "error",
        confirmButtonText: "Đóng",
    });
}


function swalSuccessAd(mes) {
    Swal.fire({
        icon: 'success',
        title: '',
        text: `${mes}`,
        allowOutsideClick: false, // Không cho phép đóng bằng cách ấn bên ngoài
        allowEscapeKey: false,   // Không cho phép đóng bằng phím Esc
        confirmButtonText: 'Đóng', // Văn bản trên nút xác nhận
    });
}



function swalErrorAd(mes) {
    Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: `${mes}`,
        allowOutsideClick: false, // Không cho phép đóng bằng cách ấn bên ngoài
        allowEscapeKey: false,   // Không cho phép đóng bằng phím Esc
        confirmButtonText: 'Đóng',
    });
}


