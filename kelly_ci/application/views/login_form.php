<div id="container">
	<h2>Enter your log-in information</h2>

	<div id="body">
		<?php
		echo validation_errors();
			echo form_open('/User_authentication');
			echo '<label for="username">Username:</label><br/>' . form_input('username',set_value('username')) . '<br/><br/>';
			echo '<label for="password">Password:</label><br/>' . form_password('password','') . '<br/><br/>';

			echo form_submit('register_submit', 'Login');
			echo form_close();
			
		?>
	</div>

</div>