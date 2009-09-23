<?php

// file: /app/views/users/login.ctp

?>

<div class="login form">

<?php if(isset($error)): ?>
<p class="flash_bad">
	<?php e($error); ?>
</p>
<?php endif; ?>

<?php echo $form->create('User', array('url'=>'login'));?>
	<fieldset>
 		<legend>Login</legend>
		<div class="input required">
			<label>Username: *</label>
			<?php echo $form->text('User.username'); ?>
		</div>
		<div class="input required">
			<label>Password: *</label>
			<?php echo $form->password('User.password'); ?>
		</div>
	</fieldset>
<?php echo $form->end('Login');?>

</div>