
<div id="container">
	<br/>
	<h2>Your settings:</h2>  
  	
	<div id="body">
		<?php
		echo '<br/><br/>';
		
		// REPLACE WITH A TABLE (NEED TO REDO CSS)
		echo "Username: " . $username . '<br/>';
		echo "Name: " . $name . '<br/>';
		echo "Email: " . $email . '<br/>';
		?>
		
		<div id="lower_options">
			<ul style="float:left;list-style-type:none;">
				<?php
				echo '<li>' . anchor('/User/edit_profile','Edit Profile') .'</li>';
				echo '<li>' . anchor('/User_authentification/change_password','Change Password') .'</li>';
				?>
			</ul>
		</div>
		
	</div>
</div>