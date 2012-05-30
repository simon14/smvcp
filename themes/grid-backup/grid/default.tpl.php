<!doctype html>
<html lang='sv'> 
<head>
  <meta charset='iso-8859-1'/>
  <title><?=$title?></title>
  <link rel='stylesheet' href='<?=$stylesheet?>'/>
  <?php if(isset($inline_style)): ?><style><?=$inline_style?></style><?php endif; ?>
</head>
<body>

<div id='outer-wrap-header'>
  <div id='inner-wrap-header'>
    <div id='header'>
      <div id='login-menu'><?=login_menu()?></div>
      <div id='banner'>
        <span id='site-title'><a href='<?=base_url()?>'><?=makeLogo()?></a></span>
        <span id='site-slogan'></span>
      </div>
      <span id='site-menu'><?=makeMenu()?></span>
    </div>
  </div>
</div
<?php if(region_has_content('flash')): ?>
<div id='outer-wrap-flash'>
  <div id='inner-wrap-flash'>
    <div id='flash'><?=render_views('flash')?></div>
  </div>
</div>
<?php endif; ?>

<?php if(region_has_content('featured-first', 'featured-middle', 'featured-last')): ?>
<div id='outer-wrap-featured'>
  <div id='inner-wrap-featured'>
    <div id='featured-first'><?=render_views('featured-first')?></div>
    <div id='featured-middle'><?=render_views('featured-middle')?></div>
    <div id='featured-last'><?=render_views('featured-last')?></div>
  </div>
</div>
<?php endif; ?>

<div id='outer-wrap-main'>
  <div id='inner-wrap-main'>
    <div id='primary'>
      <?=get_messages_from_session()?>
      <?=@$main?>
      <?=render_views('primary')?>
      <?=render_views('default')?>
    </div>
    <div id='sidebar'><?=render_views('sidebar')?></div>
  </div>
</div>

<?php if(region_has_content('triptych-first', 'triptych-middle', 'triptych-last')): ?>
<div id='outer-wrap-triptych'>
  <div id='inner-wrap-triptych'>
    <div id='triptych-first'>Triptych first</div>
    <div id='triptych-middle'>Triptych middle</div>
    <div id='triptych-last'>Triptych last</div>
  </div>
</div>
<?php endif;?>


<div id='outer-wrap-footer'>
  <?php if(region_has_content('footer-column-one', 'footer-column-two', 'footer-column-three', 'footer-column-four')): ?>
  <div id='inner-wrap-footer-column'>
    <div id='footer-column-one'><?=render_views('footer-column-one')?></div>
    <div id='footer-column-two'><?=render_views('footer-column-two')?></div>
    <div id='footer-column-three'><?=render_views('footer-column-three')?></div>
    <div id='footer-column-four'><?=render_views('footer-column-four')?></div>
  </div>
  <?php endif; ?>
  <div id='inner-wrap-footer'>
    <div id='footer'><?=render_views('footer')?><?=$footer?><?=get_debug()?></div>
  </div>
</div>
</body>
</html>