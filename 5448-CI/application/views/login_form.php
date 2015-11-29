<html>
<?php
if (isset($this->session->userdata['logged_in'])) {

	header("location: http://localhost/login/index.php/user_authentication/user_login_process");
}
?>
<head>
	<title>Login Form</title>
</head>
<body>
	<?php
	if (isset($logout_message)) {
		echo "<div class='message'>";
		echo $logout_message;
		echo "</div>";
	}
	?>
	<?php
	if (isset($message_display)) {
		echo "<div class='message'>";
		echo $message_display;
		echo "</div>";
	}
	?>
	<div id="main">
		<div id="login">
			<h2>Login Form</h2>
			<hr/>
			<?php echo form_open('user_authentication/user_login_process'); ?>
			<?php
			echo "<div class='error_msg'>";
			if (isset($error_message)) {
				echo $error_message;
			}
			echo validation_errors();
			echo "</div>";
			?>
			<label>Username:</label>
			<input type="text" name="username" id="name" placeholder="username"/><br /><br />
			<label>Password:</label>
			<input type="password" name="password" id="password" placeholder="**********"/><br/><br />
			<input type="submit" value=" Login " name="submit"/><br />
			<a href="<?php echo base_url() ?>index.php/user_authentication/user_registration_show">Register New Account</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>