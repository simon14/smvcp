<div class='content-wrapper'>
<h1>Restore</h1>
<p>One controller to manage the actions for content, mainly list, create, edit, delete, view.</p>

<?php if($userAdmin): ?>
<h2>Your content</h2>
<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
  <?php if($val['owner']==$user['akronym'] && isset($val['deleted'])):?>
  		<p><?=$val['id']?>. <a href='<?=create_url("page/view/{$val['id']}")?>'><?=$val['title']?></a> -  Writer: <?=$val['owner']?> 
		<a href='<?=create_url("page/restore/{$val['id']}")?>'>restore</a></p>
  <?php endif;?>
  <?php endforeach; ?>
<?php else:?>
  <p>No content exists.</p>
<?php endif;?>

<h2>All content</h2>
<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
  <?php if(isset($val['deleted'])):?>
  		<p><?=$val['id']?>. <a href='<?=create_url("page/view/{$val['id']}")?>'><?=$val['title']?></a> -  Writer: <?=$val['owner']?> 
		<a href='<?=create_url("page/restore/{$val['id']}")?>'>restore</a></p>
  <?php endif;?>
  <?php endforeach; ?>
<?php else:?>
  <p>No content exists.</p>
<?php endif;?>
<?php else:?>
<p>You have to be logged in as an administrator to restore contents</p>
<?php endif;?>
</div>