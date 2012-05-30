<div class='content-wrapper'>
<h1>Blog</h1>
<p>All blog-like list of all content with the type "post", <a href='<?=create_url("content")?>'>view all content</a>.</p>

<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
  <?php if($val['type']=='blog' && empty($val['deleted'])):?>
  <div class='content'>
    <a href='<?=create_url("page/view/{$val['id']}")?>'><h2><?=$val['title']?></h2></a>
    <p><?=$val['content']?></p>
    <p class='smaller-text silent'>
    <?php if(isset($gravatar["{$val['owner']}"])):?>
    	<img style='float:right; padding-left:10px;' src='<?php echo $gravatar["{$val['owner']}"]['gravatar']?>' />
    <?php endif;?>
    <?php if($userWriter):?>
	    <a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a> <a href='<?=create_url("page/delete/{$val['id']}/blog")?>'>delete</a> 
	<?php endif;?>
    <br />
    Posted on <?=$val['created']?> by <?=$val['owner']?>
    </p>
    </div>
  <?php endif;?>
  <?php endforeach; ?>
<?php else:?>
  <p>No posts exists.</p>
<?php endif;?>
</div>