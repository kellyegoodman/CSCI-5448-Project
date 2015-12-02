<div id="container">
	<h2>Create an Account</h2>

	<div id="body">
		<?php
		echo validation_errors();
			echo form_open('/User/create_user');
			echo '<label for="username">Username:</label><br/>' . form_input('username',set_value('username')) . '<br/><br/>';
			echo '<label for="password">Password:</label><br/>' . form_password('password','') . '<br/><br/>';
			echo '<label for="password_confirm">Confirm Password:</label><br/>' . form_password('password_confirm','') . '<br/><br/>';
			echo '<label for="email">E-mail Address:</label><br/>' . form_input('email',set_value('email')) . '<br/><br/>';
			echo '<label for="name">First and Last Name:</label><br/>' . form_input('name',set_value('name')) . '<br/><br/>';
			
			echo form_submit('register_submit', 'Register');
			echo form_close();
			
		?>
	</div>

</div>