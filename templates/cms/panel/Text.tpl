<div class="row">
  <h4>Text Message Board</h4>
</div>
<div class="row well">
    {foreach $keywords as $keyword}
      <span class="label label-info" data-id="{$keyword.id}" data-type="{$keyword.replyType}">{$keyword.word}<div style="display:none">{$keyword.reply}</div></span>
    {/foreach}
    <button type="button" class="btn btn-inverse" style="float: right;margin-top: 35px;">Add</button>
</div>
<div class="row">
  <div class="col-lg-8 col-lg-offset-2">
    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Text <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="#">Text</a></li>
          <li><a href="#">News</a></li>
        </ul>
      </div><!-- /btn-group -->
      <input type="text" class="form-control">
    </div><!-- /input-group -->

    <span id="widget"></span>

  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->


