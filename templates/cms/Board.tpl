<!DOCTYPE html>
<html lang="zh-cn">
  <head>
      <meta charset="utf-8">
      <title>Vera Dashboard</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Loading Bootstrap -->
      <link href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">

      <!-- Loading Flat UI -->
      <link href="{$base}cms/css/flat-ui.min.css" rel="stylesheet">

      <link href="{$base}cms/css/board.css" rel="stylesheet">

      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.6.2/html5shiv.js"></script>
      <![endif]-->
    </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1>
          Vera<small data-toggle="modal" data-target="#Login" style="padding-left: 30px;"> Dashboard </small>
          <button type="button" class="btn btn-info btn-sm" style="float: right;margin-top: 35px;" onclick="location.href='http://120.24.83.112/cms/api/login?m=logout'">Logout</button>
        </h1>
      </div>

      <div class="row">
        <div class="col-md-3">
          <ul class="list-unstyled lead" id="models" style="border-right: 2px solid #e7e9ec;padding-right: 30px;">
            {foreach $models as $model}
                <li class="board-list"><button id="model" type="button" data-model="{$model.key}" class="btn btn-primary btn-lg btn-block">{$model.name}</button></li>
            {/foreach}
          </ul>
        </div>

        <div class="col-md-9" id="panel"></div>

      </div>

      {include file="cms/Footer.tpl"}

    </div>

    <!-- 文本信息组件 START -->
    {include file="cms/widget/Text.tpl"}
    <!-- 文本信息组件 END -->

    <!-- 图文信息组件 START -->
    {include file="cms/widget/News.tpl"}
    <!-- 图文信息组件 END -->

    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="{$base}cms/js/vendor/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{$base}cms/js/flat-ui.min.js"></script>
    <script src="{$base}cms/js/board.js"></script>

  </body>
</html>
