<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>后台管理 | 首页</title>

    <link href="/base/css/bootstrap.min.css" rel="stylesheet">
    <link href="/base/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="/base/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="/base/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="/base/css/animate.css" rel="stylesheet">
    <link href="/base/css/style.css" rel="stylesheet">
    <link href="/base/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="/base/js/jquery-2.1.1.js"></script>
    <script src="/base/js/popper.min.js"></script>
    <script src="/base/js/bootstrap.js"></script>
    <script src="/base/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/base/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="/base/js/plugins/layer/layer.min.js"></script>

    <link href="/base/plugins/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="/base/plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/base/plugins/bootstrap-fileinput/js/locales/zh.js" type="text/javascript"></script>

    @yield('header')
</head>

<body>
<div id="wrapper">
    <!-- Navigation -->
@include('admin.layouts.navigation')

<!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

        <!-- Page wrapper -->
    @include('admin.layouts.topnavbar')

    <!-- Main view  -->
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </div>
        </div>

        <div class="row J_mainContent" id="content-main" style="height:calc(100vh - 140px)">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ U('Base/Index/welcome')}}"
                    frameborder="0" data-id="index_v1.html" seamless></iframe>
        </div>

        <!-- Footer -->
        @include('admin.layouts.footer')

    </div>
    <!-- End page wrapper-->

</div>

<!-- Flot -->
<script src="/base/js/plugins/flot/jquery.flot.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/base/js/plugins/flot/jquery.flot.pie.js"></script>


<!-- Custom and plugin javascript -->
<script src="/base/js/inspinia.js"></script>
<script src="/base/js/plugins/pace/pace.min.js"></script>
<script type="text/javascript" src="/base/js/contabs.min.js?v={{config("sys.version")}}"></script>

<!-- jQuery UI -->
<script src="/base/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="/base/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="/base/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="/base/js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="/base/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="/base/js/plugins/toastr/toastr.min.js"></script>

<!-- DatePicker -->
<script src="/base/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script>

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
