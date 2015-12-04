<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
	//header("location: http://localhost/5448-CI/index.php/login_controller/user_login_process");
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
			<?php $att=array('class'=>'dark-matter');?>
			<?php
			echo "<div class='error_msg'>";
			echo validation_errors();
			echo "</div>";
			echo "<div class='error_msg'>";
			if (isset($message_display)) {
				echo $message_display;
			}
			echo "</div>";
			echo"<br/>";

			echo form_open('login_controller/new_user_registration', $att);

			echo form_label('Your name: ');
			echo"<br/>";
			echo form_input('name');
			echo"<br/>";
			echo"<br/>";
			echo form_label('Create Username: ');
			echo"<br/>";
			echo form_input('username');
			echo"<br/>";
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
			<a href="index">Already have an account? Login</a>
		</div>
	</div>
</body>
</html>