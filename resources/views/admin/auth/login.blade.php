<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IN+ | 登录</title>

    <link href="/base/css/bootstrap.min.css" rel="stylesheet">
    <link href="/base/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/base/css/animate.css" rel="stylesheet">
    <link href="/base/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">IN+</h1>
        </div>
        <h3>后台管理</h3>

        <form class="m-t" role="form" accept-charset="UTF-8" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input name="username" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" required="">
            </div>
            <div class="form-group">
                {!! Geetest::render() !!}
            </div>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
        </form>
        <p class="m-t"> <small>Wesley &copy; 2018</small> </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="/base/js/jquery-3.1.1.min.js"></script>
<script src="/base/js/popper.min.js"></script>
<script src="/base/js/bootstrap.js"></script>

</body>

</html>
