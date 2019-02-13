<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>INSPINIA | Dashboard</title>

    <link href="/base/css/bootstrap.min.css" rel="stylesheet">
    <link href="/base/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="/base/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="/base/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="/base/css/animate.css" rel="stylesheet">
    <link href="/base/css/style.css" rel="stylesheet">
    <link href="/base/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/base/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="/base/js/jquery-2.1.1.js"></script>
    <script src="/base/js/bootstrap.js"></script>
    <script src="/base/js/plugins/layer/layer.min.js"></script>

    <script src="/base/js/popper.min.js"></script>
    <script src="/base/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/base/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <link href="/base/plugins/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="/base/plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/base/plugins/bootstrap-fileinput/js/locales/zh.js" type="text/javascript"></script>

    @yield('header')
</head>

<body class="gray-bg">
    @yield('content')

<!-- Flot -->
<script src="/base/js/plugins/flot/jquery.flot.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Custom and plugin javascript -->
<script src="/base/js/inspinia.js"></script>
<script src="/base/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="/base/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="/base/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="/base/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- ChartJS-->
<script src="/base/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="/base/js/plugins/toastr/toastr.min.js"></script>

<!-- DatePicker -->
<script src="/base/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script src="/base/js/jquery.tablesort.js"></script>

<script>
    $(".dataTable").tableSort(['sorting', 'sorting_asc', 'sorting_desc']);
    $('.input-group.date').datepicker({
        language: "zh",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: "yyyy-mm-dd"
    });
</script>

@yield('js')

</body>
</html>
