<div x-data="{ open: false }" x-show="open"
    @sweet-alert-loading.window="
   Swal.fire({
        title: 'Data Proses',
        html: 'Mohon Menunggu...',
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
">
</div>
