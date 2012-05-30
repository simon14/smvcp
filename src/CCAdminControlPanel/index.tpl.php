<div class='content-wrapper'>
<h1> Admin control panel </h1>
<p> Here you can manage some of website.</p>
<table>
<?php foreach($users as $val):?>
<tr>
	<td><?=$val['akronym']?></td>
	<td><?=$val['name']?></td>
	<td><?php foreach($val['groups'] as $grp) { echo $grp." "; }?></td>
	<td><a href='<?=create_url("user/delete/{$val['id']}")?>'>Delete</a> | Make: <a href='<?=create_url("user/makeadmin/{$val['id']}")?>'>admin</a> <a href='<?=create_url("user/makewriter/{$val['id']}")?>'>writer</a></td>
</tr>
<?php endforeach;?>
</table>
</div>