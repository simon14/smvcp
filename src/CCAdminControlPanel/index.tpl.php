<h1> Admin control panel </h1>
<p> Here you can manage some of website.</p>
<?php foreach($users as $key => $val):?>
<?=$val['akronym']?><a href='<?=create_url("user/delete/{$val['id']}")?>'>Delete</a><br />
<?php endforeach;?>