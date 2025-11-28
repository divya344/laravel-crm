
<head>
    <!-- GROWCRM © growcrm.io -->
    <!-- Header-Lite: used for embedded or direct-access pages -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('system.settings_company_name') }}
        {{ clean($page['meta_title'] ?? '') }}
    </title>

    <!-- Base URL -->
    <base href="{{ url('/') }}" target="_self">

    <!-- jQuery / Vendor (Lite) -->
    <script src="{{ asset('vendor/js/vendor-lite.header.js') }}?v={{ config('system.versioning') }}" defer></script>

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="{{ asset('vendor/css/bootstrap/bootstrap.min.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap"
          rel="stylesheet" type="text/css">

    <!-- Vendors CSS -->
    <link rel="stylesheet"
          href="{{ asset('vendor/css/vendor-lite.css') }}?v={{ config('system.versioning') }}">

    <!-- Default Theme -->
    <link rel="stylesheet"
          href="{{ asset('themes/default/css/style.css') }}?v={{ config('system.versioning') }}">

    <!-- Custom User CSS -->
    <link rel="stylesheet"
          href="{{ asset('css/custom.css') }}?v={{ config('system.versioning') }}">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Dynamic JS Variables -->
    <script>
        window.NX = window.NX || {};
        NX.site_url  = "{{ url('/') }}";
        NX.csrf_token = "{{ csrf_token() }}";
        NX.system_type = "tenant";
        NX.system_language = "{{ request('system_language') }}";
        NX.date_format = "{{ config('system.settings_system_date_format') }}";
        NX.date_picker_format = "{{ config('system.settings_system_datepicker_format') }}";
        NX.date_moment_format = "{{ runtimeMomentFormat(config('system.settings_system_date_format')) }}";
        NX.upload_maximum_file_size = "{{ config('system.settings_files_max_size_mb') }}";
        NX.settings_system_currency_symbol = "{{ config('system.settings_system_currency_symbol') }}";
        NX.settings_system_decimal_separator =
            "{{ runtimeCurrrencySeperators(config('system.settings_system_decimal_separator')) }}";
        NX.settings_system_thousand_separator =
            "{{ runtimeCurrrencySeperators(config('system.settings_system_thousand_separator')) }}";
        NX.settings_system_currency_position = "{{ config('system.settings_system_currency_position') }}";
        NX.show_action_button_tooltips = "{{ config('settings.show_action_button_tooltips') }}";
        NX.notification_position = "{{ config('settings.notification_position') }}";
        NX.notification_error_duration = "{{ config('settings.notification_error_duration') }}";
        NX.notification_success_duration = "{{ config('settings.notification_success_duration') }}";
        NX.session_login_popup = "{{ config('system.settings_system_session_login_popup') }}";
        NX.debug_javascript = "{{ config('app.debug_javascript') }}";

        // Default popover template
        NX.basic_popover_template =
            '<div class="popover card-popover" role="tooltip">' +
            '<span class="popover-close" onclick="$(this).closest(\'div.popover\').popover(\'hide\');">' +
            '<i class="ti-close"></i></span>' +
            '<div class="popover-header"></div><div class="popover-body" id="popover-body"></div></div>';

        // Language strings
        window.NXLANG = {
            delete_confirmation: "{{ cleanLang(__('lang.delete_confirmation')) }}",
            are_you_sure_delete: "{{ cleanLang(__('lang.are_you_sure_delete')) }}",
            cancel: "{{ cleanLang(__('lang.cancel')) }}",
            continue: "{{ cleanLang(__('lang.continue')) }}",
            file_too_big: "{{ cleanLang(__('lang.file_too_big')) }}",
            maximum: "{{ cleanLang(__('lang.maximum')) }}",
            generic_error: "{{ cleanLang(__('lang.error_request_could_not_be_completed')) }}",
            drag_drop_not_supported: "{{ cleanLang(__('lang.drag_drop_not_supported')) }}",
            use_the_button_to_upload: "{{ cleanLang(__('lang.use_the_button_to_upload')) }}",
            file_type_not_allowed: "{{ cleanLang(__('lang.file_type_not_allowed')) }}",
            cancel_upload: "{{ cleanLang(__('lang.cancel_upload')) }}",
            remove_file: "{{ cleanLang(__('lang.remove_file')) }}",
            maximum_upload_files_reached: "{{ cleanLang(__('lang.maximum_upload_files_reached')) }}",
            upload_maximum_file_size: "{{ cleanLang(__('lang.upload_maximum_file_size')) }}",
            upload_canceled: "{{ cleanLang(__('lang.upload_canceled')) }}",
            are_you_sure: "{{ cleanLang(__('lang.are_you_sure')) }}",
            image_dimensions_not_allowed: "{{ cleanLang(__('lang.image_dimensions_not_allowed')) }}",
            ok: "{{ cleanLang(__('lang.ok')) }}",
            close: "{{ cleanLang(__('lang.close')) }}",
            default_category: "{{ cleanLang(__('lang.default_category')) }}",
            select_atleast_one_item: "{{ cleanLang(__('lang.select_atleast_one_item')) }}",
            invalid_discount: "{{ cleanLang(__('lang.invalid_discount')) }}",
            please_wait: "{{ cleanLang(__('lang.please_wait')) }}"
        };
    </script>
</head>
