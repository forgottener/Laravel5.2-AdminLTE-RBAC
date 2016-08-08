<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>用户登录 | 开放平台</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/iCheck/square/blue.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a><b>rbac</b>开放平台</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">万事登录难</p>

    <form action="{{ url('/admin/login') }}" method="post">
		{!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="登录邮箱名"  name="email" value="{{ old('email') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control"  name="password" placeholder="密码">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> 记住登录
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->

    <a href="{{ url('/admin/password/reset') }}">我忘了密码</a><br>
    {{--<a href="#" class="text-center">新注册用户</a>--}}

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
<!-- iCheck -->
<script src="{{ asset("/bower_components/AdminLTE/plugins/iCheck/icheck.min.js") }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
