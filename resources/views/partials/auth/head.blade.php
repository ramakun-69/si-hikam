<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} || {{ $title }}</title>

    @include('partials.auth.css')
    <style>
        .bg-login-image {
            background: url("{{ asset('img/logo-smk.png') }}") !important;
            background-position: center !important;
            background-size: contain !important;
            background-repeat: no-repeat !important;
        }
    </style>
</head>
