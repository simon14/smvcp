<h1> User profile. </h1>

<div class='content'>
<?php if($is_authenticated): ?>
  <?=$profile_form?>
<?php else: ?>
  <p>User is anonymous and not authenticated.</p>
<?php endif; ?>
</div>

