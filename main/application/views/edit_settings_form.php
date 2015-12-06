<?php
if (empty($this->session->userdata['user_id'])) {
	redirect(base_url().'index.php/Welcome');
}
?>
<div id="container">
	<h2>Your settings:</h2>  

	<div id="body">
		<?php
			echo form_open('/Register_controller/edit_user');
			echo "<div class='error_msg'>";
			if (isset($error_message)) {
				echo $error_message;
			}
			echo validation_errors();
			echo "</div>";
			echo "Username: " . $username . '<br/><br/><br/>';
			echo '<label for="name">First and Last Name:</label><br/>' . form_input('name',set_value('name')) . '<br/><br/>';
			echo '<label for="email">E-mail Address:</label><br/>' . form_input('email',set_value('email')) . '<br/><br/>';
			
			echo form_submit('edit_submit', 'Set Changes');
			echo form_button('test','Cancel');
			echo form_close();
			
		?>
	</div>

</div>