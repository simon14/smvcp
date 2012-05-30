<h1>User.</h1>
<div class='content'>
<p>
Login is possible with following testusers:
</p>
<ul>
  <li>root, root
  <li>doe, doe
</ul>
<a href='<?=create_url('user/login')?>'>Login right here</a>
<a href='<?=create_url('user/Create')?>'>or create a new user!</a>




<-- Change showDebug to true if you want the more specified user information! -->
<p>This is what is known on the current user.</p>
<?php if($is_authenticated): ?>
  <p>User is authenticated.</p>
  <pre><?=print_r($user, true)?></pre>
<?php else: ?>
  <p>User is anonymous and not authenticated.</p>
<?php endif; ?>
</div>