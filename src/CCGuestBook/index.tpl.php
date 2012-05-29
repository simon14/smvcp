<h1>Guestbook.</h1>
<div class='content'>
<form action='<?=$formAction?>' method='post'>
        <p>
          <label>
          <textarea name='newEntry' class='guestbook'></textarea></label>
        </p>
        <p>
          <input class='button' type='submit' name='doAdd' value='Add message' />
        </p>
</form>
<?php foreach($entries as $val):?>
<p class='post'>
<?=$val['entry']?>
<br />
<small>Posted on: <?=$val['date']?></small>
</p>
<?php endforeach;?>
</div>