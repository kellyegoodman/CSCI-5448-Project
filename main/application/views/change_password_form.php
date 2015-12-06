<div id="container">
	<h2>Change your password</h2>

	<div id="body">
		<?php
		echo validation_errors();
			echo form_open('/Register_controller/change_password');
			echo '<label for="password">Current Password:</label><br/>' . form_password('password','') . '<br/><br/>';
			echo '<label for="password_new">New Password:</label><br/>' . form_password('password_new','') . '<br/><br/>';
			echo '<label for="password_new_confirm">Confirm New Password:</label><br/>' . form_password('password_new_confirm','') . '<br/><br/>';
				

			echo form_submit('register_submit', 'Login');
			echo form_close();
			
		?>
	</div>

</div>