<?php
if (isset($this->session->userdata['user_id'])) {
	redirect(base_url().'index.php/Welcome');
}

if (empty($msg)) {
	$msg = 'Enter your log-in information';
}
?>
<div id="container">

	<?php echo '<h2>' . $msg . '</h2>'?>

	<div id="body">
		<?php
			echo form_open('/Login_controller');
			echo "<div class='error_msg'>";
			if (isset($error_message)) {
				echo $error_message;
			}
			echo validation_errors();
			echo "</div>";
			echo '<label for="username">Username:</label><br/>' . form_input('username',set_value('username')) . '<br/><br/>';
			echo '<label for="password">Password:</label><br/>' . form_password('password','') . '<br/><br/>';

			echo form_submit('login_submit', 'Login');
			echo form_button('test','Cancel');
			echo form_close();
			
		?>
	</div>

</div>