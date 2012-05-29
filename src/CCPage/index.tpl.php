<?php if($content['id']):?>
  <h1><?=$content['title']?></h1>
<div class='content'>
  <p><?=$content['content']?></p>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a> <a href='<?=create_url("content")?>'>view all</a></p>
<?php else:?>
<div class='content'>
  <p>404: No such page exists.</p>
<?php endif;?>
</div>

<?php if(isset($user['akronym'])):?>
<div class='content'>
<form action='<?=$formAction?>' method='post'>
        <p>
          <label>
          <textarea name='newEntry' class='comment'></textarea></label>
        </p>
        <p>
          <input class='textfield' type='textfield' name='userId'  hidden='hidden' value='<?=$user['id']?>' />
          <input class='button' type='submit' name='doAdd' value='Add comment' />
        </p>
</form>
<?php else:?>
<p>You have to be logged in to comment!</p>
<?php endif;?>

<?php foreach($entries as $val):?>
<p class='post'>
<?=$val['entry']?>
<br />
<small>Posted on: <?=$val['date']?></small>
</p>
<?php endforeach;?>
</div>