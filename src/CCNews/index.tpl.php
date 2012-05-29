<h1>News</h1>

<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
  <?php if($val['type']=='news' && empty($val['deleted'])):?>
  <div class='content'>
    <a href='<?=create_url("page/view/{$val['id']}")?>'><h2><?=$val['title']?></h2></a>
    <p><?=$val['short']?></p>
    <p class='smaller-text silent'>
    <?php if(isset($gravatar["{$val['owner']}"])):?>
    	<img style='float:right; padding-left:10px;' src='<?php echo $gravatar["{$val['owner']}"]['gravatar']?>' />
    <?php endif;?>
    <a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a> <a href='<?=create_url("page/delete/{$val['id']}/blog")?>'>delete</a> 
    <br />
    Posted on <?=$val['created']?> by <?=$val['owner']?>
    </p>
    </div>
  <?php endif;?>
  <?php endforeach; ?>
<?php else:?>
  <p>No posts exists.</p>
<?php endif;?>