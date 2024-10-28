<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- added  template links start --}}
            <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


            <!-- Vendor CSS Files -->
        <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="./assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="./assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="./assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="./assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="./assets/vendor/simple-datatables/style.css" rel="stylesheet">

                <!-- Template Main CSS File -->
            <link href="./assets/css/style.css" rel="stylesheet">
            <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet">
            <link href="./assets/css/custom-style.css" rel="stylesheet">

    {{-- added  template links end --}}

    @yield("page-script")

    <!-- Scripts -->

    @vite([ 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>
<body>
    <div id="app">

    </div>

    {{-- added template js start --}}
                <!-- Vendor JS Files -->
            <script src="./assets/vendor/apexcharts/apexcharts.min.js"></script>
            <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="./assets/vendor/chart.js/chart.umd.js"></script>
            <script src="./assets/vendor/echarts/echarts.min.js"></script>
            <script src="./assets/vendor/quill/quill.js"></script>
            <script src="./assets/vendor/simple-datatables/simple-datatables.js"></script>
            <script src="./assets/vendor/tinymce/tinymce.min.js"></script>
            <script src="./assets/vendor/php-email-form/validate.js"></script>



            <!-- Template Main JS File -->
                <script src="./assets/js/main.js"></script>

    {{-- added template js end --}}
</body>
</html>
