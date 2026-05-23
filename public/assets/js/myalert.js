// function flash_alert() {
//     // allert status action message
//     const swallflash = $("#flashdata").data("flashdatatext");
//     const swalltype = $("#flashdata").data("flashtype");

//     console.log(swallflash);

//     if (swallflash) {
//         Swal.fire({
//             position: "center",
//             icon: swalltype,
//             title: swallflash,
//             showConfirmButton: false,
//             timer: 3000,
//         });

//         $("#fromSwallFlash").val("1");
//     }
// }

function loading_spin() {
    Swal.fire({
        title: "Data Proses",
        html: "Mohon Menunggu...",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
}

function loading_alert() {
    Swal.fire({
        title: "Data Proses",
        html: "Mohon Menunggu...",
        allowEscapeKey: false,
        allowOutsideClick: false,
        timer: 1500,
        didOpen: () => {
            Swal.showLoading();
        },
    });
}

function loading_download() {
    swal.fire({
        title: "Data Proses",
        html: "Please wait...",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    }).then(
        () => {},
        (dismiss) => {
            if (dismiss === "timer") {
                swal({
                    title: "Finished!",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false,
                });
            }
        },
    );
}
