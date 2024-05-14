<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="An impressive and flawless site template that includes various UI elements and countless features, attractive ready-made blocks and rich pages, basically everything you need to create a unique and professional website.">
    <meta name="keywords"
        content="bootstrap 5, business, corporate, creative, gulp, marketing, minimal, modern, multipurpose, one page, responsive, saas, sass, seo, startup, html5 template, site template">
    <meta name="author" content="elemis">
    <title>{{ $company->name }} - Modern & Multipurpose Bootstrap 5 Template</title>
    <link rel="shortcut icon" href="{{ asset($company->name . '/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset($company->name . '/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset($company->name . '/css/style.css') }}">
    @stack('addons-style')
</head>

<body>
    @php
        $config = [];
        foreach ($company->config()->get() as $value) {
            $config[$value->nama] = $value->isi;
        }
        $text = str_replace(' ', '%20', !empty($config) ? $config['text-wa'] : '');
    @endphp
    <div class="content-wrapper">
        @include($folder . 'partials.header')
        @yield('main')
    </div>
    <!-- /.content-wrapper -->

    @include($folder . 'partials.footer')

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <script src="{{ asset($company->name . '/js/plugins.js') }}"></script>
    <script src="{{ asset($company->name . '/js/theme.js') }}"></script>
</body>

</html>
