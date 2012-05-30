<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
  <?php if($val['type']=='news' && empty($val['deleted'])):?>
  <div style='background-image:url("<?=$val['img']?>");' class='news-post'>
    <a href='<?=create_url("page/view/{$val['id']}")?>'><h2><?=$val['title']?></h2></a>
    <div class='news-hider'>
    	<p class='short-news'>
    	<?=$val['short']?>
    </p>
      <p class='smaller-text'>
   		 <?php if(isset($gravatar["{$val['owner']}"])):?>
    	<img style='float:right; padding-left:10px;' src='<?php echo $gravatar["{$val['owner']}"]['gravatar']?>' />
    	<?php endif;?>
	    <?php if($userWriter):?>
    	 <a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a> <a href='<?=create_url("page/delete/{$val['id']}/blog")?>'>delete</a> 
	    <?php endif;?>
    	<a href='<?=create_url("page/like/{$val['id']}")?>'>like</a> : <?=$val['rating']?>
	    <br />
    	<?=$val['owner']?> | <?=$val['created']?>
	    </p>
    </div>
  </div>
  <?php endif;?>
  <?php endforeach; ?>
<?php else:?>
  <p>No posts exists.</p>
<?php endif;?>
