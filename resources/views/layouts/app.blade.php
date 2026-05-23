<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-boxed-layout="{{ session('ly_container') == 'boxed' ? 'boxed' : 'full' }}"
    data-bs-theme="{{ session('ly_theme') == 'dark' ? 'dark' : 'light' }}"
    data-card="{{ session('ly_card') == 'shadow' ? 'shadow' : 'border' }}"
    data-color-theme="{{ session()->has('ly_color') ? session('ly_color') : 'Blue_Theme' }}">

@include('layouts.header')

<body data-sidebartype="{{ session('ly_sidebar') == 'mini-sidebar' ? 'mini-sidebar' : 'full' }}">
    <!-- =======================================ALERT=================================== -->
    <x-template.sweet-alert />
    <x-template.sweet-alert-notime />
    <!-- =======================================ALERT=================================== -->

    <!-- =======================================MAIN CONTENT=================================== -->
    @include('layouts.main')
    <!-- =======================================MAIN CONTENT=================================== -->

    <!-- =======================================IMPOR SCRIPT=================================== -->
    @include('layouts.script')
    <!-- =======================================IMPOR SCRIPT=================================== -->

    <!-- =======================================IMPOR SCRIPT ADDITIONAL=================================== -->
    @include('layouts.script_add')
    <!-- =======================================IMPOR SCRIPT ADDITIONAL=================================== -->

    <!-- =======================================MODAL LIST TABLE=================================== -->
    @livewire('template.modal-list')
    <!-- =======================================MODAL LIST TABLE=================================== -->

    <!-- =======================================LAYOUT THEME SETTING=================================== -->



    <script>
        window.addEventListener('popstate', function(event) {
            // Force a full page reload when the browser's back (or forward) button is used
            window.location.reload();
        });
    </script>


    <script>
        $(document).ready(function() {
            $sessSubmenuUrl = "{{ session('submenu_url') }}";
        });
    </script>

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


    @livewireScripts

    @stack('scripts')

</body>

</html>
