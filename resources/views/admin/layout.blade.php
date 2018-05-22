<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>{{config('app.name')}} | 服务代理系统</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic"--}}
    {{--rel="stylesheet" type="text/css"/>--}}
    {{--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}
    <link href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>
    <link href="/assets/css/style.min.css" rel="stylesheet"/>
    <link href="/assets/css/style-responsive.css" rel="stylesheet"/>
    <link href="/assets/css/theme/default.css" rel="stylesheet" id="theme"/>
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"/>
    <link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader">
    <div class="material-loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
        <div class="message">Loading...</div>
    </div>
</div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed navbar-toggle-left" data-click="sidebar-minify">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">
                    {{config('app.name')}}-服务代理系统
                </a>
            </div>
            <!-- end mobile sidebar expand / collapse button -->

            <!-- begin header navigation right -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">Hi, {{session('logined.user')->username}}</span>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li><a href="/">返回主页</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout">退出登录</a></li>
                    </ul>
                </li>
            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->

    @include('admin.sidebar')
    <div id="content" class="content">
        @yield('content')
    </div>

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
                class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="/assets/crossbrowserjs/html5shiv.js"></script>
<script src="/assets/crossbrowserjs/respond.min.js"></script>
<script src="/assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="/assets/plugins/flot/jquery.flot.min.js"></script>
<script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="/assets/plugins/sparkline/jquery.sparkline.js"></script>
<script src="/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/assets/js/dashboard.min.js"></script>
<script src="/assets/js/apps.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function () {
        App.init();
        @if (Session::has('alert'))
        alert('{{Session::pull('alert')}}');
        @endif
    });
</script>
</body>
</html>
