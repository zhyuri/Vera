<!DOCTYPE html>
<html lang="zh-CN">
  <head>
      <meta charset="utf-8">
      <title>Vera Dashboard</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Loading Bootstrap -->
      <link href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">

      <!-- Loading Flat UI -->
      <link href="{$base}cms/css/flat-ui.min.css" rel="stylesheet">

      <!-- Loading Index CSS -->
      <link href="{$base}cms/css/index.css" rel="stylesheet">

      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.6.2/html5shiv.js"></script>
      <![endif]-->
    </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1>Vera<small data-toggle="modal" data-target="#Login" style="padding-left: 30px;"> Dashboard</small></h1>
      </div>

      <div class="row text-center">
        <h1>Hello World!</h1>
      </div>

      {include file="cms/Footer.tpl"}

    </div>

    <!-- 登录框 -->
    <div class="modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="LoginLabel" aria-hidden="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="LoginLabel">Login</h4>
          </div>
          <div class="modal-body">
            <form class="form-inline" id="loginForm">
              <div class="form-group">
                <label class="sr-only" for="username">User</label>
                <input type="text" class="form-control" id="username" placeholder="User">
              </div>
              <div class="form-group">
                <label class="sr-only" for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
              </div>
              <button type="button" id="loginButton" data-loading-text="Loading..." data-success-text="登录成功" class="btn btn-primary index-btn" style="float: right;" autocomplete="off">
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="{$base}cms/js/vendor/jquery.min.js"></script>
    <script src="{$base}cms/js/flat-ui.min.js"></script>

    <script src="{$base}cms/js/index.js"></script>

  </body>
</html>
