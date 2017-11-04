<?php
	session_start();

	// Check if user is logged in
	include('includes/requireLogin');

	// Includes password reset module
	include('includes/requireLogin.php');
?>
<!-- Webpage for resetting password -->
<!DOCTYPE html>
<html>
	<head>
		<title>Reset Password | Pi In The Sky</title>
		<link rel="stylesheet" type="text/css" href="/css/style.css">
	</head>

	<body>
		<div class="header">
			<h1>Pi In the Sky</h1>
		</div>
		<div class="extra-space"></div>

		<div class="login-form">
			<h2>Reset Password</h2>

			<?php include('includes/errors.php') ?>

			<form class="login" action="includes/reset_password.php" method="post">
				<div class="input-group">
					<label>Old Password</label>&nbsp;
					<input type="password" name="password_old" value="">
				</div>
				<div class="input-group">
					<label>New Password</label>&nbsp;
					<input type="password" name="password_new1" value="">
				</div>
				<div class="input-group">
					<label>Repeat New Password</label>&nbsp;
					<input type="password" name="password_new2" value="">
				</div>
				<div class="input-group">
					<button type="submit" name="reset-password" class="btn">Reset Password</button>
				</div>
			</form>

		</div>

	</body>

</html>
