<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<?php $image_url = $this->Url->build('/', ['escape' => false,'fullBase' => true,]);?>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Skydash Admin</title>
		<?php
			echo $this->Html->css([
				'setting',
			]);
			echo $this->fetch('css');
		?>
		<link rel="icon" type="image/png" href="<?= $image_url.'images/favicon.png'?>">
	</head>
	<body>
	<div class="card">
		<form action="auth" method="post">
			<h2 class="title"> Log in</h2>
			<p class="subtitle">Don't have an account? <a href="#"> sign Up</a></p>

			<p class="or"><span>or</span></p>

			<div class="email-login">
				<label for="email"> <b>Email</b></label>
				<input type="text" placeholder="Enter Email" name="email" required>
				<label for="psw"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="password" required>
			</div>
			<?php
			echo $this->Form->button('Log In', [
				'type' => 'submit',
				'class' => 'cta-btn',
			]); ?>
			<?= $this->Flash->render() ?>
			<a class="forget-pass" href="#">Forgot password?</a>
		</form>
	</div>
	</body>
</html>