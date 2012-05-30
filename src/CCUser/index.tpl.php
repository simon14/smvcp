<div class='content-wrapper'>
<h1>User.</h1>
<div class='content'>
<p>
Login is possible with following testusers:
</p>
<ul>
  <li>root, root
  <li>doe, doe
</ul>
<ul>
	<li><a href='<?=create_url('user/login')?>'>Login right here.</a>
	<li><a href='<?=create_url('user/Create')?>'>Or create a new user!</a>
</ul>
<p>This is what is known on the current user.</p>
<?php if($is_authenticated): ?>
  <p>User is authenticated.</p>
  <pre><?=print_r($user, true)?></pre>
<?php else: ?>
  <p>User is anonymous and not authenticated.</p>
<?php endif; ?>
</div>
</div>