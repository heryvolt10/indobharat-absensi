<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')

<body>
    <!-- =======================================ALERT=================================== -->
    <x-sweet-alert />
    <!-- =======================================ALERT=================================== -->

    {{ $slot }}

    <!-- =======================================IMPOR SCRIPT=================================== -->
    @include('layouts.script')
    <!-- =======================================IMPOR SCRIPT=================================== -->

    <!-- =======================================LAYOUT THEME SETTING=================================== -->

    @if (session()->has('dataflash'))
        <script>
            $(function() {
                Swal.fire({
                    position: "center",
                    icon: "{{ session('dataflash.flashtype') }}",
                    title: "{{ session('dataflash.pesan') }}",
                    showConfirmButton: true,
                    timer: 3000,
                });
            });
        </script>
    @endif
    <!-- =======================================LAYOUT THEME SETTING=================================== -->

    @Stack('scripts')


    @livewireScripts
</body>

</html>
