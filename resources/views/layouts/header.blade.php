
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        {{ config('system.settings_company_name') }}
        @isset($page['meta_title'])
            | {{ $page['meta_title'] }}
        @endisset
    </title>

    <!-- Base URL -->
    <base href="{{ url('/') }}" target="_self">

    <!-- Vendor Header JS (loaded first for compatibility) -->
    <script src="{{ asset('vendor/js/vendor.header.js') }}?v={{ config('system.versioning') }}" defer></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap/bootstrap.min.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/vendor.css') }}?v={{ config('system.versioning') }}">

    <!-- GrowCRM Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/fonts/growcrm-icons/styles.css') }}?v={{ config('system.versioning') }}">

    <!-- Bootstrap Icons (for nav icons, settings, etc.) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Theme CSS -->
    @if(config('visibility.external_view_use_default_theme'))
        <link rel="stylesheet" href="{{ asset('themes/default/css/style.css') }}?v={{ config('system.settings_system_javascript_versioning') }}">
    @else
        @auth
            <link rel="stylesheet" href="{{ asset('themes/' . auth()->user()->pref_theme . '/css/style.css') }}?v={{ config('system.settings_system_javascript_versioning') }}">
        @else
            <link rel="stylesheet" href="{{ asset(config('theme.selected_theme_css')) }}">
        @endauth
    @endif

    <!-- Custom CSS (user modifications & fixes) -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ config('system.versioning') }}">

    <!-- Print Styles -->
    <link rel="stylesheet" href="{{ asset('css/print.css') }}?v={{ config('system.versioning') }}" media="print">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">

    <!-- Core Head JS -->
    <script src="{{ asset('js/core/head.js') }}?v={{ config('system.versioning') }}" defer></script>

    <!-- Theme Specific Scripts -->
    {!! config('system.settings_theme_head') !!}

    <!-- Custom Topbar CSS Fix (Optional enhancement) -->
    <style>
        .topbar {
            position: sticky;
            top: 0;
            z-index: 1050;
            background-color: #ffffff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .navbar .nav-link {
            color: #374151;
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar .nav-link:hover {
            color: #2563eb;
        }
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .profile-pic img {
            border: 2px solid #e5e7eb;
            border-radius: 50%;
        }
    </style>
</head>
