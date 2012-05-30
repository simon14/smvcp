<?php if(!empty($image)):?><img style='width:780px;' src='<?=$image?>' /><?php elseif(isset($video)):?><?=$video?><?php endif;?>
<div class='content-wrapper'>
<?php if($content['id'] && empty($content['deleted'])):?>
  <h1><?=$content['title']?></h1>
<div class='content'>
  <p><?=$content['content']?></p>
  <?php if($userWriter):?>
  	<p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a> <a href='<?=create_url("content")?>'>view all</a></p>
  <?php endif;?>
<?php else:?>
<div class='content'>
  <p>404: No such page exists.</p>
<?php endif;?>
</div>


<?php if($content['type']=='news'):?>
<a href='<?=create_url("page/like/{$content['id']}")?>'>like</a> - <?=$content['rating']?>
<?php if(isset($user['akronym'])):?>

<form name='comment' action='<?=$formAction?>' method='post'>
        <p>
          <label>Comment</label><br />
<textarea name="newEntry"></textarea>        
        </p>
        <p>
          <input class='textfield' type='textfield' name='userId'  hidden='hidden' value='<?=$user['id']?>' />
          <input class='button' type='submit' name='doAdd' value='Add comment' />
        </p>
</form>


<?php else:?>
<br />
<p>You have to be logged in to comment!</p>
<?php endif;?>

<?php foreach($entries as $val):?>
<p class='post'>
<?=$val['entry']?>
<br />
<small id='mini'><?=$val['owner']?> | <?=$val['date']?></small>
</p>
<?php endforeach;?>

<?php endif;?>
</div>