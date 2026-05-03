<head>
    <!-- Required meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Web icon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/org/setting_app/favicon-light.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/images/org/setting_app/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/images/org/setting_app/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/images/org/setting_app/favicon-180x180.png') }}">
    <meta property="og:url" content="url('/')" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $title ?? config('app.name') }}" />
    <meta property="og:description" content="{{ help_setapp('app_name') }}" />
    <meta property="og:image" content="{{ $title ?? config('app.name') }}" />
    <meta property="og:image:width" content="100"> <!-- Optimal width for many platforms -->
    <meta property="og:image:height" content="100"> <!-- Optimal height for many platforms -->
    <meta name="application-name" content="{{ help_setapp('app_name') }}" />

    @if (session('submenu_nama'))
        <title>{{ session('menu_nama') . '-' . session('submenu_nama') }}</title>
    @elseif ($title)
        <title>{{ $title }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    {{-- <title>{{ session('menu_nama') . '-' . session('submenu_nama') ?? config('app.name') }}</title> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script data-navigate-once src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styleadmin.css') }}" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/icon/fontawesome-all.css') }}" />


    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2bootstrap5.css') }}" />

    <!-- daterangepicker -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datepicker/datepicker.css') }}" />

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/css/buttons.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/css/fixedColumns.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/css/fixedHeader.dataTables.min.css') }}" />

    <!-- Input mask -->
    <script data-navigate-once src="{{ asset('assets/libs/inputmask/inputmask.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/libs/datepicker/datepicker.min.js') }}"></script>

    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.7/af-2.7.1/b-3.2.6/b-colvis-3.2.6/b-html5-3.2.6/b-print-3.2.6/cr-2.1.2/cc-1.2.1/date-1.6.3/fc-5.0.5/fh-4.0.6/kt-2.12.2/r-3.0.8/rg-1.6.0/rr-1.5.1/sc-2.4.3/sb-1.8.4/sp-2.3.5/sl-3.1.3/sr-1.4.3/datatables.min.css"
        rel="stylesheet" integrity="sha384-cG/fst5iVesuASUU3YLweoZ/HpBT/iUhx3CSBa45inqeE8mwF+MtBk8xWjvxOXsx"
        crossorigin="anonymous">


    @vite(['resources/js/app.js', 'resources/css/app.css'])

    @stack('styles')

    @livewireStyles

</head>
