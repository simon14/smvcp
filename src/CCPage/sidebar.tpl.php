<?php if($news):?>
<?php if(isset($nextNews)):?>
	<a href='<?=create_url("page/view/{$nextNews['id']}")?>'>Next</a>
<?php endif; ?>
<?php if(isset($backNews)):?>
	<a href='<?=create_url("page/view/{$backNews['id']}")?>'>Back</a>
<?php endif; ?>
<?php endif;?>