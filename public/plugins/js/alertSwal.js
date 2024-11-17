function swalSuccess(mes) {
    swal({
        content: {
            element: "span",
            attributes: {
                innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>${mes}`,
            },
        },
        text: "",
        icon: "success",
        button: "Đóng",
    });
}

function swalError(mes) {
    swal({
        content: {
            element: "span",
            attributes: {
                innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>${mes}`,
            },
        },
        text: "",
        icon: "error",
        button: "Đóng",
    });
}
