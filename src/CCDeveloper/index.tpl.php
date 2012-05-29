<h1> Links around the developer site. </h1>
<div class='content'>
<ul>
<?php foreach($menu as $val):?>
<li><a href='<?=$baseurl.$val?>'><?=$val?></a></li>
<?php endforeach;?>
</ul>
<?=@$extra?>
</div>