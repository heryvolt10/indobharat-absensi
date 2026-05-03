 <!-- Preloader -->
 {{-- <div class="preloader">
     <img src="/assets/images/logos/loader.svg" alt="loader" class="lds-ripple img-fluid" />
 </div> --}}

 <div id="main-wrapper">
     <!-- SIDEBAR VERTICAL -->
     @livewire('layouts.sidebar')

     <!-- SIDEBAR VERTICAL END -->

     <div class="page-wrapper">
         <div class="body-wrapper">
             <div class="container-fluid {{ session('ly_container') == 'boxed' ? '' : 'mw-100' }}">
                 <!-- TOPBAR -->
                 @livewire('layouts.topbar')
                 <!-- TOPBAR END -->

                 <!-- Welcome Section Start -->
                 <section class="welcome">

                     <div class="row">
                         <main>
                             <!-- CONTENT -->
                             {{ $slot }}
                             <!-- CONTENT END -->
                         </main>
                     </div>
                 </section>
             </div>
         </div>
         <div style="margin-top: 100px;"></div>
         <!-- THEME SETTING -->
         <script>
             function handleColorTheme(e) {
                 $("html").attr("data-color-theme", e);
                 $(e).prop("checked", !0);
             }
         </script>
         <!-- THEME SETTING END -->

         <!-- BUTTON SETTING -->
         {{-- <x-layouts.setting_button /> --}}

         <livewire:layouts.layset />
         <!-- BUTTON SETTING END -->

     </div>
     <div class="dark-transparent sidebartoggler"></div>
 </div>

 {{-- =========================COMPONEN DATATABLE================================ --}}

 {{-- =========================COMPONEN DATATABLE================================ --}}
