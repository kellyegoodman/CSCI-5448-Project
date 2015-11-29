<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
	header("location: http://localhost/login/index.php/user_authentication/user_login_process");
}
?>
<head>
	<title>Registration Form</title>
</head>
<body>
	<div id="main">
		<div id="login">
			<h2>Registration Form</h2>
			<hr/>
			<?php
			echo "<div class='error_msg'>";
			echo validation_errors();
			echo "</div>";
			echo form_open('user_authentication/new_user_registration');

			echo form_label('Create Username: ');
			echo"<br/>";
			echo form_input('username');
			echo "<div class='error_msg'>";
			if (isset($message_display)) {
				echo $message_display;
			}
			echo "</div>";
			echo"<br/>";
			echo form_label('Email: ');
			echo"<br/>";
			$data = array(
				'type' => 'email',
				'name' => 'email_value'
				);
			echo form_input($data);
			echo"<br/>";
			echo"<br/>";
			echo form_label('Password: ');
			echo"<br/>";
			echo form_password('password');
			echo"<br/>";
			echo"<br/>";
			echo form_submit('submit', 'Register');
			echo form_close();
			?>
			<a href="<?php echo base_url() ?> ">Already have an account? Login</a>
		</div>
	</div>
</body>
</html>