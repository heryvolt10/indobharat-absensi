@script
    <script>
        $(document).on("click", ".btn_index_delete", function(e) {
            $iddet = $(this).data('id');
            Swal.fire({
                title: 'Yakin Menghapus Data?',
                text: "data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA'
            }).then((result) => {
                if (result.value) {
                    $wire.delete($iddet);
                }
            })
        });
    </script>
@endscript
