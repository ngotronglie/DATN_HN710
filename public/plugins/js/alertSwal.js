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
