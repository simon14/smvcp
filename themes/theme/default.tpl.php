<!doctype html>
<html lang="<?=$language?>"> 
<head>
  <meta charset="<?=$character_encoding?>">
  <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
  <title><?=$title?></title>
  <link rel="stylesheet" href="<?=$stylesheet?>">
</head>
<body>
<div class='floater'>
<?=login_menu()?>
</div>
<div class='wrapper'>
  <div class='header'>
    <?=makeHeader();?>
  </div>
</div>
<?=sub_menu()?>
<div class='wrapper'>
 <div class="main" role="main">
  	<p><?=get_messages_from_session()?></p>
    <?=@$main?>
    <?=render_views()?>
  </div>
  <div class="footer">
    <?=$footer?>
    <?=get_debug()?>
  </div>
</div>
</body>
</html>