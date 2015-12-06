
<div id="container">
	<h2>Your settings:</h2>  
  	
	<div id="body">
		<?php
		
		// REPLACE WITH A TABLE (NEED TO REDO CSS)
		echo "Username: " . $username . '<br/>';
		echo "Name: " . $name . '<br/>';
		echo "Email: " . $email . '<br/>';
		?>
		
		<div id="lower_options">
			<ul style="float:left;list-style-type:none;">
				<?php
				echo '<li>' . anchor('/Register_controller/edit_profile_show','Edit Profile') .'</li>';
				echo '<li>' . anchor('/Register_controller/change_password','Change Password') .'</li>';
				?>
			</ul>
		</div>
		
	</div>
</div>