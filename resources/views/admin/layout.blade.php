<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理 - @yield('title') </title>


    <link href="/base/css/bootstrap.min.css" rel="stylesheet">
    <link href="/base/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="/base/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="/base/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="/base/css/animate.css" rel="stylesheet">
    <link href="/base/css/style.css" rel="stylesheet">
    @yield('header')
</head>

<body class="gray-bg">
@yield('content')
</body>
</html>



