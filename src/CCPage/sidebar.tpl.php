<?php if($news):?>
<?php if(isset($nextNews)):?>
	<a href='<?=create_url("page/view/{$nextNews['id']}")?>'><img class='news-view' src='<?=create_url('site/img/nav_right.gif')?>' /></a>
<?php endif; ?>
<?php if(isset($backNews)):?>
	<a href='<?=create_url("page/view/{$backNews['id']}")?>'><img class='news-view' src='<?=create_url('site/img/nav_left.gif')?>' /></a>
<?php endif; ?>
<?php endif;?>